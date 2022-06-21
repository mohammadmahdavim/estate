@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="https://golaeen.com/themes/golaeen/css/custom.css?v=2.8.2">
    <link href="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.css" rel="stylesheet" type="text/css">
    <script src="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.js" type="text/javascript"></script>
    <style>
        hr.new2 {
            border-top: 1px dashed red;
        }

        hr.new5 {
            border: 1px solid red;
        }

    </style>
@endsection
@section('content')
    <div class="aeen--page-wrapper">

        <main class="aeen--page-content">
            <div class="container">

                <div class="" data-remodal-options="hashTracking: false">
                    <div class="remodal-title text-md fw-bold mb-4">انتخاب آدرس روی نقشه</div>
                    <div class="row">
                        <div class="col-md-12 map-container">
                            <form action="#" class="aeen-search-in-map">
                                <div class="form-row d-flex mb-3">
                                    <div class="aeen-search-in-map-field">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="جستجو کن">
                                        <button class="aeen-search-in-map-field-close d-none js-search-map-cancel" type="button"><i
                                                class="ri-close-line"></i></button>
                                    </div>
                                    <button type="button" class="btn btn-primary rounded-pill"><i
                                            class="isax isax-search-status"></i></button>
                                </div>
                                <ul class="aeen-search-in-map-result do-simplebar map-search-content-result"
                                    style="display: none;"></ul>
                            </form>
                            <div id="map"
                                 style="width: 100%; height: 450px; background: #eee; border: 2px solid #aaa; z-index: 0;"></div>
                            <div class="map-center-marker"><img src="https://golaeen.com/assets/img/marker.svg"></div>
                            <button class="btn btn-primary w-100 rounded-pill mt-3 js-select-address-map" data-form="add-address-form">
                                ثبت نشانی
                            </button>
                        </div>
                    </div>
                </div>

                <div class="remodal" data-remodal-id="add-address-modal" data-remodal-options="hashTracking: false">
                    <button data-remodal-action="close" class="remodal-close"></button>
                    <div class="remodal-title text-md fw-bold mb-4">افزودن آدرس جدید</div>
                    <form action="" id="add-address-form" onsubmit="return false;">
                        <input type="hidden" name="lat">
                        <input type="hidden" name="lng">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="aeen-form-row with-icon mb-3">
                                    <input type="text" name="fname" class="aeen-form-element-input"
                                           value=""
                                           placeholder="نام شما">
                                    <i class="isax isax-user-octagon"></i>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="aeen-form-row with-icon mb-3">
                                    <input type="text" class="aeen-form-element-input"
                                           name="lname"
                                           value=""
                                           placeholder="نام خانوادگی شما">
                                    <i class="isax isax-mobile"></i>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="aeen-form-row mb-3">
                                    <label for="state">استان:</label>
                                    <select id="state" class="aeen-form-element-select select2-in-remodal select-state-js"
                                            placeholder="انتخاب استان"
                                            name="state_id">
                                        <option value="">انتخاب استان</option>
                                        <option
                                            value="8">تهران</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="aeen-form-row mb-3">
                                    <label for="state">شهر:</label>
                                    <select id="city" class="aeen-form-element-select select2-in-remodal select-city-js"
                                            placeholder="انتخاب شهر"
                                            name="city_id">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 parish-content d-none">
                                <div class="aeen-form-row mb-3">
                                    <label for="parish">محله:</label>
                                    <select name="parish_id" id="parish" placeholder="انتخاب محله"
                                            class="aeen-form-element-select select2-in-remodal select-parish-js">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="aeen-form-row with-icon mb-3">
                                    <input type="text" id="address" name="address" class="aeen-form-element-input"
                                           placeholder="آدرس پستی"/>
                                    <i class="isax isax-textalign-justifyleft"></i>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="aeen-form-row with-icon mb-3">
                                    <input type="text" id="postal-code" name="postal_code" class="aeen-form-element-input"
                                           placeholder="کد پستی">
                                    <i class="isax isax-mail"></i>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="aeen-form-row with-icon mb-3">
                                    <input type="text" name="transferee" class="aeen-form-element-input"
                                           placeholder="نام کامل گیرنده">
                                    <i class="isax isax-user-octagon"></i>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="aeen-form-row with-icon mb-3">
                                    <input type="text" class="aeen-form-element-input"
                                           name="mobile"
                                           placeholder="شماره موبایل گیرنده">
                                    <i class="isax isax-mobile"></i>
                                </div>
                            </div>

                            <div class="col-12 text-left mt-4">
                                <a class="btn btn-link me-3" data-remodal-target="add-map-address-modal">اصلاح موقعیت بر روی نقشه</a>
                                <button class="btn btn-primary rounded-pill add-address-modal-js" style="float: left!important;">
                                    تایید و ثبت آدرس
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </main>  <!-- End Modal remove-location -->
    </div>
@endsection
@section('script')


    <script src="https://golaeen.com/themes/golaeen/js/dependencies/jquery.min.js?v=2.8.2"></script>
    <script src="https://golaeen.com/themes/golaeen/js/theme.js?v=2.8.2"></script>
    <script src="https://golaeen.com/themes/golaeen/js/custom.js?v=2.8.2"></script>


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var baseUrl = "https://golaeen.com";
        var userId = 14;
        var userInformation = {"firstName":null,"lastName":null,"fullName":null,"mobile":"09332676163"};
        var mapWebKey = "web.ClftjhsJcbdhnDH99ZJuaZmnQCwPKWaaaQFtYKfZ";
        var mapAddressReverse = true
        var redirectAfterAddCart = false
    </script>

    <script type="text/javascript" src="/assets/js/toastr.min.js"></script><script type="text/javascript">toastr.options = {"positionClass":"toast-bottom-left"};</script>


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
        !function(){var i="6Pbwm6",a=window,d=document;function g(){var g=d.createElement("script"),s="https://www.goftino.com/widget/"+i,l=localStorage.getItem("goftino_"+i);g.async=!0,g.src=l?s+"?o="+l:s;d.getElementsByTagName("head")[0].appendChild(g);}"complete"===d.readyState?g():a.attachEvent?a.attachEvent("onload",g):a.addEventListener("load",g,!1);}();
    </script>
    <!---end GOFTINO code--->
@endsection

