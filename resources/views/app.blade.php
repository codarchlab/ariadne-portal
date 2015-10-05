<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ARIADNE Portal</title>

        <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="Shortcut icon" href="http://ariadne-infrastructure.eu/extension/mdr_site/design/ariadne/images/favicon.ico" type="image/x-icon" />
        
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body {{ (Request::is('/') ? ' id=frontpage' : '') }}>
        
        @include('shared._navigation')

        <!-- Google Maps libraries -->
        <script src="https://maps.googleapis.com/maps/api/js?libraries=drawing"></script>
        <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>

        <!-- combined JS code -->
        <script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>

        <div class="container-fluid">
            @yield('content')
        </div>
                  
    </body>
</html>
