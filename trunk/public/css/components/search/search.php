<?php
	if(isset($_GET['q'])) $q = strval($_GET['q']);
	if(isset($_POST['q'])) $q = strval($_POST['q']);
	
	if(isset($_GET['type'])) $type = strval($_GET['type']);
	if(isset($_POST['type'])) $type = strval($_POST['type']);
	if($type=="") $type="datasets";
	
	if($type=="datasets") $type_name="datasets";
	if($type=="collections") $type_name="collections";
	
?>

<aside class="right-side">                

	<!-- Main content -->
	<section class="content">
		<div class="row">

			<div class="col-md-3"></div>
			<div class="col-md-6">

				<!-- search form -->
				<form action="#" method="POST" >
				<input type="hidden" name="search_type" id="search_type" value="<?php echo $type; ?>" />
					<div class="input-group">
						<input type="text" name="q" class="form-control" placeholder="Search for <?php echo $type_name; ?>...">
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
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
								<li class=""><a href="#tab_2" data-toggle="tab">Rights</a></li>
								<li class=""><a href="#tab_3" data-toggle="tab">Spatial</a></li>
								<li class=""><a href="#tab_4" data-toggle="tab">Temporal</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
								
									<div class="row" style="margin-bottom:8px;">
										<div class="col-md-3">Title:</div>
										<div class="col-md-9" id="rec-title"></div>
									</div>
									<div class="row" style="margin-bottom:8px;">
										<div class="col-md-3">Description:</div>
										<div class="col-md-9" id="rec-desc"></div>
									</div>
									<div class="row" style="margin-bottom:8px;">
										<div class="col-md-3">Type:</div>
										<div class="col-md-9" id="rec-type"></div>
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
									
								<div class="tab-pane " id="tab_3">
								
								</div>
															
							</div>
						</div>
																
					</div>
						
					<div class="modal-footer clearfix">
						<button type="button" class="btn btn-success pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
					</div>
                        
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        
	</section>
</aside>