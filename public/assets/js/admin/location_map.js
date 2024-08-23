window.initMap = function () {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 50.2522263, lng: 18.8969564},
        zoom: 14
    });

    var input = document.getElementById('map-input');

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();

    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    var geocoder = new google.maps.Geocoder;

    if (document.getElementById('location')) {
        geocodePlaceId(geocoder, map, infowindow, marker);
    }
    
    map.addListener('click', function(event) {
        geocoder.geocode({'location': event.latLng}, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    var place = results[0];
                    var location = place.geometry.location;
                    
                    map.setZoom(17);
                    map.setCenter(location);
                    
                    marker.setPosition(location);
                    marker.setVisible(true);
                    
                    var form = document.getElementById('location_form');
                    
                    document.getElementById(form.name + '_location_name').value = place.name;
                    document.getElementById(form.name + '_location_latitude').value = location.lat();
                    document.getElementById(form.name + '_location_longitude').value = location.lng();
                    document.getElementById(form.name + '_location_placeId').value = place.place_id;
                    document.getElementById(form.name + '_location_formattedAddress').value = place.formatted_address;
                    document.getElementById(form.name + '_location_url').value = place.url;
                    
                    infowindow.setContent(place.formatted_address);
                    infowindow.open(map, marker);
                } else {
                    window.alert('Nie znaleziono wyników dla lokalizacji.');
                }
            } else {
                window.alert('Błąd geolokalizacji: ' + status);
            }
        });
    });

    autocomplete.addListener('place_changed', function () {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Brak danych dla wyszukiwania: '" + place.name + "'. Wybierz pozycję z podpowiedzi.");
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
        
        var form = document.getElementById('location_form');

        document.getElementById(form.name + '_location_name').value = place.name;
        document.getElementById(form.name + '_location_latitude').value = place.geometry.location.lat();
        document.getElementById(form.name + '_location_longitude').value = place.geometry.location.lng();
        document.getElementById(form.name + '_location_placeId').value = place.place_id;
        document.getElementById(form.name + '_location_formattedAddress').value = place.formatted_address;
        document.getElementById(form.name + '_location_url').value = place.url;

        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);
    });

};

function geocodePlaceId(geocoder, map, infowindow, marker) {
    var location = document.getElementById('location');
    var placeId = location.dataset.place;
    geocoder.geocode({'placeId': placeId}, function (results, status) {
        if (status === 'OK') {
            if (results[0]) {
                map.setZoom(17);
                map.setCenter(results[0].geometry.location);

                marker.setPosition(results[0].geometry.location);
                marker.setVisible(true);
                
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
            } else {
                window.alert('Nie znaleziono wyników dla lokalizacji o id: ' + placeId);
            }
        } else {
            window.alert('Błąd geolokalizacji: ' + status);
        }
    });
}
