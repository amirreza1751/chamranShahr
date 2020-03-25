<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\Http\Controllers\API\Sama\SamaRequestController;
use App\Models\Gender;
use App\Models\StudyLevel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;

class StudyLevelFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'study_level:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "retrieve study levels's information from SAMA webservice";

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
        $class_name = strtolower(array_last(explode("\\", StudyLevel::class))); // static part of unique_code
        $study_level_list = SamaRequestController::sama_request('EducationService', 'GetStudyLevelList', []);

        /**
         * Translates into English --> uncomment if you want translate title to english, but be careful!
         * this google web service has a limitation for request and may ban you for a day due to high-rate request
         */
//        $tr = new GoogleTranslate('en'); // Translates into English

        dump("read data from SAMA : Study Level webservice [ to sync with study level entity of ours ]...");
        dump("Process:");

        foreach ($study_level_list as $study_level_item) {
            $study_level = StudyLevel::where('unique_code', $class_name . $study_level_item->StudyLevelId)->first();
//            $translated = $tr->translate($study_level_item->Title);

            if(is_null($study_level)) { // new study level
                printf($cc->getColoredString("-\tadd\t", $cc::CREATE)."new study level:\t".$cc->getColoredString($study_level_item->Title, $cc::CREATE)."\n");
                $study_level = new StudyLevel();
            } else { // existing study level
                printf($cc->getColoredString("-\tupdate\t", $cc::UPDATE)."existing study level:\t".$cc->getColoredString($study_level_item->Title, $cc::UPDATE)."\n");
            }

            $study_level->title = $study_level_item->Title;

            if(!is_null($study_level_item->EnglishTitle)){ // check for empty english title field
                $study_level->english_title = $study_level_item->EnglishTitle;
            }
//            else {
//                $study_level->english_title = $translated;
//            }
            /**
             * static part of unique_code      CONCAT      numeric part of unique_code retrieve from SAMA
             * example:            studylevel [CONCAT] 2 : studylevel2
             */
            $study_level->unique_code = $class_name . $study_level_item->StudyLevelId;
            $study_level->updated_at = Carbon::now(); // set update time
            $study_level->save();
        }

        /**
         * delete all study level record which updated before this procedure,
         * because all needed study study levels's information retrieved from SAMA and the others probably are dummy data
         */
        $study_levels = StudyLevel::all();
        foreach ($study_levels as $study_level){
            if ($study_level->updated_at < Carbon::now()->subMinute(30)){ // check for trash
                printf($cc->getColoredString("-\tdelete\t", $cc::DELETE)."study level:\t\t".$cc->getColoredString($study_level->english_title, $cc::DELETE)."\n");
                $study_level->delete();
            }
        }
        printf("\n");
    }
}
