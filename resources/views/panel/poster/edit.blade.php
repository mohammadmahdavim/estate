@extends('layouts.main')
@section('head')
    <link rel="stylesheet" href="https://golaeen.com/themes/golaeen/css/custom.css?v=2.8.2">
    <link href="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.css" rel="stylesheet" type="text/css">
    <script src="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.js" type="text/javascript"></script>
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
                            <h5 class="content-header-title float-left pr-1">ویرایش آگهی
                                {{$poster->title}}

                            </h5>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/poster">آگهی ها</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/panel/poster">
                                            {{$poster->title}}
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش آگهی
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
                                    <h4 class="card-title"> ویرایش آگهی</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div id="map"
                                                     style="width: 400px; height: 400px; background: #eee; border: 2px solid #aaa;"></div>
                                            </div>
                                            <div class="col-md-8">
                                                <img src="/files/{{$poster->filename}}"
                                                     style="width: 900px;height: 450px">

                                            </div>

                                        </div>

                                        <form action="/panel/poster/{{$poster->id}}" method="post"
                                              class="form-horizonal" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            @include('errors')

                                            <br>
                                            <br>
                                            <br>
                                            <h4 style="text-align: center">اطلاعات </h4>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>
                                                        عنوان*
                                                    </label>
                                                    <input required name="title" class="form-control"
                                                           value="{{$poster->title}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        شماره موبایل*
                                                    </label>
                                                    <input name="mobile" class="form-control"
                                                           value="{{$poster->mobile}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        تاریخ انتشار آگهی*

                                                    </label>
                                                    <input name="date_from" class="form-control shamsi-datepicker-list"
                                                           value="{{$poster->date_from}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        تا تاریخ*

                                                    </label>
                                                    <input name="date_to" class="form-control shamsi-datepicker-list"
                                                           value="{{$poster->date_to}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        نوع ملک*

                                                    </label>
                                                    <select name="type_id" class="form-control">
                                                        @foreach($types as $type)
                                                            <option @if($type->id==$poster->type_id) selected
                                                                    @endif value="{{$type->id}}">{{$type->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        محله*
                                                    </label>
                                                    <select name="sector_id" class="form-control" required>
                                                        @foreach($sectors as $sector)
                                                            <option @if($sector->id==$poster->sector_id) selected
                                                                    @endif value="{{$sector->id}}">{{$sector->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>
                                                        قیمت فروش یا رهن (تومان)*
                                                    </label>
                                                    <div class="col-sm-12 data-field-col">
                                                        <div class="position-relative">
                                                            <div class="price-box-product">
                                                                <input type="number" autocomplete="off" required
                                                                       class="form-control"
                                                                       id="price" value="{{$poster->price}}"
                                                                       name="price">
                                                                <div class="price-box-product-content"
                                                                     style="display: none">
                                                                    <div
                                                                        class="price-box-header-product d-flex justify-content-between align-items-center">
                                                                        <span>وضعیت مبلغ شما</span>
                                                                        <button class="close"><i
                                                                                class="ion-android-close"></i></button>
                                                                    </div>
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="text-secondary ml-2">به عدد:</span>
                                                                        <span class="price-box-numbers ml-2">
                                                                        </span>
                                                                        <span class="text-dark">تومان</span>
                                                                    </div>

                                                                    <hr>
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="text-secondary ml-2">به
                                                                            حروف:</span>
                                                                        <span class="price-box-letters ml-2">
                                                                        </span>
                                                                        <span class="text-dark">تومان</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        اجاره ماهیانه(تومان)
                                                    </label>
                                                    <div class="col-sm-12 data-field-col">
                                                        <div class="position-relative">
                                                            <div class="price-box-product">
                                                                <input type="number" autocomplete="off" required
                                                                       class="form-control"
                                                                       id="price" value="{{$poster->price_month}}"
                                                                       name="price_month">
                                                                <div class="price-box-product-content"
                                                                     style="display: none">
                                                                    <div
                                                                        class="price-box-header-product d-flex justify-content-between align-items-center">
                                                                        <span>وضعیت مبلغ شما</span>
                                                                        <button class="close"><i
                                                                                class="ion-android-close"></i></button>
                                                                    </div>
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="text-secondary ml-2">به عدد:</span>
                                                                        <span class="price-box-numbers ml-2">
                                                                        </span>
                                                                        <span class="text-dark">تومان</span>
                                                                    </div>

                                                                    <hr>
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="text-secondary ml-2">به
                                                                            حروف:</span>
                                                                        <span class="price-box-letters ml-2">
                                                                        </span>
                                                                        <span class="text-dark">تومان</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label>
                                                        <span style="color: red"><b> جایگزین
                                                            تصویر شاخص
                                                            </b></span>

                                                    </label>
                                                    <input class="form-control" type="file" name="image">
                                                </div>
                                                <div class="col-md-2">
                                                    <br>
                                                    <input @if($poster->show_mobile==1) checked value="1"
                                                           @endif name="show_mobile" class="checkbox-custom"
                                                           type="checkbox">
                                                    <span>
                                                        موبایل نمایش داده شود؟
                                                    </span>
                                                </div>
                                                @php($i = 0)
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <textarea name="description" class="form-control"
                                                              placeholder="درصورت نیاز...">{{$poster->description}}</textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @php($i = 0)
                                                @foreach($poster->detail as $detail )

                                                    <div class="col-md-6">
                                                        <label>
                                                            <br>

                                                            {{$detail->field->name}}
                                                            @if($detail->field->required)
                                                                <span
                                                                    style="color: red">*</span>
                                                            @endif
                                                        </label>
                                                        @switch($detail->field->type)

                                                            @case('text')
                                                            <input type="text" name="field[{{$detail->field->id}}]"
                                                                   class="form-control"
                                                                   @if($detail->field->required)
                                                                   required
                                                                   @endif
                                                                   value="{{json_decode($detail->value)}}">
                                                            @break
                                                            @case('time')
                                                            <input type="text" name="field[{{$detail->field->id}}]"
                                                                   class="form-control pickatime"
                                                                   @if($detail->field->required)
                                                                   required
                                                                   @endif
                                                                   value="{{json_decode($detail->value)}}"
                                                            >
                                                            @break
                                                            @case('date')
                                                            <fieldset
                                                                class="form-group position-relative has-icon-left">
                                                                <input autocomplete="off" required type="text"
                                                                       @if($detail->field->required)
                                                                       required
                                                                       @endif
                                                                       name="field[{{$detail->field->id}}]"
                                                                       class="form-control shamsi-datepicker-list"
                                                                       placeholder="انتخاب تاریخ" readonly
                                                                       value="{{json_decode($detail->value)}}">
                                                                <div class="form-control-position">
                                                                    <i class="bx bx-calendar"></i>
                                                                </div>
                                                            </fieldset>

                                                            @break

                                                            @case('number')
                                                            <input type="number" name="field[{{$detail->field->id}}]"
                                                                   @if($detail->field->required)
                                                                   required
                                                                   @endif
                                                                   value="{{json_decode($detail->value)}}"
                                                                   class="form-control">
                                                            @break

                                                            @case('textarea')
                                                            <textarea class="ckeditor form-control"
                                                                      name="field[{{$detail->field->id}}]"
                                                                      rows="3">{!! json_decode($detail->value) !!}</textarea>
                                                            @break

                                                            @case('select')
                                                            <select class="select" name="field[{{$detail->field->id}}]">
                                                                <option value="">انتخاب کنید</option>
                                                                @foreach($options = $detail->field->option()->active()->get() as $option)
                                                                    <option value="{{$option->value}}"
                                                                            @if($option->value == json_decode($detail->value)) selected @endif>{{$option->value}}</option>
                                                                @endforeach
                                                            </select>
                                                            @break

                                                            @case('multi-select')
                                                            <?php
                                                            $selects = [];
                                                            foreach (json_decode($detail->value) as $d) {
                                                                $selects[] = $d;
                                                            }
                                                            ?>
                                                            <select class="select2"
                                                                    name="field[{{$detail->field->id}}][]"
                                                                    multiple="multiple">
                                                                @foreach($options = $detail->field->option()->active()->get() as $option)

                                                                    <option value="{{$option->value}}"
                                                                            @if( in_array($option->value,$selects)) selected @endif
                                                                    >
                                                                        {{$option->value}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @break

                                                        @endswitch
                                                    </div>


                                                @endforeach

                                            </div>

                                            <!-- END: Page Vendor JS-->
                                            <br>
                                            <button type="submit" class="btn btn-block btn-success">ذخیره</button>
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
@endsection
@section('script')
    <script>
        $(document).on('focus', '.price-box-product input', function () {
            var boxPrice = $(this).siblings('.price-box-product-content');
            boxPrice.fadeIn(100);
            boxPrice.find('.price-box-numbers').html($(this).val())
            boxPrice.find('.price-box-numbers').divide({
                delimiter: ',',
                divideThousand: false
            });
            var e = this;
            this.nextSibling.nextElementSibling.children[3].childNodes[1].nextElementSibling.innerHTML = e.value
                .toPersianLetter()
            e.oninput = myHandler;
            e.onpropertychange = e.oninput; // for IE8
            function myHandler() {
                this.nextSibling.nextElementSibling.children[3].childNodes[1].nextElementSibling.innerHTML = e.value
                    .toPersianLetter();
            }
        });

        $(document).on('click', '.price-box-product-content button.close', function () {
            $(this).parents('.price-box-product-content').fadeOut(100);
        })

        $(document).on('blur', '.price-box-product input', function () {
            $(this).siblings('.price-box-product-content').fadeOut(100);
        });

        $(document).on('keyup', '.price-box-product input', function () {
            var boxPrice = $(this).siblings('.price-box-product-content');
            boxPrice.find('.price-box-numbers').html($(this).val());
            boxPrice.find('.price-box-numbers').divide({
                delimiter: ',',
                divideThousand: false
            });
        });
    </script>
    <script>
        function stateForm(value) {

            var form = value;
            $.ajax({
                url: "{{url('panel/poster-load')}}",
                type: "POST",
                data: {
                    form: form,
                    _token: '{{csrf_token()}}'
                },
                success: function (data) {
                    window.location.reload(true);
                }
            });

        }
    </script>

    <script src="/../../assets/vendors/js/num2persian-min.js"></script>
    <script src="/../../assets/vendors/js/number-divider.min.js"></script>



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
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

    <script>
        var allEditors = document.querySelectorAll('.html');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor
                .create(allEditors[i], {
                    language: 'fa',
                    contentsLangDirection: 'rtl',
                    contentsLanguage: 'fa',
                    dialog_buttonsOrder: 'rtl',
                })
                .then(editor => {
                    console.log('Editor was initialized', editor);
                })
                .catch(error => {
                    console.error(error.stack);
                });
        }
    </script>
    <script type="text/javascript">
        var myMap = new L.Map('map', {
            key: 'web.ClftjhsJcbdhnDH99ZJuaZmnQCwPKWaaaQFtYKfZ',
            center: [35.71586339999998, 51.1012605],
            maptype: 'dreamy',
            poi: true,
            zoom: 16,
            onPoiLayerSwitched: function (state) {
                console.log(state);
            }
        });
    </script>
    @include('sweetalert::alert')

@endsection

