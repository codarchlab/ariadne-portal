@extends('app')
@section('title', 'Services - Ariadne portal')

@section('description', 'ARIADNE brings together and integrates existing archaeological research data infrastructures
so that researchers can use the various distributed datasets and new and powerful technologies as an integral
component of the archaeological research methodology.')
@section('keywords', 'Archaeological Research Data Infrastructures, Metadata Registry, Services')

@section('content')

<div id="servicespage" class="container content">

    <!-- Main content -->
    <div class="row">

        <div class="col-md-12">
            <h1>Services</h1>
        </div>

    </div>

    <div class="row service">
        <div class="col-md-4">
            <a href="http://visual.ariadne-infrastructure.eu/">
                <img class="img-thumbnail" src="{{ asset("img/services/visual_media_service.png") }}" alt="The Visual Media Service" />
            </a>                      
        </div>

        <div class="col-md-8">
            <h4>The Visual Media Service</h4>
            <p>
              The ARIADNE Visual Media Service provides easy publication and presentation on the web of complex visual media assets. 
              It is an automatic service that allows to upload visual media files on an ARIADNE server and to transform them into an efficient web format, 
              making them ready for web-based visualization.
            </p>
            
            <p>
                <a href="http://visual.ariadne-infrastructure.eu/">http://visual.ariadne-infrastructure.eu <span class="glyphicon glyphicon-new-window" data-toggle="tooltip" data-placement="bottom" title="The Visual Media Service"></span></a>
            </p>            
        </div>
    </div>
    
    <div class="row service">
        <div class="col-md-4">
            <a href="http://landscape.ariadne-infrastructure.eu/">
                <img class="img-thumbnail" src="{{ asset("img/services/landscape_services.png") }}" alt="Landscape Services">
            </a>
        </div>

        <div class="col-md-8">
            <h4>The Landscape Services</h4>
            <p>
              <i>Landscape Services</i> for <a href="http://www.ariadne-infrastructure.eu/">ARIADNE</a> are a set of responsive web services that include large terrain datasets generation, 
              3D landscape composing and 3D model processing, leveraging on powerful open-source frameworks and toolkits such as 
              <a href="http://www.gdal.org/">GDAL</a>, <a href="http://osgjs.org/">OSGjs</a>, <a href="http://www.openscenegraph.com">OpenSceneGraph</a> and <a href="http://www.owncloud.org">ownCloud</a>.
            </p>
            <p>
                <a href="http://landscape.ariadne-infrastructure.eu/">http://landscape.ariadne-infrastructure.eu <span class="glyphicon glyphicon-new-window" data-toggle="tooltip" data-placement="bottom" title="The Landscape Services"></span></a>
            </p>
        </div>
    </div>      

</div>

@endsection