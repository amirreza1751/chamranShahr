<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\Http\Controllers\API\Sama\SamaRequestController;
use App\Models\StudyStatus;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;

class StudyStatusFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'study_status:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "retrieve study statuses's information from SAMA webservice";

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
        $class_name = strtolower(array_last(explode("\\", StudyStatus::class))); // static part of unique_code
        $study_status_list = SamaRequestController::sama_request('EducationService', 'GetStudentStatusList', []);

        /**
         * Translates into English --> uncomment if you want translate title to english, but be careful!
         * this google web service has a limitation for request and may ban you for a day due to high-rate request
         */
//        $tr = new GoogleTranslate('en'); // Translates into English

        dump("read data from SAMA : Student Status webservice [ to sync with study status entity of ours ]...");
        dump("Process:");

        foreach ($study_status_list as $study_status_item) {
            $study_status = StudyStatus::where('unique_code', $class_name.$study_status_item->StudentStatusId)->first();
//            $translated = $tr->translate($study_status_item->Title);

            if(empty($study_status)) { // new study status
                printf($cc->getColoredString("-\tadd\t", $cc::CREATE)."new study status:\t".$cc->getColoredString($study_status_item->Title, $cc::CREATE)."\n");
                $study_status = new StudyStatus();
            } else { // existing study status
                printf($cc->getColoredString("-\tupdate\t", $cc::UPDATE)."existing study status:\t".$cc->getColoredString($study_status_item->Title, $cc::UPDATE)."\n");
            }

            $study_status->title = $study_status_item->Title;
//            $study_status->english_title = $translated;
            /**
             * static part of unique_code      CONCAT      numeric part of unique_code retrieve from SAMA
             * example:            studystatus [CONCAT] 2 : studystatus2
             */
            $study_status->unique_code = $class_name . $study_status_item->StudentStatusId;
            $study_status->updated_at = Carbon::now(); // set update time
            $study_status->save();
        }

        /**
         * delete all study status record which updated before this procedure,
         * because all needed study statuses's information retrieved from SAMA and the others probably are dummy data
         */
        $study_statuses = StudyStatus::all();
        foreach ($study_statuses as $study_status){
            if ($study_status->updated_at < Carbon::now()->subMinute(30)){ // check for trash
                printf($cc->getColoredString("-\tdelete\t", $cc::DELETE)."study status:\t\t".$cc->getColoredString($study_status->title, $cc::DELETE)."\n");
                $study_status->delete();
            }
        }
        printf("\n");
    }
}
