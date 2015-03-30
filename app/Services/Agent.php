<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class Agent {

    /**
     * Loads the agent object and all properties
     * @param Integer $id Database-Id of the DataResoruce 
     * @return Object agent object with all properties loaded
     */
    public static function get($id) {

        $agent = DB::table('foafAgent')->where('id', $id)->first();

        if ($agent->type == 0) {
            $agent->type = 'Agent';
        } else if ($agent->type == 1) {
            $agent->type = 'Organisation';
        }

        $agent->properties = array();

        $properties = DB::table('foafAgentProperties')->where('foafAgentId', $id)->get();
        foreach ($properties as $property) {
            $key = Utils::removePrefix($property->propertyName);
            $agent->properties[$key] = $property->propertyValue;
        }

        return $agent;
    }

    /**
     * Get all agents
     * @return Array paginated list of agents
     */
    public static function all($provider = null) {
        $users =  Utils::getUsersByProviderInList($provider);
        
        $query = DB::table('foafAgent')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id');
        if($provider){
            $query->whereIn('cr_uid', $users);
        }

        $agents = $query->paginate(15);
        if($provider){
            foreach ($agents as &$agent) {
                $agent->provider = Provider::getProviderName($provider);
            }
        }
        else{
           foreach ($agents as &$agent) {
                $agent->provider = Provider::getProviderName(Utils::getUserProvider($agent->cr_uid));              
            } 
        }
        return $agents;   
    }
    
    public static function connectedDR($id) {
        $conncectDRs = DB::table('DataResourceProperties')
                        ->distinct()
                        ->select('DataResourceId')
                        ->where('propertyValue', $id)
                        ->whereIn('propertyName', ['dct:creator', 'dct:publisher',':owner',':technicalResponsible',':scientificResponsible',':legalResponsible'])
                        ->get();
        foreach ($conncectDRs as $conncectDR) {
            $conncectDR->name = DataResource::getName($conncectDR->DataResourceId);
            $conncectDR->type = DataResource::getType($conncectDR->DataResourceId);
        }

        return $conncectDRs;
    }

}
