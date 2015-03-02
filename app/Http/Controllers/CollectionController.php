<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Collection;
use App\Services\DataResource;

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
        return view('provider_data.collections')->with('collections', $collections);
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

}
