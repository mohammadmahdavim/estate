<!DOCTYPE html>
<html class="loading" lang="fa" data-textdirection="rtl" dir="rtl">
<!-- BEGIN: Head-->
<head>

    <meta name="_token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>مشاور املاک</title>
    <link rel="shortcut icon" type="image/x-icon" href="/../../assets/images/ico/favicon.ico">
    <meta name="theme-color" content="#5A8DEE">
@yield('head')

<!-- BEGIN: Vendor CSS-->

    <link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/forms/select/select2.min.css">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/../../assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/../../assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/../../assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="/../../assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/../../assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/../../assets/css/core/menu/menu-types/horizontal-menu.css">
    <!-- END: Page CSS-->
    <!-- END: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="/../../assets/css/plugins/extensions/toastr.css">

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="horizontal-layout horizontal-menu navbar-sticky 2-columns   footer-static menu-collapsed "
      data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
@include('layouts.loading')

<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed bg-primary navbar-brand-center">
    <div class="navbar-header d-xl-block d-none">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item"><a class="navbar-brand" href="/../../html/horizontal-menu-template/index.html">
                    <div class="brand-logo"><img class="logo" src="/../../assets/images/logo/logo-light.png"></div>
                    <h2 class="brand-text mb-0">مشاور املاک</h2></a></li>
        </ul>
    </div>
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu mr-auto"><a class="nav-link nav-menu-main menu-toggle" href="#"><i
                                    class="bx bx-menu"></i></a></li>
                    </ul>
                    {{--                    <ul class="nav navbar-nav bookmark-icons">--}}
                    {{--                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#"--}}
                    {{--                                                                  data-toggle="tooltip" data-placement="bottom"--}}
                    {{--                                                                  title="ایمیل"><i class="ficon bx bx-envelope"></i></a>--}}
                    {{--                        </li>--}}
                    {{--                    </ul>--}}
                </div>
                <ul class="nav navbar-nav float-right d-flex align-items-center">

                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown">
                            <div class="user-nav d-lg-flex d-none"><span class="user-name">مسعود صیدی</span><span
                                    class="user-status">آنلاین</span></div>
                            <span><img class="round" src="/../../assets/images/portrait/small/avatar-s-11.jpg"
                                       alt="avatar" height="40" width="40"></span></a>
                        <div class="dropdown-menu pb-0"><a class="dropdown-item" href="page-user-profile.html"><i
                                    class="bx bx-user mr-50"></i> ویرایش پروفایل</a>
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item" href="#"><i class="bx bx-power-off mr-50"></i>
                                خروج</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow"
     role="navigation" data-menu="menu-wrapper">
    <div class="navbar-header d-xl-none d-block">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="#">
                    <div class="brand-logo"><img class="logo" src="/../../assets/images/logo/logo.png"></div>
                    <h2 class="brand-text mb-0">املاک</h2></a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i></a></li>
        </ul>
    </div>

    <div class="shadow-bottom"></div>
    <!-- Horizontal menu content-->
    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <!-- include /../../includes/mixins-->
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="filled">
            <li class="nav-item"><a class="nav-link" href="/">
                    <i class="menu-livicon"
                       data-icon="home"></i><span
                        data-i18n="home">خانه</span></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="/panel/poster">
                    <i class="menu-livicon"
                       data-icon="list"></i><span
                        data-i18n="plus">آگهی ها</span></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="/panel/poster/create">
                    <i class="menu-livicon"
                       data-icon="plus"></i><span
                        data-i18n="plus">آگهی جدید</span></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="/panel/users/create">
                    <i class="menu-livicon"
                       data-icon="users"></i><span
                        data-i18n="users">ایجاد کاربر</span></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="/panel/estates">
                    <i class="menu-livicon"
                       data-icon="list"></i><span
                        data-i18n="users">املاک</span></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="/panel/roles">
                    <i class="menu-livicon"
                       data-icon="notebook"></i><span
                        data-i18n="notebook">نقش ها</span></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="/panel/users-favorites">
                    <i class="menu-livicon"
                       data-icon="star"></i><span
                        data-i18n="star">علاقه مندی ها</span></a>
            </li>

            {{--            <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"--}}
            {{--                                                                  data-toggle="dropdown"><i class="menu-livicon"--}}
            {{--                                                                                            data-icon="comments"></i><span>لیست متقاضیان</span></a>--}}
            {{--                <ul class="dropdown-menu dropdown-menu-right">--}}
            {{--                    <li data-menu=""><a class="dropdown-item align-items-center" href="app-email.html"--}}
            {{--                                        data-toggle="dropdown"><i class="bx bx-left-arrow-alt"></i>ایمیل</a>--}}
            {{--                    </li>--}}
            {{--                </ul>--}}
            {{--            </li>--}}
        </ul>
    </div>
    <!-- /horizontal menu content-->
</div>
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
@yield('content')
<!-- END: Content-->

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0"><span class="float-left d-inline-block">ساخته شده توسط گروه برنامه نویسی<a
                href="https://www.rtl-theme.com" target="_blank">واحد زرتشت</a></span><span
            class="float-right d-sm-inline-block d-none"></span>
    </p>
</footer>
<!-- END: Footer-->

<!-- BEGIN: Vendor JS-->
<script src="/../../assets/vendors/js/vendors.min.js"></script>
<script src="/../../assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js"></script>
<script src="/../../assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
<script src="/../../assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->

<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="/../../assets/js/scripts/configs/horizontal-menu.js"></script>
<script src="/../../assets/js/core/app-menu.js"></script>
<script src="/../../assets/js/core/app.js"></script>
<script src="/../../assets/js/scripts/components.js"></script>
<script src="/../../assets/js/scripts/footer.js"></script>

<script src="/../../assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="/../../assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="/../../assets/js/scripts/forms/select/form-select2.js"></script>

<!-- BEGIN: Page Vendor JS-->
<script src="/../../assets/vendors/js/extensions/toastr.min.js"></script>
<script src="/../../assets/js/scripts/extensions/toastr.js"></script>




<!-- END: Theme JS-->
@yield('script')
</body>
<!-- END: Body-->
</html>
