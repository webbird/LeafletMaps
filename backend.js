var lm_div;
var lm_lat;
var lm_lng;
var lm_zoom;
var lm_title;

function lm_initmap(div,lat,lng,zoom,title) {
    lm_div = div;
    lm_lat = lat;
    lm_lng = lng;
    lm_zoom = zoom;
    lm_title = title;
}

$(function() {
    "use strict";
    if(typeof CAT_URL == 'undefined') { // WBCE
        $.getScript( WB_URL + "/modules/LeafletMaps/js/leaflet.min.js", function( data, textStatus, jqxhr ) {
            $.getScript( WB_URL + "/modules/LeafletMaps/js/map.js", function( data, textStatus, jqxhr ) {
                deferred_lm_initmap(lm_div,lm_lat,lm_lng,lm_zoom,lm_title);
            });
            $.getScript( WB_URL +"/modules/LeafletMaps/js/jquery-asTooltip.min.js", function( data, textStatus, jqxhr ) {
                $.getScript( WB_URL +"/modules/LeafletMaps/js/jquery-asScrollbar.min.js", function( data, textStatus, jqxhr ) {
                    $.getScript( WB_URL +"/modules/LeafletMaps/js/jquery-asIconPicker.min.js", function( data, textStatus, jqxhr ) {
                        $('.fa_select').asIconPicker({handleLength: '5px'});
                        $('.asIconPicker-list li').unbind('click').on('click', function (e) {
                            var glyph = $(e.currentTarget).attr('title');
                            $('input[name="marker_glyph"]').val(glyph);
                        });
                    });
                });
            });
        });
    } else {
        deferred_lm_initmap(lm_div,lm_lat,lm_lng,lm_zoom,lm_title);
        $('.fa_select').asIconPicker({handleLength: '5px'});
        $('.asIconPicker-list li').unbind('click').on('click', function (e) {
            var glyph = $(e.currentTarget).attr('title');
            $('input[name="marker_glyph"]').val(glyph);
        });
    }
});