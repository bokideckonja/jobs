<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Dashboard
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Job links
Route::get('/jobs', 'JobsController@index');
Route::get('/jobs/create', 'JobsController@create');
Route::post('/jobs', 'JobsController@store');

Route::get('/jobs/{job}/edit', 'JobsController@edit');
Route::put('/jobs/{job}', 'JobsController@update');

// Token based access, for mail links
Route::get('/jobs/approve/{token}', 'JobsController@tokenApprove');
Route::get('/jobs/spam/{token}', 'JobsController@tokenSpam');