var SCRIPT = {
    xhrPool: [],
    xhrPoolSame: [],
    localStorageBinds: [],
    isInitialized: false,

    ajaxGETRequestHTML: function (
        url,
        params,
        callbackStatusTrue,
        loggedOnly,
        showLoader,
        duplicateMode,
        duplicateUrl,
        async
    ) {
        return this.ajaxRequest(
            "GET",
            url,
            params,
            callbackStatusTrue,
            null,
            loggedOnly,
            showLoader,
            duplicateMode,
            duplicateUrl,
            "HTML",
            async,
            false
        );
    },

    ajaxPOSTRequestHTML: function (
        url,
        params,
        callbackStatusTrue,
        loggedOnly,
        showLoader,
        duplicateMode,
        duplicateUrl,
        async
    ) {
        return this.ajaxRequest(
            "POST",
            url,
            params,
            callbackStatusTrue,
            null,
            loggedOnly,
            showLoader,
            duplicateMode,
            duplicateUrl,
            "HTML",
            async,
            false
        );
    },

    ajaxGETRequestJSON: function (
        url,
        params,
        callbackStatusTrue,
        callbackStatusFalse,
        loggedOnly,
        showLoader,
        duplicateMode,
        duplicateUrl,
        async
    ) {
        return this.ajaxRequest(
            "GET",
            url,
            params,
            callbackStatusTrue,
            callbackStatusFalse,
            loggedOnly,
            showLoader,
            duplicateMode,
            duplicateUrl,
            "JSON",
            async,
            false
        );
    },

    ajaxPOSTRequestJSON: function (
        url,
        params,
        callbackStatusTrue,
        callbackStatusFalse,
        loggedOnly,
        showLoader,
        duplicateMode,
        duplicateUrl,
        async
    ) {
        return this.ajaxRequest(
            "POST",
            url,
            params,
            callbackStatusTrue,
            callbackStatusFalse,
            loggedOnly,
            showLoader,
            duplicateMode,
            duplicateUrl,
            "JSON",
            async,
            false
        );
    },

    ajaxUploadJSON: function (
        url,
        params,
        callbackStatusTrue,
        callbackStatusFalse,
        loggedOnly,
        showLoader,
        duplicateMode,
        duplicateUrl,
        async
    ) {
        return this.ajaxRequest(
            "POST",
            url,
            params,
            callbackStatusTrue,
            callbackStatusFalse,
            loggedOnly,
            showLoader,
            duplicateMode,
            duplicateUrl,
            "JSON",
            async,
            true
        );
    },

    ajaxRequest: function (
        method,
        url,
        params,
        callbackStatusTrue,
        callbackStatusFalse,
        loggedOnly,
        showLoader,
        duplicateMode,
        duplicateUrl,
        responseType,
        async,
        isFileUpload
    ) {
        var thiz = this;
        if (
            method === "undefined" ||
            (method !== "POST" && method !== "GET") ||
            url === "undefined"
        ) {
            return;
        }

        if (
            loggedOnly !== "undefined" &&
            loggedOnly === true &&
            !thiz.checkUserLogged()
        ) {
            return;
        }

        //none, stop, execute
        duplicateMode = duplicateMode || "none";
        duplicateUrl = duplicateUrl || url;
        async = typeof async !== "undefined" ? async : false;
        return $.ajax({
            duplicateMode: duplicateMode,
            duplicateUrl: duplicateUrl,
            type: method,
            url: baseUrl + url,
            data: params,
            async: async,
            contentType: !isFileUpload
                ? "application/x-www-form-urlencoded; charset=UTF-8"
                : false,
            processData: !isFileUpload,
            beforeSend: function (jqXHR, settings) {
                thiz.ajaxBeforeSendCallback(jqXHR, settings);
                thiz.ajaxBeforeSendCallbackDigilara(jqXHR, settings);
                if (showLoader) {
                    thiz.showLoader();
                }
            },
            success: function (response) {
                callbackStatusTrue(response.items);

                console.log(response)
                console.log(response.items)
                console.log(response.status)
                if (showLoader) {
                    thiz.hideLoader();
                }

                if (responseType === "HTML") {
                    if (response.length === 0) {
                        console.log(response, "Please use AjaxHTMLResponse response!");
                        return;
                    }

                    callbackStatusTrue(response);
                    return;
                }

                if (response.status === "undefined" && response.items === "undefined") {
                    console.log(response, "Please use AjaxJsonResponse response!");
                    return;
                }
                if (response.status === true) {
                    if (
                        typeof callbackStatusTrue !== "undefined" &&
                        callbackStatusTrue !== null
                    ) {
                        callbackStatusTrue(response.items);
                    } else {
                        console.log("Please define default true callback");
                    }
                } else if (response.status === false) {
                    if (
                        typeof callbackStatusFalse !== "undefined" &&
                        callbackStatusFalse !== null
                    ) {
                        callbackStatusFalse(response.items);
                    } else {
                        thiz.ajaxCallbackStatusFalse(response.items);
                    }
                } else {
                    console.log("Please use AjaxJsonResponse response!");
                }
            },
            error: function (jqXHR) {
                if (showLoader) {
                    thiz.hideLoader();
                }

                switch (jqXHR.status) {
                    case 0:
                        break;
                    case 400:
                        thiz.ajaxErrorBadRequestResponse(jqXHR);
                        break;
                    case 401:
                        thiz.ajaxError401Response(jqXHR);
                        break;
                    case 403:
                    case 404:
                        thiz.ajaxErrorBadRequestResponse(jqXHR);
                        break;
                    case 422:
                        thiz.ajaxMultiErrorBadRequestResponse(jqXHR);
                        break;
                    case 500:
                        thiz.ajaxErrorDefaultResponse(jqXHR);
                        break;
                    case 503:
                        thiz.ajaxError503Response(jqXHR);
                        break;
                    default:
                        thiz.ajaxErrorDefaultResponse(jqXHR);
                        break;
                }
            },
            complete: function () {
                if (showLoader) {
                    thiz.hideLoader();
                }
            },
        });
    },
    checkUserLogged: function () {
        return true;
    },
    ajaxError401Response: function (jqXHR) {
        this.DLAlert("warning", "Ø´Ù…Ø§ ÙˆØ§Ø±Ø¯ Ø­Ø³Ø§Ø¨ Ú©Ø§Ø±Ø¨Ø±ÛŒ Ø®ÙˆØ¯ Ù†Ø´Ø¯Ù‡ Ø§ÛŒØ¯!");
    },
    ajaxError503Response: function (jqXHR) {
        this.DLAlert(
            "warning",
            "Ù…Ø§ Ø¯Ø± Ø­Ø§Ù„ ØªÙˆØ³Ø¹Ù‡ Ù‡Ø³ØªÛŒÙ…. Ù„Ø·ÙØ§ Ú†Ù†Ø¯ Ø¯Ù‚ÛŒÙ‚Ù‡ Ø¯ÛŒÚ¯Ø± Ø§Ù…ØªØ­Ø§Ù† Ù†Ù…Ø§ÛŒÛŒØ¯!"
        );
    },
    ajaxErrorDefaultResponse: function (jqXHR) {
        this.DLAlert(
            "warning",
            "Please define default error callback. Code #" + jqXHR.status
        );
    },
    ajaxErrorBadRequestResponse: function (jqXHR) {
        this.hideLoader();
        this.DLAlert("warning", jqXHR.responseJSON.message);
    },
    ajaxMultiErrorBadRequestResponse: function (jqXHR) {
        this.hideLoader();
        jQuery.each(jqXHR.responseJSON.errors, function (key, value) {
            SCRIPT.DLAlert("error", value);
        });
    },
    ajaxBeforeSendCallback: function (jqXHR, settings) {},
    ajaxBeforeSendCallbackDigilara: function (jqXHR, settings) {
        var thiz = this;
        if (settings.duplicateMode === "execute") {
            jqXHR.url = settings.duplicateUrl || settings.url;
            $.each(thiz.xhrPool, function (k, v) {
                if (v.url === jqXHR.url) {
                    v.abort();
                }
            });
            thiz.xhrPool = $.grep(
                thiz.xhrPool,
                function (v) {
                    return v.url === jqXHR.url || v.readyState === 4;
                },
                true
            );
            thiz.xhrPool.push(jqXHR);
        } else if (settings.duplicateMode === "stop") {
            jqXHR.url = settings.duplicateUrl || settings.url;
            thiz.xhrPoolSame = $.grep(thiz.xhrPool, function (v) {
                return v.url === jqXHR.url && v.readyState !== 4;
            });
            if (thiz.xhrPoolSame.length) {
                jqXHR.abort();
            } else {
                thiz.xhrPool.push(jqXHR);
            }
        }
    },
    ajaxCallbackStatusFalse: function (data) {},
    showLoader: function () {
        var loader = $("#loading");
        if (loader.length) {
            loader.show();
        }
    },
    hideLoader: function () {
        var loader = $("#loading");
        setTimeout(function () {
            if (loader.length) {
                loader.hide();
            }
        }, 500);
    },
    nl2br: function (str) {
        if (typeof str === "undefined" || str === null) {
            return "";
        }
        var breakTag = "<br>";
        return (str + "").replace(
            /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,
            "$1" + breakTag + "$2"
        );
    },
    DLAlert: function (messageType, message, buttonText, extraClass) {
        message = message || "";
        buttonText = buttonText || "Ø¨Ø§Ø´Ù‡";
        extraClass = extraClass || "";

        toastr.clear();

        toastr.options = {
            closeButton: true,
            positionClass: "toast-bottom-left",
            onclick: null,
            showDuration: 1000,
            hideDuration: 1000,
            timeOut: 10000,
            extendedTimeOut: 1000,
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        };

        toastr[messageType](SCRIPT.nl2br(message));
    },
};
(function ($) {
    "use strict";

    /*====== Preloader ======*/
    var preloader = $(".skeleton-loading");
    $(window).on("load", function () {
        var preloaderFadeOutTime = 500;

        setTimeout(function () {
            $(".skeleton-loading").removeClass("skeleton-loading");
            if ($(".skeleton-loading-translateY-15").length) {
                $(".skeleton-loading-translateY-15").removeClass(
                    "skeleton-loading-translateY-15"
                );
            }
        }, preloaderFadeOutTime);
    });
    /*====== end Preloader ======*/

    /*====== MegaSearch ======*/
    SCRIPT.MegaSearch = function () {
        $(".aeen--page-header .aeen-search-btn").on("click", function () {
            $(".aeen-search-box-container").addClass("show");
        });
        $(
            ".aeen-search-box-container .search-box--close, .aeen-search-box-container .aeen-search-box--overlay"
        ).on("click", function () {
            $(".aeen-search-box-container").removeClass("show");
        });
    };
    /*====== end MegaSearch ======*/

    /*====== Menu ======*/
    SCRIPT.Menu = function () {
        $(".aeen--page-header .mega-menu > li:first-child").addClass("active");
        $(".aeen--page-header .mega-menu li").on("mouseenter", function () {
            $(".aeen--page-header .mega-menu li").removeClass("active");
            $(this).addClass("active");
        });
        $(".aeen--page-header .mega-menu").on("mouseleave", function () {
            $(".aeen--page-header .mega-menu li").removeClass("active");
            $(".aeen--page-header .mega-menu > li:first-child").addClass("active");
        });
    };
    /*====== end Menu ======*/

    /*====== Navigation ======*/
    SCRIPT.Navigation = function () {
        $(".aeen-toggle-navigation").on("click", function () {
            $(".aeen-navigation").addClass("toggle");
            $(".aeen-navigation-overlay").fadeIn(100);
        });
        $(".aeen-navigation .aeen-toggle-submenu").on("click", function (event) {
            event.preventDefault();
            $(this).siblings(".aeen-submenu").addClass("toggle");
        });
        $(".aeen-navigation .aeen-close-submenu").on("click", function (event) {
            event.preventDefault();
            $(this).parent(".aeen-submenu").removeClass("toggle");
        });
        $(".aeen-navigation-overlay, .aeen-close-navigation").on(
            "click",
            function (event) {
                event.preventDefault();
                $(".aeen-navigation").removeClass("toggle");
                $(".aeen-navigation .aeen-submenu").removeClass("toggle");
                $(".aeen-navigation-overlay").fadeOut(100);
            }
        );
        $(".aeen-panel-menus .aeen-panel-menu-btn").on("click", function (e) {
            e.preventDefault();
            $(".aeen-panel-profile").addClass("show");
            $(".aeen-panel-profile-overlay").addClass("show");
        });
        $(".aeen-panel-profile-overlay").on("click", function () {
            $(".aeen-panel-profile").removeClass("show");
            $(this).removeClass("show");
        });
        $(".aeen-panel-menus .aeen-panel-club-btn").on("click", function (e) {
            e.preventDefault();
            $(".aeen-panel-club").addClass("show");
            $(".aeen-panel-club-overlay").addClass("show");
        });
        $(".aeen-panel-club-overlay").on("click", function () {
            $(".aeen-panel-club").removeClass("show");
            $(this).removeClass("show");
        });
        $(".category-filter-sidebar-btn").on("click", function (e) {
            e.preventDefault();
            $(".category-filter-sidebar").addClass("show");
            $(".category-filter-sidebar-overlay").addClass("show");
        });
        $(".category-filter-sidebar-overlay").on("click", function () {
            $(".category-filter-sidebar").removeClass("show");
            $(this).removeClass("show");
        });
    };
    /*====== end Navigation ======*/

    /*====== CartSide ======*/
    /*====== end CartSide ======*/

    /*====== Countdown ======*/
    SCRIPT.Countdown = function () {
        if ($("[data-countdown]").length) {
            $("[data-countdown]").each(function () {
                var $this = $(this),
                    finalDate = $(this).data("countdown");
                $this.countdown(finalDate, function (event) {
                    $this.html(
                        event.strftime(
                            "<span>%D</span><span class='divider'>:</span><span>%H</span><span class='divider'>:</span><span>%M</span><span class='divider'>:</span><span>%S</span>"
                        )
                    );
                });
            });
        }
    };
    /* end Countdown ======*/

    /*====== SwiperSlider ======*/
    SCRIPT.SwiperSlider = function () {
        let arr_next1 = $(".aeen-select-option-slider-next"); //your arrows class name
        let arr_prev1 = $(".aeen-select-option-slider-prev"); //your arrows class name
        $(".aeen-select-option-slider").each(function (index, element) {
            $(this).addClass("aeen-select-option-slider--" + index);
            arr_next1[index].classList.add("aeen-select-option-slider-next-" + index);
            arr_prev1[index].classList.add("aeen-select-option-slider-prev-" + index);
            new Swiper(".aeen-select-option-slider--" + index, {
                speed: 800,
                freeMode: true,
                // spaceBetween: 10,
                navigation: {
                    nextEl: ".aeen-select-option-slider-next-" + index,
                    prevEl: ".aeen-select-option-slider-prev-" + index,
                },
                breakpoints: {
                    1090: {
                        slidesPerView: 4,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    576: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    480: {
                        slidesPerView: 3,
                        spaceBetween: 8,
                    },
                    0: {
                        slidesPerView: 3,
                        spaceBetween: 8,
                    },
                },
            });
        });
        let arr_next2 = $(".aeen-5-col-slider-next"); //your arrows class name
        let arr_prev2 = $(".aeen-5-col-slider-prev"); //your arrows class name
        $(".aeen-5-col-slider").each(function (index, element) {
            $(this).addClass("aeen-5-col-slider--" + index);
            arr_next2[index].classList.add("aeen-5-col-slider-next-" + index);
            arr_prev2[index].classList.add("aeen-5-col-slider-prev-" + index);
            new Swiper(".aeen-5-col-slider--" + index, {
                spaceBetween: 20,
                observer: true,
                observeParents: true,
                navigation: {
                    nextEl: ".aeen-5-col-slider-next-" + index,
                    prevEl: ".aeen-5-col-slider-prev-" + index,
                },
                breakpoints: {
                    1090: {
                        slidesPerView: 5,
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    576: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    480: {
                        slidesPerView: 2,
                        spaceBetween: 8,
                    },
                },
            });
        });
        let productSlider = new Swiper(".aeen-product-slider", {
            spaceBetween: 20,
            lazy: true,
            observer: true,
            observeParents: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                1200: {
                    slidesPerView: 4,
                },
                1090: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                576: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 8,
                },
            },
        });
        let checkoutPackSlider = new Swiper(".aeen-checkout-pack-slider", {
            spaceBetween: 20,
            observer: true,
            observeParents: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                1090: {
                    slidesPerView: 5,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                576: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                480: {
                    slidesPerView: 2,
                    spaceBetween: 8,
                },
            },
        });
        let mainSlider = new Swiper(".aeen-main-slider", {
            singleSlide: true,
            spaceBetween: 20,
            observer: true,
            observeParents: true,
            direction: "vertical",
            // autoplay: {
            //   delay: 3500,
            // },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
        let blogSlider = new Swiper(".aeen-blog-slider", {
            singleSlide: true,
            spaceBetween: 20,
            observer: true,
            observeParents: true,
            loop: true,
            autoplay: {
                delay: 3500,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
        let pointsToDiscountSlider = new Swiper(
            ".aeen-points-to-discounts-slider",
            {
                slidesPerView: 3,
                // slidesPerGroup: 2,
                slidesPerColumn: 2,
                slidesPerColumnFill: "column",
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            }
        );
        let giftCouponSlider = new Swiper(".aeen-gift-coupons-slider", {
            spaceBetween: 20,
            observer: true,
            observeParents: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                1200: {
                    slidesPerView: 4,
                },
                1090: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                576: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 8,
                },
            },
        });
        let panelGiftSlider = new Swiper(".aeen-panel-gift-slider", {
            spaceBetween: 20,
            observer: true,
            observeParents: true,
            slidesPerView: "auto",
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
        let checkoutTimeSlider = new Swiper(".aeen-checkout-time-swiper-slider", {
            spaceBetween: 20,
            observer: true,
            observeParents: true,
            slidesPerView: "auto",
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
        if ($(".aeen-gallery-slider").length) {
            let arr_next = $(".aeen-gallery-slider-thumbs-next"); //your arrows class name
            let arr_prev = $(".aeen-gallery-slider-thumbs-prev"); //your arrows class name
            let galleryThumbs = new Swiper(".aeen-gallery-slider-thumbs", {
                centeredSlides: true,
                centeredSlidesBounds: true,
                slidesPerView: 3,
                spaceBetween: 10,
                watchOverflow: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                direction: "vertical",
                navigation: {
                    nextEl: $(".aeen-gallery-slider-thumbs-next"),
                    prevEl: $(".aeen-gallery-slider-thumbs-prev"),
                },
            });
            let galleryMain = new Swiper(".aeen-gallery-slider", {
                watchOverflow: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                preventInteractionOnTransition: true,
                effect: "fade",
                fadeEffect: {
                    crossFade: true,
                },
                thumbs: {
                    swiper: galleryThumbs,
                },
                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: true,
                    clickable: true,
                },
            });
            galleryMain.on("slideChangeTransitionStart", function () {
                galleryThumbs.slideTo(galleryMain.activeIndex);
            });
            galleryThumbs.on("transitionStart", function () {
                galleryMain.slideTo(galleryThumbs.activeIndex);
            });
        }
        // tab
        let searchFilterOptionsSlider = new Swiper(
            ".aeen-search-filter-options-slider",
            {
                spaceBetween: 20,
                observer: true,
                observeParents: true,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    1200: {
                        slidesPerView: 6,
                    },
                    1090: {
                        slidesPerView: 5,
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    576: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    480: {
                        slidesPerView: 2,
                        spaceBetween: 8,
                    },
                },
            }
        );
        // tab
    };
    /*====== end SwiperSlider ======*/

    /*====== Zoom ======*/
    SCRIPT.ZoomImage = function () {
        if ($(".zoom-image").length) {
            if ($(window).width() > 960) {
                $(".zoom-image").imagezoomsl({
                    zoomrange: [3, 3],
                });
            }
        }
    };
    /* end Zoom ======*/

    /*====== Form ======*/
    SCRIPT.Form = function () {
        if ($(".select2").length) {
            $(".select2").select2({
                dir: "rtl",
            });
        }
        if ($(".select2-in-remodal").length) {
            $(".select2-in-remodal").select2({
                selectionCssClass: "select-option--text",
                dropdownCssClass: "select-option--text-dropdown",
            });
        }
        if ($("#aeen-send-comment-star-slider").length) {
            let roundSlider = document.getElementById(
                "aeen-send-comment-star-slider"
            );
            noUiSlider.create(roundSlider, {
                start: 3,
                connect: "lower",
                format: wNumb({
                    decimals: 1,
                }),
                range: {
                    min: 1,
                    max: 5,
                },
            });
            let starStepSliderValueInputElement = document.getElementById(
                "aeen-send-comment-star-input"
            );
            let starStepSliderValueSpanElement = document.querySelector(
                ".aeen-send-comment-star-value"
            );
            roundSlider.noUiSlider.on("update", function (values, handle) {
                starStepSliderValueInputElement.value = values[handle];
                starStepSliderValueSpanElement.innerHTML = values[handle];
            });
        }
    };
    /*====== end Form ======*/

    /*====== FilterPrice ======*/
    SCRIPT.FilterPrice = function () {
        if ($(".filter-price").length) {
            let skipSlider = document.getElementById("slider-non-linear-step");
            let $sliderFrom = document.querySelector(".js-slider-range-from");
            let $sliderTo = document.querySelector(".js-slider-range-to");
            let min = parseInt($sliderFrom.dataset.range),
                max = parseInt($sliderTo.dataset.range);
            noUiSlider.create(skipSlider, {
                start: [$sliderFrom.value, $sliderTo.value],
                connect: true,
                direction: "rtl",
                format: wNumb({
                    thousand: ",",
                    decimals: 0,
                }),
                step: 1,
                range: {
                    min: min,
                    max: max,
                },
            });
            let skipValues = [
                document.getElementById("skip-value-lower"),
                document.getElementById("skip-value-upper"),
            ];
            let sliderRangeFromValueSpanElement =
                document.querySelector(".slider-range-from");
            let sliderRangeToValueSpanElement =
                document.querySelector(".slider-range-to");
            skipSlider.noUiSlider.on("update", function (values, handle) {
                skipValues[handle].value = values[handle];
                sliderRangeFromValueSpanElement.innerHTML = values[0];
                sliderRangeToValueSpanElement.innerHTML = values[1];
            });
        }
    };
    /* end FilterPrice ======*/

    /*====== Tab ======*/
    SCRIPT.Tab = function () {
        $('[data-toggle="aeen--tab"] [data-tab-target]').on(
            "click",
            function (event) {
                event.preventDefault();
                let targetTab = $(this)
                    .parents('[data-toggle="aeen--tab"]')
                    .attr("data-target");
                let targetTabItem = $(this).attr("data-tab-target");
                $(targetTab)
                    .find(targetTabItem)
                    .addClass("aeen-active-tab-content")
                    .siblings()
                    .removeClass("aeen-active-tab-content");
                $(this)
                    .addClass("aeen-active-tab")
                    .siblings()
                    .removeClass("aeen-active-tab");
            }
        );
    };
    /*====== end Tab ======*/

    /*====== AddToCartSlider ======*/
    SCRIPT.AddToCartSlider = function () {
        $(".aeen-add-to-cart-container .add-to-cart").on("click", function () {
            var AddToCartSlider = $(this);
            var price_id = $(this).data("id");
            AddToCartSlider.parents(".aeen-add-to-cart-container").data(
                "added",
                "true"
            );
            AddToCartSlider.siblings("input[type=number]").val("1");
            AddToCartSlider.parents(".aeen-add-to-cart-container").toggleClass(
                "show-quantity"
            );
            var cartInputGroup = AddToCartSlider.siblings(".input-group");
            cartInputGroup.find(".btn-decrement").on("click", function (e) {
                if (cartInputGroup.find(".form-control").val() == "0") {
                    Swal.fire({
                        allowOutsideClick: false,
                        title: "Ø§Ø² Ø³Ø¨Ø¯ Ø­Ø°Ù Ø¨Ø´Ù‡ØŸ",
                        text: "Ø¨Ø§ ØµÙØ± Ø´Ø¯Ù† ØªØ¹Ø¯Ø§Ø¯ØŒ Ú©Ø§Ù„Ø§ÛŒ ÙÙˆÙ‚ Ø§Ø² Ø³Ø¨Ø¯ Ø®Ø±ÛŒØ¯ Ø´Ù…Ø§ Ø­Ø°Ù Ù…ÛŒØ´Ù‡.Ù…Ø·Ù…Ø¦Ù†ÛŒØŸ",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "Ù†Ù‡!!!",
                        confirmButtonText: "Ø¨Ù„Ù‡ØŒØ­Ø°Ù Ø¨Ø´Ù‡!",
                    }).then((result) => {
                        if (result.value) {
                            e.preventDefault();
                            var quantity = 0;
                            SCRIPT.showLoader();
                            SCRIPT.ajaxPOSTRequestHTML(
                                "/cart/add",
                                {
                                    price_id: price_id,
                                    quantity: quantity,
                                },
                                function (response) {
                                    SCRIPT.hideLoader();
                                    $("#mini-cart").html(response.miniCart);
                                    $("#mini-cart-mobile").html(response.miniCartMobile);
                                    SCRIPT.CartSide();
                                    SCRIPT.DLAlert("success", response.message);
                                    if (redirectAfterAddCart) {
                                        window.location.href = baseUrl + "/cart";
                                    }
                                }
                            );
                        }
                    });
                    $(".swal2-confirm").on("click", function () {
                        AddToCartSlider.parents(".aeen-add-to-cart-container").toggleClass(
                            "show-quantity"
                        );
                    });
                    $(".swal2-cancel").on("click", function () {
                        AddToCartSlider.siblings("input[type=number]").val("1");
                    });
                }
            });
        });

        $(".aeen-add-to-cart-container .add-to-cart").on("click", function (e) {
            e.preventDefault();
            var price_id = $(this).data("id");
            var quantity = 1;
            SCRIPT.showLoader();
            SCRIPT.ajaxPOSTRequestHTML(
                "/cart/add",
                {
                    price_id: price_id,
                    quantity: quantity,
                },
                function (response) {
                    SCRIPT.hideLoader();
                    $("#mini-cart").html(response.miniCart);
                    $("#mini-cart-mobile").html(response.miniCartMobile);
                    SCRIPT.CartSide();
                    SCRIPT.DLAlert("success", response.message);
                    if (redirectAfterAddCart) {
                        window.location.href = baseUrl + "/cart";
                    }
                }
            );
        });

        $(".aeen-add-to-cart-container input[type=number]").on(
            "input",
            function (event) {
                event.preventDefault();
                var price_id = $(this).data("id");
                var quantity = 1;
                SCRIPT.showLoader();
                SCRIPT.ajaxPOSTRequestHTML(
                    "/cart/add",
                    {
                        price_id: price_id,
                        quantity: quantity,
                    },
                    function (response) {
                        SCRIPT.hideLoader();
                        $("#mini-cart").html(response.miniCart);
                        $("#mini-cart-mobile").html(response.miniCartMobile);
                        SCRIPT.CartSide();
                        SCRIPT.DLAlert("success", response.message);
                        if (redirectAfterAddCart) {
                            window.location.href = baseUrl + "/cart";
                        }
                    }
                );
            }
        );
        $(".aeen-add-to-cart-container input[type='number']").inputSpinner({
            buttonsOnly: true,
        });
        $(".aeen-add-to-cart-container[data-added='true'] .btn-decrement").on(
            "click",
            function () {
                var parents = $(this).parents(
                    ".aeen-add-to-cart-container[data-added='true']"
                );
                if (parents.find(".form-control").val() == "0") {
                    Swal.fire({
                        allowOutsideClick: false,
                        title: "Ø§Ø² Ø³Ø¨Ø¯ Ø­Ø°Ù Ø¨Ø´Ù‡ØŸ",
                        text: "Ø¨Ø§ ØµÙØ± Ø´Ø¯Ù† ØªØ¹Ø¯Ø§Ø¯ØŒ Ú©Ø§Ù„Ø§ÛŒ ÙÙˆÙ‚ Ø§Ø² Ø³Ø¨Ø¯ Ø®Ø±ÛŒØ¯ Ø´Ù…Ø§ Ø­Ø°Ù Ù…ÛŒØ´Ù‡.Ù…Ø·Ù…Ø¦Ù†ÛŒØŸ",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "Ù†Ù‡!!!",
                        confirmButtonText: "Ø¨Ù„Ù‡ØŒØ­Ø°Ù Ø¨Ø´Ù‡!",
                    }).then((result) => {
                        if (result.value) {
                            Swal.fire({
                                allowOutsideClick: false,
                                title: "Ø­Ø°Ù Ø´Ø¯!",
                                text: "Ú©Ø§Ù„Ø§ Ø§Ø² Ø³Ø¨Ø¯ Ø´Ù…Ø§ Ø­Ø°Ù Ø´Ø¯.",
                                icon: "success",
                                confirmButtonText: "Ø®Ø¨..",
                            });
                        }
                    });
                    $(".swal2-confirm").on("click", function () {
                        parents.toggleClass("show-quantity");
                        parents.attr("data-added", "false");
                    });
                    $(".swal2-cancel").on("click", function () {
                        parents.find("input[type=number]").val("1");
                    });
                }
            }
        );
    };
    /* end AddToCartSlider ======*/

    /*====== Simplebar ======*/
    SCRIPT.SimpleBar = function () {
        if ($(".do-simplebar").length) {
            $(".do-simplebar").each(function (index, el) {
                new SimpleBar(el, {
                    autoHide: false,
                });
            });
        }
    };
    /* end Simplebar ======*/

    /*====== BtnAction ======*/
    SCRIPT.BtnAction = function () {
        $(".add-to-whishlist").on("click", function (e) {
            e.preventDefault();
            $(this).toggleClass("added");
        });
        $(".js-copy-link").on("click", function (e) {
            e.preventDefault();
            var copyBtn = $(this);
            $(copyBtn)
                .removeClass("btn-dark")
                .addClass("btn-success")
                .text("Ú©Ù¾ÛŒ Ø´Ø¯!");
            setTimeout(function () {
                $(copyBtn)
                    .removeClass("btn-success")
                    .addClass("btn-dark")
                    .text("Ù„ÛŒÙ†Ú© Ø±Ø§ Ú©Ù¾ÛŒ Ú©Ù†ÛŒØ¯");
            }, 3000);
        });
    };
    /*====== end BtnAction ======*/

    /*====== Example ======*/
    SCRIPT.Example = function () {};
    /*====== end Example ======*/

    $(window).on("load", function () {});
    $(document).ready(function () {
        SCRIPT.MegaSearch(),
            SCRIPT.Menu(),
            SCRIPT.Navigation(),
            SCRIPT.CartSide(),
            SCRIPT.Countdown(),
            SCRIPT.SwiperSlider(),
            SCRIPT.ZoomImage(),
            SCRIPT.Form(),
            SCRIPT.FilterPrice(),
            SCRIPT.AddToCartSlider(),
            SCRIPT.SimpleBar(),
            SCRIPT.Tab(),
            SCRIPT.BtnAction(),
            SCRIPT.Example();
    });
})(jQuery);

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}
