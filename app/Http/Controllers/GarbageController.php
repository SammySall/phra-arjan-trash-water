<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bill;

class GarbageController extends Controller
{
    public function checkPayment()
    {
        $user = Auth::user();

    $bills = Bill::where('user_id', $user->id)
                ->whereNotNull('trash_location_id')
                ->with('trashLocation')
                ->orderBy('due_date', 'desc')
                ->get();

    return view('user.check-payment-page', compact('user', 'bills'));
    }

    public function downloadBill($id)
    {
        $bill = auth()->user()->bills()->findOrFail($id);

        $filePath = storage_path('app/bills/'.$bill->id.'.pdf'); // สมมติเก็บ pdf ไว้
        return response()->download($filePath);
    }
}
