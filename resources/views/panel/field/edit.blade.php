@extends('layouts.main')
@section('css')
@endsection
@section('script')


    <script type="text/javascript">
        fieldUpdate = function (id) {
            $("#loading").show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var form = $('#form-update').serialize();
            $.ajax({
                url: '{{ url('/panel/fields') }}/' + id,
                type: 'PUT',
                data: form,
                success: function (response) {
                    $("#loading").hide();
                    toastr.success(response.message);
                    location.reload();
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
                                    <li class="breadcrumb-item"><a href="/panel/forms_fields/{{$field->form_id}}">سوالات</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        ویرایش سوال  {{$field->name}}
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
                                    <h5 class="panel-title"> ویرایش سوال  {{$field->name}}
                                    </h5>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal" onsubmit="fieldUpdate();return false"
                                              id="form-update">
                                            <div class="panel panel-flat">

                                                <div class="panel-body">

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <label>نام</label>
                                                                <input type="text" name="name" value="{{$field->name}}"
                                                                       class="form-control">
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <label>توضیحات</label>
                                                                <input type="text" name="description" value="{{$field->description}}"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <!-- Default checked -->
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class=""
                                                                           name="active"
                                                                           @if($field->active) checked @endif>
                                                                    <label >وضعیت نمایش این فیلد فعال
                                                                        است؟</label>
                                                                    <br>
                                                                    <input type="checkbox" class=""
                                                                           name="required"
                                                                           @if($field->required) checked @endif>
                                                                    <label >جواب دادن به این سوال
                                                                        الزامی است؟</label>
                                                                    <br>
                                                                    <input type="checkbox" class="custom-checkbox"
                                                                           name="filter" @if($field->filter) checked @endif>
                                                                    <label>

                                                                        در فیلتر سایت قرار بگیرد؟
                                                                        <span style="color: red">(توجه: فقط نوع عددی و انتخابی و چندانتخابی می تواند فیلتر شود.)</span>
                                                                    </label>
                                                                </div>


                                                                <!-- Default checked -->


                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="row">

                                                                    <div class="col-sm-6">
                                                                        <label>نوع نمایش سوال</label>
                                                                        <select class="form-control" name="type">
                                                                            @foreach($types as $key => $option )
                                                                                <option
                                                                                    @if($key == $field->type) selected
                                                                                    @endif value="{{$key}}">{{$option}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!-- Default checked -->
                                                        </div>
                                                    </div>


                                                    <div class="text-right">
                                                        <a onclick="fieldUpdate('{{$field->id}}');"
                                                           class="btn btn-primary project">بروزرسانی<i
                                                                class="icon-arrow-left13 position-right"></i></a>
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
