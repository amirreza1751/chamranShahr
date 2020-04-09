<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
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
use Orchestra\Parser\Xml\Document;
use Orchestra\Parser\Xml\Reader;
use Weidner\Goutte\GoutteFacade;

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
        try {

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

            foreach ($external_services as $external_service) {
                dump("read data from SCU notice rss: " . $external_service->title . "...");
                dump("( URL:\t" . $external_service->url . " )");
                $app = new Container;
                $document = new Document($app);
                $reader = new Reader($document);
                $input = collect($reader->load($external_service->url)); // get XML data notices from SCU-API
//                $input = collect((new Reader(new Document(new Container())))->load($external_service->url)); // get XML data notices from SCU-API
                $datas = ((array)$input[$input->keys()[3]])['entry']; // fetch news from xml file and convert to array

                dump('images store on server for specific notice:');
                foreach ($datas as $data) {

                    $default_image = false;

                    $notice = [
                        'title' => strval($data->title),
                        'link' => strval(($data->link)[0]['href']),
                        'path' => strval(($data->link)[1]['href']),
                        'description' => strval($data->summary),
                        'author' => strval($data->author->name),
                        'creator_id' => $scu_user->id,
                        'owner_type' => $external_service->owner_type,
                        'owner_id' => $external_service->owner_id,
                    ];

                    $notice['description'] = str_replace("<br>", '\n', $notice['description']);
                    $notice['description'] = str_replace("&nbsp;", ' ', $notice['description']);

                    $check = Notice::where('link', $notice['link'])->first();
                    // find out that this news is a new one or not
                    if (!isset($check)) { // if this notice is a new one

                        if ($notice['path'] != "") {// image exist
                            //                      < get image size >
                            stream_context_set_default(array('http' => array('method' => 'HEAD')));
                            $head = array_change_key_case(get_headers($notice['path'], 1));
                            $clen = isset($head['content-length']) ? $head['content-length'] : 0; // content-length of download (in bytes), read from Content-Length: field

                            if (!$clen) { // cannot retrieve file size, return "-1"
                                $clen = -1;
                            }
                            //                      < get image size >

                            if ($clen < 2097152) { // if image size < 2MiB
                                $name = 'tmp/notices_tmp' . str_random(4) . '.tmp';
                                $ch = curl_init($notice['path']);
                                $fp = fopen($name, 'wb') or die('Permission error');
                                curl_setopt($ch, CURLOPT_FILE, $fp);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_exec($ch);
                                curl_close($ch);
                                fclose($fp);

                                $path = Storage::putFile('public/notices_images/' . app($external_service->owner_type)->getTable() . '/' . $external_service->owner_id, new File($name));
                                $path = URL::to('/') . '/' . str_replace('public', 'storage', $path);
                                $notice['path'] = $path;

                            } else { // image size is > 2MiB
                                $notice['path'] = URL::to('/') . Storage::url('notices_images/notice_default_image.jpg');
                                $default_image = true;
                            }
                        } else { // notice have no image
                            $notice['path'] = URL::to('/') . Storage::url('notices_images/notice_default_image.jpg');
                            $default_image = true;
                        }
                        $cc->print_success('image url:', "\t"); dump($notice['path']); if ($default_image) { $cc->print_warning("\t-> default image"); }
                        $this->noticeRepository->create($notice);
                    }
                }

                //                      < clear tmp directory >
                $files = glob('tmp/notices_tmp*'); //get all file names
                if (sizeof($files) > 0) {
                    $cc->print_warning('clean tmp directory:');
                    dump($files);
                    foreach ($files as $file) {
                        if (is_file($file))
                            unlink($file); //delete file
                    }
                } else {
                    $cc->print_warning('no new image to store');
                }
                //                      < clear tmp directory >

                $cc->print_success("----------------------------------------------------------------------------------------\tretrieve " . $external_service->title . " done successfully.\n");
            }

            $cc->print_success("========================================================================================\tnotice:initial command done successfully.\n");
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
