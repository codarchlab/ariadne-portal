<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Services\Subject;

class SubjectController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * List the subjects and number of records
     *
     * @return Response
     */
    public function index() {
        $subjects = Subject::statistics();
        return view('ariadne_subject.subjects')->with('subjects', $subjects);
    }

}
