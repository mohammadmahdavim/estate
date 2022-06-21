@extends('layouts.home')
@section('css')

@endsection
@section('main')
    <div class="featured_slick_gallery gray">
        <div class="featured_slick_gallery-slide">
            @foreach($poster->images as $image)
                <div class="featured_slick_padd"><a href="/images/{{$image->filename}}" class="mfp-gallery"><img
                            src="/images/{{$image->filename}}" class="img-fluid mx-auto" alt=""/></a></div>
            @endforeach
        </div>
    </div>
    <!-- ============================ New Search Form End ================================== -->

    <!-- ============================ Property Detail Start ================================== -->
    <section class="gray">
        <div class="container">
            <div class="row">

                <!-- property main detail -->
                <div class="col-lg-8 col-md-12 col-sm-12">

                    <div class="property_info_detail_wrap exlio_wrap mb-4">

                        <div class="property_info_detail_wrap_first">
                            <div class="pr-price-into">
                                <div class="_card_list_flex mb-2">
                                    <div class="_card_flex_01">
                                        <span class="_list_blickes _netork">{{$poster->type->name}}</span>
                                        <span class="_list_blickes types">{{$poster->form->name}}</span>
                                    </div>
                                </div>
                                <span><i class="lni-map-marker"></i> {{$poster->sector->name}}</span>
                                <h3>{{$poster->title}}</h3>
                                <h5>{{$poster->description}}</h5>

                            </div>
                        </div>

                        <div class="property_detail_section">
                            <div class="prt-sect-pric" id="mydiv">
                                <ul class="_share_lists light">

                                    @if(auth()->user())
                                        @if(!in_array($poster->id,auth()->user()->like->pluck('id')->all()))
                                            <li>
                                                <a data-toggle="tooltip" data-placement="top"
                                                   data-original-title="لایک"
                                                   onclick="like({{$poster->id}})"><i class="fa fa-heart"></i>&nbsp;20
                                                </a>
                                            </li>
                                        @endif
                                        @if(!in_array($poster->id,auth()->user()->favorite->pluck('id')->all()))
                                            <li><a data-toggle="tooltip" data-placement="top"
                                                   data-original-title="ذخیره"
                                                   onclick="favorite({{$poster->id}})"><i
                                                        class="fa fa-bookmark"></i></a></li>

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
                                    <li><a data-toggle="tooltip" data-placement="top" data-original-title="نظر"
                                           href="#"><i class="fa fa-comment"></i>&nbsp;{{$poster->comments_count}}</a>
                                    </li>

                                        @if(\Illuminate\Support\Facades\Session::has('posters'))
                                            @if(!in_array($poster->id,\Illuminate\Support\Facades\Session::all()['posters']))
                                            <li><a onclick="compare({{$poster->id}})" data-toggle="tooltip"
                                                   data-placement="top" data-original-title="مقایسه"
                                                   href="#"><i class="ti-control-shuffle"></i></a></li>
                                        @endif
                                    @else
                                        <li><a onclick="compare({{$poster->id}})" data-toggle="tooltip"
                                               data-placement="top" data-original-title="مقایسه"
                                               href="#"><i class="ti-control-shuffle"></i></a></li>
                                    @endif
                                    <li>
                                        <a data-toggle="tooltip" data-placement="top" data-original-title="اشتراک"
                                           href="#"><i class="fa fa-share"></i></a></li>

                                </ul>
                            </div>
                        </div>

                    </div>

                    <!-- Single Block Wrap -->
                    <div class="_prtis_list mb-4">

                        <div class="_prtis_list_body">
                            <ul class="deatil_features">
                                @foreach($poster->detail as $key=> $detail)

                                    <li>
                                        <div class="content">
                                            <strong> {{$detail->field->name}}</strong>

                                            @if(is_array(json_decode($detail->value)))
                                                @foreach( json_decode($detail->value) as $d)
                                                    {{$d}},
                                                @endforeach
                                            @else
                                                {{json_decode($detail->value)}}
                                            @endif


                                        </div>
                                    </li>

                                @endforeach

                            </ul>
                        </div>
                    </div>


                    <!-- Single Reviews Block -->
                    <div class="_prtis_list mb-4">
                        @if($poster->documents!='[]')
                            <div class="_prtis_list_header min">
                                <h4 class="m-0">فایل های ملک <span class="theme-cl"></span></h4>
                            </div>

                            <div class="_prtis_list_body">

                                <div class="row">
                                    @foreach($poster->documents as $file)
                                        <ol>
                                            <a href="{{ route('poster.download', $file->id) }}"
                                               class="btn btn-outline-warning btn-rounded">
                                                <i class="livicon-evo"
                                                   data-options="name: download.svg; size:30px; style: original;"></i>
                                                {{$file->name}} </a>
                                        </ol>
                                        <br>
                                    @endforeach
                                </div>

                            </div>
                        @endif
                        <div id="comment_section">
                            <div class="_prtis_list mb-4">

                                <div class="_prtis_list_header min">
                                    <h4 class="m-0">{{$poster->comments_count}} نظر <span
                                            class="theme-cl">ارسال شده</span></h4>
                                </div>

                                <div class="_prtis_list_body">

                                    <div class="author-review">
                                        <div class="comment-list">
                                            <ul>
                                                @foreach($poster->comments as $comment)
                                                    <li class="article_comments_wrap">
                                                        <article>
                                                            <div class="article_comments_thumb">
                                                                <img src="/home/assets/img/team-4.jpg" alt="">
                                                            </div>
                                                            <div class="comment-details">
                                                                <div class="comment-meta">
                                                                    <div class="comment-left-meta">
                                                                        <h4 class="author-name">
                                                                            {{$comment->user->name}}
                                                                        </h4>
                                                                        <div
                                                                            class="comment-date">{{Morilog\Jalali\Jalalian::forge($comment->created_at)->format('Y-m-d')}}

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="comment-text">
                                                                    <p>
                                                                        {{$comment->body}}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- Single Block Wrap -->


                            <!-- Single Write a Review -->
                            <div class="_prtis_list mb-4">

                                <div class="_prtis_list_header min">
                                    <h4 class="m-0">ارسال <span class="theme-cl">نظرات</span></h4>
                                </div>

                                <div class="_prtis_list_body">
                                    <div class="row">
                                        @if(auth()->user())
                                            <form id="form-comment" onsubmit="return false">


                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label>پیام</label>
                                                        <textarea cols="80" required name="body"
                                                                  class="form-control ht-80"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <button onclick="comment('{{$poster->id}}')"
                                                                class="btn theme-bg rounded" type="submit">ارسال نظر
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <a href="/login" class="alio_green" data-toggle="modal"
                                               data-target="#login">
                                                <label class="toggler toggler-danger"
                                                       data-toggle="tooltip"
                                                       data-placement="top"
                                                       data-original-title="ورود"><input
                                                        type="checkbox"><i class="ti-user"></i></label>
                                            </a>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>

                <!-- property Sidebar -->
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="property-sidebar side_stiky">

                        <div class="sidebar-widgets">

                            <h4>املاک مشابه</h4>

                            <div class="sidebar_featured_property">

                                <!-- List Sibar Property -->
                                <div class="sides_list_property">
                                    <div class="sides_list_property_thumb">
                                        <img src="/home/assets/img/p-1.png" class="img-fluid" alt=""/>
                                    </div>
                                    <div class="sides_list_property_detail">
                                        <h4><a href="single-property-1.html">آپارتمان در مرکز شهر</a></h4>
                                        <span><i class="ti-location-pin"></i>تهران</span>
                                        <div class="lists_property_price">
                                            <div class="lists_property_types">
                                                <div class="property_types_vlix sale">برای فروش</div>
                                            </div>
                                            <div class="lists_property_price_value">
                                                <h4>4,240 تومان</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- List Sibar Property -->
                                <div class="sides_list_property">
                                    <div class="sides_list_property_thumb">
                                        <img src="/home/assets/img/p-4.png" class="img-fluid" alt=""/>
                                    </div>
                                    <div class="sides_list_property_detail">
                                        <h4><a href="single-property-1.html">آپارتمان در مرکز شهر</a></h4>
                                        <span><i class="ti-location-pin"></i>تهران</span>
                                        <div class="lists_property_price">
                                            <div class="lists_property_types">
                                                <div class="property_types_vlix">برای اجاره</div>
                                            </div>
                                            <div class="lists_property_price_value">
                                                <h4>7,380 تومان</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- List Sibar Property -->
                                <div class="sides_list_property">
                                    <div class="sides_list_property_thumb">
                                        <img src="/home/assets/img/p-7.png" class="img-fluid" alt=""/>
                                    </div>
                                    <div class="sides_list_property_detail">
                                        <h4><a href="single-property-1.html">آپارتمان در مرکز شهر</a></h4>
                                        <span><i class="ti-location-pin"></i>تهران</span>
                                        <div class="lists_property_price">
                                            <div class="lists_property_types">
                                                <div class="property_types_vlix buy">برای فروش</div>
                                            </div>
                                            <div class="lists_property_price_value">
                                                <h4>8,730 تومان</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- List Sibar Property -->
                                <div class="sides_list_property">
                                    <div class="sides_list_property_thumb">
                                        <img src="/home/assets/img/p-5.png" class="img-fluid" alt=""/>
                                    </div>
                                    <div class="sides_list_property_detail">
                                        <h4><a href="single-property-1.html">آپارتمان در مرکز شهر</a></h4>
                                        <span><i class="ti-location-pin"></i>تهران</span>
                                        <div class="lists_property_price">
                                            <div class="lists_property_types">
                                                <div class="property_types_vlix">برای اجاره</div>
                                            </div>
                                            <div class="lists_property_price_value">
                                                <h4>6,240 تومان</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>
    @include('sweetalert::alert')
