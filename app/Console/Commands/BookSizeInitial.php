<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralFunction;
use App\Models\BookSize;
use Illuminate\Console\Command;

class BookSizeInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book_size:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'populate book_sizes table with basic records';

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
    {$cc = new ConsoleColor();
        $gf = new GeneralFunction();
        $cc->print_error("this procedure will truncate \"books\" and \"book_sizes\" tables which may permanently delete some records, also affected some other functionality relative to users and other tables!\nDo you want to continue? (pls type\t\tHellYeah\t\tto continue or anything to skip)");
        $answer = trim(fgets(STDIN));
        if ($answer == 'HellYeah') {

            $gf->truncate([
                'books',
                'book_sizes'],
                false);

            $book_size = BookSize::create([
                'size_name' => 'وزیری (دانشگاهی و علمی)',
                'english_size_name' => 'B5',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

            $book_size = BookSize::create([
                'size_name' => 'رقعی',
                'english_size_name' => 'A5',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

            $book_size = BookSize::create([
                'size_name' => 'رحلی',
                'english_size_name' => 'A4',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

            $book_size = BookSize::create([
                'size_name' => 'رحلی بزرگ (مدیران)',
                'english_size_name' => 'Modiran',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

            $book_size = BookSize::create([
                'size_name' => 'سلطانی',
                'english_size_name' => 'Soltani',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

            $book_size = BookSize::create([
                'size_name' => 'خشتی',
                'english_size_name' => 'Kheshti',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

            $book_size = BookSize::create([
                'size_name' => 'خشتی کوچک',
                'english_size_name' => 'Kheshti (small)',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

            $book_size = BookSize::create([
                'size_name' => 'پالتویی',
                'english_size_name' => 'Paltoei',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

            $book_size = BookSize::create([
                'size_name' => 'پالتویی کوچک',
                'english_size_name' => 'Paltoei (small)',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

            $book_size = BookSize::create([
                'size_name' => 'جیبی',
                'english_size_name' => 'Jibi',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

            $book_size = BookSize::create([
                'size_name' => 'ربعی',
                'english_size_name' => 'B6',
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new book size:\t" . $cc->getColoredString($book_size->size_name."\t".$book_size->english_size_name, $cc::CREATE) ."\n");

        } else {
            $cc->print_warning("\nno changes has been made; good luck...");
        }
    }
}
