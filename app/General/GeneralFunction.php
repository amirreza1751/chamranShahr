<?php


namespace App\General;


use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class GeneralFunction
{
    public function truncate($tables, $foreign_key_checks)
    {
        if($foreign_key_checks){
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } else {
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
        }
    }

    public function databaseForeignKeyCheck($check = true)
    {
        if ($check){
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
    }

    public function createThumbnail($destinationPath, $file, $fileName, $fileExtension, $width=100)
    {
        /**
         * create thumbnail of the original image
         * this image will store with a postfix '-thumbnail' beside the original image
         */
        $img = Image::make($file);
        // create a thumbnail for the god sake because of OUR EXCELLENT INTERNET  :/
        $img->resize($width, $width, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/' . $fileName . '-thumbnail.' . $fileExtension);
    }
}
