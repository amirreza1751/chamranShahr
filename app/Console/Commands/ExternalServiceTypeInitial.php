<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralFunction;
use App\Models\ExternalServiceType;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class ExternalServiceTypeInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'external_service_type:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fill external_service_types table with basic records';

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
        $cc->print_error("this procedure will truncate external_service_types table which may permanently delete some records, also affected some other functionality relative to external_services and other tables!\nDo you want to continue? (pls type\t\tHellYeah\t\tto continue or anything to skip)");
        $answer = trim(fgets(STDIN));
        if ($answer == 'HellYeah') {

            $gf->truncate([
                'external_service_types',
                ],
                false);

            $external_service_type = ExternalServiceType::create([
                'title' => 'rss',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new external service type:\t" . $cc->getColoredString($external_service_type->title, $cc::CREATE) . "\n");

        } else {
            $cc->print_warning("\nno changes has been made; good luck...");
        }
    }
}
