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

                        
            
                        <li class="nav-item start ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-wrench"></i>
                                <span class="title">Tools</span>
                                <span class="selected start "></span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item ">
                                    <a href="{!!url('tools/search')!!}" class="nav-link ">
                                        <i class="icon-magnifier"></i>
                                        <span class="title">Search</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a href="{!!url('tools/browse')!!}" class="nav-link ">
                                        <i class="icon-book-open"></i>
                                        <span class="title">Browse</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a href="{!!url('tools/requests')!!}" class="nav-link ">
                                        <i class="icon-magic-wand"></i>
                                        <span class="title">Requests</span>
                                        <span class="badge badge-success">1</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item start ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-layers"></i>
                                <span class="title">Data</span>
                                <span class="selected "></span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item ">
                                    <a href="{!!url('admin/data/categories')!!}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Categories</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a href="{!!url('admin/data/locations')!!}" class="nav-link ">
                                        <i class="icon-drawer"></i>
                                        <span class="title">Locations</span>
                                        <span class="badge badge-success">1</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a href="{!!url('admin/data/suppliers')!!}" class="nav-link ">
                                        <i class="icon-globe"></i>
                                        <span class="title">Suppliers</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a href="{!!url('admin/data/resources')!!}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Resources</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item start ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">System</span>
                                <span class="selected "></span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item ">
                                    <a href="{!!url('admin/system/variables')!!}" class="nav-link ">
                                        <i class="icon-list"></i>
                                        <span class="title">Variables</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

 