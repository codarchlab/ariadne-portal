<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Service;
use Illuminate\Http\Request;
use App\Services\Utils;

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
        $providers = Utils::getProviders();
        return view('provider_data.services')->with('services', $services)->with('providers', $providers);
    }

    /**
     * Display the specified service.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $service = Service::get($id);
        //dd($service);
        return view('provider_data.service')->with('service', $service);
    }

}
