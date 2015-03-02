<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Dataset;
use Illuminate\Http\Request;

class DatasetController extends Controller {

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
     * @return Response
     */
    public function index() {
        $datasets = Dataset::all();
        return view('provider_data.datasets')->with('datasets', $datasets);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $dataset = Dataset::get($id);
        return view('provider_data.dataresource')->with('resource', $dataset);
    }

}
