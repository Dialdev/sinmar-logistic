(function($) {
$('#map-01').each(function(){

    var styles = $(this).find('.theme-config').data('color');
    var set_center = $(this).parents('.sc_map').find('.map-block-info').length;
    var mapker_align = $(this).data('mapker-align');
    var key = $(this).data('key');
    
    var contentString1,
        mapmakerSmall;
    var data = $(this).data('json');
    var zoom = data.zoom;
    var color =  data.main_color;
    if(!color){
        color = "#18364a";
    }

    mapmakerSmall = data.marker;
    var locations_array = data.address;
    var address_lat,address_lng,marker_info;
    var i;
    var locations = [];

    if( styles == null ){
        
        styles =  [{
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{
                "color": "#e9e9e9"
            }, {
                "lightness": 17
            }]
        }, {
            "featureType": "landscape",
            "elementType": "geometry",
            "stylers": [{
                "color": "#f5f5f5"
            }, {
                "lightness": 20
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#ffffff"
            }, {
                "lightness": 17
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#ffffff"
            }, {
                "lightness": 29
            }, {
                "weight": 0.2
            }]
        }, {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [{
                "color": "#ffffff"
            }, {
                "lightness": 18
            }]
        }, {
            "featureType": "road.local",
            "elementType": "geometry",
            "stylers": [{
                "color": "#ffffff"
            }, {
                "lightness": 16
            }]
        }, {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{
                "color": "#f5f5f5"
            }, {
                "lightness": 21
            }]
        }, {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{
                "color": "#dedede"
            }, {
                "lightness": 21
            }]
        }, {
            "elementType": "labels.text.stroke",
            "stylers": [{
                "visibility": "on"
            }, {
                "color": "#ffffff"
            }, {
                "lightness": 16
            }]
        }, {
            "elementType": "labels.text.fill",
            "stylers": [{
                "saturation": 36
            }, {
                "color": "#333333"
            }, {
                "lightness": 40
            }]
        }, {
            "elementType": "labels.icon",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "transit",
            "elementType": "geometry",
            "stylers": [{
                "color": "#f2f2f2"
            }, {
                "lightness": 19
            }]
        }, {
            "featureType": "administrative",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#fefefe"
            }, {
                "lightness": 20
            }]
        }, {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#fefefe"
            }, {
                "lightness": 17
            }, {
                "weight": 1.2
            }]
        }];
    }

    for (i = 0; i < locations_array.length; i++) {
        contentString1 = 
            '<div id="content" class="map-content">' +
                '<div class="text-center">' +
                    '<div class="g-address"><i class="fa fa-map-marker"></i>'+locations_array[i]+'</div>' +
                '</div>' +
            '</div>';
        if (locations_array[i] != '') {
            $.ajax({
                url: "https://maps.googleapis.com/maps/api/geocode/json?key="+key+"&address="+locations_array[i]+"&sensor=false",
                type: "POST",
                async: false,
                success: function(res){

                    if (res.status == 'OK') {
                        address_lat = res.results[0].geometry.location.lat;
                        address_lng = res.results[0].geometry.location.lng;
                        marker_info = [locations_array[i],address_lat, address_lng,i,contentString1,mapmakerSmall];                        
                        locations.push(marker_info);
                    }
                }
            });
        };
    }
  
    function init() {

        if ( locations.length === 0 ) {
            var center_in_screen = new google.maps.LatLng(39.9679831, -75.1641189);
        }else{
            if( set_center !== 0 ){
                if(mapker_align == 'right'){
                    if($(window).width() > 768) {
                        var center_in_screen = new google.maps.LatLng( parseFloat(locations[0][1]), parseFloat(locations[0][2])  - 0.00035 * Math.pow(1.9, ( 21 - zoom )) );
                    }else{
                        var center_in_screen = new google.maps.LatLng(locations[0][1], locations[0][2]);
                    }
                }else{
                    if($(window).width() > 768) {
                        var center_in_screen = new google.maps.LatLng( parseFloat(locations[0][1]), parseFloat(locations[0][2])  + 0.00035 * Math.pow(1.9, ( 21 - zoom )) );
                    }else{
                        var center_in_screen = new google.maps.LatLng(locations[0][1], locations[0][2]);
                    }
                }
            }else{
                var center_in_screen = new google.maps.LatLng(locations[0][1], locations[0][2]);
            }
           
        }
    
        var isDraggable = true;
      
        var styledMap = new google.maps.StyledMapType(styles, { name: "Styled Map" });
        var myOptions = {
            zoom: zoom,
            center: center_in_screen,
            mapTypeControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            draggable: isDraggable,
            scrollwheel: false,
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
            }

        };

        var map = new google.maps.Map(document.getElementById('map-01'), myOptions);

        var infowindow = new google.maps.InfoWindow({
        });

        var marker, i;
        for (i = 0; i < locations.length; i++) {

            if(locations[i][5]){
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: locations[i][5]
                });
            }else{
                 var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                });
            }
           

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][4]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
           
        }

        map.mapTypes.set('map_style', styledMap);
        map.setMapTypeId('map_style');

        google.maps.event.addListener(infowindow, 'domready', function() {


            // Reference to the DIV which receives the contents of the infowindow using jQuery
            var iwOuter = $('.gm-style-iw');

            /* The DIV we want to change is above the .gm-style-iw DIV.
             * So, we use jQuery and create a iwBackground variable,
             * and took advantage of the existing reference to .gm-style-iw for the previous DIV with .prev().
             */
            var iwBackground = iwOuter.prev();

            // Remove the background shadow DIV
            // iwBackground.css({'display' : 'none'});
            iwBackground.children(':nth-child(2)').css({
                'box-shadow': 'none',
                'background-color': 'transparent',
            });

            //Remove close button
            var iwCloseBtn = iwOuter.next();

            // Remove the white background DIV
            iwBackground.children(':nth-child(4)').css({
                'border': '2px solid',
                'border-color':color,
            });
            iwBackground.children(':nth-child(3)').find('div').children().css({
                'box-shadow': ''+color+' 1px 2px 6px',
                'z-index': '1',
                
            });

        });

        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;

        $('.location-link').on('click', function() {

            var destination = $(this).data('attr');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    calculateAndDisplayRoute(directionsService, directionsDisplay, pos, destination);
                });
            }
            directionsDisplay.setMap(map);
        });
    }
    google.maps.event.addDomListener(window, 'load', init);

    //END GOOGLE MAP

    // Set isotope for info-location-content
    setTimeout(function() {
        $('.location-wrapper .row').isotope({
            // options
            itemSelector: '.location-address-content',
            layoutMode: 'masonry'
        });
    }, 1500);

    function calculateAndDisplayRoute(directionsService, directionsDisplay, pos, destination) {
        directionsService.route({
            origin: pos,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $("#map-01").offset().top
                    }, 500);
                }, 500);

            } else {
                window.alert('Directions request failed due to ' + status);
            }

        });
    }
  });
})(jQuery);
