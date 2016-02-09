@extends('app')
@section('title', 'Error parsing query - Ariadne portal')

@section('description', 'ARIADNE brings together and integrates existing archaeological research data infrastructures
so that researchers can use the various distributed datasets and new and powerful technologies as an integral
component of the archaeological research methodology.')
@section('keywords', 'Archaeological Research Data Infrastructures, Metadata Registry')

@section('content')

<div class="container content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 text-center error-title">
            <h1>The query could not be parsed</h1>
            <p>
                Unfortunately we couldn't parse your query. An email was sent to report the issue. Try searching for the exact phrase:
            </p>
        </div>
    </div>
    <div class="row" id="frontpage">

        <div class="col-md-10 col-md-offset-1 text-center search-form">

            <div id="welcomeSearch" class="error-search">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="row">
                            {!! Form::open(array("action" => "ResourceController@search", "method" => "GET", "class" => "form-inline")) !!}
                                <div class="col-md-3 form-group">
                                    {!! Form::select("fields", ["" => "All fields", "subject" => "Subject", "time" => "Time period", "location" => "Location"], null, ["class" => "form-control"]) !!}
                                </div>
                                <div class="col-md-9 input-group">
                                    {!! Form::text("q", '"'.Request::input("q").'"', array("id" => "q", "class" => "form-control", "placeholder" => "Search for resources in the Ariadne catalog ...")) !!}
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

    </div>

</div>

@endsection