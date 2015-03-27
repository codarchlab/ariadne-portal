<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Provider;

class Database {

    /**
     * Get all databases
     *
     * @return Array of all databases
     */
    public static function all($provider = null) {

        $users =  Utils::getUsersByProviderInList($provider);
        
        $query = DB::table('DataResource')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id')
                ->where('type', Utils::getDataResourceType('database'));
        if($provider){
            $query->whereIn('cr_uid', $users);
        }

        $databases = $query->paginate(15);
        if($provider){
            foreach ($databases as &$database) {
                $database->provider = Provider::getProviderName($provider);
            }
        }
        else{
           foreach ($databases as &$database) {
                $database->provider = Provider::getProviderName(Utils::getUserProvider($database->cr_uid));              
            } 
        }
        return $databases;
    }
    
    /**
     * Get a specific collection
     *
     * @param int $id ID of collection
     * @return A collection object
     */
    public static function get($id){
        
        $database = DB::table('DataResource')
                ->where('id', $id)
                ->first();
        return $database;
    }
}