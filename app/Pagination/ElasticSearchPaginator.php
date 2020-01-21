<?php

namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class ElasticSearchPaginator extends LengthAwarePaginator {

  /**
   * The aggregations
   *
   * @var array
   */
  protected $aggregations;

  /**
   * Create a new paginator instance.
   *
   * @param  mixed  $items
   * @param  int  $total
   * @param  int  $perPage
   * @param  array $aggregations
   * @param  int|null  $currentPage
   * @param  array  $options (path, query, fragment, pageName)
   * @return void
   */
  public function __construct($items, $total, $perPage, $aggregations, $currentPage = null, array $options = []) {
    $this->aggregations = $aggregations;
    parent::__construct($items, $total['value'], $perPage, $currentPage, $options);
  }

  /**
   * Get the aggregations.
   *
   * @return array
   */
  public function aggregations() {
    return $this->aggregations;
  }

  /**
   * Get the instance as an array.
   * Overridden to include aggregations
   *
   * @return array
   */
  public function toArray() {
    return [
      'total' => $this->total(),
      'per_page' => $this->perPage(),
      'current_page' => $this->currentPage(),
      'last_page' => $this->lastPage(),
      'next_page_url' => $this->nextPageUrl(),
      'prev_page_url' => $this->previousPageUrl(),
      'from' => $this->firstItem(),
      'to' => $this->lastItem(),
      'data' => $this->items->toArray(),
      'aggregations' => $this->aggregations()
    ];
  }

}
