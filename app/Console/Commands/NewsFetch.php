<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralVariable;
use App\Models\ExternalService;
use App\Models\News;
use App\Models\Notice;
use App\Repositories\NewsRepository;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Weidner\Goutte\GoutteFacade;
use Illuminate\Container\Container;

class NewsFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'retrieve news information from SCU News rss';


    /** @var  NewsRepository */
    private $newsRepository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NewsRepository $newsRepo)
    {
        parent::__construct();

        $this->newsRepository = $newsRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        ini_set('max_execution_time', '1200'); // temporary set php execution limit time to 20 minutes
        $cc = new ConsoleColor();
        $default_image_dir = URL::to('/') . Storage::url('news_images/news_default_image.jpg');

        try {
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

            if(!isset($scu_user)){
                $cc->print_warning("default user that should created before not found for some reason.");
                $cc->print_error("this may cause some error during fetch procedure...");
                $cc->print_help("problem maybe be somewhere in user:initial command logic (according to my creators thoughts)");
                $cc->print_help("if you don't execute this command, so do it first and try again.");
                $cc->print_warning("do you want to continue anyway?(y or n)");
                $c = fread(STDIN, 1);
            } else {
                $c = 'y';
            }

            if ($c == 'y'){
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

                        dump('medias store on server for specific news:');
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
                                            $file_name = pathinfo(basename($path), PATHINFO_FILENAME); // file name
                                            $file_extension = pathinfo(basename($path), PATHINFO_EXTENSION); // file extension
                                            // retrieve the stored media
                                            $file = Storage::get($path);
                                            // create laravel symbolic link for this media
                                            $path = '/' . str_replace('public', 'storage', $path);
                                            $news['path'] = $path;

                                            $destinationPath = public_path('storage/news_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id);
                                            $img = Image::make($file);
                                            // create a thumbnail for the god sake because of OUR EXCELLENT INTERNET  :/
                                            $img->resize(100, 100, function ($constraint) {
                                                $constraint->aspectRatio();
                                            })->save($destinationPath.'/' . $file_name . '-thumbnail.' . $file_extension);



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
                                $this->newsRepository->create($news);
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

                        dump('medias store on server for specific news:');
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
                                            $file_name = pathinfo(basename($path), PATHINFO_FILENAME); // file name
                                            $file_extension = pathinfo(basename($path), PATHINFO_EXTENSION); // file extension
                                            // retrieve the stored media
                                            $file = Storage::get($path);
                                            // create laravel symbolic link for this media
                                            $path = URL::to('/') . '/' . str_replace('public', 'storage', $path);
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
                                            })->save($destinationPath.'/' . $file_name . '-thumbnail.' . $file_extension);

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
                                $this->newsRepository->create($news);
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

                $cc->print_success("========================================================================================\tnotice:initial command done successfully.\n");
            } else { // scu user not found
                $cc->print_error("\n\n\nfetch procedure canceled; check and try again.");
            }

        } catch (\Exception $e) {
            $cc->print_error("\n\n\noops!");
            $cc->print_warning("fetch procedure crash due to some problem with this error:");
            $cc->print_error($e->getMessage());
            $cc->print_help("the exception thrown at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
            $cc->print_warning("do you want to see exception trace back?(y or n)");
            $c = fread(STDIN, 1);
            if ($c == 'y') {
                var_dump($e->getTraceAsString());
            }
        }

        /**
         * **************************************************************************************************************
         * **************************************************************************************************************
         * **************************************************************************************************************
         * **************************************************************************************************************
         * **************************************************************************************************************
         * **************************************************************************************************************
         * **************************************************************************************************************
         */


    }

    public function str_contains_array($extension, $acceptables)
    {
        foreach ($acceptables as $acceptable){
            if(str_contains($extension, $acceptable))
                return true;
        }
        return false;
    }
}
