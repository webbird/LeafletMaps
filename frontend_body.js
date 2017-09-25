$(function() {
    "use strict";

    function lm_fill_map() {
        deferred_lm_initmap(lm_div,lm_lat,lm_lng,lm_zoom,lm_title);
        $('div.lm_map.leaflet-container').each( function() {
            var section = $(this).data('section');
            $.get( WB_URL + "/modules/LeafletMaps/marker.php?section_id="+section, function( data, textStatus, jqxhr ) {
                var div = "lm__"+section+"_div";
                var map = lm_maps.div;
                var icons = {};
                var classes = {};
                for ( var i=0; i < data.length; ++i )
                {
                    var c_id  = data[i].class_id;
                    var i_id  = data[i].icon_id;
                    var glyph = 'fw';
                    if(typeof classes["class_"+c_id] == 'undefined') {
                        classes["class_"+c_id] = L.Icon.Glyph.extend({
                            options: {
                                shadowUrl:    WB_URL + data[i].baseUrl + "/" + data[i].shadowUrl,
                                iconSize:     [data[i].iconWidth       , data[i].iconHeight        ],
                                shadowSize:   [data[i].shadowWidth     , data[i].shadowHeight      ],
                                iconAnchor:   [data[i].iconAnchorLeft  , data[i].iconAnchorBottom  ],
                                shadowAnchor: [data[i].shadowAnchorLeft, data[i].shadowAnchorBottom],
                                glyphAnchor:  [data[i].glyphAnchorLeft , data[i].glyphAnchorBottom ],
                                prefix:       'fa',
                                glyphColor:   data[i].glyphColor
                            }
                        });
                    }
                    if(data[i]['glyph'] != '') {
                        glyph = data[i]['glyph'];
                    }
                    icons["icon_"+i_id+"_"+i] = new classes["class_"+c_id]({
                        iconUrl: WB_URL + data[i].baseUrl + "/" + data[i].iconUrl,
                        glyph: glyph
                    });
                    // create marker
                    var marker = L.marker([
                        data[i].latitude,
                        data[i].longitude
                    ], {
                        icon: icons["icon_"+i_id+"_"+i]
                    });
                    // bind popup
                    if(data[i]['popup'] != '') {
                        marker.bindPopup(
                            L.popup({
                                autoPan: false
                            })
                            .setContent(data[i]['popup'])
                            .setLatLng(data[i].latitude,data[i].longitude)
                        );
                    }
                    // add marker to map
                    map.addControl(marker);
                }
            }, "json" );
        });
    }

    if(typeof CAT_URL == 'undefined') { // WBCE
        $.getScript( WB_URL + "/modules/LeafletMaps/js/leaflet.min.js", function( data, textStatus, jqxhr ) {
            $.getScript( WB_URL + "/modules/LeafletMaps/js/Leaflet.Icon.Glyph.js", function( data, textStatus, jqxhr ) {
                $.getScript( WB_URL + "/modules/LeafletMaps/js/map.js", function( data, textStatus, jqxhr ) {
                    lm_fill_map();
                });
            });
        });
    } else {
        lm_fill_map();
    }
});
