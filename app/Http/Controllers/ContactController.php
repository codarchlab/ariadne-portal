<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use Config;
use Mail;

class ContactController extends Controller
{
    
	public function form() {
        return view('contact.form');
    }

    public function store(ContactFormRequest $request) {

    	\Mail::send('contact.email',
	        array(
	            'name' => $request->get('name'),
	            'email' => $request->get('email'),
	            'subject' => $request->get('subject'),
	            'user_message' => $request->get('message')
	        ), function($message) use ($request)
	    {
	        $message->to(Config::get('app.contact_email'), 'Admin')
	        	->subject('ARIADNE Portal Contact Form - ' . $request->get('subject'));
	    });

    	return \Redirect::route('contact.form')
    		->with('message', 'Thanks for your feedback!');
	}

}
