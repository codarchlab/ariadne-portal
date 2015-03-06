<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class MetaSchema {

    /**
     * Loads the metadata schema object and all properties
     * @param Integer $id metadata schema-Id of the MetadataSchema 
     * @return Object metadata schema object with all properties loaded
     */
    public static function get($id) {

        $metaschema = DB::table('MetadataSchema')->where('id', $id)->first();

        $metaschema->agent_name = DB::table('foafAgent')
                        ->where('id', $metaschema->agent_id)
                        ->pluck('name');
              
       $properties = DB::table('MetadataSchemaProperties')
                        ->where('MetadataSchemaId', $id)
                        ->get();
       
       $metaschema->properties = array();
         
       foreach($properties as $property) {
            $key = Utils::removePrefix($property->propertyName);
            $metaschema->properties[$key][] = $property->propertyValue;
       }
        
       return $metaschema;
        
        
    }

    /**
     * Get all metadata schemas
     * @return Array paginated list of metadata schemas
     */
    public static function all($provider = null) {
        $query = DB::table('MetadataSchema');

        if($provider){
            $query->where('cr_uid', $provider);
        }

        $metaschemas = $query->paginate(15);
        
        foreach ($metaschemas as &$metaschema) {
            $metaschema->provider = Provider::getName($metaschema->cr_uid);
        }

        return $metaschemas;
    }

}
