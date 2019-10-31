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

Route::post('/subscribe-ajax', 'SubscribeController@subscribeAjax')->middleware('only.ajax')->name('subscribeAjax');
Route::get('/confirm-subscription/{emailVerificationId}', 'SubscribeController@confirmSubscription')->name('confirmSubscription');
