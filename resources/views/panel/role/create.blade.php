@extends('layouts.main')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{url('/css/bootstrap-duallistbox.css')}}">
@stop

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">نقش ها</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/roles">نقش ها</a>
                                    </li>
                                    <li class="breadcrumb-item"><a>ایجاد</a>
                                    </li>
                                </ol>
                            </div>
                        </div>                    </div>
                </div>
            </div>


            <div class="row" id="basic-table">
                <div class="table-responsive">
                    <div class="card">
                    <div class="card-body">

                        <form class="form form-horizontal" id="saveForm" onsubmit="return false;">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>عنوان نقش</span>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" id="name" class="form-control" name="name"
                                                       placeholder="بطور مثال: مدیر کارمندان">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span>مجوز ها</span>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="select2 form-control" multiple="multiple" size="{{$permissions->count()}}"
                                                        name="permissions[]" title="مجوز ها">
                                                    @foreach($permissions as $permission)
                                                        <option
                                                            value="{{$permission->id}}">{{$permission->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 offset-md-4">
                                        <button onclick="saveForm();" class="btn btn-primary mr-1 mb-1">ثبت</button>
                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1">پاک کردن
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <!--/ Zero configuration table -->
@stop

@section('script')
    <script src="{{url('js/jquery.bootstrap-duallistbox.js')}}"></script>
    <script>
        var permissions = $('select[name="permissions[]"]').bootstrapDualListbox({
            nonSelectedListLabel: 'لیست مجوز ها',
            selectedListLabel: 'مجوزهای انتخاب شده',
            preserveSelectionOnMove: 'moved',
        });
    </script>
    <script>
        saveForm = function () {
            $('#loading').show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var data = $('#saveForm').serialize();
            $.ajax({
                url: '{{ url('/panel/roles') }}',
                type: 'POST',
                data: data,
                success: function (response) {
                    $('#loading').hide();
                    toastr.success(response.message);
                    document.getElementById('saveForm').reset();
                },
                error: function (xhr) {
                    $('#loading').hide();
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
