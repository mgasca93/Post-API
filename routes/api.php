<?php

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\CategoryController;

Route::prefix('v1')->name('api.v1.')->group( function(){

    Route::get('/', function( Request $request ){
        return response()->json([
            'message' => 'Welcome to the API',
            'status' => 'success',
        ], Response::HTTP_OK);
    });

    Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
    Route::get('/users', [UserController::class, 'index'])->name('user.index');

    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
    Route::put('/category/{slug}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{slug}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');
});
