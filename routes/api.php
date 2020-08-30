<?php

use App\Events\NewMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'prefix' => 'auth',
    'middleware' => 'cors'
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

Route::group(['middleware' => ['auth:api', 'cors']], function(){

    /** User Apis which needs Authenticated user */
    Route::put('users/{id}/update_scu_id', 'UserAPIController@updateScuId');
//    Route::put('users/verify', 'UserAPIController@verify');
    Route::get('users/userInfo', 'UserAPIController@userInfo');
    Route::get('users/notifications', 'UserAPIController@notifications'); /** Retrieve notifications of authenticated user */
    /** User Roles and Permissions Apis which needs Authenticated user */
    Route::post('users/hasRole', 'RolePermissionAPIController@hasRole');
    Route::get('users/roles', 'RolePermissionAPIController@roles');

    /** Notifications Apis which needs Authenticated user */
    Route::get('notifications/{id}/notifierOwner', 'NotificationAPIController@notifierOwner');

    /** Ad Apis which needs Authenticated user */
    Route::get('ads/show_book_ad/{id}', 'AdAPIController@show_book_ad'); /** Displaying a book advertisement (Custom Method) */
    Route::get('ads/index_book_ads', 'AdAPIController@index_book_ads'); /** Displaying all book advertisements (Custom Method) */
    Route::get('ads/my_book_ads', 'AdAPIController@my_book_ads'); /** Displaying user's book advertisements (Custom Method) */
    Route::post('ads/create_book_ad', 'AdAPIController@create_book_ad'); /** Adding a book advertisement (Custom Method) */
    Route::get('ads/remove_book_ad/{id}', 'AdAPIController@remove_book_ad'); /** Displaying user's book advertisements (Custom Method) */
    Route::get('ads/update_book_ad/{id}', 'AdAPIController@update_book_ad'); /** Updating user's book advertisements (Custom Method) */


    /** Student Apis which needs Authenticated user */
    Route::get('students/byScuId', 'StudentAPIController@byScuId'); /** retrieve user by scu_id */
    Route::put('students/updateProfile', 'StudentAPIController@updateProfile'); /** Update Profile Information of authenticated user */
    Route::put('students/verify', 'StudentAPIController@verify'); /** Verify University information (as student) of authenticated User */
    Route::delete('students/unVerify', 'StudentAPIController@unVerify'); /** Soft Delete Student information of authenticated user */
    Route::delete('students/hardDelete', 'StudentAPIController@hardDelete'); /** Hard Delete Student information of authenticated user */
    Route::get('students/studentInfo', 'StudentAPIController@studentInfo'); /** Retrieve Student information of authenticated user */
    Route::get('students/notifications', 'StudentAPIController@notifications'); /** Retrieve notifications of authenticated studentRetrieve notifications of authenticated student */
    Route::get('students/readNotifications', 'StudentAPIController@readNotifications'); /** Retrieve read notifications of authenticated student */
    Route::get('students/unreadNotifications', 'StudentAPIController@unreadNotifications'); /** Retrieve Unread notifications of authenticated student */
    Route::put('students/notification/markAsRead', 'StudentAPIController@markAsReadNotification'); /** Update the notification should be mark as read by authenticated Student */
    Route::put('students/notifications/markAsRead', 'StudentAPIController@markAsReadNotifications'); /** Update the notifications should be mark as read by authenticated Student */
    Route::put('students/notification/markAsUnread', 'StudentAPIController@markAsUnreadNotification'); /** Update the notification should be mark as unread by authenticated Student */
    Route::put('students/notifications/markAsUnread', 'StudentAPIController@markAsUnreadNotifications'); /** Update the notifications should be mark as unread by authenticated Student */

    /** Department Apis which doesnt needs Authenticated user */
    Route::get('departments/{id}', 'DepartmentAPIController@show');
    Route::get('departments/{id}/notices', 'DepartmentAPIController@notices');


    Route::group(['middleware' => ['role:admin|developer']], function(){

        Route::get('locations/bytype/{id}', 'LocationAPIController@byType');
        Route::resource('locations', 'LocationAPIController');

        Route::resource('users', 'UserAPIController');

        Route::resource('media', 'MediaAPIController');

        Route::resource('news', 'NewsAPIController');

        Route::resource('notices', 'NoticeAPIController');

        Route::resource('genders', 'GenderAPIController');

        Route::resource('terms', 'TermAPIController');

        Route::resource('study_levels', 'StudyLevelAPIController');

        Route::resource('ad_types', 'AdTypeAPIController');

        Route::resource('categories', 'CategoryAPIController');

        /** Book Trade */

//        Route::post('ads/create_book_ad', 'AdAPIController@create_book_ad'); /** Adding a book advertisement (Custom Method) */
//        Route::get('ads/show_book_ad/{id}', 'AdAPIController@show_book_ad'); /** Displaying a book advertisement (Custom Method) */
//        Route::get('ads/index_book_ads', 'AdAPIController@index_book_ads'); /** Displaying all book advertisements (Custom Method) */
//        Route::get('ads/my_book_ads', 'AdAPIController@my_book_ads'); /** Displaying user's book advertisements (Custom Method) */
//        Route::get('ads/update_book_ad/{id}', 'AdAPIController@update_book_ad'); /** Updating user's book advertisements (Custom Method) */
//        Route::get('ads/remove_book_ad/{id}', 'AdAPIController@remove_book_ad'); /** Displaying user's book advertisements (Custom Method) */
        Route::resource('ads', 'AdAPIController');

        /** Book Trade */

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

//        Route::post('notifications/notify_students', 'NotificationAPIController@notify_students');
        Route::resource('notifications', 'NotificationAPIController');

    });
});


