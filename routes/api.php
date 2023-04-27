<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('api')->group(function (){
    Route::post('/auth/login', [LoginController::class, 'login']);
    Route::post('/auth/logout', [LoginController::class, 'logout']);
    Route::post('/auth/register', [LoginController::class, 'register']);


    Route::get('/auth/detail', [LoginController::class, 'detail']);

    Route::post('/product/upload-image', [ProductController::class, 'upload']);
    Route::post('/product/add', [ProductController::class, 'create']);
    Route::get('/product/list', [ProductController::class, 'index']);
    Route::get('/product/edit/{id}', [ProductController::class, 'edit']);
    Route::get('/product/search', [ProductController::class, 'search']);
    Route::put('/product/update/{id}', [ProductController::class, 'update']);

    Route::post('/category/add', [CategoryController::class, 'create']);
    Route::get('/category/list', [CategoryController::class, 'index']);
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::put('/category/update/{id}', [CategoryController::class, 'update']);
});




