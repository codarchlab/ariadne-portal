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
        $query = DB::table('DataResource')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id')
                ->where('type', Utils::getDataResourceType('gis'));
        
        if($provider){
            $query->where('cr_uid', $provider);
        }

        $giss = $query->paginate(15);
        
        foreach($giss as &$gis){
            $gis->provider = Provider::getName($gis->cr_uid);
        }

        return $giss;
    }
    
    public static function get($id){
        $gis = DataResource::get($id);
        return $gis;
    }
}
