<?php

namespace App\Http\Controllers;

use App\Services\Provider;
use Utils;

class ProviderController extends Controller {


    /**
     * List the providers and number of records
     *
     * @return Response
     */
    public function index() {
        $providers = Provider::statistics();
        return view('provider.index')
                ->with('providers', $providers)
                ->with('full', false);
    }
}
