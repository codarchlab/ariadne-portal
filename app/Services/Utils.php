<?php namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Services\Provider;

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
    
    public static function getDataResourceTypeNameIdent($id)
    {
        switch($id){
            case 0: return 'coll';
            case 1: return 'dat';
            case 2: return 'dat';
            case 3: return 'gis';
        }
    }    
    
    public static function removePrefix($string){
        $string = str_replace("dct:", "", $string);
        $string = str_replace("dct_", "", $string);
        $string = str_replace("dcat:", "", $string);
        $string = str_replace("foaf:", "", $string);
        $string = str_replace("dbpedia-owl:", "", $string);
        $string = str_replace("rdfs:", "", $string);
        $string = str_replace(":", "", $string);
        return $string;
    }
    
    public static function contains($string, array $array){
        foreach($array as $item) {
            if (stripos($string, $item) !== false) return true;
        }
        return false;
    }
    
    public static function allSubject($subjectId, $type) {
                   
        $dataResourcesQuery = DB::table('DataResource')
                            ->select('DataResource.id', 'DataResource.name', 'DataResource.cr_uid')                
                            ->join('DataResourceIndexes', 'DataResourceIndexes.DataResourceID', '=', 'DataResource.id')
                            ->where('DataResource.type', $type)
                            ->where('DataResourceIndexes.ariadne_subject', $subjectId)
                            ->orderBy('id');
         
        $dataResources = $dataResourcesQuery->paginate(15);
        
        foreach ($dataResources as &$dataResource) {
            $dataResource->provider = Provider::getName($dataResource->cr_uid);
        }
        return $dataResources;
    }
}