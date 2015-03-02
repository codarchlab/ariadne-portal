<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Services\Provider;
use \App\Services\Collection;
use \App\Services\Dataset;
use \App\Services\Agent;

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
        
    }
    
    public function gis($id){
        
    }
    
    public function schema($id){
        
    }

    public function service($id){
        
    }
    
    public function vocabulary($id){
        
    }
    
    public function agent($id){
        $agents = Agent::all($id);
        return view('provider_data.agents')->with('agents', $agents);           
    }
}
