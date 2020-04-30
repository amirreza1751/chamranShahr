<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralVariable;
use App\Models\ExternalService;
use App\Models\Notice;
use App\Repositories\NoticeRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class NoticeFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notice:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'retrieve notices information from SCU Notice rss';


    /** @var  NoticeRepository */
    private $noticeRepository;

    /**
     * Create a new command instance.
     *
     * @param NoticeRepository $noticeRepo
     * @return void
     */
    public function __construct(NoticeRepository $noticeRepo)
    {
        parent::__construct();

        $this->noticeRepository = $noticeRepo;
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
        $default_image_dir = URL::to('/') . Storage::url('notices_images/notice_default_image.jpg');
        try {
            /**
             * get all external services which are notice type
             */
            $external_services = ExternalService::where('content_type', Notice::class)->get();

            /**
             * this user is the default user of the university created by UserInitial command at first
             * consist of special information,
             * and it use for specific functionality,
             * such as fill creator_id field of notices which retrieved from Scu portal using it's id
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

            if ($c == 'y') {

                foreach ($external_services as $external_service) {
                    dump("read data from SCU notice rss: " . $external_service->title . "...");
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
                     * so we use certain part of information which retrieved in "entry" key
                     * that's an array of notices
                     */
                    $datas = $xml->entry;

                    /** retrieve owner of the notice; for example: department */
                    $model_name = $external_service->owner_type;
                    $model = new $model_name();
                    $owner = $model::findOrFail($external_service->owner_id);

                    dump('medias store on server for specific notice:');
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


                        $notice['description'] = str_replace("<br>", '\n', $notice['description']);
                        $notice['description'] = str_replace("&nbsp;", ' ', $notice['description']);

                        /**
                         * identifier of each retrieved notice is its "link" (id attribute in xml),
                         * so check out that in notices table to find out that is a new one or not
                         */
                        $check = Notice::where('link', $notice['link'])->first();
                        if (!isset($check)) { // if this notice is a new one
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
                                $extension = explode("?", $pathinfo['extension'])[0];

                                if (str_contains(strtolower($extension), GeneralVariable::$inbound_acceptable_media)) { // acceptable extension such png and jpg
                                    /** < get media size > */
                                    if ($clen < 2097152) { // if media size < 2MiB

                                        $name = 'tmp/notices_tmp' . str_random(4) . '.tmp';
                                        $ch = curl_init($notice['path']);
                                        $fp = fopen($name, 'wb') or die('Permission error');
                                        curl_setopt($ch, CURLOPT_FILE, $fp);
                                        curl_setopt($ch, CURLOPT_HEADER, 0);
                                        curl_exec($ch);
                                        curl_close($ch);
                                        fclose($fp);
                                        //put media to relative folder to its owner such department
                                        $path = Storage::putFile('public/notices_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id, new File($name));
                                        // create laravel symbolic link for this media
                                        $path = URL::to('/') . '/' . str_replace('public', 'storage', $path);
                                        $notice['path'] = $path;


                                        /**
                                         * ************************* SO IMPORTANT
                                         * if for some reason can't get media of this notice
                                         * use default image that MUST exist with this specific directory and name:
                                         * /storage/app/public/notices_images/notice_default_image.jpg
                                         * creating this default image is an INITIAL functionality :)
                                         */
                                    } else { // media size is > 2MiB
                                        $notice['path'] = $default_image_dir;
                                        $default_image = true;
                                        $default_image_message = 'image file was too big';
                                    }
                                } else { // media's extension is not acceptable for this functionality
                                    $notice['path'] = $default_image_dir;
                                    $default_image = true;
                                    $default_image_message = 'media extension was not acceptable : ' . $extension;
                                }
                            } else { // notice have no media
                                $notice['path'] = $default_image_dir;
                                $default_image = true;
                                $default_image_message = 'media file not found';
                            }
                            $cc->print_success('media url:', "\t");
                            dump($notice['path']);
                            if ($default_image) {
                                $cc->print_warning("\t-> default image; " . $default_image_message);
                            }
                            $this->noticeRepository->create($notice);
                        }
                    }

                    /**
                     * < clear tmp directory >
                     * delete all medias stored in in tmp directory due to put it to exact directory,
                     * because all needed medias should stored to their exact directory before, and the others probably are dummy files
                     */
                    $files = glob('tmp/notices_tmp*'); //get all file names
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
                    //                      < clear tmp directory >

                    $cc->print_success("----------------------------------------------------------------------------------------\tretrieve " . $external_service->title . " done successfully.\n");
                }

                $cc->print_success("========================================================================================\tnews:initial command done successfully.\n");
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
    }
}
