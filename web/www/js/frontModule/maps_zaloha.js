(function ($, window, document) {


    $(function () {

        initializeMap();

    });

    initializeMap = function () {
        var myLatlng1 = new google.maps.LatLng(49.9550535, 13.2766505, 1);
        var myLatlng2 = new google.maps.LatLng(45.9550535, 13.2766505, 1);
        var myLatlng3 = new google.maps.LatLng(49.9550535, 13.2766505, 1);
        var myLatlng4 = new google.maps.LatLng(49.9550535, 13.2766505, 1);
        var myLatlng5 = new google.maps.LatLng(49.9550535, 13.2766505, 1);

        mapOptions = [
            {
                zoom: 12,
                center: myLatlng1,
                scrollwheel: false
            },
            {
                zoom: 12,
                center: myLatlng2,
                scrollwheel: false
            },
            {
                zoom: 12,
                center: myLatlng3,
                scrollwheel: false
            },
            {
                zoom: 12,
                center: myLatlng4,
                scrollwheel: false
            },
            {
                zoom: 12,
                center: myLatlng5,
                scrollwheel: false
            }

        ];

        $('.tabs-map li').click(function () {
            $('.tabs-map li').removeClass('active');
            $(this).addClass('active');



            var index = $(this).index();
            console.log(index);
            var map = new google.maps.Map(document.getElementById('map-canvas'), (mapOptions[index]));



        });
    };

    google.maps.event.addDomListener(window, 'load', initialize);



}(window.jQuery, window, document));