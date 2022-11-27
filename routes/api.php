<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\ApiUserJsonController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::group(['prefix' => 'v1' , 'as' => 'api.'], function(){

	Route::get('users', [ApiUserJsonController::class, 'fech_users'])->name('users.fech_users');

});

