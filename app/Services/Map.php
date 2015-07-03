<?php
namespace App\Services;

use App\Services\ElasticSearch;

class Map {
 
    public static function all() {
        $size_query = ['filter'=>
                          ['exists' => ['field' => 'lat']]
                     ];
        $points_size = Elasticsearch::countHits($size_query, 'resource');
        
        $query= ['size' => $points_size,
                'filter'=>
                          ['exists' => ['field' => 'lat']]
                     ];
       
        $points = Elasticsearch::allHits($query, 'resource');
                         
        return $points;
    }
    
    
}