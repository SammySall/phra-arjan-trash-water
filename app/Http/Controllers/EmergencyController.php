<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emergency;
use Illuminate\Support\Facades\Storage;

class EmergencyController extends Controller
{
    public function showForm($type = '')
    {
        return view('user.emergency', compact('type'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'salutation' => 'required|string',
            'name' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            'description' => 'nullable|string',
            'picture' => 'nullable|image|max:2048',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('emergency_pictures', 'public');
        }

        Emergency::create([
            'type' => $request->salutation,
            'name' => $request->name,
            'tel' => $request->tel,
            'description' => $request->description,
            'picture' => $picturePath,
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ส่งไปยังหน่วยงานที่เกี่ยวข้องเรียบร้อยแล้ว'
        ]);
    }

    public function emergencyList($type = null)
    {
        $emergencyNames = [
            'water-leak' => 'น้ำรั่ว',
            'fire' => 'ไฟไหม้',
            'tree-fall' => 'ต้นไม้ล้ม',
            'broken-road' => 'ถนนเสีย',
            'elec-broken' => 'ไฟเสีย',
        ];

        $title = 'แจ้งเหตุ'; // ✅ เปลี่ยนชื่อหัวข้อเป็น "แจ้งเหตุ"

        // ถ้ามีประเภท ให้กรองเฉพาะ type นั้น
        $query = Emergency::query();
        if ($type) {
            $query->where('type', $type);
        }

        $emergencies = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin_water.emergency.emergency-list', compact('title', 'type', 'emergencies', 'emergencyNames'));
    }


    public function showDetail($id)
    {
        $location = Emergency::findOrFail($id); // ดึงข้อมูลตาม id
        return view('admin_water.emergency.emergency-detail', compact('location'));
    }

}
