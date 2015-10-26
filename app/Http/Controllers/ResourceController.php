<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Config;
use App\Services\ElasticSearch;
use App\Services\DataResource;
use App\Services\Utils;
use Request;

class ResourceController extends Controller {


    public function index() {
        return view('resource.search');
    }

    /**
     * Display the specified resource.
     *
     * @param string $type the elasticsearch type
     * @param  int  $id
     * @return View
     */
    public function show($type,$id) {
        $resource = ElasticSearch::get($id, 'resource', $type);
        return view('resource.show')->with('resource', $resource);
    }

    /**
     * Performs a faceted search depending on the GET-values
     * Eg ?q=dig&keyword=england does a free text search for dig in
     * resources where the keyword england exists
     *
     * @return View rendered pagination for search results
     */
    public function search() {
        $query = ['aggregations' => Config::get('app.elastic_search_aggregations')];

        if (Request::has('q')) {
            $q = ['query_string' => ['query' => Request::get('q')]];
            $query['query']['bool']['must'][] = $q;
        }

        foreach ($query['aggregations'] as $key => $aggregation) {
            if (Request::has($key)) {
                $values = Utils::getArgumentValues($key);

                $field = $aggregation['terms']['field'];

                foreach ($values as $value) {
                    $fieldQuery = [];
                    $fieldQuery[$field] = $value;
                    $query['query']['bool']['must'][] = ['match' => $fieldQuery];
                }
            }
        }

        $hits = ElasticSearch::search($query, 'resource');

        return view('resource.search')
            ->with('type', null)
            ->with('aggregations', $query['aggregations'])
            ->with('hits', $hits);
    }
}