Route::group(['middleware' => 'cors'], function() {
    /** Location Apis which doesnt needs Authenticated user */
    Route::get('locations', 'LocationAPIController@index');
    Route::get('locations/{location}', 'LocationAPIController@show');
    /** Location Routes, that's it */

    /** Media Apis which doesnt needs Authenticated user */
    Route::get('medias', 'MediaAPIController@index');
    Route::get('medias/{media}', 'MediaAPIController@show');
    /** Media Routes, that's it */

    /** News Apis which doesnt needs Authenticated user */
    Route::get('news', 'NewsAPIController@index');
    Route::get('news/{news}', 'NewsAPIController@show');
    /** News Routes, that's it */

    /** Notice Apis which doesnt needs Authenticated user */
    Route::get('notices', 'NoticeAPIController@index');
    Route::get('notices/{notice}', 'NoticeAPIController@show');
    /** Notice Routes, that's it */

    /** Gender Apis which doesnt needs Authenticated user */
    Route::get('genders', 'GenderAPIController@index');
    Route::get('genders/{gender}', 'GenderAPIController@show');
    /** Gender Routes, that's it */

    /** Term Apis which doesnt needs Authenticated user */
    Route::get('terms', 'TermAPIController@index');
    Route::get('terms/{term}', 'TermAPIController@show');
    /** Term Routes, that's it */

    /** StudyLevel Apis which doesnt needs Authenticated user */
    Route::get('study_levels', 'StudyLevelAPIController@index');
    Route::get('study_levels/{study_level}', 'StudyLevelAPIController@show');
    /** StudyLevel Routes, that's it */

    /** AdType Apis which doesnt needs Authenticated user */
    Route::get('ad_types', 'AdTypeAPIController@index');
    Route::get('ad_types/{ad_type}', 'AdTypeAPIController@show');
    /** AdType Routes, that's it */

    /** Category Apis which doesnt needs Authenticated user */
    Route::get('categories', 'CategoryAPIController@index');
    Route::get('categories/{category}', 'CategoryAPIController@show');
    /** Category Routes, that's it */

    /** BookEdition Apis which doesnt needs Authenticated user */
    Route::get('book_editions', 'BookEditionAPIController@index');
    Route::get('book_editions/{book_edition}', 'BookEditionAPIController@show');
    /** BookEdition Routes, that's it */

    /** BookLanguage Apis which doesnt needs Authenticated user */
    Route::get('book_languages', 'BookLanguageAPIController@index');
    Route::get('book_languages/{book_language}', 'BookLanguageAPIController@show');
    /** BookLanguage Routes, that's it */

    /** BookSize Apis which doesnt needs Authenticated user */
    Route::get('book_sizes', 'BookSizeAPIController@index');
    Route::get('book_sizes/{book_size}', 'BookSizeAPIController@show');
    /** BookSize Routes, that's it */

    /** Book Apis which doesnt needs Authenticated user */
    Route::get('books', 'BookAPIController@index');
    Route::get('books/{book}', 'BookAPIController@show');
    /** Book Routes, that's it */

    /** ManageLevel Apis which doesnt needs Authenticated user */
    Route::get('manage_levels', 'ManageLevelAPIController@index');
    Route::get('manage_levels/{manage_level}', 'ManageLevelAPIController@show');
    /** ManageLevel Routes, that's it */

    /** ManageHierarchy Apis which doesnt needs Authenticated user */
    Route::get('manage_hierarchies', 'ManageHierarchyAPIController@index');
    Route::get('manage_hierarchies/{manage_hierarchy}', 'ManageHierarchyAPIController@show');
    /** ManageHierarchy Routes, that's it */

    /** Department Apis which doesnt needs Authenticated user */
//    Route::get('departments', 'DepartmentAPIController@index');
//    Route::get('departments/{department}', 'DepartmentAPIController@show');
    /** Department Routes, that's it */

    /** Faculty Apis which doesnt needs Authenticated user */
    Route::get('faculties', 'FacultyAPIController@index');
    Route::get('faculties/{faculty}', 'FacultyAPIController@show');
    /** Faculty Routes, that's it */

    /** StudyField Apis which doesnt needs Authenticated user */
    Route::get('study_fields', 'StudyFieldAPIController@index');
    Route::get('study_fields/{study_field}', 'StudyFieldAPIController@show');
    /** StudyField Routes, that's it */

    /** StudyArea Apis which doesnt needs Authenticated user */
    Route::get('study_areas', 'StudyAreaAPIController@index');
    Route::get('study_areas/{study_area}', 'StudyAreaAPIController@show');
    /** StudyArea Routes, that's it */

    /** StudyStatus Apis which doesnt needs Authenticated user */
    Route::get('study_statuses', 'StudyStatusAPIController@index');
    Route::get('study_statuses/{study_status}', 'StudyStatusAPIController@show');
    /** StudyStatus Routes, that's it */

    /** StudyStatus Apis which doesnt needs Authenticated user */
    Route::get('students', 'StudentAPIController@index');
    Route::get('students/{student}', 'StudentAPIController@show');
    /** StudyStatus Routes, that's it */

    /** ManageHistory Apis which doesnt needs Authenticated user */
    Route::get('manage_histories', 'ManageHistoryAPIController@index');
    Route::get('manage_histories/{manage_histories}', 'ManageHistoryAPIController@show');
    /** ManageHistory Routes, that's it */

    /** Notification Apis which doesnt needs Authenticated user */
//    Route::post('notifications/notify_students', 'NotificationAPIController@notify_students');
//    Route::get('notifications/{notification}', 'NotificationAPIController@show');
    /** Notification Routes, that's it */

//Route::get('/notification/test/{message}', function ($message){
//    return event(new NewMessage($message));
//});

    /** Fire Event */

    Route::get('test-broadcast/', function (Request $request) {

        return event(new \App\Events\NewMessage($request->get('message')));

    });

    /** Fire Event */


    Route::resource('external_service_types', 'ExternalServiceTypeAPIController');

    Route::resource('external_services', 'ExternalServiceAPIController');


//store a push subscriber.
    Route::post('/push', 'PushController@store');
});
