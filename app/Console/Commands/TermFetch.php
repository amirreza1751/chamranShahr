<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\TimeHandling;
use App\Http\Controllers\API\Sama\SamaRequestController;
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
        $term_list = SamaRequestController::sama_request('EducationService', 'GetTermList', []);
        dump("read data from sama:term api...");
        dump("Process:");
        foreach ($term_list as $term_item) {
            $term = Term::where('unique_code', $class_name . $term_item->TermId)->first();
            $begin_date_array = explode('/', $term_item->BeginDate);
            $end_date_array = explode('/', $term_item->EndDate);
            if ($begin_date_array[1] > 6 && $begin_date_array[2] == 31) { // unnatural day number
                $begin_date_array[2] = 30;
            }
            if ($end_date_array[1] > 6 && $end_date_array[2] == 31) { // unnatural day number
                $end_date_array[2] = 30;
            }
            // ex. 1383/04/31 =>                1383                    04                      30 (: unnatural day number check)
            $jalalian_begin = new Jalalian($begin_date_array[0], $begin_date_array[1], $begin_date_array[2]);
            $jalalian_end = new Jalalian($end_date_array[0], $end_date_array[1], $end_date_array[2]);

            if (is_null($term)) { // new term
                printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new term:\t" . $cc->getColoredString($term_item->Title . ",\tBegin Date: " . Jalalian::forge($jalalian_begin->getTimestamp())->format('Y-m-d'), $cc::CREATE) . "\t");
                $term = new Term();
            } else { // existing term
                printf($cc->getColoredString("-\tupdate\t", $cc::UPDATE) . "existing term:\t" . $cc->getColoredString($term_item->Title . ",\tBegin Date: " . Jalalian::forge($jalalian_begin->getTimestamp())->format('Y-m-d'), $cc::UPDATE) . "\t");
            }

            $term->title = $term_item->Title;

            $term->unique_code = $class_name . $term_item->TermId;
            $term->term_code = $term_item->TermCode;

            if (TimeHandling::isDST(($jalalian_begin)->toCarbon())) {
                printf($cc->getColoredString("has DST time:", $cc::WARNING) . Jalalian::forge($jalalian_begin->getTimestamp())->format('Y-m-d') . "\t");
                $term->begin_date = ($jalalian_begin->addHours(1)->subMinutes($jalalian_begin->getMinute()))->toCarbon();
            } else {
                $term->begin_date = ($jalalian_begin)->toCarbon();
            }

            if (TimeHandling::isDST(($jalalian_end)->toCarbon())) {
                printf($cc->getColoredString("has DST time:", $cc::WARNING) . Jalalian::forge($jalalian_begin->getTimestamp())->format('Y-m-d') . "\t");
                $term->end_date = ($jalalian_end->addHours(1)->subMinutes($jalalian_end->getMinute()))->toCarbon();
            } else {
                $term->end_date = ($jalalian_end)->toCarbon();
            }

            $term->updated_at = Carbon::now(); // set update time
            $term->save();
            printf("\n");
        }

        $terms = Term::all();
        foreach ($terms as $term) {
            if ($term->updated_at < Carbon::now()->subMinute(30)) { // check for trash
                printf($cc->getColoredString("-\tdelete\t", $cc::DELETE) . "term:\t\t" . $cc->getColoredString($term->title . ', ' . $jalalian_begin->getMonth() . ' ' . $jalalian_begin->getYear(), $cc::DELETE) . "\n");
                $term->delete();
            }
        }
        printf("\n");
    }
}
