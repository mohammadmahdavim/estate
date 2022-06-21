@extends('layouts.home')
@section('css')

@endsection
@section('main')

    <div id="main-wrapper">
        <!-- ============================ Hero Banner  Start================================== -->
        <div class="image-cover hero_banner" style="background:url(/home/assets/img/banner-3.png) no-repeat;"
             data-overlay="0">
            <div class="container">

                <h1 class="big-header-capt mb-0">خانه جدید خود را پیدا کنید</h1>
                <p class="text-center mb-4">ملک جدید و برجسته واقع در شهر محلی خود را پیدا کنید.</p>
                <!-- Type -->
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-12 col-md-12">
                        <div class="full_search_box nexio_search lightanic_search hero_search-radius modern">
                            <div class="search_hero_wrapping">
                                <form method="get" action="/home/search">

                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label>محله</label>

                                                <div class="">
                                                    <select id="location" name="sector_id[]" multiple class="">

                                                        @foreach($sectors as $sector)
                                                            <option value="{{$sector->id}}">{{$sector->name}}</option>
                                                        @endforeach
                                                    </select>


                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>نوع آگهی</label>
                                                <div class="">
                                                    <select id="ptypes" name="type_id[]" multiple class="">
                                                        <option value="">&nbsp;</option>
                                                        @foreach($types as $type)
                                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>دسته بندی</label>
                                                <div class="input-with-icon">
                                                    <select id="formId" name="form_id" class="form-control"
                                                            onchange="search()">
                                                        <option value="">&nbsp;</option>
                                                        @foreach($forms as $form)
                                                            <option value="{{$form->id}}">{{$form->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-2 col-md-3 col-sm-12">
                                            <div class="form-group none">
                                                <a class="collapsed ad-search" data-toggle="collapse"
                                                   data-parent="#search"
                                                   data-target="#advance-search" href="javascript:void(0);"
                                                   aria-expanded="false" aria-controls="advance-search"><i
                                                        class="fa fa-sliders-h ml-2"></i>فیلتر پیشرفته</a>
                                            </div>
                                        </div>

                                        <div class="col-lg-1 col-md-2 col-sm-12 small-padd">
                                            <div class="form-group none">
                                                <button type="" class="btn search-btn"><i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Collapse Advance Search Form -->
                                    <div class="collapse" id="advance-search" aria-expanded="false" role="banner">
                                        @include('include.home.search')
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- ============================ Hero Banner End ================================== -->

        <!-- ============================ Property Type Start ================================== -->
        <section class="gray-simple min">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="sec-heading center">
                            <h2>دسته بندی ها</h2>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    @foreach($groupForm as $form)
                        <div class="col-lg col-md-4">
                            <!-- Single Category -->
                            <div class="property_cats_boxs">
                                <a href="/home/search?form_id={{$form[0]->form->id}}" class="category-box">
                                    <div class="property_category_short">
                                        <div class="category-icon clip-1">
                                            <i class="flaticon-beach-house-2"></i>
                                        </div>

                                        <div class="property_category_expand property_category_short-text">
                                            <h4>{{$form[0]->form->name}}</h4>
                                            <p>

                                                    {{count($form)}}

                                                ملک</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </section>
        <!-- ============================ Property Type End ================================== -->

        <!-- ============================ Recent Property Start ================================== -->
        <section class="min">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-8">
                        <div class="sec-heading center">
                            <h2>املاک اخیر ارسال شده</h2>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center" id="mydiv">

                    <!-- Single Property -->
                    @foreach($posters as $poster)
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="property-listing property-2">

                                <div class="listing-img-wrapper">
                                    <div class="list-img-slide">

                                        <div
                                            @if($poster->type->name=='فروش')
                                            class="_exlio_125"
                                            @else
                                            class="_exlio_126"
                                            @endif>
                                            برای {{$poster->type->name}}
                                        </div>
                                        <a href="/single/{{$poster->id}}">
                                            @if($poster->salled==1)
                                                <img src="/home/images/sold_house.jpg" class="img-fluid mx-auto"
                                                     alt="فروخته شده"/>
                                            @else
                                                <img src="/files/{{$poster->filename}}" class="img-fluid mx-auto"
                                                     alt="{{$poster->title}}"/>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                                <div class="listing-detail-wrapper">
                                    <div class="listing-short-detail-wrap">

                                        <div class="listing-short-detail">
                                            <h5 class="listing-name verified"><a href="/single/{{$poster->id}}"
                                                                                 class="prt-link-detail">

                                                    {{\Illuminate\Support\Str::limit($poster->title, 18)}}
                                                </a></h5>
                                            <div class="foot-location"><img src="/home/assets/img/pin.svg" width="18"
                                                                            alt=""/>

                                                {{\Illuminate\Support\Str::limit($poster->sector->name, 17)}}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="_card_list_flex mb-2">
                                        <div class="_card_flex_01">
                                        </div>
                                        <div class="_card_flex_last">
                                            {{$poster->form->name}}
                                        </div>
                                    </div>
                                </div>

                                <div class="listing-detail-footer">
                                    <div class="footer-first">
    <span>
                                            @if($poster->type_id==1)

            قیمت کل:
            {{number_format($poster->price)}}
            تومان
        @else
            پول پیش:
            {{number_format($poster->price)}}
            تومان
            <br>
            اجاره ماهانه:
            {{number_format($poster->price_month)}}
            تومان
        @endif
                                        </span>
                                    </div>
                                    <div class="footer-flex">
                                        <ul class="selio_style">
                                            <li>
                                                @if(auth()->user())
                                                    @if(!in_array($poster->id,auth()->user()->favorite->pluck('id')->all()))
                                                        <div class="prt_saveed_12lk">
                                                            <a onclick="favorite({{$poster->id}})">
                                                                <label class="toggler toggler-danger"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top"
                                                                       data-original-title="ذخیره"><input
                                                                        type="checkbox"><i
                                                                        class="ti-bookmark"></i></label>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="prt_saveed_12lk">
                                                        <a href="/login" class="alio_green" data-toggle="modal"
                                                           data-target="#login">
                                                            <label class="toggler toggler-danger"
                                                                   data-toggle="tooltip"
                                                                   data-placement="top"
                                                                   data-original-title="ورود"><input
                                                                    type="checkbox"><i class="ti-user"></i></label>
                                                        </a>
                                                    </div>
                                                @endif
                                            </li>
                                            <li>
                                                @if(\Illuminate\Support\Facades\Session::has('posters'))
                                                    @if(!in_array($poster->id,\Illuminate\Support\Facades\Session::all()['posters']))
                                                        <div class="prt_saveed_12lk">
                                                            <a href="#" onclick="compare({{$poster->id}})"
                                                               data-toggle="tooltip"
                                                               data-placement="top" data-original-title="مقایسه"><i
                                                                    class="ti-control-shuffle"></i></a>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="prt_saveed_12lk">
                                                        <a href="#" onclick="compare({{$poster->id}})"
                                                           data-toggle="tooltip"
                                                           data-placement="top" data-original-title="مقایسه"><i
                                                                class="ti-control-shuffle"></i></a>
                                                    </div>
                                                @endif

                                            </li>

                                            <li>
                                                <input type="hidden" name="url" id="url"
                                                       value="http://127.0.0.1:8000/single/{{$poster->id}}">
                                                <div class="prt_saveed_12lk">
                                                    <a data-toggle="tooltip" data-placement="top"
                                                       data-original-title="اشتراک"
                                                       onclick="copy()"><i class="ti-share"></i></a>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </section>


    </div>
    @include('sweetalert::alert')
@endsection
@section('js')

    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>
    <script>
        search = function () {
            var form_id = document.getElementById('formId').value;

            $.ajaxSetup({

                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#search_box').html('');

            $.ajax({
                url: '/home/search_box/' + form_id,
                type: 'get',

                success: function (data) {
                    $('#search_box').html(data);

                }
            })

        }

        function favorite(id) {
            $.ajax({
                url: '/panel/poster/favorite/' + id,
                type: 'get',

                success: function () {
                    swal.fire({
                        title: "عملیات موفق",
                        text: "آگهی به لیست علاقه مندی های شما افزوده شد.",
                        icon: "success",
                        timer: '3500'

                    });
                    $("#mydiv").load(location.href + " #mydiv");
                }
            })
        }

        function compare(id) {
            $.ajax({
                url: '/add_compare_list/' + id,
                type: 'get',

                success: function () {
                    swal.fire({
                        title: "عملیات موفق",
                        text: "آگهی به لیست مقایسه شما افزوده شد.",
                        icon: "success",
                        timer: '3500'

                    });
                    $("#mydiv").load(location.href + " #mydiv");
                },
                error: function () {
                    swal.fire({
                        title: "لیست مقایسه شما با یک دسته بندی متفاوتی می باشد. ابتدا آن هارا حذف کنید.",
                        // text: data.message,
                        type: 'error',
                        timer: '3500'
                    })

                }

            })
        }
    </script>

    @include('sweetalert::alert')

    <script src="/home/assets/js/select2.min.js"></script>

@endsection
