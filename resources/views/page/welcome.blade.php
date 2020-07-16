@extends('app')
@section('title', 'Welcome - Ariadne portal')

@section('description', 'ARIADNE brings together and integrates existing archaeological research data infrastructures
so that researchers can use the various distributed datasets and new and powerful technologies as an integral
component of the archaeological research methodology.')
@section('keywords', 'Archaeological Research Data Infrastructures, Metadata Registry')

@section('content')

<script>

    /**
     *  Set available query fields for dropdown menu
     *  (see script element at the end of the template)
     */
    var queryFields = {
        "All fields": "",
        "Subject": "derivedSubject",
        "Identifier": "identifier",
        "Time period": "time",
        "Place": "location",
        "Title": "title",
        "Original subject": "nativeSubject"
    };

    /**
     * Randomize background image
     */
    var bgr = [
        'img/frontpage/sitebgr_01.jpg',
        'img/frontpage/sitebgr_02.jpg',
        'img/frontpage/sitebgr_05.jpg',
        'img/frontpage/sitebgr_06.jpg',
        'img/frontpage/sitebgr_07.jpg',
        'img/frontpage/sitebgr_08.jpg',
        'img/frontpage/sitebgr_09.jpg',
        'img/frontpage/sitebgr_10.jpg',
        'img/frontpage/sitebgr_11.jpg',
        'img/frontpage/sitebgr_12.jpg',
        'img/frontpage/sitebgr_13.jpg',
        'img/frontpage/sitebgr_14.jpg',
        'img/frontpage/sitebgr_16.jpg',
        'img/frontpage/sitebgr_17.jpg',
        'img/frontpage/sitebgr_18.jpg',
        'img/frontpage/sitebgr_20.jpg',
        'img/frontpage/sitebgr_21.jpg'
        ];

    var image = bgr[Math.floor(Math.random() * bgr.length)];
    $('body').css('background-image', 'url(' + image + ')');

</script>

<div class="container content">
    <div class="row">

        <div class="col-md-10 col-md-offset-1 text-center search-form">

            <div id="welcomeSearch">

                <img id="searchlogo" class="img-responsive" src="img/logo.png">

                <div class="row">
                    <div class="col-md-8 col-md-offset-2">

                        {!! Form::open(array("action" => "ResourceController@search", "method" => "GET", "class" => "form-inline", "id" => "catalogSearch")) !!}
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="select-field-btn input-group-btn">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span id="query-field-label">All fields</span>
                                        <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" id="query-fields-list">
                                        </ul>
                                    </div>
                                    <input type="hidden" name="fields" id="query-field-input" value="">
                                    {!! Form::text("q", Request::input("q"), array("id" => "q", "class" => "form-control typeahead", "placeholder" => "Search for resources in the Ariadne catalog ...", "autofocus" => "autofocus")) !!}
                                    <div class="submit-btn input-group-btn">
                                        {!! Form::button('&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;', array("type" => "submit", "class" => "btn btn-primary")) !!}
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="row" id="welcomeDetails">

        <div class="col-md-10 col-md-offset-1">

            <div class="row">

                <div class="col-md-12">

                    <div class="welcomebox">

                        <h1>Welcome</h1>
                        <p>
                            Explore the digital resources and services that ARIADNE has brought together from across Europe for archaeological research, learning and teaching.
                        </p>

                    </div>

                    <div class="welcomebox browse">

                        <h1>Browse the Catalog</h1>

                        <div class="row">
                            <div class="col-md-4" id="where">                                
                                <a href="{{ action('BrowseController@where') }}" class="btn btn-primary white-btn-primary">
                                    <span class="glyphicon glyphicon-globe"></span> Where
                                </a>
                                <div class="imageBox">
                                    <a href="{{ action('BrowseController@where') }}"><img src="img/where.png" class="img-responsive image"></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ action('BrowseController@when') }}" class="btn btn-primary white-btn-primary">
                                    <span class="glyphicon glyphicon-stats"></span> When
                                </a>
                                <div class="imageBox">
                                    <a href="{{ action('BrowseController@when') }}"><img src="img/when.png" class="img-responsive image"></a>
                                </div>
                            </div>
                            <div class="col-md-4">
                              <div id="wordCloud" class="wordCloudContainerWelcome">"@include('shared._word_cloud')"</div>
                              <a href="{{ action('BrowseController@what') }}" class="btn btn-primary white-btn-primary"><span class="glyphicon glyphicon-list"></span> What</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
<script>

    var suggest = new Suggest('#catalogSearch .typeahead').create();

    for (var key in queryFields) {
        $('#query-fields-list').append('<li><a href="#" onclick="setQueryField(\'' + key + '\')">' + key + '</a></li>');
    }

    function setQueryField(key) {
        $('#query-field-input').val(queryFields[key]);
        $('#query-field-label').text(key);
        $("input[autofocus]").focus();
        if ($.inArray(key, ['Subject', 'ARIADNE subject', 'All fields']) != -1) {
            suggest.create();
        } else {
            suggest.destroy();
        }
    }

    $("input[autofocus]").focus();

</script>

@endsection