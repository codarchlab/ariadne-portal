<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class Gis {

    /**
     * Get all gis (paged)
     * @return Array information for each gis entry
     */
    public static function all($provider = null) {
        $users =  Utils::getUsersByProviderInList($provider);
        
        $query = DB::table('DataResource')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id')
                ->where('type', Utils::getDataResourceType('gis'));
        if($provider){
            $query->whereIn('cr_uid', $users);
        }

        $giss = $query->paginate(15);
        if($provider){
            foreach ($giss as &$gis) {
                $gis->provider = Provider::getProviderName($provider);
            }
        }
        else{
           foreach ($giss as &$gis) {
                $gis->provider = Provider::getProviderName(Utils::getUserProvider($gis->cr_uid));              
            } 
        }
        return $giss;
    }
    
    public static function get($id){
        $gis = DataResource::get($id);
        return $gis;
    }
}
