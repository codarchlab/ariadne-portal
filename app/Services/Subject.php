<?php

/**
 * Service for accessing subjects in the catalog
 *
 * Wraps access to the elasticsearch index representing the ariadne catalog.
 */

namespace app\Services;

use App\Services\ElasticSearch;
use Config;

class Subject {

    /**
     * Get a document for a single resource from the catalog index
     *
     * @param type $id id of the document (e.g. dataset id)
     * @return Array all the values in _source from Elastic Search
     * @throws Exception if document is not found
     */
    public static function get($id) {
        
        return array(
            '_index' => 'subject_v1',
            '_type' => 'subject',
            '_id' => '123456789',
            '_source' => array(
                'title' => 'Shipwrecks',
                'description' => 'Occations of the severe damage or loss of a boat or ship at sea',
                'terms' => array(
                    'shipwrecks (preferred,C,U,LC,English-P,D,U,U)',
                    'shipwreck (C,U,English,AD,U,U)',
                    'wrecks (events) (C,U,English,UF,U,U)',
                    'schipbreuken (C,U,Dutch-P,D,U,U)',
                    'schipbreuk (C,U,Dutch,AD,U,U)',
                    'scheepsongelukken (C,U,Dutch,UF,U,U)',
                    'scheepsongeluk (C,U,Dutch,UF,U,U)',
                    'naufragios (C,U,Spanish-P,D,U,PN)',
                    'naufragio (C,U,Spanish,AD,U,U)',                    
                ),
                'connected_concept' => array(
                    array(
                        'concept' => 'Schiffswrack',
                        'source' => 'DAI Thesaurus',
                        'identifier' => 'http://thesauri.dainst.org/schemes/1/concepts/2004',
                        'relation' => 'Exact match',
                    ),
                    array(
                        'concept' => 'Vikingaskepp',
                        'source' => 'Swedish National Data Service',
                        'identifier' => '324525',
                        'relation' => 'Related match',
                    ),
                ),
            )
        );
        
        
        
        //return ElasticSearch::get($id, Config::get('app.elastic_subject_index'), 'concept');
    }

    /**
     * @param $subject
     * @return resources connected to the concept.
     */
    public static function connectedResourcesQuery($subject) {
     
       return array(
            array(          
                "location" => array(
                    "lon" => 15.176353,
                    "lat" => 58.235996
                ),
                "placeName" => "Östergötland",
                "coordinateSystem" => "WGS 84",
                "country" => "Sweden"
            ),
            array (
                "location" => array(
                    "lon" => 15.276353,
                    "lat" => 58.235996
                ),
                "placeName" => "Östergötlands län",
                "coordinateSystem" => "WGS 84",
                "country" => "Sweden",
            ),
            array (
                "location" => array (
                    "lon" => 15.076353,
                    "lat" => 58.435996
                ),
                "placeName" => "Boxholm kommun",
                "coordinateSystem" => "WGS 84",
                "country" => "Sweden",
            ),
            array (
                "location" => array (
                    "lon" => 15.076353,
                    "lat" => 58.635996
                ),
                "placeName" => "Ekeby socken",
                "coordinateSystem" => "WGS 84",
                "country" => "Sweden"
            ),
            array (
                "location" => array (
                    "lon" => 15.276353,
                    "lat" => 58.735996
                ),
                "placeName" => "Norrköping kommun",
                "coordinateSystem" => "WGS 84",
                "country" => "Sweden"
            ),
            array (
                "location" => array (
                    "lon" => 15.876353,
                    "lat" => 58.835996
                ),
                "placeName" => "Norrköping socken",
                "coordinateSystem" => "WGS 84",
                "country" => "Sweden"
            )
        );       
    }

    /**
     * @param $subjects
     * @return the seven most similar subjects
     */
    public static function similarSubjectsQuery($subjects) {
        
        return array(
            array(          
                "_index" => 'subject_v1',
                "_type" => "subject",
                "_id" => "ships",
                "_score" => "3.1091805",
                "_source" => array(
                    'title' => 'Ships'                    
                )
            ),
            array (
                "_index" => 'subject_v1',
                "_type" => "subject",
                "_id" => "maritime_archaeology",
                "_score" => "2.9091805",
                "_source" => array(
                    'title' => 'Maritime archaeology'                    
                )
            )
        );       
    }

}
