<?php namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Services\Provider;

class Utils {

   public static function getUsersByProvider($provider_id) {
         $users = DB::table('users')
                ->select('id')
                ->where('provider_id', $provider_id)
                ->get();

         return $users;
    }
    
    public static function getUsersByProviderInList($provider_id) {
         $users = DB::table('users')
                ->select('id')
                ->where('provider_id', $provider_id)
                ->lists('id');

         return $users;
    }
    
    public static function getUserProvider($user_id) {
        $provider = DB::table('users')
                ->select('users.provider_id')                
                ->where('users.id', $user_id)
                ->pluck('provider_id');
        
        return $provider; 
    }    
    
    public static function getTableCountByUsers($table, $users, $type = 0) {
        $total = 0;
        foreach ($users as &$user) {
            $total += Utils::getTableCountByUser($table, $user->id, $type);
        }     
        return $total;
    }
    
    public static function getTableCountByUser($table, $user_id, $type = 0) {
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
                   
        $dataResources = DB::table('DataResource')
                            ->select('DataResource.id', 'DataResource.name', 'DataResource.cr_uid')                
                            ->join('DataResourceIndexes', 'DataResourceIndexes.DataResourceID', '=', 'DataResource.id')
                            ->where('DataResource.type', $type)
                            ->where('DataResourceIndexes.ariadne_subject', $subjectId)
                            ->orderBy('id')
                            ->paginate(15);
        
        foreach ($dataResources as &$dataResource) {
            //$dataResource->provider = Provider::getName($dataResource->cr_uid);
            $dataResource->provider = Provider::getProviderName(Utils::getUserProvider($dataResource->cr_uid));  
        }
        return $dataResources;
    }
    
    public static function getProviders() {
         $users = DB::table('providers')
                ->select('id','name')            
                ->get();

         return $users;
    }
}