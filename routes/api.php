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

Route::post('/login', 'App\Http\Controllers\authUserController@login');
Route::post('register', 'App\Http\Controllers\authUserController@register');

Route::group(['prefix' => 'users','middleware' => ['auth:api']], function() {
    Route::get('/','App\Http\Controllers\userController@listing');

    Route::post('/add-user', 'App\Http\Controllers\userController@fileUploadAddUser');
    Route::post('/delete-user', 'App\Http\Controllers\userController@fileUploadDeleteUser');
});
