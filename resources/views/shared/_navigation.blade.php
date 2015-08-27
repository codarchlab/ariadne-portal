<nav class="navbar navbar-inverse navbar-fixed-top">

    <div class="container-fluid">
    
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ action('WelcomeController@index') }}">
                <img src="{{ asset("img/logo.png") }}" height="30">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">             
                <li {{ (Request::is('search') ? 'class=active' : '') }}>
                    <a href="{{ action('SearchController@index') }}">
                        <span class="glyphicon glyphicon-search"></span>
                        Search
                    </a>
                </li>
                <li>
                    <a href="{{ action('MapController@index') }}">
                        <span class="glyphicon glyphicon-map-marker"></span>
                        Map based search
                    </a>
                </li>
                <li {{ (Request::is('provider') ? 'class=active' : '') }}>
                    <a href="{{ action('ProviderController@index') }}">
                        <span class="glyphicon glyphicon-user"></span>
                        Provider info
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                            role="button" aria-haspopup="true"
                            aria-expanded="false">
                        <span class="glyphicon glyphicon-list"></span>
                        Provider data
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                       <li{{ (Request::is('collection') ? ' class=active' : '') }}>
                            <a href="{{ action('CollectionController@index') }}">
                                <span class="glyphicon glyphicon-folder-close"></span>
                                Collections
                            </a>
                        </li>
                       <li{{ (Request::is('dataset') ? ' class=active' : '') }}>
                            <a href="{{ action('DatasetController@index') }}">
                                <span class="glyphicon glyphicon-compressed"></span>
                                Datasets
                            </a>
                        </li>                               
                        <li {{ (Request::is('database') ? ' class=active' : '') }}>
                            <a href="{{ action('DatabaseController@index') }}">
                                <span class="glyphicon glyphicon-cloud"></span>
                                Databases
                            </a>
                        </li>   
                       <li{{ (Request::is('gis') ? ' class=active' : '') }}>
                            <a href="{{ action('GisController@index') }}">
                                <span class="glyphicon glyphicon-globe"></span>
                                GIS
                            </a>
                        </li>
                       <li{{ (Request::is('textualDocument') ? ' class=active' : '') }}>
                            <a href="{{ action('TextualDocumentController@index') }}">
                                <span class="glyphicon glyphicon-file"></span>
                                Textual Documents
                            </a>
                        </li>
                        <!--
                        <li {{ (Request::is('metaSchema') ? ' class=active' : '') }}>
                            <a href="{{ action('MetaSchemaController@index') }}">
                                Metadata Schemas
                            </a>
                        </li>   
                        <li {{ (Request::is('service') ? ' class=active' : '') }}>
                            <a href="{{ action('ServiceController@index') }}">
                                Services
                            </a>
                        </li>   
                        <li {{ (Request::is('vocabulary') ? ' class=active' : '') }}>
                            <a href="{{ action('VocabularyController@index') }}">
                                Vocabularies
                            </a>
                        </li>
                       <li{{ (Request::is('agent') ? ' class=active' : '') }}>
                            <a href="{{ action('AgentController@index') }}">
                                Agents
                            </a>
                        </li>-->                                
                    </ul>
                </li> 
                <li{{ (Request::is('subject') ? ' class=active' : '') }}>
                    <a href="{{ action('SubjectController@index') }}">
                        <span class="glyphicon glyphicon-tags"></span>
                        Ariadne subject
                    </a>
                </li> 
                <li{{ (Request::is('about') ? ' class=active' : '') }}>
                    <a href="{{ action('WelcomeController@about') }}">
                        <span class="glyphicon glyphicon-question-sign"></span>
                        About
                    </a>
                </li>
            </ul>

        </div>
    </div>

</nav>