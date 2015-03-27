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
        $users =  Utils::getUsersByProviderInList($provider);
        
        $query = DB::table('DataResource')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id')
                ->where('type', Utils::getDataResourceType('dataset'));
        if($provider){
            $query->whereIn('cr_uid', $users);
        }

        $datasets = $query->paginate(15);
        if($provider){
            foreach ($datasets as &$dataset) {
                $dataset->provider = Provider::getProviderName($provider);
            }
        }
        else{
           foreach ($datasets as &$dataset) {
                $dataset->provider = Provider::getProviderName(Utils::getUserProvider($dataset->cr_uid));              
            } 
        }
        return $datasets;
    }
    
    public static function get($id){
        $dataset = DataResource::get($id);
        return $dataset;
    }
}
