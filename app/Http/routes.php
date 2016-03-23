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
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::resource('/article','ArticleController');
Route::get('json', 'ArticleController@articles_json')->name('ajson');
Route::group(['middleware' => 'web'], function () {
    Route::auth();
	Route::get('userjson', 'HomeController@users_json')->name('ujson');

    Route::get('/home', 'HomeController@index');
});
