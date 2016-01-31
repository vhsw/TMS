                        <li class="sidebar-toggler-wrapper hide">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler"> </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>

                        <li class="sidebar-search-wrapper">
                            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                            <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                                <a href="javascript:;" class="remove">
                                    <i class="icon-close"></i>
                                </a>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <a href="javascript:;" class="btn submit">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </span>
                                </div>
                            </form>
                            <!-- END RESPONSIVE QUICK SEARCH FORM -->
                        </li>

                
            
                        <li class="nav-item start {{ \App\Services\Active::pattern('/', 'active open') }}">
                            <a href="/" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Home</span>
                                <span class="selected start "></span>
                            </a>
                        </li>

                        <li class="heading">
                            <h3 class="uppercase">Features</h3>
                        </li>

                        <li class="nav-item {{ \App\Services\Active::pattern('requests', 'active open') }}">
                            <a href="{!!url('requests')!!}" class="nav-link ">
                                <i class="icon-magic-wand"></i>
                                <span class="title">Requests</span>
                                <span class="selected start "></span>
                            </a>
                        </li>

                        <li class="nav-item {{ \App\Services\Active::pattern('tools/*', 'active open') }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-wrench"></i>
                                <span class="title">Tools</span>
                                <span class="selected start "></span>
                                <span class="arrow {{ \App\Services\Active::pattern('tools/*', 'open') }}"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ \App\Services\Active::pattern('tools/search', 'active open') }}">
                                    <a href="{!!url('tools/search')!!}" class="nav-link ">
                                        <i class="icon-magnifier"></i>
                                        <span class="title">Search</span>
                                        {!! \App\Services\Active::pattern('tools/search', '<span class="selected"></span>') !!}
                                    </a>
                                </li>
                                <li class="nav-item {{ \App\Services\Active::pattern('tools/browse', 'active open') }}">
                                    <a href="{!!url('tools/browse')!!}" class="nav-link ">
                                        <i class="icon-book-open"></i>
                                        <span class="title">Browse</span>
                                        {!! \App\Services\Active::pattern('tools/browse', '<span class="selected"></span>') !!}
                                    </a>
                                </li>
                            </ul>
                        </li>

@if(Auth::check() && Auth::user()->hasRole('admin'))

                        <li class="heading">
                            <h3 class="uppercase">Admin Tools</h3>
                        </li>

                        <li class="nav-item {{ \App\Services\Active::pattern('data/*', 'active open') }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-layers"></i>
                                <span class="title">Data</span>
                                <span class="selected "></span>
                                <span class="arrow {{ \App\Services\Active::pattern('data/*', 'open') }}"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ \App\Services\Active::pattern('data/categories', 'active open') }}">
                                    <a href="{!!url('data/categories')!!}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Categories</span>
                                        {!! \App\Services\Active::pattern('data/categories', '<span class="selected"></span>') !!}
                                    </a>
                                </li>
                                <li class="nav-item {{ \App\Services\Active::pattern('data/locations', 'active open') }}">
                                    <a href="{!!url('data/locations')!!}" class="nav-link ">
                                        <i class="icon-drawer"></i>
                                        <span class="title">Locations</span>
                                        {!! \App\Services\Active::pattern('data/locations', '<span class="selected"></span>') !!}
                                    </a>
                                </li>
                                <li class="nav-item {{ \App\Services\Active::pattern('data/suppliers', 'active open') }}">
                                    <a href="{!!url('data/suppliers')!!}" class="nav-link ">
                                        <i class="icon-globe"></i>
                                        <span class="title">Suppliers</span>
                                        {!! \App\Services\Active::pattern('data/suppliers', '<span class="selected"></span>') !!}
                                    </a>
                                </li>
                                <li class="nav-item {{ \App\Services\Active::pattern('data/resources', 'active open') }}">
                                    <a href="{!!url('data/resources')!!}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Resources</span>
                                        {!! \App\Services\Active::pattern('data/resources', '<span class="selected"></span>') !!}
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item {{ \App\Services\Active::pattern('system/*', 'active open') }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">System</span>
                                <span class="selected "></span>
                                <span class="arrow {{ \App\Services\Active::pattern('system/*', 'open') }}"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item {{ \App\Services\Active::pattern('system/variables', 'active open') }}">
                                    <a href="{!!url('system/variables')!!}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Variables</span>
                                        {!! \App\Services\Active::pattern('system/variables', '<span class="selected"></span>') !!}
                                    </a>
                                </li>
                            </ul>
                        </li>
@endif
 