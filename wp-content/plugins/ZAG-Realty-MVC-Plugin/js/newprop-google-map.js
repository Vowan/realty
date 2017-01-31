
jQuery(document).ready(function ($) {

    var placeSearch, autocomplete, infowindow, marker;



    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: parseFloat(map_object['map_center']['lat']), lng: parseFloat(map_object['map_center']['lng'])},
        zoom: parseFloat(map_object['zoom']),
    });

    if (document.getElementById('autocomplete')) {

        autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['address']});

        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', fillInAddress);
    }






    marker = new google.maps.Marker({
        map: map,
        // position: myLatLng,
    });








    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        sublocality_level_1: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        // postal_code: 'short_name'
    };


    function fillInAddress() {


        marker.setVisible(false);


//console.log(autocomplete);

        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        for (var component in componentForm) {

            //console.log(document.getElementById(component) );
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }


        var latitude = place.geometry.location.lat();
        var longitude = place.geometry.location.lng();

        var form_elem_lat = document.getElementById('latitude')
        form_elem_lat.value = latitude;

        var form_elem_lng = document.getElementById('longitude')
        form_elem_lng.value = longitude;



        // Get each component of the address from the place details
        // and fill the corresponding field on the form.

        var zag_address = document.getElementById('prop_address');

        zag_address.textContent = document.getElementById('autocomplete').value;


        // console.log(document.getElementById('autocomplete').value);


        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];

            //console.log(place.geometry.location.lat());

            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                var form_elem = document.getElementById(addressType)
                form_elem.value = val;
                //console.log(form_elem);


            }
        }
    }




});


