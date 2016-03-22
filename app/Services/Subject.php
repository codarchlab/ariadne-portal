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
    return ElasticSearch::get($id, Config::get('app.elastic_search_subject_index'), 'terms');
  }

  /**
   * Performs a paginated search against Elastic Search
   *
   * @param Array $query Array containing the elastic search query
   * @return LengthAwarePaginator paginated result of the search
   */
  public static function search($query) {
    return ElasticSearch::search($query, Config::get('app.elastic_search_subject_index'), 'terms');
  }

  /**
   * @param $subject
   * @return resources connected to the concept.
   */
  public static function connectedResourcesQuery($subject) {

    $body = [
      'query' => [
        'match' => [
          'derivedSubject.prefLabel' => $subject['_source']['prefLabel']
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

    return $result['hits']['hits'];
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
