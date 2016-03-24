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
   * Get a document for a single resource from the subject index
   *
   * @param type $id id of the document (e.g. dataset id)
   * @return Array all the values in _source from Elastic Search
   * @throws Exception if document is not found
   */
  public static function get($id) {
    return ElasticSearch::get($id, Config::get('app.elastic_search_subject_index'), 'terms');
  }

  /**
   * Performs a paginated search against the Elastic Search subject index
   *
   * @param Array $query Array containing the elastic search query
   * @return LengthAwarePaginator paginated result of the search
   */
  public static function search($query) {
    return ElasticSearch::search($query, Config::get('app.elastic_search_subject_index'), 'terms');
  }

  /**
   * Performs a paginated search against the Elastic Search suggest index
   *
   * @param Array $query Array containing the elastic search query
   * @return LengthAwarePaginator paginated result of the search
   */
  public static function suggest($query) {
    return ElasticSearch::search($query, Config::get('app.elastic_search_subject_suggest_index'), 'terms');
  }

  /**
   * @param $subject
   * @return resources connected to the concept.
   */
  public static function connectedResourcesQuery($subject) {

    $body = [
      'query' => [
        'bool' => [
          'must' => [
            'term' => [
              'derivedSubject.source' => $subject['_id']
            ]
          ]
        ]
      ],
      'filter' => [
        'exists' => ['field' => 'lat']
      ]
    ];

    $params = [
      'index' => Config::get('app.elastic_search_catalog_index'),
      'type' => 'resource',
      'body' => $body
    ];

    $result = ElasticSearch::getClient()->search($params);

    return $result;
  }
  
  /**
   * Get list of subjects where the id is in the list of broader subject
   * @param type $id
   * @return array list of narrower subjects
   */
  public static function getSubSubjects($id){
    $body = [
      'fields'=>['prefLabel'],
      'size' => 100,
      'query' => [
        'bool' => [
          'must' => [
            'term' => [
              'broader.id'=>[
                'value' => $id
              ]
            ]
          ]
        ]
      ]
    ];

    $params = [
      'index' => Config::get('app.elastic_search_subject_index'),
      'type' => 'terms',
      'body' => $body
    ];

    $result = ElasticSearch::getClient()->search($params);

    $subjects = [];
    foreach ($result['hits']['hits'] as $subject){
      $subjects[$subject['_id']] = $subject['fields']['prefLabel'][0];
    }
    
    asort($subjects);
    
    return $subjects;    
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
      array(
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
