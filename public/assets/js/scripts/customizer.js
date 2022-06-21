(function ($) {

    /*====== Add To Favorite ======*/
    SCRIPT.Favorite = function () {
        $(document).on('click', '.js-add-favorite', function (e) {
            e.preventDefault();

            if (userId == null) {
                var currentLoginUrl = $('.js-login-link').attr('href');

                if (self.oldLoginUrlOfModal) {
                    currentLoginUrl = self.oldLoginUrlOfModal;
                } else {
                    self.oldLoginUrlOfModal = currentLoginUrl;
                }

                currentLoginUrl += '?_selectedVal=' + $(".js-pdp-size-select").val();
                $('.js-login-link').attr('href', currentLoginUrl);
            }

        });
    }
    /*====== Add To Favorite ======*/

    /*====== Comment ======*/
    SCRIPT.Comment = function () {

        if (userId == null) {
            var commentTrigger = $('.js-comment-add');
            commentTrigger.attr("href", commentTrigger.data("login"));
            commentTrigger.removeClass("js-comment-add");
            commentTrigger.removeAttr("data-remodal-target");
        }

        $(document).on('click', '.js-comment-add', function (e) {
            $('[data-remodal-id="add-comment-modal"]').remodal().open();
        });

        function getComments(productId, page, mode) {
            var nextPage = page || 1;
            var params = mode ? {"page": nextPage, "mode": mode} : {"page": nextPage};
            SCRIPT.ajaxGETRequestHTML(
                "/ajax/product/comments/list/" + productId,
                params,
                function (response) {
                    if (page > 1) {
                        $(".js-comments-list-content").append(response);
                        $(".js-more-comments").data("next-page", page + 1);
                    }
                    if (!$.trim(response)) {
                        $(".js-more-comments").remove();
                    }
                },
                function (response) {
                    SCRIPT.DLAlert('error', response.errors);
                },
                false,
                true
            );
        }

        $(document).on('click', '.js-new-comment-submit', function (e) {
            e.preventDefault();
            var o = $(e.currentTarget);
            var r = o.closest("form");
            var productId = $(this).data('product');
            var formData = r.serialize();

            SCRIPT.ajaxPOSTRequestJSON(
                '/ajax/product/comments/add/' + productId,
                formData,
                function () {
                    $('[data-remodal-id="add-comment-modal"]').remodal().close();
                    $('[data-remodal-id="added-comment-success-modal"]').remodal().open();
                },
                function (data) {
                    if (Array.isArray(data.errors)) {
                        SCRIPT.DLAlert('error', data.errors[0]);
                    } else {
                        SCRIPT.DLAlert('error', data.errors);
                    }
                },
                true,
                true
            );
        });

        $(document).on('click', '.js-more-comments', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var page = $(this).data('next-page');
            var productId = $(this).data('product');
            getComments(productId, page);
        });
    }
    /*====== Comment ======*/

    /*====== Map ======*/
    SCRIPT.Map = function () {
        var map = $('#map');
        var searchLag;
        $mapWebKey = window.mapWebKey || false;
        if (map.length && $mapWebKey) {
            var digilaraMap = new L.Map('map', {
                key: $mapWebKey,
                maptype: 'dreamy',
                poi: true,
                traffic: false,
                center: [35.7013221, 51.3353777],
                zoom: 16
            });
        }
        $(document).on('click', '.js-new-address-btn', function (e) {
            e.preventDefault();
            setTimeout(function () {
                digilaraMap.invalidateSize();
            }, 10);
            $('[data-remodal-id="add-map-address-modal"]').remodal().open();
        });

        $(document).on('input', '.js-search-map-input', function (t) {
            if (searchLag) {
                clearTimeout(searchLag);
            }

            let parent = $(this).parents(".aeen-search-in-map");
            parent.find(".aeen-search-in-map-field-close").removeClass("d-none");

            var o = $(t.currentTarget);
            var mapContainer = o.closest('.map-container');
            var mapSearchContentResult = mapContainer.find('.map-search-content-result');
            var center = digilaraMap.getCenter();
            if (center) {
                searchLag = setTimeout(function () {
                    searchAjax = SCRIPT.ajaxPOSTRequestJSON(
                        '/addresses/search-address',
                        {
                            address: o.val(),
                            latitude: center.lat,
                            longitude: center.lng
                        },
                        function (response) {
                            mapSearchContentResult.html('');
                            var mapResult = '';
                            $.map(response, function (val) {
                                mapResult = mapResult + `<li>
                                                            <a class="js-map-search-item" data-lng="${val.longitude}" data-lat="${val.latitude}">
                                                            ${val.title} , ${val.address}
                                                            </a>
                                                        </li>`
                            });
                            mapSearchContentResult.html(mapResult);
                            mapSearchContentResult.show();
                        },
                        function (data) {
                            console.log(data.errors);
                        }
                    );
                }, 1000);
            }
        });

        $(document).on('click', '.js-map-search-item', function (e) {
            e.stopPropagation();
            var o = $(e.currentTarget);
            var mapContainer = o.closest('.map-container');
            var mapSearchContentResult = mapContainer.find('.map-search-content-result');
            digilaraMap.flyTo([$(this).data('lat'), $(this).data('lng')], 16);
            mapSearchContentResult.hide();
            mapContainer.find(".aeen-search-in-map-field-close").addClass("d-none");
        });


        $('.js-select-address-map').on('click', function () {
            var center = digilaraMap.getCenter();
            $mapAddressReverse = window.mapAddressReverse;
            var formAddress = $('form[id="' + $(this).data('form') + '"]');
            if (Math.ceil(center.lng * 10000000) === 513354207 && Math.ceil(center.lat * 10000000) === 357013243) {
                SCRIPT.DLAlert('error', 'Ù„Ø·ÙØ§ Ù…ÙˆÙ‚Ø¹ÛŒØª Ù…Ú©Ø§Ù†ÛŒ Ø®ÙˆØ¯ Ø±Ø§ Ø§Ù†ØªØ®Ø§Ø¨ Ú©Ù†ÛŒØ¯');
                return;
            }
            formAddress.find('[name = "lat"]').val(center.lat);
            formAddress.find('[name = "lng"]').val(center.lng);
            if ($mapAddressReverse) {
                SCRIPT.SearchAddressReverse(center.lat, center.lng, formAddress);
            }
            $('[data-remodal-id="add-address-modal"]').remodal().open();
        });

        $('.js-search-map-cancel').on('click', function (e) {
            e.stopPropagation();
            var o = $(e.currentTarget);
            var mapContainer = o.closest('.map-container');
            mapContainer.find('.js-search-map-input').val('');
            mapContainer.find('.map-search-content-result').hide();
            mapContainer.find(".aeen-search-in-map-field-close").addClass("d-none");
        });
    }

    SCRIPT.SearchAddressReverse = function (lat, lng, $form) {
        if (lat > 0 && lng > 0) {
            SCRIPT.ajaxPOSTRequestJSON(
                '/addresses/search-address-reverse',
                {'latitude': lat, 'longitude': lng},
                function (data) {
                    $form.find('.select-state-js').val(data.state_id).trigger('change');
                    $form.find('.select-city-js').val(data.city_id).trigger('change');
                    $form.find("input[name='address']").val(data.address);
                },
                function (data) {
                    console.log(data.errors);
                }
            );
        }
    }
    /*====== Map ======*/

    /*====== Add To Cart ======*/
    SCRIPT.AddToCart = function () {
        $(document).on('click', '.js-add-cart', function (e) {
            e.preventDefault();
            var price_id = $(this).data('id');
            var quantity = $('#quantity-product-input').val() ?? 1;
            SCRIPT.showLoader();
            SCRIPT.ajaxPOSTRequestHTML(
                '/cart/add',
                {
                    price_id: price_id,
                    quantity: quantity
                },
                function (response) {
                    SCRIPT.hideLoader();
                    $('#mini-cart').html(response.miniCart);
                    $("#mini-cart-mobile").html(response.miniCartMobile);
                    SCRIPT.CartSide();
                    SCRIPT.DLAlert('success', response.message);
                    if (redirectAfterAddCart) {
                        window.location.href = baseUrl + '/cart';
                    }
                }
            )
        });
    }
    /*====== Add To Cart ======*/

    /*====== Remove Cart Item======*/
    SCRIPT.ModalRemoveCartItem = function () {
        $(document).on('click', '.js-remove-product-cart', function (e) {
            e.preventDefault();
            $(".js-confirm-delete-product-cart").attr("data-cart", $(this).attr("data-cart"));
            $(".js-confirm-add-favorite-cart").attr("data-product", $(this).attr("data-product"));
            $("#removeItemFromCartModal").modal('show');
        });
    }

    SCRIPT.ReloadRemoveBox = function () {
        if ($(".select2").length) {
            $(".select2").select2({
                dir: "rtl",
            });
        }
        $(".aeen-cart-side-btn-close").on(
            "click",
            function () {
                $(".aeen-cart-side-container").removeClass("show");
                $(".aeen-cart-side-overlay").removeClass("show");
            }
        );
        $(".aeen-cart-side-item-btn-remove").on("click", function () {
            $(this)
                .parents(".aeen-cart-side-item")
                .find(".aeen-cart-side-remove-item-container")
                .addClass("show");
        });
        $(".aeen-cart-side-remove-item-container .cancel").on(
            "click",
            function () {
                $(this)
                    .parents(".aeen-cart-side-remove-item-container")
                    .removeClass("show");
            }
        );
    }

    SCRIPT.RemoveCartItem = function () {
        $(document).on('click', '.js-cart-side-remove-item', function (e) {
            var cartItemId = $(this).attr("data-cart");
            e.preventDefault();
            SCRIPT.ajaxPOSTRequestHTML(
                "/ajax/cart/remove",
                {cart_id: cartItemId},
                function (response) {
                    $("#detail-total-cart").html(response.detailTotal);
                    $("#mini-cart-mobile").html(response.miniCartMobile);
                    SCRIPT.ReloadRemoveBox();
                    SCRIPT.DLAlert('success', response.message);
                },
                function () {

                },
                true
            );
        });

        $(document).on('click', '.js-confirm-delete-product-cart', function (e) {
            var cartItemId = $(this).attr("data-cart");
            e.preventDefault();
            SCRIPT.ajaxPOSTRequestHTML(
                "/ajax/cart/remove",
                {cart_id: cartItemId},
                function (response) {
                    if (window.location.pathname === "/cart") {
                        window.location.reload();
                    }
                    $("#mini-cart").html(response.miniCart);
                    $("#mini-cart-mobile").html(response.miniCartMobile);
                    SCRIPT.CartSide();
                    $("#removeItemFromCartModal").modal('hide');
                    SCRIPT.DLAlert('success', response.message);
                },
                function () {
                    $("#removeItemFromCartModal").modal('hide');
                },
                true
            );
        });

        SCRIPT.MoveCartItem = function () {
            $(document).on('click', '.js-confirm-add-favorite-cart', function (e) {
                var productId = $(this).attr("data-product");
                e.preventDefault();
                SCRIPT.ajaxPOSTRequestJSON(
                    "/ajax/favorites/add",
                    {product_id: productId},
                    function (response) {
                        if (window.location.pathname === "/cart/") {
                            window.location.reload();
                        }
                        $("#mini-cart").html(response.miniCart);
                        $("#mini-cart-mobile").html(response.miniCartMobile);
                        SCRIPT.CartSide();
                        $("#removeItemFromCartModal").modal('hide');
                        SCRIPT.DLAlert('success', response.message);
                    },
                    function () {
                        $("#removeItemFromCartModal").modal('hide');
                    },
                    true,
                    true
                );
            });
        }
    }
    /*====== Remove Cart Item ======*/

    /*====== Search Mega Menu ======*/
    SCRIPT.InitMegaSearch = function () {
        var self = this;
        var $searchInput = $(".js-mega-menu-search-input"),
            $searchKeyword = $(".js-mega-menu-search-result-query"),
            $resultListContainer = $(".js-mega-menu-search-results-container"),
            $resultList = $(".js-mega-menu-search-results-category"),
            $productList = $(".js-mega-menu-search-results-product"),
            $trendList = $(".js-mega-menu-search-trend-results"),
            $emptyList = $(".js-mega-menu-search-no-result")

        var esc = 27,
            ent = 13;

        var showResults = function () {
            $resultListContainer.show();
            $emptyList.hide();
        };

        var hideResults = function () {

            if ($searchInput.length <= 0) {
                return;
            }

            $resultListContainer.hide();
            if ($searchInput.val().trim().length === 0) {
                $emptyList.hide();
            } else {
                $emptyList.show();
            }
        };


        var showProducts = function (brand_urls) {
            if (brand_urls.length > 0) {
                var dom = $.map(brand_urls, function (element) {
                    return (
                        '<li class="js-mega-menu-search-results-products">' +
                        '   <a href="' +
                        element.url +
                        '">' +
                        element.title +
                        "   </a>" +
                        "</li>"
                    );
                });

                $productList
                    .empty()
                    .append(dom)
                    .parent()
                    .show();
            } else {
                $productList
                    .empty()
                    .parent()
                    .hide();
            }
        };

        var showTrends = function (trend_urls) {
            if (trend_urls.length > 0) {
                var dom = $.map(trend_urls, function (element) {
                    return (
                        '<li class="js-mega-menu-search-most-results">' +
                        '   <a href="' +
                        element.url +
                        '">' +
                        element.title +
                        "   </a>" +
                        "</li>"
                    );
                });

                $trendList
                    .empty()
                    .append(dom)
                    .parent()
                    .show();
            } else {
                $trendList
                    .empty()
                    .parent()
                    .hide();
            }
        };

        var showSearchResults = function (search_result) {
            if (search_result.length > 0) {
                var doms = $.map(search_result, function (element) {
                    return (
                        '<li class="js-mega-menu-search-results-category">' +
                        '   <a href="' +
                        element.url +
                        '">' +
                        '       <span class="search--keyword js-mega-menu-search-result-query">' +
                        element.label +
                        "       </span>" +
                        element.category_name +
                        "   </a>" +
                        "</li>"
                    );
                });
                $resultList
                    .empty()
                    .append(doms)
                    .parent()
                    .show();
            } else {
                $resultList.parent().hide();
            }
        };

        var processResponse = function (data) {
            self.lastSearch = data.query;
            self.lastSearchResponse = data;
            self.lastFocusedItem = -1;

            self.trends = data.trends_result ? data.trends_result : self.trends;

            if (
                data.search_result.length === 0 &&
                data.product_result.length === 0
            ) {
                hideResults();
            } else {
                showResults();
                showSearchResults(data.search_result);
                showProducts(data.product_result);
                showTrends(data.trends_result);
            }
        };

        var goToSearchPage = function (val) {
            val = val.trim();
            if (!!val && val.length > 0) {
                window.location = "/search/?q=" + encodeURIComponent(val);
            }
        };


        var timeout = null;

        $searchInput.on("keyup", function (e) {
            var key = e.which;

            if (key === esc) return;

            if (key === ent) {
                var val;
                if ((val = $(this).val())) {
                    goToSearchPage(val);
                }
            } else {
                var searchInputValue = $(this).val();
                var searchInputValueL = searchInputValue.length;
                $searchKeyword.text(searchInputValue);
                if (searchInputValueL > 1) {
                    if (
                        self.lastSearch === searchInputValue &&
                        !!self.lastSearchResponse
                    )
                        return processResponse(self.lastSearchResponse);

                    $emptyList.hide();

                    if (timeout) clearTimeout(timeout);

                    timeout = setTimeout(function () {
                        SCRIPT.ajaxGETRequestJSON(
                            "/ajax/autosuggest",
                            {
                                q: searchInputValue
                            },
                            processResponse,
                            null,
                            null,
                            null,
                            "execute"
                        );
                    }, 400);
                } else {
                    hideResults();
                }
            }
        });

        $searchInput.on("keydown", function (e) {
            var key = e.which;

            if ([ent].indexOf(key) === -1) return;

            e.preventDefault();
            e.stopPropagation();
        });
    }
    /*====== Search Mega Menu ======*/

    /*====== Subscribe ======*/
    SCRIPT.Subscribe = function () {
        $(document).on('click', '.js-add-subscribe', function (e) {
            e.preventDefault();
            var email = document.getElementById('email-subscribe').value;
            var mailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (email.match(mailFormat)) {
                SCRIPT.ajaxPOSTRequestJSON(
                    "/subscribes",
                    {email: email},
                    function (response) {
                        document.getElementById("subscribeForm").reset();
                        SCRIPT.DLAlert('success', 'Ø§ÛŒÙ…ÛŒÙ„ Ø´Ù…Ø§ Ø¨Ø§ Ù…ÙˆÙÙ‚ÛŒØª Ø°Ø®ÛŒØ±Ù‡ Ú¯Ø±Ø¯ÛŒØ¯!');
                    },
                    function () {

                    },
                    false,
                    true
                );
            } else {
                SCRIPT.DLAlert('warning', 'Ø§ÛŒÙ…ÛŒÙ„ Ø±Ø§ Ø¨Ù‡ Ø¯Ø±Ø³ØªÛŒ ÙˆØ§Ø±Ø¯ Ù†Ù…Ø§ÛŒÛŒØ¯!');
                document.getElementById("subscribeForm").email.focus();
                return false;
            }
        });
    }
    /*====== Subscribe ======*/

    /*====== Basket Product ======*/
    SCRIPT.BasketProduct = function () {
        var min = 1;
        $(document).on("click", ".js-checkout-product-amount-inc, .js-checkout-product-amount-dec", function () {
            var $amountInput = $(this).siblings(".js-checkout-product-amount-input");
            var max = $amountInput.data("max-quantity");
            var currentVal = parseInt($amountInput.attr("data-value"));
            var nextVal = $(this).hasClass("js-checkout-product-amount-inc") ? currentVal + 1 : currentVal - 1;
            nextVal = nextVal >= min ? nextVal : min;
            nextVal = nextVal <= max ? nextVal : max;
            $amountInput.val(nextVal);
            $amountInput.attr("data-value", nextVal);
            $amountInput.change();
        });
        SCRIPT.UpdateQuantityCart = function () {
            $(document).on("change", ".js-checkout-product-amount-input", function () {
                var $this = $(this);
                var quantity = $this.attr("data-value");
                var cartId = $this.closest(".js-checkout-product").data("cart-id");
                SCRIPT.ajaxPOSTRequestHTML(
                    "/cart/change",
                    {id: cartId, quantity: quantity},
                    function (response) {
                        $("#mini-cart").html(response.miniCart);
                        $("#mini-cart-mobile").html(response.miniCartMobile);
                        $("#cart-data").html(response.cartData);
                        SCRIPT.CartSide();
                    },
                    function (response) {
                        SCRIPT.DLAlert('warning', response.message);
                    },
                    true,
                    true
                );
            });
        }
    }
    /*====== Basket Product ======*/

    /*====== Product Variant ======*/
    SCRIPT.ProductVariant = function () {
        $(document).on("change", ".product-variant-selector", function () {
            $('.product-gallery--loading').addClass('show');
            var data = $('#productVariantForm').serialize();
            SCRIPT.ajaxPOSTRequestHTML(
                "/product/variant/change",
                data,
                function (response) {
                    $("#product-price-box").html(response.productPriceBox);
                    $("#product-gallery-box").html(response.productGalleryBox);
                    SCRIPT.SwiperSlider();
                    SCRIPT.ZoomImage();
                    if ($(".select2").length) {
                        $(".select2").select2({
                            dir: "rtl",
                        });
                    }
                    $('.product-gallery--loading').removeClass('show');
                },
                function (response) {
                    SCRIPT.DLAlert('warning', response.message);
                },
                false
            );
        });
    }
    /*====== Product Variant ======*/

    /*====== Store Address ======*/
    SCRIPT.AddAddressModal = function () {
        $(document).on("click", ".add-address-modal-js", function () {
            var data = $('#add-address-form').serialize();
            SCRIPT.ajaxPOSTRequestHTML(
                "/addresses/store",
                data,
                function () {
                    setTimeout(function () {
                        window.location.replace(baseUrl + '/shipping')
                    }, 1000);
                },
                function (response) {
                    SCRIPT.DLAlert('warning', response.message);
                },
                true
            );
        });
    }
    /*====== Store Address ======*/

    /*====== Edit Address Modal ======*/
    SCRIPT.EditAddressModal = function () {
        $(document).on("click", ".edit-address-modal-js", function () {
            var address_id = $(this).attr('data-address-id');
            var editAddressContent = $('#edit-address-content');
            SCRIPT.ajaxPOSTRequestHTML(
                "/ajax/addresses/edit/" + address_id,
                {},
                function (response) {
                    editAddressContent.html(response.data);
                    $('[data-remodal-id="edit-map-address-modal"]').remodal().open();
                },
                function (response) {
                    SCRIPT.DLAlert('warning', response.message);
                },
                true
            );
        });
    }
    /*====== Edit Address Modal ======*/

    /*====== Edit Address Form Submit ======*/
    SCRIPT.EditAddressFormSubmit = function () {
        $(document).on("click", ".edit-address-form-submit-js", function (e) {
            e.preventDefault();
            var $editAddressForm = $("#edit-address-form");
            var editAddressModel = $("#editAddressModal");
            var address_id = $(this).attr('data-address-id');
            SCRIPT.ajaxPOSTRequestJSON(
                "/ajax/shipping/addresses/edit/" + address_id,
                $editAddressForm.serialize(),
                function (response) {
                    editAddressModel.removeClass('open');
                    $('#shipping-data-js').html(response);
                    SCRIPT.Address();
                    SCRIPT.Dialog();
                },
                function (response) {
                    editAddressModel.addClass('open');
                },
                true,
                true
            );
        });

    }
    /*====== Edit Address Form Submit ======*/

    /*====== Remove Address Form Submit ======*/
    SCRIPT.ModalRemoveAddress = function () {
        $(document).on('click', '.remove-address-modal-js', function (e) {
            e.preventDefault();
            $(".js-confirm-delete-address").attr("data-address-id", $(this).attr("data-address-id"));
            $("#removeAddressModal").addClass('open');
        });
    }
    SCRIPT.RemoveAddress = function () {
        var self = this;
        $(document).on("click", ".js-confirm-delete-address", function () {
            var address_id = $(this).attr('data-address-id');
            SCRIPT.ajaxPOSTRequestJSON(
                "/ajax/shipping/address/remove/" + address_id,
                null,
                function (response) {
                    $("#removeAddressModal").removeClass('open');
                    $('#shipping-data-js').html(response);
                    SCRIPT.Address();
                    SCRIPT.Dialog();
                },
                function (response) {
                },
                true,
                true
            );
        });
    }
    /*====== Remove Address Form Submit ======*/

    /*====== Change Default Address ======*/
    SCRIPT.ChangeDefaultAddress = function () {
        var self = this;
        $(document).on("change", ".default-address-input-js", function (e) {
            e.stopPropagation();
            e.preventDefault();
            var addressId = $(this).val();
            SCRIPT.ajaxGETRequestJSON(
                "/shipping/address/default/" + addressId,
                {},
                function (response) {
                    location.reload();
                },
                function (response) {
                    SCRIPT.DLAlert(
                        'warning',
                        response.message
                    );
                },
                true,
                true
            );
        });
    }
    /*====== Change Default Address ======*/

    /*====== Update Cities ======*/
    SCRIPT.UpdateCities = function () {
        var self = this;
        $(document).on("change", ".select-state-js", function () {
            var $this = $(this);
            var $form = $this.closest("form");
            var formCityId = $form.data("city-id");
            var stateId = $this.val();
            var $citySelector = $form.find("select.select-city-js");
            var $parishSelector = $form.find("select.select-parish-js");
            var $parishContent = $form.find("div.parish-content");

            if (!stateId) {
                return;
            }

            SCRIPT.ajaxGETRequestJSON(
                "/ajax/state/cities/" + stateId,
                null,
                function (data) {
                    $citySelector.children("select .js-not-empty").remove();
                    var hasCityId = false;
                    $.each(data, function (index, city) {
                        if (!hasCityId) {
                            hasCityId = city.id === formCityId;
                        }
                        $("<option>")
                            .val(city.id)
                            .text(city.name)
                            .addClass("js-not-empty")
                            .appendTo($citySelector);
                    });

                    if (formCityId > 0 && hasCityId) {
                        $citySelector.val(formCityId);
                    }

                    $this.val(stateId);
                    $citySelector.select2("destroy");
                    $citySelector.val(0);
                    $parishSelector.select2("destroy");
                    $parishSelector.val(0);
                    $parishContent.addClass('d-none');
                    SCRIPT.InitialSelect2($citySelector);
                    SCRIPT.InitialSelect2($parishSelector);
                },
                function (data) {
                    console.log(data.errors);
                    $this.val(stateId);
                }
            );
        });
        $(document).on("change", ".select-city-js", function () {
            var $this = $(this);
            var $form = $this.closest("form");
            var formParishId = $form.data("parish-id");
            var cityId = $this.val();
            var $parishSelector = $form.find("select.select-parish-js");
            var $parishContent = $form.find("div.parish-content");

            if (!cityId) {
                return;
            }

            SCRIPT.ajaxGETRequestJSON(
                "/ajax/state/parishes/" + cityId,
                null,
                function (data) {
                    $parishSelector.children("select .js-not-empty").remove();
                    var hasParishId = false;
                    $.each(data, function (index, parish) {
                        if (!hasParishId) {
                            hasParishId = parish.id === formParishId;
                        }
                        $("<option>")
                            .val(parish.id)
                            .text(parish.name)
                            .addClass("js-not-empty")
                            .appendTo($parishSelector);
                    });

                    if (formParishId > 0 && hasParishId) {
                        $parishSelector.val(formParishId);
                    }

                    if (data.length) {
                        $parishContent.removeClass('d-none');
                    } else {
                        $parishContent.addClass('d-none');
                    }

                    $this.val(cityId);
                    $parishSelector.select2("destroy");
                    $parishSelector.val(0);
                    SCRIPT.InitialSelect2($parishSelector);
                },
                function (data) {
                    console.log(data.errors);
                    $this.val(cityId);
                }
            );
        });

        $(document).on('change', ".js-transferee-is-me", function () {
            var $this = $(this);
            var $form = $this.closest("form"),
                $transfereeInput = $form.find("input[name='transferee']"),
                $mobilePhoneInput = $form.find("input[name='mobile']"),
                $userData = window.userInformation || {};

            if ($this.is(':checked')) {
                if (!($userData.fullName && $userData.mobile)) {
                    $this.prop('checked', false).change();
                    $this.closest('.js-transferee-is-me-container').remove();
                } else {
                    $transfereeInput.attr('disabled', 1).val($userData.fullName);
                    $mobilePhoneInput.attr('disabled', 1).val($userData.mobile);
                }
            } else {
                $transfereeInput.removeAttr('disabled').val('');
                $mobilePhoneInput.removeAttr('disabled').val('');
            }
        })
    }
    /*====== Update Cities ======*/

    /*====== Initial Select2 ======*/
    SCRIPT.InitialSelect2 = function ($select) {
        var options = {
            dir: "rtl",
            minimumInputLength: 0,
            minimumResultsForSearch: $select.data("min-res-for-search") || 7,
            width: $select.data("width") || "100%",
            placeholder: $select.attr("placeholder"),
            selectionCssClass: "select-option--text",
            dropdownCssClass: "select-option--text-dropdown",
            language: {
                errorLoading: function () {
                    return "Ø§Ù…Ú©Ø§Ù† Ø¨Ø§Ø±Ú¯Ø°Ø§Ø±ÛŒ Ù†ØªØ§ÛŒØ¬ ÙˆØ¬ÙˆØ¯ Ù†Ø¯Ø§Ø±Ø¯.";
                },
                inputTooLong: function (e) {
                    var t = e.input.length - e.maximum;
                    return "Ù„Ø·ÙØ§Ù‹ " + SCRIPT.convertToFaDigit(t) + " Ú©Ø§Ø±Ø§Ú©ØªØ± Ø±Ø§ Ø­Ø°Ù Ù†Ù…Ø§ÛŒÛŒØ¯";
                },
                inputTooShort: function (e) {
                    var t = e.minimum - e.input.length;
                    return "Ù„Ø·ÙØ§Ù‹ ØªØ¹Ø¯Ø§Ø¯ " + SCRIPT.convertToFaDigit(t) + " Ú©Ø§Ø±Ø§Ú©ØªØ± ÛŒØ§ Ø¨ÛŒØ´ØªØ± ÙˆØ§Ø±Ø¯ Ù†Ù…Ø§ÛŒÛŒØ¯";
                },
                loadingMore: function () {
                    return "Ø¯Ø± Ø­Ø§Ù„ Ø¨Ø§Ø±Ú¯Ø°Ø§Ø±ÛŒ Ù†ØªØ§ÛŒØ¬ Ø¨ÛŒØ´ØªØ±...";
                },
                maximumSelected: function (e) {
                    return "Ø´Ù…Ø§ ØªÙ†Ù‡Ø§ Ù…ÛŒâ€ŒØªÙˆØ§Ù†ÛŒØ¯ " + SCRIPT.convertToFaDigit(e.maximum) + " Ø¢ÛŒØªÙ… Ø±Ø§ Ø§Ù†ØªØ®Ø§Ø¨ Ù†Ù…Ø§ÛŒÛŒØ¯";
                },
                noResults: function () {
                    return "Ù‡ÛŒÚ† Ù†ØªÛŒØ¬Ù‡â€ŒØ§ÛŒ ÛŒØ§ÙØª Ù†Ø´Ø¯";
                },
                searching: function () {
                    return "Ø¯Ø± Ø­Ø§Ù„ Ø¬Ø³ØªØ¬Ùˆ...";
                }
            }
        };

        if ($select.data("url") && $select.data("url").length > 0) {
            options.ajax = {
                url: $select.data("url"),
                data: function (params) {
                    return {
                        query: params.term
                    };
                }
            };
        }

        $select.select2(options);
    }
    /*====== Initial Select2 ======*/

    /*====== Discount ======*/
    SCRIPT.Discount = function () {
        $(".js-gift-card-input, .js-discount-input")
            .each(function () {
                if ($(this).val().length > 0) {
                    $(this)
                        .closest(".js-voucher-container")
                        .find("button")
                        .removeAttr("disabled");
                } else {
                    $(this)
                        .closest(".js-voucher-container")
                        .find("button")
                        .attr("disabled", "disabled");
                }
            })
            .on("input", function () {
                if ($(this).val().length > 0) {
                    $(this)
                        .closest(".js-voucher-container")
                        .find("button")
                        .removeAttr("disabled");
                } else {
                    $(this)
                        .closest(".js-voucher-container")
                        .find("button")
                        .attr("disabled", "disabled")
                }
            })
            .on("keypress", function (e) {
                if (e.which === 13) {
                    $(this)
                        .closest(".js-voucher-container")
                        .find("button")
                        .click();
                    e.preventDefault();
                }
            });

        $(document).on("click", ".js-apply-discount-btn", function (e) {
            e.preventDefault();
            var o = $(e.currentTarget);
            var $input = $(".js-discount-input");
            var $container = $input.closest(".js-voucher-container");
            if ($input.val().length < 1) {
                return;
            }
            var type = o.data('type');

            SCRIPT.ajaxPOSTRequestJSON(
                "/ajax/discount/set",
                {code: $input.val(), type: type},
                function (data) {
                    if (type === 'create') {
                        o.data('type', 'delete').removeClass('btn-primary').addClass('btn-danger').text('Ø­Ø°Ù ØªØ®ÙÛŒÙ');
                        $input.attr('disabled', 'disabled');
                    } else {
                        o.data('type', 'create').removeClass('btn-danger').addClass('btn-primary').text('Ø§Ø¹Ù…Ø§Ù„ ØªØ®ÙÛŒÙ');
                        $input.val('').removeAttr('disabled').focus();
                    }
                    $container.find(".js-valid-code-msg").text(data.message).removeClass("d-none");
                    $container.find(".js-invalid-code-msg").addClass("d-none");
                    SCRIPT.UpdatePayablePrice();
                },
                function (data) {
                    $container.find(".js-valid-code-msg").addClass("d-none");
                    $container.find(".js-invalid-code-msg").text(data.message).removeClass("d-none");
                },
                false,
                true
            );
        });

        $(document).on("click", ".js-apply-gift-card-btn", function() {
            var $input = $(".js-gift-card-input");
            var $container = $input.closest(".js-voucher-container");

            if ($input.val().length < 5) {
                return;
            }

            SCRIPT.ajaxPOSTRequestJSON(
                "/ajax/apply/giftcard",
                { code: $input.val() },
                function(data) {
                    $container.find(".js-valid-code-msg").text(data.message).removeClass("d-none");
                    $container.find(".js-invalid-code-msg").addClass("d-none");
                    $input.attr('disabled', 'disabled');
                    SCRIPT.UpdatePayablePrice();
                },
                function(data) {
                    $container.find(".js-valid-code-msg").addClass("d-none");
                    $container.find(".js-invalid-code-msg").text(data.message).removeClass("d-none");
                },
                false,
                true
            );
        });
    }
    /*====== Discount ======*/


    /*====== Shipping Method ======*/
    SCRIPT.ShippingMethod = function () {
        $(document).on('click', '.js-save-shipping-data', function (){
            var form = $('#shipping-data-form').serialize();
            SCRIPT.ajaxPOSTRequestJSON(
                "/ajax/shipping/set",
                form,
                function () {
                    window.location.replace(baseUrl + '/payment');
                },
                function () {
                    //
                },
                false,
                true
            );
        });
    }
    /*====== Shipping Method ======*/


    /*====== Payment Method ======*/
    SCRIPT.PaymentMethod = function () {
        $(document).on('click', '.js-submit-payment', function (){
            var form = $('#paymentForm').serialize();
            SCRIPT.ajaxPOSTRequestJSON(
                "/payment",
                form,
                function (response) {
                    window.location.replace(response.url);
                },
                function () {
                    //
                },
                false,
                true
            );
        });
    }
    /*====== Shipping Method ======*/

    /*====== Update Payable Price ======*/
    SCRIPT.UpdatePayablePrice = function () {
        var purchaseDetailContent = $('#purchase-detail-content');
        if (purchaseDetailContent.length) {
            SCRIPT.ajaxPOSTRequestHTML(
                '/ajax/payment/detail',
                {},
                function (response) {
                    purchaseDetailContent.html(response.data);
                }
            )
        }
    }
    /*====== Update Payable Price ======*/

    /*====== Pay With Wallet ======*/
    SCRIPT.PayWithWallet = function () {
        $(document).on("change", "#pay-with-wallet-switch", function (e) {
            SCRIPT.showLoader();
            e.preventDefault();
            var status = (this.checked) ? 'yes' : 'no';
            SCRIPT.ajaxPOSTRequestHTML(
                '/paymentWallet',
                {status: status},
                function () {
                    SCRIPT.UpdatePayablePrice();
                }
            )
            SCRIPT.hideLoader();
        });
    }
    /*====== Pay With Wallet ======*/

    $(window).on("load", function () {

    });

    $(document).ready(function () {
        SCRIPT.Favorite();
        SCRIPT.AddToCart();
        SCRIPT.ModalRemoveCartItem();
        SCRIPT.RemoveCartItem();
        SCRIPT.MoveCartItem();
        SCRIPT.InitMegaSearch();
        SCRIPT.Subscribe();
        SCRIPT.BasketProduct();
        SCRIPT.UpdateQuantityCart();
        SCRIPT.ProductVariant();
        SCRIPT.AddAddressModal();
        SCRIPT.ChangeDefaultAddress();
        SCRIPT.UpdateCities();
        SCRIPT.EditAddressModal();
        SCRIPT.EditAddressFormSubmit();
        SCRIPT.ModalRemoveAddress();
        SCRIPT.RemoveAddress();
        SCRIPT.Comment();
        SCRIPT.Map();
        SCRIPT.ShippingMethod();
        SCRIPT.Discount();
        SCRIPT.PayWithWallet();
        SCRIPT.PaymentMethod();
    });
})
(jQuery);
