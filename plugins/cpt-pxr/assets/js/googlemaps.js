( function ( $ ) {
    "use strict";

    
    /* ******************************************************************************

    ALE GOOGLE MAPS

    ********************************************************************************* */
    $.pxr_maps = function(el, locations, zoom){

        var base = this;
        base.init = function(){

            if(locations.length>0) google.maps.event.addDomListener(window, 'load', $.fn.pxr_maps());
        };

        if(locations.length>0) base.init();
    };

    $.fn.pxr_maps = function(locations, zoom){

        var map_id = $(this).attr("id");

        var height = $('[data-scope="#'+map_id+'"]').attr("data-height");

        if ( height > 0 ){
            $(this).css({'height':height+"px"});
        }

       if (typeof google === 'object' && typeof google.maps === 'object') {

        var myOptions = {
            zoom: zoom,
            panControl: true,
            zoomControl: true,
            scaleControl: false,
            streetViewControl: false,
            overviewMapControl: false,
            scrollwheel : false,
            navigationControl: false,
            mapTypeControl: false,
            center: new google.maps.LatLng(0, 0),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        var map = new google.maps.Map( document.getElementById(map_id), myOptions);


        //Map styling
        var styles = [
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#d3d3d3"
                    }
                ]
            },
            {
                "featureType": "transit",
                "stylers": [
                    {
                        "color": "#808080"
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#b3b3b3"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#ffffff"
                    },
                    {
                        "weight": 1.8
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#d7d7d7"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#ebebeb"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#a7a7a7"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#efefef"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#696969"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#737373"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#d6d6d6"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {},
            {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#dadada"
                    }
                ]
            }
        ]
        var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

        //Associate the styled map with the MapTypeId and set it to display.
        map.mapTypes.set('map_style', styledMap);
        map.setMapTypeId('map_style');


        $.fn.setMarkers(map, locations);

        $.fn.fixTabs(map,map_id,zoom);
        $.fn.fixAccordions(map,map_id,zoom);
    }
    };

    $.fn.setMarkers = function (map, locations) {


        if(locations.length>1){
            var bounds = new google.maps.LatLngBounds();
        }else{
            var center = new google.maps.LatLng(locations[0][1], locations[0][2]);
            map.panTo(center);
        }

        var mrk_str = $('.google_map_holder').data('markerstr');
        var mrk_clr = $('.google_map_holder').data('marker');

        function pinSymbol(color) {
            return {
                path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
                fillColor: color,
                fillOpacity: 1,
                strokeColor: mrk_str,
                strokeWeight: 1.5,
                scale: 1.2
           };
        }
        
        for (var i = 0; i < locations.length; i++) {
            if (locations[i] instanceof Array) {
                var location = locations[i];
                var myLatLng = new google.maps.LatLng(location[1], location[2]);
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    icon: pinSymbol(mrk_clr),
                    map: map,
                    draggable: false,
                    title: location[0]
                });

                $.fn.add_new_event(map,marker,location[4]);
                if(locations.length>1) bounds.extend(myLatLng);
            }
        }

        if(locations.length>1)  map.fitBounds(bounds);
    };

    $.fn.add_new_event = function (map,marker,content) {

      if(content){
            var infowindow = new google.maps.InfoWindow({
                content: content,
                maxWidth: 300
            });
            google.maps.event.addListener(marker, 'click', function() {;
            infowindow.open(map,marker);
        });
      }
    };

    $.fn.fixTabs = function (map,map_id,zoom) {
        var tabs = $("#"+map_id).parents(".pxr_tabs:eq(0)"),
            desktop_nav_element = tabs.find("> .tab_nav > li"),
            mobile_nav_element = tabs.find("> .tab_contents > .tab_content_wrapper > .tab_title");

        desktop_nav_element.on("click",  { map: map } , function() {
            var c = map.getCenter();
            google.maps.event.trigger(map, 'resize');
            map.setZoom(zoom);
            map.setCenter(c);
        });

        mobile_nav_element.on("click",  { map: map } , function() {
            var c = map.getCenter();
            google.maps.event.trigger(map, 'resize');
            map.setZoom(zoom);
            map.setCenter(c);
        });
    };

    $.fn.fixAccordions = function (map,map_id,zoom) {
        var panes = $("#"+map_id).parents(".pxr-toggle:eq(0) > ol > li");

        panes.on("click",  { map: map } , function() {
            var c = map.getCenter();
            google.maps.event.trigger(map, 'resize');
            map.setZoom(zoom);
            map.setCenter(c);
        });
    }

}( jQuery ) );