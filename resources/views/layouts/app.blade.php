<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>چمران‌شهر</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.7 -->
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
{{--    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">--}}

{{--<!-- Optional theme -->--}}
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">--}}

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <!-- Customisation -->
    <style>


        /*********************************************************/
        /*                      English Digits                      */
        /*********************************************************/
        @font-face {
            font-family: Vazir;
            src: url('/fonts/vazir/englishdigits/Vazir.eot');
            src: url('/fonts/vazir/englishdigits/Vazir.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/englishdigits/Vazir.woff2') format('woff2'),
            url('/fonts/vazir/englishdigits/Vazir.woff') format('woff'),
            url('/fonts/vazir/englishdigits/Vazir.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: Vazir;
            src: url('/fonts/vazir/englishdigits/Vazir-Bold.eot');
            src: url('/fonts/vazir/englishdigits/Vazir-Bold.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/englishdigits/Vazir-Bold.woff2') format('woff2'),
            url('/fonts/vazir/englishdigits/Vazir-Bold.woff') format('woff'),
            url('/fonts/vazir/englishdigits/Vazir-Bold.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        @font-face {
            font-family: Vazir;
            src: url('/fonts/vazir/englishdigits/Vazir-Black.eot');
            src: url('/fonts/vazir/englishdigits/Vazir-Black.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/englishdigits/Vazir-Black.woff2') format('woff2'),
            url('/fonts/vazir/englishdigits/Vazir-Black.woff') format('woff'),
            url('/fonts/vazir/englishdigits/Vazir-Black.ttf') format('truetype');
            font-weight: 900;
            font-style: normal;
        }
        @font-face {
            font-family: Vazir;
            src: url('/fonts/vazir/englishdigits/Vazir-Medium.eot');
            src: url('/fonts/vazir/englishdigits/Vazir-Medium.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/englishdigits/Vazir-Medium.woff2') format('woff2'),
            url('/fonts/vazir/englishdigits/Vazir-Medium.woff') format('woff'),
            url('/fonts/vazir/englishdigits/Vazir-Medium.ttf') format('truetype');
            font-weight: 500;
            font-style: normal;
        }
        @font-face {
            font-family: Vazir;
            src: url('/fonts/vazir/englishdigits/Vazir-Light.eot');
            src: url('/fonts/vazir/englishdigits/Vazir-Light.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/englishdigits/Vazir-Light.woff2') format('woff2'),
            url('/fonts/vazir/englishdigits/Vazir-Light.woff') format('woff'),
            url('/fonts/vazir/englishdigits/Vazir-Light.ttf') format('truetype');
            font-weight: 300;
            font-style: normal;
        }
        @font-face {
            font-family: Vazir;
            src: url('/fonts/vazir/englishdigits/Vazir-Thin.eot');
            src: url('/fonts/vazir/englishdigits/Vazir-Thin.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/englishdigits/Vazir-Thin.woff2') format('woff2'),
            url('/fonts/vazir/englishdigits/Vazir-Thin.woff') format('woff'),
            url('/fonts/vazir/englishdigits/Vazir-Thin.ttf') format('truetype');
            font-weight: 100;
            font-style: normal;
        }
        /*********************************************************/
        /*                      Farsi Digits                        */
        /*********************************************************/
        @font-face {
            font-family: VazirFD;
            src: url('/fonts/vazir/farsidigits/Vazir-FD.eot');
            src: url('/fonts/vazir/farsidigits/Vazir-FD.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/farsidigits/Vazir-FD.woff2') format('woff2'),
            url('/fonts/vazir/farsidigits/Vazir-FD.woff') format('woff'),
            url('/fonts/vazir/farsidigits/Vazir-FD.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: VazirFD;
            src: url('/fonts/vazir/farsidigits/Vazir-Bold-FD.eot');
            src: url('/fonts/vazir/farsidigits/Vazir-Bold-FD.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/farsidigits/Vazir-Bold-FD.woff2') format('woff2'),
            url('/fonts/vazir/farsidigits/Vazir-Bold-FD.woff') format('woff'),
            url('/fonts/vazir/farsidigits/Vazir-Bold-FD.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        @font-face {
            font-family: VazirFD;
            src: url('/fonts/vazir/farsidigits/Vazir-Black-FD.eot');
            src: url('/fonts/vazir/farsidigits/Vazir-Black-FD.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/farsidigits/Vazir-Black-FD.woff2') format('woff2'),
            url('/fonts/vazir/farsidigits/Vazir-Black-FD.woff') format('woff'),
            url('/fonts/vazir/farsidigits/Vazir-Black-FD.ttf') format('truetype');
            font-weight: 900;
            font-style: normal;
        }
        @font-face {
            font-family: VazirFD;
            src: url('/fonts/vazir/farsidigits/Vazir-Medium-FD.eot');
            src: url('/fonts/vazir/farsidigits/Vazir-Medium-FD.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/farsidigits/Vazir-Medium-FD.woff2') format('woff2'),
            url('/fonts/vazir/farsidigits/Vazir-Medium-FD.woff') format('woff'),
            url('/fonts/vazir/farsidigits/Vazir-Medium-FD.ttf') format('truetype');
            font-weight: 500;
            font-style: normal;
        }
        @font-face {
            font-family: VazirFD;
            src: url('/fonts/vazir/farsidigits/Vazir-Light-FD.eot');
            src: url('/fonts/vazir/farsidigits/Vazir-Light-FD.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/farsidigits/Vazir-Light-FD.woff2') format('woff2'),
            url('/fonts/vazir/farsidigits/Vazir-Light-FD.woff') format('woff'),
            url('/fonts/vazir/farsidigits/Vazir-Light-FD.ttf') format('truetype');
            font-weight: 300;
            font-style: normal;
        }
        @font-face {
            font-family: VazirFD;
            src: url('/fonts/vazir/farsidigits/Vazir-Thin-FD.eot');
            src: url('/fonts/vazir/farsidigits/Vazir-Thin-FD.eot?#iefix') format('embedded-opentype'),
            url('/fonts/vazir/farsidigits/Vazir-Thin-FD.woff2') format('woff2'),
            url('/fonts/vazir/farsidigits/Vazir-Thin-FD.woff') format('woff'),
            url('/fonts/vazir/farsidigits/Vazir-Thin-FD.ttf') format('truetype');
            font-weight: 100;
            font-style: normal;
        }

        :root { /* general direction */
            direction: rtl;
        }
        body, h1, h2, h3, h4, h5, h6 {
            font-family: VazirFD;
            font-size: 1.15rem;
        }
        h1, h2, h3, h4, h5, h6 {
            font-weight: bolder;
        }
        th {
            text-align: right !important;
        }
        .content-header > h1 > a {
            margin-bottom: 1.7rem !important;
        }
        .td-action {
            width: fit-content;
            display: inline-flex;
            direction: ltr;
        }
        .pad2rem{
            padding: 2rem;
        }
        .mar2rem{
            margin: 2rem;
        }
        .srightleftpad2 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .srightleftmar2 {
            margin-left: 1rem;
            margin-right: 1rem;
        }
        .spad2rem{
            padding: 0.2rem;
        }
        .smar2rem{
            margin: 0.2rem;
        }
        .gap {
           margin-left: 10px;
        }
        .gap2 {
           margin-left: 20px;
        }
        li.active > a {
             padding-left: 2rem;
             padding-right: 2rem;
             color: yellow !important;
         }
        li:not(.active) > a {
             padding-left: 1rem;
             padding-right: 1rem;
         }
        .main-sidebar-right {
            float: right !important;
            right: 0 !important;
        }
        .main-sidebar {
            /*float: right !important;*/
            right: 0 !important;
            width: 25rem;
        }
        .content-wrapper {
            margin-right: 25rem !important;
            margin-left: 0px !important;
            /*left: 0 !important;*/
        }
        /*.main-header .navbar-nav {*/
        /*    !*right: auto !important;*!*/
        /*    margin-left: 0 !important;*/
        /*    !*left: 0 !important;*!*/
        /*}*/

        .logo {
            float: right !important;
            width: 25rem !important;
        }
        @media (max-width: 767px){
            .main-header .logo, .main-header .navbar {
                width: 100% !important;
                float: none !important;
            }
            .main-header .navbar {
                margin-right: 0 !important;
            }
        }
        .main-header .navbar {
            /*-webkit-transition: margin-right .3s ease-in-out;*/
            /*-o-transition: margin-right .3s ease-in-out;*/
            /*transition: margin-right .3s ease-in-out;*/
            margin-bottom: 0;
            margin-left: 0 !important;
            margin-right: 25rem;
            height: 5rem !important;

            border: none;
            min-height: 50px;
            border-radius: 0;
        }
        .main-header {
            background: red !important;
        }
        .navbar-custom-menu {
            float: left !important;
        }
        .sidebar-toggle {
            float: right !important;
        }
        .dropdown-menu {
            right: auto !important;
            left: 0 !important;
        }
        .dropdown {
            margin-left: 5rem;
        }
        /*.content-wrapper > .content { !* to remove pad2rem *!*/
        /*    padding: 0 2rem;*/
        /*}*/
        /*.content-wrapper > .content-header { !* to remove pad2rem *!*/
        /*    padding: 0 2rem;*/
        /*}*/
        .content-wrapper { /* to remove pad2rem */
            padding: 2rem;
        }

        /************************************************************************/
        .control-sidebar-push-slide .content-wrapper,
        .control-sidebar-push-slide .main-footer {
            /*transition: margin-right 0.3s ease-in-out;*/
            transition: margin-left 0.3s ease-in-out;
        }

        .layout-top-nav .wrapper .content-wrapper,
        .layout-top-nav .wrapper .main-header,
        .layout-top-nav .wrapper .main-footer {
            /*margin-left: 0;*/
            margin-right: 0;
        }

        body.sidebar-collapse:not(.sidebar-mini-md):not(.sidebar-mini) .content-wrapper, body.sidebar-collapse:not(.sidebar-mini-md):not(.sidebar-mini) .content-wrapper::before,
        body.sidebar-collapse:not(.sidebar-mini-md):not(.sidebar-mini) .main-footer,
        body.sidebar-collapse:not(.sidebar-mini-md):not(.sidebar-mini) .main-footer::before,
        body.sidebar-collapse:not(.sidebar-mini-md):not(.sidebar-mini) .main-header,
        body.sidebar-collapse:not(.sidebar-mini-md):not(.sidebar-mini) .main-header::before {
            /*margin-left: 0;*/
            margin-right: 0;
        }

        @media (min-width: 768px) {
            body:not(.sidebar-mini-md) .content-wrapper,
            body:not(.sidebar-mini-md) .main-footer,
            body:not(.sidebar-mini-md) .main-header {
                /*transition: margin-left 0.3s ease-in-out;*/
                /*margin-right: 250px;*/
                transition: margin-right 0.3s ease-in-out;
                /*margin-right: 25rem;*/
            }
        }

        @media (min-width: 768px) and (prefers-reduced-motion: reduce) {
            body:not(.sidebar-mini-md) .content-wrapper,
            body:not(.sidebar-mini-md) .main-footer,
            body:not(.sidebar-mini-md) .main-header {
                transition: none;
            }
        }

        @media (min-width: 768px) {
            .sidebar-collapse body:not(.sidebar-mini-md) .content-wrapper, .sidebar-collapse
            body:not(.sidebar-mini-md) .main-footer, .sidebar-collapse
            body:not(.sidebar-mini-md) .main-header {
                /*margin-left: 0;*/
                margin-right: 0;
            }
        }

        @media (max-width: 991.98px) {
            body:not(.sidebar-mini-md) .content-wrapper, body:not(.sidebar-mini-md) .content-wrapper::before,
            body:not(.sidebar-mini-md) .main-footer,
            body:not(.sidebar-mini-md) .main-footer::before,
            body:not(.sidebar-mini-md) .main-header,
            body:not(.sidebar-mini-md) .main-header::before {
                /*margin-left: 0;*/
                margin-right: 0;
            }
        }

        @media (min-width: 768px) {
            .sidebar-mini-md .content-wrapper,
            .sidebar-mini-md .main-footer,
            .sidebar-mini-md .main-header {
                /*transition: margin-left 0.3s ease-in-out;*/
                /*margin-right: 250px;*/
                transition: margin-right 0.3s ease-in-out;
                margin-left: 25rem;
            }
        }

        @media (min-width: 768px) and (prefers-reduced-motion: reduce) {
            .sidebar-mini-md .content-wrapper,
            .sidebar-mini-md .main-footer,
            .sidebar-mini-md .main-header {
                transition: none;
            }
        }

        @media (min-width: 768px) {
            .sidebar-collapse .sidebar-mini-md .content-wrapper, .sidebar-collapse
            .sidebar-mini-md .main-footer, .sidebar-collapse
            .sidebar-mini-md .main-header {
                /*margin-left: 4.6rem;*/
                margin-right: 4.6rem;
            }
        }

        @media (max-width: 991.98px) {
            .sidebar-mini-md .content-wrapper, .sidebar-mini-md .content-wrapper::before,
            .sidebar-mini-md .main-footer,
            .sidebar-mini-md .main-footer::before,
            .sidebar-mini-md .main-header,
            .sidebar-mini-md .main-header::before {
                /*margin-left: 4.6rem;*/
                margin-right: 4.6rem;
            }
        }

        .sidebar-mini.sidebar-collapse .content-wrapper,
        .sidebar-mini.sidebar-collapse .main-footer {
            /*margin-left: 4.6rem !important;*/
            margin-right: 4.6rem !important;
        }

        .sidebar-mini-md.sidebar-collapse .content-wrapper,
        .sidebar-mini-md.sidebar-collapse .main-footer,
        .sidebar-mini-md.sidebar-collapse .main-header {
            /*margin-left: 4.6rem !important;*/
            margin-right: 4.6rem !important;
        }

        .control-sidebar-push-slide .content-wrapper,
        .control-sidebar-push-slide .main-footer {
            /*transition: margin-right 0.3s ease-in-out;*/
            transition: margin-left 0.3s ease-in-out;
        }

        @media (prefers-reduced-motion: reduce) {
            .control-sidebar-push-slide .content-wrapper,
            .control-sidebar-push-slide .main-footer {
                transition: none;
            }
        }

        .control-sidebar-open.control-sidebar-push .content-wrapper,
        .control-sidebar-open.control-sidebar-push .main-footer, .control-sidebar-open.control-sidebar-push-slide .content-wrapper,
        .control-sidebar-open.control-sidebar-push-slide .main-footer {
            /*margin-right: 250px;*/
            margin-left: 25rem;
        }

        .control-sidebar-slide-open.control-sidebar-push .content-wrapper,
        .control-sidebar-slide-open.control-sidebar-push .main-footer, .control-sidebar-slide-open.control-sidebar-push-slide .content-wrapper,
        .control-sidebar-slide-open.control-sidebar-push-slide .main-footer {
            /*margin-right: 250px;*/
            margin-right: 25rem;
        }

        .sidebar-mini.sidebar-collapse .content-wrapper {
            margin-left: 0 !important;
        }
        .sidebar-mini:not(sidebar-collapse) .content-wrapper {
            margin-right: 25rem !important;
        }
        @media (max-width: 768px) {
            .main-sidebar {
                transform: translate(25rem, 0) !important;
            }
            .sidebar-mini:not(sidebar-collapse) .content-wrapper {
                margin-right: 0 !important;
            }
        }
        .content-wrapper, .main-footer {
            margin-right: 25rem !important;
            margin-left: 0 !important;
        }
    </style>


    @yield('css')



<!-- jQuery 3.1.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>

    @yield('scripts')

</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <b>چمران‌شهر</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="http://infyom.com/images/logo/blue_logo_150x150.jpg"
                                     class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! Auth::user()->first_name . ' ' . Auth::user()->last_name!!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="http://infyom.com/images/logo/blue_logo_150x150.jpg"
                                         class="img-circle" alt="User Image"/>
                                    <p>
                                        {!! Auth::user()->name !!}
                                        <small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ route('users.showProfile') }}" class="btn btn-default btn-flat">صفحه‌ی شخصی</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Sign out
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2016 <a href="#">Company</a>.</strong> All rights reserved.
        </footer>

    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">
                    چمران‌شهر
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">خانه</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">ورود</a></li>
                    <li><a href="{!! url('/register') !!}">ثبت‌نام</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @endif
</body>
</html>
