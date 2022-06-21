@extends('layouts.main')
@section('head')
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">سوالات</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/forms">دسته بندی ها</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        سوالات دسته {{$form->name}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="panel-title"> سوالات دسته {{$form->name}}
                                    </h5>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="panel panel-flat">
                                            <div class="panel-heading">
                                                <div class="heading-elements">
                                                    <div class="heading-btn">
                                                        <a href="{{url('/panel/fields/'.$form->id)}}"
                                                           class="btn btn-info">

                                                            <i class="livicon-evo"
                                                               data-options="name: plus-alt.svg; size:30px; style: original: 0.05em;"></i>
                                                            ایجاد کردن</a>

                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table datatable-header-basic">
                                                <thead>
                                                <tr>

                                                    <th> نام</th>
                                                    <th> توضیحات</th>

                                                    <th>الزامی</th>

                                                    <th>فعال</th>
                                                    <th width="25%">نوع</th>

                                                    <th width="35%"> عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody id="table-contents">
                                                @include('panel.form.load')
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Header and footer fixed -->

                    <!-- create form modal -->
                    <div id="modal_form_create" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h5 class="modal-title">Vertical form</h5>
                                </div>

                                <form action="#">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>First name</label>
                                                    <input type="text" placeholder="Eugene" class="form-control">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>Last name</label>
                                                    <input type="text" placeholder="Kopyov" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Address line 1</label>
                                                    <input type="text" placeholder="Ring street 12"
                                                           class="form-control">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>Address line 2</label>
                                                    <input type="text" placeholder="building D, flat #67"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal">بستن</button>
                                        <a onclick="" class="btn btn-primary">ارسال</a>
                                    </div>
                                </form>
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
                url: '{{ url('/panel/fieldAjaxStatus') }}/' + id,
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
    <script>
        function requiredswitcher(id) {
            var status = 0;
            if (document.getElementById('switcher-required-' + id).checked) {
                var status = 1;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ url('/panel/fieldAjaxRequiredStatus') }}/' + id,
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
    <script>
        typeFieldChange = function (field_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var type = document.getElementById("type-field-" + field_id).value;
            $.ajax({
                url: '{{ url('/panel/forms/fields/changeTypeAjax') }}/' + field_id,
                type: 'PUT',
                data: {type: type},
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
@endsection
