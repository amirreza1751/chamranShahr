<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\Http\Controllers\API\Sama\SamaRequestController;
use App\Models\StudyArea;
use App\Models\StudyField;
use App\Models\StudyLevel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StudyAreaFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'study_area:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "retrieve study areas's information from SAMA webservice";

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
        $study_field_class_name = strtolower(array_last(explode("\\", StudyField::class))); // static part of unique_code
        $study_level_class_name = strtolower(array_last(explode("\\", StudyLevel::class))); // static part of unique_code
        $class_name = strtolower(array_last(explode("\\", StudyArea::class))); // static part of unique_code
        $study_area_count = SamaRequestController::sama_request('EducationService', 'GetCourseStudiesCount', []);
        $counter = 1;
        dump("read data from SAMA : Course Study webservice [ to sync with study area entity of ours ]...");
        while ($study_area_count > 0) {
            $study_area_list = SamaRequestController::sama_request('EducationService', 'GetCourseStudyList', ['pageNumber' => $counter]);

            /**
             * Translates into English --> uncomment if you want translate title to english, but be careful!
             * this google web service has a limitation for request and may ban you for a day due to high-rate request
             */
//            $tr = new GoogleTranslate('en'); // Translates into English

            dump("Process, Page Number " . $counter . ":");
            foreach ($study_area_list as $study_area_item) {
                $study_area = StudyArea::where('unique_code', $class_name . $study_area_item->CourseStudyCode)->first();

                if (is_null($study_area)) { // new study area
                    printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new study area:\t" . $cc->getColoredString($study_area_item->Title, $cc::CREATE) . "\n");
                    $study_area = new StudyArea();
                    if (!is_null($study_area_item->EnglishTitle)) { // check for empty english title field
                        $study_area->english_title = $study_area_item->EnglishTitle;
                    }
//                    else {
//                        $study_area->english_title = $tr->translate($study_area_item->Title);
//                    }
                } else { // existing study area
                    printf($cc->getColoredString("-\tupdate\t", $cc::UPDATE) . "existing study area:\t" . $cc->getColoredString($study_area->title, $cc::UPDATE) . "\n");
                    if (is_null($study_area->english_title)) { // check for empty english title field
                        if (!is_null($study_area_item->EnglishTitle)) { // check for empty english title field
                            $study_area->english_title = $study_area_item->EnglishTitle;
                        }
//                    else {
//                        $study_area->english_title = $tr->translate($study_area_item->Title);
//                    }
                    }
                }

                $study_area->title = $study_area_item->Title;
                $study_area->is_active = $study_area_item->IsActive;
                /**
                 * static part of unique_code      CONCAT      numeric part of unique_code retrieve from SAMA
                 * example:            studyarea [CONCAT] 500 : studyarea500
                 * example:            studylevel [CONCAT] 2 : studylevel2
                 * example:            studyfield [CONCAT] 260 : studyfield260
                 */
                $study_area->unique_code = $class_name . $study_area_item->CourseStudyCode;
                $study_area->study_level_unique_code = $study_level_class_name . $study_area_item->StudyLevel->StudyLevelId;
                $study_area->study_field_unique_code = $study_field_class_name . $study_area_item->RegistryGroup->RegistryGroupCode;
                $study_area->updated_at = Carbon::now(); // set update time
                $study_area->save();
            }
            printf("\n");

            $counter++;
            $study_area_count -= 500; /** SAMA paginates huge information to several pages, each page have 500 record */
        }

        /**
         * delete all study area's record which updated before this procedure,
         * because all needed study areas's information retrieved from SAMA and the others probably are dummy data
         */
        $study_areas = StudyArea::all();
        foreach ($study_areas as $study_area) {
            if ($study_area->updated_at < Carbon::now()->subMinute(30)) { // check for trash
                printf($cc->getColoredString("-\tdelete\t", $cc::DELETE) . "study area:\t\t" . $cc->getColoredString($study_area->english_title, $cc::DELETE) . "\n");
                $study_area->delete();
            }
        }
        printf("\n");
    }
}
