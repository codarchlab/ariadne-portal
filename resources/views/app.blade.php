<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
       
        @yield('headers')
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        
        <title>@yield('title')</title>

        @if(env('APP_ENV') != 'production')
        <meta name="robots" content="noindex">
        @endif

        <link href="https://fonts.googleapis.com/css?family=Roboto:400,400italic,700&subset=latin,latin-ext" rel="stylesheet" type="text/css">
        
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet">


        <link rel="Shortcut icon" href="http://ariadne-infrastructure.eu/extension/mdr_site/design/ariadne/images/favicon.ico" type="image/x-icon" />

        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body {{ (Request::is('/') ? ' id=frontpage' : '') }} itemscope itemtype="http://schema.org/DataCatalog">
        
        <!-- combined JS code -->
        <script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
             
        @include('shared._navigation')
        
        @yield('content')

        @include('shared._footer')
        
              

    </body>
</html>
