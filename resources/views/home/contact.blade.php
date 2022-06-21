@extends('layouts.home')
@section('css')

@endsection
@section('main')
    <div class="page-title" style="background:#f4f4f4 url(/home/assets/img/slider-3.jpg);" data-overlay="5">
        <div class="ht-80"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="_page_tetio">
                        <div class="pledtio_wrap"><span>تماس با ما</span></div>
                        <h2 class="text-light mb-0">دریافت راهنما و پشتیبانی</h2>
                        <p>به دنبال کمک یا پشتیبانی هستید؟ ما 24 ساعته در دسترس هستیم.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ht-120"></div>
    </div>
    <!-- ============================ Page Title End ================================== -->

    <!-- ============================ Agency List Start ================================== -->
    <section class="pt-0">
        <div class="container">
            <div class="row align-items-center pretio_top">

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="contact-box">
                        <i class="fa fa-phone"></i>
                        <h4>شماره تماس</h4>

                        <span>0211234567</span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="contact-box">
                        <i class="fa fa-comment"></i>
                        <h4>آدرس ایمیل</h4>
                        <p>sales@rikadahelp.co.uk</p>

                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="contact-box">
                        <i class="fa fa-tablet"></i>
                        <h4>تماس تصویری</h4>
                        <span>0211234567</span>
                        <span class="live-chat">چت زنده</span>
                    </div>
                </div>

            </div>

            <!-- row Start -->
            <div class="row">
                <div class="col-lg-10 col-md-7">
                    <div class="property_block_wrap">

                        <div class="property_block_wrap_header">
                            <h4 class="property_block_title">فرم را پر کنید</h4>
                        </div>

                        <form action="/home/contact/store" method="post">
                            @csrf
                            <div class="block-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>نام</label>
                                            <input name="name" required type="text" class="form-control simple">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>شماره تماس</label>
                                            <input name="mobile" type="number" class="form-control simple">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>موضوع</label>
                                    <input name="title" required type="text" class="form-control simple">
                                </div>

                                <div class="form-group">
                                    <label>پیام</label>
                                    <textarea name="body" required class="form-control simple"></textarea>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success-gradiant btn-block" type="submit">ارسال درخواست
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>


            </div>
            <!-- /row -->
        </div>
    </section>


    @include('sweetalert::alert')
@endsection
@section('js')
    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>
@endsection
