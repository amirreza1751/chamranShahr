<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\Models\Gender;
use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Morilog\Jalali\Jalalian;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TermFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'term:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $class_name = strtolower(array_last(explode("\\", Term::class))); // static part of unique_code
//        $term_list = SamaRequestController::sama_request('CoreService', 'GetTermList', []);
        $term_list = json_decode('[
    {
        "BeginDate": "1397\/06\/24",
        "EndDate": "1397\/11\/05",
        "ModifiedDateTime": "1\/6\/2020 9:38:06 AM",
        "StandardCode": 971,
        "TermCode": 971,
        "TermId": "145",
        "Title": "971"
    },
    {
        "BeginDate": "1397\/11\/06",
        "EndDate": "1398\/06\/31",
        "ModifiedDateTime": "1\/6\/2020 9:38:06 AM",
        "StandardCode": 972,
        "TermCode": 972,
        "TermId": "146",
        "Title": "972"
    },
    {
        "BeginDate": "1397\/06\/03",
        "EndDate": "1397\/06\/23",
        "ModifiedDateTime": "1\/6\/2020 9:38:06 AM",
        "StandardCode": 963,
        "TermCode": 963,
        "TermId": "147",
        "Title": "963"
    },
    {
        "BeginDate": "1398\/06\/02",
        "EndDate": "1398\/10\/27",
        "ModifiedDateTime": "1\/18\/2020 3:24:33 PM",
        "StandardCode": 981,
        "TermCode": 981,
        "TermId": "148",
        "Title": "981"
    },
    {
        "BeginDate": "1398\/07\/01",
        "EndDate": "1398\/07\/01",
        "ModifiedDateTime": "1\/6\/2020 9:38:06 AM",
        "StandardCode": 973,
        "TermCode": 973,
        "TermId": "149",
        "Title": "973"
    },
    {
        "BeginDate": "1398\/10\/28",
        "EndDate": "1399\/05\/31",
        "ModifiedDateTime": "1\/18\/2020 3:25:02 PM",
        "StandardCode": 982,
        "TermCode": 982,
        "TermId": "150",
        "Title": "982"
    },
    {
        "BeginDate": "1398\/07\/01",
        "EndDate": "1398\/07\/30",
        "ModifiedDateTime": "1\/6\/2020 9:38:06 AM",
        "StandardCode": 0,
        "TermCode": 0,
        "TermId": "151",
        "Title": "000"
    }
]');

        dump("read data from sama:term api...");
        dump("Process:");
        foreach ($term_list as $term_item) {
            $term = Term::where('unique_code', $class_name.$term_item->TermId)->first();
            $jalalian_begin = new Jalalian(explode('/', $term_item->BeginDate)[0], explode('/', $term_item->BeginDate)[1], explode('/', $term_item->BeginDate)[2]);
            $jalalian_end = new Jalalian(explode('/', $term_item->EndDate)[0], explode('/', $term_item->EndDate)[1], explode('/', $term_item->EndDate)[2]);

            if(is_null($term)) { // new term
                printf($cc->getColoredString("-\tadd\t", $cc::CREATE)."new term:\t".$cc->getColoredString($term_item->Title.', '.$jalalian_begin->getMonth().' '.$jalalian_begin->getYear(), $cc::CREATE)."\n");
                $term = new Term();
            } else { // existing gender
                printf($cc->getColoredString("-\tupdate\t", $cc::UPDATE)."existing term:\t".$cc->getColoredString($term_item->Title.', '.$jalalian_begin->getMonth().' '.$jalalian_begin->getYear(), $cc::UPDATE)."\n");
            }

            $term->title = $term_item->Title;

            $term->unique_code = $class_name.$term_item->TermId;
            $term->term_code = $term_item->TermCode;
            $term->begin_date = ($jalalian_begin)->toCarbon();
            $term->end_date = ($jalalian_end)->toCarbon();
            $term->updated_at = Carbon::now(); // set update time
            $term->save();
        }

        $terms = Term::all();
        foreach ($terms as $term){
            if ($term->updated_at < Carbon::now()->subMinute(30)){ // check for trash
                printf($cc->getColoredString("-\tdelete\t", $cc::DELETE)."term:\t\t".$cc->getColoredString($term->title.', '.$jalalian_begin->getMonth().' '.$jalalian_begin->getYear(), $cc::DELETE)."\n");
                $term->delete();
            }
        }
        printf("\n");
    }
}
