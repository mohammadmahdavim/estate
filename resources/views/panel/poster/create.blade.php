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
    <style>
        hr.new2 {
            border-top: 3px dashed red;
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
                                    <li class="breadcrumb-item active">آگهی جدید
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
                                    <h4 class="card-title">ایجاد آگهی جدید</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="/panel/poster/create" method="get">
                                            @csrf
                                            @include('errors')
                                            <div class="row">
                                                <div class="col-md-6"><select class="form-control"
                                                                              onchange="stateForm(this.value)"
                                                                              name="form_id"
                                                                              id="form_id">
                                                        @foreach($forms as $form)
                                                            <option @if($request->form_id==$form->id) selected
                                                                    @endif value="{{$form->id}}">{{$form->name}}</option>
                                                        @endforeach
                                                    </select></div>
                                                <div class="col-md-1">
                                                    <button type="submit" class="btn btn-block btn-info">اعمال
                                                    </button>
                                                </div>
                                            </div>


                                        </form>

                                        <form action="/panel/poster" method="post" class="form-horizonal"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input hidden value="{{$request->form_id}}" name="form_id">
                                            <br>
                                            <br>
                                            <br>
                                            <h4 style="text-align: center">اطلاعات اولیه</h4>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>
                                                        عنوان*
                                                    </label>
                                                    <input required name="title" class="form-control"
                                                           value="{{old('title')}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        شماره موبایل*
                                                    </label>
                                                    <input required name="mobile" type="number" class="form-control"
                                                           value="{{old('mobile')}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        تاریخ انتشار آگهی*

                                                    </label>
                                                    <input required name="date_from"
                                                           class="form-control shamsi-datepicker-list"
                                                           autocomplete="off" value="{{old('date_from')}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        تا تاریخ*

                                                    </label>
                                                    <input required name="date_to"
                                                           class="form-control shamsi-datepicker-list"
                                                           autocomplete="off" value="{{old('date_to')}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        نوع ملک*

                                                    </label>
                                                    <select name="type_id" class="form-control">
                                                        @foreach($types as $type)
                                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>
                                                        محله*
                                                    </label>
                                                    <select name="sector_id" class="form-control" required>
                                                        @foreach($sectors as $sector)
                                                            <option value="{{$sector->id}}">{{$sector->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>
                                                        قیمت  فروش یا رهن (تومان)*
                                                    </label>
                                                    <div class="col-sm-12 data-field-col">
                                                        <div class="position-relative">
                                                            <div class="price-box-product">
                                                                <input type="number" autocomplete="off" required
                                                                       class="form-control"
                                                                       id="price" value="{{old('price')}}"
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
                                                                       id="price" value="{{old('price_month')}}"
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
                                                        تصویر شاخص
                                                    </label>
                                                    <input required class="form-control" type="file" name="image">
                                                </div>
                                                <div class="col-md-2">
                                                    <br>
                                                    <input name="show_mobile" class="checkbox-custom" type="checkbox">
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
                                                              placeholder="درصورت نیاز..."></textarea>
                                                </div>
                                            </div>
                                            <h4 style="text-align: center">
                                                <br>
                                                اطلاعات دسته</h4>
                                            <div class="row">

                                                @foreach($fields as $key => $field )

                                                    <div class="col-md-6">
                                                        <label>
                                                            <br>

                                                            {{$field->name}}
                                                            @if($field->required)
                                                                <span
                                                                    style="color: red">*</span>
                                                            @endif
                                                        </label>
                                                        @switch($field->type)

                                                            @case('text')
                                                            <input type="text" name="field[{{$field->id}}]"
                                                                   class="form-control"
                                                                   @if($field->required)
                                                                   required
                                                                   @endif
                                                                   value="{{(isset($details[$key]) ? $details[$key]->field_value : old('field'.$field->id))}}">
                                                            <span>{{$field->description}}</span>
                                                            @break
                                                            @case('time')
                                                            <input type="text" name="field[{{$field->id}}]"
                                                                   class="form-control pickatime "
                                                                   @if($field->required)
                                                                   required
                                                                   @endif
                                                                   value="{{(isset($details[$key]) ? $details[$key]->field_value : old('field'.$field->id))}}">
                                                            <span>{{$field->description}}</span>

                                                            @break
                                                            @case('date')
                                                            <fieldset
                                                                class="form-group position-relative has-icon-left">
                                                                <input autocomplete="off" required type="text"
                                                                       @if($field->required)
                                                                       required
                                                                       @endif
                                                                       name="field[{{$field->id}}]"
                                                                       class="form-control shamsi-datepicker-list"
                                                                       placeholder="انتخاب تاریخ" readonly
                                                                       value="{{old('forecast')}}">
                                                                <span>{{$field->description}}</span>

                                                                <div class="form-control-position">
                                                                    <i class="bx bx-calendar"></i>
                                                                </div>
                                                            </fieldset>

                                                            @break

                                                            @case('number')
                                                            <input type="number" name="field[{{$field->id}}]"
                                                                   @if($field->required)
                                                                   required
                                                                   @endif
                                                                   value="{{(isset($details[$key]) ? $details[$key]->field_value : old('field'.$field->id))}}"
                                                                   class="form-control">
                                                            <span>{{$field->description}}</span>

                                                            @break

                                                            @case('textarea')
                                                            <textarea class="ckeditor form-control"
                                                                      name="field[{{$field->id}}]"
                                                                      rows="3">{{(isset($details[$key]) ? $details[$key]->field_value : old('field'.$field->id))}}</textarea>
                                                            <span>{{$field->description}}</span>

                                                            @break

                                                            @case('select')
                                                            <select class="select" name="field[{{$field->id}}]">
                                                                <option value="">انتخاب کنید</option>
                                                                @foreach($options = $field->option()->active()->get() as $option)
                                                                    <option value="{{$option->value}}"
                                                                            @if(isset($details[$key]) && $option->value == $details[$key]->field_value) selected @endif>{{$option->value}}</option>
                                                                @endforeach

                                                                <span>{{$field->description}}</span>
                                                            </select>
                                                            @break

                                                            @case('multi-select')
                                                            <select class="select2" name="field[{{$field->id}}][]"
                                                                    multiple="multiple">
                                                                @foreach($options = $field->option()->active()->get() as $option)
                                                                    <option value="{{$option->value}}"
                                                                            @if(isset($details[$key]) && in_array($option->value,explode(',',$details[$key]->field_value))) selected @endif>{{$option->value}}</option>
                                                                @endforeach

                                                            </select>
                                                            <span>{{$field->description}}</span>

                                                            @break

                                                        @endswitch
                                                    </div>


                                                @endforeach
                                                <hr>
                                                <div class="col-md-12"></div>
                                                <div class="col-md-12 map-container">
                                                    <hr class="new2">
                                                    <hr class="new2">
                                                    <h4>آدرس</h4>

                                                    <form action="#" class="aeen-search-in-map">
                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                <input type="text"
                                                                       class="form-control js-search-map-input" required
                                                                       placeholder="جستجو کن">

                                                            </div>

                                                        </div>
                                                        <ul class="aeen-search-in-map-result do-simplebar map-search-content-result"
                                                            style="display: none;"></ul>
                                                    </form>
                                                    <br>
                                                    <div id="map"
                                                         style="width: 100%; height: 450px; background: #eee; border: 2px solid #aaa; z-index: 0;"></div>
                                                    <div class="map-center-marker"><img
                                                            src="https://golaeen.com/assets/img/marker.svg"></div>
                                                    <button
                                                        class="btn btn-primary w-100 rounded-pill mt-3 js-select-address-map"
                                                        data-form="add-address-form">
                                                        ذخیره
                                                    </button>
                                                </div>

                                            </div>

                                            <!-- END: Page Vendor JS-->
                                            <br>
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


    <script src="/../../assets/js/scripts/jquery.min.js"></script>
    <script src="/../../assets/js/scripts/leaflet.js"></script>
    <script src="/../../assets/js/scripts/them2.js"></script>
    <script src="/../../assets/js/scripts/custom.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var baseUrl = "http://127.0.0.1:8000";
        var userId = 14;
        var userInformation = {"firstName": null, "lastName": null, "fullName": null, "mobile": "09332676163"};
        var mapWebKey = "web.ClftjhsJcbdhnDH99ZJuaZmnQCwPKWaaaQFtYKfZ";
        var mapAddressReverse = true
        var redirectAfterAddCart = false
    </script>

    <script type="text/javascript" src="/assets/js/toastr.min.js"></script>
    <script type="text/javascript">toastr.options = {"positionClass": "toast-bottom-left"};</script>


    <script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "WebSite",
		"url": "https://golaeen.com",
		"potentialAction": {
		"@type": "SearchAction",
		"target": "https://golaeen.com/search/?q={search_term_string}",
		"query-input": "required name=search_term_string"
			}
	}











    </script>

    <!---start GOFTINO code--->
    <script type="text/javascript">
        !function () {
            var i = "6Pbwm6", a = window, d = document;

            function g() {
                var g = d.createElement("script"), s = "https://www.goftino.com/widget/" + i,
                    l = localStorage.getItem("goftino_" + i);
                g.async = !0, g.src = l ? s + "?o=" + l : s;
                d.getElementsByTagName("head")[0].appendChild(g);
            }

            "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load", g, !1);
        }();
    </script>
    <!---end GOFTINO code--->
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
    <script>
        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var htmlPreview =
                        '<img width="200" src="' + e.target.result + '" />' +
                        '<p>' + input.files[0].name + '</p>';
                    var wrapperZone = $(input).parent();
                    var previewZone = $(input).parent().parent().find('.preview-zone');
                    var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

                    wrapperZone.removeClass('dragover');
                    previewZone.removeClass('hidden');
                    boxZone.empty();
                    boxZone.append(htmlPreview);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function reset(e) {
            e.wrap('<form>').closest('form').get(0).reset();
            e.unwrap();
        }

        $(".dropzone").change(function () {
            readFile(this);
        });

        $('.dropzone-wrapper').on('dragover', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('dragover');
        });

        $('.dropzone-wrapper').on('dragleave', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragover');
        });

        $('.remove-preview').on('click', function () {
            var boxZone = $(this).parents('.preview-zone').find('.box-body');
            var previewZone = $(this).parents('.preview-zone');
            var dropzone = $(this).parents('.form-group').find('.dropzone');
            boxZone.empty();
            previewZone.addClass('hidden');
            reset(dropzone);
        });

    </script>
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
    <script src="/../../assets/vendors/js/num2persian-min.js"></script>
    <script src="/../../assets/vendors/js/number-divider.min.js"></script>

@endsection

