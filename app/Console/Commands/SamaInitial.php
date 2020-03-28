<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SamaInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sama:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fill all relevant tables with basic information before sync app with sama';

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
        $cc = new ConsoleColor();
        try {
            $manage_level_initial_exitCode = Artisan::call('manage_level:initial');
            $cc->print_success("========================================================================================\tgender:fetch command done successfully.\n");

            dump("initial procedure done successfully.");
        } catch (\Exception $e){
            $cc->print_error("\n\n\noops!");
            $cc->print_warning("initial procedure crash due to some problem with this error:");
            $cc->print_error($e->getMessage());
            if(!isset($gender_fetch_exitCode)){
                $cc->print_help("the exception thrown by GenderFetch logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }

            }
        }
    }
}