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
    
    public static function searchResults($data) {
        $query = ['filter' => 
                    ['geo_bounding_box' => 
                        ['spatial.location' => 
                            ['top_left' => 
                                ['lat' => $data['top_left_lan'],'lon' => $data['top_left_lon']],
                            'bottom_right' => 
                                ['lat' => $data['bottom_right_lan'],'lon' => $data['bottom_right_lon']]
                            ]
                        ]
                    ]
                ];
                                  
        $resources = ElasticSearch::allHits($query, 'resource');
              
        return $resources;
    }
}