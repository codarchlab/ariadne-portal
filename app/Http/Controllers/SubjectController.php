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
        
        $spatial_items = self::getSpatialItems($connected_resources);
                
        $similar_subjects = Subject::similarSubjectsQuery($subject);
        
        if (Request::wantsJson()) {
            return response()
                    ->json($subject)
                    ->header("Vary", "Accept");
        }else{
          return view('subject.page', [
              'subject' => $subject,
              'resources' => $spatial_items,
              'similar_subjects' => $similar_subjects
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
}
