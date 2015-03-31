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
            switch($key){
                case 'creator':
                case 'owner':
                case 'publisher':
                case 'legalResponsible':
                case 'scientificResponsible':
                case 'technicalResponsible':
                case 'usedby':
                    if(is_numeric($property->propertyValue)){
                        $agent = DB::table('foafAgent')->where('id', $property->propertyValue)->pluck('name');
                        $metaschema->properties[$key][] = $agent;
                    }else{
                        $metaschema->properties[$key][] = $property->propertyValue;
                    }
                    break;
                default:
                    $metaschema->properties[$key][] = $property->propertyValue;
            }
       }
        
       return $metaschema;
        
        
    }

    /**
     * Get all metadata schemas
     * @return Array paginated list of metadata schemas
     */
    public static function all($provider = null) {
        $users =  Utils::getUsersByProviderInList($provider);
        
        $query = DB::table('MetadataSchema')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id');
        if($provider){
            $query->whereIn('cr_uid', $users);
        }

        $metaschemas = $query->paginate(15);
        if($provider){
            foreach ($metaschemas as &$metaschema) {
                $metaschema->provider = Provider::getProviderName($provider);
            }
        }
        else{
           foreach ($metaschemas as &$metaschema) {
                $metaschema->provider = Provider::getProviderName(Utils::getUserProvider($metaschema->cr_uid));              
            } 
        }
        return $metaschemas;
    }

}
