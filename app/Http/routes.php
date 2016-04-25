<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTPassignments
| kernel and includes session state, CSRF protection, and more.
|
*/



Route::group(['middleware' => 'web'], function () {
	Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
	Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);
	Route::get('/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@showLoginForm']);
	Route::post('/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
	Route::get('/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);
    Route::get('/home', 'HomeController@index');
    Route::resource('/home/opdrachten', 'AssignmentsController');
    Route::resource('/home/opdrachten/delete', 'AssignmentsController@delete');
    Route::resource('/home/opdrachten/active', 'AssignmentsController@active');
    Route::resource('/home/tochten', 'TripsController');
});


