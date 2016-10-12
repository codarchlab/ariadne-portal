@extends('app')
@section('title', 'Services - Ariadne portal')

@section('description', 'ARIADNE brings together and integrates existing archaeological research data infrastructures
so that researchers can use the various distributed datasets and new and powerful technologies as an integral
component of the archaeological research methodology.')
@section('keywords', 'Archaeological Research Data Infrastructures, Metadata Registry, Services')

@section('content')

<div id="servicespage" class="container content">

    <div class="row">

        <div class="col-md-12">
            <h1>Services</h1>
        </div>

    </div>
    
    <!-- Search bar -->
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <input class="service-search" type="text" name="service_search" placeholder="{{ trans('service.search') }}" autofocus>
        </div>
    </div>

    <!-- Services -->  
    <div id="services">
    
        <div class="first-row row service_divider" data-type="web_services">

            <div class="col-md-12">
                <h2>Web Services</h2>
            </div>

        </div>    

        @foreach($services['web_services'] as $service)
            @include('page.service', ['service' => $service, 'type' => 'web_services'])
        @endforeach
            
        <div class="row service_divider" data-type="stand_alone_services">

            <div class="col-md-12">
                <h2>Stand-alone Services</h2>
            </div>

        </div>       
        
        @foreach($services['stand_alone_services'] as $service)
            @include('page.service', ['service' => $service, 'type' => 'stand_alone_services'])
        @endforeach   
        
        <div class="row service_divider" data-type="institutional_services">

            <div class="col-md-12">
                <h2>Institutional Services</h2>
            </div>

        </div>       
        
        @foreach($services['institutional_services'] as $service)
            @include('page.service', ['service' => $service, 'type' => 'institutional_services'])
        @endforeach 
        
        <div class="row service_divider" data-type="human_services">

            <div class="col-md-12">
                <h2>Services for Humans</h2>
            </div>

        </div>       
        
        @foreach($services['human_services'] as $service)
            @include('page.service', ['service' => $service, 'type' => 'human_services'])
        @endforeach     
    
        <div class="row" id="no-services" style="display:none;">

            <div class="col-md-12">
                <h2>No services matching &quot;<span id="match-phrase">katt</span>&quot;</h2>
            </div>

        </div> 
    
    </div>
    
</div>

@endsection