@endsection
@section('js')
    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>
    <script>
        function like(id) {
            $.ajax({
                url: '/like/' + id,
                type: 'get',

                success: function () {
                    swal.fire({
                        title: "عملیات موفق",
                        text: "آگهی توسط شما پسندیده شد.",
                        icon: "success",
                        timer: '3500'

                    });
                    $("#mydiv").load(location.href + " #mydiv");
                }
            })
        }


        comment = function (id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });


            var data = $('#form-comment').serialize();
            $.ajax({
                url: '{{ url('/comment') }}/' + id,
                type: 'POST',
                data: data,
                beforeSend: function () {
                    // Show image container
                    $("#loading").show();
                },
                success: function (response) {

                    swal.fire({
                        title: "عملیات موفق",
                        text: "نظر شما با موفقیت ثبت گردید",
                        type: "success",
                        timer: 10000000,
                        buttons: true,
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                $("#comment_section").load(location.href + " #comment_section");

                            }
                        });


                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        jQuery.each(xhr.responseJSON.errors, function (key, value) {
                            toastr.error(value);
                        });
                    }
                    if (xhr.status !== 422) {
                        toastr.warning(xhr.responseJSON.errors);
                    }
                },
                complete: function (data) {
                    // Hide image container
                    $("#loading").hide();
                }
            });
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
                }
            })
        }

    </script>

@endsection
