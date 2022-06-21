@extends('layouts.main')

@section('head')
    <style>

        #one {
            margin-top: 50px;
            box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.2);
        }

        .it .btn-orange {
            background-color: transparent;
            border-color: #777 !important;
            color: #777;
            text-align: left;
            width: 100%;
        }

        .it input.form-control {
            height: 54px;
            border: none;
            margin-bottom: 0px;
            border-radius: 0px;
            border-bottom: 1px solid #ddd;
            box-shadow: none;
        }

        .it .form-control:focus {
            border-color: #ff4d0d;
            box-shadow: none;
            outline: none;
        }

        .fileUpload {
            position: relative;
            overflow: hidden;
            margin: 10px;
        }

        .fileUpload input.upload {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .it .btn-new,
        .it .btn-next {
            margin: 30px 0px;
            border-radius: 0px;
            background-color: #333;
            color: #f5f5f5;
            font-size: 16px;
            width: 155px;
        }

        .it .btn-next {
            background-color: #ff4d0d;
            color: #fff;
        }

        .it .btn-check {
            cursor: pointer;
            line-height: 54px;
            color: red;
        }

        .it .uploadDoc {
            margin-bottom: 20px;
        }

        .it .uploadDoc {
            margin-bottom: 20px;
        }

        .it .btn-orange img {
            width: 30px;
        }

        p {
            font-size: 16px;
            text-align: center;
            margin: 30px 0px;
        }

        .it #uploader .docErr {
            position: absolute;
            right: auto;
            left: 10px;
            top: -56px;
            padding: 10px;
            font-size: 15px;
            background-color: #fff;
            color: red;
            box-shadow: 0px 0px 7px 2px rgba(0, 0, 0, 0.2);
            display: none;
        }

        .it #uploader .docErr:after {
            content: "\f0d7";
            display: inline-block;
            font-family: FontAwesome;
            font-size: 50px;
            color: #fff;
            position: absolute;
            left: 30px;
            bottom: -40px;
            text-shadow: 0px 3px 6px rgba(0, 0, 0, 0.2);
        }

    </style>
@endsection
@section('content')
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
                                    <li class="breadcrumb-item active">فایل ها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    <!-- end::page header -->

            <div class="content-body"><!-- Basic Inputs start -->

                <section id="basic-input">
                    <div class="card">
                        <div class="card-body">
                            <span>فایل های آپلود شده</span>

                            <ul>
                                <br>
                                @foreach($files as $file)
                                    <li>
                                        <a href="{{ route('poster.download', $file->id) }}"
                                           class="btn btn-outline-warning">
                                            <i class="livicon-evo"
                                               data-options="name: download.svg; size:30px; style: original;"></i>
                                            {{$file->name}} </a>
                                        <x-destroy :id="$file->id" url="'/panel/poster/posterFileDestroy'"/>
                                    </li>
                                    <br>
                                @endforeach
                            </ul>


                            <section id="basic-input">
                                <form action="/panel/poster/file-upload" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{$id}}" name="poster_id">
                                    <div class="row it">
                                        <div class=" col-md-12" id="one">
                                            <p>
                                                لطفا فایل را با فرمت های 'pdf', 'docx', 'rtf', 'jpg', 'jpeg', 'png' &
                                                'text'
                                                آپلود کنید.
                                            </p><br>
                                            <div class="row">
                                                <div class="col-sm-offset-4 col-sm-4 form-group">
                                                    <h3 class="text-center">
                                                        آپلود فایل
                                                    </h3>
                                                </div>
                                                <!--form-group-->
                                            </div>
                                            <!--row-->
                                            <div id="uploader">
                                                <div class="row uploadDoc">
                                                    <div class="col-sm-3">
                                                        <div class="docErr">لطفا فایل معتبر آپلود کنید.</div>
                                                        <!--error-->
                                                        <div class="fileUpload btn btn-orange">
                                                            <img src="/../../assets/images/icon/698394.png"
                                                                 class="icon">
                                                            <span class="upl" id="upload">آپلود فایل</span>
                                                            <input type="file" name="file[file][]" class="upload up"
                                                                   id="up"
                                                                   onchange="readURL(this);"/ required>
                                                        </div><!-- btn-orange -->
                                                    </div><!-- col-3 -->
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="file[note][]"
                                                               placeholder="نام فایل" required>
                                                    </div>
                                                    <!--col-8-->
                                                    <div class="col-sm-1"><a class="btn-check"><i
                                                                class="fa fa-times"></i></a></div>
                                                    <!-- col-1 -->
                                                </div>
                                                <!--row-->
                                            </div>
                                            <!--uploader-->
                                            <div class="text-center">
                                                <a class="btn btn-new" style="color: white"><i class="fa fa-plus"></i>اضافه
                                                    کردن
                                                    فایل</a>
                                                <button type="submit" class="btn btn-next" style="color: #5F2222 "><i
                                                        class="fa fa-paper-plane"></i> ارسال
                                                </button>
                                            </div>
                                        </div>
                                        <!--one-->
                                    </div><!-- row -->
                                </form>
                            </section>
                        </div>
                    </div>
                </section>
            </div><!-- container -->
        </div>
    </div>



