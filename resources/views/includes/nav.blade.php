<li class="sidebar-toggler-wrapper hide">
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <div class="sidebar-toggler"> </div>
    <!-- END SIDEBAR TOGGLER BUTTON -->
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

<li class="nav-item {{ \App\Services\Active::pattern('transactions', 'active open') }}">
    <a href="{!!url('transactions')!!}" class="nav-link ">
        <i class="icon-magic-wand"></i>
        <span class="title">Transactions</span>
        <span class="selected start "></span>
    </a>
</li>

<li class="nav-item {{ \App\Services\Active::pattern('inventory/*', 'active open') }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="icon-wrench"></i>
        <span class="title">Inventory</span>
        <span class="selected start "></span>
        <span class="arrow {{ \App\Services\Active::pattern('inventory/*', 'open') }}"></span>
    </a>
    <ul class="sub-menu">
        <li class="nav-item {{ \App\Services\Active::pattern('inventory/search*', 'active open') }}">
            <a href="{!!url('inventory/search')!!}" class="nav-link ">
                <i class="icon-magnifier"></i>
                <span class="title">Search</span>
                {!! \App\Services\Active::pattern('inventory/search*', '<span class="selected"></span>') !!}
            </a>
        </li>
        <li class="nav-item {{ \App\Services\Active::pattern('inventory/browse', 'active open') }}">
            <a href="{!!url('inventory/browse')!!}" class="nav-link ">
                <i class="icon-book-open"></i>
                <span class="title">Browse</span>
                {!! \App\Services\Active::pattern('inventory/browse', '<span class="selected"></span>') !!}
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
        <li class="nav-item {{ \App\Services\Active::pattern('system/update', 'active open') }}">
            <a href="{!!url('system/update')!!}" class="nav-link ">
                <i class="icon-refresh"></i>
                <span class="title">Update</span>
                {!! \App\Services\Active::pattern('system/update', '<span class="selected"></span>') !!}
            </a>
        </li>
    </ul>
</li>
@endif
