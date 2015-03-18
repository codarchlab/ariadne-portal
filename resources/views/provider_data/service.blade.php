
@extends('app')
@section('content')

<aside class="right-side"> 
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header" title="">
                        <h3 class="box-title">{{ $service->name }}</h3>
                        <div class="box-tools pull-right">Added: {{ date("Y-m-d", strtotime($service->cr_tstamp)) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" value="{{ $service->id }}" name="id" />
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_general" data-toggle="tab">General</a></li>                                                
                        @if (isset($service->properties['byteSize']) || isset($service->properties['genre']) || isset($service->properties['operatingSystem']) || isset($service->properties['programmingLanguage'])
                        || isset($service->properties['exportFacility']) || isset($service->properties['isInRepository']) || isset($service->properties['developer'])
                        || isset($service->properties['requirements']) || isset($service->properties['latestReleaseVersion']) || isset($service->properties['hasApi'])
                        || isset($service->properties['hasTechnicalSupport']) || isset($service->properties['hasComponents']))                        
                        <li><a href="#tab_tech" data-toggle="tab">Technical</a></li>
                        @endif
                        @if (isset($service->properties['license']))      
                        <li><a href="#tab_rights" data-toggle="tab">Rights</a></li>
                        @endif
                        @if (isset($service->properties['comment']) || isset($service->properties['homepage']))
                        <li><a href="#tab_other" data-toggle="tab">Other</a></li>
                        @endif
                    </ul>                   
                    <div class="tab-content">
                         <div class="tab-pane active" id="tab_general">
                            <div class="row" style="padding: 14px;">
                                <div class="col-md-12">
                                    <b>Identifier</b>
                                    <p>dat: {{ $service->id }}</p>
                                </div>

                                @if (isset($service->properties['originalId']))
                                <div class="col-md-12">
                                    <b>Other Identifiers</b>
                                    @foreach($service->properties['originalId'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach 
                                </div>
                                @endif
                                
                                @if (!empty($service->name))
                                <div class="col-md-12">
                                    <b>About</b>
                                    <p>{{ $service->name }}</p>
                                </div>
                                @endif
                                
                                @if (isset($service->properties['dbpedia_owl_abstract']))
                                <div class="col-md-12">
                                    <b>Abstract</b>
                                    @foreach($service->properties['dbpedia_owl_abstract'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (!empty($service->agent_name))
                                <div class="col-md-12">
                                    <b>Agent</b>
                                    <p>{{ $service->agent_name }}</p>
                                </div>
                                @endif
                                
                                @if (isset($service->properties['issued']))
                                <div class="col-md-12">
                                    <b>Issued</b>                                   
                                    @foreach($service->properties['issued'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach                            
                                </div>
                                @endif
                                
                                @if (isset($service->properties['modified']))
                                <div class="col-md-12">
                                    <b>Modified</b>                                   
                                    @foreach($service->properties['modified'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach                            
                                </div>
                                @endif
                                                                
                                @if (isset($service->properties['downloadURL']))
                                <div class="col-md-12">
                                    <b>URL</b>
                                    @foreach($service->properties['downloadURL'] as $value)
                                    <p><a href="{{ $value }}">{{ $value }}</a></p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($service->properties['dbpedia_owl_status']))
                                <div class="col-md-12">
                                    <b>Status</b>
                                    @foreach($service->properties['dbpedia_owl_status'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                            </div>
                        </div>  
                        
                        @if (isset($service->properties['byteSize']) || isset($service->properties['genre']) || isset($service->properties['operatingSystem']) || isset($service->properties['programmingLanguage'])
                        || isset($service->properties['exportFacility']) || isset($service->properties['isInRepository']) || isset($service->properties['developer'])
                        || isset($service->properties['installationRequirements']) || isset($service->properties['latestReleaseVersion']) || isset($service->properties['hasApi'])
                        || isset($service->properties['hasTechnicalSupport']) || isset($service->properties['hasComponents']))

                        <div class="tab-pane" id="tab_tech">
                            <div class="row" style="padding: 14px;">

                                @if (isset($service->properties['byteSize']))
                                <div class="col-md-12">
                                    <b>Byte size</b>
                                    @foreach($service->properties['byteSize'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif


                                @if (isset($service->properties['genre']))
                                <div class="col-md-12">
                                    <b>Genre</b>
                                    @foreach($service->properties['genre'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($service->properties['dbpedia_owl_operatingSystem']))
                                <div class="col-md-12">
                                    <b>Operating system</b>
                                    @foreach($service->properties['dbpedia_owl_operatingSystem'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($service->properties['programmingLanguage']))
                                <div class="col-md-12">
                                    <b>Programming Language</b>
                                    @foreach($service->properties['programmingLanguage'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($service->properties['exportFacility']))
                                <div class="col-md-12">
                                    <b>Byte size</b>
                                    @foreach($service->properties['exportFacility'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($service->properties['isInRepository']))
                                <div class="col-md-12">
                                    <b>Is in repository</b>
                                    @foreach($service->properties['isInRepository'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($service->properties['developer']))
                                <div class="col-md-12">
                                    <b>Developer</b>
                                    @foreach($service->properties['developer'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($service->properties['installationRequirements']))
                                <div class="col-md-12">
                                    <b>Requirements</b>
                                    @foreach($service->properties['installationRequirements'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($service->properties['latestReleaseVersion']))
                                <div class="col-md-12">
                                    <b>Latest Release Version</b>
                                    @foreach($service->properties['latestReleaseVersion'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($service->properties['hasApi']))
                                <div class="col-md-12">
                                    <b>has Api</b>
                                    @foreach($service->properties['hasApi'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($service->properties['hasTechnicalSupport']))
                                <div class="col-md-12">
                                    <b>has Technical Support</b>
                                    @foreach($service->properties['hasTechnicalSupport'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($service->properties['hasComponents']))
                                <div class="col-md-12">
                                    <b>has Components</b>
                                    @foreach($service->properties['hasComponents'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                            </div>
                        </div>                                

                        @endif

                        @if (isset($service->properties['license'])) 
                        
                        <div class="tab-pane" id="tab_rights">
                            <div class="row" style="padding: 14px;">
                                @if (isset($service->properties['license']))
                                <div class="col-md-12">
                                    <b>License</b>
                                    @foreach($service->properties['license'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif                          

                            </div>
                        </div>

                        @endif

                        @if (isset($service->properties['comment']) || isset($service->properties['homepage']))
                        <div class="tab-pane" id="tab_other">
                            <div class="row" style="padding: 14px;">

                                @if (isset($service->properties['comment'])) 
                                <div class="col-md-12">
                                    <b>Comment</b>
                                    @foreach($service->properties['comment'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif   

                                @if (isset($service->properties['homepage'])) 
                                <div class="col-md-12">
                                    <b>Homepage</b>
                                    @foreach($service->properties['homepage'] as $value)
                                    <p><a href="{{ $value }}">{{ $value }}</a></p>
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