@endsection
@section('script')
    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>
    @include('sweetalert::alert')

    <script>
        var fileTypes = ["pdf", "docx", "rtf", "jpg", "jpeg", "png", "txt"]; //acceptable file types
        function readURL(input) {
            if (input.files && input.files[0]) {
                var extension = input.files[0].name.split(".").pop().toLowerCase(), //file extension from input file
                    isSuccess = fileTypes.indexOf(extension) > -1; //is extension in acceptable types

                if (isSuccess) {
                    //yes
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        if (extension == "pdf") {
                            $(input)
                                .closest(".fileUpload")
                                .find(".icon")
                                .attr("src", "https://image.flaticon.com/icons/svg/179/179483.svg");
                        } else if (extension == "docx") {
                            $(input)
                                .closest(".fileUpload")
                                .find(".icon")
                                .attr("src", "https://image.flaticon.com/icons/svg/281/281760.svg");
                        } else if (extension == "rtf") {
                            $(input)
                                .closest(".fileUpload")
                                .find(".icon")
                                .attr("src", "https://image.flaticon.com/icons/svg/136/136539.svg");
                        } else if (extension == "png") {
                            $(input)
                                .closest(".fileUpload")
                                .find(".icon")
                                .attr("src", "https://image.flaticon.com/icons/svg/136/136523.svg");
                        } else if (extension == "jpg" || extension == "jpeg") {
                            $(input)
                                .closest(".fileUpload")
                                .find(".icon")
                                .attr("src", "https://image.flaticon.com/icons/svg/136/136524.svg");
                        } else if (extension == "txt") {
                            $(input)
                                .closest(".fileUpload")
                                .find(".icon")
                                .attr("src", "https://image.flaticon.com/icons/svg/136/136538.svg");
                        } else {
                            //console.log('here=>'+$(input).closest('.uploadDoc').length);
                            $(input).closest(".uploadDoc").find(".docErr").slideUp("slow");
                        }
                    };

                    reader.readAsDataURL(input.files[0]);
                } else {
                    //console.log('here=>'+$(input).closest('.uploadDoc').find(".docErr").length);
                    $(input).closest(".uploadDoc").find(".docErr").fadeIn();
                    setTimeout(function () {
                        $(".docErr").fadeOut("slow");
                    }, 9000);
                }
            }
        }

        $(document).ready(function () {
            $(document).on("change", ".up", function () {
                var id = $(this).attr(
                    "id"
                ); /* gets the filepath and filename from the input */
                var profilePicValue = $(this).val();
                var fileNameStart = profilePicValue.lastIndexOf(
                    "\\"
                ); /* finds the end of the filepath */
                profilePicValue = profilePicValue
                    .substr(fileNameStart + 1)
                    .substring(0, 20); /* isolates the filename */
                //var profilePicLabelText = $(".upl"); /* finds the label text */
                if (profilePicValue != "") {
                    //console.log($(this).closest('.fileUpload').find('.upl').length);
                    $(this)
                        .closest(".fileUpload")
                        .find(".upl")
                        .html(profilePicValue); /* changes the label text */
                }
            });

            $(".btn-new").on("click", function () {
                $("#uploader").append(
                    '<div class="row uploadDoc"><div class="col-sm-3"><div class="docErr">لطفا فایل معتبر آپلود کنید.</div><!--error--><div class="fileUpload btn btn-orange"> <img src="/../../assets/images/icon/698394.png" class="icon"><span class="upl" id="upload">آپلود فایل</span><input type="file" class="upload up" name="file[file][]" id="up" onchange="readURL(this);" / required></div></div><div class="col-sm-8"><input type="text" class="form-control" name="file[note][]" placeholder="نام فایل" required></div><div class="col-sm-1"><a class="btn-check"><i class="fa fa-times"></i></a></div></div>'
                );
            });

            $(document).on("click", "a.btn-check", function () {
                if ($(".uploadDoc").length > 1) {
                    $(this).closest(".uploadDoc").remove();
                } else {
                    alert("باید حداقل یک فایل آپلود کنید.");
                }
            });
        });

    </script>
@endsection

