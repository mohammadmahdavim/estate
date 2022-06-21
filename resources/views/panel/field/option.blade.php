@extends('layouts.main')


@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1"> ایجاد گزینه برای سوال {{$field->name}}
                            </h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/forms">دسته بندی ها</a>
                                    </li>
                                    <li class="breadcrumb-item"><a
                                            href="/panel/forms_fields/{{$field->form_id}}">سوالات</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        ایجاد گزینه برای سوال {{$field->name}}
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
                                    <h5 class="panel-title"> ایجاد سوال برای دسته {{$field->name}}
                                    </h5>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal"
                                              onsubmit="optionCreate('{{$field->id}}');return false" id="form-create">
                                            <input type="hidden" name="field_id" value="{{$field->id}}">
                                            <div class="panel panel-flat">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title"> ایجاد پاسخ برای <span style="color: red">{{$field->name}} - {{$field->key}}</span>
                                                    </h5>
                                                    <div class="heading-elements">
                                                        <div class="heading-btn">
                                                            <a href="{{url('/panel/forms_fields/'.$field->form->id)}}"
                                                               class="btn btn-info">
                                                                بازگشت
                                                                <i class="livicon-evo"  data-options="name: caret-left



.svg; size:30px; style: original: 0.05em;"></i>

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
                                                                <label>کد</label>
                                                                <input type="text" name="code" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <!-- Default checked -->
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox"
                                                                           name="active">
                                                                    <label>وضعیت نمایش این فیلد فعال
                                                                        است؟</label>
                                                                </div>
                                                            </div>

                                                            <!-- Default checked -->
                                                        </div>
                                                    </div>


                                                    <div class="text-right">
                                                        <a onclick="optionCreate('{{$field->id}}');"
                                                           class="btn btn-primary project"><span style="color:#000;">ایجاد</span><i
                                                                class="icon-arrow-left13 position-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                        <!-- /basic layout -->

                                        <!-- Header and footer fixed -->
                                        <hr>
                                        <div class="panel panel-flat">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">گزینه ها</h5>
                                                <div class="heading-elements">
                                                    <div class="heading-btn">
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table datatable-header-basic">
                                                <thead>
                                                <tr>
                                                    <th>پاسخ</th>
                                                    <th> کلید</th>
                                                    <th>فعال</th>
                                                    <th width="25%"> عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody id="table-contents">
                                                @include('panel.field.load')
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /Header and footer fixed -->
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
    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>

    <script type="text/javascript">
        optionCreate = function (id) {
            $("#loading").show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var form = $('#form-create').serialize();
            $.ajax({
                url: '{{ url('/panel/fieldOptions') }}',
                type: 'POST',
                data: form,
                success: function (response) {
                    $("#loading").hide();
                    optionLoad(id);
                    document.getElementById("form-create").reset();
                    toastr.success(response.message);
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

        optionLoad = function (id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ url('/panel/fieldsOptionLoad') }}/' + id,
                type: 'POST',
                success: function (response) {
                    $('#table-contents').empty().html(response);
                },
                error: function (xhr) {
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
    <script>
        function statusswitcher(id) {
            var status = 0;
            if (document.getElementById('switcher-' + id).checked) {
                var status = 1;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ url('/panel/optionAjaxStatus') }}/' + id,
                data: {status: status},
                type: 'PUT',
                success: function (response) {
                    toastr.success(response.message);
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
                }
            });
        }
    </script>
@stop

