<?php

namespace App\Http\Controllers;

use Request;
use Input;
use \App\Services\Map;

class BrowseController extends Controller {
    
    public function map() {
        return view('browse.map');      
    }
    
     
}
