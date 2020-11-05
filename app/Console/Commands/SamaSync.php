<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SamaSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sama:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'execute all commands needed for sync app with sama';

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
            $gender_fetch_exitCode = Artisan::call('gender:fetch');
            $cc->print_success("========================================================================================\tgender:fetch command done successfully.\n");

            $term_fetch_exitCode = Artisan::call('term:fetch');
            $cc->print_success("========================================================================================\tterm:fetch command done successfully.\n");

            $study_level_fetch_exitCode = Artisan::call('study_level:fetch');
            $cc->print_success("========================================================================================\tstudy_level:fetch command done successfully.\n");

            $study_status_fetch_exitCode = Artisan::call('study_status:fetch');
            $cc->print_success("========================================================================================\tstudy_status:fetch command done successfully.\n");

            $faculty_fetch_exitCode = Artisan::call('faculty:fetch');
            $cc->print_success("========================================================================================\tfaculty:fetch command done successfully.\n");

            $study_field_fetch_exitCode = Artisan::call('study_field:fetch');
            $cc->print_success("========================================================================================\tstudy_field:fetch command done successfully.\n");

            $study_area_fetch_exitCode = Artisan::call('study_area:fetch');
            $cc->print_success("========================================================================================\tstudy_area:fetch command done successfully.\n");

            dump("retrieve and synchronize all needed information between app and sama has done successfully.");
        } catch (\Exception $e){
            $cc->print_error("\n\n\noops!");
            $cc->print_warning("retrieve and synchronize procedure crash due to some problem with this error:");
            $cc->print_error($e->getMessage());

            if(!isset($gender_fetch_exitCode)){
                $cc->print_help("the exception thrown by GenderFetch logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }

            } elseif (!isset($term_fetch_exitCode)){
                $cc->print_help("the exception thrown by TermFetch logic at line " . $e->getLine() . ", pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            } elseif (!isset($study_level_fetch_exitCode)){
                $cc->print_help("the exception thrown by StudyLevelFetch logic at line " . $e->getLine() . ", pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            } elseif (!isset($study_status_fetch_exitCode)){
                $cc->print_help("the exception thrown by StudyStatusFetch logic at line " . $e->getLine() . ", pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            } elseif (!isset($faculty_fetch_exitCode)){
                $cc->print_help("the exception thrown by FacultyFetch logic at line " . $e->getLine() . ", pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            } elseif (!isset($study_field_fetch_exitCode)){
                $cc->print_help("the exception thrown by StudyFieldFetch logic at line " . $e->getLine() . ", pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            } elseif (!isset($study_area_fetch_exitCode)){
                $cc->print_help("the exception thrown by StudyAreaFetch logic at line " . $e->getLine() . ", pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            }
        }

    }
}
