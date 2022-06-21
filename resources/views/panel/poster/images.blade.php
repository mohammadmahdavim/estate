@extends('layouts.main')

@section('head')

@endsection
@section('content')
    <link href="/assets/dropzone.min.css" rel="stylesheet">
    <script src="/assets/dropzone.min.js"></script>
    <script type="text/javascript">

        Dropzone.options.dropzone =
            {

                maxFilesize: 5,
                renameFile: function (file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time + file.name;
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                timeout: 5000,
                addRemoveLinks: false,


            };
    </script>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">آگهی جدید</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/poster">آگهی ها</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/poster">{{$poster->title}}</a>
                                    </li>
                                    <li class="breadcrumb-item active">تصاویر
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    <!-- end::page header -->

            <div class="content-body"><!-- Basic Inputs start -->

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">


                                    @foreach($images as $image)

                                        <img src="/images/{{$image->filename}}" width="190" height="190">
                                        <label>
                                            <x-destroy :id="$image->id" url="'/panel/poster/posterImageDestroy'"/>
                                        </label>

                                    @endforeach

                                    <br>
                                    <br>

                                    <form method="post" action="/panel/poster/image-upload"
                                          enctype="multipart/form-data"
                                          class="dropzone" id="dropzone">

                                        <label><b>انتخاب عکس</b><br>عکس های خود را اینجا بکشید</label>
                                        <input name="id" value="{{$id}}" hidden>
                                        @csrf
                                        <div class="header-topinfo text-right">
                                            <ul>
                                                {{--<li><i class="fa fa-clock-o"></i>{{$rows->day}}:{{$rows->time}}</li>--}}


                                            </ul>
                                        </div>
                                    </form>
                                    <a href="/panel/poster_images/{{$id}}">
                                        <button type="button" class="btn btn-primary btn-rounded btn-block">ثبت</button>

                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>



@endsection
@section('script')
    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>
    @include('sweetalert::alert')


@endsection

