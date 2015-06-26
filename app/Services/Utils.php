<?php namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Services\Provider;
use Illuminate\Support\Facades\Input;

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
    
    public static function containsAndNotContains($string, array $array, $stringNeg){
        foreach($array as $item) {
            if (stripos($string, $item) !== false && stripos($string, $stringNeg) == false) return true;
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
    
    
    /**
     * Adds a value to a new parameter or adds it to the list of an existing
     * 
     * @param string $key
     * @param string $value
     * @return Array
     */
    public static function addKeyValue($key, $value) {
        $arguments = Input::all();
        if(array_key_exists($key, $arguments)){
            $arguments[$key] = $arguments[$key].",".$value;
        } else {
            $arguments[$key] = $value;
        }
        return $arguments;
    }
 
    /**
     * Removes value from list or deletes key if value becomes empty
     * 
     * @param string $key
     * @param string $value
     * @return Array
     */
    public static function removeKeyValue($key, $value) {
        $arguments = Input::all();
        if(array_key_exists($key, $arguments)){
            if($arguments[$key] == $value){
                unset($arguments[$key]);
            } else if(strpos(urldecode($arguments[$key]), ',') !== FALSE){
                $values = explode(',', urldecode($arguments[$key]));
                if(($index = array_search($value, $values)) !== false) {
                    unset($values[$index]);
                    $arguments[$key] = implode(',', $values);
                }
            }
            
        }
        return $arguments;
    }    
    
    /**
     * Get a list of values for a specific key and returns them as an array
     * 
     * @param string $key
     * @return Array
     */
    public static function getArgumentValues($key) {
        $arguments = Input::all();
        if(array_key_exists($key, $arguments) && strpos(urldecode($arguments[$key]), ',') !== FALSE){
            return explode(',', urldecode($arguments[$key]));
        }else{
            return array($arguments[$key]);
        }
    }        
    
    /**
     * Checks if a specified value is set for a paramter
     * Also checks if its in a comma separetd list
     * 
     * @param type $key key to lock for
     * @param type $value expected value or value in list
     * @return boolean
     */
    public static function keyValueActive($key, $value) {
        $arguments = Input::all();
        if(array_key_exists($key, $arguments)){
            $values = explode(",", $arguments[$key]);
            return in_array($value, $values);
        } 
        return false;
    }
    
    /**
     * Sets a set of specified values and keep all existing
     * 
     * @param Array $keyValues key-value pairs for values to set
     * @return Array
     */
    public static function setValues($keyValues = array()) {
        $arguments = Input::all();
        foreach($keyValues as $key => $value) {
            $arguments[$key] = $value;
        }
        return $arguments;
    }    
}