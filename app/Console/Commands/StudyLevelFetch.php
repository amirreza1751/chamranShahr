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
        $class_name = strtolower(array_last(explode("\\", StudyLevel::class))); // static part of unique_code
        $study_level_list = SamaRequestController::sama_request('EducationService', 'GetStudyLevelList', []);
        $tr = new GoogleTranslate('en'); // Translates into English

        dump("read data from sama:study_level api...");
        dump("Process:");

        foreach ($study_level_list as $study_level_item) {
            $study_level = StudyLevel::where('unique_code', $class_name.$study_level_item->StudyLevelId)->first();
            $translated = $tr->translate($study_level_item->Title);

            if(is_null($study_level)) { // new gender
                printf($cc->getColoredString("-\tadd\t", $cc::CREATE)."new study level:\t".$cc->getColoredString($translated, $cc::CREATE)."\n");
                $study_level = new StudyLevel();
            } else { // existing gender
                printf($cc->getColoredString("-\tupdate\t", $cc::UPDATE)."existing study level:\t".$cc->getColoredString($translated, $cc::UPDATE)."\n");
            }

            $study_level->title = $study_level_item->Title;

            if(!is_null($study_level_item->EnglishTitle)){ // check for empty english title field
                $study_level->english_title = $study_level_item->EnglishTitle;
            } else {
                $study_level->english_title = $translated;
            }

            $study_level->unique_code = $class_name.$study_level_item->StudyLevelId;
            $study_level->updated_at = Carbon::now(); // set update time
            $study_level->save();
        }

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
