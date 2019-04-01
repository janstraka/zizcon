(function ($, window, document) {


    $(function () {
        initializeMap();
    });

    var initializeMap = function () {
        var myLatlng1 = new google.maps.LatLng(50.074733, 14.441838, 0);
        var myLatlng2 = new google.maps.LatLng(50.074733, 14.441838, 0);


        var mapOptions1 =
        {
            zoom: 17,
            center: {lat: 50.075277, lng: 14.441849},
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_CENTER
            },
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            scaleControl: true,
            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.LEFT_TOP
            }
        };
        var mapOptions2 =
        {
            zoom: 17,
            center: {lat: 50.074733, lng: 14.441838},
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_CENTER
            },
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            scaleControl: true,
            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.LEFT_TOP
            }
        };


        var map = new google.maps.Map(document.getElementById('map-canvas'), (mapOptions1));


        var contentString = '<div class="container map-description">' +
            '<div id="siteNotice">' +
            '</div>' +


            '<div id="bodyContent">' +
            '<p><strong>Small Charming Hotels</strong><br>Budečská 17, Praha</p>' +
            '</div>' +
            '</div>';


        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var marker = new google.maps.Marker({
            position: myLatlng1,
            map: map,
            title: ''


        });

        var contentString2 = '<div class="container map-description">' +
            '<div id="siteNotice">' +
            '</div>' +


            '<div id="bodyContent">' +
            '<p><strong>Small Charming Hotels</strong><br>Jiná</p>' +
            '</div>' +
            '</div>';


        infowindow.open(map, marker);


        if (document.getElementById('map-canvas2')) {
            var map2 = new google.maps.Map(document.getElementById('map-canvas2'), (mapOptions2));
            var infowindow2 = new google.maps.InfoWindow({
                content: contentString2
            });

            var marker2 = new google.maps.Marker({
                position: myLatlng2,
                map: map2,
                title: ''


            });

            infowindow2.open(map2, marker2);
        }

    };


}(window.jQuery, window, document));
