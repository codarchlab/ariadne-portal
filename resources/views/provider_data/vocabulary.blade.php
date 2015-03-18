
@extends('app')
@section('content')

<aside class="right-side"> 
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header" title="">
                        <h3 class="box-title">{{ $vocabulary->name }}</h3>
                        <div class="box-tools pull-right">Added: {{ date("d-m-Y", strtotime($vocabulary->cr_tstamp)) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" value="{{ $vocabulary->id }}" name="id" />
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_general" data-toggle="tab">General</a></li>                                                
                        @if (isset($vocabulary->properties['creator']) || isset($vocabulary->properties['publisher']) || isset($vocabulary->properties['usedby']))                      
                        <li><a href="#tab_ownership" data-toggle="tab">Ownership</a></li>
                        @endif
                    </ul>                   
                    <div class="tab-content">
                         <div class="tab-pane active" id="tab_general">
                            <div class="row" style="padding: 14px;">
                                <div class="col-md-12">
                                    <b>Identifier</b>
                                    <p>dat: {{ $vocabulary->id }}</p>
                                </div>

                                @if (isset($vocabulary->properties['originalId']))
                                <div class="col-md-12">
                                    <b>Other Identifiers</b>
                                    @foreach($vocabulary->properties['originalId'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach 
                                </div>
                                @endif
                                
                                @if (!empty($vocabulary->name))
                                <div class="col-md-12">
                                    <b>Title</b>
                                    <p>{{ $vocabulary->name }}</p>
                                </div>
                                @endif
                                                               
                                @if (!empty($vocabulary->agent_name))
                                <div class="col-md-12">
                                    <b>Agent</b>
                                    <p>{{ $vocabulary->agent_name }}</p>
                                </div>
                                @endif
                                
                                @if (isset($vocabulary->properties['description']))
                                <div class="col-md-12">
                                    <b>Description</b>
                                    @foreach($vocabulary->properties['description'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif                                
                                   
                                @if (isset($vocabulary->properties['status']))
                                <div class="col-md-12">
                                    <b>Status</b>
                                    @foreach($vocabulary->properties['status'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($vocabulary->properties['homepage']))
                                <div class="col-md-12">
                                    <b>Homepage</b>
                                    @foreach($vocabulary->properties['homepage'] as $value)
                                    <p><a href="{{ $value }}">{{ $value }}</a></p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($vocabulary->properties['hasConcept']))
                                <div class="col-md-12">
                                    <b>Has concept</b>
                                    @foreach($vocabulary->properties['hasConcept'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($vocabulary->properties['hasVersion']))
                                <div class="col-md-12">
                                    <b>Has version</b>
                                    @foreach($vocabulary->properties['hasVersion'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($vocabulary->properties['language']))
                                <div class="col-md-12">
                                    <b>Language</b>
                                    @foreach($vocabulary->properties['language'] as $value)
                                    <p>{{ $value }} <img src='../img/language/{{ $value }}.png' style='height: 24px;'/></p>
                                    @endforeach
                                </div>
                                @endif
                                
                            </div>
                        </div>  
                        
                        @if (isset($vocabulary->properties['creator']) || isset($vocabulary->properties['publisher']) || isset($vocabulary->properties['usedby']))                      

                        <div class="tab-pane" id="tab_ownership">
                            <div class="row" style="padding: 14px;">

                                @if (isset($vocabulary->properties['creator']))
                                <div class="col-md-12">
                                    <b>Creator</b>
                                    @foreach($vocabulary->properties['creator'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif


                                @if (isset($vocabulary->properties['publisher']))
                                <div class="col-md-12">
                                    <b>Publisher</b>
                                    @foreach($vocabulary->properties['publisher'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($vocabulary->properties['usedby']))
                                <div class="col-md-12">
                                    <b>Used by</b>
                                    @foreach($vocabulary->properties['usedby'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                         
                            </div>
                        </div>                                

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>

@endsection

