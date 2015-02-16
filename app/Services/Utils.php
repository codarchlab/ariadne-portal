<?php namespace App\Services;
use Illuminate\Support\Facades\DB;

class Utils {

    public static function getTableCount($table, $user_id, $type = 0) {
        $query = DB::table($table)->where('cr_uid', $user_id);

        if ($table == 'DataResource') {
            $query->where('type', $type);
        }

        return $query->count();
    }

}
