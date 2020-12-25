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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login');
Route::post('/password/email', 'API\AuthController@forgot');
Route::post('/password/reset', 'API\AuthController@reset');
Route::post('/logout', 'API\AuthController@logout')->middleware('auth:api');
Route::apiResource('/image', 'API\ImageController')->middleware('auth:api');

