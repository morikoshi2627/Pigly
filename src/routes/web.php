<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\Auth\RegisterController;
// use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::get('/weight_logs', [WeightLogController::class, 'index'])
    ->middleware('auth') // ← 認証ユーザーのみアクセス可能にするミドルウェア
    ->name('weight_logs.index');

// 初期体重登録画面の表示（GET）
Route::get('/register/step2', [WeightLogController::class, 'createInitial'])->middleware('auth')->name('register.step2');
// 初期体重登録処理（POST）
Route::post('/register/step2', [WeightLogController::class, 'storeInitial'])->middleware('auth');

// Fortify の /register を上書き
Route::get('/register/step1', [RegisterController::class, 'show'])->name('register.step1');
Route::post('/register/step1', [RegisterController::class, 'register'])->name('register.perform');

// 体重登録（登録フォームの表示）
Route::get('/weight_logs/create', [WeightLogController::class, 'create'])->middleware('auth')->name('weight_logs.create');

// 体重登録（登録処理）
Route::post('/weight_logs/create', [WeightLogController::class, 'store'])->middleware('auth')->name('weight_logs.store');

// 体重検索
Route::get('/weight_logs/search', [WeightLogController::class, 'search'])->middleware('auth')->name('weight_logs.search');

// 目標体重設定画面
Route::get('/weight_logs/goal_setting', [WeightLogController::class, 'editTarget'])->middleware('auth')->name('weight_logs.goal_setting');

// 目標体重設定更新処理（POST)
Route::post('/weight_logs/goal_setting', [WeightLogController::class, 'updateTarget'])->middleware('auth')->name('weight_logs.goal_setting.update');

// logout を明示的に上書き登録
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('web');

// 体重詳細(情報更新画面)
Route::get('/weight_logs/{weightLog}', [WeightLogController::class, 'show'])->middleware('auth')->name('weight_logs.show');

// 体重更新(情報更新画面)
Route::post('/weight_logs/{weightLog}/update', [WeightLogController::class, 'update'])->middleware('auth')->name('weight_logs.update');

// 体重更新画面表示用（GET）
Route::get('/weight_logs/{weightLog}/edit', [WeightLogController::class, 'edit'])->middleware('auth')->name('weight_logs.edit');

// 体重削除
Route::post('/weight_logs/{weightLog}/delete', [WeightLogController::class, 'destroy'])->middleware('auth')->name('weight_logs.delete');