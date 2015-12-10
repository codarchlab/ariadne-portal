@extends('app')
@section('title', 'Welcome - Ariadne portal')

@section('description', 'ARIADNE brings together and integrates existing archaeological research data infrastructures
so that researchers can use the various distributed datasets and new and powerful technologies as an integral
component of the archaeological research methodology.')
@section('keywords', 'Archaeological Research Data Infrastructures, Metadata Registry')

@section('content')

<div class="row">

    <div class="col-md-10 col-md-offset-1 text-center search-form" style="background-color:rgba(239, 239, 239, 0.5);">
        
        <img id="searchlogo" class="img-responsive" src="img/logo.png">

        <div class="row">            
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    {!! Form::open(array("action" => "ResourceController@search", "method" => "GET", "class" => "form-inline")) !!}
                        <div class="col-md-3 form-group">
                            {!! Form::select("fields", ["" => "All fields", "subject" => "Subject", "time" => "Time period", "location" => "Location"], null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="col-md-9 input-group">
                            {!! Form::text("q", Request::input("q"), array("id" => "q", "class" => "form-control", "placeholder" => "Search for resources in the Ariadne catalog ...")) !!}
                            <span class="submit-btn input-group-btn">
                                {!! Form::button('&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;', array("type" => "submit", "class" => "btn btn-primary")) !!}
                            </span>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-5 col-md-offset-1">
        <h3>Welcome</h3>
        <div class="panel panel-default">
            <div class="panel-body">
                <p>
                    ARIADNE is ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit 
                    in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
                <h4>Featured resource</h4>
                <p>
                    Description is ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit 
                    in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <h3>Browse</h3>
        <div class="panel panel-default">
            <div class="panel-image hide-panel-body">   
                <div class="row">
                    <div class="col-md-4" style="padding-left: 0px; padding-right: 0px;">
                        <a href="{{ action('BrowseController@map') }}"><img src="img/where.JPG" class="img-responsive"></a>
                    </div> 
                    <div class="col-md-4" style="padding-left: 0px; padding-right: 0px;">
                        <a href="#"><img src="img/when.JPG" class="img-responsive"></a>
                    </div> 
                    <div class="col-md-4" style="padding-left: 0px; padding-right: 0px;">
                        <a href="#"><img src="img/what.JPG" class="img-responsive"></a>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
</div>  

@endsection