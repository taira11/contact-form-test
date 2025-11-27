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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [ContactController::class, 'index']);
// Route::post('/confirm', [ContactController::class, 'confirm']);
// Route::post('/contacts', [ContactController::class, 'store']);
// Route::post('/thanks', [ContactController::class, 'thanks']);

// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout']);


// Route::get('/', function () {
//     return redirect('/');
// });

// お問い合わせフォーム（ゲストアクセス可能）
Route::get('/', [ContactController::class, 'index'])->name('contact.index');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/contacts', [ContactController::class, 'store']);




Route::middleware('auth')->group(function () {
    // 管理画面（検索機能含む）
    Route::get('/admin', [AuthController::class, 'index'])->name('admin.index');

    // 検索
    Route::get('/admin/search', [AuthController::class, 'search'])->name('admin.search');

    // 検索リセット
    Route::get('/admin/reset', [AuthController::class, 'reset'])->name('admin.reset');

    // お問い合わせ削除
    Route::delete('/admin/delete/{id}', [AuthController::class, 'delete'])->name('admin.delete');

    // エクスポート
    Route::get('/admin/export', [AuthController::class, 'export'])->name('admin.export');
});
