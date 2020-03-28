<?php

use App\Events\NewMessage;
use Illuminate\Http\Request;

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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
Route::post('/send_otp', 'OtpController@send_otp');

Route::resource('locations', 'LocationAPIController');

Route::get('locations/bytype/{id}', 'LocationAPIController@byType');

Route::resource('media', 'MediaAPIController');

Route::resource('news', 'NewsAPIController');

Route::resource('notifications', 'NotificationAPIController');

Route::resource('notices', 'NoticeAPIController');

Route::resource('users', 'UserAPIController');
Route::middleware('auth:api')->put('users/{id}/update_scu_id', 'UserAPIController@updateScuId');
Route::middleware('auth:api')->put('users/{id}/verify', 'UserAPIController@verify');



//Route::get('/notification/test/{message}', function ($message){
//    return event(new NewMessage($message));
//});





Route::resource('genders', 'GenderAPIController');

Route::resource('terms', 'TermAPIController');

Route::resource('study_levels', 'StudyLevelAPIController');


Route::resource('ad_types', 'AdTypeAPIController');

Route::resource('categories', 'CategoryAPIController');

Route::resource('ads', 'AdAPIController');
Route::post('ads/create_book_ad', 'AdAPIController@create_book_ad'); /** Adding a book advertisement (Custom Method) */
Route::get('ads/show_book_ad/{id}', 'AdAPIController@show_book_ad'); /** Displaying a book advertisement (Custom Method) */

Route::resource('book_editions', 'BookEditionAPIController');

Route::resource('book_languages', 'BookLanguageAPIController');

Route::resource('book_sizes', 'BookSizeAPIController');

Route::resource('books', 'BookAPIController');


Route::resource('manage_levels', 'ManageLevelAPIController');

Route::resource('manage_hierarchies', 'ManageHierarchyAPIController');



Route::resource('departments', 'DepartmentAPIController');

Route::resource('faculties', 'FacultyAPIController');

Route::resource('study_fields', 'StudyFieldAPIController');

Route::resource('study_areas', 'StudyAreaAPIController');

Route::resource('study_statuses', 'StudyStatusAPIController');

Route::resource('students', 'StudentAPIController');

Route::resource('manage_histories', 'ManageHistoryAPIController');
