<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\TrashRequestController;
use App\Http\Controllers\TrashLocationController;
use App\Http\Controllers\GarbageController;
use App\Http\Controllers\WaterController;
use App\Http\Controllers\TrashBankController;
use App\Http\Controllers\EmergencyController;
use Barryvdh\DomPDF\Facade\Pdf;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');


Route::get('/user/request/general', function () {
    return view('user.form_request.general');
});

Route::get('/user/request/trash_request', function () {
    return view('user.form_request.trash-request');
});

Route::middleware('auth')->get('/user/request/history_request/{type}', [TrashRequestController::class, 'historyRequest'])
    ->name('user.history-request');
Route::middleware('auth')->get('/user/request/history_request/{type}/{id}', [TrashRequestController::class, 'showUserRequestDetail'])
    ->name('user.history-request.detail');

Route::get('/user/waste_payment', function () {
    return view('user.garbage');
});
Route::prefix('user/waste_payment')->middleware('auth')->group(function() {
    Route::get('/trash_bank', [TrashBankController::class, 'index'])->name('user.trash_bank');
});
Route::prefix('admin')->middleware('auth')->group(function() {
    Route::get('/trash_bank', [TrashBankController::class, 'adminIndex'])->name('admin.trash_bank');
    Route::post('/trash_bank/store', [TrashBankController::class, 'store'])->name('admin.trash_bank.store');
});


Route::get('/user/waterworks', function () {
    return view('user.waterworks');
});

Route::get('/user/waterworks/emergency/{type}', function ($type) {
    return view('user.emergency-page', ['type' => $type]);
});

Route::get('/user/request-emergency', function () {
    return view('user.request-emergency.emergency-menu');
});
Route::post('/user/emergency/submit', [EmergencyController::class, 'store'])->name('emergency.submit');
Route::get('/admin/waterworks/emergency', [EmergencyController::class, 'emergencyList'])
    ->name('admin.emergency-list');
Route::get('/admin/waterworks/emergency/{id}/detail', [EmergencyController::class, 'showDetail'])
    ->name('admin.emergency.detail');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/water_payment/check-payment', [WaterController::class, 'checkPayment'])->name('user.water_payment');
    Route::get('/user/water_payment/{id}/download', [WaterController::class, 'downloadBill'])->name('user.water_bill.download');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/user/waste_payment/check-payment', [GarbageController::class, 'checkPayment'])->name('user.check-payment');
    Route::get('/bills/{id}/download', [GarbageController::class, 'downloadBill'])->name('bills.download');
});

Route::get('/user/waste_payment/status-trash', function () {
    return view('user.status-trash-page');
});

Route::get('/admin/waste_payment', [TrashLocationController::class, 'dashboard'])
    ->name('admin_trash.dashboard');

Route::get('/bill/{bill}/pdf', [TrashRequestController::class, 'showPdfReceiptBill'])
    ->name('admin.bill.pdf');
Route::get('/water_bill/{bill}/pdf', [TrashRequestController::class, 'showPdfWaterBill'])
    ->name('admin.water_bill.pdf');
Route::get('/license/{type}/pdf/{id}', [TrashRequestController::class, 'showLicensePdf'])
    ->name('admin_trash.license_pdf');

Route::get('/admin/showdata', [TrashRequestController::class, 'showData'])->name('admin.showdata');
Route::get('/admin/waterworks/showdata', [WaterController::class, 'showData'])->name('admin.showdata');
Route::middleware(['auth'])->group(function () {
    Route::get('/user/water_payment/statistics', [WaterController::class, 'waterUsageStatistics'])
        ->name('user.water_payment.statistics');
    Route::get('/user/water_payment/statistics/{id}', [WaterController::class, 'showWaterStatistics'])
        ->name('user.water_payment.statistics.detail');

    Route::get('/admin/waterworks/manage-water', [WaterController::class, 'index']);
    Route::get('/admin/waterworks/manage-water/detail/{id}', [WaterController::class, 'showManageWaterDetail']);
    Route::post('/manage/store-new-bill', [WaterController::class, 'storeNewBill'])
        ->name('admin.water.storeNewBill');
});

