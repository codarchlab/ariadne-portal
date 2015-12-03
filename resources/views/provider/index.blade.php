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
                                    <th>Textual Documents</th>
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
                                                {{ $provider['collections'] }}
                                            @else
                                                {{ $provider['collections'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider['datasets'] > 0)
                                                {{ $provider['datasets'] }}
                                            @else
                                                {{ $provider['datasets'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider['databases'] > 0)
                                                {{ $provider['databases'] }}
                                            @else
                                                {{ $provider['databases'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider['textualDocuments'] > 0)
                                                {{ $provider['textualDocuments'] }}
                                            @else
                                                {{ $provider['textualDocuments'] }}
                                            @endif
                                        </td>
                                        <?php if($full): ?>
                                        <td>
                                            @if($provider->gis > 0)
                                                {{ $provider->gis }}
                                            @else
                                                {{ $provider->gis }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider->schemas > 0)
                                                {{ $provider->schemas }}
                                            @else
                                                {{ $provider->schemas }}
                                            @endif
                                        </td>    
                                        <td>
                                            @if($provider->services > 0)
                                                {{ $provider->services }}
                                            @else
                                                {{ $provider->services }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider->vocabularies > 0)
                                                {{ $provider->vocabularies }}
                                            @else
                                                {{ $provider->vocabularies }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($provider->foaf > 0)
                                                {{ $provider->foaf }}
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