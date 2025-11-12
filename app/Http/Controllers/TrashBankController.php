<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrashBank;
use App\Models\User;

class TrashBankController extends Controller
{
    // หน้า user เดิม
    public function index(Request $request)
    {
        $user = auth()->user();
        $trashBanks = TrashBank::where('depositor', $user->name)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.trash-bank', compact('trashBanks', 'user'));
    }

    // หน้า admin
    public function adminIndex(Request $request)
    {
        $perPage = $request->input('data_table_length', 10);
        $search = $request->input('search');

        $trashBanks = TrashBank::with('creator') // กรณีต้อง join user
            ->when($search, function ($q) use ($search) {
                $q->where('type', 'LIKE', "%{$search}%")
                  ->orWhere('subtype', 'LIKE', "%{$search}%")
                  ->orWhereHas('creator', function($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%");
                  });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends(['search' => $search, 'data_table_length' => $perPage]);

        $users = User::all(); // สำหรับ dropdown ผู้ใช้

        return view('admin_trash.new-bank', compact('trashBanks', 'users', 'perPage', 'search'));
    }

    // บันทึกข้อมูลใหม่
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'subtype' => 'nullable|string',
            'weight' => 'required|numeric',
            'amount' => 'required|numeric',
            'depositor' => 'required|string',
            'creator_id' => 'required|exists:users,id',
        ]);

        TrashBank::create($request->all());

        return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

}
