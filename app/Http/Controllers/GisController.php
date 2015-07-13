<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Gis;
use Illuminate\Http\Request;
use App\Services\Utils;

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
        //$giss = Gis::all();
        //$providers = Utils::getProviders();
        $giss = Utils::allESwithType(null,'gis');
        $providers = Utils::getProvidersES();
        return view('provider_data.giss')->with('giss', $giss)->with('providers', $providers);
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
    
    public function subject($subjectId) {
        $giss = Utils::allSubject($subjectId,2);
        $providers = Utils::getProviders();
        $subjectName = Utils::getSubjectName($subjectId);
        return view('provider_data.giss')->with('giss', $giss)->with('providers', $providers)->with('subjectName', $subjectName)->with('subjectId', $subjectId);
    }

}
