    <div class="pull-right box-tools">
        <?php 
            if (isset($collections)) $action = "CollectionController@index"; 
            else if (isset($databases)) $action = "DatabaseController@index"; 
            else if (isset($agents)) $action = "AgentController@index"; 
            else if (isset($giss)) $action = "GisController@index"; 
            else if (isset($metaSchemas)) $action = "MetaSchemaController@index"; 
            else if (isset($services)) $action = "ServiceController@index"; 
            else if (isset($textualDocuments)) $action = "TextualDocumentController@index"; 
            else if (isset($vocabularies)) $action = "VocabularyController@index"; 
            else if (isset($datasets)) $action = "DatasetController@index"; 
            else $action="#";
        ?>
        <form name='search' method='POST' action='{{ action($action) }}' style='display:inline;' >   
            <div class="col-xs-12  pull-right">
                <label>Select Provider</label>
                </br>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
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
                            else $sel='';
                        ?>
                        <option value='{{$provider['_id']}}' <?php echo $sel; ?> >{{$provider['_source']['acronym']}} </option>
                    @endforeach                    
                </select> 
                <button class="btn btn-sm btn-default" type="submit"><i class="fa fa-search"></i></button>
            </div>	
        </form>										
    </div>						
