<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);
Route::apiResource('/banksoals', App\Http\Controllers\Api\banksoalController::class);
Route::apiResource('/materis', App\Http\Controllers\Api\materiController::class);

//API Login
Route::post('auth/login', \App\Http\Controllers\Api\Auth\LoginController::class);

//API Data User
Route::apiResource('auth/user', \App\Http\Controllers\Api\Auth\UserController::class);

//API Data Siswa
Route::get('/siswas/{user}', [App\Http\Controllers\Api\Auth\UserController::class, 'dataSiswa']);

//API Update User
Route::put('/updateprofile/{user}', [App\Http\Controllers\Api\Auth\UserController::class, 'updateProfile']);
Route::put('/updatepassword/{user}', [App\Http\Controllers\Api\Auth\UserController::class, 'updatePassword']);
Route::put('/updateimage/{user}', [App\Http\Controllers\Api\Auth\UserController::class, 'updateImage']);

//API Data Image User
Route::get('/image/{user}', [App\Http\Controllers\Api\Auth\UserController::class, 'showImage']);


//API Soal Ujian
Route::post('/exam', [ App\Http\Controllers\Api\ExamController::class, 'store']);
Route::get('/exam/{id_user}/{level}/{subject}', [ App\Http\Controllers\Api\ExamController::class, 'show']);
Route::put('/exam', [ App\Http\Controllers\Api\ExamController::class, 'update']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

