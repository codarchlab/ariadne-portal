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
                        <i class='fa fa-tag'></i>
                        <h3 class="box-title">ARIADNE subjects</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Collections</th>
                                    <th>Datasets</th>
                                    <th>Databases</th>
                                    <th>GIS</th>
                                    <th>TextualDocument</th>
                                </tr>   
                            </thead>
                            <tbody>
                               @foreach ($subjects as $subject)
                                <tr>
                                   <th>{{ $subject['_source']['name'] }}</th>  
                                   <td>{{ $subject['collections'] }}</td>
                                   <td>{{ $subject['datasets'] }}</td>
                                   <td>{{ $subject['databases'] }}</td>
                                   <td>{{ $subject['gis'] }}</td>
                                   <td>{{ $subject['textualDocument'] }}</td>
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