<?php

use Illuminate\Http\Request;
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

Route::get('/', 'Controller@checkUser');

Route::get('/login/{email}/{password}', 'Auth\LoginController@tryLogin')->name('login');

Route::get('/logout/{token}', 'Auth\LoginController@logout')->name('logout');

Route::get('/disponible/{token}', 'PartidaController@disponible')->name('disponible');

Auth::routes();