@extends('app')

@section('content')

<div class="row">

    <div class="col-md-6 col-md-offset-3 text-center search-form">
        
        <img id="searchlogo" class="img-responsive" src="img/logo-white.png">

        {!! Form::open(array("action" => "ResourceController@search", "method" => "GET")) !!}
            <div class="input-group">
                {!! Form::text("q", Request::input("q"), array("id" => "q", "class" => "form-control", "placeholder" => "Search for resources in the Ariadne catalog ...")) !!}
                <span class="input-group-btn">
                    {!! Form::button('&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;', array("type" => "submit", "class" => "btn btn-primary")) !!}
                </span>
            </div>
        {!! Form::close() !!}
    </div>

</div>

@endsection