<?php

namespace App\Http\Controllers;
use App\Services\Utils;
use App\Services\Service;

class PageController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Welcome Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders the "marketing page" for the application and
      | is configured to only allow guests. Like most of the other sample
      | controllers, you are free to modify or remove it as you desire.
      |
     */


    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function welcome() {
        $cloudData = Utils::getWordCloudData();
        return view('page.welcome') -> with('cloud_data', $cloudData);
    }
    
    /**
     * Show the services page
     *
     * @return Response
     */
    public function services()
    {
        $serviceData = Service::services();
        return view('page.services') -> with('services', $serviceData);
    }       
    
    /**
     * Show the about page
     *
     * @return Response
     */
    public function about()
    {
        return view('page.about');
    }    
    
    /**
     * Generate robots.txt
     *
     * @return Response
     */
    public function robots()
    {
        $path = public_path();
        
        if(env('APP_ENV') == 'production') {
            $path .= '/robots_production.txt';
        }else {
            $path .= '/robots_development.txt';
        }
        return response(file_get_contents($path))
                ->header('Content-Type', 'text/plain');
    }       
}
