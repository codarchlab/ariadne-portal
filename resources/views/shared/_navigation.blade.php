<nav {{ (Request::is('/') ? 'id=navbar-big' : 'id=navbar-small') }}>

    <div id="logo">

        <a class="navbar-brand" href="http://www.ariadne-infrastructure.eu">
            <img id="brand" src="{{ asset("img/logo-symbol.png") }}">
        </a>

        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

    </div>

    <ul class="nav navbar-fixed-top nav-justified navbar-main">

        <li id="navCatalog">
            <a href="{{ action('BrowseController@map') }}">
                <span class="glyphicon glyphicon-globe"></span>
                Catalog
            </a>
        </li>

        <li id="navSearch">

            {!! Form::open(array("action" => "ResourceController@search", "method" => "GET")) !!}

            <div class="input-group">
                {!! Form::text("q", Request::input("q"), array("id" => "q", "class" => "form-control", "placeholder" => "Search...")) !!}
            <span class="input-group-btn">
                {!! Form::button('&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;', array("type" => "submit", "class" => "btn btn-primary")) !!}
            </span>
            </div>
            {!! Form::close() !!}

        </li>

        <li id="navServices">
            <a href="#">
                <span class="glyphicon glyphicon-cog"></span>
                Services
            </a>
        </li>

        <li id="navExperiments">
            <a href="#">
                <span class="glyphicon glyphicon-grain"></span>
                Experiments
            </a>
        </li>

        <li id="navAbout" {{ (Request::is('about') ? ' class=active' : '') }}>
            <a href="{{ action('PageController@about') }}">
                <span class="glyphicon glyphicon-question-sign"></span>
                About
            </a>
        </li>

    </ul>

</nav>