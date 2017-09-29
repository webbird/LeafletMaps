var lm_maps = new Object();

function deferred_lm_initmap(div,lat,lng,zoom,title) {
    var map;
	// set up the map
	map = new L.Map(div);
	// create the tile layer with correct attribution
    L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        subdomains: ['a','b','c']
    }).addTo( map );
    // center map on default lat/lng
    var latlng = L.latLng(lat,lng);
    map.setView(latlng, zoom);
    // save map
    lm_maps.div = map;
}

function lm_addr_search(section_id,value) {
    $.getJSON('https://nominatim.openstreetmap.org/search?format=json&limit=5&q=' + value, function(data) {
        var map_div_id = "lm__" + section_id + "_mapid";
        var appendTo = $('div[data-id="'+section_id+'"] div.lm_results span');
        var items = [];
        $.each(data, function(key, val) {
            items.push(
                "<li><a href='#' data-lng='" + val.lon + "' data-lat='" + val.lat + "'>" + val.display_name + '</a></li>'
            );
        });
        $(appendTo).empty();
        if (items.length != 0) {
            $('<ul/>', {'class': 'lm-search-results',html: items.join('')}).appendTo(appendTo);
            $('ul.lm-search-results li a').on('click', function(e) {
                var lng  = $(this).data('lng');
                var lat  = $(this).data('lat');
                var name = $(this).text();
                lm_addr_set(lat,lng,name,map_div_id);
            });

        } else {
            $('<p>', { html: "No results found" }).appendTo(appendTo);
        }
        appendTo.parent().show();
    });
}

function lm_addr_set(lat, lng, name, div) {
    var map = lm_maps.div;
    var location = new L.LatLng(lat, lng);
    map.panTo(location);
    L.marker(location).addTo(map);
    $('#'+div).attr('data-lng',lng);
    $('#'+div).attr('data-lat',lat);
    $('#'+div).next('div.lm_search').find('button.lm_take').show();
    $('#'+div).next('div.lm_search').find('button.lm_take').on('click', function(e) {
        $('input.lm_lng').val(lng);
        $('input.lm_lat').val(lat);
        if($('input[name="marker_name"]').length && $('input[name="marker_name"]').val() == '') {
            $('input[name="marker_name"]').val(name);
        }
    });

}