<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralFunction;
use App\Models\Category;
use Illuminate\Console\Command;

class CategoryInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'populate categories table with basic records';

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
        $cc->print_error("this procedure will truncate \"books\" and \"categories\" tables which may permanently delete some records, also affected some other functionality relative to users and other tables!\nDo you want to continue? (pls type\t\tHellYeah\t\tto continue or anything to skip)");
        $answer = trim(fgets(STDIN));
        if ($answer == 'HellYeah') {

            $gf->truncate([
                'books',
                'categories'],
                false);

            $book_category = Category::create([
                'title' => 'کتاب',
                'english_title' => 'Book',
                'parent_id' => null,
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new category:\t" . $cc->getColoredString($book_category->title."\t".$book_category->english_title, $cc::CREATE) ."\n");

            $category = Category::create([
                'title' => 'کتاب دانشگاهی',
                'english_title' => 'Academic Book',
                'parent_id' => $book_category->id,
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new category:\t" . $cc->getColoredString($category->title."\t".$category->english_title, $cc::CREATE) ."\n");

            $category = Category::create([
                'title' => 'کتاب عمومی',
                'english_title' => 'General Book',
                'parent_id' => $book_category->id,
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new category:\t" . $cc->getColoredString($category->title."\t".$category->english_title, $cc::CREATE) ."\n");

        } else {
            $cc->print_warning("\nno changes has been made; good luck...");
        }
    }
}
