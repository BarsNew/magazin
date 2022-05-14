<?php

namespace App\Models;

abstract class Main 
{
    static function get($path) {
        global $db;

        if (empty($path)) return [];

        $result = \App\DB::query('pages', '*', "`slug` = '" . $path . "' AND public = 1");

        // code

        //if (empty($result[0])) return [];

        if (empty($result[0])) $result = \App\DB::query('pages', '*', "`slug` = '404' AND public = 1");

        return $result[0];
    }
}