Route::prefix('/user/water_payment')->middleware('auth')->group(function () {
    // แสดงหน้าลงทะเบียนลูกค้าน้ำ
    Route::get('register_water_no', [WaterController::class, 'showRegisterWater'])->name('user.water_payment.register');

    // บันทึกคำขอ
    Route::post('register_water_no', [WaterController::class, 'store'])->name('user.water_payment.register.store');
});


Route::post('/admin/reply/{id}', [TrashRequestController::class, 'reply'])->name('admin.trash.reply');
Route::middleware('auth')->post('/trash-request/store', [TrashRequestController::class, 'store'])->name('trash-request.store');
Route::post('/admin/trash/accept', [TrashRequestController::class, 'accept'])->name('admin_trash.accept');
Route::get('/admin/trash/pdf/{id}', [TrashRequestController::class, 'showPdfTrash'])->name('admin_trash.show_pdf');

Route::get('/admin/trash_can_installation', [TrashLocationController::class, 'index']);
Route::get('/admin/trash_can_installation/detail/{id}', [TrashLocationController::class, 'showCanInstallDetail']);
Route::post('/admin/trash_can_installation/{id}/confirm-payment', [TrashLocationController::class, 'confirmPayment']);

Route::get('/admin/trash_installer', [TrashLocationController::class, 'installerTrash']);
Route::get('/admin/trash_installer/detail/{id}', [TrashLocationController::class, 'showInstallerDetail']);

Route::get('/admin/verify_payment', [TrashLocationController::class, 'verifyPaymentsList'])
    ->name('admin.verify_payment');
Route::post('/admin/verify_payment/receive-bill', [TrashLocationController::class, 'receiveBill'])
    ->name('admin.verify_payment.receive-bill');
Route::get('/admin/water/verify_payment/get-bill', [WaterController::class, 'getBill'])
    ->name('admin.water.verify_payment.getBill');
Route::post('/admin/water/verify_payment/receive-bill', [WaterController::class, 'receiveBill'])
    ->name('admin.water.verify_payment.receiveBill');

Route::get('/admin/payment_history', [TrashLocationController::class, 'paymentHistoryList'])
    ->name('admin.payment_history');
Route::get('/admin/payment_history/detail/{id}', [TrashLocationController::class, 'paymentHistoryDetail'])
    ->name('admin.payment_history.detail');

Route::get('/admin/non_payment', [TrashLocationController::class, 'nonPaymentList'])->name('admin.non_payment');
Route::get('/admin/non_payment/detail/{location}', [TrashLocationController::class, 'nonPaymentDetail'])
    ->name('non_payment.detail');
Route::get('/admin/non_payment/{trashLocationId}/export', [TrashLocationController::class, 'exportNonPaymentPdf'])
    ->name('admin.non_payment.export');
Route::post('/admin/non-payment/upload-slip', [TrashLocationController::class, 'uploadSlip'])->name('admin.non_payment.upload_slip');

Route::prefix('admin/waterworks')->group(function () {
    // ✅ หน้าแสดงรายการใบเสร็จทั้งหมดที่รออนุมัติ
    Route::get('/approve-bill', [WaterController::class, 'showApproveList'])
        ->name('admin.water.approve_bill');

    // ✅ API อนุมัติบิล (ใช้กับปุ่มอนุมัติใน JS)
    Route::post('/approve-bill', [WaterController::class, 'approveBill'])
        ->name('admin.water.approve_bill.submit');

    // API ดึงข้อมูลบิลสำหรับ Modal
    Route::get('/get-bill', [WaterController::class, 'getBillForModal'])
        ->name('admin.water.verify_payment.getBill');
});

Route::prefix('admin/approve_bill')->group(function () {
    // ✅ หน้าแสดงรายการใบเสร็จทั้งหมดที่รออนุมัติ
    Route::get('/', [TrashLocationController::class, 'showApproveList'])
        ->name('admin.approve_bill');

    // ✅ API อนุมัติบิล (ใช้กับปุ่มอนุมัติใน JS)
    Route::post('/', [TrashLocationController::class, 'approveBill'])
        ->name('admin.approve_bill.submit');

    // API ดึงข้อมูลบิลสำหรับ Modal
    Route::get('/get-bill', [TrashLocationController::class, 'getBillForModal'])
        ->name('admin.verify_payment.getBill');
});

Route::get('/link-storage', function () {
    Artisan::call('storage:link');
    return 'Storage link created!';
});