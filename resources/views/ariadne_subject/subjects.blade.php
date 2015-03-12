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
                        <h3 class="box-title">Ariadne subjects</h3>
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
                                </tr>   
                            </thead>
                            <tbody>
                               @foreach ($subjects as $subject)
                                <tr>
                                   <th>{{ $subject->name }}</th>  
                                   @if ($subject->collections > 0)
                                   <td><a href="{{ action('CollectionController@subject', $subject->id) }}">{{ $subject->collections }}</a></td>
                                   @else
                                   <td>{{ $subject->collections }}</td>
                                   @endif
                                   @if ($subject->datasets > 0)
                                   <td><a href="{{ action('DatasetController@subject', $subject->id) }}">{{ $subject->datasets }}</a></td>
                                   @else
                                   <td>{{ $subject->datasets }}</td>
                                   @endif
                                   @if ($subject->databases > 0)
                                   <td><a href="{{ action('DatabaseController@subject', $subject->id) }}">{{ $subject->databases }}</a></td>
                                   @else
                                   <td>{{ $subject->databases }}</td>
                                   @endif
                                   @if ($subject->gis > 0)
                                   <td><a href="{{ action('GisController@subject', $subject->id) }}">{{ $subject->gis }}</a></td>
                                   @else
                                   <td>{{ $subject->gis }}</td>
                                   @endif
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