@extends('app')
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->        
<aside class="right-side">                
    <!-- Main content -->
    <section class="content-header">
        <h1>
            Search
            <small>Here you can search all available {{ $type['name'] }} </small>
        </h1>
        <hr>
    </section>
    <!-- Main content -->
    <section class="content">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                        <!-- search form -->
                        <form id="searchform" action="#" method="POST" >
                        <input type="hidden" name="search_type" id="search_type" value="{{ $type['id'] }}" />
                                <div class="input-group">
                                        <input type="text" id="q" name="q" class="form-control" placeholder="Search for {{ $type['name'] }}...">
                                        <span class="input-group-btn">
                                                <div name='search' id='searchbtn' class="btn btn-flat" style="border:1px #c0c0c0 solid;"><i class="fa fa-search"></i></div>
                                        </span>
                                </div>
                        </form>


                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                <div class="col-md-12" id="search_results_box">
                    <div class='row'><div class='col-md-12'><hr/></div></div>
                    @foreach($drs as $dr)
                                               
                        <div class='col-md-6'>
                            <div class='box box-primary' id='dataresource_item' item_id='{{ $dr->id }}'>
                                <div class='box-body'>
                                    <div class='row'>
                                        <div class='col-md-2'>
                                            <img src='{{ asset("img/monument.png") }}' height='50' border='0'> 
                                        </div>
                                        <div class='col-md-10'>
                                            <a href='#' id='dr_item_href' item_id='{{ $dr->id }}' data-toggle='modal' data-target='#item-modal'>{{ $dr->name }}</a>
                                        </div>
                                    </div></br>
                                    <div class='row'>
                                        <div class='col-md-12'>
                                        <br/><br/>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-10'>
                                            type: <b>{{ $type['name'] }}</b><br/>
                                            @foreach($dr->properties['ariadne_subject'] as $value)
                                            subject: <b>{{ $value }}</b> <br/>
                                            @endforeach
                                        </div>
                                        <div class='col-md-2 pull-right'>         
                                            <br/><br/><a href='#' id='dr_item_href' item_id='{{ $dr->id }}' data-toggle='modal' data-target='#item-modal'>more...</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>						
                 
                    @endforeach
                </div>
            </div>
            <div class="row">
                    <div class="col-md-12" id="search_results_more" p="1" style="display:none;">
                            <center><div class="btn btn-primary btn-sm"> more results </div></center>
                    </div>
            </div>
        
        <!-- ITEM MODAL -->
        <div class="modal modal-wide fade" id="item-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa  fa-picture-o"></i> <div id="item_title"></div></h4>
                    </div>
                        
                    <div class="modal-body">
                        <div class="nav-tabs-custom">
                            <ul id='tabs' class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-tag"></i> General</a></li>
                                    <li class=""><a href="#tab_2" data-toggle="tab"><i class="fa fa-minus-circle"></i> Rights</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">

                                    <div class="row" style="margin-bottom:8px;">
                                            <div class="col-md-3">Identifier:</div>
                                            <div class="col-md-9" id="rec-ident">{{ $type['ident'] }}:{{ $dr->id }}</div>
                                    </div>
                                    <div class="row" style="margin-bottom:8px;">
                                            <div class="col-md-3">Title:</div>
                                            <div class="col-md-9" id="rec-title">{{ $dr->name }}</div>
                                    </div>
                                    
                                    <div class="row" style="margin-bottom:8px;">
                                            <div class="col-md-3">Description:</div>
                                            <div class="col-md-9" id="rec-desc">{{ $value }}</div>
                                    </div>
                                    
                                    <div class="row" style="margin-bottom:8px;">
                                            <div class="col-md-3">Type:</div>
                                            <div class="col-md-9" id="rec-type">{{ $type['name'] }}</div>
                                    </div>
                                    <div class="row" style="margin-bottom:8px;">
                                            <div class="col-md-3">Language:</div>
                                            <div class="col-md-9" id="rec-lan"></div>
                                    </div>
                                    <div class="row" style="margin-bottom:8px;">
                                            <div class="col-md-3">Landing Page:</div>
                                            <div class="col-md-9" id="rec-landingpage"></div>
                                    </div>
                                    <div class="row" style="margin-bottom:8px;">
                                            <div class="col-md-3">Agent:</div>
                                            <div class="col-md-9" id="rec-agent"></div>
                                    </div>
                                    <div class="row" style="margin-bottom:8px;">
                                            <div class="col-md-3">Ariadne subject:</div>
                                            <div class="col-md-9" id="rec-ariadne_subject"></div>
                                    </div>
                                    <div class="row" style="margin-bottom:8px;">
                                            <div class="col-md-3">Keywords:</div>
                                            <div class="col-md-9" id="rec-keywords"></div>
                                    </div>																													
                                </div>
                                <div class="tab-pane " id="tab_2">
                                        <div class="row" style="margin-bottom:8px;">
                                                <div class="col-md-3">Publisher:</div>
                                                <div class="col-md-9" id="rec-publisher"></div>
                                        </div>
                                        <div class="row" style="margin-bottom:8px;">
                                                <div class="col-md-3">Creator:</div>
                                                <div class="col-md-9" id="rec-creator"></div>
                                        </div>
                                        <div class="row" style="margin-bottom:8px;">
                                                <div class="col-md-3">Owner:</div>
                                                <div class="col-md-9" id="rec-owner"></div>
                                        </div>																	
                                </div>		
                            </div>
                        </div>

                    </div>

                <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-success pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                </div>
                        
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
   </section>             
</aside>
@endsection