<div class="box-header">
    <h3 class="box-title"><?php //echo $type_name; ?> <?php //if ($user_id != 0) echo "of " . $user_name; ?></h3>
    <div class="pull-right box-tools">
        <form name='search' method='POST' action='' style='display:inline;' >   
            <div class="col-xs-12  pull-right">
                <label>Select Provider</label>
                </br>
                <select name="search_query" class="form-control" style='display:inline; width: 70%;'>
                    <option value='0'>-</option>
                    <?php
                    /*
                    $results = $db->query("SELECT * FROM `users` WHERE `id` IN " . $providers);
                    foreach ($results as $result) {
                        $pr_id = $result['id'];
                        $pr_name = $result['name'];

                        if ($pr_id == 33)
                            $pr_name = "DANS";
                        if ($pr_id == 59)
                            $pr_name = "SND";
                        if ($pr_id == 61)
                            $pr_name = "INRAP";
                        if ($pr_id == 34)
                            $pr_name = "ADS";

                        if (intval($search_query) == $pr_id)
                            $sel = "selected";
                        else
                            $sel = "";
                        echo "<option value='" . $pr_id . "' " . $sel . ">" . $pr_name . "</option>\n";
                     * 
                     */
                    ?>
                </select> 
                <button class="btn btn-sm btn-default" type="submit"><i class="fa fa-search"></i></button>
            </div>	
        </form>										
    </div>						
</div><!-- /.box-header -->