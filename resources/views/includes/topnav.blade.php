                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                      
                            {{-- @include('includes.partials.notifications') --}}
                            
                            <!-- END NOTIFICATION DROPDOWN -->
                            <!-- BEGIN INBOX DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            
                            {{-- @include('includes.partials.newmessages') --}}

                            <!-- END INBOX DROPDOWN -->
                            <!-- BEGIN TODO DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            
                            {{-- @include('includes.partials.tasks') --}}

                            <!-- END TODO DROPDOWN -->


                            <li class="dropdown dropdown-user dropdown-dark" data-toggle="user">
                                <a href="javascript:;" class="dropdown-toggle">
                                    <span class="username username-hide-on-mobile">
                                    {{ Auth::check() ? Auth::user()->name : 'Login' }}</span>
                                    <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                    <img alt="" class="img-circle" src="" /> </a>
                                
                            </li>

                            @if(Auth::check())
                            <li class="dropdown dropdown-user"><span class="at username-hide-on-mobile">@</span></li>

                            <li class="dropdown dropdown-user dropdown-dark " data-toggle="resource">
                                <a href="javascript:;" class="dropdown-toggle">
                                    <span class="username username-hide-on-mobile">{{ Auth::user()->resource->short_name }}</span>
                                    <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                    <img alt="" class="img-circle" src="" /> </a>
                                
                            </li>
                            @endif


                            <li class="dropdown dropdown-quick-sidebar-toggler">
                                <a href="javascript:;" class="dropdown-toggle">
                                    <i class="icon-logout"></i>
                                </a>
                            </li>