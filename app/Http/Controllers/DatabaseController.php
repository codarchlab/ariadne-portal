<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Database;
use App\Services\DataResource;

class DatabaseController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() {
        $databases = Database::all();
        return view('provider_data.databases')->with('databases', $databases);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id) {
        $database = DataResource::get($id);
        return view('provider_data.dataresource')->with('resource', $database);
    }

}
