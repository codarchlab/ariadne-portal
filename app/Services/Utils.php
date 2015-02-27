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
    
    public static function getDataResourceType($type)
    {
        switch($type){
            case 'collection': return 0;
            case 'dataset': return 1;
            case 'database': return 2;
            case 'gis': return 3;
        }
    }

    public static function getDataResourceTypeName($id)
    {
        switch($id){
            case 0: return 'collection';
            case 1: return 'dataset';
            case 2: return 'database';
            case 3: return 'gis';
        }
    }    
    
    public static function removePrefix($string){
        $string = str_replace("dct:", "", $string);
        $string = str_replace("dct_", "", $string);
        $string = str_replace("dcat:", "", $string);
        return $string;
    }
}