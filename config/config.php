<?php

$config = array(
    'google_api_key' => 'AIzaSyAkUXI2Oo7bGD7wQFt5vkMw2_7_1mQHXos',
    'page' => array(
        'map' => array(
            'elementId' => 'gmap-map-page',
            'elementInputId' => 'gmap-input',
            'autocomplete' => true,
            'autocompleteZoom' => 8,
            'defaultZoom' => 4,
            'defaultCenter' => array(
                'lat' => 47.7540,
                'lng' => 19.4238,
            ),
            'mapTypeIds' => array('ROADMAP', 'OSM', 'SATELLITE'), // from plugin.gmappost.tile_layers (typeName) or/and
            // The following map types are available in the Google Maps API:
            // ROADMAP -- displays the default road map view. This is the default map type.
            // SATELLITE -- displays Google Earth satellite images
            // HYBRID -- displays a mixture of normal and satellite views
            // TERRAIN -- displays a physical map based on terrain information.
            'mapTypeId' => 'ROADMAP',
            'streetViewControl' => false,
            'panControl' => false,
        ),
        'topicAdd' => array(
            'elementId' => 'gmap-map-topic',
            'elementInputId' => 'gmap-input',
            'autocomplete' => true,
            'autocompleteZoom' => 8,
            'defaultZoom' => 3,
            'defaultCenter' => array(
                'lat' => 47.7540,
                'lng' => 19.4238,
            ),
            'mapTypeIds' => array('ROADMAP', 'OSM', 'SATELLITE'),
            'mapTypeId' => 'ROADMAP',
            'streetViewControl' => false,
            'panControl' => false,
        ),
    ),
    'tile_layers' => array(
        'OSM' => array(
            'name' => 'Mapnik',
            'link' => 'http://tile.openstreetmap.org/{z}/{x}/{y}.png',
        ),
        'BAW' => array(
            'name' => 'Black and white',
            'link' => 'http://tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png',
        ),
        'OCM' => array(
            'name' => 'OpenCycleMap',
            'link' => 'http://tile.thunderforest.com/cycle/{z}/{x}/{y}.png',
        ),
    ),
);

Config::Set('router.page.map', 'PluginGmappost_ActionMap');


return $config;