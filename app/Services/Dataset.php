<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class Dataset {

    /**
     * Get all dataset (paged)
     * @return Array information for each dataset
     */
    public static function all($provider = null) {
        $query = DB::table('DataResource')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id')
                ->where('type', Utils::getDataResourceType('dataset'));
        
        if($provider){
            $query->where('cr_uid', $provider);
        }

        $datasets = $query->paginate(15);
        
        foreach($datasets as &$dataset){
            $dataset->provider = Provider::getName($dataset->cr_uid);
        }

        return $datasets;
    }
    
    public static function get($id){
        return DataResource::get($id);
    }

}
