<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Collection;
use App\Services\DataResource;
use App\Services\Utils;
use App\Services\Subject;

class CollectionController extends Controller {

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
        $collections = Utils::allESwithType(null,'collection');
        $providers = Utils::getProvidersES();
        //dd($collections);
        return view('provider_data.collections')->with('collections', $collections)->with('providers', $providers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id) {
        $collection = DataResource::get($id);
        return view('provider_data.dataresource')->with('resource', $collection);
    }

    public function subject($subjectId) {
        $collections = Subject::resourceWithSubject($subjectId,"collection");
        $providers = Utils::getProvidersES();
       // dd($collections);
       debug($collections);
        return view('provider_data.collections')->with('collections', $collections)->with('providers', $providers);
    }
}
