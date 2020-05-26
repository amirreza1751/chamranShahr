<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>چمران‌شهر</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- Latest compiled and minified CSS -->
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}
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


    <!-- Fonts -->
    <style>
        /*********************************************************/
        /*                Vazir English Digits                      */
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
        /*                  Vazir Farsi Digits                      */
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

        /*********************************************************/
        /*                  Iran English Digits                      */
        /*********************************************************/
        /*@font-face {*/
        /*    font-family: IRAN;*/
        /*    src: url('/fonts/IRAN.ttf');*/
        /*}*/
        /*@font-face {*/
        /*    font-family: IRANBlack;*/
        /*    src: url('/fonts/IRAN_Black.ttf');*/
        /*}*/
        /*@font-face {*/
        /*    font-family: IRANBold;*/
        /*    src: url('/fonts/IRAN_Bold.ttf');*/
        /*}*/
        /*@font-face {*/
        /*    font-family: IRANMarker;*/
        /*    src: url('/fonts/IRANMarker.ttf');*/
        /*}*/
        /*.iran-marker {*/
        /*    font-family: IRANMarker;*/
        /*}*/
        /*.iran-black {*/
        /*    font-family: IRANBlack;*/
        /*}*/
        /*.iran-bold {*/
        /*    font-family: IRANBold;*/
        /*}*/
        /*.iran {*/
        /*    font-family: IRAN;*/
        /*}*/

        .vazir-font-fd {
            font-family: VazirFD !important;
        }
    </style>

    <!-- Admin Lte Customisation, RTL Configuration -->
    <style>
        :root { /* general direction */
            direction: rtl;
        }
        /* Bootstrap 3.3.7 to Rtl */
        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            float: right !important;
        }
        body, .sidebar-toggle {
            line-height: 1.42857143 !important;
            font-size: 1.15rem;
        }
        body, h1, h2, h3, h4, h5, h6 {
            font-family: VazirFD;
        }
        h1, h2, h3, h4, h5, h6 {
            font-weight: bolder;
        }
        th {
            text-align: right !important;
        }
        .skin-blue .main-header .logo {
            background-color: #367fa9;
        }
        .td-action {
            width: fit-content;
            display: inline-flex;
            direction: ltr;
        }
        .content-header > h1 > a {
            margin-bottom: 1.7rem !important;
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

            border: none;
            border-radius: 0;
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
        .content-wrapper, .main-footer {
            margin-right: 25rem !important;
            margin-left: 0 !important;
        }
        @media (max-width: 768px) {
            .main-sidebar {
                transform: translate(25rem, 0) !important;
            }
            .sidebar-mini:not(sidebar-collapse) .content-wrapper {
                margin-right: 0 !important;
            }
            .content-wrapper, .main-footer {
                margin-right: 0 !important;
                margin-left: 0 !important;
            }
            .sidebar-open .content-wrapper, .sidebar-open .main-footer{
                transform: translate(-25rem, 0);
            }
            .sidebar-mini.sidebar-collapse .main-sidebar {
                transform: translate(-25rem, 0);
            }
            .sidebar-open .main-sidebar {
                transform: translate(0, 0) !important;
            }
        }

    </style>

    {{-- Add Cards to Bootstrap 3 Styles --}}
    <style>
        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #EDEFF2;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.75rem;
        }

        .card > hr {
            margin-right: 0;
            margin-left: 0;
        }

        .card > .list-group:first-child .list-group-item:first-child {
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        .card > .list-group:last-child .list-group-item:last-child {
            border-bottom-right-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }

        .card-title {
            margin-bottom: 0.75rem;
            font-family: IRANMarker;
        }

        .card-subtitle {
            margin-top: -0.375rem;
            margin-bottom: 0;
        }

        .card-text:last-child {
            margin-bottom: 0;
            font-family: IRAN;
        }

        .card-link:hover {
            text-decoration: none;
        }

        .card-link + .card-link {
            margin-left: 1.25rem;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
        }

        .card-header + .list-group .list-group-item:first-child {
            border-top: 0;
        }

        .card-footer {
            padding: 0.75rem 1.25rem;
            background-color: rgba(0, 0, 0, 0.03);
            border-top: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-footer:last-child {
            border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
        }

        .card-header-tabs {
            margin-right: -0.625rem;
            margin-bottom: -0.75rem;
            margin-left: -0.625rem;
            border-bottom: 0;
        }

        .card-header-pills {
            margin-right: -0.625rem;
            margin-left: -0.625rem;
        }

        .card-img-overlay {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 1.25rem;
        }

        .card-img {
            width: 100%;
            border-radius: calc(0.25rem - 1px);
        }

        .card-img-top {
            width: 100%;
            /*border-top-left-radius: calc(0.25rem - 1px);*/
            border-top-left-radius: 0.75rem;
            /*border-top-right-radius: calc(0.25rem - 1px);*/
            border-top-right-radius: 0.75rem;
        }

        .card-img-bottom {
            width: 100%;
            border-bottom-right-radius: calc(0.25rem - 1px);
            border-bottom-left-radius: calc(0.25rem - 1px);
        }

        .card-deck {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .card-deck .card {
            margin-bottom: 15px;
        }

        @media (min-width: 576px) {
            .card-deck {
                -ms-flex-flow: row wrap;
                flex-flow: row wrap;
                margin-right: -15px;
                margin-left: -15px;
            }

            .card-deck .card {
                display: -ms-flexbox;
                display: flex;
                -ms-flex: 1 0 0%;
                flex: 1 0 0%;
                -ms-flex-direction: column;
                flex-direction: column;
                margin-right: 15px;
                margin-bottom: 0;
                margin-left: 15px;
            }
        }

        .card-group {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .card-group > .card {
            margin-bottom: 15px;
        }

        @media (min-width: 576px) {
            .card-group {
                -ms-flex-flow: row wrap;
                flex-flow: row wrap;
            }

            .card-group > .card {
                -ms-flex: 1 0 0%;
                flex: 1 0 0%;
                margin-bottom: 0;
            }

            .card-group > .card + .card {
                margin-left: 0;
                border-left: 0;
            }

            .card-group > .card:not(:last-child) {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }

            .card-group > .card:not(:last-child) .card-img-top,
            .card-group > .card:not(:last-child) .card-header {
                border-top-right-radius: 0;
            }

            .card-group > .card:not(:last-child) .card-img-bottom,
            .card-group > .card:not(:last-child) .card-footer {
                border-bottom-right-radius: 0;
            }

            .card-group > .card:not(:first-child) {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }

            .card-group > .card:not(:first-child) .card-img-top,
            .card-group > .card:not(:first-child) .card-header {
                border-top-left-radius: 0;
            }

            .card-group > .card:not(:first-child) .card-img-bottom,
            .card-group > .card:not(:first-child) .card-footer {
                border-bottom-left-radius: 0;
            }
        }

        .card-columns .card {
            margin-bottom: 0.75rem;
        }

        @media (min-width: 576px) {
            .card-columns {
                -webkit-column-count: 3;
                -moz-column-count: 3;
                column-count: 3;
                -webkit-column-gap: 1.25rem;
                -moz-column-gap: 1.25rem;
                column-gap: 1.25rem;
                orphans: 1;
                widows: 1;
            }

            .card-columns .card {
                display: inline-block;
                width: 100%;
            }
        }

        .accordion > .card {
            overflow: hidden;
        }

        .accordion > .card:not(:first-of-type) .card-header:first-child {
            border-radius: 0;
        }

        .accordion > .card:not(:first-of-type):not(:last-of-type) {
            border-bottom: 0;
            border-radius: 0;
        }

        .accordion > .card:first-of-type {
            border-bottom: 0;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .accordion > .card:last-of-type {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .accordion > .card .card-header {
            margin-bottom: -1px;
        }
    </style>
    {{--    add custom file to bootstrap 3.3.7  --}}
    <style>.input-group > .custom-file {
            position: relative;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            width: 1%;
            margin-bottom: 0;
        }

        .input-group > .form-control + .form-control,
        .input-group > .form-control + .custom-select,
        .input-group > .form-control + .custom-file,
        .input-group > .form-control-plaintext + .form-control,
        .input-group > .form-control-plaintext + .custom-select,
        .input-group > .form-control-plaintext + .custom-file,
        .input-group > .custom-select + .form-control,
        .input-group > .custom-select + .custom-select,
        .input-group > .custom-select + .custom-file,
        .input-group > .custom-file + .form-control,
        .input-group > .custom-file + .custom-select,
        .input-group > .custom-file + .custom-file {
            margin-left: -1px;
        }
        .input-group > .form-control:focus,
        .input-group > .custom-select:focus,
        .input-group > .custom-file .custom-file-input:focus ~ .custom-file-label {
            z-index: 3;
        }

        .input-group > .custom-file .custom-file-input:focus {
            z-index: 4;
        }

        .input-group > .custom-file {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
        }

        .input-group > .custom-file:not(:last-child) .custom-file-label,
        .input-group > .custom-file:not(:last-child) .custom-file-label::after {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group > .custom-file:not(:first-child) .custom-file-label {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }


        .custom-file {
            position: relative;
            display: inline-block;
            width: 100%;
            height: calc(1.5em + 0.75rem + 2px);
            margin-bottom: 0;
        }

        .custom-file-input {
            position: relative;
            z-index: 2;
            width: 100%;
            height: calc(1.5em + 0.75rem + 2px);
            margin: 0;
            opacity: 0;
        }

        .custom-file-input:focus ~ .custom-file-label {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .custom-file-input:disabled ~ .custom-file-label {
            background-color: #e9ecef;
        }

        .custom-file-input:lang(fa) ~ .custom-file-label::after {
            content: "انتخاب کنید" !important;
        }

        .custom-file-input ~ .custom-file-label[data-browse]::after {
            content: attr(data-browse);
        }

        .custom-file-label {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .custom-file-label::after {
            position: absolute;
            top: 0;
            /*right: 0;*/
            bottom: 0;
            z-index: 3;
            display: block;
            height: calc(1.5em + 0.75rem);
            padding: 0.375rem 0.75rem;
            line-height: 1.5;
            color: #495057;
            content: "انتخاب کنید";
            background-color: #e9ecef;
            /*border-left: inherit;*/
            border-radius: 0 0.25rem 0.25rem 0;
            left: 0;
            right: auto;
            border-left-width: 0;
            border-right: inherit;
        }
        .custom-control-label::before,
        .custom-file-label,
        .custom-select {
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        @media (prefers-reduced-motion: reduce) {
            .custom-control-label::before,
            .custom-file-label,
            .custom-select {
                transition: none;
            }
        }

        .was-validated .custom-file-input:valid ~ .custom-file-label, .custom-file-input.is-valid ~ .custom-file-label {
            border-color: #28a745;
        }

        .was-validated .custom-file-input:valid ~ .valid-feedback,
        .was-validated .custom-file-input:valid ~ .valid-tooltip, .custom-file-input.is-valid ~ .valid-feedback,
        .custom-file-input.is-valid ~ .valid-tooltip {
            display: block;
        }

        .was-validated .custom-file-input:valid:focus ~ .custom-file-label, .custom-file-input.is-valid:focus ~ .custom-file-label {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        .was-validated .custom-file-input:invalid ~ .custom-file-label, .custom-file-input.is-invalid ~ .custom-file-label {
            border-color: #dc3545;
        }

        .was-validated .custom-file-input:invalid ~ .invalid-feedback,
        .was-validated .custom-file-input:invalid ~ .invalid-tooltip, .custom-file-input.is-invalid ~ .invalid-feedback,
        .custom-file-input.is-invalid ~ .invalid-tooltip {
            display: block;
        }

        .was-validated .custom-file-input:invalid:focus ~ .custom-file-label, .custom-file-input.is-invalid:focus ~ .custom-file-label {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
    </style>

    <!-- Custom Css -->
    <style>
        .text-ltr {
            direction: ltr;
        }
        .box {
            padding-top: 1rem;
        }
        .font-size-lg{
            font-size: 125%;
        }
        .label-box {
            padding: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            margin: 1.2rem 0;
        }
        .label-box-title {
            min-width: 15rem;
            max-width: 15rem;
            color: lightgray;
        }
        .label-box > .input{
            border: none;
            /*width: 100%;*/
        }
        .label-box > label{
            margin-bottom: 0;
            padding: 1px;
        }
        .label-box > .input {
            width: 100%;
        }
        .label-box > .input:hover{
            border: 0.05rem lightblue solid;
        }

        .royallabel {
            color: royalblue;
            margin-left: 5rem;
        }
        .label-row {
            display: inline-flex;
            width: 100%;
        }
        .label-row .label-box:first-child {
            margin-left: .5rem;
        }
        .label-row .label-box:last-child {
            width: calc(100% - .5rem);
        }
        .label-row > a {
            margin: 1.2rem .5rem;
            line-height: 2.428571;
        }
        .label-box > a {
            line-height: 0.428571;
        }
        .label-box {
            display: inline-flex;
        }

        /*   mobile view   */
        @media (max-width: 576px) {
            .label-row {
                display: grid;
            }
            .label-row .label-box:first-child {
                padding: 0 1rem;
                margin: 0;
                background: grey;
                border: none;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }
            .label-row .label-box:first-child > .label-box-title {
                color: white;
            }
            .label-row .label-box:last-child {
                width: 100%;
                margin-top: 0;
                border-top-right-radius: 0;
                border-top-left-radius: 0;
            }
            .label-box > a {
                width: 100%;
                padding: 0;
                margin-top: .5rem;
            }
            .label-box {
                width: 100%;
                display: grid;
            }
            .label-box > span {
                display: table-row;
            }
            .label-row > a {
                margin: 0;
                line-height: 1.428571;
            }
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
