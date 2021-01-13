<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- FONTS -->
    {!! Html::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all') !!}
    {!! Html::style('global/plugins/font-awesome/css/font-awesome.min.css') !!}
    {!! Html::style('global/plugins/simple-line-icons/css/simple-line-icons.css') !!}
    {!! Html::style('global/plugins/typeahead.js-bootstrap3.less/typeaheadjs.css') !!}
    <!-- GLOBAL STYLE (Sass) -->
    {!! Html::style('css/global.css') !!}
    <!-- PAGE SPECIFIC STYLE -->
    @yield('css')
    <!-- LAYOUT STYLE (Sass) -->
    {!! Html::style('css/layout.css') !!}
    <!-- EXTRA STYLE -->
    @yield('style')

    <style>
    .pagination > li.paginate_button {padding:0 !important;}
    </style>

    <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">

        @include('includes.overlay')

        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <span class="logo-default" style="color:#c6cfda;font-size:20px;font-weight:500;padding:1px 5px 6px 0px">TMS</span>
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>


                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->

                <!-- BEGIN PAGE TOP -->

                {{-- @include('includes.search') --}}

                <!-- END HEADER SEARCH BOX -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">

                    <ul class="nav navbar-nav pull-right">
                        @include('includes.topnav')


                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->

                <!-- END HEADER INNER -->
            </div>
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->

        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- END SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->

                <div class="page-sidebar navbar-collapse collapse">

                    <ul class="menu-trigger page-sidebar-menu page-header-fixed " data-keep-expanded="false" data-auto-scroll="false" data-slide-speed="200" style="padding-top: 20px">
                        <!-- BEGIN SIDEBAR MENU -->
                        @include('includes.nav')
                        <!-- END SIDEBAR MENU -->
                    </ul>
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <!-- BEGIN THEME PANEL -->


                    {{-- @include('includes.themepanel') --}}


                    {{-- @include('includes.partials.messages') --}}


                    @yield('content')




                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->


            {{-- @include('includes.sidebar') --}}


            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->


        @include('includes.footer')


        <!-- END FOOTER -->
        <!--[if lt IE 9]>
        {!! HTML::script('global/plugins/respond.min.js') !!}
        {!! HTML::script('global/plugins/excanvas.min.js') !!}
        <![endif]-->


        <!-- CORE PLUGINS -->
        <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!};
        </script>
        {!! Html::script('global/plugins/jquery/jquery.min.js') !!}
        {!! Html::script('global/plugins/bootstrap/dist/js/bootstrap.min.js') !!}
        {!! Html::script('js/global.js') !!}
        {!! Html::script('global/plugins/js-cookie/src/js.cookie.js') !!}
        {!! Html::script('global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') !!}
        {!! Html::script('global/plugins/blockUI/jquery.blockUI.js') !!}
        {!! Html::script('global/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js') !!}
        {!! Html::script('global/plugins/typeahead.js/dist/typeahead.bundle.min.js') !!}
        {!! Html::script('js/johnnyhuman.overlay.js') !!}
        <!-- PAGE SPECIFIC SCRIPTS -->
        @yield('js')
        <!-- MAIN APP SCRIPT -->
        {!! Html::script('global/scripts/app.js') !!}

        <script>

        var overlay = $('.burger-trigger').overlay({
            'ajaxUserUrl' :             '{!! url("login") !!}',
            'ajaxResourceUrl' :         '{!! url("resource/change") !!}',
            'ajaxSearchBarcodeUrl' :    '{!! url("inventory/instant-search-barcode") !!}',
            'ajaxSearchSerialnrUrl' :   '{!! url("inventory/instant-search-serialnr") !!}',
            'ajaxFindItemBySerialnr' :  '{!! url("inventory/instant-item-serialnr") !!}',
        });

        var reveal = function reveal() {
            overlay.find('form').addClass('hidden');
            if (overlay.hasClass('hidden')) {
                overlay.removeClass("hidden");
            } else {
                overlay.show();
            }
        }

        function submitRequest() {
            var submitForm = $('.burger-trigger').find('[data-form="barcode"]');
            submitForm.append( $('.burger-trigger').find('#search_str') );
            submitForm.attr('action', '{!! url("requests/create") !!}');
            submitForm.submit();
        };

        @if(!Auth::check())
        // $('[data-toggle="user"]').trigger('click');
        @endif


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'off' );
        });


        </script>
        <!-- EXTRA SCRIPT -->
        @yield('script')
        <!-- LAYOUT SCRIPTS -->
        {!! Html::script('layouts/layout/scripts/layout.js') !!}
        {!! Html::script('layouts/global/scripts/quick-sidebar.min.js') !!}
        {!! Html::script('js/modernizr.custom.js') !!}
        {!! Html::script('global/plugins/jquery.scrollbar/jquery.scrollbar.min.js') !!}

    </body>

    </html>
