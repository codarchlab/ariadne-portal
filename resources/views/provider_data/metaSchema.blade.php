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