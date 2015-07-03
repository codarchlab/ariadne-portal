<div class="box-header">
    <h3 class="box-title"><?php //echo $type_name; ?> <?php //if ($user_id != 0) echo "of " . $user_name; ?></h3>
    <div class="pull-right box-tools">
        <form name='search' method='POST' action='' style='display:inline;' >   
            <div class="col-xs-12  pull-right">
                <label>Select Provider</label>
                </br>
                <select name="search_query" class="form-control" style='display:inline; width: 70%;'>
                    <option value='0'>-</option>
                    @foreach ($providers as $provider)

                    @endforeach                    
                </select> 
                <button class="btn btn-sm btn-default" type="submit"><i class="fa fa-search"></i></button>
            </div>	
        </form>										
    </div>						
</div><!-- /.box-header -->