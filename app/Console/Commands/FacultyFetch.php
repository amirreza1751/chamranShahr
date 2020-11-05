<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\Http\Controllers\API\Sama\SamaRequestController;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\ManageLevel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;

class FacultyFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faculty:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "retrieve faculties's information from SAMA webservice";

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
        $class_name = strtolower(array_last(explode("\\", Faculty::class))); // static part of unique_code
        $faculty_list = SamaRequestController::sama_request('EducationService', 'GetFacultyList', []);

        /**
         * Translates into English --> uncomment if you want translate title to english, but be careful!
         * this google web service has a limitation for request and may ban you for a day due to high-rate request
         */
//        $tr = new GoogleTranslate('en');

        dump("read data from SAMA : Faculty webservice [ to sync with faculty entity of ours ]...");
        dump("Process:");
        foreach ($faculty_list as $faculty_item) {
            $faculty = Faculty::where('unique_code', $class_name.$faculty_item->FacultyCode)->first();
//            $translated = $tr->translate($faculty_item->Title);

            if(empty($faculty)) { // new faculty
                printf($cc->getColoredString("-\tadd\t", $cc::CREATE)."new faculty:\t".$cc->getColoredString($faculty_item->Title, $cc::CREATE)."\n");
                $faculty = new Faculty();
                $department = new Department();
                $department->title = $faculty_item->Title;
                if(isset($faculty_item->EnglishTitle)){ // check for empty english title field
                    $department->english_title = $faculty_item->EnglishTitle;
                }
//                else {
//                    $department->english_title = $translated;
//                }

                /**
                 * 3.5 is Contractual value of faculty's manage_level
                 * must replace with a Variable of ManageLevel Enum later :)
                 */
                $department->manage_level_id = ManageLevel::where('level', '3.5')->first()->id;
                $department->save();

                $faculty->department_id = $department->id;

              /**
               * static part of unique_code      CONCAT      numeric part of unique_code retrieve from SAMA
               * example:            term [CONCAT] 128 : term128
               */
                $faculty->unique_code = $class_name . $faculty_item->FacultyCode;
                $faculty->updated_at = Carbon::now(); // set update time
                $faculty->save();

            } else { // existing faculty
                printf($cc->getColoredString("-\tupdate\t", $cc::UPDATE)."existing faculty:\t".$cc->getColoredString($faculty_item->Title, $cc::UPDATE)."\n");
                $faculty->department->title = $faculty_item->Title;
                if(isset($faculty_item->EnglishTitle)){ // check for empty english title field
                    $faculty->department->english_title = $faculty_item->EnglishTitle;
                }
//                else {
//                    $faculty->department->english_title = $translated;
//                }
                $faculty->department->save();

                /**
                 * static part of unique_code      CONCAT      numeric part of unique_code retrieve from SAMA
                 * example:            faculty [CONCAT] 105 : faculty105
                 */
                $faculty->unique_code = $class_name . $faculty_item->FacultyCode;
                $faculty->updated_at = Carbon::now(); // set update time
                $faculty->save();
            }
        }

        /**
         * delete all faculties record which updated before this procedure,
         * because all needed faculties's information retrieved from SAMA and the others probably are dummy data
         */
        $faculties = Faculty::all();
        foreach ($faculties as $faculty){
            if ($faculty->updated_at < Carbon::now()->subMinute(30)){ // check for trash
                printf($cc->getColoredString("-\tdelete\t", $cc::DELETE)."faculty:\t\t".$cc->getColoredString($faculty->department->english_title, $cc::DELETE)."\n");
                $faculty->department->delete(); // cascade on delete
                $faculty->delete();
            }
        }
        printf("\n");
    }
}
