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
use Laravie\Parser\Xml\Reader;
use Orchestra\Parser\Xml\Document;
use Orchestra\Parser\Xml\Facade as XmlParser;
use phpseclib\Net\SSH1;
use Weidner\Goutte\GoutteFacade;
use function foo\func;

Route::get('/', function () {
//    return view('welcome');
    return view('landing');
});

Route::get('/landingtest', function (){
    return view('landing');
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

//        Route::resource('departments', 'DepartmentController'); // ++

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

        Route::get('ads/show_advertisable/{id}', 'AdController@show_advertisable')->name('show_advertisable');
        Route::get('ads/verify/{id}', 'AdController@verify_ad')->name('verify_ad');
        Route::resource('ads', 'AdController');

        Route::resource('books', 'BookController');

        Route::resource('students', 'StudentController');

        Route::get('/manageHistories/ajaxManaged', 'ManageHistoryController@ajaxManaged');
        Route::resource('manageHistories', 'ManageHistoryController');

    });

    Route::patch('departments/{department}/editProfile/', [
        'as' => 'departments.updateProfile', 'uses' => 'DepartmentController@updateProfile'
    ]);
    Route::get('departments/{department}/editProfile/', [
        'as' => 'departments.editProfile', 'uses' => 'DepartmentController@editProfile'
    ]);
    Route::resource('departments', 'DepartmentController'); // ++



    Route::get('showProfile/', [
        'as' => 'users.showProfile', 'uses' => 'UserController@showProfile'
    ]);
    Route::patch('updateProfile/{user}', [
        'as' => 'users.updateProfile', 'uses' => 'UserController@updateProfile'
    ]);
    Route::get('editProfile', [
        'as' => 'users.editProfile', 'uses' => 'UserController@editProfile'
    ]);

    Route::get('/notices/ajaxOwner', 'NoticeController@ajaxOwner');
    Route::resource('notices', 'NoticeController');

    Route::get('notifications/notifyStudents/', [
        'as' => 'notifications.showNotifyStudents', 'uses' => 'NotificationController@showNotifyStudents'
    ]);
    Route::get('notifications/notifyStudents/{type}/{id}', [
        'as' => 'notifications.showNotifyStudentsFromNotifier', 'uses' => 'NotificationController@showNotifyStudentsFromNotifier'
    ]);
    Route::post('notifications/notifyStudents', [
        'as' => 'notifications.notifyStudents', 'uses' => 'NotificationController@notifyStudents'
    ]);
    Route::get('/notifications/ajaxStudyField', 'NotificationController@ajaxStudyField');
    Route::get('/notifications/ajaxStudyArea', 'NotificationController@ajaxStudyArea');
    Route::get('/notifications/ajaxNotifier', 'NotificationController@ajaxNotifier');
    Route::resource('notifications', 'NotificationController');

    //    Route::get('/home', 'HomeController@index');
    Route::get('/home', [
        'as' => 'home', 'uses' => 'HomeController@index'
    ]);

    Route::resource('users', 'UserController'); // ++

});



Route::get('departments/{department}/showProfile/', [
    'as' => 'departments.showProfile', 'uses' => 'DepartmentController@showProfile'
]);

Route::get('notices/{notice}/public_show/', [
    'as' => 'notices.publicShow', 'uses' => 'NoticeController@publicShow'
]);


Route::get('news/{news}/public_show/', [
    'as' => 'news.publicShow', 'uses' => 'NewsController@publicShow'
]);

/** test notification page */
Route::middleware('auth:web')->get('/test', function(){
    return view('test');
});

Route::get('roletest', function(){
    Auth::user()->assignRole('developer');
});

Route::get('notitest', function(){
    return Notice::find(21)->notifications;
});

Route::get('manage', function (){
//    return Auth::user()->manage_history;
//    return Auth::user()->is_manager_of();
    $manager = Department::find(113)->manager();
    if(isset($manager))
        return Department::find(113)->manager();
    else
        return "FALSE";
//    foreach (Department::all() as $departmnt){
//        dump($departmnt->manager());
//    }
});

