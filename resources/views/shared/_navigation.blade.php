            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <br/>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">

                        <li>
                            <a href="{{ action('WelcomeController@index') }}">
                                <i class="fa fa-home"></i> <span>Home</span>
                            </a>
                        </li>

                        <li class="treeview" >
                            <a href="index.php?op=browse">
                                <i class="fa fa-search"></i> <span>Search</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="index.php?op=browse&type=datasets">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-archive"></i> <span>Datasets</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?op=browse&type=collections">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-picture-o"></i> <span>Collections</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <a href="index.php?op=map">
                                <i class="fa fa-map-marker"></i> <span>Map based search</span>
                            </a>
                        </li>

                        <li{{ (Request::is('provider') ? ' class=active' : '') }}>
                            <a href="{{ action('ProviderController@index') }}">
                                <i class="fa fa-users"></i> <span>Provider info</span>
                            </a>
                        </li> 

                        <li class="treeview" >
                            <a href="#">
                                <i class="fa fa-list"></i> <span>Provider data</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                               <li{{ (Request::is('collection') ? ' class=active' : '') }}>
                                    <a href="{{ action('CollectionController@index') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-picture-o"></i> <span>Collections</span>
                                    </a>
                                </li>
                               <li{{ (Request::is('dataset') ? ' class=active' : '') }}>
                                    <a href="{{ action('DatasetController@index') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-archive"></i> <span>Datasets</span>
                                    </a>
                                </li>								
                                <li>
                                    <a href="index.php?op=data_summary&table=DataResource&type=2">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-cloud"></i> <span>Databases</span>
                                    </a>
                                </li>	
                               <li{{ (Request::is('gis') ? ' class=active' : '') }}>
                                    <a href="{{ action('GisController@index') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-globe"></i> <span>GIS</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?op=data_summary&table=MetadataSchema">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-square-o"></i> <span>Metadata Schemas</span>
                                    </a>
                                </li>	
                                <li>
                                    <a href="index.php?op=data_summary&table=ARIADNEService">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-gears"></i> <span>Services</span>
                                    </a>
                                </li>	
                                <li>
                                    <a href="index.php?op=data_summary&table=Vocabulary">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-file-text-o"></i> <span>Vocabularies</span>
                                    </a>
                                </li>
                               <li{{ (Request::is('agent') ? ' class=active' : '') }}>
                                    <a href="{{ action('AgentController@index') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-user"></i> <span>Agents</span>
                                    </a>
                                </li>								
                            </ul>
                        </li>    						

                        <li{{ (Request::is('subjects') ? ' class=active' : '') }}>
                            <a href="{{ action('SubjectController@index') }}">
                                <i class="fa fa-tag "></i> <span>Ariadne subject</span>
                            </a>
                        </li>                        

                        <li>
                            <a href="/about">
                                <i class="fa fa-question-circle"></i> <span>About</span>
                            </a>
                        </li>

                    </ul>

                </section>
                <!-- /.sidebar -->
            </aside>