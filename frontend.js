var lm_data = new Object();

function lm_initmap(div,lat,lng,zoom,title) {
    var data = {
        div: div,
        lat: lat,
        lng: lng,
        zoom: zoom,
        title: title
    };
    lm_data[div] = data;
}