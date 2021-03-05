// google.maps.event.addDomListener(window, 'load', init);
// function init() {
//     var mapOptions = {
// // How zoomed in you want the map to start at (always required)
//         zoom: 11,
//
// // The latitude and longitude to center the map (always required)
//         center: new google.maps.LatLng(48.254861, 25.949917),
//
// // How you would like to style the map.
// // This is where you would paste any style found on Snazzy Maps.
//         styles: [
//             {
//                 "featureType": "administrative",
//                 "elementType": "labels.text.fill",
//                 "stylers": [
//                     {
//                         "color": "#444444"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "administrative.neighborhood",
//                 "elementType": "geometry.fill",
//                 "stylers": [
//                     {
//                         "visibility": "on"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "administrative.neighborhood",
//                 "elementType": "labels.text.fill",
//                 "stylers": [
//                     {
//                         "visibility": "on"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "landscape",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "color": "#f2f2f2"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "landscape.man_made",
//                 "elementType": "geometry.fill",
//                 "stylers": [
//                     {
//                         "visibility": "on"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "landscape.man_made",
//                 "elementType": "labels.text.fill",
//                 "stylers": [
//                     {
//                         "visibility": "on"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "poi",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "poi.attraction",
//                 "elementType": "geometry.fill",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     },
//                     {
//                         "color": "#cb1010"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "poi.attraction",
//                 "elementType": "labels.text.fill",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "poi.attraction",
//                 "elementType": "labels.icon",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "poi.park",
//                 "elementType": "geometry.fill",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     },
//                     {
//                         "hue": "#00ff66"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "poi.park",
//                 "elementType": "geometry.stroke",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     },
//                     {
//                         "color": "#d81d1d"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "poi.park",
//                 "elementType": "labels.text.fill",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "poi.park",
//                 "elementType": "labels.icon",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "road",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "saturation": -100
//                     },
//                     {
//                         "lightness": 45
//                     }
//                 ]
//             },
//             {
//                 "featureType": "road.highway",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "visibility": "simplified"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "road.arterial",
//                 "elementType": "labels.icon",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "transit",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "transit.line",
//                 "elementType": "geometry.fill",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "transit.line",
//                 "elementType": "labels.text.fill",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "transit.line",
//                 "elementType": "labels.icon",
//                 "stylers": [
//                     {
//                         "visibility": "on"
//                     },
//                     {
//                         "color": "#d31818"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "transit.station.airport",
//                 "elementType": "geometry.fill",
//                 "stylers": [
//                     {
//                         "visibility": "on"
//                     },
//                     {
//                         "color": "#2d014d"
//                     },
//                     {
//                         "saturation": "29"
//                     },
//                     {
//                         "lightness": "-3"
//                     },
//                     {
//                         "weight": "6.14"
//                     },
//                     {
//                         "gamma": "1.55"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "transit.station.airport",
//                 "elementType": "geometry.stroke",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     },
//                     {
//                         "weight": "6.72"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "transit.station.airport",
//                 "elementType": "labels.text.fill",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "transit.station.airport",
//                 "elementType": "labels.text.stroke",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "transit.station.airport",
//                 "elementType": "labels.icon",
//                 "stylers": [
//                     {
//                         "visibility": "on"
//                     },
//                     {
//                         "gamma": "2.46"
//                     },
//                     {
//                         "lightness": "-2"
//                     },
//                     {
//                         "saturation": "100"
//                     },
//                     {
//                         "hue": "#1800ff"
//                     },
//                     {
//                         "weight": "6.43"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "water",
//                 "elementType": "all",
//                 "stylers": [
//                     {
//                         "color": "#46bcec"
//                     },
//                     {
//                         "visibility": "on"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "water",
//                 "elementType": "geometry.fill",
//                 "stylers": [
//                     {
//                         "visibility": "on"
//                     },
//                     {
//                         "color": "#b7e5f8"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "water",
//                 "elementType": "labels.text.fill",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "water",
//                 "elementType": "labels.text.stroke",
//                 "stylers": [
//                     {
//                         "visibility": "on"
//                     }
//                 ]
//             },
//             {
//                 "featureType": "water",
//                 "elementType": "labels.icon",
//                 "stylers": [
//                     {
//                         "visibility": "off"
//                     }
//                 ]
//             }
//         ]
//
//     };
//
//     var mapElement = document.getElementById('map2');
//
// // Create the Google Map using our element and options defined above
//     var map = new google.maps.Map(mapElement, mapOptions);
//
// // Let's also add a marker while we're at it
//     var marker = new google.maps.Marker({
//         position: new google.maps.LatLng(48.254861, 25.949917),
//         map: map,
//         title: 'Мы тут!!',
//         icon: '/img/map_point.png'
//     });
// }