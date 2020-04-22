<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralFunction;
use App\User;
use Illuminate\Console\Command;

class UserInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fill users table with basic records';

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
        $gf = new GeneralFunction();
        $cc->print_error("this procedure will truncate users table which may permanently delete some records, also affected some other functionality relative to user_levels and other tables!\nDo you want to continue? (pls type\t\tHellYeah\t\tto continue or anything to skip)");
        $answer = trim(fgets(STDIN));
        if ($answer == 'HellYeah') {

//            $gf->truncate([
//                'users',
//            ],
//                true);

            $user = User::create([
                'first_name' => 'Shahid Chamran',
                'last_name' => 'University of Ahvaz',
                'username' => 'scu',
                'scu_id' => 'scu',
                'phone_number' => '09166415637',
                'national_id' => 'scu',
                'gender_unique_code' => 'gender0',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new user:\t" . $cc->getColoredString($user->first_name . ' ' . $user->last_name, $cc::CREATE) . "\n");

        } else {
            $cc->print_warning("\nno changes has been made; good luck...");
        }
    }
}
