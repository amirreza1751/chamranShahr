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


use App\Models\News;
use http\Client\Request;
use Illuminate\Container\Container;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravie\Parser\Xml\Reader;
use Orchestra\Parser\Xml\Document;
use phpseclib\Net\SSH1;
use Weidner\Goutte\GoutteFacade;

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
