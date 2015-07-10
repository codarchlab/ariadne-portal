@extends('app')

@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-5">
                <div class="box box-warning">
                    <div class="box-header">
                        <i class='fa fa-home'></i>
                        <h3 class="box-title">Welcome</h3>
                    </div>
                    <div class="box-body">
                        <p>
                            ARIADNE brings together and integrates existing archaeological research data infrastructures 
                            so that researchers can use the various distributed datasets and new and powerful technologies 
                            as an integral component of the archaeological research methodology.  There is now a large 
                            availability of archaeological digital datasets that, together, span different periods, 
                            domains and regions; more are continuously created as a result of the increasing use of IT.  
                            These are the accumulated outcome of the research of individuals, teams and institutions, but 
                            form a vast and fragmented corpus and their potential has been constrained by difficult access 
                            and non-homogenous perspectives.
                        </p>
                        <a href='http://www.ariadne-infrastructure.eu/' target='blank'>Visit Ariadne infrastructure</a>	
                       
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-7">
                <div class="box box-danger">
                    <div class="box-header">
                        <i class='fa fa-user'></i>
                        <h3 class="box-title">Providers</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Country</th>
                                            <th>Name</th>
                                            <th>Collections</th>
                                            <th>Datasets</th>
                                            <th>Databases</th>
                                            <th>Textual Documents</th>
                                        </tr>   
                                    </thead>
                                    <tbody>
                                        @foreach ($providers as $provider)
                                            @if($provider['datasets'] > 0 || $provider['collections'] > 0 || $provider['databases'] > 0 || $provider['textualDocument'] > 0)
                                            <tr>
                                                <td>
                                                    <img src='img/language/{{ $provider['_source']['flag'] }}.png' style='height: 24px;'/>
                                                </td>
                                                <th>
                                                    {{ $provider['_source']['acronym'] }}
                                                </th>   
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
                                                        <a href="{{ action('ProviderController@database', $provider['_id']) }}">{{ $provider['databases'] }}</a>
                                                    @else
                                                        {{ $provider['databases'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($provider['textualDocuments'] > 0)
                                                        <a href="{{ action('ProviderController@textualDocument', $provider['_id']) }}">{{ $provider['textualDocuments'] }}</a>
                                                    @else
                                                        {{ $provider['textualDocuments'] }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>                                
                            </div>	
                        </div>	<!-- // row -->	
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <a href="{{ action('ProviderController@index') }}" class="btn btn-sm btn-primary pull-right">More</a>
                                </p> 
                            </div>
                        </div>	
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->

        </div>
    </section><!-- /.content -->                
</aside><!-- /.right-side -->
@endsection