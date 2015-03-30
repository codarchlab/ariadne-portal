<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class Service {

    /**
     * Loads the service object and all properties
     * @param Integer $id service-Id of the ARIADNEService 
     * @return Object service object with all properties loaded
     */
    public static function get($id) {

        $service = DB::table('ARIADNEService')->where('id', $id)->first();

        $service->agent_name = DB::table('foafAgent')
                        ->where('id', $service->agent_id)
                        ->pluck('name');
              
       $properties = DB::table('ARIADNEServiceProperties')
                        ->where('ARIADNEServiceId', $id)
                        ->get();
       
       $service->properties = array();
         
       foreach($properties as $property) {
            $key = Utils::removePrefix($property->propertyName);
            switch($key){
                case 'hasTechnicalSupport':
                    if(is_numeric($property->propertyValue)){
                        $agent = DB::table('foafAgent')->where('id', $property->propertyValue)->pluck('name');
                        $service->properties[$key][] = $agent;
                    }else{
                        $service->properties[$key][] = $property->propertyValue;
                    }
                    break;
                default:
                    $service->properties[$key][] = $property->propertyValue;
            }
       }
        
       return $service;
        
        
    }

    /**
     * Get all services
     * @return Array paginated list of services
     */
    public static function all($provider = null) {
        $users =  Utils::getUsersByProviderInList($provider);
        
        $query = DB::table('ARIADNEService')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id');
        if($provider){
            $query->whereIn('cr_uid', $users);
        }

        $services = $query->paginate(15);
        if($provider){
            foreach ($services as &$service) {
                $service->provider = Provider::getProviderName($provider);
            }
        }
        else{
           foreach ($services as &$service) {
                $service->provider = Provider::getProviderName(Utils::getUserProvider($service->cr_uid));              
            } 
        }
        return $services;
    }

}
