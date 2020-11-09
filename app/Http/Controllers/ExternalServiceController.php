<?php

namespace App\Http\Controllers;

use App\General\ConsoleColor;
use App\General\GeneralVariable;
use App\Http\Requests\CreateExternalServiceRequest;
use App\Http\Requests\UpdateExternalServiceRequest;
use App\Models\Department;
use App\Models\ExternalService;
use App\Models\ExternalServiceType;
use App\Models\News;
use App\Models\Notice;
use App\Repositories\ExternalServiceRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\NewsRepository;
use App\Repositories\NoticeRepository;
use App\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Exception\NotFoundException;
use Intervention\Image\Facades\Image;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Symfony\Component\Console\Output\ConsoleOutput;
use Weidner\Goutte\GoutteFacade;

class ExternalServiceController extends AppBaseController
{
    /** @var  ExternalServiceRepository */
    private $externalServiceRepository;
    /** @var  NewsRepository */
    private $newsRepository;
    /** @var  NoticeRepository */
    private $noticeRepository;
    private $content_types = [
        'اطلاعیه' => Notice::class,
        'خبر' => News::class,
    ];
    private $owner_types = [
        'دپارتمان' => Department::class,
    ];

    public function __construct(ExternalServiceRepository $externalServiceRepo, NewsRepository $newsRepo, NoticeRepository $noticeRepo)
    {
        $this->externalServiceRepository = $externalServiceRepo;
        $this->newsRepository = $newsRepo;
        $this->noticeRepository = $noticeRepo;
    }

    /**
     * Display a listing of the ExternalService.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->externalServiceRepository->pushCriteria(new RequestCriteria($request));


        if (Auth::user()->hasRole('developer')) {
            $externalServices = $this->externalServiceRepository->all();
        } elseif (Auth::user()->hasRole('admin')) {
            $externalServices = $this->externalServiceRepository->all();
        } elseif (Auth::user()->hasRole('content_manager')) {
            $externalServices = $this->externalServiceRepository->all();
        } else {
            $externalServices = collect();
            $manage_histories = Auth::user()->under_managment();
            foreach ($manage_histories as $manage_history) {
                if (isset($manage_history->managed)) {
                    $department = Department::where('id', $manage_history->managed->id)->first();
                    if (isset($department)){
                        foreach ($department->externalServices as $externalService){
                            $externalServices->push($externalService);
                        }
                    }
                }
            }
        }

        return view('external_services.index')
            ->with('externalServices', $externalServices);
    }

    /**
     * Show the form for creating a new ExternalService.
     *
     * @return Response
     */
    public function create()
    {
        return view('external_services.create')
            ->with('external_service_types', ExternalServiceType::all()->pluck('title', 'id'))
            ->with('content_types', $this->content_types)
            ->with('owner_types', $this->owner_types);
    }

