@extends('app')
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <i class='fa fa-file'></i>
                        <h3 class="box-title">Information for each provider</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Collections</th>
                                    <th>Datasets</th>
                                    <th>Databases</th>
                                    <?php if($full): ?>
                                    <th>GIS</th>
                                    <th>Metadata Schemas</th>
                                    <th>Services</th>
                                    <th>Vocabularies</th>
                                    <th>Foaf agents</th>
                                    <?php endif;?>
                                </tr>   
                            </thead>
                            <tbody>
                                @foreach ($providers as $provider)
                                    @if($provider['datasets'] > 0 || $provider['collections'] > 0 || $provider['databases'] > 0 || $provider['gis'] > 0)
                                    <tr>
                                        <th>{{ $provider['_source']['acronym'] }}</th>
                                        <td>
                                            @if($provider['collections'] > 0)
                                                <a href="{{ action('ProviderController@collection', $provider['_id']) }}">{{ $provider['collections'] }}</a>
                                            @else
                                                {{ $provider['collections'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider['datasets'] > 0)
                                                <a href="{{ action('ProviderController@dataset', $provider['_id']) }}">{{ $provider['datasets'] }}</a>
                                            @else
                                                {{ $provider['datasets'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider['databases'] > 0)
                                                <a href="{{ action('ProviderController@database', $provider['_id']) }}">{{ $provider-['databases'] }}</a>
                                            @else
                                                {{ $provider['databases'] }}
                                            @endif
                                        </td>
                                        <?php if($full): ?>
                                        <td>
                                            @if($provider->gis > 0)
                                                <a href="{{ action('ProviderController@gis', $provider['_id']) }}">{{ $provider->gis }}</a>
                                            @else
                                                {{ $provider->gis }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider->schemas > 0)
                                                <a href="{{ action('ProviderController@schema', $provider['_id']) }}">{{ $provider->schemas }}</a>
                                            @else
                                                {{ $provider->schemas }}
                                            @endif
                                        </td>    
                                        <td>
                                            @if($provider->services > 0)
                                                <a href="{{ action('ProviderController@service', $provider['_id']) }}">{{ $provider->services }}</a>
                                            @else
                                                {{ $provider->services }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider->vocabularies > 0)
                                                <a href="{{ action('ProviderController@vocabulary', $provider['_id']) }}">{{ $provider->vocabularies }}</a>
                                            @else
                                                {{ $provider->vocabularies }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider->foaf > 0)
                                                <a href="{{ action('ProviderController@agent', $provider['_id']) }}">{{ $provider->foaf }}</a>
                                            @else
                                                {{ $provider->foaf }}
                                            @endif
                                        </td>
                                        <?php endif;?>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>              
</aside>
@endsection