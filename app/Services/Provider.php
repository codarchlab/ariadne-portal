<?php
namespace App\Services;

use App\Services\Utils;
use App\Services\ElasticSearch;

class Provider {

    /**
     * Get statistics for each provider with new providers table and through ElasticSearch
     * 
     * @return Array list of providers with statistics
     */
    public static function statistics() {
       
        $providers = Utils::getProvidersES();
       
        foreach ($providers as &$provider) {
            $query = ['query'=>
                          ['match' => ['providerId' => $provider['_source']['id']]]
                     ];
 
            $provider['collections'] = ElasticSearch::countHits($query, 'resource', 'collection');
            $provider['datasets'] = ElasticSearch::countHits($query, 'resource', 'dataset');
            $provider['databases'] = ElasticSearch::countHits($query, 'resource', 'database');
            $provider['gis'] = ElasticSearch::countHits($query, 'resource', 'gis');
            $provider['textualDocuments'] = ElasticSearch::countHits($query, 'resource', 'textualDocument');
           
        }
        
        return $providers;
    }

}

