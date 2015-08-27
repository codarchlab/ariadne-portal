<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ARIADNE Portal</title>

        <link href="/css/app.css" rel="stylesheet">

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="/css/app.css" rel="stylesheet" type="text/css" />
        <link rel="Shortcut icon" href="http://ariadne-infrastructure.eu/extension/mdr_site/design/ariadne/images/favicon.ico" type="image/x-icon" />
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="/" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="{{ asset("img/logo2.png") }}" height="40" style="position:relative; " border="0" />
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">


                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">        

            @include('shared._navigation')

            @yield('content')

            <script src="https://maps.googleapis.com/maps/api/js?libraries=drawing"></script>
            <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>


            <!-- jQuery UI 1.10.3 -->
            <script src="/js/app.js" type="text/javascript"></script>
                  
    </body>
</html>
