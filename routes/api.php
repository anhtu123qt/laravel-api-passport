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
Route::prefix('v1')->group(function(){
    Route::post('register','Api\v1\UserController@register');
    Route::post('login','Api\v1\UserController@login');
    Route::group(['middleware' => ['auth:api']],function(){
        Route::get('me','Api\v1\UserController@me');
    });
});
