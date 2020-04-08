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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravie\Parser\Xml\Reader;
use Orchestra\Parser\Xml\Document;
use phpseclib\Net\SSH1;
use Weidner\Goutte\GoutteFacade;
use function foo\func;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth:web'], function(){

    Route::group(['middleware' => ['role:admin|developer']], function(){

        Route::resource('users', 'UserController'); // ++

        Route::get('roles/guard_name_ajax', 'RoleController@guardNameAjax');
        Route::resource('roles', 'RoleController');  // ++

        Route::get('permissions/guard_name_ajax', 'PermissionController@guardNameAjax');
        Route::resource('permissions', 'PermissionController');  // ++

        Route::resource('genders', 'GenderController'); // ++

        Route::resource('terms', 'TermController');  // ++

        Route::resource('studyLevels', 'StudyLevelController');  // ++

        Route::resource('adTypes', 'AdTypeController');  // ++

        Route::resource('categories', 'CategoryController');  // ++

        Route::resource('bookEditions', 'BookEditionController'); // ++

        Route::resource('bookLanguages', 'BookLanguageController'); // ++

        Route::resource('bookSizes', 'BookSizeController'); // ++

        Route::resource('manageLevels', 'ManageLevelController'); // ++

        Route::resource('manageHierarchies', 'ManageHierarchyController'); // ++

        Route::resource('departments', 'DepartmentController'); // ++

        Route::resource('faculties', 'FacultyController'); // ++

        Route::resource('studyFields', 'StudyFieldController'); // ++

        Route::resource('studyAreas', 'StudyAreaController'); // ++

        Route::resource('studyStatuses', 'StudyStatusController'); // ++

        Route::resource('externalServiceTypes', 'ExternalServiceTypeController'); // ++

        Route::get('/externalServices/ajaxOwner', 'ExternalServiceController@ajaxOwner');
        Route::resource('externalServices', 'ExternalServiceController'); // ++

    });

    Route::group(['middleware' => ['role:admin|developer|content_manager']], function(){

        Route::resource('locations', 'LocationController');

        Route::resource('media', 'MediaController');

        Route::resource('news', 'NewsController');

        Route::resource('notifications', 'NotificationController');

        Route::get('/notices/ajaxOwner', 'NoticeController@ajaxOwner');
        Route::resource('notices', 'NoticeController');


        Route::get('ads/show_advertisable/{id}', 'AdController@show_advertisable')->name('show_advertisable');
        Route::get('ads/verify/{id}', 'AdController@verify_ad')->name('verify_ad');
        Route::resource('ads', 'AdController');

        Route::resource('books', 'BookController');

        Route::resource('students', 'StudentController');

        Route::resource('manageHistories', 'ManageHistoryController');

    });

    Route::get('/home', 'HomeController@index');

});

/** test notification page */
Route::middleware('auth:web')->get('/test', function(){
    return view('test');
});

Route::get('roletest', function(){
    Auth::user()->assignRole('developer');
});

Route::get('xmltest2', function (){
    $input = collect((new Reader(new Document(new Container())))->load('http://scu.ac.ir/web/ugrad/%D8%B5%D9%81%D8%AD%D9%87-%D8%A7%D8%B5%D9%84%DB%8C/-/asset_publisher/UwTaYRF3YZS8/rss?p_p_cacheability=cacheLevelPage')); // get XML data notices from SCU-API
//    return $input;
    dump($input);
});





