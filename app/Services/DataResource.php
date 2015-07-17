<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class DataResource {

    /**
     * Loads the DataResource object and all properties
     * @param Integer $id Database-Id of the DataResoruce 
     * @return Object complete object with all properties loaded
     */
    public static function get($id, $type = 'dataset') {

        $resource = ElasticSearch::get($id, 'resource', $type);
                
        return $resource;
    }
    
     /**
     * Get name for a Dataresource
     *
     * @param int $id ID of Dataresource
     * @return string Name of Dataresource
     */
    public static function getName($id) {
        
        $name = DB::table('DataResource')
                ->select('DataResource.name')                
                ->where('DataResource.id', $id)
                ->pluck('name');
        
        return $name;
    }

    public static function getType($id) {
        
        $type = DB::table('DataResource')
                ->select('DataResource.type')                
                ->where('DataResource.id', $id)
                ->pluck('type');
        
        return $type;
    }
}