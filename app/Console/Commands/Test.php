<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'for testing some functionality of app; changes every time, so check source before execution';

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
        $login_result = app('App\Http\Controllers\API\Sama\SamaAuthController')->sama_login();
        if ($login_result){
            dump('true');
        } else {
            dump('scan path: ' . base_path() . "\\" . 'config');
            print_r(scandir(base_path() . "\\" . 'config'));
            if (is_dir('scan path: ' . base_path() . "\\" . 'config\cookie')){
                dump('scan path: ' . base_path() . "\\" . 'config\\cookie');
                print_r(scandir(base_path() . "\\" . 'config\\cookie'));
            } else {
                error_log('there is no cookie dir');
            }
        }
    }
}
