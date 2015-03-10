<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller {

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
    public function index() {
        $services= Service::all();
        return view('provider_data.services')->with('services', $services);
    }

    /**
     * Display the specified service.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $service = Service::get($id);
        //dd($metaSchema);
        return view('provider_data.service')->with('service', $service);
    }

}
