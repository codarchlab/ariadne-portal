<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ARIADNE Portal</title>

        <link href="/css/app.css" rel="stylesheet">

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link rel="Shortcut icon" href="http://ariadne-infrastructure.eu/extension/mdr_site/design/ariadne/images/favicon.ico" type="image/x-icon" />

        <style>
            .modal.modal-wide .modal-dialog {
                width: 70%;
            }
            .modal-wide .modal-body {
                overflow-y: auto;
            }
        </style>

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

            <!-- Scripts -->
            <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

            <!-- jQuery 2.0.2 -->

            <script src="https://maps.googleapis.com/maps/api/js"></script>
            <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>


            <!-- jQuery UI 1.10.3 -->
            <script src="/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
            <!-- Bootstrap -->
            <script src="/js/bootstrap.min.js" type="text/javascript"></script>
            <!-- Morris.js charts -->
            <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
            <script src="/js/plugins/morris/morris.min.js" type="text/javascript"></script>
            <!-- Sparkline -->
            <script src="/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
            <!-- jvectormap -->
            <script src="/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
            <script src="/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
            <!-- fullCalendar -->
            <script src="/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
            <!-- jQuery Knob Chart -->
            <script src="/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
            <!-- daterangepicker -->
            <script src="/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
            <!-- Bootstrap WYSIHTML5 -->
            <script src="/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
            <!-- iCheck -->
            <script src="/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

            <!-- FLOT CHARTS -->
            <script src="/js/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
            <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
            <script src="/js/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
            <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
            <script src="/js/plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
            <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
            <script src="/js/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>            


            <!-- AdminLTE App -->
            <script src="/js/AdminLTE/app.js" type="text/javascript"></script>        
    </body>
</html>
