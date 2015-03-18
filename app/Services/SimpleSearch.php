<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class SimpleSearch {
    
    public static function getType($typeId) {
         
        $typeName = Utils::getDataResourceTypeName($typeId);
        $typeNameIdent = Utils::getDataResourceTypeNameIdent($typeId);
        $type = array('id' => $typeId, 'name' => $typeName, 'ident' => $typeNameIdent);
        
        return $type;
    }
    
    public static function getDataResources($q) {
         
        $drs =  DB::table('DataResource')
                        ->select('id','name')
                        ->where('name','LIKE', '%'.$q.'%')
                        ->get();
        
       foreach($drs as $dr) { 
            $properties = DB::table('DataResourceProperties')
                             ->where('DataResourceId',$dr->id)
                             ->get();

            $dr->properties = array();

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
                             $dr->properties[$key][] = $agent;
                         }else{
                             $dr->properties[$key][] = $property->propertyValue;
                         }
                         break;
                     default:
                         $dr->properties[$key][] = $property->propertyValue;
                 }
            }
       }   
             
        return $drs;
    }
    
    
}
