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
        
        $agent->properties = array();
        
        $properties = DB::table('foafAgentProperties')->where('foafAgentId', $id)->get();
        foreach($properties as $property){
            $key = Utils::removePrefix($property->propertyName);
            
            $agent->properties[$key] = $property->propertyValue;
        }
        
        return $agent;
    }
    
    /**
     * Get all agents
     * @return Array paginated list of agents
     */
    public static function all() {
        $agents = DB::table('foafAgent')->paginate(15);
        
        foreach($agents as &$agent){
            $agent->provider = Provider::getName($agent->cr_uid);
        }
        
        return $agents;
    }

}