<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Provider;
use Illuminate\Support\Facades\Input;
use App\Services\ElasticSearch;
use App\Services\Resource;
use Request;
use Log;


class Utils {

  public static function contains($string, array $array) {
    foreach ($array as $item) {
      if (stripos($string, $item) !== false)
        return true;
    }
    return false;
  }

  public static function containsAndNotContains($string, array $array, $stringNeg) {
    foreach ($array as $item) {
      if (stripos($string, $item) !== false && stripos($string, $stringNeg) == false) {
        return true;
      }
    }
    return false;
  }

  /**
   * Return all providers from ES index common/providers/
   * 
   * @return Array
   */
  public static function getProvidersES() {
    $query = ['query' =>
      ['match_all' => []]
    ];
    $providers = ElasticSearch::allHits($query, 'common', 'providers');

    return $providers;
  }

  /**
   * Return provider name
   * 
   * @param int $p_id
   * @return string
   */
  public static function getProviderName($p_id) {
    $query = ['query' =>
      ['match' => ['id' => $p_id]]
    ];
    $provider = ElasticSearch::allHits($query, 'common', 'providers');

    return $provider[0]['_source']['acronym'];
  }

  /**
   * Return all providers from ES index common/providers/
   * 
   * @return Array
   */
  public static function geAriadneSubjectsES() {
    $query = ['query' =>
      ['match_all' => []]
    ];
    $aSubjects = ElasticSearch::allHits($query, 'common', 'archaeologicalResourceType');

    return $aSubjects;
  }

  public static function getSubjectName($subjectId) {
    $query = ['query' =>
      ['match' => ['_id' => $subjectId]]
    ];
    $provider = ElasticSearch::allHits($query, 'common', 'archaeologicalResourceType');

    return $provider[0]['_source']['name'];
  }

  public static function getResourceTitle($resourceId) {
    $query = ['query' =>
      ['match' => ['_id' => $resourceId]]
    ];
    $provider = ElasticSearch::allHits($query, 'catalog', 'resource');
    if (count($provider) > 0) {
      return $provider[0]['_source']['title'];
    } else {
      return '';
    }
  }

  /**
   * Adds a value to a new parameter or adds it to the list of an existing
   * 
   * @param string $key
   * @param string $value
   * @return Array
   */
  public static function addKeyValue($key, $value) {
    $arguments = Input::all();
    if (array_key_exists($key, $arguments)) {
      $arguments[$key] = $arguments[$key] . "|" . $value;
    } else {
      $arguments[$key] = $value;
    }

    if (array_key_exists('page', $arguments)) {
      unset($arguments['page']);
    }
    
    if (array_key_exists('noPagination', $arguments)) {
      unset($arguments['noPagination']);
    }
    
    if (array_key_exists('size', $arguments)) {
      unset($arguments['size']);
    }
    
    return $arguments;
  }

  /**
   * Removes value from list or deletes key if value becomes empty
   * 
   * @param string $key
   * @param string $value
   * @return Array
   */
  public static function removeKeyValue($key, $value) {
    $arguments = Input::all();
    if (array_key_exists($key, $arguments)) {
      if ($arguments[$key] == $value) {
        unset($arguments[$key]);
      } else if (strpos(urldecode($arguments[$key]), '|') !== FALSE) {
        $values = explode('|', urldecode($arguments[$key]));
        if (($index = array_search($value, $values)) !== false) {
          unset($values[$index]);
          $arguments[$key] = implode('|', $values);
        }
      }
    }

    if (array_key_exists('page', $arguments)) {
      unset($arguments['page']);
    }
    
    if (array_key_exists('noPagination', $arguments)) {
      unset($arguments['noPagination']);
    }
    
    if (array_key_exists('size', $arguments)) {
      unset($arguments['size']);
    }
    
    return $arguments;
  }
  
  /**
   * Get a list of values for a specific key and returns them as an array
   * 
   * @param string $key
   * @return Array
   */
  public static function getArgumentValues($key) {
    $arguments = Input::all();
    if (array_key_exists($key, $arguments) && strpos(urldecode($arguments[$key]), '|') !== FALSE) {
      return explode('|', urldecode($arguments[$key]));
    } else {
      return array($arguments[$key]);
    }
  }

  /**
   * Checks if a specified value is set for a paramter
   * Also checks if its in a comma separetd list
   * 
   * @param type $key key to lock for
   * @param type $value expected value or value in list
   * @return boolean
   */
  public static function keyValueActive($key, $value) {
    $arguments = Input::all();
    if (array_key_exists($key, $arguments)) {
      $values = explode('|', $arguments[$key]);
      return in_array($value, $values);
    }
    return false;
  }

  /**
   * Sets a set of specified values and keep all existing
   * 
   * @param Array $keyValues key-value pairs for values to set
   * @return Array
   */
  public static function setValues($keyValues = array()) {
    $arguments = Input::all();
    foreach ($keyValues as $key => $value) {
      $arguments[$key] = $value;
    }
    return $arguments;
  }
  
     
    /**
     * Redirect to search without parameters if parameters are empty
     */
    public static function redirectIfEmptySearch() {        

        if(!empty(Request::input())) { 
            if(self::emptyRecursive(Request::input())){
                header('Location: ' . route('search'));
                die();
            }elseif(count(Request::input()) != count(array_filter(Request::input()))){
              $params = array_filter(Request::input());
              header('Location: ' . route('search').'?'.http_build_query($params));
              die();              
            }
        }
    }

  /**
   * Recursively check if an array is empty
   * 
   * @param array $value
   * @return boolean
   */
  public static function emptyRecursive($value) {
    if (is_array($value)) {
        $empty = TRUE;
        array_walk_recursive($value, function($item) use (&$empty) {
            $empty = $empty && empty($item);
        });
    } else {
        $empty = empty($value);
    }
    return $empty;
}


 public static function getWordCloudData() {

    $query = [
      'size' => 0,
      'aggregations' => [
        'derivedSubject' => [
          'terms' => [
            'field' => 'derivedSubject.prefLabel.raw',
            'size' => 100
          ]
        ],
        'keyword' => [
          'terms' => [
            'field' => 'keyword.raw',
            'size' => 100
          ]
        ]
      ]
    ];    
    
    //Log::info( $query );
    return Resource::search($query);
    
  }

}
