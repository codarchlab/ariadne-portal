@extends('app')
@section('content')
<aside class="right-side"> 
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header" title="">
                        <h3 class="box-title">{{ $agent->name }}</h3>
                        <div class="box-tools pull-right">Added: {{ $agent->cr_tstamp }}</div>
                    </div>
                    <div class='box-body'>
                        <div class="row" style="padding: 14px;">
                            <div class="col-md-12">
                                <b>Name</b>
                                <p>{{ $agent->name }}</p>			
                            </div>
                            <div class="col-md-12">
                                <b>Type</b>
                                <p>
                                    {{ $agent->type }}
                                </p>			
                            </div>

                            @if(isset($agent->properties['phone']))
                            <div class="col-md-12">
                                <b>Phone</b>
                                <p>{{ $agent->properties['phone'] }}</p>			
                            </div>
                            @endif

                            @if(isset($agent->properties['mbox']))
                            <div class="col-md-12">
                                <b>Email</b>
                                <p>{{ $agent->properties['mbox'] }}</p>		
                            </div>
                            @endif

                            @if(isset($agent->properties['skypeID']))
                            <div class="col-md-12">
                                <b>Skype name</b>
                                <p>{{ $agent->properties['skypeID'] }}</p>			
                            </div>
                            @endif
                            
                            @if(isset($agent->properties['homepage']))
                            <div class="col-md-12">
                                <b>Homepage</b>
                                <p><a href="{{ $agent->properties['homepage'] }}">{{ $agent->properties['homepage'] }}</a></p>			
                            </div>
                            @endif
                        </div>
                    </div>					
                </div>
            </div>
        </div>
    </section>
</aside>
@endsection