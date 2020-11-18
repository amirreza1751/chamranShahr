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


use App\General\ConsoleColor;
use App\General\GeneralVariable;
use App\Models\Department;
use App\Models\ExternalService;
use App\Models\Gender;
use App\Models\News;
use App\Models\Notice;
use App\Models\NotificationSample;
use App\User;
use http\Client\Request;
use Illuminate\Container\Container;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Laravie\Parser\Xml\Reader;
use Orchestra\Parser\Xml\Document;
use Orchestra\Parser\Xml\Facade as XmlParser;
use phpseclib\Net\SSH1;
use Weidner\Goutte\GoutteFacade;
use function foo\func;



Route::resource('manageLevels', 'ManageLevelController'); // ++

Route::post('empty', 'HomeController@empty');

Route::group(['prefix' => 'GfIEpZz0QgdgdDz9hrpxfDo0cqk0Fw9vuBAdfM3titEyxDkOtGhPN8f0UESwBrdTWslIqA56iMSz10RZKZci2wLfGf3GJaT4wg8SBXyQg0CGBjbQYbo4I8NSNH1HodtQ'], function () {

//    Auth::routes();
    // Authentication Routes...
    $this->get('login', function (){
        return redirect(route('landing'));
    })->name('login');
//    $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $this->post('login', 'Auth\LoginController@login')->name('auth.login');

//    // Registration Routes...
//    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//    $this->post('register', 'Auth\RegisterController@register');
//
//    // Password Reset Routes...
//    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
//    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
//    $this->post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('account', 'CustomLoginController@account')->name('auth.account');
    Route::post('password', 'CustomLoginController@password')->name('auth.password');
    Route::post('credentials', 'CustomLoginController@credentials')->name('auth.credentials');
});

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('signin', function (){
    return view('auth.signin');
});
Route::post('signin', function (){
    return view('auth.signin')
        ->with('errors', collect(['email' => 'حساب کاربری با این مشخصات وجود ندارد']));
});

Route::get('/', function () {
//    return view('welcome');
    return view('landing');
})->name('landing');

Route::post('custom_login/send_otp_ajax', 'CustomLoginController@send_otp_ajax')->name('custom_login.send_otp_ajax');

Route::group(['middleware' => 'auth:web'], function(){

    //    Route::get('/home', 'HomeController@index');
    Route::get('/home', [
        'as' => 'home', 'uses' => 'HomeController@index'
    ]);

    Route::get('profile', 'ProfileController@profile')->name('profile');
    Route::patch('profile', 'ProfileController@updateProfile')->name('profile.update');

    Route::group(['middleware' => ['role:developer|content_manager|manager']], function(){

        Route::resource('notificationSamples', 'NotificationSampleController');

        Route::patch('departments/{department}/updateProfile/', [
            'as' => 'departments.updateProfile', 'uses' => 'DepartmentController@updateProfile'
        ]);
        Route::get('departments/{department}/profile/', [
            'as' => 'departments.profile', 'uses' => 'DepartmentController@profile'
        ]);
        Route::resource('departments', 'DepartmentController'); // ++

        Route::get('/notices/ajaxOwner', 'NoticeController@ajaxOwner');
        Route::resource('notices', 'NoticeController');

        Route::get('/externalServices/ajaxOwner', 'ExternalServiceController@ajaxOwner');
        Route::get('/externalServices/{id}/fetch', 'ExternalServiceController@fetch')->name('externalServices.fetch');
        Route::resource('externalServices', 'ExternalServiceController'); // ++

        Route::get('/notifications/ajaxStudyField', 'NotificationController@ajaxStudyField');
        Route::get('/notifications/ajaxStudyArea', 'NotificationController@ajaxStudyArea');
        Route::get('/notifications/ajaxNotifier', 'NotificationController@ajaxNotifier');
        Route::get('notifications/notify/{type}/{id}', [
            'as' => 'notifications.showNotifyFromNotifier', 'uses' => 'NotificationController@showNotifyFromNotifier'
        ]);
        Route::get('notifications/notify/', [
            'as' => 'notifications.showNotify', 'uses' => 'NotificationController@showNotify'
        ]);
        Route::post('notifications/notify', [
            'as' => 'notifications.notify', 'uses' => 'NotificationController@notify'
        ]);
        Route::resource('notifications', 'NotificationController');

        Route::get('/news/ajaxOwner', 'NewsController@ajaxOwner');
        Route::resource('news', 'NewsController');

    });

    Route::group(['middleware' => ['role:developer']], function(){



        /** test notification page */
        //Route::middleware('auth:web')->get('/test', function(){
        //    return view('test');
        //});

        //make a push notification.
        Route::middleware('auth:web')->get('/push/{message?}','PushController@push')->name('push');

        Route::resource('users', 'UserController'); // ++

        Route::get('ads/show_advertisable/{id}', 'AdController@show_advertisable')->name('show_advertisable');
        Route::get('ads/verify/{id}', 'AdController@verify_ad')->name('verify_ad');
        Route::resource('ads', 'AdController');

        Route::resource('books', 'BookController');

        Route::resource('students', 'StudentController');

        Route::get('/manageHistories/ajaxManaged', 'ManageHistoryController@ajaxManaged');
        Route::resource('manageHistories', 'ManageHistoryController');

        Route::resource('locations', 'LocationController');

        Route::resource('media', 'MediaController');


        Route::get('users/{id}/unrestricted', 'UserController@unrestricted')->name('users.unrestricted'); // ++
        Route::get('users/{id}/restrict', 'UserController@restrict')->name('users.restrict'); // ++
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

//        Route::resource('departments', 'DepartmentController'); // ++

        Route::resource('faculties', 'FacultyController'); // ++

        Route::resource('studyFields', 'StudyFieldController'); // ++

        Route::resource('studyAreas', 'StudyAreaController'); // ++

        Route::resource('studyStatuses', 'StudyStatusController'); // ++

        Route::resource('externalServiceTypes', 'ExternalServiceTypeController'); // ++

    });

});
