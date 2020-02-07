<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\Sama\SamaRequestController;
use App\Models\Gender;
use Carbon\Carbon;
use Illuminate\Console\Command;
use \App\General\ConsoleColor;
use Stichoza\GoogleTranslate\GoogleTranslate;

class GenderFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gender:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch and synch genders from api of SAMA';

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
        $class_name = strtolower(array_last(explode("\\", Gender::class))); // static part of unique_code
        $gender_list = SamaRequestController::sama_request('CoreService', 'GetGenderList', []);
        $tr = new GoogleTranslate('en'); // Translates into English

        dump("read data from sama:gender api...");
        dump("Process:");
        foreach ($gender_list as $gender_item) {
            $gender = Gender::where('unique_code', $class_name.$gender_item->GenderId)->first();
            $translated = $tr->translate($gender_item->Title);

            if(is_null($gender)) { // new gender
                printf($cc->getColoredString("-\tadd\t", $cc::CREATE)."new gender type:\t".$cc->getColoredString($translated, $cc::CREATE)."\n");
                $gender = new Gender();
            } else { // existing gender
                printf($cc->getColoredString("-\tupdate\t", $cc::UPDATE)."existing gender type:\t".$cc->getColoredString($translated, $cc::UPDATE)."\n");
            }

            $gender->title = $gender_item->Title;

            if(!is_null($gender_item->EnglishTitle)){ // check for empty english title field
                $gender->english_title = $gender_item->EnglishTitle;
            } else {
                $gender->english_title = $translated;
            }

            $gender->unique_code = $class_name.$gender_item->GenderId;
            $gender->updated_at = Carbon::now(); // set update time
            $gender->save();
        }

        $genders = Gender::all();
        foreach ($genders as $gender){
            if ($gender->updated_at < Carbon::now()->subMinute(30)){ // check for trash
                printf($cc->getColoredString("-\tdelete\t", $cc::DELETE)."gender type:\t\t".$cc->getColoredString($gender->english_title, $cc::DELETE)."\n");
                $gender->delete();
            }
        }
        printf("\n");
    }
}
