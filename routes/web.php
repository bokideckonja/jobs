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

// Normaly we would have dedicated controller, but for small
// project like this, we will just display index method from
// jobs controller, for the sake of not duplicating code
Route::get('/', 'JobsController@index');

// Auth routes
Auth::routes();

// Dashboard
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Job links
Route::get('/jobs/create', 'JobsController@create');
Route::get('/jobs/{job}', 'JobsController@show');
Route::post('/jobs', 'JobsController@store');
Route::get('/jobs/{job}/edit', 'JobsController@edit');
Route::put('/jobs/{job}', 'JobsController@update');
Route::delete('/jobs/{job}', 'JobsController@destroy');


// Token based access, for mail links
Route::get('/jobs/approve/{token}', 'JobsController@tokenApprove');
Route::get('/jobs/spam/{token}', 'JobsController@tokenSpam');