<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\MetaSchema;
use Illuminate\Http\Request;
use App\Services\Utils;

class MetaSchemaController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the metadata schemas.
     *
     * @return Response
     */
    public function index() {
        $metaSchemas= MetaSchema::all();
        $providers = Utils::getProviders();
        return view('provider_data.metaSchemas')->with('metaSchemas', $metaSchemas)->with('providers', $providers);
    }

    /**
     * Display the specified metadata schema.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $metaSchema = MetaSchema::get($id);
        //dd($metaSchema);
        return view('provider_data.metaSchema')->with('metaSchema', $metaSchema);
    }

}
