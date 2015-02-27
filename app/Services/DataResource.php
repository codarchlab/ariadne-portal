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
    public static function get($id) {

        $resource = DB::table('DataResource')
                            ->where('id', $id)
                            ->first();

        $resource->type = Utils::getDataResourceTypeName($resource->type);
        
        $resource->agent_name = DB::table('foafAgent')
                                ->where('id', $resource->agent_id)
                                ->pluck('name');
        
        $properties = DB::table('DataResourceProperties')
                        ->where('DataResourceId', $id)
                        ->get();
        
        $resource->properties = array();
        $resource->spatial = array();
        foreach($properties as $property) {
            $key = Utils::removePrefix($property->propertyName);
            switch($key){
                case 'spatial':
                    $gis =  DB::table('gis')->where('id', $property->propertyValue)->first();
                    $resource->spatial[$gis->id] = $gis;
                    break;
                case 'temporal':
                    $temporal =  DB::table('temporal')->where('id', $property->propertyValue)->first();
                    $resource->properties[$key][$temporal->id] = $temporal;
                    break;
                case 'creator':
                case 'owner':
                case 'publisher':
                case 'legalResponsible':
                case 'scientificResponsible':
                case 'technicalResponsible':
                    if(is_numeric($property->propertyValue)){
                        $agent = DB::table('foafAgent')->where('id', $property->propertyValue)->pluck('name');
                        $resource->properties[$key][] = $agent;
                    }else{
                        $resource->properties[$key][] = $property->propertyValue;
                    }
                    break;
                default:
                    $resource->properties[$key][] = $property->propertyValue;
            }
        }
        
        return $resource;
    }

}