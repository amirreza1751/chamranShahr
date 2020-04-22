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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Laravie\Parser\Xml\Reader;
use Orchestra\Parser\Xml\Document;
use Orchestra\Parser\Xml\Facade as XmlParser;
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

        Route::get('/manageHistories/ajaxManaged', 'ManageHistoryController@ajaxManaged');
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


    ini_set('max_execution_time', '1200'); // temporary set php execution limit time to 20 minutes
    $cc = new ConsoleColor();
    $default_image_dir = URL::to('/') . Storage::url('news_images/news_default_image.jpg');

    /**
     * get all external services which are news type
     */
    $external_services = ExternalService::where('content_type', News::class)->get();

    /**
     * this user is the default user of the university created by UserInitial command at first
     * consist of special information,
     * and it use for specific functionality,
     * such as fill creator_id field of news which retrieved from Scu portal using it's id
     */
    $scu_user = User::where('scu_id', 'scu')
        ->where('national_id', 'scu')
        ->where('username', 'scu')->first();

    foreach ($external_services as $external_service) {
        dump("read data from SCU news rss: " . $external_service->title . "...");
        dump("( URL: " . $external_service->url . " )");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $external_service->url);
        $xml = curl_exec($ch);  // get xml content of this service rss url
        curl_close($ch);

        $xml = simplexml_load_string($xml);

        /**
         * scu portal have special structure and we don't need all information its provide;
         * so we use certain part of information which retrieved in "item" key
         * that's an array of news
         */
        if(isset($xml->item)) {
            $datas = $xml->item;

            /** retrieve owner of the notice; for example: department */
            $model_name =  $external_service->owner_type;
            $model = new $model_name();
            $owner = $model::findOrFail($external_service->owner_id);

            dump('images store on server for specific news:');
            foreach ($datas as $data) {
                $default_image = false;
                $default_image_message = '';


                //                      < scraping news link >
                $crawler = GoutteFacade::request('GET', 'http://scu.ac.ir/-/' . urlencode(str_replace('http://scu.ac.ir/-/', '', strval($data->link))));
                $node = $crawler->filter('div.news-page-image > img')->first();
                $media_url = 'http://scu.ac.ir' . $node->attr('src');
                //                      < scraping news link >

                $news = [
                    'title' => strval($data->title),
                    'link' => strval($data->link),
                    'description' => strval($data->description),
                    'path' => $media_url,
                    'owner_type' => $external_service->owner_type,
                    'owner_id' => $external_service->owner_id,
                ];

                /**
                 * check that this news's owner has manager or not
                 * if not, use default user of the university created first of this procedure
                 */
                if(isset($owner)){
                    $manager = $owner->manager();
                    if (isset($manager)){
                        $news['creator_id'] = $owner->manager()->id;
                    } else {
                        $news['creator_id'] = $scu_user->id;
                    }
                } else {
                    $news['creator_id'] = $scu_user->id;
                }

                $news['description'] = str_replace("<br>", '\n', $news['description']);
                $news['description'] = str_replace("&nbsp;", ' ', $news['description']);

                /**
                 * identifier of each retrieved news is its "link" (id attribute in xml),
                 * so check out that in news table to find out that is a new one or not
                 */
                $check = News::where('link', $news['link'])->first();
                if (!isset($check)) { // if this news is a new one
                    if ($news['path'] != "") {// image exist
                        /**
                         * < get media size >
                         * brief look at request header to check some details
                         * such as file size, extension and etc.
                         */
                        stream_context_set_default(array('http' => array('method' => 'HEAD')));
                        $head = array_change_key_case(get_headers($news['path'], 1));
                        $clen = isset($head['content-length']) ? $head['content-length'] : 0; // content-length of download (in bytes), read from Content-Length: field

                        if (!$clen) { // cannot retrieve file size, return "-1"
                            $clen = -1;
                        }
                        /** < get media size > */

                        /**
                         * < get media extension >
                         * extract substring after last '.' and remove possible parameters
                         * example:
                         * http://scu.ac.ir/documents/236544/0/etelaeiyeh-6.jpg?t=1568533120548
                         * http://scu.ac.ir/documents/236544/0/etelaeiyeh-6.    + jpg +     ?t=1568533120548
                         *                                              we need this^
                         */
                        $pathinfo = pathinfo($news['path']);
                        if (isset($pathinfo['extension'])){
                            $extension = explode("?", $pathinfo['extension'])[0];
                        }
                        /** < get media extension > */

                        if (isset($extension) && str_contains(strtolower($extension), GeneralVariable::$inbound_acceptable_media)) { // acceptable extension such png and jpg
                            /** < get image size > */
                            if ($clen < 2097152) { // if image size < 2MiB

                                $media_file = 'tmp/news_tmp' . str_random(4) . '.tmp';
                                $ch = curl_init($news['path']);
                                $fp = fopen($media_file, 'wb') or die('Permission error');
                                curl_setopt($ch, CURLOPT_FILE, $fp);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_exec($ch);
                                curl_close($ch);
                                fclose($fp);
                                //put image to relative folder to its owner such department
                                $path = Storage::putFile('public/news_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id, new File($media_file));
                                // create laravel symbolic link for this media
                                $path = URL::to('/') . '/' . str_replace('public', 'storage', $path);
                                $news['path'] = $path;


                                /**
                                 * ************************* VERY IMPORTANT
                                 * if for some reason can't get media of this news
                                 * use default image that MUST exist with this specific directory and name:
                                 * /storage/app/public/news_images/news_default_image.jpg
                                 * creating this default image is an INITIAL functionality :)
                                 */
                            } else { // image size is > 2MiB
                                $news['path'] = $default_image_dir;
                                $default_image = true;
                                $default_image_message = 'image file was too big';
                            }
                        } else { // media's extension is not acceptable for this functionality
                            $news['path'] = $default_image_dir;
                            $default_image = true;
                            $default_image_message = 'media extension was not acceptable : ' . $extension;
                        }
                    } else { // news have no media
                        $news['path'] = $default_image_dir;
                        $default_image = true;
                        $default_image_message = 'media file not found';
                    }
                    $cc->print_success('media url:', "\t");
                    dump($news['path']);
                    if ($default_image) {
                        $cc->print_warning("\t-> default image; " . $default_image_message);
                    }
                    News::create($news);
                }
            }
        }
        /**
         * scu portal have special structure and we don't need all information its provide;
         * so we use certain part of information which retrieved in "entry" key also
         * that's an array of news
         */
        elseif(isset($xml->entry)){
            $datas = $xml->entry;

            /** retrieve owner of the notice; for example: department */
            $model_name =  $external_service->owner_type;
            $model = new $model_name();
            $owner = $model::findOrFail($external_service->owner_id);

            dump('medias store on server for specific notice:');
            foreach ($datas as $data) {
                $default_image = false;
                $default_image_message = '';

                $news = [
                    'title' => strval($data->title),
                    'link' => strval(($data->link)[0]['href']),
                    'path' => strval(($data->link)[1]['href']),
                    'description' => strval($data->summary),
                    'author' => strval($data->author->name),
                    'owner_type' => $external_service->owner_type,
                    'owner_id' => $external_service->owner_id,
                ];

                /**
                 * check that this notice's owner has manager or not
                 * if not, use default user of the university created first of this procedure
                 */
                if(isset($owner)){
                    $manager = $owner->manager();
                    if (isset($manager)){
                        $news['creator_id'] = $owner->manager()->id;
                    } else {
                        $news['creator_id'] = $scu_user->id;
                    }
                } else {
                    $news['creator_id'] = $scu_user->id;
                }

                $news['description'] = str_replace("<br>", '\n', $news['description']);
                $news['description'] = str_replace("&nbsp;", ' ', $news['description']);

                /**
                 * identifier of each retrieved news is its "link" (id attribute in xml),
                 * so check out that in notices table to find out that is a new one or not
                 * if exist, there is nothing to do with this data,
                 * because existing news created using this procedure for sure
                 * and we don't care about update FOR NOW :)
                 */
                $check = News::where('link', $news['link'])->first();
                if (!isset($check)) { // if this news is a new one
                    if ($news['path'] != "") {// image exist

                        /**
                         * brief look at request header to check some details
                         * such as file size, extension and etc.
                         */
                        stream_context_set_default(array('http' => array('method' => 'HEAD')));
                        $head = array_change_key_case(get_headers($news['path'], 1));
                        $clen = isset($head['content-length']) ? $head['content-length'] : 0; // content-length of download (in bytes), read from Content-Length: field

                        if (!$clen) { // cannot retrieve file size, return "-1"
                            $clen = -1;
                        }

                        $pathinfo = pathinfo($news['path']);
                        /**
                         * < get media extension >
                         * extract substring after last '.' and remove possible parameters
                         * example:
                         * http://scu.ac.ir/documents/236544/0/etelaeiyeh-6.jpg?t=1568533120548
                         * http://scu.ac.ir/documents/236544/0/etelaeiyeh-6.    + jpg +     ?t=1568533120548
                         *                                              we need this^
                         */
                        $extension = explode( "?", $pathinfo['extension'])[0];

                        if(str_contains(strtolower($extension) , GeneralVariable::$inbound_acceptable_media)){ // acceptable extension such png and jpg
                            /** < get media size > */
                            if ($clen < 2097152) { // if media size < 2MiB

                                $name = 'tmp/news_tmp' . str_random(4) . '.tmp';
                                $ch = curl_init($news['path']);
                                $fp = fopen($name, 'wb') or die('Permission error');
                                curl_setopt($ch, CURLOPT_FILE, $fp);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_exec($ch);
                                curl_close($ch);
                                fclose($fp);
                                //put media to relative folder to its owner such department
                                $path = Storage::putFile('public/news_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id, new File($name));
                                // create laravel symbolic link for this media
                                $path = URL::to('/') . '/' . str_replace('public', 'storage', $path);
                                $news['path'] = $path;


                                /**
                                 * ************************* VERY IMPORTANT
                                 * if for some reason can't get media of this news
                                 * use default image that MUST exist with this specific directory and name:
                                 * /storage/app/public/news_images/news_default_image.jpg
                                 * creating this default image is an INITIAL functionality :)
                                 */
                            } else { // image size is > 2MiB
                                $news['path'] = $default_image_dir;
                                $default_image = true;
                                $default_image_message = 'image file was too big';
                            }
                        } else { // media's extension is not acceptable for this functionality
                            $news['path'] = $default_image_dir;
                            $default_image = true;
                            $default_image_message = 'media extension was not acceptable : '.$extension;
                        }
                    } else { // notice have no media
                        $news['path'] = $default_image_dir;
                        $default_image = true;
                        $default_image_message = 'media file not found';
                    }
                    $cc->print_success('media url:', "\t"); dump($news['path']); if ($default_image) { $cc->print_warning("\t-> default image; ". $default_image_message); }
                    News::create($news);
                }
            }
        }

        /**
         * < clear tmp directory >
         * delete all medias stored in in tmp directory due to put it to exact directory,
         * because all needed medias should stored to their exact directory before, and the others probably are dummy files
         */
        $files = glob('tmp/news_tmp*'); //get all file names
        if (sizeof($files) > 0) {
            $cc->print_warning('clean tmp directory:');
            foreach ($files as $file) {
                if (is_file($file))
                    unlink($file); //delete file
            }
            dump($files);
        } else {
            $cc->print_warning('no new media to store');
        }

        $cc->print_success("----------------------------------------------------------------------------------------\tretrieve " . $external_service->title . " done successfully.\n");
    }
});

function console_log()
{
    $js_code = 'console.log(' . json_encode(func_get_args(), JSON_HEX_TAG) .
        ');';
    $js_code = '<script>' . $js_code . '</script>';
    echo $js_code;
}

function xml2array($xml) {
    $arr = array();
    foreach ($xml as $element) {
        $tag = $element->getName();
        $e = get_object_vars($element);
        if (!empty($e)) {
            $arr[$tag] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
        }
        else {
            $arr[$tag] = trim($element);
        }
    }
    return $arr;
}




