jQuery(document).ready(function ($) {

    var placeSearch, autocomplete, infowindow, marker;



    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: parseFloat(single_map_object[0]['lat']), lng: parseFloat(single_map_object[0]['lng'])},
        zoom: parseFloat(map_object['zoom']),
    });

    var prop_type = single_map_object[0]['prop_type'];
    var prop_icon;

   
    switch (prop_type) {
        case 'buy':
            prop_icon = single_map_object[0]['markers']['buy'];
            break;
        case 'sell':
            prop_icon = single_map_object[0]['markers']['sell'];
            break;
        case 'project':
            prop_icon = single_map_object[0]['markers']['project'];
            break;
        case 'rent_long':
            prop_icon = single_map_object[0]['markers']['rent_long'];
            break;
        case 'rent_short':
            prop_icon = single_map_object[0]['markers']['rent_short'];
            break;
        case 'rent_rever':
            prop_icon = single_map_object[0]['markers']['rent_rever'];
            break;
        case 'hostel':
            prop_icon = single_map_object[0]['markers']['hostel'];
            break;
    }


//console.log(single_map_object);



    marker = new google.maps.Marker({
        map: map,
        position: {lat: parseFloat(single_map_object[0]['lat']), lng: parseFloat(single_map_object[0]['lng'])},
        icon: prop_icon,
        draggable: true,
    });

    map.setCenter(new google.maps.LatLng(parseFloat(single_map_object[0]['lat']), parseFloat(single_map_object[0]['lng']) - 0.0045));


    var old_point = marker.getPosition();
    
    var old_lat = old_point.lat();
     var old_lng = old_point.lng();

    google.maps.event.addListener(marker, 'dragend', function (evt) {

        var point = marker.getPosition();
        
        
        if (Math.abs(old_lat - point.lat()) > 0.0015 || Math.abs(old_lng - point.lng()) > 0.0015) {
            
            marker.setPosition({lat: old_lat, lng: old_lng });

            
        } else {
            //console.log('point '+point.lat());
            $('#latitude').val(point.lat());
            $('#longitude').val(point.lng());

            map.panTo(point);
            
        }
    });




});


