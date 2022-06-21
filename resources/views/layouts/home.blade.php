
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="_token" content="{{ csrf_token() }}" />

    <meta charset="utf-8" />
    <meta name="author" content="Themezhub" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>رنت آپ - قالب مشاور املاک و مستغلات</title>

    <!-- Custom CSS -->
    <link href="/home/assets/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="/home/assets/css/plugins/datepicker.css">
    @yield('css')

</head>

<body class="yellow-skin">

<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader"></div>

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->
    <!-- Start Navigation -->
@include('include.home.header')
    @yield('main')
    <!-- End Navigation -->
    <div class="clearfix"></div>

@include('include.home.footer')



</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="/home/assets/js/jquery.min.js"></script>
<script src="/home/assets/js/popper.min.js"></script>
<script src="/home/assets/js/bootstrap.min.js"></script>
<script src="/home/assets/js/ion.rangeSlider.min.js"></script>
<script src="/home/assets/js/select2.min.js"></script>
<script src="/home/assets/js/jquery.magnific-popup.min.js"></script>
<script src="/home/assets/js/slick.js"></script>
<script src="/home/assets/js/slider-bg.js"></script>
<script src="/home/assets/js/lightbox.js"></script>
<script src="/home/assets/js/imagesloaded.js"></script>
<script src="/home/assets/js/daterangepicker.js"></script>
<script src="/home/assets/js/custom.js"></script>

<!-- Date Booking Script -->
<!-- <script src="/home/assets/js/moment.min.js"></script>
<script src="/home/assets/js/daterangepicker.js"></script> -->

<script src="/home/assets/js/datepicker.js"></script>
<script src="/home/assets/js/datepicker.fa.js"></script>

<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->


</body>

</html>
@yield('js')
