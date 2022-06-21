@extends('layouts.home')
@section('css')

@endsection
@section('main')
    <div class="page-title" style="background:#f4f4f4 url(/home/assets/img/slider-5.jpg);" data-overlay="5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <div class="breadcrumbs-wrap">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">مقایسه</li>
                        </ol>
                        <h2 class="breadcrumb-title">مقایسه - مقایسه ملک ها</h2>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Page Title End ================================== -->

    <!-- ============================ Compare Property Start ================================== -->
    <section>
        <div class="container">
            <div class="pricing packages_style_5">

                <div class="row" id="mydiv">
                    <div class="col-lg-3 text-center d-lg-block d-md-none d-sm-none d-none">
                        <div class="compare_property_blank">
                        </div>
                        <ul>
                            @if($firstPoster!=[])
                                @foreach($firstPoster->form->field as $field)

                                    <li>
                                        <span>{{$field->name}}</span>
                                    </li>
                                @endforeach
                            @endif

                        </ul>

                    </div>
                    @if($firstPoster!=[])
                    <div class="col-lg-3 col-md-3 col-sm-12 text-center">
                        <div class="comp_properties">
                            <a href="#">
                                <div class="clp-img">
                                    <img src="/files/{{$firstPoster->filename}}" height="150px" width="250px">
                                    <a onclick="destroy({{$firstPoster->id}})">
                                        <span class="remove-from-compare"><i class="ti-close"></i></span>
                                    </a>
                                </div>

                                <div class="clp-title">
                                    <h4>{{$firstPoster->title}}

                                        <span
                                            @if($firstPoster->type->name=='فروش')
                                            class="property-type elt_sale"
                                            @else
                                            class="property-type elt_rent"
                                                    @endif>
                                                 {{$firstPoster->type->name}}
                                                </span>
                                    </h4>


                                    <span>
                                            @if($firstPoster->type_id==1)

                                            قیمت کل:
                                            {{number_format($firstPoster->price)}}
                                            تومان
                                        @else
                                            پول پیش:
                                            {{number_format($firstPoster->price)}}
                                            تومان
                                            <br>
                                            اجاره ماهانه:
                                            {{number_format($firstPoster->price_month)}}
                                            تومان
                                        @endif
                                        </span>
                                </div>
                            </a>
                        </div>
                        <ul>
                            @foreach($firstPoster->detail as $detail)
                                <li>
                                    @if(is_array(json_decode($detail->value)))
                                        @foreach( json_decode($detail->value) as $d)
                                            {{$d}},
                                        @endforeach
                                    @else
                                        {{json_decode($detail->value)}}
                                    @endif

                                    <span class="show-mb"></span>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    @endif
                @foreach($posters as $poster)
                        <div class="col-lg-3 col-md-3 col-sm-12 text-center">
                            <div class="comp_properties">
                                <a href="#">
                                    <div class="clp-img">
                                        <img src="/files/{{$poster->filename}}" height="150px" width="250px">
                                        <a onclick="destroy({{$poster->id}})">
                                            <span class="remove-from-compare"><i class="ti-close"></i></span>
                                        </a>
                                    </div>

                                    <div class="clp-title">
                                        <h4>{{$poster->title}}

                                            <span
                                                @if($poster->type->name=='فروش')
                                                class="property-type elt_sale"
                                                @else
                                                class="property-type elt_rent"
                                                    @endif>
                                                 {{$poster->type->name}}
                                                </span>
                                        </h4>


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
                                </a>
                            </div>
                            <ul>
                                @foreach($poster->detail as $detail)
                                    <li>
                                        @if(is_array(json_decode($detail->value)))
                                            @foreach( json_decode($detail->value) as $d)
                                                {{$d}},
                                            @endforeach
                                        @else
                                            {{json_decode($detail->value)}}
                                        @endif

                                        <span class="show-mb"></span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

    @include('sweetalert::alert')
@endsection
@section('js')
    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>
    <script>
        function destroy(id) {
            $.ajax({
                url: '/destroy_compare_list/' + id,
                type: 'get',

                success: function () {
                    swal.fire({
                        title: "عملیات موفق",
                        text: "آگهی از لیست مقایسه شما حذف شد.",
                        icon: "success",
                        timer: '3500'

                    });
                    $("#mydiv").load(location.href + " #mydiv");
                }
            })
        }

    </script>
@endsection
