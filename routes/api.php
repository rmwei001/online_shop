<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResendVerificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//public routes
Route::post('/register-user', [AuthController::class, 'register']);
Route::post('/login-user', [AuthController::class, 'login']);

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
            ->name('verification.verify')
            ->middleware(['signed', 'throttle:6,1']);

Route::post('/email/resend', [ResendVerificationController::class, 'resend'])
            ->middleware(['throttle:6,1']);

//Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout_user', [AuthController::class, 'logout']);

    Route::post('/create-role',[RoleController::class,'createRole']);
    Route::get('/read-roles',[RoleController::class,'readAll']);
    Route::get('/read-role/{id}',[RoleController::class, 'readRole']);
    Route::post('/update-role/{id}',[RoleController::class, 'updateRole']);
    Route::delete('/delete-role/{id}',[RoleController::class, 'deleteRole']);

    Route::post('/create-category',[CategoryController::class,'createCategory']);
    Route::get('/read-categories',[CategoryController::class,'readAll']);
    Route::get('/read-category/{id}',[CategoryController::class, 'readCategory']);
    Route::post('/update-category/{id}',[CategoryController::class, 'updateCategory']);
    Route::delete('/delete-category/{id}',[CategoryController::class, 'deleteCategory']);

    Route::post('/create-user',[UserController::class,'createUser']);
    Route::get('/read-users',[UserController::class,'readAll']);
    Route::get('/read-user/{id}',[UserController::class, 'readUser']);
    Route::post('/update-user/{id}',[UserController::class, 'updateUser']);
    Route::delete('/delete-user/{id}',[UserController::class, 'deleteUser']);

    Route::post('/create-product',[ProductController::class,'createProduct']);
    Route::get('/read-products',[ProductController::class,'readAll']);
    Route::get('/read-product/{id}',[ProductController::class, 'readProduct']);
    Route::post('/update-product/{id}',[ProductController::class, 'updateProduct']);
    Route::delete('/delete-product/{id}',[ProductController::class, 'deleteProduct']);
});