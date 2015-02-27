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
                               <?php foreach($subjects as $subject): ?>
                                <tr>
                                   <th><?php print $subject->name;?></th>
                                   <td><?php print $subject->collections;?></td>
                                   <td><?php print $subject->datasets;?></td>
                                   <td><?php print $subject->databases;?></td>
                                   <td><?php print $subject->gis;?></td>
                                </tr>
                               <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>              
</aside>
@endsection