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
    
    public static function getSubjectCount($subject_id, $type = 0){
        $users = getenv('PROVIDERS');
        return DB::table('DataResourceIndexes')
                ->select('DataResourceID')->distinct()
                ->where('ariadne_subject', $subject_id)
                ->whereRaw('DataResourceID IN (SELECT id FROM DataResource WHERE type= ? AND cr_uid IN  ( '.$users.' ))', array($type))
                ->count();
    }

}
