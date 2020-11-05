<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralFunction;
use App\Models\BookLanguage;
use Illuminate\Console\Command;

class BookLanguageInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book_language:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'populate book_languages table with basic records';

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
        $gf = new GeneralFunction();
        $cc->print_error("this procedure will truncate \"books\" and \"book_languages\" tables which may permanently delete some records, also affected some other functionality relative to users and other tables!\nDo you want to continue? (pls type\t\tHellYeah\t\tto continue or anything to skip)");
        $answer = trim(fgets(STDIN));
        if ($answer == 'HellYeah') {

            $gf->truncate([
                'books',
                'book_languages'],
                false);

            $book_language = BookLanguage::create([
                'title' => 'فارسی',
                'english_title' => 'Persian',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book language:\t" . $cc->getColoredString($book_language->title."\t".$book_language->english_title, $cc::CREATE) ."\n");

            $book_language = BookLanguage::create([
                'title' => 'انگلیسی',
                'english_title' => 'English',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book language:\t" . $cc->getColoredString($book_language->title."\t".$book_language->english_title, $cc::CREATE) ."\n");

            $book_language = BookLanguage::create([
                'title' => 'عربی',
                'english_title' => 'Arabic',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book language:\t" . $cc->getColoredString($book_language->title."\t".$book_language->english_title, $cc::CREATE) ."\n");

            $book_language = BookLanguage::create([
                'title' => 'سایر زبان‌ها',
                'english_title' => 'Other',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book language:\t" . $cc->getColoredString($book_language->title."\t".$book_language->english_title, $cc::CREATE) ."\n");

        } else {
            $cc->print_warning("\nno changes has been made; good luck...");
        }
    }
}
