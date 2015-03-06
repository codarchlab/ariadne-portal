<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\MetaSchema;
use Illuminate\Http\Request;

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
        return view('provider_data.metaSchemas')->with('metaSchemas', $metaSchemas);
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
