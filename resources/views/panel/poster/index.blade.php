@extends('layouts.main')
@section('head')

<link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/pickers/pickadate/pickadate.css">
<link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/pickers/daterange/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/pickers/datepicker-jalali/bootstrap-datepicker.min.css">
<link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/w3.css">


@endsection

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1">آگهی ها</h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/users">آگهی ها</a>
                                    </li>

                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/panel/poster/create">
                <button class="btn btn-success">افزودن
                    <i class="livicon-evo" data-options="name: plus-alt.svg; size:27px; style: original;"></i>
                </button>

            </a>
            <button type='button' class="btn btn-primary" onclick="hideshow()" id='hideshow'>
                جستجوی پیشرفته
            </button>
            <div id='search' style="display: none">
                <form method="get" action="/panel/poster">
                    <div class="d-flex flex-row">
                        <div class="w3-row-padding">
                            <div class="w3-col.m2 w3-quarter p-2">
                                <br>
                                <button type="submit" class="btn btn-info">جستجوکن</button>
                            </div>

                        <div class="w3-col.m2 w3-quarter p-2">
                            <label>عنوان</label>

                            <input class="form-control" id="title" name="title"
                                   value="{{request()->title}}"
                                   placeholder="عنوان">
                        </div>
                        <div class="w3-col.m2 w3-quarter p-2">
                            <label>عنوان</label>
                            <input class="form-control" id="mobile" name="mobile"
                                   value="{{request()->mobile}}"
                                   placeholder="موبایل">
                        </div>
                        <div class="w3-col.m2 w3-quarter p-2">
                            <label>آگهی دهنده</label>
                            <select class="select2 form-control" name="author[]" multiple>
                                @foreach($users as $athor)
                                    <option @if(request()->author) @if( in_array($athor->id,request()->author)) selected @endif @endif value="{{$athor->id}}">{{$athor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w3-col.m2 w3-quarter p-2">
                            <label>دسته بندی</label>
                            <select class="select2 form-control" name="form_id[]" multiple>
                                @foreach($forms as $form)
                                    <option @if(request()->form_id) @if(in_array($form->id,request()->form_id)) selected @endif @endif value="{{$form->id}}">{{$form->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w3-col.m12 w3-quarter p-2">
                            <label>نوع</label>
                            <select class="select2 form-control" name="type_id[]" multiple>
                                @foreach($types as $type)
                                    <option  @if(request()->type_id) @if(in_array($type->id,request()->type_id)) selected   @endif  @endif value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w3-col.m2 w3-quarter p-2">
                            <label>تاریخ آگهی تا</label>
                                <input autocomplete="off" type="text"
                                       name="date_to"
                                       value="{{request()->date_to}}"

                                       class="form-control shamsi-datepicker-list"
                                       placeholder="انتخاب تاریخ" >
                        </div>
                            <div class="w3-col.m2 w3-quarter p-2">
                                <label>تاریخ آگهی از</label>
                                <input autocomplete="off" type="text"
                                       name="date_from"
                                       class="form-control shamsi-datepicker-list"
                                       value="{{request()->date_from}}"
                                       placeholder="انتخاب تاریخ" >

                            </div>
                    </div>
                    </div>


            </form>
        </div>

        <div class="row" id="basic-table">
            <div class="col-12">
                <br>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">لیست آگهی ها</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            <!-- Table with outer spacing -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr style="text-align: center">
                                        <th>عنوان</th>
                                        <th>آگهی دهنده</th>
                                        <th>شماره همراه</th>
                                        <th>دسته</th>
                                        <th>نوع آگهی</th>
                                        <th>تاریخ شروع</th>
                                        <th>تاریخ پایان</th>
                                        <th>وضعیت آگهی</th>

                                        <th>عملیات</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $row)
                                        <tr style="text-align: center">
                                            <td>{{$row->title}}</td>
                                            <td>{{$row->authorPost->name}}</td>
                                            <td>{{$row->mobile}}</td>
                                            <td>{{$row->form->name}}</td>
                                            <td>{{$row->type->name}}</td>
                                            <td>{{$row->date_from}}</td>
                                            <td>{{$row->date_to}}</td>
                                            <td>
                                                @if($row->salled==1)
                                                    <button class="btn btn-danger">فروخته شد</button>
                                                @elseif($row->active==1)
                                                    <button class="btn btn-success">فعال</button>
                                                @else
                                                    <button class="btn btn-dark">غیرفعال</button>
                                                @endif
                                            </td>
                                            <td>
                                                <a
                                                    title="جزییات"
                                                    onclick="modal_show('{{$row->id}}','/panel/poster/detail');">
                                                    <i class="livicon-evo"
                                                       data-options="name: info-alt.svg; size:27px; style: original;"></i>
                                                </a>
                                                <a href="/panel/poster_images/{{$row->id}}"
                                                   title="تصاویر">
                                                    <i class="livicon-evo"
                                                       data-options="name: image.svg; size:27px; style: original;"></i>
                                                </a>
                                                <a href="/panel/poster_files/{{$row->id}}"
                                                   title="پیوست ها">
                                                    <i class="livicon-evo"
                                                       data-options="name: paper-clip.svg; size:27px; style: original;"></i>
                                                </a>


                                                <a title="کامنت"
                                                   onclick="modal_show('{{$row->id}}','/panel/comments');">
                                                    <i class="livicon-evo"
                                                       data-options="name: comments.svg; size:27px; style: original;"></i>

                                                </a>
                                                <a title="مشاهده"
                                                   onclick="modal_show('{{$row->id}}','/panel/comments');">
                                                    <i class="livicon-evo"
                                                       data-options="name: morph-eye-open-close.svg; size:27px; style: original;"></i>
                                                </a>
                                                @if(!in_array($row->id,$user->favorite->pluck('id')->all()))
                                                    <a title="ذخیره" href="/panel/poster/favorite/{{$row->id}}">
                                                        <i class="livicon-evo"
                                                           data-options="name: star.svg; size:27px; style: original;"></i>

                                                    </a>
                                                @endif


                                                <a title="ویرایش"
                                                   href="/panel/poster/{{$row->id}}/edit">

                                                    <i class="livicon-evo"
                                                       data-options="name: pencil.svg; size:27px; style: original;"></i>

                                                </a>
                                                <x-destroy :id="$row->id" url="'/panel/poster/posterDestroy'"/>
                                                <a href="/panel/poster/verify/{{$row->id}}" title="فعال/غیرفعال">
                                                    <i class="livicon-evo"
                                                       data-options="name: unlock.svg; size:27px; style: original;"></i>
                                                </a>
                                                <a href="/panel/poster/sold/{{$row->id}}" title="فروخته شده">
                                                    <i class="livicon-evo"
                                                       data-options="name: coins.svg; size:27px; style: original;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('include.modal.show')
@endsection

@section('script')

    <script src="/../../assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
    <script src="/../../assets/vendors/js/pickers/datepicker-jalali/bootstrap-datepicker.min.js"></script>
    <script
        src="/../../assets/vendors/js/pickers/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
    <!-- END: Theme JS-->    <script src="/../../assets/js/scripts/pickers/dateTime/pick-a-datetime.js"></script>


    <script>
        function hideshow() {
            var x = document.getElementById("search");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

    </script>
    <script src="{{url('/assets/js/scripts/extensions/sweetalert2.all.min.js')}}"></script>
    @include('sweetalert::alert')



@endsection
