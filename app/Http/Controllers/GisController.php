<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Gis;
use Illuminate\Http\Request;

class GisController extends Controller {

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
        $giss = Gis::all();
        return view('provider_data.giss')->with('giss', $giss);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $gis = Gis::get($id);
        return view('provider_data.dataresource')->with('resource', $gis);
    }

}
