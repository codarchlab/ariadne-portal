<?php
/**
 * Service for accessing subjects in the catalog
 *
 * Wraps access to the elasticsearch index representing the ariadne catalog.
 */

namespace app\Services;
use App\Services\ElasticSearch;
use Config;


class Subject
{
    /**
     * Get a document for a single resource from the catalog index
     *
     * @param type $id id of the document (e.g. dataset id)
     * @return Array all the values in _source from Elastic Search
     * @throws Exception if document is not found
     */
    public static function get($id){
        return ElasticSearch::get($id, Config::get('app.elastic_subject_index'), 'concept');
    }

    /**
     * @param $subjects    
     * @return resources connected to the concept.
     */
    public static function connectedResourcesQuery($subjects) {

    }

    /**
     * @param $subjects
     * @return the seven most similar subjects
     */
    public static function similarSubjectsQuery($subjects) {

        
    }


}