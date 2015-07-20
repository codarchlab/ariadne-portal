<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Collection;
use App\Services\DataResource;
use App\Services\Utils;
use App\Services\Subject;

class TextualDocumentController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() {
        //$collections = Collection::all();
        //$providers = Utils::getProviders();
        $textualDocuments = Utils::allESwithType(null,'textualDocument');
        $providers = Utils::getProvidersES();
        //dd($collections);
        return view('provider_data.textualDocuments')->with('textualDocuments', $textualDocuments)->with('providers', $providers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id) {
        $textualDocument = DataResource::get($id,'textualDocument');
        return view('provider_data.dataresource')->with('resource', $textualDocument);
    }

    public function subject($subjectId) {
        $textualDocuments = Subject::resourceWithSubject($subjectId,"textualDocument");
        $providers = Utils::getProvidersES();
        $subjectName = Utils::getSubjectName($subjectId);
       // dd($collections);
       debug($textualDocuments);
        return view('provider_data.textualDocuments')->with('textualDocuments', $textualDocuments)->with('providers', $providers)->with('subjectName', $subjectName)->with('subjectId', $subjectId);
    }
}
