<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Services\Provider;

class ProviderController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * List the providers and number of records
     *
     * @return Response
     */
    public function index() {
        $providers = Provider::statistics();
        return view('providers')->with('providers', $providers);
    }

}
