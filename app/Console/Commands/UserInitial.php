<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralFunction;
use App\Models\Department;
use App\Models\ManageHistory;
use App\Models\ManageLevel;
use App\User;
use Carbon\Carbon;
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

            $gf->truncate([
                'users',
            ],false);


            $gf->databaseForeignKeyCheck(false);
            $scu = User::create([
                'first_name' => 'Shahid Chamran',
                'last_name' => 'University of Ahvaz',
                'username' => 'scu',
                'scu_id' => 'scu',
                'phone_number' => '09123456789',
                'national_id' => 'scu',
                'gender_unique_code' => 'gender0',
                'birthday' => Carbon::create(1955, 3, 22),
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new user:\t" . $cc->getColoredString($scu->first_name . ' ' . $scu->last_name, $cc::CREATE) . "\n");

            $astyag = User::create([
                'first_name' => 'توسعه فناوری',
                'last_name' => 'آستیاگ',
                'username' => 'Astyag',
                'scu_id' => 'Astyag',
                'phone_number' => '09927787385',
                'national_id' => 'Astyag',
                'gender_unique_code' => 'gender0',
                'email' => 'astyag.arvand@gmail.com',
                'birthday' => Carbon::create(2019, 8, 23),
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new user:\t" . $cc->getColoredString($astyag->first_name . ' ' . $astyag->last_name, $cc::CREATE) . "\n");

            $astyag->assignRole('developer');

            ManageHistory::create([
                'manager_id' => $astyag->id,
                'managed_type' => Department::class,
                'managed_id' => Department::where('manage_level_id', ManageLevel::where('level', 0.0)->first()->id)->first()->id,
                'begin_date' => Carbon::now(),
                'is_active' => true,
            ]);

            $gf->databaseForeignKeyCheck(true);

        } else {
            $cc->print_warning("\nno changes has been made; good luck...");
        }
    }
}
