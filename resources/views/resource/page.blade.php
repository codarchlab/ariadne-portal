@extends('app')
@section('title', $resource['_source']['title'].' - Ariadne portal')

@if (isset($resource['_source']['description']))

    <?php
        $description = strip_tags($resource['_source']['description']);
        $length = 155;

        if (strlen($description) > $length) {

            $description = substr($description, 0, $length) . '...';
        }
    ?>

    @section('description', $description)

@endif

@if (isset($resource['_source']['nativeSubject']))

    <?php $keywords = array(); ?>

    @foreach ($resource['_source']['nativeSubject'] as $nativeSubject)
        <?php $keywords[] = $nativeSubject['prefLabel']; ?>
    @endforeach

    <?php $keywords = implode(',', $keywords); ?>

    @section('keywords', $keywords)

@endif

@section('headers')
<link rel="meta" type="application/json" title="JSON" href="{{ route('resource.json', $resource['_id']) }}">
@endsection

@section('content')

<div class="container-fluid content">

    <div id="citationModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('resource.cite.header') }}</h4>
                </div>
                <div class="modal-body resource-citation-modal">
                    <div class="info">{{ trans('resource.cite.info') }}.</div>
                    <form>
                        <input id="citationLink" type="text" readonly value="{{$citationLink}}"></input>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $('#citationModal').on('shown.bs.modal', function() {
                $('#citationLink').select();
            });
        </script>
    </div>

    <div class="row">

        <!-- resoure metadata -->
        <div class="col-md-8 resource-metadata" itemscope itemtype="http://schema.org/Dataset">
            <h3 itemprop="name">{{ $resource['_source']['title'] }}</h3>

            <div>
                @if (isset($resource['_source']['landingPage']))
                    <a href="{{ $resource['_source']['landingPage']}}" target="_blank" itemprop="sameAs">
                        <span class="glyphicon glyphicon-globe"></span> {{ trans('resource.landing_page') }}
                    </a>
                @endif

                <!-- TODO Add contact information when available in data. See mockups. -->

                <div class="pull-right">
                    <a class="button" href="{{ route('resource.data', [ $resource['_id'] ]  ) }}" target="_blank">
                        <span class="glyphicon glyphicon-file"></span>
                    </a>
                    <a class="button" data-toggle="modal" data-target="#citationModal">
                        <span class="glyphicon glyphicon-link"></span>
                    </a>
                </div>
            </div>

            @if (isset($resource['_source']['description']))
                <div id="description" itemprop="description">
                    {!! $resource['_source']['description'] !!}
                </div>
            @endif

            @if (isset($resource['_source']['nativeSubject']))
                <div>
                    @foreach ($resource['_source']['nativeSubject'] as $nativeSubject)
                        <a class="tag" href="{{ route('search', [ 'nativeSubject' => $nativeSubject['prefLabel'] ]) }}">
                            <span class="glyphicon glyphicon-tag"></span>
                            <span itemprop="keywords">{{ $nativeSubject['prefLabel'] }}</span>
                        </a>
                    @endforeach
                </div>
            @endif

            @if (isset($resource['_source']['temporal']))
            <div>
                @foreach ($resource['_source']['temporal'] as $temporal)
                    @if(isset($temporal['periodName']))
                        <a class="tag" href="{{ route('search', [ 'temporal' => $temporal['periodName'] ]) }}">
                            <span class="glyphicon glyphicon-time"></span>
                            {{ $temporal['periodName'] }}
                        </a>
                    @endif
                @endforeach
            </div>
            @endif

            @if (isset($resource['_source']['spatial']))
                <div>
                    @foreach ($resource['_source']['spatial'] as $spatial)
                        @if(isset($spatial['placeName']))
                            <a class="tag" href="{{ route('search', [ 'spatial' => $spatial['placeName'] ]) }}">
                                <span class="glyphicon glyphicon-map-marker"></span>
                                <span itemprop="spatial" itemscope="itemscope" itemtype="http://schema.org/Place" itemid="http://dbpedia.org/resource/{{ $spatial['placeName'] }}">{{ $spatial['placeName'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif

            <h4>{{ trans('resource.metadata') }}</h4>

            <dl class="dl-horizontal">


                @if (isset($resource['_id']))
                    <dt>{{ trans('resource.identifier') }}</dt>
                    <dd>{{ $resource['_id'] }}</dd>
                @endif

                @if (isset($resource['_source']['language']))
                    <dt>{{ trans('resource.language') }}</dt>
                    <dd itemprop="inLanguage">{{ trans('resource.language.'.$resource['_source']['language']) }}</dd>
                @endif

                @if (isset($resource['_source']['archaeologicalResourceType']))
                    <dt>{{ trans('resource.archaeologicalResourceType') }}</dt>
                    <dd>{{ $resource['_source']['archaeologicalResourceType']['name'] }}</dd>
                @endif

                @if (isset($resource['_source']['resourceType']))
                    <dt>{{ trans('resource.resourceType') }}</dt>
                    <dd>{{ trans('resource.resourceType.'.$resource['_source']['resourceType']) }}</dd>
                @endif

                @if (isset($resource['_source']['publisher']))
                    <dt>{{ trans('resource.publisher') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['publisher'] as $publisher)
                            <li><span itemprop="publisher" itemscope="" itemtype="http://schema.org/ {{ $publisher['type'] }}">{{ $publisher['name'] }}</span> <em>[{{ $publisher['type']}}]</em></li>
                            @endforeach
                        </ul>
                    </dd>
                @endif

                @if (isset($resource['_source']['issued']))
                    <dt>{{ trans('resource.issued') }}</dt>
                    <dd itemprop="datePublished">{{ $resource['_source']['issued'] }}</dd>
                @endif

                @if (isset($resource['_source']['contributor']))
                    <dt>{{ trans('resource.contributor') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['contributor'] as $contributor)
                            <li itemprop="contributor" itemscope="" itemtype="http://schema.org/ {{ $contributor['type'] }}"><span itemprop="name">{{ $contributor['name'] }}</span> <em>[{{ $contributor['type']}}]</em></li>
                            @endforeach
                        </ul>
                    </dd>
                @endif
            </dl>

            <h4>{{ trans('resource.license') }}</h4>

            <dl class="dl-horizontal">

                @if (isset($resource['_source']['accessRights']))
                    <dt>{{ trans('resource.accessRights') }}</dt>
                    <dd>{{ $resource['_source']['accessRights'] }}</dd>
                @endif

                @if (isset($resource['_source']['accessPolicy']))
                    <dt>{{ trans('resource.accessPolicy') }}</dt>
                    <dd>
                        @if(filter_var($resource['_source']['accessPolicy'], FILTER_VALIDATE_URL))
                        <a href="{{ $resource['_source']['accessPolicy'] }}">
                            {{ $resource['_source']['accessPolicy'] }}
                        </a>
                        @else
                        {{ $resource['_source']['accessPolicy'] }}
                        @endif
                    </dd>
                @endif

            </dl>

        </div>
        <!-- resource context -->
        <div class="col-md-4 resource-context">

            @if (isset($resource['_source']['isPartOf']))
                <h4>{{ trans('resource.part_of') }}</h4>
                @foreach($partOf as $isPartOf)
                    <a href="{{ route('resource.page', $isPartOf->id  ) }}" target="_blank">
                        <p>{{ $isPartOf->name }}</p>
                    </a>
                @endforeach
            @endif

            @if (isset($parts_count) && $parts_count != 0)
                <h4>{{ trans('resource.has_parts') }}</h4>
                <p>
                    <a href="{{ route('search', [ 'q' => 'isPartOf:' . $resource['_id'] ]) }}">
                        {{ trans('resource.children') .' (' . $parts_count . ')' }}
                    </a>
                </p>
            @endif

            @if (sizeof($geo_items)>0)

                <h4>{{ trans('resource.geo_similar') }}</h4>

                <div id="map"></div>

                <script>
                    $("#description").readmore({
                        moreLink: '<a href="#"><?php print trans('resource.readmore'); ?></a>',
                        lessLink: '<a href="#"><?php print trans('resource.readless'); ?></a>'
                    });

                    var smallMap = new SmallMap(
                        {!! json_encode($geo_items) !!},
                        {!! json_encode($nearby_geo_items) !!}
                    );

                </script>
            @endif



            <h4>{{ trans('resource.theme_similar') }}</h4>
            <ul>
            @foreach($similar_resources as $similar_resource)
                <li>
                    <a href="{{ route('resource.page', [ $similar_resource['_id'] ]  ) }}">
                        {{ $similar_resource['_source']['title'] }}
                    </a>
                </li>
            @endforeach
            </ul>

        </div>

    </div>

</div>

@endsection