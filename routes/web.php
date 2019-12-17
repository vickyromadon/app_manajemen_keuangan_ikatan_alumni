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

// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// check NIS
Route::get('check-nis', 'Auth\RegisterController@showFormCheckNIS')->name('check-nis');
Route::post('check-nis', 'Auth\RegisterController@checkNIS');

// check data
Route::get('check-data', 'Auth\RegisterController@showFormCheckData')->name('check-data');
Route::post('check-data', 'Auth\RegisterController@checkData');

// result account
Route::get('result-account', 'Auth\RegisterController@resultAccount')->name('result-account');

// home
Route::get('/', 'HomeController@index')->name('index');

// news
Route::get('news',      'NewsController@index')->name('news.index');
Route::resource('news', 'NewsController', ['only' => [
    'show',
]]);

// galery
Route::get('galery',        'GaleryController@index')->name('galery.index');
Route::resource('galery',   'GaleryController', ['only' => [
    'show',
]]);

// event
Route::get('event',         'EventController@index')->name('event.index');
Route::resource('event',    'EventController', ['only' => [
    'show',
]]);

// donation
Route::get('donation',      'DonationController@index')->name('donation.index');
Route::post('donation/change-password/{id}',    'ProfileController@changePassword')->name('profile.change-password');
Route::resource('donation', 'DonationController', ['only' => [
    'show',
]]);

Route::group(['middleware' => ['auth', 'alumni']], function () {
    // profile
    Route::get('profile',                          'ProfileController@index')->name('profile.index');
    Route::post('profile/change-password/{id}',    'ProfileController@changePassword')->name('profile.change-password');
    Route::post('profile/change-avatar/{id}',      'ProfileController@changeAvatar')->name('profile.change-avatar');
    Route::post('profile/change-setting/{id}',     'ProfileController@changeSetting')->name('profile.change-setting');
});

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // Login
    Route::match(['get', 'post'], 'login', 'Auth\LoginController@login')->name('login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['auth', 'admin']], function () {
        // home
        Route::get('/', 'HomeController@index')->name('index');

        // profile
        Route::get('profile',                          'ProfileController@index')->name('profile.index');
        Route::post('profile/change-password/{id}',    'ProfileController@changePassword')->name('profile.change-password');
        Route::post('profile/change-avatar/{id}',      'ProfileController@changeAvatar')->name('profile.change-avatar');
        Route::post('profile/change-setting/{id}',     'ProfileController@changeSetting')->name('profile.change-setting');

        // dataset
        Route::match(['get', 'post'], 'dataset',   'DatasetController@index')->name('dataset.index');
        Route::post('dataset/add',                 'DatasetController@store')->name('dataset.store');
        Route::resource('dataset',                 'DatasetController', ['only' => [
            'update', 'destroy',
        ]]);

        // news
        Route::match(['get', 'post'], 'news',   'NewsController@index')->name('news.index');
        Route::post('news/add',                 'NewsController@store')->name('news.store');
        Route::resource('news',                 'NewsController', ['only' => [
            'update', 'destroy',
        ]]);

        // galery
        Route::match(['get', 'post'], 'galery',   'GaleryController@index')->name('galery.index');
        Route::post('galery/add',                 'GaleryController@store')->name('galery.store');
        Route::resource('galery',                 'GaleryController', ['only' => [
            'update', 'destroy',
        ]]);

        // event
        Route::match(['get', 'post'], 'event',   'EventController@index')->name('event.index');
        Route::post('event/add',                 'EventController@store')->name('event.store');
        Route::resource('event',                 'EventController', ['only' => [
            'update', 'destroy',
        ]]);

        // donation
        Route::match(['get', 'post'], 'donation',   'DonationController@index')->name('donation.index');
        Route::post('donation/add',                 'DonationController@store')->name('donation.store');
        Route::resource('donation',                 'DonationController', ['only' => [
            'update', 'destroy',
        ]]);

        // message
        Route::match(['get', 'post'], 'message',   'MessageController@index')->name('message.index');
        Route::resource('message',                 'MessageController', ['only' => [
            'destroy',
        ]]);

        // slider
        Route::match(['get', 'post'], 'slider', 'SliderController@index')->name('slider.index');
        Route::post('slider/add',               'SliderController@store')->name('slider.store');
        Route::resource('slider',               'SliderController', ['only' => [
            'update', 'destroy',
        ]]);

        // bank
        Route::match(['get', 'post'], 'bank',   'BankController@index')->name('bank.index');
        Route::post('bank/add',                 'BankController@store')->name('bank.store');
        Route::resource('bank',                 'BankController', ['only' => [
            'update', 'destroy',
        ]]);
    });
});
