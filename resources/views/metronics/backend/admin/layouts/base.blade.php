<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
            <title>{{ $pageTitle or "Page Title" }} | JGTC 2018</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="SuitEvent" name="description" />
        {{-- csrf token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="apple-touch-icon" href="{{ asset('frontend/assets/img/apple-icon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('frontend/assets/img/favicon.png') }}">

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{ Theme::url('backend/css/main.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/global/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ Theme::url('backend/global/css/components-md.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ Theme::url('backend/global/css/plugins-md.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        @yield('style-page')

        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ Theme::url('backend/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ Theme::url('backend/layouts/layout/css/themes/colorbrand.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ Theme::url('backend/layouts/layout/css/themes/custom.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <!--
        <link href="{{ Theme::url('backend/layouts/layout/css/themes/darkblue.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        -->
        <link href="{{ Theme::url('backend/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <!-- BEGIN FROM SUITBAZE STYLES -->

        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/modernizr.min.js') }}"></script>
        <!-- END FROM SUITBAZE STYLES -->

        @yield('style-head')
        @yield('script-head')
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md {{ Theme::config('sidebar-closed') !== null ? (Theme::config('sidebar-closed') ? 'page-sidebar-closed' : '') : '' }}">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="{{ route('backend.home.index') }}">
                        <img height="12" src="{{ Theme::url('backend/img/logo-jgtc.jpg') }}" alt="jgtc logo" class="logo-default" />
                    </a>
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN NOTIFICATION DROPDOWN -->
                        {{-- @if (in_array(auth()->user()->role, ['admin']))
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                <i class="icon-bell"></i>
                                <span class="badge badge-default"> {{ notifCounter() }} </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="external">
                                    <h3><span class="bold">{{ notifCounter() }}</span> Unread Notifications</h3>
                                    <a href="{{ route('backend.notification.index') }}">View all</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 500px;" data-handle-color="#637283">
                                        @foreach($latestNotifications as $notif)
                                        <li style="{{ $notif->is_read == 0 ? 'background-color: #f6f9fb;' : '' }}">
                                            <a href="{{ route('backend.notification.click', ['id' => $notif->id]) }}">
                                                <span class="time">{{  Carbon\Carbon::createFromTimestamp(strtotime($notif->created_at))->diffForHumans() }}</span>
                                                <span class="details">
                                                    {{ $notif->message }}
                                                </span>
                                            </a>
                                        </li>
                                        @endforeach
                                        <li>
                                            <a href="{{ route('backend.notification.index') }}">
                                                <span class="details">View all</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        @endif --}}
                        <!-- END NOTIFICATION DROPDOWN -->
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            @if (Auth::check())
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="username username-hide-on-mobile" style="color: black;">Hi, {{Auth::user()->name}}</span>
                                    <i class="fa fa-angle-down" style="color: black"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="{{ route('backend.useraccount.index') }}">
                                            <i class="icon-user"></i> My Account </a>
                                    </li>
                                    <li class="divider"> </li>
                                    <li>
                                        <a href="{{route('frontend.home')}}" target="_blank">
                                            <i class="icon-globe"></i> Go To Public Web
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="{{ Theme::url('backend/layouts/layout/img/avatar3_small.jpg') }}" />
                                    <span class="username username-hide-on-mobile"> Hi, Guest </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            @endif
                        </li>
                        <li class="dropdown dropdown-quick-sidebar-toggler">
                            <a href="{{ route('sessions.logout') }}" class="dropdown-toggle" title="Logout">
                                <i class="icon-logout"></i>
                            </a>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <div class="">
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed {{ Theme::config('sidebar-closed') !== null ? (Theme::config('sidebar-closed') ? 'page-sidebar-menu-closed' : '') : '' }}" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <li class="sidebar-toggler-wrapper hide">
                                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                                <!-- END SIDEBAR TOGGLER BUTTON -->
                            </li>
                            <li class="sidebar-search-wrapper">
                                <div class="sidebar-search  sidebar-search-bordered">
                                    <a href="javascript:;" class="remove">
                                        <i class="icon-close"></i>
                                    </a>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="{{ date('D, d M Y') }}" readonly />
                                        <span class="input-group-btn">
                                            <a href="javascript:;" class="btn submit">
                                                <i class="icon-clock"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <!-- DATE/TIME -->
                            </li>
                            <!--
                            <li class="heading">
                                <h3 class="uppercase">Heading Menu</h3>
                            </li>
                            -->
                            @foreach(\App\SuitEvent\Config\DefaultConfig::getConfig()['pageId'] as $key => $value)
                                @if (in_array(auth()->user()->role, $value['roles']))
                                <li class="nav-item start {{ $pageId[0] == $key ? "active open" : "" }}">
                                    <a href="javascript:;" class="nav-link {{ sizeof($value['submenu']) > 0 ? 'nav-toggle' : '' }}" href="{{ sizeof($value['submenu']) > 0 ? '#' : route($value['route']) }}">
                                        <i class="fa {{ isset($value['icon']) ? $value['icon'] : 'fa-map' }}"></i>
                                        <span class="title">{{ $value['label'] }}</span>
                                        <span class="arrow"></span>
                                    </a>
                                    @if (sizeof($value['submenu']) > 0)
                                    <ul class="sub-menu">
                                        @foreach ($value['submenu'] as $submenuKey => $submenuValue)
                                            @if (in_array(auth()->user()->role, $submenuValue['roles']))
                                            <li class="nav-item start {{ $pageId == $submenuKey ? "active open" : "" }}">
                                                <a class="nav-link " href="{{ route($submenuValue['route']) }}">
                                                    <i class="{{ isset($submenuValue['icon']) ? $submenuValue['icon'] : 'fa fa-map' }}"></i>
                                                    <span class="title">{{ $submenuValue['label'] }}</span>
                                                    <!--
                                                    <span class="badge badge-success">1</span>
                                                    <span class="badge badge-danger">5</span>
                                                    -->
                                                </a>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endif
                            @endforeach
                        </ul>
                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN LARAVEL CONTENT BODY -->
                        @yield('featured-content')
                        @yield('content')
                        <!-- END LARAVEL CONTENT BODY -->
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <div class="page-footer">
                <div class="page-footer-inner"> Copyright &copy; 2018 Suitmedia, All Rights Reserved.
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
        <!--[if lt IE 9]>
        <script src="{{ Theme::url('backend/global/plugins/respond.min.js') }}"></script>
        <script src="{{ Theme::url('backend/global/plugins/excanvas.min.js') }}"></script>
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ Theme::url('backend/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ Theme::url('backend/global/scripts/datatable.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/ladda/spin.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/ladda/ladda.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ Theme::url('backend/global/scripts/app.min.js') }}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ Theme::url('backend/pages/scripts/table-datatables-ajax.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/pages/scripts/dataTables.buttons.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/pages/scripts/buttons.print.min.js') }}" type="text/javascript"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
        {{-- <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
        <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/vfs_fonts.js"></script> --}}
        <script src="{{ Theme::url('backend/pages/scripts/components-select2.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ Theme::url('backend/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
        <script src="{{ Theme::url('backend/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script type="text/javascript">            window.myPrefix = '';</script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/jquery.dataTables.yadcf.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/locationpicker.jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/highcharts.min.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/highcharts.funnel.js')}}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/highcharts.exporting.js')}}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/jquery.inputmask.min.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/jquery.inputmask.numeric.min.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/vanilla.masker.min.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/rome.min.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript"> CKEDITOR.timestamp = Date.now() / 1000 | 0; </script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/ckeditor/adapters/jquery.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/autosize.min.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/vendor/colorpicker.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/helpers.min.js') }}"></script>
        <script type="text/javascript" src="{{ Theme::url('backend/js/main.min.js') }}"></script>

        @yield('page_script')

    </body>
</html>