    /**
     * Store a newly created ExternalService in storage.
     *
     * @param CreateExternalServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateExternalServiceRequest $request)
    {
        $input = $request->all();

        $externalService = $this->externalServiceRepository->create($input);

        Flash::success('سرویس خارجی با موفقیت ذخیره شد');

        return redirect(route('externalServices.index'));
    }

    /**
     * Display the specified ExternalService.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $externalService = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($externalService)) {
            Flash::error('سرویس خارجی وجود ندارد');

            return redirect(route('externalServices.index'));
        }

        return view('external_services.show')->with('externalService', $externalService);
    }

    /**
     * Show the form for editing the specified ExternalService.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $external_service = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($external_service)) {
            Flash::error('سرویس خارجی وجود ندارد');

            return redirect(route('externalServices.index'));
        }

        return view('external_services.edit')->with('external_service', $external_service)
            ->with('external_service_types', ExternalServiceType::all()->pluck('title', 'id'))
            ->with('content_types', $this->content_types)
            ->with('owner_types', $this->owner_types);
    }

    /**
     * Update the specified ExternalService in storage.
     *
     * @param  int              $id
     * @param UpdateExternalServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExternalServiceRequest $request)
    {
        $externalService = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($externalService)) {
            Flash::error('سرویس خارجی وجود ندارد');

            return redirect(route('externalServices.index'));
        }

        $externalService = $this->externalServiceRepository->update($request->all(), $id);

        Flash::success('سرویس خارجی باموفقیت ویرایش شد');

        return redirect(route('externalServices.index'));
    }

    /**
     * Remove the specified ExternalService from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $externalService = $this->externalServiceRepository->findWithoutFail($id);

        if (empty($externalService)) {
            Flash::error('سرویس خارجی وجود ندارد');

            return redirect(route('externalServices.index'));
        }

        $this->externalServiceRepository->delete($id);

        Flash::success('سرویس خارجی باموفقیت حذف شد');

        return redirect(route('externalServices.index'));
    }

    public function ajaxOwner(Request $request)
    {

        $external_service = ExternalService::find($request->id);
        $model_name =  $request['model_name'];
        $model = new $model_name();
        $models = collect();

        if (Auth::user()->hasRole('developer')) {
            $models = $model::all();
        } elseif (Auth::user()->hasRole('admin')) {
            $models = $model::all();
        } elseif (Auth::user()->hasRole('content_manager')) {
            $models = $model::all();
        } elseif(Auth::user()->hasRole('manager')) {
            $manage_histories = Auth::user()->under_managment();
            foreach ($manage_histories as $manage_history) {
                if (isset($manage_history->managed)) {
                    $model = $model_name::where('id', $manage_history->managed->id)->first();
                    if (isset($model)){
                        $models->push($model);
                    }
                }
            }
        }

        foreach ($models as $model){
            if (isset($external_service)){
                if ($external_service->owner_type == $model_name && $external_service->owner_id == $model->id){
                    $model['selected'] = true;
                }
            }
        }
        return $models;
    }

    public function fetch($id)
    {
        $external_service = ExternalService::find($id);
        $cc = new ConsoleColor();
        if(isset($external_service)){
            ini_set('max_execution_time', '1200'); // temporary set php execution limit time to 20 minutes
            try {
                /**
                 * this user is the default user of the university created by UserInitial command at first
                 * consist of special information,
                 * and it use for specific functionality,
                 * such as fill creator_id field of news which retrieved from Scu portal using it's id
                 */
                $scu_user = User::where('scu_id', 'scu')
                    ->where('national_id', 'scu')
                    ->where('username', 'scu')->first();

                if(!isset($scu_user)){
                    Flash::error('متاسفانه یک مشکل فنی در فرایند بروزرسانی به وجود آمده است. لطفا جهت کسب اطلاع بیشتر با مدیریت سامانه ارتباط برقرار کنید.');
//                    $cc->print_warning("default user that should created before, not found for some reason.");
//                    $cc->print_error("this may cause some error during fetch procedure...");
//                    $cc->print_help("problem maybe be somewhere in user:initial command logic (according to my creators thoughts)");
//                    $cc->print_help("if you don't execute this command, so do it first and try again.");
//                    $cc->print_warning("do you want to continue anyway?(y or n)");
//                    $c = fread(STDIN, 1);
                } else {
                    $c = 'y';
                }

                if ($c == 'y'){
//                    dump("read data from external service: " . $external_service->title . "...");
//                    dump("( URL: " . $external_service->url . " )");

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $external_service->url);
                    $xml = curl_exec($ch);  // get xml content of this service rss url
                    curl_close($ch);

                    $xml = simplexml_load_string($xml);

