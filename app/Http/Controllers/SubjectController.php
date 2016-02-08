<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Services\Subject;

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
     * @return View
     */
    public function page($id) {

        $subject = Subject::get($id);
        $connected_resources = Subject::connectedResourcesQuery($subject);
        $similar_subjects = Subject::similarSubjectsQuery($subject);
        
        return view('subject.page', [
            'subject' => $subject,
            'resources' => $connected_resources,
            'similar_subjects' => $similar_subjects
        ]);
    }

}
