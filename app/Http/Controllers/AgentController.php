<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller {

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
     * @return Response
     */
    public function index() {
        $agents= Agent::all();
        return view('provider_data.agents')->with('agents', $agents);
    }

    /**
     * Display the specified agent.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $agent = Agent::get($id);

        return view('provider_data.agent')->with('agent', $agent);
    }

}
