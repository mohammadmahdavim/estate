@extends('layouts.main')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">                                        ایجاد سوال برای دسته {{$form->name}}
                            </h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/forms">دسته بندی ها</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/forms_fields/{{$form->id}}">سوالات</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        ایجاد سوال برای دسته {{$form->name}}
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
                                    <h5 class="panel-title">                                         ایجاد سوال برای دسته {{$form->name}}
                                    </h5>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <!-- Basic layout-->
                                        <form class="form-horizontal" onsubmit="fieldCreate();return false"
                                              id="form-create">
                                            <input type="hidden" name="form_id" value="{{$form->id}}">
                                            <div class="panel panel-flat">
                                                <div class="panel-heading">
                                                    <div class="heading-elements">
                                                        <div class="heading-btn">
                                                            <a href="{{url('/panel/forms_fields/'.$form->id)}}"
                                                               class="btn btn-info">
                                                                بازگشت
                                                                <i class="livicon-evo"  data-options="name: caret-left.svg; size:30px; style: original: 0.05em;"></i>

                                                                </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="panel-body">

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <label>نام</label>
                                                                <input type="text" name="name" class="form-control">
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <label>توضیحات</label>
                                                                <input type="text" name="description" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <!-- Default checked -->
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-checkbox"
                                                                           name="active">
                                                                    <label>
                                                                        وضعیت نمایش این فیلد فعال
                                                                        است؟
                                                                    </label>
                                                                    <br>
                                                                    <input type="checkbox" class="custom-checkbox"
                                                                           name="required">
                                                                    <label
                                                                    >جواب دادن به این سوال
                                                                        الزامی است؟</label>
                                                                    <br>
                                                                    <input type="checkbox" class="custom-checkbox"
                                                                           name="filter">
                                                                    <label>

                                                                        در فیلتر سایت قرار بگیرد؟
                                                                        <span style="color: red">(توجه: فقط نوع عددی و انتخابی و چندانتخابی می تواند فیلتر شود.)</span>
                                                                    </label>
                                                                </div>


                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <label>نوع نمایش سوال</label>
                                                                        <select class="form-control" name="type">
                                                                            @foreach($types as $key => $option )
                                                                                <option
                                                                                    value="{{$key}}">{{$option}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!-- Default checked -->
                                                        </div>
                                                    </div>


                                                    <div class="text-right">
                                                        <a onclick="fieldCreate();" class="btn btn-primary project">ایجاد<i
                                                                class="icon-arrow-left13 position-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                        <!-- /basic layout -->

                                    </div>
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

    <script type="text/javascript">
        fieldCreate = function () {
            $("#loading").show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var form = $('#form-create').serialize();
            $.ajax({
                url: '{{ url('/panel/fields') }}',
                type: 'POST',
                data: form,
                success: function (response) {
                    $("#loading").hide();
                    toastr.success(response.message);
                    document.getElementById("form-create").reset();
                },
                error: function (xhr) {
                    $("#loading").hide();
                    if (xhr.status === 422) {
                        jQuery.each(xhr.responseJSON.errors, function (key, value) {
                            toastr.error(value);
                        });
                    }
                    if (xhr.status !== 422) {
                        toastr.warning(xhr.responseJSON.message);
                    }
                }
            });
        }
    </script>


@stop

