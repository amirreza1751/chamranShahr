<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\Http\Controllers\API\Sama\SamaRequestController;
use Illuminate\Console\Command;

class StudyFieldFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'study_field:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "retrieve study fields's information from SAMA webservice";

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
        $faculty_class_name = strtolower(array_last(explode("\\", Faculty::class))); // static part of unique_code
        $class_name = strtolower(array_last(explode("\\", StudyField::class))); // static part of unique_code
        $study_field_list = SamaRequestController::sama_request('EducationService', 'GetRegistryGroupList', []);

        /**
         * Translates into English --> uncomment if you want translate title to english, but be careful!
         * this google web service has a limitation for request and may ban you for a day due to high-rate request
         */
//        $tr = new GoogleTranslate('en'); // Translates into English

        dump("read data from SAMA : Registry Group webservice [ to sync with study field entity of ours ]...");
        dump("Process:");
        foreach ($study_field_list as $study_field_item) {
            $study_field = StudyField::where('unique_code', $class_name.$study_field_item->RegistryGroupCode)->first();
//            $translated = $tr->translate($study_field_item->Title);

            if(is_null($study_field)) { // new study field
                printf($cc->getColoredString("-\tadd\t", $cc::CREATE)."new study field:\t".$cc->getColoredString($study_field_item->Title, $cc::CREATE)."\n");
                $study_field = new StudyField();
                $department = new Department();

                $department->title = $study_field_item->Title;

                if(!is_null($study_field_item->EnglishTitle)){ // check for empty english title field
                    $department->english_title = $study_field_item->EnglishTitle;
                }
//                else {
//                    $department->english_title = $translated;
//                }

                /**
                 * 4.5 is Contractual value of Study Field's manage_level
                 * must replace with a Variable of ManageLevel Enum later :)
                 */
                $department->manage_level_id = ManageLevel::where('level', '4.5')->first()->id;
                $department->save();

                $study_field->department_id = $department->id;
                /**
                 * static part of unique_code      CONCAT      numeric part of unique_code retrieve from SAMA
                 * example:            studyfield [CONCAT] 260 : studyfield260
                 * example:            faculty [CONCAT] 105 : faculty105
                 */
                $study_field->unique_code = $class_name . $study_field_item->RegistryGroupCode;
                $study_field->faculty_unique_code = $faculty_class_name . $study_field_item->Faculty->FacultyCode;
                $study_field->updated_at = Carbon::now(); // set update time
                $study_field->save();

            } else { // existing study field
                printf($cc->getColoredString("-\tupdate\t", $cc::UPDATE)."existing study field:\t".$cc->getColoredString($study_field_item->Title, $cc::UPDATE)."\n");
                $study_field->department->title = $study_field_item->Title;

                if(!is_null($study_field_item->EnglishTitle)){ // check for empty english title field
                    $study_field->department->english_title = $study_field_item->EnglishTitle;
                }
//                else {
//                    $study_field->department->english_title = $translated;
//                }
                $study_field->department->save();

                /**
                 * static part of unique_code      CONCAT      numeric part of unique_code retrieve from SAMA
                 * example:            studyfield [CONCAT] 260 : studyfield260
                 * example:            faculty [CONCAT] 105 : faculty105
                 */
                $study_field->unique_code = $class_name . $study_field_item->RegistryGroupCode;
                $study_field->faculty_unique_code = $faculty_class_name . $study_field_item->Faculty->FacultyCode;
                $study_field->updated_at = Carbon::now(); // set update time
                $study_field->save();
            }
        }

        /**
         * delete all study field's record which updated before this procedure,
         * because all needed study fields's information retrieved from SAMA and the others probably are dummy data
         */
        $study_fields = StudyField::all();
        foreach ($study_fields as $study_field){
            if ($study_field->updated_at < Carbon::now()->subMinute(30)){ // check for trash
                printf($cc->getColoredString("-\tdelete\t", $cc::DELETE)."study field:\t\t".$cc->getColoredString($study_field->department->english_title, $cc::DELETE)."\n");
                $study_field->department->delete(); // cascade on delete
                $study_field->delete();
            }
        }
        printf("\n");
    }
}
