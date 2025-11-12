<?php

namespace App\Http\Controllers;

use App\Models\TrashRequest;
use App\Models\TrashRequestHistory;
use App\Models\TrashRequestFile;
use App\Models\TrashLocation;
use App\Models\WaterLocation;
use App\Models\WaterHistory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bill;
use Carbon\Carbon; 

class WaterController extends Controller
{
    /**
     * แสดงหน้าตรวจสอบการชำระค่าน้ำของผู้ใช้
     */
    public function checkPayment()
    {
        $user = Auth::user();

        // ดึงบิลของผู้ใช้ที่เกี่ยวข้องกับ water_locations เท่านั้น
        $bills = Bill::where('user_id', $user->id)
            ->whereNotNull('water_location_id')
            ->with('waterLocation')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.check-water-payment-page', compact('user', 'bills'));
    }

    /**
     * ดาวน์โหลดใบแจ้งหนี้ (PDF)
     */
    public function downloadBill($id)
    {
        $bill = auth()->user()->bills()->findOrFail($id);

        $filePath = storage_path('app/bills/' . $bill->id . '.pdf');

        if (!file_exists($filePath)) {
            abort(404, 'ไม่พบไฟล์ใบแจ้งหนี้');
        }

        return response()->download($filePath);
    }

    public function showData(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('data_table_length', 10);

        $trashRequests = TrashRequest::with(['receiver:id,name', 'files'])
            ->where('type', 'water-request')
            ->where('status', 'รอรับเรื่อง')

            ->when($search, function ($query, $search) {
                $query->where('fullname', 'LIKE', "%{$search}%")
                    ->orWhereHas('receiver', function($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends(['search' => $search, 'data_table_length' => $perPage]);

        $histories = TrashRequestHistory::with('responder:id,name')->get();

        $modified = $trashRequests->getCollection()->map(function ($request) use ($histories) {
            $requestHistories = $histories->where('trash_request_id', $request->id)
                ->map(function ($item) {
                    return [
                        'responder_name' => $item->responder->name ?? '-',
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'message' => $item->message,
                    ];
                })->values();

            $request->fullname = $request->fullname ?? $request->name ?? '-';
            $request->receiver_name = $request->receiver->name ?? '-';
            $request->histories = $requestHistories;
            $request->picture_path = $request->files->pluck('file_path')->toArray();

            // parse water data จาก addon
            $request->water_data = json_decode($request->addon, true) ?? [];

            return $request;
        });


        $trashRequests->setCollection($modified);

        return view('admin_water.showdata', compact('trashRequests', 'search', 'perPage'));
    }

    // App\Http\Controllers\WaterController.php
    public function waterUsageStatistics()
    {
        $user = auth()->user();

        // ✅ ดึงข้อมูล WaterLocation ทั้งหมดของ user ที่ล็อกอินอยู่
        $waterLocations = WaterLocation::where('owner_id', $user->id)->get();

        // ✅ ดึง bills เฉพาะของ user ที่มี type = water-request
        // และ water_location_id ต้องอยู่ในรายการของ waterLocations
        $bills = Bill::where('user_id', $user->id)
            ->where('type', 'water-request')
            ->whereIn('water_location_id', $waterLocations->pluck('id'))
            ->get();

        return view('user.water-usage-statistics', compact('user', 'bills', 'waterLocations'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search'); // ค้นหาจากชื่อหรือที่อยู่
        $perPage = $request->input('data_table_length', 10);

        $locationsQuery = WaterLocation::when($search, function($query, $search){
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('address', 'LIKE', "%{$search}%");
        })
        ->with('bills')
        ->orderByDesc('id');

        if ($perPage == -1) {
            $locations = $locationsQuery->get(); // แสดงทั้งหมด
        } else {
            $locations = $locationsQuery->paginate($perPage)
                ->appends(['search' => $search, 'data_table_length' => $perPage]);
        }

        return view('admin_water.manage_water.manage-water', compact('locations', 'search', 'perPage'));
    }

    public function showManageWaterDetail(Request $request, int $id)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('data_table_length', 10);

        // ดึง Location พร้อม history
        $location = WaterLocation::with('waterHistories')->findOrFail($id);

        // เตรียม query ของ bills
        $billsQuery = Bill::where('water_location_id', $id)
                        ->orderBy('created_at', 'desc'); // เรียงจากใหม่ไปเก่า

        if ($search) {
            $billsQuery->where('water_user_no', 'like', "%$search%");
        }

        // Pagination
        $bills = ($perPage == -1) ? $billsQuery->get() : $billsQuery->paginate($perPage)->appends([
            'search' => $search,
            'data_table_length' => $perPage,
        ]);

        return view('admin_water.manage_water.manage-water-detail', compact('location', 'bills', 'search', 'perPage'));
    }


    public function getBill(Request $request)
    {
        try {
            $bill = Bill::with(['user', 'waterLocation'])->findOrFail($request->bill_id);

            return response()->json([
                'success' => true,
                'bill' => [
                    'id' => $bill->id,
                    'amount' => $bill->amount,
                    'status' => $bill->status,
                    'user' => $bill->user->name ?? '-',
                    'location' => $bill->waterLocation->address ?? '-',
                    'created_at' => $bill->created_at->format('d/m/Y'),
                    'paid_date' =>$bill->paid_date ,
                    'slip_url' => $bill->slip_path ? asset('storage/' . $bill->slip_path) : null, // ✅ ใช้ asset()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function approveBill(Request $request)
    {
        $request->validate([
            'bill_id' => 'required|exists:bills,id',
            'receive_by' => 'nullable|string'
        ]);

        $bill = Bill::findOrFail($request->bill_id);
        $bill->status = 'ชำระแล้ว';
        $bill->receive_by = $request->receive_by;
        $bill->save();

        if (!$bill->water_location_id) {
            return response()->json(['error' => 'bill ไม่มี water_location_id'], 500);
        }

        $trashRequest = TrashRequest::where('water_location_id', $bill->water_location_id)->first();

        if ($trashRequest) {
            $addon = json_decode($trashRequest->addon, true) ?? [];
            $addon['receive_by'] = $request->receive_by ?? 'ไม่ระบุ';

            $trashRequest->addon = json_encode($addon, JSON_UNESCAPED_UNICODE);
            $trashRequest->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'บิลถูกอนุมัติและอัปเดตข้อมูล TrashRequest เรียบร้อยแล้ว',
        ]);
    }



    public function storeNewBill(Request $request)
    {
        $request->validate([
            'water_location_id' => 'required|exists:water_locations,id',
            'new_miter' => 'required|numeric|min:0',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        $user = auth()->user(); // ผู้สร้างบิล
        $location = WaterLocation::findOrFail($request->water_location_id);

        // คำนวณปริมาณการใช้น้ำ
        $oldMiter = $location->new_miter ?? 0; // ค่าเก่าล่าสุด
        $newMiter = $request->new_miter;
        $usage = $newMiter - $oldMiter;
        if ($usage < 0) $usage = 0;

        $amount = $usage * $request->price_per_unit;

        // สร้างบิลใหม่
        $bill = Bill::create([
            'user_id' => $location->owner_id,
            'water_location_id' => $location->id,
            'amount' => $amount,
            'status' => 'ยังไม่ชำระ',
            'type' => 'water-request',
            'due_date' => Carbon::now()->addDays(15), // กำหนดวันครบกำหนด 15 วันหลังสร้าง
        ]);

        // อัพเดตค่า new_miter ล่าสุดใน WaterLocation
        $location->old_miter = $location->new_miter;
        $location->new_miter = $newMiter;
        $location->save();

        // สร้างประวัติการอัปเดตมิเตอร์
        WaterHistory::create([
            'water_location_id' => $location->id,
            'old_miter' => $oldMiter,
            'update_miter' => $newMiter,
            'updateAt' => Carbon::now(),
            'updateBy' => $user->id,
        ]);

        return redirect()->back()->with('success', 'บิลน้ำถูกสร้างเรียบร้อยแล้ว');
    }

    public function showWaterStatistics($id)
    {
        $user = auth()->user();

        // ตรวจสอบว่า location นี้เป็นของ user ที่ล็อกอินอยู่
        $location = WaterLocation::where('id', $id)
            ->where('owner_id', $user->id)
            ->with(['waterHistories' => function($q) {
                $q->orderBy('updateAt', 'desc');
            }])
            ->firstOrFail();

        // ดึงบิลของ location นี้
        $bills = Bill::where('water_location_id', $location->id)
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // เตรียมข้อมูลส่งไป JS (จัดรูปแบบให้พร้อมใช้งาน)
        $billData = $bills->map(function($bill) {
            return [
                'month' => Carbon::parse($bill->created_at)->translatedFormat('M y'),
                'amount' => (float)$bill->amount,
                'status' => $bill->status,
            ];
        });

        $usageData = $location->waterHistories->map(function($h) {
            return [
                'month' => Carbon::parse($h->updateAt)->translatedFormat('M y'),
                'usage' => ($h->update_miter ?? 0) - ($h->old_miter ?? 0),
            ];
        });

        return view('user.water-statistics-detail', compact('user', 'location', 'billData', 'usageData'));
    }

    public function showRegisterWater()
    {
        $user = auth()->user();

        // หากต้องการดึง WaterLocation ของผู้ใช้มาแสดงด้วย
        $waterLocations = WaterLocation::where('owner_id', $user->id)->get();

        return view('user.new-water-no', compact('user', 'waterLocations'));
    }

    public function store(Request $request)
    {
        // เตรียมข้อมูล TrashRequest จาก input โดยตรง
        $requestData = [
            'prefix' => $request->field_1,
            'fullname' => auth()->user()->name,
            'age' => $request->field_5,
            'nationality' => $request->field_6,
            'tel' => $request->field_3,
            'house_no' => $request->field_7,
            'village_no' => $request->field_8,
            'subdistrict' => $request->field_9,
            'district' => $request->field_10,
            'province' => $request->field_11,
            'road' => $request->field_15,
            'alley' => $request->field_14,
            'type' => 'water-request',
            'status' => 'รอรับเรื่อง',
            'creator_id' => auth()->id(),
            'id_card' => $request->field_16,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ];

        // เก็บ addon เป็น JSON
        if ($request->has('addon')) {
            $requestData['addon'] = json_encode($request->addon, JSON_UNESCAPED_UNICODE);
        }

        // สร้าง TrashRequest
        $trashRequest = TrashRequest::create($requestData);

        // เก็บไฟล์แยกใน trash_request_files
        $fileInputs = [
            'files1','files2','files3','files4','files4_1','files4_2','files4_3','files4_4','files4_5','files5','files6','files7','files8'
        ];

        foreach ($fileInputs as $field) {
            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $file) {
                    if ($file->isValid()) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('trash_pictures', $filename, 'public');

                        TrashRequestFile::create([
                            'trash_request_id' => $trashRequest->id,
                            'field_name' => $field,
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $path,
                        ]);
                    }
                }
            }
        }

        // ตรวจสอบว่าเป็น Ajax request หรือไม่
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'ลงทะเบียนเสร็จสิ้น'
            ]);
        }

        return redirect()->route('user.water_payment.register')
                        ->with('success', 'ลงทะเบียนเสร็จสิ้น');
    }

}

