!(function (t) {
    Array.prototype.forEach ||
        (t.forEach =
            t.forEach ||
            function (t, o) {
                for (var e = 0, a = this.length; e < a; e++) e in this && t.call(o, this[e], e, this);
            });
})(Array.prototype);
var mapObject,
    marker,
    markers = [],
    markersData = {
        Marker: [
            {
                location_latitude: 35.696466,
                location_longitude: 51.389242,
                locationURL: "single-property-2.html",
                locationImg: "assets/img/p-1.png",
                propertypricebed: "220 تومان + 2 خوابه",
                propertyname: "204# گرین ولی توچال",
                propertylocation: "تهران، ایران",
                contactURL: "single-property-2.html",
            },
            {
                location_latitude: 35.697625,
                location_longitude: 51.385755,
                locationURL: "single-property-2.html",
                locationImg: "assets/img/p-2.png",
                propertypricebed: "220 تومان + 2 خوابه",
                propertyname: "204# گرین ولی توچال",
                propertylocation: "تهران، ایران",
                contactURL: "single-property-2.html",
            },
            {
                location_latitude: 35.699943,
                location_longitude: 51.389800,
                locationURL: "single-property-2.html",
                locationImg: "assets/img/p-3.png",
                propertypricebed: "220 تومان + 2 خوابه",
                propertyname: "204# گرین ولی توچال",
                propertylocation: "تهران، ایران",
                contactURL: "single-property-2.html",
            },
            {
                location_latitude: 35.702278,
                location_longitude: 51.384854,
                locationURL: "single-property-2.html",
                locationImg: "assets/img/p-4.png",
                propertypricebed: "220 تومان + 2 خوابه",
                propertyname: "204# گرین ولی توچال",
                propertylocation: "تهران، ایران",
                contactURL: "single-property-2.html",
            },
            {
                location_latitude: 35.696270,
                location_longitude: 51.378948,
                locationURL: "single-property-2.html",
                locationImg: "assets/img/p-5.png",
                propertypricebed: "220 تومان + 2 خوابه",
                propertyname: "204# گرین ولی توچال",
                propertylocation: "تهران، ایران",
                contactURL: "single-property-2.html",
            },
            {
                location_latitude: 35.694013,
                location_longitude: 51.387070,
                locationURL: "single-property-2.html",
                locationImg: "assets/img/p-6.png",
                propertypricebed: "220 تومان + 2 خوابه",
                propertyname: "204# گرین ولی توچال",
                propertylocation: "تهران، ایران",
                contactURL: "single-property-2.html",
            },
            {
                location_latitude: 35.694990,
                location_longitude: 51.388771,
                locationURL: "single-property-2.html",
                locationImg: "assets/img/p-7.png",
                propertypricebed: "220 تومان + 2 خوابه",
                propertyname: "204# گرین ولی توچال",
                propertylocation: "تهران، ایران",
                contactURL: "single-property-2.html",
            },
            {
                location_latitude: 35.694821,
                location_longitude: 51.388210,
                locationURL: "single-property-2.html",
                locationImg: "assets/img/p-8.png",
                propertypricebed: "220 تومان + 2 خوابه",
                propertyname: "204# گرین ولی توچال",
                propertylocation: "تهران، ایران",
                contactURL: "single-property-2.html",
            },
        ],
    },
    mapOptions = {
        zoom: 15,
        center: new google.maps.LatLng(35.695333, 51.387568),
        mapTypeId: google.maps.MapTypeId.satellite,
        mapTypeControl: !1,
        mapTypeControlOptions: { style: google.maps.MapTypeControlStyle.DROPDOWN_MENU, position: google.maps.ControlPosition.LEFT_CENTER },
        panControl: !1,
        panControlOptions: { position: google.maps.ControlPosition.TOP_RIGHT },
        zoomControl: !0,
        zoomControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
        scrollwheel: !1,
        scaleControl: !1,
        scaleControlOptions: { position: google.maps.ControlPosition.TOP_LEFT },
        streetViewControl: !0,
        streetViewControlOptions: { position: google.maps.ControlPosition.LEFT_TOP },
    };
for (var key in ((mapObject = new google.maps.Map(document.getElementById("map"), mapOptions)), markersData))
    markersData[key].forEach(function (t) {
        (marker = new google.maps.Marker({ position: new google.maps.LatLng(t.location_latitude, t.location_longitude), map: mapObject, icon: "assets/img/marker.png" })),
            void 0 === markers[key] && (markers[key] = []),
            markers[key].push(marker),
            google.maps.event.addListener(marker, "click", function () {
                closeInfoBox(), getInfoBox(t).open(mapObject, this), mapObject.setCenter(new google.maps.LatLng(t.location_latitude, t.location_longitude));
            });
    });
function hideAllMarkers() {
    for (var t in markers)
        markers[t].forEach(function (t) {
            t.setMap(null);
        });
}
function closeInfoBox() {
    $("div.infoBox").remove();
}
function getInfoBox(t) {
    return new InfoBox({
        content:
            '<div class="map-popup-wrap"><div class="map-popup"><div class="_RentUP_proprty_grid"><div class="_RentUP_prt_grid_thumb"><a href="' +
            t.locationURL +
            '"><img src="' +
            t.locationImg +
            '" class="img-fluid" alt="" /></a><div class="rhomy_abs_caption"><h4 class="rhomy_pr_name verify">' +
            t.propertypricebed +
            '</h4></div></div><div class="_RentUP_prt_grid_caption"><div class="_RentUP_prt_head"><h5 class="_RentUP_prt_title">' +
            t.propertyname +
            '</h5><span class="_RentUP_prt_location"><i class="ti-location-pin ml-1"></i>' +
            t.propertylocation +
            '</span></div><div class="_RentUP_prt_bot"><div class="_RentUP_prt_bot_flex"><ul class="featur_5269"><li><div class="ft_th" data-toggle="tooltip" data-placement="top" title="" data-original-title="Pet Allowed"><img src="assets/img/pet.svg" alt=""></div></li><li><div class="ft_th" data-toggle="tooltip" data-placement="top" title="" data-original-title="Air Conditions"><img src="assets/img/cooling.svg" alt=""></div></li><li><div class="ft_th" data-toggle="tooltip" data-placement="top" title="" data-original-title="Wifi Avaialable"><img src="assets/img/wifi.svg" alt=""></div></li><li><div class="ft_th" data-toggle="tooltip" data-placement="top" title="" data-original-title="Gym Center"><img src="assets/img/gym.svg" alt=""></div></li><li><div class="ft_th" data-toggle="tooltip" data-placement="top" title="" data-original-title="Car Parking"><img src="assets/img/car.svg" alt=""></div></li></ul></div><div class="_RentUP_prt_bot_left"><a href=""' +
            t.contactURL +
            '"" class="mp_rhomy_btn"><i class="fa fa-envelope ml-1"></i>تماس</a></div></div></div></div></div></div>',
        disableAutoPan: !1,
        maxWidth: 0,
        pixelOffset: new google.maps.Size(10, 92),
        closeBoxMargin: "",
        closeBoxURL: "assets/img/close.png",
        isHidden: !1,
        alignBottom: !0,
        pane: "floatPane",
        enableEventPropagation: !0,
    });
}
function onHtmlClick(t, o) {
    google.maps.event.trigger(markers[t][o], "click");
}
new MarkerClusterer(mapObject, markers[key]);
