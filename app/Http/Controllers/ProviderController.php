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
        $providers = Provider::statistics2withES();
        return view('provider_info.providers')
                ->with('providers', $providers)
                ->with('full', false);
    }
    
    public function collection($id){
        $collections = Collection::allES($id);
        $providers = Utils::getProvidersES();
        return view('provider_data.collections')->with('collections', $collections)->with('providers', $providers);
    }
    
    public function dataset($id){
        $datasets = Dataset::all($id);
        $providers = Utils::getProviders();
        return view('provider_data.datasets')->with('datasets', $datasets)->with('providers', $providers);        
    }
    
    public function database($id){
        $databases = Database::all($id);
        $providers = Utils::getProviders();
        return view('provider_data.databases')->with('databases', $databases)->with('providers', $providers);        
    }
    
    public function gis($id){
        $giss = Gis::all($id);
        $providers = Utils::getProviders();
        return view('provider_data.giss')->with('giss', $giss)->with('providers', $providers);            
    }
    
    public function schema($id){
        $metaSchemas = MetaSchema::all($id);
        $providers = Utils::getProviders();
        return view('provider_data.metaSchemas')->with('metaSchemas', $metaSchemas)->with('providers', $providers);
    }

    public function service($id){
        $services = Service::all($id);
        $providers = Utils::getProviders();
        return view('provider_data.services')->with('services', $services)->with('providers', $providers);
    }
    
    public function vocabulary($id){
        $vocabularies = Vocabulary::all($id);
        $providers = Utils::getProviders();
        return view('provider_data.vocabularies')->with('vocabularies', $vocabularies)->with('providers', $providers);
    }
    
    public function agent($id){
        $agents = Agent::all($id);
        $providers = Utils::getProviders();
        return view('provider_data.agents')->with('agents', $agents)->with('providers', $providers);           
    }
}
