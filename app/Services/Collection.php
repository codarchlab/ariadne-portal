<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Provider;

class Collection {

    public static function all() {

        $collections = DB::table('DataResource')
                ->select('id', 'name', 'cr_uid')
                ->orderBy('id')
                ->where('type', Utils::getDataResourceType('collection'))
                ->get();

        foreach ($collections as &$collection) {
            $collection->provider = Provider::getName($collection->cr_uid);
        }
        return $collections;
    }

}