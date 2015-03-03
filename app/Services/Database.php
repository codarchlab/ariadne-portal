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

        $query = DB::table('DataResource')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id')
                ->where('type', Utils::getDataResourceType('database'));
        if($provider){
            $query->where('cr_uid', $provider);
        }

        $databases = $query->paginate(15);
        
        foreach ($databases as &$database) {
            $database->provider = Provider::getName($database->cr_uid);
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