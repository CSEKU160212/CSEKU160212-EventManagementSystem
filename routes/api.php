<?php

use App\Http\Controllers\AuthController;
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


//login, signup, logout, user routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::post('signup', 'AuthController@signup')->name('auth.signup');

    Route::group(['middleware' => 'auth:api'], function() {
          Route::get('logout', 'AuthController@logout')->name('auth.logout');
          Route::get('user', 'AuthController@user')->name('auth.user');
      });
});

Route::group(['prefix' => 'event'], function () {
    Route::get('allevent', 'Event\EventController@index')->name('event.index');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('store', 'Event\EventController@store')->name('event.store');
        Route::get('edit/{event}', 'Event\EventController@edit')->name('event.store');
        Route::put('update/{event}', 'Event\EventController@update')->name('event.update');
        Route::get('delete/{event}', 'Event\EventController@destroy')->name('event.destroy');

      });
});