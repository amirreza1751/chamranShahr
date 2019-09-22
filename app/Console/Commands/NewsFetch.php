<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;
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
        $input = collect((new Reader(new Document(new Container())))->load(env('NEWS_LINK'))); // get XML data news from SCU-API
        $datas = ((array) $input[$input->keys()[3]])['item']; // fetch news from xml file and convert to array

        foreach (array_reverse($datas) as $data){
            $news = [
                'title' => $data->title,
                'link' => $data->link,
                'description' => $data->description,
            ];
            $check = News::where('link', $news['link'])->first();
            // find out that this news is a new one or not
            if(isset($check)){ // if this news is a new one
                $crawler = GoutteFacade::request('GET', 'http://scu.ac.ir/-/'.urlencode(str_replace('http://scu.ac.ir/-/', '',$news['link'])));
                $node = $crawler->filter('div.news-page-image > img')->first();
                $news['path'] = 'http://scu.ac.ir'.$node->attr('src');

                app('App\Http\Controllers\NewsController')->repoCreate($news);
            }
            else if(strcmp(substr(strval($data->description), -100), substr(strval($check->description), -100)) != 0){ // if is not but
                $crawler = GoutteFacade::request('GET', 'http://scu.ac.ir/-/'.urlencode(str_replace('http://scu.ac.ir/-/', '',$news['link'])));
                $node = $crawler->filter('div.news-page-image > img')->first();
                $news['path'] = 'http://scu.ac.ir'.$node->attr('src');

                app('App\Http\Controllers\NewsController')->repoCreate($news);
            }
        }
    }
}
