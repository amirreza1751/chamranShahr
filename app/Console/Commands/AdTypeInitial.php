<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralFunction;
use App\Models\AdType;
use Illuminate\Console\Command;

class AdTypeInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ad_type:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'populate ad_types table with basic records';

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
        $cc->print_error("this procedure will truncate \"ads\" and \"ad_types\" tables which may permanently delete some records, also affected some other functionality relative to users and other tables!\nDo you want to continue? (pls type\t\tHellYeah\t\tto continue or anything to skip)");
        $answer = trim(fgets(STDIN));
        if ($answer == 'HellYeah') {

            $gf->truncate([
                'ads',
                'ad_types'],
                false);

            $ad_type = AdType::create([
                'ad_type_title' => 'آگهی خرید',
                'english_ad_type_title' => 'Buy',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new ad type:\t" . $cc->getColoredString($ad_type->ad_type_title."\t".$ad_type->english_ad_type_title, $cc::CREATE) ."\n");

            $ad_type = AdType::create([
                'ad_type_title' => 'آگهی فروش',
                'english_ad_type_title' => 'Sale',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new ad type:\t" . $cc->getColoredString($ad_type->ad_type_title."\t".$ad_type->english_ad_type_title, $cc::CREATE) ."\n");

        } else {
            $cc->print_warning("\nno changes has been made; good luck...");
        }
    }
}
