<?php

use App\Http\Controllers\PersonController;
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


Route::prefix('person')->middleware('auth')->group(function(){
    Route::get('/import',[PersonController::class, 'importForm'])->name('person.import.form');
    Route::post('/import',[PersonController::class, 'import'])->name('person.import');
    Route::get('/{id}/report',[PersonController::class, 'singleReport'])->name('person.report');

    Route::get('/list',[PersonController::class, 'index'])->name('person.index');
    Route::get('/create',[PersonController::class, 'new'])->name('person.new');
    Route::post('/store',[PersonController::class, 'store'])->name('person.store');
    Route::get('/{id}/edit',[PersonController::class, 'edit'])->name('person.edit');
    Route::post('/find',[PersonController::class, 'ahmadiSrchById'])->name('srch_user_by_id');
    Route::put('/{id}',[PersonController::class,'update'])->name('person.update');

    Route::get('truncate', [PersonController::class, 'truncate']);
});

