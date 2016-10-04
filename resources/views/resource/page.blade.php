@extends('app')
@section('title', $resource['_source']['title'].' - Ariadne portal')

@if (isset($resource['_source']['description']))

    @section('description', str_limit(strip_tags($resource['_source']['description']), 155))

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
<link rel="meta" type="application/xml" title="ACDM XML" href="{{ route('resource.xml', $resource['_id']) }}">
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

    @if (str_contains(URL::previous(), URL::to('search')))
        <div class="row">
            <div class="col-md-12">
                <a href="{{ URL::previous() }}" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-arrow-left"></span> {{ trans('resource.backlink') }}
                </a>
            </div>
        </div>
    @endif  

    <div class="row">
        <div class="col-md-12 resource-title">
            <h1 itemprop="name">{{ $resource['_source']['title'] }}</h1>  
        </div>
    </div>

    <div class="row">

        <!-- resoure metadata -->
        <div class="col-md-8 resource-metadata" itemscope itemtype="http://schema.org/Dataset">

            <div class="clearfix">

                <!-- TODO Add contact information when available in data. See mockups. -->

                <div class="pull-right">
                    <a class="button" data-toggle="tooltip" data-placement="left" title="Resource metadata in JSON" href="{{ route('resource.json', [ $resource['_id'] ]  ) }}" target="_blank">
                        <span class="glyphicon glyphicon-file"></span>
                    </a>
                    <a class="button" data-toggle="tooltip" data-placement="left" title="Resource metadata in ACDM XML" href="{{ route('resource.xml', [ $resource['_id'] ]  ) }}" target="_blank">
                        <span class="glyphicon glyphicon-tasks"></span>
                    </a>                    
                    <a class="button"  data-tooltip="true" data-placement="bottom" title="Cite resource" data-toggle="modal" data-target="#citationModal">
                        <span class="glyphicon glyphicon-link"></span>
                    </a>
                    <a class="button" data-toggle="tooltip" data-placement="right" title="Report data quality issue" href="{{ route('contact.form', ['subject' => 'Data quality issue resource #' . $resource['_id']]) }}">
                        <span class="glyphicon glyphicon-envelope"></span>
                    </a>
                </div>
            </div>

            @if (isset($resource['_source']['description']))
                <div id="description" itemprop="description">
                    {!! $resource['_source']['description'] !!}
                </div>
            @endif

            @if (isset($resource['_source']['derivedSubject']))
                <div>
                    @foreach ($resource['_source']['derivedSubject'] as $derivedSubject)
                        <span class="tag">
                            <a href="{{ route('search', [ 'derivedSubject' => $derivedSubject['prefLabel'] ]) }}">
                                <span class="glyphicon glyphicon-tag"></span>
                                <span itemprop="keywords">{{ $derivedSubject['prefLabel'] }}</span>
                            </a>
                            <?php $uriComponents = explode('/', $derivedSubject['source']); ?>
                            <a class="text-muted" href="{{ route('subject.page', [ array_pop($uriComponents) ] ) }}">
                                <span class="glyphicon glyphicon-info-sign"></span>
                            </a>
                          
                        </span>
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

                @if (isset($resource['_source']['originalId']))
                    <dt>{{ trans('resource.originalId') }}</dt>
                    <dd>{{ $resource['_source']['originalId'] }}</dd>
                @endif

                @if (isset($resource['_source']['language']))
                    <dt>{{ trans('resource.language') }}</dt>
                    <dd itemprop="inLanguage">{{ trans('resource.language.'.$resource['_source']['language']) }}</dd>
                @endif

                @if (isset($resource['_source']['audience']))
                    <dt>{{ trans('resource.audience') }}</dt>
                    <dd>
                        <ul>
                            @foreach ($resource['_source']['audience'] as $audience)
                            <li><span itemprop="audience" itemscope="" itemtype="http://schema.org/Audience">{{ $audience }}</span></li>
                            @endforeach
                        </ul>
                    </dd>
                @endif    
                
                @if (isset($resource['_source']['archaeologicalResourceType']))
                    <dt>{{ trans('resource.archaeologicalResourceType') }}</dt>
                    <dd>{{ $resource['_source']['archaeologicalResourceType']['name'] }}</dd>
                @endif

                @if (isset($resource['_source']['extent']))
                    <dt>{{ trans('resource.extent') }}</dt>
                    <dd>
                        <ul>
                            @foreach ($resource['_source']['extent'] as $extent)
                            <li>{{ $extent }}</li>
                            @endforeach
                        </ul>
                    </dd>
                @endif  
                
                 @if (isset($resource['_source']['derivedSubject']))
                    <dt>{{ trans('resource.subject') }}</dt>
                      @foreach ($resource['_source']['derivedSubject'] as $derivedSubject)
                        <dd>
                          <span class="tag">
                            <a href="{{ route('search', [ 'subjectUri' => $derivedSubject['id'], 'subjectLabel' => $derivedSubject['prefLabel'] ]) }}">                                               
                                <span itemprop="keywords">{{ $derivedSubject['prefLabel'] }}</span>
                            </a>
                            <?php $uriComponents = explode('/', $derivedSubject['source']); ?>
                            <a class="text-muted" href="{{ route('subject.page', [ array_pop($uriComponents) ] ) }}">
                                <span class="glyphicon glyphicon-info-sign"></span>
                            </a>
                          </span>
                        </dd>
                        @if (isset($derivedSubject['dc:language']))
                          <dd><span itemprop="dc:language" itemscope="">{{trans('resource.dc:language') }}: {{ $derivedSubject['dc:language'] }}</span></dd>
                        @endif
                        @if (isset($derivedSubject['skopeNote']))
                          <dd><span itemprop="skopeNote" itemscope="">{{trans('resource.skopeNote') }}: {{ $derivedSubject['skopeNote'] }}</span></dd>
                        @endif
                        @if (isset($derivedSubject['definition']))
                          <dd><span itemprop="definition" itemscope="">{{trans('resource.definition') }}: {{ $derivedSubject['definition'] }}</span></dd>
                        @endif                        
                      @endforeach
                @endif 
                
                @if (isset($resource['_source']['nativeSubject']))
                    <dt>{{ trans('resource.nativeSubject') }}</dt>
                      @foreach ($resource['_source']['nativeSubject'] as $nativeSubject)
                        <dd>  
                            <ul>
                                <li>{{ $nativeSubject['prefLabel'] }}</li>    
                            </ul>
                        </dd>                                            
                      @endforeach
                @endif    
                
                @if (isset($resource['_source']['keyword']))
                    <dt>{{ trans('resource.keyword') }}</dt>
                    <dd>
                        <ul>
                            @foreach ($resource['_source']['keyword'] as $keyword)
                            <li>{{ $keyword }}</li>
                            @endforeach
                        </ul>
                    </dd>
                @endif 
                
                @if (isset($resource['_source']['temporal']))
                    <dt>{{ trans('resource.temporal')}}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['temporal'] as $temporal)
                            <li>
                                @if(isset($temporal['from']))
                                  {{ $temporal['from'] }}
                                @endif
                                @if(isset($temporal['until']) && $temporal['until'] != $temporal['from'])
                                  &ndash; {{ $temporal['until'] }}
                                @endif
                                
                                @if(isset($temporal['periodName']))
                                  @if(isset($temporal['from']) || isset($temporal['until'])),@endif
                                  {{ $temporal['periodName'] }}
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </dd>
                @endif

                @if (isset($resource['_source']['spatial']))
                    <dt>{{ trans('resource.spatial')}}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['spatial'] as $spatial)
                              <li>
                              <?php $parts = [] ?>
                              @foreach(['address','numberInRoad','postcode','placeName','country'] as $key)
                                @if(isset($spatial[$key]))
                                  <?php $parts[] = $spatial[$key] ?>
                                @endif
                              @endforeach
                              @if(count($parts) > 0)
                                  {{ implode($parts, ', ') }}
                              @endif
                              @if(isset($spatial['location']))
                                <em>[{{ implode($spatial['location'], ', ') }}]</em>
                              @endif
                              </li>
                            @endforeach
                        </ul>
                    </dd>
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
                            <li><span itemprop="publisher" itemscope="" itemtype="http://schema.org/{{ $publisher['type'] }}">{{ $publisher['name'] }}</span> <em>[{{ $publisher['type']}}]</em></li>
                              @if (isset($publisher['email']))
                                <li><span itemprop="publisher" itemscope="">{{trans('resource.email') }}:
                                @if (preg_match('/@/',$publisher['email']))
                                   <a href="mailto:{{ $publisher['email'] }}">{{ $publisher['email'] }}</a>
                                @else
                                  {{ $publisher['email'] }}
                                @endif
                                </span></li>
                              @endif
                              @if (isset($publisher['phone']))
                                <li><span itemprop="publisher" itemscope="">{{trans('resource.phone') }}: {{ $publisher['phone'] }}</span></li>
                              @endif  
                              @if (isset($publisher['skypeID']))
                                <li><span itemprop="publisher" itemscope="">{{trans('resource.skypeID') }}: {{ $publisher['skypeID'] }}</span></li>
                              @endif
                            @endforeach
                        </ul>
                    </dd>
                @endif

                @if (isset($resource['_source']['issued']))
                    <dt>{{ trans('resource.issued') }}</dt>
                    <dd>
                        <time itemprop="datePublished" datetime="{{ $resource['_source']['issued'] }}">
                            {{ date_format(date_create($resource['_source']['issued']), 'Y-m-d') }}
                        </time>
                    </dd>
                @endif
                
                @if (isset($resource['_source']['modified']))
                    <dt>{{ trans('resource.modified') }}</dt>
                    <dd>
                        <time itemprop="dateModified" datetime="{{ $resource['_source']['modified'] }}">
                            {{ date_format(date_create($resource['_source']['modified']), 'Y-m-d') }}
                        </time>
                    </dd>
                @endif
                
                @if (isset($resource['_source']['hasMetadataRecord']))
                    <dt>{{ trans('resource.hasMetadataRecord') }}</dt>
                    <dd>
                        <ul>
                        @foreach ($resource['_source']['hasMetadataRecord'] as $hasMetadataRecord)
                            <li>
                                @if (isset($hasMetadataRecord['xmlDoc']))
                                    @if(filter_var($hasMetadataRecord['xmlDoc'], FILTER_VALIDATE_URL))
                                    <a href="{{ $hasMetadataRecord['xmlDoc'] }}">
                                        {{ $hasMetadataRecord['xmlDoc'] }}
                                    </a>
                                    @else
                                    {{ $hasMetadataRecord['xmlDoc'] }}
                                    @endif                                
                                @endif
                                @if (isset($hasMetadataRecord['conformsTo']))
                                    <br/>
                                    <em>[
                                        @if (isset($hasMetadataRecord['conformsTo'][0]['description']))
                                            {{ $hasMetadataRecord['conformsTo'][0]['description'] }}
                                        @endif
                                    ]</em>
                                    <em>[
                                        @if (isset($hasMetadataRecord['conformsTo'][0]['characterSet']))
                                            {{ trans('resource.characterSet') }}:
                                            {{ $hasMetadataRecord['conformsTo'][0]['characterSet'] }}
                                        @endif
                                    ]</em>
                                @endif
                            </li>
                        @endforeach
                        </ul>
                    </dd>
                @endif
                
            </dl>
                
            <h4>{{ trans('resource.responsible') }}</h4>

            <dl class="dl-horizontal">                

                @if (isset($resource['_source']['creator']))
                    <dt>{{ trans('resource.creator') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['creator'] as $creator)
                            <li itemprop="creator" itemscope="" itemtype="http://schema.org/{{ $creator['type'] }}"><span itemprop="name">{{ $creator['name'] }}</span> <em>[{{ $creator['type']}}]</em></li>
                              @if (isset($creator['email']))
                                <li><span itemprop="creator" itemscope="">{{trans('resource.email') }}:
                                @if (preg_match('/@/',$creator['email']))
                                   <a href="mailto:{{ $creator['email'] }}">{{ $creator['email'] }}</a>
                                @else
                                  {{ $creator['email'] }}
                                @endif
                                </span></li>
                              @endif
                              @if (isset($creator['phone']))
                                <li><span itemprop="creator" itemscope="">{{trans('resource.phone') }}: {{ $creator['phone'] }}</span></li>
                              @endif    
                              @if (isset($creator['skypeID']))
                                <li><span itemprop="creator" itemscope="">{{trans('resource.skypeID') }}: {{ $creator['skypeID'] }}</span></li>
                              @endif
                            @endforeach
                        </ul>
                    </dd>
                @endif                
                
                @if (isset($resource['_source']['contributor']))
                    <dt>{{ trans('resource.contributor') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['contributor'] as $contributor)
                            <li itemprop="contributor" itemscope="" itemtype="http://schema.org/{{ $contributor['type'] }}"><span itemprop="name">{{ $contributor['name'] }}</span> <em>[{{ $contributor['type']}}]</em></li>
                              @if (isset($contributor['email']))
                                <li><span itemprop="contributor" itemscope="">{{trans('resource.email') }}:
                                @if (preg_match('/@/',$contributor['email']))
                                   <a href="mailto:{{ $contributor['email'] }}">{{ $contributor['email'] }}</a>
                                @else
                                  {{ $contributor['email'] }}
                                @endif
                                </span></li>
                              @endif                              
                              @if (isset($contributor['phone']))
                                <li><span itemprop="contributor" itemscope="">{{trans('resource.phone') }}: {{ $contributor['phone'] }}</span></li>
                              @endif    
                              @if (isset($contributor['skypeID']))
                                <li><span itemprop="contributor" itemscope="">{{trans('resource.skypeID') }}: {{ $contributor['skypeID'] }}</span></li>
                              @endif
                            @endforeach
                        </ul>
                    </dd>
                @endif
                
                @if (isset($resource['_source']['owner']))
                    <dt>{{ trans('resource.owner') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['owner'] as $owner)
                            <li itemprop="owner" itemscope="" itemtype="http://schema.org/{{ $owner['type'] }}"><span itemprop="name">{{ $owner['name'] }}</span> <em>[{{ $owner['type']}}]</em></li>
                              @if (isset($owner['email']))
                                <li><span itemprop="owner" itemscope="">{{trans('resource.email') }}:
                                @if (preg_match('/@/',$owner['email']))
                                   <a href="mailto:{{ $owner['email'] }}">{{ $owner['email'] }}</a>
                                @else
                                  {{ $owner['email'] }}
                                @endif
                                </span></li>
                              @endif 
                              @if (isset($owner['phone']))
                                <li><span itemprop="owner" itemscope="">{{trans('resource.phone') }}: {{ $owner['phone'] }}</span></li>
                              @endif    
                              @if (isset($owner['skypeID']))
                                <li><span itemprop="owner" itemscope="">{{trans('resource.skypeID') }}: {{ $owner['skypeID'] }}</span></li>
                              @endif
                            @endforeach
                        </ul>
                    </dd>
                @endif       
                
                @if (isset($resource['_source']['legalResponsible']))
                    <dt>{{ trans('resource.legalResponsible') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['legalResponsible'] as $legalResponsible)
                            <li itemprop="legalResponsible" itemscope="" itemtype="http://schema.org/{{ $legalResponsible['type'] }}"><span itemprop="name">{{ $legalResponsible['name'] }}</span> <em>[{{ $legalResponsible['type']}}]</em></li>
                              @if (isset($legalResponsible['email']))
                                <li><span itemprop="legalResponsible" itemscope="">{{trans('resource.email') }}:
                                @if (preg_match('/@/',$legalResponsible['email']))
                                   <a href="mailto:{{ $legalResponsible['email'] }}">{{ $legalResponsible['email'] }}</a>
                                @else
                                  {{ $legalResponsible['email'] }}
                                @endif
                                </span></li>
                              @endif 
                              @if (isset($legalResponsible['phone']))
                                <li><span itemprop="legalResponsibler" itemscope="">{{trans('resource.phone') }}: {{ $legalResponsible['phone'] }}</span></li>
                              @endif    
                              @if (isset($legalResponsible['skypeID']))
                                <li><span itemprop="legalResponsible" itemscope="">{{trans('resource.skypeID') }}: {{ $legalResponsible['skypeID'] }}</span></li>
                              @endif
                            @endforeach
                        </ul>
                    </dd>
                @endif         
                
                @if (isset($resource['_source']['scientificResponsible']))
                    <dt>{{ trans('resource.scientificResponsible') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['scientificResponsible'] as $scientificResponsible)
                            <li itemprop="scientificResponsible" itemscope="" itemtype="http://schema.org/{{ $scientificResponsible['type'] }}"><span itemprop="name">{{ $scientificResponsible['name'] }}</span> <em>[{{ $scientificResponsible['type']}}]</em></li>
                              @if (isset($scientificResponsible['email']))
                                <li><span itemprop="scientificResponsible" itemscope="">{{trans('resource.email') }}:
                                @if (preg_match('/@/',$scientificResponsible['email']))
                                   <a href="mailto:{{ $scientificResponsible['email'] }}">{{ $scientificResponsible['email'] }}</a>
                                @else
                                  {{ $scientificResponsible['email'] }}
                                @endif
                                </span></li>
                              @endif                             
                              @if (isset($scientificResponsible['phone']))
                                <li><span itemprop="scientificResponsible" itemscope="">{{trans('resource.phone') }}: {{ $scientificResponsible['phone'] }}</span></li>
                              @endif    
                              @if (isset($scientificResponsible['skypeID']))
                                <li><span itemprop="scientificResponsible" itemscope="">{{trans('resource.skypeID') }}: {{ $scientificResponsible['skypeID'] }}</span></li>
                              @endif                              
                            @endforeach
                        </ul>
                    </dd>
                @endif    
                
                @if (isset($resource['_source']['technicalResponsible']))
                    <dt>{{ trans('resource.technicalResponsible') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['technicalResponsible'] as $technicalResponsible)
                            <li itemprop="technicalResponsible" itemscope="" itemtype="http://schema.org/{{ $technicalResponsible['type'] }}"><span itemprop="name">{{ $technicalResponsible['name'] }}</span> <em>[{{ $technicalResponsible['type']}}]</em></li>
                              @if (isset($technicalResponsible['email']))
                                <li><span itemprop="technicalResponsible" itemscope="">{{trans('resource.email') }}:
                                @if (preg_match('/@/',$technicalResponsible['email']))
                                   <a href="mailto:{{ $technicalResponsible['email'] }}">{{ $technicalResponsible['email'] }}</a>
                                @else
                                  {{ $technicalResponsible['email'] }}
                                @endif
                                </span></li>
                              @endif
                              @if (isset($technicalResponsible['phone']))
                                <li><span itemprop="technicalResponsible" itemscope="">{{trans('resource.phone') }}: {{ $technicalResponsible['phone'] }}</span></li>
                              @endif
                              @if (isset($technicalResponsible['skypeID']))
                                <li><span itemprop="technicalResponsible" itemscope="">{{trans('resource.skypeID') }}: {{ $technicalResponsible['skypeID'] }}</span></li>
                              @endif                              
                            @endforeach
                        </ul>
                    </dd>
                @endif   

                @if (isset($resource['_source']['providedSubject']))
                    <dt>{{ trans('resource.providedSubject') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['providedSubject'] as $providedSubject)
                              @if (isset($providedSubject['prefLabel']))
                                <li><span itemprop="providedSubject" itemscope="">{{trans('resource.providedSubject.prefLabel') }}: {{ $providedSubject['prefLabel'] }}</span></li>
                              @endif
                              @if (isset($providedSubject['skopeNote']))
                                <li><span itemprop="providedSubject" itemscope="">{{trans('resource.skopeNote') }}: {{ $providedSubject['skopeNote'] }}</span></li>
                              @endif
                              @if (isset($providedSubject['definition']))
                                <li><span itemprop="providedSubject" itemscope="">{{trans('resource.definition') }}: {{ $providedSubject['definition'] }}</span></li>
                              @endif
                              @if (isset($providedSubject['source']))
                                <li><span itemprop="providedSubject" itemscope="">{{trans('resource.source') }}: {{ $providedSubject['source'] }}</span></li>
                              @endif                              
                            @endforeach
                        </ul>
                    </dd>
                @endif   
                
                <!-- New Attributes -->
                
                @if (isset($resource['_source']['aatSubjects']))
                    <dt>{{ trans('resource.aatSubjects') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['aatSubjects'] as $aatSubject)
                            <li itemprop="aatSubject" itemscope="">
                              <span itemprop="name">{{ $aatSubject['label'] }}</span> <span class="badge">{{ $aatSubject['lang']}}</span></li>
                            @endforeach
                        </ul>
                    </dd>
                @endif
                
                @if (isset($resource['_source']['accrualPeriodicity']))
                    <dt>{{ trans('resource.accrualPeriodicity') }}</dt>
                    <dd>{{ $resource['_source']['accrualPeriodicity'] }}</dd>
                @endif
                
                @if (isset($resource['_source']['contactPoint']))
                    <dt>{{ trans('resource.contactPoint') }}</dt>
                    <dd>{{ $resource['_source']['contactPoint'] }}</dd>
                @endif
                
                @if (isset($resource['_source']['identifier']))
                    <dt>{{ trans('resource.metadata.identifier') }}</dt>
                    <dd>
                    @if(filter_var($resource['_source']['identifier'], FILTER_VALIDATE_URL))
                    <a href="{{ $resource['_source']['identifier'] }}">
                        {{ $resource['_source']['identifier'] }}
                    </a>
                    @else
                    {{ $resource['_source']['identifier'] }}
                    @endif 
                    </dd>                   
                @endif
                
                @if (isset($resource['_source']['packageId']))
                    <dt>{{ trans('resource.packageId') }}</dt>
                    <dd>{{ $resource['_source']['packageId'] }}</dd>
                @endif
                
                @if (isset($resource['_source']['providerId']))
                    <dt>{{ trans('resource.providerId') }}</dt>
                    <dd>{{ $resource['_source']['providerId'] }}</dd>
                @endif
                
                @if (isset($resource['_source']['size']))
                    <dt>{{ trans('resource.size') }}</dt>
                    <dd>{{ $resource['_source']['size'] }}</dd>
                @endif
                
                @if (isset($resource['_source']['hasItemMetadataStructure']))
                    <dt>{{ trans('resource.hasItemMetadataStructure') }}</dt>
                    <dd>
                        <ul>
                            @foreach($resource['_source']['hasItemMetadataStructure'] as $hasItemMetadataStructure)
                              @if (isset($hasItemMetadataStructure['dc:description']))
                                <li itemprop="hasItemMetadataStructure" itemscope="">
                                  <span itemprop="dc:description">{{ $hasItemMetadataStructure['dc:description'] }}</span>
                                </li>
                              @endif  
                              @if (isset($hasItemMetadataStructure['characterSet']))
                                <li itemprop="hasItemMetadataStructure" itemscope="">
                                  <span itemprop="characterSet">{{ $hasItemMetadataStructure['characterSet'] }}</span>
                                </li>
                              @endif  
                              @if (isset($hasItemMetadataStructure['xsd']))  
                                <li itemprop="hasItemMetadataStructure" itemscope="">
                                  <span itemprop="xsd">{{ $hasItemMetadataStructure['xsd'] }}</span>
                                </li>
                              @endif
                            @endforeach
                        </ul>
                    </dd>
                @endif           
                
                <!-- END New Attributes -->
                
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

                @if (isset($resource['_source']['rights']))
                    <dt>{{ trans('resource.rights') }}</dt>
                    <dd>{{ $resource['_source']['rights'] }}</dd>
                @endif                
                
            </dl>
            
            @if (isset($resource['_source']['distribution']))            
                @foreach($resource['_source']['distribution'] as $distribution)                
                    <h4>{{ trans('resource.distribution') }}</h4>
                    <dl class="dl-horizontal">                
                                        
                        @if (isset($distribution['title']))
                            <dt>{{ trans('resource.distribution.title') }}</dt>
                            <dd>{{ $distribution['title'] }}</dd>
                        @endif   
                        
                        @if (isset($distribution['description']))
                            <dt>{{ trans('resource.distribution.description') }}</dt>
                            <dd>{{ $distribution['description'] }}</dd>
                        @endif 
                        
                        @if (isset($distribution['accessURL']))
                            <dt>{{ trans('resource.distribution.accessUrl') }}</dt>
                            <dd>
                                @if(filter_var($distribution['accessURL'], FILTER_VALIDATE_URL))
                                <a href="{{ $distribution['accessURL'] }}">
                                    {{ $distribution['accessURL'] }}
                                </a>
                                @else
                                {{ $distribution['accessURL'] }}
                                @endif
                            </dd>
                        @endif                         
                        
                        @if (isset($distribution['issued']))
                            <dt>{{ trans('resource.distribution.issued') }}</dt>
                            <dd>{{ $distribution['issued'] }}</dd>
                        @endif 
                        
                        @if (isset($distribution['modified']))
                            <dt>{{ trans('resource.distribution.modified') }}</dt>
                            <dd>{{ $distribution['modified'] }}</dd>
                        @endif                        
                        @if (isset($distribution['publisher']))
                            <dt>{{ trans('resource.publisher') }}</dt>
                            <dd>
                                <ul>
                                    @foreach($distribution['publisher'] as $publisher)                                        
                                            <li><span itemprop="publisher" itemscope="" itemtype="http://schema.org/{{ $publisher['type'] }}">
                                                @if (isset($publisher['name']))
                                                    {{ $publisher['name'] }}
                                                @endif
                                            </span> <em>[{{ $publisher['type']}}]</em></li>                                        
                                    @endforeach
                                </ul>
                            </dd>
                        @endif
                    </dl>
                @endforeach            
            @endif    

        </div>
        <!-- resource context -->
        <div class="col-md-4 resource-context">

            @if (isset($resource['_source']['landingPage']))
                <a href="{{ $resource['_source']['landingPage']}}" target="_blank" itemprop="sameAs" class="btn btn-primary form-control">
                    <span class="glyphicon glyphicon-globe"></span> {{ trans('resource.landing_page') }}
                    <span class="glyphicon glyphicon-new-window"></span>
                </a>
            @endif

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

                <h4 title="{{ trans('resource.geo_legend_similar_explanation') }}" data-tooltip="true">{{ trans('resource.geo_similar') }} <span class="glyphicon glyphicon-info-sign"></span></h4>

                
                <div id="map"></div>
                <div id="map-legend">
                    <span><img src="/img/leaflet/custom/marker-icon-red.png" />{{  trans('resource.geo_legend_current') }}</span>
                    <span><img src="/img/leaflet/custom/marker-icon-blue.png" />{{  trans('resource.geo_legend_similar') }}</span>
                </div>
                
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

            <h4 title="{{ trans('resource.theme_similar_explanation') }}" data-tooltip="true">{{ trans('resource.theme_similar') }} <span class="glyphicon glyphicon-info-sign"></span></h4>
            <ul class="list-unstyled list-similar">
            @foreach($similar_resources as $similar_resource)
                <li>
                    <img src="{{ asset("img/icons/")."/icon_".$similar_resource['_source']['archaeologicalResourceType']['id'].".png" }}" data-toggle="tooltip" title="{{ $similar_resource['_source']['archaeologicalResourceType']['name'] }}" height="20" border="0">
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