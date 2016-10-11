<?php

/**
 * Service for providing information about services in the catalog
 */

namespace app\Services;

class Service {

  /**
   * Get all servcies
   *
   * @return Array all the services
   */
  public static function services() {
    
      $services = array();
      $services = json_decode(file_get_contents(public_path().'/resources/services.json'));

      return $services;
  }
}