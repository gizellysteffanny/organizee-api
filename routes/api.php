<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
],function() {
    Route::post('sign-up', 'AuthController@signUp');
    Route::post('sign-in', 'AuthController@signIn');

    Route::middleware('auth:api')->group(function() {
        Route::delete('sign-out', 'AuthController@signOut');
    });
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'App\Http\Controllers',
], function() {
    Route::get('resources', 'ResourcesController@index');
    Route::get('resources/{id}', 'ResourcesController@show');
    Route::post('resources', 'ResourcesController@store');
    Route::delete('resources/{id}', 'ResourcesController@delete');
});