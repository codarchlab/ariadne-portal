
@extends('app')
@section('content')

<aside class="right-side"> 
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header" title="">
                        <h3 class="box-title">{{ $metaSchema->name }}</h3>
                        <div class="box-tools pull-right">Added: {{ date("d-m-Y", strtotime($metaSchema->cr_tstamp)) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" value="{{ $metaSchema->id }}" name="id" />
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_general" data-toggle="tab">General</a></li>
                        @if (isset($metaSchema->properties['keyword']) || isset($metaSchema->properties['subject']))                        
                        <li><a href="#tab_subjects" data-toggle="tab">Subjects</a></li>
                        @endif
                        @if (isset($metaSchema->properties['accessPolicy']) || isset($metaSchema->properties['accessRights']) || isset($metaSchema->properties['rights']))      
                        <li><a href="#tab_rights" data-toggle="tab">Rights</a></li>
                        @endif
                        @if (isset($metaSchema->properties['creator']) || isset($metaSchema->properties['owner']) || isset($metaSchema->properties['publisher']) || isset($metaSchema->properties['used']) ||
                        isset($metaSchema->properties['legalResponsible']) || isset($metaSchema->properties['scientificResponsible']) || isset($metaSchema->properties['technicalResponsible']))                          
                        <li><a href="#tab_ownership" data-toggle="tab">Ownership</a></li>
                        @endif
                        @if (isset($metaSchema->properties['standardUsed']) || isset($metaSchema->properties['proprietaryFormatDesc']) || isset($metaSchema->properties['homepage']))
                        <li><a href="#tab_other" data-toggle="tab">Other</a></li>.
                        @endif
                    </ul>                   
                    <div class="tab-content">
                         <div class="tab-pane active" id="tab_general">
                            <div class="row" style="padding: 14px;">
                                <div class="col-md-12">
                                    <b>Identifier</b>
                                    <p>dat: {{ $metaSchema->id }}</p>
                                </div>

                                @if (isset($metaSchema->properties['originalId']))
                                <div class="col-md-12">
                                    <b>Other Identifiers</b>
                                    <p>{{ $metaSchema->properties['originalId'] }}</p>  
                                </div>
                                @endif
                                
                                @if (!empty($metaSchema->name))
                                <div class="col-md-12">
                                    <b>Title</b>
                                    <p>{{ $metaSchema->name }}</p>
                                </div>
                                @endif
                                
                                @if (isset($metaSchema->properties['description']))
                                <div class="col-md-12">
                                    <b>Description</b>
                                    @foreach($metaSchema->properties['description'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (!empty($metaSchema->agent_name))
                                <div class="col-md-12">
                                    <b>Agent</b>
                                    <p>{{ $metaSchema->agent_name }}</p>
                                </div>
                                @endif
                                
                                @if (isset($metaSchema->properties['issued']))
                                <div class="col-md-12">
                                    <b>Issued</b>                                   
                                    @foreach($metaSchema->properties['issued'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach                            
                                </div>
                                @endif
                                
                                @if (isset($metaSchema->properties['modified']))
                                <div class="col-md-12">
                                    <b>Modified</b>                                   
                                    @foreach($metaSchema->properties['modified'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach                            
                                </div>
                                @endif
                                
                                @if (isset($metaSchema->properties['language']))
                                <div class="col-md-12">
                                    <b>Language</b>
                                    @foreach($metaSchema->properties['language'] as $value)
                                    <p>{{ $value }} <img src='../img/language/{{ $value }}.png' style='height: 24px;'/></p>
                                    @endforeach
                                </div>
                                @endif
                                
                                @if (isset($metaSchema->properties['landingPage']))
                                <div class="col-md-12">
                                    <b>URL</b>
                                    @foreach($metaSchema->properties['landingPage'] as $value)
                                    <p><a href="{{ $value }}">{{ $value }}</a></p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($metaSchema->properties['audience']))
                                <div class="col-md-12">
                                    <b>Audience</b>
                                    @foreach($metaSchema->properties['audience'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                                
                            </div>
                        </div>  
                    @if (isset($metaSchema->properties['keyword']) || isset($metaSchema->properties['subject']) )  

                        <div class="tab-pane" id="tab_subjects">
                            <div class="row" style="padding: 14px;">

                                @if (isset($metaSchema->properties['subject']))
                                <div class="col-md-12">
                                    <b>Other subject</b>
                                    @foreach($metaSchema->properties['subject'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($metaSchema->properties['keyword']))
                                <div class="col-md-12">
                                    <b>Keywords</b>
                                    @foreach($metaSchema->properties['keyword'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                            </div>
                        </div>                                

                        @endif

                        @if (isset($metaSchema->properties['accessPolicy']) || isset($metaSchema->properties['accessRights']) || isset($metaSchema->properties['rights']))      

                        <div class="tab-pane" id="tab_rights">
                            <div class="row" style="padding: 14px;">
                                @if (isset($metaSchema->properties['accessPolicy']))
                                <div class="col-md-12">
                                    <b>Access Policy</b>
                                    @foreach($metaSchema->properties['accessPolicy'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($metaSchema->properties['accessRights']))
                                <div class="col-md-12">
                                    <b>Access Rights</b>
                                    @foreach($metaSchema->properties['accessRights'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($metaSchema->properties['rights'])) 
                                <div class="col-md-12">
                                    <b>Other rights</b>
                                    @foreach($metaSchema->properties['rights'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif                                

                            </div>
                        </div>

                        @endif

                        @if (isset($metaSchema->properties['creator']) || isset($metaSchema->properties['owner']) || isset($metaSchema->properties['publisher']) ||
                        isset($metaSchema->properties['legalResponsible']) || isset($metaSchema->properties['scientificResponsible']) || isset($metaSchema->properties['technicalResponsible'])|| isset($metaSchema->properties['used']))           

                        <div class="tab-pane" id="tab_ownership">
                            <div class="row" style="padding: 14px;">

                                @if (isset($metaSchema->properties['creator'])) 
                                <div class="col-md-12">
                                    <b>Creator</b>
                                    @foreach($metaSchema->properties['creator'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif   

                                @if (isset($metaSchema->properties['owner'])) 
                                <div class="col-md-12">
                                    <b>Owner</b>
                                    @foreach($metaSchema->properties['owner'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif   

                                @if (isset($metaSchema->properties['publisher'])) 
                                <div class="col-md-12">
                                    <b>Publisher</b>
                                    @foreach($metaSchema->properties['publisher'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif   
                                
                                @if (isset($metaSchema->properties['used'])) 
                                <div class="col-md-12">
                                    <b>Used by</b>
                                    @foreach($metaSchema->properties['used'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif     

                                @if (isset($metaSchema->properties['legalResponsible'])) 
                                <div class="col-md-12">
                                    <b>Legal Responsible</b>
                                    @foreach($metaSchema->properties['legalResponsible'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif                                    

                                @if (isset($metaSchema->properties['scientificResponsible'])) 
                                <div class="col-md-12">
                                    <b>Scientific Responsible</b>
                                    @foreach($metaSchema->properties['scientificResponsible'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif  

                                @if (isset($metaSchema->properties['technicalResponsible'])) 
                                <div class="col-md-12">
                                    <b>Technical Responsible</b>
                                    @foreach($metaSchema->properties['technicalResponsible'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif      

                            </div>
                        </div>

                        @endif

                        @if (isset($metaSchema->properties['standardUsed']) || isset($metaSchema->properties['proprietaryFormatDesc']) || isset($metaSchema->properties['homepage']))      

                        <div class="tab-pane" id="tab_other">
                            <div class="row" style="padding: 14px;">
                                @if (isset($metaSchema->properties['standardUsed']))
                                <div class="col-md-12">
                                    <b>Standard Used</b>
                                    @foreach($metaSchema->properties['standardUsed'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($metaSchema->properties['proprietaryFormatDesc']))
                                <div class="col-md-12">
                                    <b>Proprietary Format Desc</b>
                                    @foreach($metaSchema->properties['proprietaryFormatDesc'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif

                                @if (isset($metaSchema->properties['homepage'])) 
                                <div class="col-md-12">
                                    <b>Homepage</b>
                                    @foreach($metaSchema->properties['homepage'] as $value)
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

@extends('app')
@section('content')

<aside class="right-side"> 
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header" title="">
                        <h3 class="box-title">{{ $metaSchema->name }}</h3>
                        <div class="box-tools pull-right">Added: {{ date("d-m-Y", strtotime($metaSchema->cr_tstamp)) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" value="{{ $metaSchema->id }}" name="id" />
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_general" data-toggle="tab">General</a></li>
                        @if (isset($metaSchema->properties['keyword']) || isset($metaSchema->properties['subject']))                        
                        <li><a href="#tab_subjects" data-toggle="tab">Subjects</a></li>
                        @endif
                        @if (isset($metaSchema->properties['accesspolicy']) || isset($metaSchema->properties['accessrights']) || isset($metaSchema->properties['rights']))      
                        <li><a href="#tab_rights" data-toggle="tab">Rights</a></li>
                        @endif
                        @if (isset($resource->properties['creator']) || isset($resource->properties['owner']) || isset($resource->properties['publisher']) || isset($resource->properties['used']) ||
                        isset($resource->properties['legalResponsible']) || isset($resource->properties['scientificResponsible']) || isset($resource->properties['technicalResponsible']))                          
                        <li><a href="#tab_ownership" data-toggle="tab">Ownership</a></li>
                        @endif
                        @if (isset($metaSchema->standardUsed) || isset($metaSchema->proprietaryFormatDesc) || isset($metaSchema->homepage))
                        <li><a href="#tab_temporal" data-toggle="tab">Other</a></li>.
                        @endif
                    </ul>                   
                    <div class="tab-content">
                         <div class="tab-pane active" id="tab_general">
                            <div class="row" style="padding: 14px;">
                                <div class="col-md-12">
                                    <b>Identifier</b>
                                    <p>dat: {{ $metaSchema->id }}</p>
                                </div>

                                @if (isset($metaSchema->properties['originalId']))
                                <div class="col-md-12">
                                    <b>Other Identifiers</b>
                                    <p>{{ $metaSchema->properties['originalId'] }}</p>  
                                </div>
                                @endif
                                
                                @if (!empty($metaSchema->name))
                                <div class="col-md-12">
                                    <b>Title</b>
                                    <p>{{ $metaSchema->name }}</p>
                                </div>
                                @endif
                                
                                @if (isset($metaSchema->properties['description']))
                                <div class="col-md-12">
                                    <b>Description</b>
                                    <p>{{ $metaSchema->properties['description'] }}</p>
                                </div>
                                @endif
                                
                                @if (!empty($metaSchema->agent_name))
                                <div class="col-md-12">
                                    <b>Agent</b>
                                    <p>{{ $metaSchema->agent_name }}</p>
                                </div>
                                @endif
                                
                                @if (isset($metaSchema->properties['issued']))
                                <div class="col-md-12">
                                    <b>Issued</b>                                   
                                    <p>{{ $metaSchema->properties['issued'] }}</p>                             
                                </div>
                                @endif
                                
                                @if (isset($metaSchema->properties['modified']))
                                <div class="col-md-12">
                                    <b>Modified</b>                                   
                                    <p>{{ $metaSchema->properties['modified'] }}</p>                             
                                </div>
                                @endif
                                
                                @if (isset($metaSchema->properties['language']))
                                <div class="col-md-12">
                                    <b>Language</b>
                                    @foreach($metaSchema->properties['language'] as $value)
                                    <p>{{ $value }}</p>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>                      
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>


@endsection

