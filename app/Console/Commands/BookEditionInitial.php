<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralFunction;
use App\Models\BookEdition;
use Illuminate\Console\Command;

class BookEditionInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book_edition:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'populate book_editions table with basic records';

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
        $cc->print_error("this procedure will truncate \"books\" and \"book_editions\" tables which may permanently delete some records, also affected some other functionality relative to users and other tables!\nDo you want to continue? (pls type\t\tHellYeah\t\tto continue or anything to skip)");
        $answer = trim(fgets(STDIN));
        if ($answer == 'HellYeah') {

            $gf->truncate([
                'books',
                'book_editions'],
                false);

            $book_edition = BookEdition::create([
                'edition' => 'اول',
                'english_edition' => 'First',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book edition:\t" . $cc->getColoredString($book_edition->edition."\t".$book_edition->english_edition, $cc::CREATE) ."\n");

            $book_edition = BookEdition::create([
                'edition' => 'دوم',
                'english_edition' => 'Second',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book edition:\t" . $cc->getColoredString($book_edition->edition."\t".$book_edition->english_edition, $cc::CREATE) ."\n");

            $book_edition = BookEdition::create([
                'edition' => 'سوم',
                'english_edition' => 'Third',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book edition:\t" . $cc->getColoredString($book_edition->edition."\t".$book_edition->english_edition, $cc::CREATE) ."\n");

            $book_edition = BookEdition::create([
                'edition' => 'چهارم',
                'english_edition' => 'Fourth',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book edition:\t" . $cc->getColoredString($book_edition->edition."\t".$book_edition->english_edition, $cc::CREATE) ."\n");

            $book_edition = BookEdition::create([
                'edition' => 'پنجم',
                'english_edition' => 'Fifth',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book edition:\t" . $cc->getColoredString($book_edition->edition."\t".$book_edition->english_edition, $cc::CREATE) ."\n");

            $book_edition = BookEdition::create([
                'edition' => 'ششم',
                'english_edition' => 'Sixth',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book edition:\t" . $cc->getColoredString($book_edition->edition."\t".$book_edition->english_edition, $cc::CREATE) ."\n");

            $book_edition = BookEdition::create([
                'edition' => 'هفتم',
                'english_edition' => 'Seventh',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book edition:\t" . $cc->getColoredString($book_edition->edition."\t".$book_edition->english_edition, $cc::CREATE) ."\n");

            $book_edition = BookEdition::create([
                'edition' => 'هشتم',
                'english_edition' => 'Eighth',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book edition:\t" . $cc->getColoredString($book_edition->edition."\t".$book_edition->english_edition, $cc::CREATE) ."\n");

            $book_edition = BookEdition::create([
                'edition' => 'نهم',
                'english_edition' => 'Ninth',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book edition:\t" . $cc->getColoredString($book_edition->edition."\t".$book_edition->english_edition, $cc::CREATE) ."\n");

            $book_edition = BookEdition::create([
                'edition' => 'دهم',
                'english_edition' => 'Tenth',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book edition:\t" . $cc->getColoredString($book_edition->edition."\t".$book_edition->english_edition, $cc::CREATE) ."\n");

        } else {
            $cc->print_warning("\nno changes has been made; good luck...");
        }
    }
}
