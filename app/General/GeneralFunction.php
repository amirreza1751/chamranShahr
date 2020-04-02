<?php


namespace App\General;


use Illuminate\Support\Facades\DB;

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
}