Route::get('xmltest', function (){

    /** ********************************************************************************************************** */
    $url = 'http://research.scu.ac.ir/web/lib/%D8%B5%D9%81%D8%AD%D9%87-%D8%A7%D8%B5%D9%84%DB%8C/-/asset_publisher/Nor6SBt40S5T/rss?p_p_cacheability=cacheLevelPage';
    /** ********************************************************************************************************** */
//    dump("read data from SCU notice rss: " . $external_service->title . "...");
    dump("( URL: " . $url . " )");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $xml = curl_exec($ch);  // get xml content of this service rss url
    curl_close($ch);

    $xml = simplexml_load_string($xml);

    /**
     * scu portal have special structure and we don't need all information its provide;
     * so we use certain part of information which retrieved in "entry" key
     * that's an array of notices
     */
    $datas = json_decode(json_encode($xml));
    dump(array($datas->entry[0]->link[0]->href));
//    dump(xmlToArray($xml));

//    foreach ($datas as $data){
//        dump($data->link);
//        dump(filter_var(strval(($data->link)[1]['href']), FILTER_VALIDATE_URL));
//    }
    return;
    /** retrieve owner of the notice; for example: department */

});

function console_log()
{
    $js_code = 'console.log(' . json_encode(func_get_args(), JSON_HEX_TAG) .
        ');';
    $js_code = '<script>' . $js_code . '</script>';
    echo $js_code;
}

function xmlToArray($xml, $options = array()) {
    $defaults = array(
        'namespaceSeparator' => ':',//you may want this to be something other than a colon
        'attributePrefix' => '@',   //to distinguish between attributes and nodes with the same name
        'alwaysArray' => array(),   //array of xml tag names which should always become arrays
        'autoArray' => true,        //only create arrays for tags which appear more than once
        'textContent' => '$',       //key used for the text content of elements
        'autoText' => true,         //skip textContent key if node has no attributes or child nodes
        'keySearch' => false,       //optional search and replace on tag and attribute names
        'keyReplace' => false       //replace values for above search values (as passed to str_replace())
    );
    $options = array_merge($defaults, $options);
    $namespaces = $xml->getDocNamespaces();
    $namespaces[''] = null; //add base (empty) namespace

    //get attributes from all namespaces
    $attributesArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
            //replace characters in attribute name
            if ($options['keySearch']) $attributeName =
                str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
            $attributeKey = $options['attributePrefix']
                . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                . $attributeName;
            $attributesArray[$attributeKey] = (string)$attribute;
        }
    }

    //get child nodes from all namespaces
    $tagsArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->children($namespace) as $childXml) {
            //recurse into child nodes
            $childArray = xmlToArray($childXml, $options);
            list($childTagName, $childProperties) = each($childArray);

            //replace characters in tag name
            if ($options['keySearch']) $childTagName =
                str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
            //add namespace prefix, if any
            if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;

            if (!isset($tagsArray[$childTagName])) {
                //only entry with this key
                //test if tags of this type should always be arrays, no matter the element count
                $tagsArray[$childTagName] =
                    in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                        ? array($childProperties) : $childProperties;
            } elseif (
                is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                === range(0, count($tagsArray[$childTagName]) - 1)
            ) {
                //key already exists and is integer indexed array
                $tagsArray[$childTagName][] = $childProperties;
            } else {
                //key exists so convert to integer indexed array with previous value in position 0
                $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
            }
        }
    }

    //get text content of node
    $textContentArray = array();
    $plainText = trim((string)$xml);
    if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;

    //stick it all together
    $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
        ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

    //return node as array
    return array(
        $xml->getName() => $propertiesArray
    );
}

Route::get('temp', function (){
    Log::info('A user has arrived at the temp page.', ['user' => Auth::user()]);
});


//make a push notification.
Route::middleware('auth:web')->get('/push/{message?}','PushController@push')->name('push');
