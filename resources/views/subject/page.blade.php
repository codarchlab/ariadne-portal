@extends('app')
@section('title', $subject['_source']['prefLabel'].' - Ariadne portal')

@if (isset($subject['_source']['scopeNote']))

    <?php
        $description = strip_tags($subject['_source']['scopeNote']);
        $length = 155;
        if (strlen($description) > $length) {
            $description = substr($description, 0, $length) . '...';
        }
    ?>

    @section('description', $description)

@endif

@section('content')

<div class="container-fluid content">

    <div class="row">

        <!-- subject metadata -->
        <div class="col-md-8 subject-metadata" itemscope itemtype="http://schema.org/Intangible">

            <h3 itemprop="name"><span class="glyphicon glyphicon-tag"></span>{{ $subject['_source']['prefLabel'] }}</h3>
 
            <dl class="dl-horizontal">

                @if (isset($subject['_id']))
                    <dt>{{ trans('subject.getty_identifier') }}</dt>
                    <dd>{{ $subject['_id'] }}</dd>
                @endif

                @if (isset($subject['_source']['scopeNote']))
                    <dt>{{ trans('subject.scopeNote') }}</dt>
                    <dd itemprop="description">{{ $subject['_source']['scopeNote'] }}</dd>                    
                @endif
                
                @if (isset($subject['_source']['uri']))
                    <dt>{{ trans('subject.uri') }}</dt>
                    <dd itemprop="sameAs"><a href="{{ $subject['_source']['uri'] }}">{{ $subject['_source']['uri'] }}</a></dd>
                @endif  
                            
                @if(count($subject['_source']['broader']) > 0)
                    <dt>{{ trans('subject.broader') }}</dt>
                    @foreach($subject['_source']['broader'] as $broader)
                        @if (array_key_exists('id',$broader))
                        <dd>
                            <span class="glyphicon glyphicon-tag"></span>
                            <a href="{{ route('subject.page', $broader['id']) }}">{{ $broader['prefLabel'] }}</a>
                        </dd>
                        @endif
                    @endforeach
                @endif
                
                @if(count($sub_subjects) > 0)
                    <dt>{{ trans('subject.narrower') }}</dt>
                    <dd>
                    @foreach($sub_subjects as $id => $sub_subject)
                      <span class="glyphicon glyphicon-tag"></span>
                      <a href="{{ route('subject.page', $id) }}">{{ $sub_subject }}</a>
                    @endforeach
                    </dd>
                @endif
            </dl>

            
            <h4>{{ trans('subject.terms') }}</h4>
            <dl class="dl-horizontal">
              @foreach ($pref_labels as $lang => $labels)
                <dt>{{ trans('resource.language.'.$lang) }}</dt>
                <dd lang="{{ $lang }}">
                @foreach($labels as $label)
                <span class="bg-primary label ">{{ $label }}</span>
                @endforeach
                </dd>
              @endforeach
            </dl>
            
            <h4>{{ trans('subject.provider_mapping') }}</h4>

            <dl class="dl-horizontal">
            
                @if (isset($subject['_source']['providerMappings']) && count($subject['_source']['providerMappings']) > 0)
                    @foreach ($subject['_source']['providerMappings'] as $mapping)
                        <div class="connected_concept">
                            <h5>{{ $mapping['sourceLabel'] }}</h5>   

                            @if (isset($mapping['matchURI']))
                                <dt>{{ trans('subject.match_uri') }}</dt>
                                <dd>{{ $mapping['matchURI'] }}</dd>
                            @endif
                            
                            @if (isset($mapping['sourceURI']))
                                <dt>{{ trans('subject.source_uri') }}</dt>
                                <dd>{{ $mapping['sourceURI'] }}</dd>
                            @endif                            

                        </div>
                    @endforeach                    
                @endif
                
            </dl>
        </div>
        
        <!-- subject context -->
        <div class="col-md-4 subject-context">
            @if(count($resources) > 0)

                <h4>{{ trans('subject.connected_resources') }}</h4>
                                
                <a href="{{ route('search', ['subjectUri'=> $subject['_source']['id'], 'subjectLabel' => $subject['_source']['prefLabel']]) }}" class="btn btn-primary form-control">
                    <span class="glyphicon glyphicon-search"></span> {{ trans('subject.search_connected_resources') }} <span class="badge">{{ $resources['hits']['total'] }}</span>
                </a>                

            @endif
            
        </div>

    </div>

</div>

<script>
    $("#description").readmore({
        moreLink: '<a href="#"><?php print trans('subject.readmore'); ?></a>',
        lessLink: '<a href="#"><?php print trans('subject.readless'); ?></a>'
    });
</script>

@endsection