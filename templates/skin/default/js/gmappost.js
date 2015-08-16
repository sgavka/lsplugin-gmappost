var ls = ls || {};

function createMap(config) {
    var mapTypeIds = [];
    var mapTypes = [];
    config.mapTypeIds.forEach(function (item, i, arr) {
        if (item == 'ROADMAP') {
            mapTypeIds.push(google.maps.MapTypeId.ROADMAP);
        } else if (item == 'SATELLITE') {
            mapTypeIds.push(google.maps.MapTypeId.SATELLITE);
        } else if (item == 'HYBRID') {
            mapTypeIds.push(google.maps.MapTypeId.HYBRID);
        } else if (item == 'TERRAIN') {
            mapTypeIds.push(google.maps.MapTypeId.TERRAIN);
        } else {
            mapTypeIds.push(item);

            tile = tileLayers[item];
            var mapType = new google.maps.ImageMapType({
                getTileUrl: function (coord, zoom) {
                    var link = tile.link;
                    link = link.replace('{z}', zoom);
                    link = link.replace('{x}', coord.x);
                    link = link.replace('{y}', coord.y);
                    return link;
                },
                tileSize: new google.maps.Size(256, 256),
                name: tile.name,
                maxZoom: 18
            });
            mapType.typeName = item;
            mapTypes.push(mapType);
        }
    });

    var mapTypeId;
    if (config.mapTypeId == 'ROADMAP') {
        mapTypeId = google.maps.MapTypeId.ROADMAP;
    } else if (config.mapTypeId == 'SATELLITE') {
        mapTypeId = google.maps.MapTypeId.SATELLITE;
    } else if (config.mapTypeId == 'HYBRID') {
        mapTypeId = google.maps.MapTypeId.HYBRID;
    } else if (config.mapTypeId == 'TERRAIN') {
        mapTypeId = google.maps.MapTypeId.TERRAIN;
    } else {
        mapTypeId = config.mapTypeId;
    }

    var mapConfig = {
        zoom: config.defaultZoom || 5,
        center: new google.maps.LatLng(config.defaultCenter.lat || 0, config.defaultCenter.lng || 0),
        //mapTypeControl: false, // map/sputnik
        streetViewControl: config.streetViewControl,
        panControl: config.panControl,
        scrollwheel: config.scrollwheel,
        mapTypeControlOptions: {
            mapTypeIds: mapTypeIds
        },
        mapTypeId: mapTypeId
    };

    var elementMap = document.getElementById(config.elementId);
    var elementInput = document.getElementById(config.elementInputId);
    if (elementMap) {
        map = new google.maps.Map(elementMap, mapConfig);

        mapTypes.forEach(function (item, i, arr) {
            map.mapTypes.set(item.typeName, item);
        });

        if (config.autocomplete) {
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(elementInput);

            var autocomplete = new google.maps.places.Autocomplete(elementInput);
            autocomplete.bindTo('bounds', map);

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                map.panTo(place.geometry.location);
                map.setZoom(config.autocompleteZoom);
            });
        }

        return map;
    }

    return false;
}

$(document).ready(function () {

    var map;
    var marker;
    var elementLat = $('.gmap-slow-showmap input[name=lat]');
    var elementLng = $('.gmap-slow-showmap input[name=lng]');
    var elementBtn = $("#gmap-btn");
    var elementShow = $('.gmap-slow-showmap');
    var elementInput = document.getElementById(pageTopicAdd.elementInputId);

    var elementMap = document.getElementById(pageTopicAdd.elementId);
    if (elementMap) {
        function setLatLng(location) {
            elementLat.val(location.lat());
            elementLng.val(location.lng());
        }

        function placeMarker(location) {
            if (marker instanceof google.maps.Marker) {
                marker.setMap(null);
            }

            marker = new google.maps.Marker({
                map: map,
                position: location,
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function (event) {
                setLatLng(event.latLng);
                map.panTo(event.latLng);

            });

            setLatLng(location);
            map.panTo(location);
        }

        function pageTopicAddInitialize() {
            map = createMap(pageTopicAdd);

            google.maps.event.addListener(map, 'click', function (event) {
                placeMarker(event.latLng)
            });

            // then init. if is set LatLng add marker
            if (!(marker instanceof google.maps.Marker) && elementLat.val() != 0 && elementLng.val() != 0) {
                placeMarker(new google.maps.LatLng(elementLat.val(), elementLng.val()));
            }
        }

        google.maps.event.addDomListener(window, 'load', pageTopicAddInitialize);

        $(elementInput).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        elementBtn.click(function () {
            if (elementShow.hasClass('active')) {
                elementShow.removeClass('active');
                setLatLng(new google.maps.LatLng(0, 0));
                elementBtn.text(ls.lang.get('plugin.gmappost.add_marker'));
            } else {
                elementShow.addClass('active');
                if (marker instanceof google.maps.Marker) {
                    setLatLng(marker.getPosition());
                }
                elementBtn.text(ls.lang.get('plugin.gmappost.delete_marker'));
            }
        });
    }
});

$(document).ready(function () {
    var elementMap = document.getElementById(pageMap.elementId);
    if (elementMap) {
        var map;
        var claster;
        var markers = [];

        function setMarks(marks) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];

            var iw = new google.maps.InfoWindow({
                content: ''
            });
            for (var i = 0; i < marks.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(marks[i].gps[0], marks[i].gps[1]),
                    title: marks[i].name,
                    map: map
                });

                var text = "<a target='_blank' href='" + marks[i].url + "'>" + marks[i].name + "</a>";
                marker.html = text;
                markers.push(marker);

                google.maps.event.addListener(markers[i], "click", function (e) {
                    iw.setContent(this.html);
                    iw.open(map, this);
                });
            }

            if (claster instanceof MarkerClusterer) {
                claster.clearMarkers();
                claster.addMarkers(markers);
            } else {
                var mcOptions = {gridSize: 50, maxZoom: 12};
                claster = new MarkerClusterer(map, markers, mcOptions);
            }
        }

        function getMarks(x1, y1, x2, y2) {
            $.ajax({
                url: aRouter.ajax + "g_map",
                method: 'post',
                data: {x1: x1, y1: y1, x2: x2, y2: y2, security_ls_key: LIVESTREET_SECURITY_KEY}
            }).success(function (result) {
                if (result.data) {
                    setMarks(result.data);
                }
            });
        }

        function pageMapInitialize() {
            map = createMap(pageMap);

            // bounds in changed
            google.maps.event.addListener(map, 'bounds_changed', function () {
                if (markers.length == 0) {
                    var marks = getMarks(
                        map.getBounds().getSouthWest().lat(),
                        map.getBounds().getSouthWest().lng(),
                        map.getBounds().getNorthEast().lat(),
                        map.getBounds().getNorthEast().lng()
                    );
                }
            });

            google.maps.event.addListener(map, 'dragend', function () {
                var marks = getMarks(
                    map.getBounds().getSouthWest().lat(),
                    map.getBounds().getSouthWest().lng(),
                    map.getBounds().getNorthEast().lat(),
                    map.getBounds().getNorthEast().lng()
                );
            });

            google.maps.event.addListener(map, 'zoom_changed', function () {
                var marks = getMarks(
                    map.getBounds().getSouthWest().lat(),
                    map.getBounds().getSouthWest().lng(),
                    map.getBounds().getNorthEast().lat(),
                    map.getBounds().getNorthEast().lng()
                );
            });
        }

        google.maps.event.addDomListener(window, 'load', pageMapInitialize);
    }

});