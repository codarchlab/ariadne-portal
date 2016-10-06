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
    
    <div class="row">

        <div class="col-md-12">
            <h2>Web Services</h2>
        </div>

    </div>    

    @foreach($services['web_services'] as $service)
        @include('page.service', ['service' => $service])
    @endforeach
        
    <div class="row">

        <div class="col-md-12">
            <h2>Stand-alone Services</h2>
        </div>

    </div>       
    
    @foreach($services['stand_alone_services'] as $service)
        @include('page.service', ['service' => $service])
    @endforeach   
    
    <div class="row">

        <div class="col-md-12">
            <h2>Institutional Services</h2>
        </div>

    </div>       
    
    @foreach($services['institutional_services'] as $service)
        @include('page.service', ['service' => $service])
    @endforeach 
    
    <div class="row">

        <div class="col-md-12">
            <h2>Services for Humans</h2>
        </div>

    </div>       
    
    @foreach($services['human_services'] as $service)
        @include('page.service', ['service' => $service])
    @endforeach     
    
</div>

@endsection