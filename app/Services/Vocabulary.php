<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class Vocabulary {

    public static function get($id) {
        $vocabulary = DB::table('Vocabulary')->where('id', $id)->first();
        
        $vocabulary->agent_name = DB::table('foafAgent')
                ->where('id', $vocabulary->agent_id)
                ->pluck('name');

        $vocabulary->properties = array();

        $properties = DB::table('VocabularyProperties')->where('VocabularyId', $id)->get();
        foreach ($properties as $property) {
            $key = Utils::removePrefix($property->propertyName);
            switch($key){
                case 'creator':
                case 'publisher':
                case 'usedby':
                    if(is_numeric($property->propertyValue)){
                        $agent = DB::table('foafAgent')->where('id', $property->propertyValue)->pluck('name');
                        $vocabulary->properties[$key][] = $agent;
                    }else{
                        $vocabulary->properties[$key][] = $property->propertyValue;
                    }
                    break;
                default:
                    $vocabulary->properties[$key][] = $property->propertyValue;
            }
        }

        return $vocabulary;
    }

    public static function all($provider = null) {
        $users =  Utils::getUsersByProviderInList($provider);
        
        $query = DB::table('Vocabulary')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id');
        if($provider){
            $query->whereIn('cr_uid', $users);
        }

        $vocabularies = $query->paginate(15);
        if($provider){
            foreach ($vocabularies as &$vocabulary) {
                $vocabulary->provider = Provider::getProviderName($provider);
            }
        }
        else{
           foreach ($vocabularies as &$vocabulary) {
                $vocabulary->provider = Provider::getProviderName(Utils::getUserProvider($vocabulary->cr_uid));              
            } 
        }
        return $vocabularies;     
    }
}
