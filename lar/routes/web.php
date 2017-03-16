<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('/auth/registration', 'AuthController@registration');
Route::post('/auth/check', 'AuthController@check');
Route::post('/auth/auth', 'AuthController@auth');
Route::get('/auth/auth', 'AuthController@getUser');

Route::get('/news', 'NewsController@getList');
Route::get('/news/{id}', 'NewsController@getItem');

Route::group(['middleware' => ['api2auth', 'checkRoleNews']], function () {
    Route::get('/adminnews', 'NewsController@getListWithHidden');
    Route::delete('/news/{id}', 'NewsController@remove');
    Route::post('/news', 'NewsController@add');
    Route::post('/news/{id}', 'NewsController@edit');
});

Route::get('/user/profile', 'ProfileController@getPofile');
Route::post('/user/profile', 'ProfileController@savePofile');
