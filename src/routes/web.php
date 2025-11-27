<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [ContactController::class, 'index'])->name('contact.index');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/contacts', [ContactController::class, 'store']);
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AuthController::class, 'index'])->name('admin.index');
    Route::get('/admin/search', [AuthController::class, 'search'])->name('admin.search');
    Route::get('/admin/reset', [AuthController::class, 'reset'])->name('admin.reset');
    Route::delete('/admin/delete/{id}', [AuthController::class, 'delete'])->name('admin.delete');
    Route::get('/admin/export', [AuthController::class, 'export'])->name('admin.export');
});
