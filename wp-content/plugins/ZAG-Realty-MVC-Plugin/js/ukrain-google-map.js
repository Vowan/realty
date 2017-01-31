
jQuery(document).ready(function ($) {

    var placeSearch, autocomplete, infowindow, marker;



    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: parseFloat(map_object['map_center']['lat']), lng: parseFloat(map_object['map_center']['lng'])},
        zoom: parseFloat(map_object['zoom']),
    });


    var myLatLng = some_map_object[0];


    infowindow = new google.maps.InfoWindow({
        maxWidth: 160
    });

    some_map_object.forEach(function (prop, idx) {

        var prop_type = prop['post_type']; 
        var prop_icon;
        var prop_type_ru;

        switch (prop_type) {
            case 'buy':
                prop_icon = map_object['markers']['buy'];
                prop_type_ru = 'куплю';
                break;
            case 'sell':
                prop_icon = map_object['markers']['sell'];
                prop_type_ru = 'продам';
                break;
            case 'project':
                prop_icon = map_object['markers']['project'];
                prop_type_ru = 'новострой';
                break;
            case 'rent_long':
                prop_icon = map_object['markers']['rent_long'];
                prop_type_ru = 'сдам длительно';
                break;
            case 'rent_short':
                prop_icon = map_object['markers']['rent_short'];
                prop_type_ru = 'сдам посуточно';
                break;
            case 'rent_rever':
                prop_icon = map_object['markers']['rent_rever'];
                prop_type_ru = 'сниму';
                break;
            case 'hostel':
                prop_icon = map_object['markers']['hostel'];
                prop_type_ru = 'хостел';
                break;
        }



        var prop_marker = new google.maps.Marker({
            map: map,
            position: {lat: parseFloat(prop['lat']), lng: parseFloat(prop['lng'])},
            icon: prop_icon,
        });

        google.maps.event.addListener(prop_marker, 'click', (function (marker, i, type) {
            return function () {
                infowindow.setContent(type + '<br>цена ' + some_map_object[i]['price'] + ' $<br> комнат ' + some_map_object[i]['rooms'] + '<br>'
                        + '<a id="' + some_map_object[i]['real_id'] + '?prop_type=' + some_map_object[i]['post_type'] + '">Подробнее</a>');
                infowindow.open(map, marker);
            }
        })(prop_marker, idx, prop_type_ru));


    });

//    for (var prop_item in some_map_object) {
//
//        var prop_type = some_map_object[prop_item]['post_type'];
//        var prop_icon;
//        var prop_type_ru;
//
//        switch (prop_type) {
//            case 'buy':
//                prop_icon = map_object['markers']['buy'];
//                prop_type_ru = 'куплю';
//                break;
//            case 'sell':
//                prop_icon = map_object['markers']['sell'];
//                prop_type_ru = 'продам';
//                break;
//            case 'project':
//                prop_icon = map_object['markers']['project'];
//                prop_type_ru = 'новострой';
//                break;
//            case 'rent_long':
//                prop_icon = map_object['markers']['rent_long'];
//                prop_type_ru = 'сдам длительно';
//                break;
//            case 'rent_short':
//                prop_icon = map_object['markers']['rent_short'];
//                prop_type_ru = 'сдам посуточно';
//                break;
//            case 'rent_rever':
//                prop_icon = map_object['markers']['rent_rever'];
//                prop_type_ru = 'сниму';
//                break;
//            case 'hostel':
//                prop_icon = map_object['markers']['hostel'];
//                prop_type_ru = 'хостел';
//                break;
//        }
//
//
//
//        var prop_marker = new google.maps.Marker({
//            map: map,
//            position: {lat: parseFloat(some_map_object[prop_item]['lat']), lng: parseFloat(some_map_object[prop_item]['lng'])},
//            icon: prop_icon,
//        });
//
//        google.maps.event.addListener(prop_marker, 'click', (function (marker, i, type) {
//            return function () {
//                infowindow.setContent(type + '<br>цена ' + some_map_object[i]['price'] + ' $<br> комнат ' + some_map_object[i]['rooms'] + '<br>'
//                        + '<a id="' + some_map_object[i]['real_id'] + '?prop_type=' + some_map_object[i]['post_type'] + '">Подробнее</a>');
//                infowindow.open(map, marker);
//            }
//        })(prop_marker, prop_item, prop_type_ru));
//
//    }



});


