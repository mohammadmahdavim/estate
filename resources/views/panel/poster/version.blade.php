@extends('layouts.main')

@section('head')
    <style>
        hr.new2 {
            border-top: 1px dashed red;
        }

        hr.new5 {
            border: 1px solid red;
        }

    </style>
    <link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/pickers/pickadate/pickadate.css">
    <link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/pickers/daterange/daterangepicker.css">
    <link rel="stylesheet" type="text/css"
          href="/../../assets/vendors/css/pickers/datepicker-jalali/bootstrap-datepicker.min.css">
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">درخواست جدید</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/editions">درخواست ها</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/leader/{{$edition}}">مسول درس</a>
                                    </li>
                                    <li class="breadcrumb-item active">بازبینی ها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body"><!-- Basic Inputs start -->

                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">ثبت بازبینی </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">

                                        @foreach($versions as $key=>$team)
                                            <button class="btn btn-success btn-sm">{{$key+1}}</button>

                                            <div class="modal-dark mr-1 mb-1 d-inline-block">

                                                <x-destroy :id="$team->id" url="'/panel/editions/version/destroy'"/>

                                            </div>
                                            <div>
                                                <div class="row">

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="codesanad">
                                                            تاریخ ورود
                                                            </label>
                                                            <input disabled class="form-control"
                                                                   @if($team->entry_date)
                                                                   value="{{\Morilog\Jalali\Jalalian::forge($team->entry_date)->format('Y/m/d')}}"
                                                                @endif>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="codesanad">
                                                            تاریخ تحویل
                                                            </label>
                                                            <input disabled class="form-control"
                                                                   @if($team->delivery_date)
                                                                   value="{{\Morilog\Jalali\Jalalian::forge($team->delivery_date)->format('Y/m/d')}}"
                                                                @endif>

                                                        </div>
                                                    </div>


                                                </div>
                                                <hr class="new2">
                                            </div>


                                        @endforeach
                                        <hr class="new5">
                                        <form action="/panel/editions/version/update" method="post">
                                            <input hidden name="leader_id" value="{{$id}}">
                                            @csrf
                                            <div class="card-body" id="skill">


                                                <div id="skill0">
                                                    <div class="row">
                                                        <div class="col-md-4"><label>تاریخ ورود</label>
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input autocomplete="off" type="text" name="data[entry_date][]" class="form-control shamsi-datepicker"

                                                                       placeholder="انتخاب تاریخ">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-calendar"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-md-4"><label>تاریخ تحویل</label>
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input autocomplete="off" type="text" name="data[delivery_date][]" class="form-control shamsi-datepicker"
                                                                       placeholder="انتخاب تاریخ">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-calendar"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>


                                                    </div>
                                                    <hr class="new2">
                                                </div>

                                                <div id="skill1">
                                                    <div class="row" id="pluspart5">
                                                        <div class="col-5"></div>
                                                        <div class="col-1">
                                                            <a onclick="addpart1('skill',5,1)">
                                                                <div
                                                                    class="col-md-4 col-sm-6 col-12 fonticon-container">
                                                                    <div class="fonticon-wrap">
                                                                        <i class="bx bxs-user-plus"></i>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-1">
                                                            <a onclick="removepart1('skill',5,1)">
                                                                <div
                                                                    class="col-md-4 col-sm-6 col-12 fonticon-container">
                                                                    <div class="fonticon-wrap">
                                                                        <i class="bx bxs-user-minus"></i>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-12">
                                                <br>
                                                <button type="submit"
                                                        class="btn btn-success mr-sm-1 mb-1 mb-sm-0">ثبت تغییرات
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @include('include.modal.show')

