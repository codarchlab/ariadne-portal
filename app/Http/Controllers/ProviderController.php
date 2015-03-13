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
        return view('provider_info.providers')
                ->with('providers', $providers)
                ->with('full', true);
    }
    
    public function collection($id){
        $collections = Collection::all($id);
        return view('provider_data.collections')->with('collections', $collections);
    }
    
    public function dataset($id){
        $datasets = Dataset::all($id);
        return view('provider_data.datasets')->with('datasets', $datasets);        
    }
    
    public function database($id){
        $databases = Database::all($id);
        return view('provider_data.databases')->with('databases', $databases);        
    }
    
    public function gis($id){
        $giss = Gis::all($id);
        return view('provider_data.giss')->with('giss', $giss);            
    }
    
    public function schema($id){
        $metaSchemas = MetaSchema::all($id);
        return view('provider_data.metaSchemas')->with('metaSchemas', $metaSchemas);
    }

    public function service($id){
        $services = Service::all($id);
        return view('provider_data.services')->with('services', $services);
    }
    
    public function vocabulary($id){
        $vocabularies = Vocabulary::all($id);
        return view('provider_data.vocabularies')->with('vocabularies', $vocabularies);
    }
    
    public function agent($id){
        $agents = Agent::all($id);
        return view('provider_data.agents')->with('agents', $agents);           
    }
}
