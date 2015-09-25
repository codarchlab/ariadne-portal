<nav class="navbar navbar-default navbar-fixed-top navbar-big">

    <div class="container-fluid">

        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ action('WelcomeController@index') }}">
                <img id="logo-symbol" src="{{ asset("img/logo-symbol.png") }}">
            </a>

        </div>

        <div id="navbar" class="collapse navbar-collapse">

            <ul class="nav navbar-nav">

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

        </div>

    </div>

</nav>