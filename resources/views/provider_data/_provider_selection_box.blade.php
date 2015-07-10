<div class="box-header">
    <h3 class="box-title"><?php //echo $type_name; ?> <?php //if ($user_id != 0) echo "of " . $user_name; ?></h3>
    <div class="pull-right box-tools">
        <form name='search' method='POST' action='{{ action('CollectionController@index') }}' style='display:inline;' >   
            <div class="col-xs-12  pull-right">
                <label>Select Provider</label>
                </br>
                <select name="provider" class="form-control" style='display:inline; width: 70%;'>
                    <option value='0'>-</option>
                    @foreach ($providers as $provider)
                        <?php 
                            if (isset($provider_id)){
                                if ($provider_id==$provider['_id']) $sel='selected';     
                                else $sel='';
                            }
                            else if (Request::input('provider')!='') {
                                 if (Request::input('provider')==$provider['_id']) $sel='selected';     
                                else $sel='';
                            }
                        ?>
                        <option value='{{$provider['_id']}}' <?php echo $sel; ?> >{{$provider['_source']['acronym']}} </option>
                    @endforeach                    
                </select> 
                <button class="btn btn-sm btn-default" type="submit"><i class="fa fa-search"></i></button>
            </div>	
        </form>										
    </div>						
</div><!-- /.box-header -->