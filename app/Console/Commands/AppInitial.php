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
            $passport_install_exitCode = Artisan::call('passport:install');
            $cc->print_success("========================================================================================\tpassport:install command done successfully.\n");

            $key_generate_exitCode = Artisan::call('key:generate');
            $cc->print_success("========================================================================================\tkey:generate command done successfully.\n");

            $storage_link_exitCode = Artisan::call('storage:link');
            $cc->print_success("========================================================================================\tstorage:link command done successfully.\n");

            $role_initial_exitCode = Artisan::call('role:initial');
            $cc->print_success("========================================================================================\trole:initial command done successfully.\n");

            $manage_level_initial_exitCode = Artisan::call('manage_level:initial');
            $cc->print_success("========================================================================================\tmanage_level:initial command done successfully.\n");

            $department_initial_exitCode = Artisan::call('department:initial');
            $cc->print_success("========================================================================================\tdepartment:initial command done successfully.\n");

            $user_initial_exitCode = Artisan::call('user:initial');
            $cc->print_success("========================================================================================\tuser:initial command done successfully.\n");

            $external_service_type_initial_exitCode = Artisan::call('external_service_type:initial');
            $cc->print_success("========================================================================================\texternal_service_type:initial command done successfully.\n");

            $ad_type_initial_exitCode = Artisan::call('ad_type:initial');
            $cc->print_success("========================================================================================\tad_type:initial command done successfully.\n");

            $book_edition_initial_exitCode = Artisan::call('book_edition:initial');
            $cc->print_success("========================================================================================\tbook_edition:initial command done successfully.\n");

            $book_language_initial_exitCode = Artisan::call('book_language:initial');
            $cc->print_success("========================================================================================\tbook_language:initial command done successfully.\n");

            $book_size_initial_exitCode = Artisan::call('book_size:initial');
            $cc->print_success("========================================================================================\tbook_size:initial command done successfully.\n");

            $category_initial_exitCode = Artisan::call('category:initial');
            $cc->print_success("========================================================================================\tcategory:initial command done successfully.\n");

            dump("initial procedure done successfully.");
        } catch (\Exception $e){
            $cc->print_error("\n\n\noops!");
            $cc->print_warning("initial procedure crash due to some problem with this error:");
            $cc->print_error($e->getMessage());

            if (!isset($passport_install_exitCode)) {
                $cc->print_help("the exception thrown by Passport Install logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            }
            elseif (!isset($key_generate_exitCode)) {
                $cc->print_help("the exception thrown by Key Generate logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            }
            elseif (!isset($storage_link_exitCode)) {
                $cc->print_help("the exception thrown by Storage Link logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
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
            elseif (!isset($manage_level_initial_exitCode)) {
                $cc->print_help("the exception thrown by ManageLevelInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            }
            elseif (!isset($department_initial_exitCode)) {
                $cc->print_help("the exception thrown by DepartmentInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            }
            elseif (!isset($user_initial_exitCode)) {
                $cc->print_help("the exception thrown by UserInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
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
            elseif (!isset($ad_type_initial_exitCode)) {
                $cc->print_help("the exception thrown by AdTypeInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            }
            elseif (!isset($book_edition_initial_exitCode)) {
                $cc->print_help("the exception thrown by BookEditionInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            }
            elseif (!isset($book_language_initial_exitCode)) {
                $cc->print_help("the exception thrown by BookLanguageInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            }
            elseif (!isset($book_size_initial_exitCode)) {
                $cc->print_help("the exception thrown by BookSizeInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            }
            elseif (!isset($category_initial_exitCode)) {
                $cc->print_help("the exception thrown by CategoryInitial logic at line " . $e->getLine() . " of\t" . str_after($e->getFile(), base_path()) . "\tfile, pls check that and try again");
                $cc->print_warning("do you want to see exception trace back?(y or n)");
                $c = fread(STDIN, 1);
                if ($c == 'y') {
                    var_dump($e->getTraceAsString());
                }
            }
        }
    }
}
