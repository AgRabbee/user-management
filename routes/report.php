<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

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


Route::prefix('report')->middleware('auth')->group(function(){
    Route::get('/list',[ReportController::class, 'list'])->name('report.list');
    Route::get('/generate',[ReportController::class, 'index'])->name('report.index');
    Route::post('/generate',[ReportController::class, 'generate'])->name('report.generate');

    Route::post('/details',[ReportController::class, 'details'])->name('report.details');
    Route::post('/update',[ReportController::class, 'update'])->name('report.update');


    Route::post('/download', [ReportController::class, 'exportReport'])->name('report.download');
    Route::get('/download', [ReportController::class,'downloadReport'])->name('download.report');

});

