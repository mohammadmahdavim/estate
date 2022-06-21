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
                            <h5 class="content-header-title float-left pr-1">دسته جدید</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/forms">دسته بندی ها</a>
                                    </li>
                                    <li class="breadcrumb-item active">دسته جدید
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
                                    <h5 class="panel-title"> ایجاد دسته جدید </h5>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form CLASS="horizontal-layout" onsubmit="formCreate();return false"
                                              id="form-create">
                                            <div class="panel panel-flat">
                                                <div class="panel-heading">
                                                    <div class="heading-elements">

                                                    </div>
                                                </div>

                                                <div class="panel-body">

                                                    <div class="row">

                                                        <label>نام دسته:</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="name">
                                                        </div>


                                                        <label></label>
                                                        <div class="col-md-3">
                                                            <a onclick="formCreate();"
                                                               class="btn btn-primary btn-block">
                                                                <span style="color:#000;">ارسال</span>
                                                                <i
                                                                    class=""></i></a>
                                                        </div>

                                                    </div>


                                                </div>
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

    <!-- /basic layout -->



@endsection
@section('script')



    <script type="text/javascript">
        formCreate = function () {
            $("#loading").show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var form = $('#form-create').serialize();
            $.ajax({
                url: '{{ url('/panel/forms') }}',
                type: 'POST',
                data: form,
                success: function (response) {
                    $("#loading").hide();
                    toastr.info(response.message, {
                        rtl: true,
                        positionClass: 'toast-bottom-right',
                        containerId: 'toast-bottom-right'
                    });
                },
                error: function (xhr) {
                    $("#loading").hide();
                    if (xhr.status === 422) {
                        jQuery.each(xhr.responseJSON.errors, function (key, value) {
                            toastr.error(value);
                        });
                    }
                    if (xhr.status !== 422) {
                        toastr.warning('خطایی در سامانه رخ داد!');
                    }
                }
            });
        }
    </script>
@stop



