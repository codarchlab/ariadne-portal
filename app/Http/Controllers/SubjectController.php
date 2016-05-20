<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Services\Subject;
use Request;

class SubjectController extends Controller {

    /**
     * List the subjects and number of records
     *
     * @return Response
     */
    public function index() {
        $subjects = Subject::statisticsWithES();
        debug($subjects);
        //dd($subjects);
        return view('subject.index')->with('subjects', $subjects);
    }

    /**
     * Display the specified subject.
     *
     * @param  int  $id
     * @return View or json
     */
    public function page($id) {

        $subject = Subject::get($id);
        $connected_resources = Subject::connectedResourcesQuery($subject);
        $sub_subjects = Subject::getSubSubjects($id);
        //$spatial_items = self::getSpatialItems($connected_resources);
        
        debug($connected_resources);
        
        $similar_subjects = Subject::similarSubjectsQuery($subject);
        
        if (Request::wantsJson()) {
            return response()
                    ->json($subject)
                    ->header("Vary", "Accept");
        }else{
          $pref_labels = [];
          foreach($subject['_source']['prefLabels'] as $prefLabel){
            $pref_labels[$prefLabel['lang']][] = $prefLabel['label'];
          }
          ksort($pref_labels);
          return view('subject.page', [
              'subject' => $subject,
              'resources' => $connected_resources,
              'similar_subjects' => $similar_subjects,
              'pref_labels' => $pref_labels,
              'sub_subjects' => $sub_subjects
          ]);
        }
    }

    /**
     * Filters out the spatial items which can be shown on a map.
     *
     * @param $resources
     * @return array of item from the spatial array
     */
    private function getSpatialItems($resources) {
        $spatialItems = array();

        foreach ($resources as $resource){
            $spatialItems[] = $resource['_source']['spatial'][0];
        }
        return $spatialItems;
    }

    /**
     * Performs a search for suggestions in the subject index
     * Eg ?q=dig does a prefix search for "dig"
     *
     * @return JSON response with a list of subjects
     */
    public function suggest() {
        
        $query = ['query' => ['match_all' => []]];
        if (Request::has('q')) {
            $query = [
                'query' => [
                    'nested' => [
                        'path' => 'prefLabels',
                        'query' => [
                            'bool' => [
                                'must' => [
                                    [ 'prefix' => [ 'prefLabels.label' => Request::get('q') ] ],
                                    [ 'match' => [ 'prefLabels.lang' => 'en' ] ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }
        
        $hits = Subject::suggest($query, 'resource');
        return response()
            ->json($hits)
            ->header("Vary", "Accept");
    }
}
