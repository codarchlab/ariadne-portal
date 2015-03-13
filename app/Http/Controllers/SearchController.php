<?php

namespace App\Http\Controllers;
use App\Services\SimpleSearch;

class SearchController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the services.
     *
     * @return Response
     */
    public function index($typeId) {
        $type= SimpleSearch::getType($typeId);
        //dd($type);
        return view('search.simpleSearch')->with('type', $type);
    }

   
}