<?php

namespace App\Console\Commands;

use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Laravie\Parser\Xml\Reader;
use Orchestra\Parser\Xml\Document;
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
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $notice = [
//                'title' => 'asdasdas',
//                'link' => 'sadasdasda',
//                'path' => 'asdasdasdasd',
//                'description' => 'asdasdksdf',
//                'author' => 'asdasdas',
//                'published' => Carbon::now()->toDateTimeString(),
//                'updated' => Carbon::now()->toDateTimeString(),
//            ];

//        app('App\Http\Controllers\NoticeController')->repoCreate($notice);

        ini_set('max_execution_time', '1200'); // temporary set php execution limit time to 20 minutes
        dump("read data from notices api...");
        $input = collect((new Reader(new Document(new Container())))->load(env('NOTICE_LINK'))); // get XML data notices from SCU-API
        $datas = ((array) $input[$input->keys()[3]])['entry']; // fetch news from xml file and convert to array

        dump('images store on server for specific notice:');
        foreach ($datas as $data){

            $notice = [
                'title' => strval($data->title),
                'link' => strval(($data->link)[0]['href']),
                'path' => strval(($data->link)[1]['href']),
                'description' => strval($data->summary),
                'author' => strval($data->author->name),
            ];

            $notice['description'] = str_replace("<br>", '\n', $notice['description']);
            $notice['description'] = str_replace("&nbsp;", ' ', $notice['description']);

            $check = Notice::where('link', $notice['link'])->first();
            // find out that this news is a new one or not
            if(!isset($check)){ // if this notice is a new one

                //                      < get image size >
                stream_context_set_default(array('http' => array('method' => 'HEAD')));
                $head = array_change_key_case(get_headers($notice['path'], 1));
                $clen = isset($head['content-length']) ? $head['content-length'] : 0; // content-length of download (in bytes), read from Content-Length: field

                if (!$clen) { // cannot retrieve file size, return "-1"
                    $clen = -1;
                }
                //                      < get image size >

                if($clen < 2097152){ // if image size < 2MiB
                    $name = 'tmp/notices_tmp'.str_random(4).'.tmp';
                    $ch = curl_init($notice['path']);
                    $fp = fopen($name, 'wb') or die('Permission error');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_exec($ch);
                    curl_close($ch);
                    fclose($fp);

                    $path = Storage::putFile('public/notices_images', new File($name));
                    $path = URL::to('/').'/'.str_replace('public', 'storage', $path);
                    $notice['path'] = $path;
                    dump($notice['path']);
                } else {
                    $notice['path'] = Storage::url('notices_images/notice_default_image.jpg');
                    dump($notice['path']);
                }
                app('App\Http\Controllers\NoticeController')->repoCreate($notice);
            }
        }

        //                      < clear tmp directory >
        dump('clean tmp directory:');
        $files = glob('tmp/notices_tmp*'); //get all file names
        dump($files);
        foreach($files as $file){
            if(is_file($file))
                unlink($file); //delete file
        }
        //                      < clear tmp directory >

    }
}
