window.initMap = function () {
    $('.element-map').each(function (index, Element) {
        var lat = $(Element).data('location-latitude');
        var lng = $(Element).data('location-longitude');
        var title = $(Element).data('location-formatted-address');
        
        var latlng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
        
        var map = new google.maps.Map(Element, {
            center: latlng,
            zoom: 14
        });
        
        var marker = new google.maps.Marker({
            position: latlng,
            title: title,
            map: map
        });
        
        var infowindow = new google.maps.InfoWindow({
            content: title
        });

        infowindow.open(map, marker);
    });
};