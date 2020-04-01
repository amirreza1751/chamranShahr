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


use App\Models\Gender;
use App\Models\News;
use App\User;
use http\Client\Request;
use Illuminate\Container\Container;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
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

Route::middleware('auth:web')->resource('users', 'UserController');

Route::middleware('auth:web')->resource('genders', 'GenderController');

Route::middleware('auth:web')->resource('terms', 'TermController');


Route::resource('studyLevels', 'StudyLevelController');


/** test notification page */
Route::middleware('auth:web')->get('/test', function(){
    return view('test');
});


Route::resource('adTypes', 'AdTypeController');

Route::resource('categories', 'CategoryController');

Route::get('ads/show_advertisable/{id}', 'AdController@show_advertisable')->name('show_advertisable');
Route::get('ads/verify/{id}', 'AdController@verify_ad')->name('verify_ad');
Route::resource('ads', 'AdController');

Route::resource('bookEditions', 'BookEditionController');

Route::resource('bookLanguages', 'BookLanguageController');

Route::resource('bookSizes', 'BookSizeController');

Route::resource('books', 'BookController');

Route::resource('manageLevels', 'ManageLevelController');

Route::resource('manageHierarchies', 'ManageHierarchyController');



Route::resource('departments', 'DepartmentController');

Route::resource('faculties', 'FacultyController');

Route::resource('studyFields', 'StudyFieldController');

Route::resource('studyAreas', 'StudyAreaController');

Route::resource('studyStatuses', 'StudyStatusController');

Route::resource('students', 'StudentController');

Route::resource('manageHistories', 'ManageHistoryController');

Route::middleware('auth:web')->get('permissions/guard_name_ajax', 'PermissionController@guardNameAjax');
Route::middleware('auth:web')->resource('permissions', 'PermissionController');

Route::middleware('auth:web')->get('roles/guard_name_ajax', 'RoleController@guardNameAjax');
Route::middleware('auth:web')->resource('roles', 'RoleController');
