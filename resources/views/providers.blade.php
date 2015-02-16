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
                                    <th>GIS</th>
                                    <th>Metadata Schemas</th>
                                    <th>Services</th>
                                    <th>Vocabularies</th>
                                    <th>Foaf agents</th>
                                </tr>   
                            </thead>
                            <tbody>
                                @foreach ($providers as $provider)
                                <tr>
                                    <td>{{ $provider->name }}</td>
                                    <td>{{ $provider->collections }}</td>
                                    <td>{{ $provider->datasets }}</td>
                                    <td>{{ $provider->databases }}</td>
                                    <td>{{ $provider->gis }}</td>
                                    <td>{{ $provider->schemas }}</td>
                                    <td>{{ $provider->services }}</td>
                                    <td>{{ $provider->vocabularies }}</td>
                                    <td>{{ $provider->foaf }}</td>
                                </tr>
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