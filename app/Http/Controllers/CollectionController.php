<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Collection;
use App\Services\DataResource;
use App\Services\Utils;

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
        $collections = Collection::all();
        $providers = Utils::getProviders();
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
        $collections = Utils::allSubject($subjectId,0);
        $providers = Utils::getProviders();
       // dd($collections);
        return view('provider_data.collections')->with('collections', $collections)->with('providers', $providers);
    }
}