@endsection
@section('script')

    <script>
        removepart1 = function (div, num, id) {
            if (id != 1) {
                var idminus = id - 1;
                document.getElementById(div + id).style.display = "none";
                document.getElementById(div + id).remove();
                document.getElementById(div + idminus).innerHTML = "";
                document.getElementById(div + idminus).innerHTML = "<div class=\"row\" id=\"pluspart" + num + "\">\n" +
                    "                                                        <div class=\"col-5\"></div>\n" +
                    "                                                        <div class=\"col-1\">\n" +
                    "                                                            <a onclick=\"addpart1('" + div + "'," + num + "," + idminus + ")\">\n" +
                    "                                                                <div class=\"col-md-4 col-sm-6 col-12 fonticon-container\">\n" +
                    "                                                                    <div class=\"fonticon-wrap\">\n" +
                    "                                                                        <i class=\"bx bxs-user-plus\"></i>\n" +
                    "                                                                    </div>\n" +
                    "                                                                </div>\n" +
                    "                                                            </a>\n" +
                    "                                                        </div><div class=\"col-1\">\n" +
                    "                                                <a onclick=\"removepart1('" + div + "'," + num + "," + idminus + ")\">\n" +
                    "                                                    <div class=\"col-md-4 col-sm-6 col-12 fonticon-container\">\n" +
                    "                                                        <div class=\"fonticon-wrap\">\n" +
                    "                                                            <i class=\"bx bxs-user-minus\"></i>\n" +
                    "                                                        </div>\n" +
                    "                                                    </div>\n" +
                    "                                                </a>\n" +
                    "                                            </div>\n" +
                    "                                                        <div class=\"col-5\"></div>\n" +
                    "                                                    </div>";
            }
        };
        addpart1 = function (div, num, id) {

            var idplus = id + 1;
            document.getElementById("pluspart" + num).style.display = "none";
            document.getElementById("pluspart" + num).remove();
            document.getElementById(div + id).innerHTML += document.getElementById(div + "0").innerHTML + "<div class=\"row\" id=\"pluspart" + num + "\">\n" +
                "                                                        <div class=\"col-5\"></div>\n" +
                "                                                        <div class=\"col-1\">\n" +
                "                                                            <a onclick=\"addpart1('" + div + "'," + num + "," + idplus + ")\">\n" +
                "                                                                <div class=\"col-md-4 col-sm-6 col-12 fonticon-container\">\n" +
                "                                                                    <div class=\"fonticon-wrap\">\n" +
                "                                                                        <i class=\"bx bxs-user-plus\"></i>\n" +
                "                                                                    </div>\n" +
                "                                                                </div>\n" +
                "                                                            </a>\n" +
                "                                                        </div><div class=\"col-1\">\n" +
                "                                                <a onclick=\"removepart1('" + div + "'," + num + "," + idplus + ")\">\n" +
                "                                                    <div class=\"col-md-4 col-sm-6 col-12 fonticon-container\">\n" +
                "                                                        <div class=\"fonticon-wrap\">\n" +
                "                                                            <i class=\"bx bxs-user-minus\"></i>\n" +
                "                                                        </div>\n" +
                "                                                    </div>\n" +
                "                                                </a>\n" +
                "                                            </div>\n" +
                "                                                        <div class=\"col-5\"></div>\n" +
                "                                                    </div>";
            document.getElementById(div + id).insertAdjacentHTML('afterend', '<div id=\"' + div + idplus + '\"></div>');
            reload_date();
        };

        reload_date = function () {
            removeclass = document.getElementsByClassName("datepicker");
            for (y = 0; y < removeclass.length; y++) {
                removeclass[y].id = "dateogd" + y;
                removeclass[y].classList.remove("hasDatepicker");
            }
            $(".datepicker").datepicker({dateFormat: "yy-mm-dd"});
        }
    </script><?php /**PATH E:\zartosht\school\laravel\resources\views/components/panel/remove-add.blade.php ENDPATH**/ ?>
    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="/../../assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="/../../assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="/../../assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="/../../assets/vendors/js/pickers/pickadate/legacy.js"></script>
    <script src="/../../assets/vendors/js/pickers/daterange/moment.min.js"></script>
    <script src="/../../assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
    <script src="/../../assets/vendors/js/pickers/datepicker-jalali/bootstrap-datepicker.min.js"></script>
    <script
        src="/../../assets/vendors/js/pickers/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
    <!-- END: Theme JS-->
    <script src="/../../assets/js/scripts/pickers/dateTime/pick-a-datetime.js"></script>
@endsection
