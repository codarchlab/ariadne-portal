<nav {{ (Request::is('/') ? ' id=navbar-big' : 'id=navbar-small') }}>

    <div id="logo">

        <a class="navbar-brand" href="{{ action('WelcomeController@index') }}">
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

        <li id="navBrowse">
            <a href="{{ action('MapController@index') }}">
                <span class="glyphicon glyphicon-globe"></span>
                Browse
            </a>
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
            <a href="{{ action('WelcomeController@about') }}">
                <span class="glyphicon glyphicon-question-sign"></span>
                About
            </a>
        </li>
    </ul>

</nav>