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

                         <li{{ (Request::is('search') ? ' class=active' : '') }}>
                            <a href="{{ action('SearchController@index') }}">
                                <i class="fa fa-search"></i> <span>Search</span>
                            </a>
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

                        <li class="treeview{{ Utils::containsAndNotContains(Request::url(), array('dataset', 'collection', 'database', 'gis', 'agent', 'metaSchema', 'service', 'vocabulary'), 'search') ? ' active' : '' }}" >
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
                                <li {{ (Request::is('database') ? ' class=active' : '') }}>
                                    <a href="{{ action('DatabaseController@index') }}">
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
                                <li {{ (Request::is('metaSchema') ? ' class=active' : '') }}>
                                    <a href="{{ action('MetaSchemaController@index') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-square-o"></i> <span>Metadata Schemas</span>
                                    </a>
                                </li>	
                                <li {{ (Request::is('service') ? ' class=active' : '') }}>
                                    <a href="{{ action('ServiceController@index') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        <i class="fa fa-gears"></i> <span>Services</span>
                                    </a>
                                </li>	
                                <li {{ (Request::is('vocabulary') ? ' class=active' : '') }}>
                                    <a href="{{ action('VocabularyController@index') }}">
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

                        <li{{ (Request::is('subject') ? ' class=active' : '') }}>
                            <a href="{{ action('SubjectController@index') }}">
                                <i class="fa fa-tag "></i> <span>Ariadne subject</span>
                            </a>
                        </li>                        

                        <li{{ (Request::is('about') ? ' class=active' : '') }}>
                            <a href="{{ action('WelcomeController@about') }}">
                                <i class="fa fa-question-circle"></i> <span>About</span>
                            </a>
                        </li>
                        
                        <li >
                            <a href="http://www.dcu.gr" target="_blank"><img style="max-width:150px;" src="{{ asset('img/dcu_logo_footer.png') }}" class="img-responsive" /></a>
                        </li>
                        
                        <li >
                            <a href="http://snd.gu.se" target="_blank"><img style="max-width:150px;" src="{{ asset('img/English_SND.png') }}" class="img-responsive" /></a>
                        </li>

                    </ul>

                </section>
                <!-- /.sidebar -->
            </aside>
