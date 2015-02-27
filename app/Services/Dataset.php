<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Utils;

class Dataset {

    /**
     * Get all dataset (paged)
     * @return Array information for each dataset
     */
    public static function all() {
        $datasets = DB::table('DataResource')->select('id', 'name', 'cr_uid')
                ->where('type', Utils::getDataResourceType('dataset'))
                ->paginate(15);
        
        foreach($datasets as &$dataset){
            $dataset->provider = Provider::getName($dataset->cr_uid);
        }

        return $datasets;
    }

}
