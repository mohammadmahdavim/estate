@extends('layouts.home')
@section('css')
    <style>
        @import url(plugins/select2.css);

    </style>
@endsection
@section('main')

    <section class="gray pt-4">

        <div class="container">

            <div class="row m-0">
                <div class="short_wraping">
                    <div class="row align-items-center">

                        <div class="col-lg-3 col-md-6 col-sm-12  col-sm-6">
                            <ul class="shorting_grid">
                                <li class="list-inline-item"><a href="grid-layout-with-sidebar.html"
                                                                class="active"><span class="ti-layout-grid2"></span>شبکه
                                        ای</a></li>
                                <li class="list-inline-item"><a href="list-layout-with-sidebar.html"><span
                                            class="ti-view-list"></span>لیستی</a></li>
                                <li class="list-inline-item"><a href="#"><span class="ti-map-alt"></span>نقشه</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 order-lg-2 order-md-3 elco_bor col-sm-12">
                            <div class="shorting_pagination">
                                <div class="shorting_pagination_laft">
                                    <h5>نمایش 1-25 از 72 نتیجه</h5>
                                </div>
                                <div class="shorting_pagination_right">
                                    <ul>
                                        <li><a href="javascript:void(0);" class="active">1</a></li>
                                        <li><a href="javascript:void(0);">2</a></li>
                                        <li><a href="javascript:void(0);">3</a></li>
                                        <li><a href="javascript:void(0);">4</a></li>
                                        <li><a href="javascript:void(0);">5</a></li>
                                        <li><a href="javascript:void(0);">6</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-12 order-lg-3 order-md-2 col-sm-6">
                            <div class="shorting-right">
                                <label>مرتب سازی بر اساس:</label>
                                <div class="dropdown show">
                                    <a class="btn btn-filter dropdown-toggle" href="#" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <span class="selection">بیشترین امتیاز</span>
                                    </a>
                                    <div class="drp-select dropdown-menu">
                                        <a class="dropdown-item" href="JavaScript:Void(0);">بیشترین امتیاز</a>
                                        <a class="dropdown-item" href="JavaScript:Void(0);">بیشترین بازدید</a>
                                        <a class="dropdown-item" href="JavaScript:Void(0);">جدیدترین</a>
                                        <a class="dropdown-item" href="JavaScript:Void(0);">کمتریت امتیاز</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">

                <!-- property Sidebar -->
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <form method="get" action="/home/search">
                        <div class="page-sidebar p-0">
                            <a class="filter_links" data-toggle="collapse" href="#fltbox" role="button"
                               aria-expanded="false" aria-controls="fltbox">فیلتر پیشرفته<i
                                    class="fa fa-sliders-h mr-2"></i></a>
                            <div class="collapse" id="fltbox">
                                <!-- Find New Property -->
                                <div class="sidebar-widgets p-4">
                                    <div class="form-group">
                                        <div class="simple-input">
                                            <select id="location" name="sector_id[]" multiple class="">

                                                @foreach($sectors as $sector)
                                                    <option
                                                        @if(isset(request()->sector_id) && is_array(request()->sector_id) && in_array($sector->id, request()->sector_id)) selected
                                                        @endif value="{{$sector->id}}">{{$sector->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <select id="ptypes" name="type_id[]" multiple class="">
                                            <option value="">&nbsp;</option>
                                            @foreach($types as $type)
                                                <option
                                                    @if(isset(request()->type_id) && is_array(request()->type_id) && in_array($type->id, request()->type_id)) selected
                                                    @endif value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">

                                        <select id="formId" name="form_id" class="form-control"
                                                onchange="search()">
                                            <option value="">&nbsp;</option>
                                            @foreach($forms as $form)
                                                <option @if(request()->form_id==$form->id) selected
                                                        @endif value="{{$form->id}}">{{$form->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    @include('include.home.search2')
                                    <button class="btn btn-block btn-info">جستجو</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="row justify-content-center">
                    @foreach($posters as $poster)
                        @if($poster->detail!='[]')
                            <!-- Single Property -->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="property-listing property-2">

                                        <div class="listing-img-wrapper">
                                            <div class="_exlio_125">برای {{$poster->type->name}}</div>
                                            <div class="list-img-slide">
                                                <div class="click">
                                                    @foreach($poster->images as $image)
                                                        <div><a href="/single/{{$poster->id}}">
                                                                <img src="/images/{{$image->filename}}"
                                                                     class="img-fluid mx-auto" alt="{{$poster->name}}"/>
                                                            </a>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>

                                        <div class="listing-detail-wrapper">
                                            <div class="listing-short-detail-wrap">
                                                <div class="_card_list_flex mb-2">
                                                    <div class="_card_flex_01">
                                                        <span
                                                            class="_list_blickes _netork">{{$poster->sector->name}}</span>

                                                        <span
                                                            class="_list_blickes types">   {{$poster->form->name}}</span>
                                                    </div>

                                                </div>
                                                <div class="_card_list_flex">
                                                    <div class="_card_flex_01">
                                                        <h4 class="listing-name verified"><a
                                                                href="/single/{{$poster->id}}"
                                                                class="prt-link-detail">   {{$poster->title}}</a>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="price-features-wrapper">
                                            <div class="list-fx-features">

                                                @foreach($poster->detail as $key=> $detail)
                                                    @if($key<3)

                                                        <div class="listing-card-info-icon">
                                                            {{$detail->field->name}}
                                                            :
                                                            @if(is_array(json_decode($detail->value)))
                                                                @foreach( json_decode($detail->value) as $d)
                                                                    {{$d}}
                                                                @endforeach
                                                            @else
                                                                {{json_decode($detail->value)}}
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>

                                        <div class="listing-detail-footer">
                                            <div class="footer-first">
                                                <div class="foot-location"><img src="assets/img/pin.svg" width="18"
                                                                                alt=""/>{{$poster->sector->name}}
                                                </div>
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
                                                                    <a href="#" onclick="compare({{$poster->id}})" data-toggle="tooltip"
                                                                       data-placement="top" data-original-title="مقایسه"><i
                                                                            class="ti-control-shuffle"></i></a>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="prt_saveed_12lk">
                                                                <a href="#" onclick="compare({{$poster->id}})" data-toggle="tooltip"
                                                                   data-placement="top" data-original-title="مقایسه"><i
                                                                        class="ti-control-shuffle"></i></a>
                                                            </div>
                                                        @endif

                                                    </li>

                                                    <li>
                                                        <div class="prt_saveed_12lk">
                                                            <a data-toggle="tooltip" data-placement="top"
                                                               data-original-title="اشتراک"
                                                               href="#"><i class="ti-share"></i></a>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- End Single Property -->
                            @endif
                        @endforeach
                        {!! $posters->render() !!}
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection
@section('js')
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
                url: '/home/search_box2/' + form_id,
                type: 'get',

                success: function (data) {
                    $('#search_box').html(data);

                }
            })

        }

    </script>
    <!-- begin::sweet alert demo -->
    @include('sweetalert::alert')
    <!-- begin::sweet alert demo -->
    <script src="/home/assets/js/select2.min.js"></script>

@endsection
