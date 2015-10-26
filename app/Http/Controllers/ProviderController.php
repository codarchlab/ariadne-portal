<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Services\Provider;
use \App\Services\Collection;
use \App\Services\Dataset;
use \App\Services\Gis;
use \App\Services\Agent;
use \App\Services\Database;
use \App\Services\MetaSchema;
use \App\Services\Service;
use \App\Services\Vocabulary;
use App\Services\Utils;

class ProviderController extends Controller {


    /**
     * List the providers and number of records
     *
     * @return Response
     */
    public function index() {
        $providers = Provider::statistics();
        return view('provider_info.providers')
                ->with('providers', $providers)
                ->with('full', false);
    }
}
