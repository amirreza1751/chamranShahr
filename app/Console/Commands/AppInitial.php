<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fill all relevant tables with basic records at the beginning';

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
            $user_initial_exitCode = Artisan::call('user:initial');
            $cc->print_success("========================================================================================\tuser:initial command done successfully.\n");

            $role_initial_exitCode = Artisan::call('role:initial');
            $cc->print_success("========================================================================================\trole:initial command done successfully.\n");

            $external_service_type_initial_exitCode = Artisan::call('external_service_type:initial');
            $cc->print_success("========================================================================================\texternal_service_type:initial command done successfully.\n");

            dump("initial procedure done successfully.");
        } catch (\Exception $e){
            $cc->print_error("\n\n\noops!");
            $cc->print_warning("initial procedure crash due to some problem with this error:");
            $cc->print_error($e->getMessage());
            if (!isset($user_initial_exitCode)) {
                $cc->print_help("the exception thrown by UserInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }

            }
            elseif (!isset($role_initial_exitCode)) {
                $cc->print_help("the exception thrown by RoleInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }

            }
            elseif (!isset($external_service_type_initial_exitCode)) {
                $cc->print_help("the exception thrown by ExternalServiceTypeInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }

            }
        }
    }
}
