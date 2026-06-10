<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\WimisController;
use App\Http\Controllers\DataKMController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () { return view('welcome'); });

// Route yang butuh Login (Middleware Auth)
Route::middleware(['auth', 'verified'])->group(function () {


    // Universal
    Route::get('/placeholder/{title}', function ($title) {

        return view('placeholder', [
            'title' => ucwords(str_replace('-', ' ', $title))
        ]);

    })->name('placeholder');
    
    // Dashboard & Smart Recruitment
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::post('/cv/process',[RecruitmentController::class, 'processCV'])->name('cv.process');
    Route::get('/vacancy', function () { return view('layouts.vacancy'); })->name('vacancy');
    

    // Formulir
    Route::get('/formulir/usulan-b1', [WimisController::class, 'formB1'])->name('formulir.b1');
    Route::post('/formulir/usulan-b1', [WimisController::class, 'storeUsulanB1'])->name('usulan.store');

    // Form A & B
    Route::get('/formulir/timesheet-b3', function () { return view('formulir.timesheet-b3'); })->name('formulir.timesheet');
    Route::post('/timesheet/store',[WimisController::class, 'storeTimesheet'])->name('timesheet.store');
    
    // My Data
    Route::get('/mydata/timesheet', [WimisController::class, 'myTimesheet'])
        ->name('mydata.timesheet');
    Route::get('/mydata/kegiatan/usulan-b1', [WimisController::class, 'myUsulanB1'])->name('mydata.usulan.b1');

    // My Data - Usulan
    Route::get('/mydata/usulan-b1/{id}/edit', [WimisController::class, 'editUsulan'])->name('mydata.usulan.edit');
    Route::put('/mydata/usulan-b1/{id}', [WimisController::class, 'updateUsulan'])->name('mydata.usulan.update');
    Route::delete('/mydata/usulan-b1/{id}', [WimisController::class, 'deleteUsulan'])->name('mydata.usulan.delete');

    // My Data - Timesheet
    Route::get('/mydata/timesheet/{id}/edit', [WimisController::class, 'editTimesheet'])->name('mydata.timesheet.edit');
    Route::put('/mydata/timesheet/{id}', [WimisController::class, 'updateTimesheet'])->name('mydata.timesheet.update');
    Route::delete('/mydata/timesheet/{id}', [WimisController::class, 'deleteTimesheet'])->name('mydata.timesheet.delete');

    // My Data B3
    Route::get('/mydata/timesheet-b3', [WimisController::class, 'myTimesheetB3'])
        ->name('mydata.timesheet.b3');
    Route::get('/mydata/timesheet-b3/{month}',[WimisController::class, 'detailTimesheet'])->name('mydata.timesheet.detail');
    
    // Approval Usulan B1
    Route::get('/approval/kegiatan/usulan-b1', [WimisController::class, 'approvalIndex'])->name('approval.usulan');
    Route::patch('/approval/usulan/{id}', [WimisController::class, 'updateStatus'])->name('approval.update');


    // Approval Timesheet B3
    Route::get('/approval/kegiatan/timesheet-b3', [WimisController::class, 'approvalTimesheetIndex'])->name('approval.timesheet');
    Route::patch('/approval/timesheet/{id}', [WimisController::class, 'updateTimesheetStatus'])->name('approval.timesheet.update');


    // Approval Laporan B2
    Route::get('/approval/kegiatan/laporan-b2', function () {return view('approval.laporan');})->name('approval.laporan');

    // Search - Global
    Route::get('/datakm', [DataKMController::class, 'index'])->name('datakm.index');
    Route::get('/datakm/create', [DataKMController::class, 'create'])->name('datakm.create');
    Route::post('/datakm', [DataKMController::class, 'store'])->name('datakm.store');
    Route::get('/datakm/search',[DataKMController::class, 'globalSearch'])->name('datakm.search');
    Route::get('/datakm/live-search', [DataKMController::class, 'liveSearch'])->name('datakm.live.search');
    Route::get('/datakm/{id}',[DataKMController::class, 'show'])->name('datakm.show');

    // Notifications
    Route::get('/notifications/read/{id}', function ($id) {

        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if($notification){
            $notification->markAsRead();

            return redirect($notification->data['url']);
        }

        return back();

    })->name('notifications.read');
});

require __DIR__.'/auth.php';