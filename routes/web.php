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


use Illuminate\Container\Container;
use Laravie\Parser\Xml\Reader;
use Orchestra\Parser\Xml\Document;
use function GuzzleHttp\Psr7\str;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index');

Route::middleware('auth:web')->resource('locations', 'LocationController');

Route::middleware('auth:web')->resource('media', 'MediaController');

Route::middleware('auth:web')->resource('news', 'NewsController');

Route::middleware('auth:web')->resource('notifications', 'NotificationController');

Route::middleware('auth:web')->resource('notices', 'NoticeController');
