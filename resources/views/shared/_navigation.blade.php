<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header"><!-- Visible with Mobile view -->
                
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-small-screen" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            @if( !Request::is('/') ) 
            <a class="navbar-brand" href="http://www.ariadne-infrastructure.eu">
              <img id="brand" src="{{ asset("img/logo-symbol.png") }}">
            </a>
            @endif
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse-small-screen"><!-- Visible Desktop view -->
            <ul class="nav nav-justified">

                @if( !Request::is('/') ) 
                <li id="navSearch">
                  {!! Form::open(array("id" => "catalogSearch", "action" => "ResourceController@search", "method" => "GET")) !!}
                    <div class="input-group">
                      {!! Form::text("q", "", array("id" => "q", "class" => "form-control", "placeholder" => "Start a new search...")) !!}
                      <span class="input-group-btn">
                        {!! Form::button('&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;', array("type" => "submit", "class" => "btn btn-primary")) !!}
                      </span>
                    </div>
                  {!! Form::close() !!}
                </li>
                @endif            
              
                <li id="navCatalog">
                    <a href="{{ action('PageController@welcome') }}"><span class="glyphicon glyphicon-globe"></span> Catalog</a>
                </li>

                <li id="navServices">
                    <a href="#"><span class="glyphicon glyphicon-cog"></span> Services</a>
                </li>
                
                <li id="navExperiments">
                    <a href="#">
                        <span class="glyphicon glyphicon-grain"></span> Experiments</a>
                </li>

                <li id="navAbout" {{ (Request::is('about') ? ' class=active' : '') }}>
                    <a href="{{ action('PageController@about') }}"><span class="glyphicon glyphicon-question-sign"></span> About</a>
                </li>      
                                
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
