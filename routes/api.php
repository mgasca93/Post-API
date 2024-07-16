<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group( function(){
    // Route::get('/', function( Request $request ){
    //     return response()->json([
    //         'message' => 'Welcome to the API',
    //         'status' => 'success',
    //     ]);
    // });

    Route::post('/user/register', [
            \App\Http\Controllers\API\V1\RegisterController::class, 'store'
    ])->name('user.register');

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');
});
