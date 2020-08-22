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
    Route::get('all', 'Event\EventController@index')->name('event.index');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('store', 'Event\EventController@store')->name('event.store');
        Route::get('edit/{id}', 'Event\EventController@edit')->name('event.edit');
        Route::get('show/{id}', 'Event\EventController@show')->name('event.show');
        Route::put('update/{id}', 'Event\EventController@update')->name('event.update');
        Route::delete('delete/{id}', 'Event\EventController@destroy')->name('event.destroy');

        Route::group(['prefix' => 'option'], function () {
            Route::get('all/{eventid}', 'Event\EventOptionController@index')->name('event.option.index');
            Route::post('store/{eventid}', 'Event\EventOptionController@store')->name('event.option.store');
            Route::get('show/{optionid}', 'Event\EventOptionController@show')->name('event.option.show');
            Route::get('edit/{optionid}', 'Event\EventOptionController@edit')->name('event.option.edit');
            Route::put('update/{optionid}', 'Event\EventOptionController@update')->name('event.option.update');
            Route::delete('delete/{optionid}', 'Event\EventOptionController@destroy')->name('event.option.delete');
        });

        Route::group(['prefix' => 'comment'], function () {
            Route::get('all/{eventid}', 'Event\EventCommentController@index')->name('event.comment.index');
            Route::post('store/{eventid}', 'Event\EventCommentController@store')->name('event.comment.store');
            Route::get('show/{commentid}', 'Event\EventCommentController@show')->name('event.comment.show');
            Route::get('edit/{commentid}', 'Event\EventCommentController@edit')->name('event.comment.edit');
            Route::put('update/{commentid}', 'Event\EventCommentController@update')->name('event.comment.update');
            Route::delete('delete/{commentid}', 'Event\EventCommentController@destroy')->name('event.comment.delete');
        });
      });
});