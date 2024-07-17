<?php

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\RegisterController;

Route::prefix('v1')->name('api.v1.')->group( function(){

    Route::get('/', function( Request $request ){
        return response()->json([
            'message' => 'Welcome to the API',
            'status' => 'success',
        ], Response::HTTP_OK);
    });

    Route::post('/user/register', [RegisterController::class, 'store'])->name('user.register');
    Route::get('/user/list', [RegisterController::class, 'index']);

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');
});
