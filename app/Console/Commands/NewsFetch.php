<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Weidner\Goutte\GoutteFacade;
use Illuminate\Container\Container;
use Laravie\Parser\Xml\Reader;
use Orchestra\Parser\Xml\Document;

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
    protected $description = 'fetch news from XMLapi of SCU portal';

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
        ini_set('max_execution_time', '1200'); // temporary set php execution limit time to 20 minutes
        dump("read data from news api...");
        $input = collect((new Reader(new Document(new Container())))->load(env('NEWS_LINK'))); // get XML data news from SCU-API
        $datas = ((array) $input[$input->keys()[3]])['item']; // fetch news from xml file and convert to array

        dump('images store on server for specific news:');
        foreach (array_reverse($datas) as $data){

            $news = [
                'title' => $data->title,
                'link' => $data->link,
                'description' => $data->description,
            ];

            $news['description'] = str_replace("<br>", '\n', $news['description']);
            $news['description'] = str_replace("&nbsp;", ' ', $news['description']);

            $check = News::where('link', $news['link'])->first();
            if(!isset($check)){ // if this news is a new one

                //                      < scraping news link >
                $crawler = GoutteFacade::request('GET', 'http://scu.ac.ir/-/'.urlencode(str_replace('http://scu.ac.ir/-/', '',$news['link'])));
                $node = $crawler->filter('div.news-page-image > img')->first();
                $url = 'http://scu.ac.ir'.$node->attr('src');
                //                      < scraping news link >

                //                      < get image size >
                stream_context_set_default(array('http' => array('method' => 'HEAD')));
                $head = array_change_key_case(get_headers($url, 1));
                $clen = isset($head['content-length']) ? $head['content-length'] : 0; // content-length of download (in bytes), read from Content-Length: field

                if (!$clen) { // cannot retrieve file size, return "-1"
                    $clen = -1;
                }
                //                      < get image size >

                if($clen < 2097152){ // if image size < 2MiB
                    $name = 'tmp/news_tmp'.str_random(4).'.tmp';
                    $ch = curl_init($url);
                    $fp = fopen($name, 'wb') or die('Permission error');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_exec($ch);
                    curl_close($ch);
                    fclose($fp);

                    $path = Storage::putFile('public/news_images', new File($name));
                    $path = URL::to('/').'/'.str_replace('public', 'storage', $path);
                    $news['path'] = $path;
                    dump($news['path']);
                } else {
                    $news['path'] = Storage::url('news_images/news_default_image.jpg');
                    dump($news['path']);
                }
                app('App\Http\Controllers\NewsController')->repoCreate($news);
            }
        }

        //                      < clear tmp directory >
        dump('clean tmp directory:');
        $files = glob('tmp/news_tmp*'); //get all file names
        dump($files);
        foreach($files as $file){
            if(is_file($file))
                unlink($file); //delete file
        }
        //                      < clear tmp directory >
    }
}