                    if ($external_service->content_type == News::class){
                        /**
                         * scu portal have special structure and we don't need all information its provide;
                         * so we use certain part of information which retrieved in "item" key
                         * that's an array of news
                         */
                        if(isset($xml->item)) {
                            $datas = $xml->item;

                            /** retrieve owner of the news; for example: department */
                            $model_name =  $external_service->owner_type;
                            $model = new $model_name();
                            $owner = $model::findOrFail($external_service->owner_id);

//                        dump('medias store on server for specific news:');
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

                                foreach ($news as $key => $value){
                                    $news[$key] = strip_tags($value);
                                }

                                /**
                                 * validate title field
                                 */
                                $validator = Validator::make($news, [
                                    'title' => 'nullable|string|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($news['title']);
                                }

                                /**
                                 * validate link field
                                 */
                                $validator = Validator::make($news, [
                                    'link' => 'nullable|url|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($news['link']);
                                }

                                /**
                                 * validate description field
                                 */
                                $validator = Validator::make($news, [
                                    'path' => 'nullable|url|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($news['path']);
                                }

                                /**
                                 * validate description field
                                 */
                                $validator = Validator::make($news, [
                                    'description' => 'nullable|string',
                                ]);
                                if ($validator->fails()) {
                                    unset($news['description']);
                                }

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

                                $news['description'] = str_replace("&nbsp;", '', $news['description']);
                                $news['description'] = trim(strip_tags($news['description']));
                                /**
                                 * identifier of each retrieved news is its "link" (id attribute in xml),
                                 * so check out that in news table to find out that is a new one or not
                                 */
                                $check = News::where('link', $news['link'])->first();
                                if (!isset($check)) { // if this news is a new one
                                    if (isset($new['path'])){
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

                                            $pathinfo = pathinfo($news['path']);
                                            /**
                                             * < get media extension >
                                             * extract substring after last '.' and remove possible parameters
                                             * example:
                                             * http://scu.ac.ir/documents/236544/0/etelaeiyeh-6.jpg?t=1568533120548
                                             * http://scu.ac.ir/documents/236544/0/etelaeiyeh-6.    + jpg +     ?t=1568533120548
                                             *                                              we need this^
                                             */
                                            if (isset($pathinfo['extension'])){
                                                $extension = explode( "?", $pathinfo['extension'])[0];
                                            }

                                            if(isset($extension) && str_contains(strtolower($extension) , GeneralVariable::$inbound_acceptable_media)){ // acceptable extension such png and jpg
                                                /** < get media size > */
                                                if ($clen < 2097152) { // if image size < 2MiB

                                                    $media_file = base_path().'/tmp/news_tmp' . str_random(4) . '.tmp';
                                                    $ch = curl_init($news['path']);
                                                    $fp = fopen($media_file, 'wb') or die('Permission error');
                                                    curl_setopt($ch, CURLOPT_FILE, $fp);
                                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                                    curl_exec($ch);
                                                    curl_close($ch);
                                                    fclose($fp);

                                                    /**
                                                     * validate image file
                                                     */
                                                    $validator = Validator::make(['img' => new File($media_file)], [
                                                        'img' => 'image|mimes:jpg,jpeg,png|max:2048',
                                                    ]);
                                                    if (!$validator->fails()) {
                                                        //put image to relative folder to its owner such department
                                                        $path = Storage::putFile('public/news_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id, new File($media_file));
                                                        $file_name = pathinfo(basename($path), PATHINFO_FILENAME); // file name
                                                        $file_extension = pathinfo(basename($path), PATHINFO_EXTENSION); // file extension
                                                        // retrieve the stored media
                                                        $file = Storage::get($path);
                                                        // create laravel symbolic link for this media
                                                        $path = '/' . str_replace('public', 'storage', $path);
                                                        $news['path'] = $path;

                                                        $img = Image::make($file);
                                                        // create a thumbnail for the god sake because of OUR EXCELLENT INTERNET  :/
                                                        $img->resize(100, 100, function ($constraint) {
                                                            $constraint->aspectRatio();
                                                        })->save(public_path('storage/news_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id . '/' . $file_name . '-thumbnail.' . $file_extension));
                                                    } else { // image is invalid
                                                        unset($news['path']);
                                                        $default_image = true;
                                                        $default_image_message = 'image file was invalid';
                                                    }


                                                    /**
                                                     * ************************* VERY IMPORTANT
                                                     * if for some reason can't get media of this news
                                                     * use default image that MUST exist with this specific directory and name:
                                                     * /storage/app/public/news_images/news_default_image.jpg
                                                     * creating this default image is an INITIAL functionality :)
                                                     */
                                                } else { // image size is > 2MiB
//                                            $news['path'] = $default_image_dir;
                                                    unset($news['path']);
                                                    $default_image = true;
                                                    $default_image_message = 'image file was too big';
                                                }
                                            } else { // media's extension is not acceptable for this functionality
                                                unset($news['path']);
                                                $default_image = true;
                                                $default_image_message = 'media extension was not acceptable : ' . $extension;
                                            }
                                        } else { // news have no media
                                            unset($news['path']);
                                            $default_image = true;
                                            $default_image_message = 'media file not found';
                                        }
                                    } else { // image is invalid
                                        $default_image = true;
                                        $default_image_message = 'image file was invalid';
                                    }
//                                    $cc->print_success('media url:', "\t");
                                    if(isset($news['path'])){
//                                    dump($news['path']);
                                    }
                                    if ($default_image) {
//                                        $cc->print_warning("\t-> default image; " . $default_image_message);
                                    }
                                    $this->newsRepository->create($news);
                                }
                            }

                            Flash::success('سرویس خارجی با موفقیت به روز رسانی شد');
                        }
                        /**
                         * scu portal have special structure and we don't need all information its provide;
                         * so we use certain part of information which retrieved in "entry" key also
                         * that's an array of news
                         */
                        elseif(isset($xml->entry)){
                            $datas = $xml->entry;

                            /** retrieve owner of the news; for example: department */
                            $model_name =  $external_service->owner_type;
                            $model = new $model_name();
                            $owner = $model::findOrFail($external_service->owner_id);

//                        dump('medias store on server for specific news:');
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

                                foreach ($news as $key => $value){
                                    $news[$key] = strip_tags($value);
                                    $news[$key] = str_replace("&nbsp;", '', $value);
                                }

                                /**
                                 * validate title field
                                 */
                                $validator = Validator::make($news, [
                                    'title' => 'nullable|string|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($news['title']);
                                }

                                /**
                                 * validate link field
                                 */
                                $validator = Validator::make($news, [
                                    'link' => 'nullable|url|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($news['link']);
                                }

                                /**
                                 * validate description field
                                 */
                                $validator = Validator::make($news, [
                                    'path' => 'nullable|url|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($news['path']);
                                }

                                /**
                                 * validate description field
                                 */
                                $validator = Validator::make($news, [
                                    'description' => 'nullable|string',
                                ]);
                                if ($validator->fails()) {
                                    unset($news['description']);
                                }

                                /**
                                 * validate author field
                                 */
                                $validator = Validator::make($news, [
                                    'author' => 'nullable|string|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($news['author']);
                                }

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

                                /**
                                 * identifier of each retrieved news is its "link" (id attribute in xml),
                                 * so check out that in news table to find out that is a new one or not
                                 * if exist, there is nothing to do with this data,
                                 * because existing news created using this procedure for sure
                                 * and we don't care about update FOR NOW :)
                                 */
                                $check = News::where('link', $news['link'])->first();
                                if (!isset($check)) { // if this news is a new one
                                    if (isset($news['path'])){
                                        if (filter_var($news['path'], FILTER_VALIDATE_URL)) {// image exist

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
                                            if (isset($pathinfo['extension'])){
                                                $extension = explode( "?", $pathinfo['extension'])[0];
                                            }

                                            if(isset($extension) && $this->str_contains_array(strtolower($extension) , GeneralVariable::$inbound_acceptable_media)){ // acceptable extension such png and jpg
                                                /** < get media size > */
                                                if ($clen < 2097152) { // if media size < 2MiB

                                                    $name = base_path().'/tmp/news_tmp' . str_random(4) . '.tmp';
                                                    $ch = curl_init($news['path']);
                                                    $fp = fopen($name, 'wb') or die('Permission error');
                                                    curl_setopt($ch, CURLOPT_FILE, $fp);
                                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                                    curl_exec($ch);
                                                    curl_close($ch);
                                                    fclose($fp);

                                                    /**
                                                     * validate image file
                                                     */
                                                    $validator = Validator::make(['img' => new File($name)], [
                                                        'img' => 'image|mimes:jpg,jpeg,png|max:2048',
                                                    ]);
                                                    if (!$validator->fails()) {
                                                        //put media to relative folder to its owner such department
                                                        $path = Storage::putFile('public/news_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id, new File($name));
                                                        $file_name = pathinfo(basename($path), PATHINFO_FILENAME); // file name
                                                        $file_extension = pathinfo(basename($path), PATHINFO_EXTENSION); // file extension
                                                        // retrieve the stored media
                                                        $file = Storage::get($path);
                                                        // create laravel symbolic link for this media
                                                        $path = '/' . str_replace('public', 'storage', $path);
                                                        $news['path'] = $path;

                                                        /**
                                                         * create thumbnail of the original image
                                                         * this image will store with a postfix '-thumbnail' beside the original image
                                                         */
                                                        $destinationPath = public_path('storage/news_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id);
                                                        $img = Image::make($file);
                                                        // create a thumbnail for the god sake because of OUR EXCELLENT INTERNET  :/
                                                        $img->resize(100, 100, function ($constraint) {
                                                            $constraint->aspectRatio();
                                                        })->save(public_path('storage/news_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id . '/' . $file_name . '-thumbnail.' . $file_extension));
                                                    } else { // image is invalid
                                                        unset($news['path']);
                                                        $default_image = true;
                                                        $default_image_message = 'image file was invalid';
                                                    }
                                                    /**
                                                     * ************************* VERY IMPORTANT
                                                     * if for some reason can't get media of this news
                                                     * use default image that MUST exist with this specific directory and name:
                                                     * /storage/app/public/news_images/news_default_image.jpg
                                                     * creating this default image is an INITIAL functionality :)
                                                     */
                                                } else { // image size is > 2MiB
                                                    unset($news['path']);
                                                    $default_image = true;
                                                    $default_image_message = 'image file was too big';
                                                }
                                            } else { // media's extension is not acceptable for this functionality
                                                unset($news['path']);
                                                $default_image = true;
                                                $default_image_message = 'media extension was not acceptable : '.$extension;
                                            }
                                        } else { // news have no media
                                            unset($news['path']);
                                            $default_image = true;
                                            $default_image_message = 'media file not found';
                                        }
                                    } else { // image is invalid
                                        $default_image = true;
                                        $default_image_message = 'image file was invalid';
                                    }
//                                    $cc->print_success('media url:', "\t");
                                    if (isset($news['path'])){
//                                    dump($news['path']);
                                    }
                                    if ($default_image) {
//                                        $cc->print_warning("\t-> default image; ". $default_image_message);
                                    }
                                    $this->newsRepository->create($news);
                                }
                            }

                            Flash::success('سرویس خارجی با موفقیت به روز رسانی شد');

                        } else {
                            Flash::error('متاسفانه یک مشکل فنی در فرایند بروزرسانی به وجود آمده است. لطفا جهت کسب اطلاع بیشتر با مدیریت سامانه ارتباط برقرار کنید. کد خطا: ExSeFetch101');
                        }

                        /**
                         * < clear tmp directory >
                         * delete all medias stored in in tmp directory due to put it to exact directory,
                         * because all needed medias should stored to their exact directory before, and the others probably are dummy files
                         */
                        $files = glob(base_path().'/tmp/news_tmp*'); //get all file names
                        if (sizeof($files) > 0) {
//                            $cc->print_warning('clean tmp directory:');
                            foreach ($files as $file) {
                                if (is_file($file))
                                    unlink($file); //delete file
                            }
//                        dump($files);
                        } else {
//                            $cc->print_warning('no new media to store');
                        }
                    }
                    elseif ($external_service->content_type == Notice::class){

                        if (isset($xml->entry)){
                            /**
                             * scu portal have special structure and we don't need all information its provide;
                             * so we use certain part of information which retrieved in "entry" key
                             * that's an array of notices
                             */
                            $datas = $xml->entry;

                            /** retrieve owner of the notice; for example: department */
                            $model_name = $external_service->owner_type;
                            $model = new $model_name();
                            $owner = $model::findOrFail($external_service->owner_id);

//                        dump('medias store on server for specific notice:');
                            foreach ($datas as $data) {
                                $default_image = false;
                                $default_image_message = '';

                                $notice = [
                                    'title' => strval($data->title),
                                    'link' => strval(($data->link)[0]['href']),
                                    'path' => strval(($data->link)[1]['href']),
                                    'description' => strval($data->summary),
                                    'author' => strval($data->author->name),
                                    'owner_type' => $external_service->owner_type,
                                    'owner_id' => $external_service->owner_id,
                                ];

                                foreach ($notice as $key => $value){
                                    $notice[$key] = strip_tags($value);
                                    $notice[$key] = str_replace("&nbsp;", '', $value);
                                }

                                /**
                                 * validate title field
                                 */
                                $validator = Validator::make($notice, [
                                    'title' => 'nullable|string|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($notice['title']);
                                }

                                /**
                                 * validate link field
                                 */
                                $validator = Validator::make($notice, [
                                    'link' => 'nullable|url|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($notice['link']);
                                }

                                /**
                                 * validate description field
                                 */
                                $validator = Validator::make($notice, [
                                    'path' => 'nullable|url|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($notice['path']);
                                }

                                /**
                                 * validate description field
                                 */
                                $validator = Validator::make($notice, [
                                    'description' => 'nullable|string',
                                ]);
                                if ($validator->fails()) {
                                    unset($notice['description']);
                                }

                                /**
                                 * validate author field
                                 */
                                $validator = Validator::make($notice, [
                                    'author' => 'nullable|string|max:191',
                                ]);
                                if ($validator->fails()) {
                                    unset($notice['author']);
                                }

                                /**
                                 * check that this notice's owner has manager or not
                                 * if not, use default user of the university created first of this procedure
                                 */
                                if (isset($owner)) {
                                    $manager = $owner->manager();
                                    if (isset($manager)) {
                                        $notice['creator_id'] = $owner->manager()->id;
                                    } else {
                                        $notice['creator_id'] = $scu_user->id;
                                    }
                                } else {
                                    $notice['creator_id'] = $scu_user->id;
                                }

                                /**
                                 * identifier of each retrieved notice is its "link" (id attribute in xml),
                                 * so check out that in notices table to find out that is a new one or not
                                 * if exist, there is nothing to do with this data,
                                 * because existing notice created using this procedure for sure
                                 * and we don't care about update FOR NOW :)
                                 */
                                $check = Notice::where('link', $notice['link'])->first();
                                if (!isset($check)) { // if this notice is a new one
                                    if(isset($notice['path'])){
                                        if ($notice['path'] != "") {// image exist

                                            /**
                                             * brief look at request header to check some details
                                             * such as file size, extension and etc.
                                             */
                                            stream_context_set_default(array('http' => array('method' => 'HEAD')));
                                            $head = array_change_key_case(get_headers($notice['path'], 1));
                                            $clen = isset($head['content-length']) ? $head['content-length'] : 0; // content-length of download (in bytes), read from Content-Length: field

                                            if (!$clen) { // cannot retrieve file size, return "-1"
                                                $clen = -1;
                                            }

                                            $pathinfo = pathinfo($notice['path']);
                                            /**
                                             * < get media extension >
                                             * extract substring after last '.' and remove possible parameters
                                             * example:
                                             * http://scu.ac.ir/documents/236544/0/etelaeiyeh-6.jpg?t=1568533120548
                                             * http://scu.ac.ir/documents/236544/0/etelaeiyeh-6.    + jpg +     ?t=1568533120548
                                             *                                              we need this^
                                             */
                                            if (isset($pathinfo['extension'])) {
                                                $extension = explode("?", $pathinfo['extension'])[0];
                                            }

                                            if (isset($extension) && $this->str_contains_array(strtolower($extension), GeneralVariable::$inbound_acceptable_media)) { // acceptable extension such png and jpg
                                                /** < get media size > */
                                                if ($clen < 2097152) { // if media size < 2MiB

                                                    $name = base_path().'/tmp/notices_tmp' . str_random(4) . '.tmp';
                                                    $ch = curl_init($notice['path']);
                                                    $fp = fopen($name, 'wb') or die('Permission error');
                                                    curl_setopt($ch, CURLOPT_FILE, $fp);
                                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                                    curl_exec($ch);
                                                    curl_close($ch);
                                                    fclose($fp);

                                                    /**
                                                     * validate image file
                                                     */
                                                    $validator = Validator::make(['img' => new File($name)], [
                                                        'img' => 'image|mimes:jpg,jpeg,png|max:2048',
                                                    ]);
                                                    if (!$validator->fails()) {
                                                        //put media to relative folder to its owner such department
                                                        $path = Storage::putFile('public/notices_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id, new File($name));
                                                        $file_name = pathinfo(basename($path), PATHINFO_FILENAME); // file name
                                                        $file_extension = pathinfo(basename($path), PATHINFO_EXTENSION); // file extension
                                                        // retrieve the stored media
                                                        $file = Storage::get($path);
                                                        // create laravel symbolic link for this media
                                                        $path = '/' . str_replace('public', 'storage', $path);
                                                        $notice['path'] = $path;

                                                        /**
                                                         * create thumbnail of the original image
                                                         * this image will store with a postfix '-thumbnail' beside the original image
                                                         */
                                                        $destinationPath = public_path('storage/notices_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id);
                                                        $img = Image::make($file);
                                                        // create a thumbnail for the god sake because of OUR EXCELLENT INTERNET  :/
                                                        $img->resize(100, 100, function ($constraint) {
                                                            $constraint->aspectRatio();
                                                        })->save('storage/notices_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id . '/' . $file_name . '-thumbnail.' . $file_extension);
                                                    } else { // image is invalid
                                                        unset($notice['path']);
                                                        $default_image = true;
                                                        $default_image_message = 'image file was invalid';
                                                    }

                                                    /**
                                                     * ************************* SO IMPORTANT
                                                     * if for some reason can't get media of this notice
                                                     * use default image that MUST exist with this specific directory and name:
                                                     * /storage/app/public/notices_images/notice_default_image.jpg
                                                     * creating this default image is an INITIAL functionality :)
                                                     */
                                                } else { // media size is > 2MiB
                                                    unset($notice['path']);
                                                    $default_image = true;
                                                    $default_image_message = 'image file was too big';
                                                }
                                            } else { // media's extension is not acceptable for this functionality
                                                unset($notice['path']);
                                                $default_image = true;
                                                $default_image_message = 'media extension was not acceptable : ' . $extension;
                                            }
                                        } else { // notice have no media
                                            unset($notice['path']);
                                            $default_image = true;
                                            $default_image_message = 'media file not found';
                                        }
                                    } else { // image is invalid=
                                        $default_image = true;
                                        $default_image_message = 'image file was invalid';
                                    }
//                                $cc->print_success('media url:', "\t");
                                    if (isset($notice['path'])){
//                                    dump($notice['path']);
                                    }
                                    if ($default_image) {
//                                    $cc->print_warning("\t-> default image; " . $default_image_message);
                                    }
                                    $this->noticeRepository->create($notice);
                                }
                            }

                            Flash::success('سرویس خارجی با موفقیت به روز رسانی شد');
                        }
                        else {
                            Flash::error('متاسفانه یک مشکل فنی در فرایند بروزرسانی به وجود آمده است. لطفا جهت کسب اطلاع بیشتر با مدیریت سامانه ارتباط برقرار کنید. کد خطا: ExSeFetch101');
                        }



                        /**
                         * < clear tmp directory >
                         * delete all medias stored in in tmp directory due to put it to exact directory,
                         * because all needed medias should stored to their exact directory before, and the others probably are dummy files
                         */
                        $files = glob(base_path().'/tmp/notices_tmp*'); //get all file names
                        if (sizeof($files) > 0) {
//                            $cc->print_warning('clean tmp directory:');
                            foreach ($files as $file) {
                                if (is_file($file))
                                    unlink($file); //delete file
                            }
//                        dump($files);
                        } else {
//                            $cc->print_warning('no new media to store');
                        }
                    }
                    else {
                        Flash::error('متاسفانه یک مشکل فنی در فرایند بروزرسانی به وجود آمده است. لطفا جهت کسب اطلاع بیشتر با مدیریت سامانه ارتباط برقرار کنید. کد خطا: ExSeFetch102');
                    }

//                    $cc->print_success("----------------------------------------------------------------------------------------\tretrieve " . $external_service->title . " done successfully.\n");
                } else { // scu user not found
//                    $cc->print_error("\n\n\nfetch procedure canceled; check and try again.");
                    Flash::error('متاسفانه یک مشکل فنی در فرایند بروزرسانی به وجود آمده است. لطفا جهت کسب اطلاع بیشتر با مدیریت سامانه ارتباط برقرار کنید. کد خطا: ExSeFetch103');
                }

            } catch (\Exception $e) {
                Flash::error('متاسفانه یک مشکل فنی در فرایند بروزرسانی به وجود آمده است. لطفا جهت کسب اطلاع بیشتر با مدیریت سامانه ارتباط برقرار کنید. کد خطا: ExSeFetch104');
//                dump($e->getMessage());
//                dump($e->getLine());
//                dump($e->getTrace());
//                return;
//                $cc->print_error("\n\n\noops!");
//                $cc->print_warning("fetch procedure crash due to some problem with this error:");
//                $cc->print_error($e->getMessage());
//                $cc->print_help("the exception thrown at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
//                $cc->print_warning("do you want to see exception trace back?(y or n)");
//                $c = fread(STDIN, 1);
//                if ($c == 'y') {
////                    var_dump($e->getTraceAsString());
//                }
            }
        } else {
            Flash::error('سرویس خارجی وجود ندارد');
        }

        if ($external_service->content_type == News::class)
            return redirect(route('news.index'));
        else
            return redirect(route('notices.index'));


    }

    public function str_contains_array($extension, $acceptables)
    {
        foreach ($acceptables as $acceptable) {
            if (str_contains($extension, $acceptable))
                return true;
        }
        return false;
    }
}
