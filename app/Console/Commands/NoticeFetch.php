<?php

namespace App\Console\Commands;

use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
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


        $input = collect((new Reader(new Document(new Container())))->load('http://scu.ac.ir/%D8%B5%D9%81%D8%AD%D9%87-%D8%A7%D8%B5%D9%84%DB%8C/-/asset_publisher/7z3VNzvtbJLj/rss?p_p_cacheability=cacheLevelPage')); // get XML data notices from SCU-API
        $datas = ((array) $input[$input->keys()[3]])['entry']; // fetch news from xml file and convert to array

        foreach (array_reverse($datas) as $data){

            //              data sample    2019-05-22T09:32:34Z
//            $t = strval($data->published);
//            $t = str_replace('T', ' ', $t);
//            $t = str_replace('Z', '', $t);
//            $published = \DateTime::createFromFormat('Y-m-d H:i:s', $t);
//
//
//            $t = strval($data->updated);
//            $t = str_replace('T', ' ', $t);
//            $t = str_replace('Z', '', $t);
//            $updated = \DateTime::createFromFormat('Y-m-d H:i:s', $t);

            $notice = [
                'title' => strval($data->title),
                'link' => strval(($data->link)[0]['href']),
                'path' => strval(($data->link)[1]['href']),
                'description' => strval($data->summary),
                'author' => strval($data->author->name),
            ];

            $data->description = str_replace('<br>', '', $data->description);
            $data->description = str_replace('&nbsp;', '', $data->description);

            $check = Notice::where('link', $notice['link'])->first();
            // find out that this news is a new one or not
            if(!isset($check)){ // if this notice is a new one
                app('App\Http\Controllers\NoticeController')->repoCreate($notice);
            }
            else {
                $check->description = str_replace('<br>', '', $check->description);
                $check->description = str_replace('&nbsp;', '', $check->description);

                if(strcmp(substr(strval($data->description), -100), substr(strval($check->description), -100)) != 0){ // if is not but
                    app('App\Http\Controllers\NoticeController')->repoCreate($notice);
                }
            }
        }
    }
}
