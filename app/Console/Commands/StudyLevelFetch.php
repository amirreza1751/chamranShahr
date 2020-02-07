<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
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
//        $gender_list = SamaRequestController::sama_request('EducationService', 'GetStudyLevelList', []);
        $study_level_list = json_decode('[
     {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 0,
        "StudyLevelId": 0,
        "Title": "نامشخص"
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 11,
        "StudyLevelId": 1,
        "Title": "كارداني"
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 12,
        "StudyLevelId": 2,
        "Title": "كارشناسي"
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 13,
        "StudyLevelId": 3,
        "Title": "كارشناسي ارشد "
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 14,
        "StudyLevelId": 4,
        "Title": "دكتري حرفه اي "
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 122,
        "StudyLevelId": 5,
        "Title": "كارشناسي ناپيوسته"
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 17,
        "StudyLevelId": 6,
        "Title": "دكتري PhD"
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 0,
        "StudyLevelId": 7,
        "Title": "دكتري حرفه اي پيش درمانگاهي"
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 17,
        "StudyLevelId": 8,
        "Title": "دكترا"
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 21,
        "StudyLevelId": 9,
        "Title": "دانشوري"
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 17,
        "StudyLevelId": 10,
        "Title": "دكتري معادل "
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 0,
        "StudyLevelId": 11,
        "Title": "کارشناسي ارشد- معادل"
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 17,
        "StudyLevelId": 14,
        "Title": "دکتراي معادل"
    },
    {
        "EnglishTitle": null,
        "IsPostGraduate": null,
        "ModifiedDateTime": "1\/20\/2020 5:06:25 PM",
        "StandardCode": 0,
        "StudyLevelId": 19,
        "Title": "نامشخص قديمي"
    }
]');
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
