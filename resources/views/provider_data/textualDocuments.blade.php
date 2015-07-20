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
                         <?php
                            if (Utils::contains(Request::url(),array('subject'))) $with = 'with '.$subjectName; 
                            else $with='';
                        ?>
                        <h3 class="box-title">Textual Documents {{ $with }}</h3>                   
                        @include("provider_data._provider_selection_box")
                    </div><!-- /.box-header -->
                    
                    <div class="box-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Provider</th>
                                    <th>Name</th>                                    
                                </tr>   
                            </thead>
                            <tbody>
                                @foreach ($textualDocuments as $textualDocument)
                                <tr>
                                    <td>{{ $textualDocument['_id'] }}</td>
                                    <td>{{ $textualDocument['_source']['providerAcro'] }}</td>
                                   
                                    <td><a href="{{ action('TextualDocumentController@show', $textualDocument['_id']) }}">{{ $textualDocument['_source']['title'] }}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <?php echo $textualDocuments->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>              
</aside>
@endsection