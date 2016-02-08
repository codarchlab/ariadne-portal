@extends('app')
@section('title', $subject['_source']['title'].' - Ariadne portal')

@if (isset($subject['_source']['description']))

    <?php
        $description = strip_tags($subject['_source']['description']);
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

            <h3 itemprop="name"><span class="glyphicon glyphicon-tag"></span>{{ $subject['_source']['title'] }}</h3>
 
            <dl class="dl-horizontal">

                @if (isset($subject['_id']))
                    <dt>{{ trans('subject.getty_identifier') }}</dt>
                    <dd>{{ $subject['_id'] }}</dd>
                @endif

                @if (isset($subject['_source']['description']))
                    <dt>{{ trans('subject.description') }}</dt>
                    <dd itemprop="description">{{ $subject['_source']['description'] }}</dd>                    
                @endif                
                                
                @if (isset($subject['_source']['terms']) && count($subject['_source']['terms']) > 0)
                    <dt>{{ trans('subject.terms') }}</dt>
                    <dd>
                        <ul>
                        @foreach ($subject['_source']['terms'] as $term)                        
                            <li>{{ $term }}</li>
                        @endforeach
                        </ul>
                    </dd>
                @endif
                
            </dl>

            <h4>{{ trans('subject.connected_concepts') }}</h4>

            <dl class="dl-horizontal">
            
                @if (isset($subject['_source']['connected_concept']) && count($subject['_source']['connected_concept']) > 0)
                    @foreach ($subject['_source']['connected_concept'] as $concept)
                        <div class="connected_concept">
                            <h5>{{ $concept['concept'] }}</h5>   

                            @if (isset($concept['source']))
                                <dt>{{ trans('subject.source') }}</dt>
                                <dd>{{ $concept['source'] }}</dd>
                            @endif

                            @if (isset($concept['identifier']))
                                <dt>{{ trans('subject.identifier') }}</dt>
                                <dd>{{ $concept['identifier'] }}</dd>                    
                            @endif     

                            @if (isset($concept['relation']))
                                <dt>{{ trans('subject.relation') }}</dt>
                                <dd>{{ $concept['relation'] }}</dd>                    
                            @endif     
                        </div>
                    @endforeach                    
                @endif
                
            </dl>
        </div>
        
        <!-- subject context -->
        <div class="col-md-4 subject-context">
          
            <h4>{{ trans('subject.connected_resources') }}</h4>

            @if(count($resources) > 0)
                <div id="map"></div>
                
                <script>
                    $("#description").readmore({
                        moreLink: '<a href="#"><?php print trans('subject.readmore'); ?></a>',
                        lessLink: '<a href="#"><?php print trans('subject.readless'); ?></a>'
                    });
                    var smallMap = new SmallMap(
                        {!! json_encode($resources) !!},
                        null
                    );
                </script>
            @endif
            
            @if(isset($similar_subjects))
                <h4>{{ trans('subject.similar') }}</h4>
                <ul>
                @foreach($similar_subjects as $similar)
                    <li>
                        <span class="glyphicon glyphicon-tag"></span>
                        <a href="{{ route('subject.page', [ $similar['_id'] ]  ) }}">
                            {{ $similar['_source']['title'] }}
                        </a>
                    </li>
                @endforeach
                </ul>
            @endif
        </div>

    </div>

</div>

@endsection