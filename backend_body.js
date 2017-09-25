$(function() {
    "use strict";

    // remove select2 from select boxes to keep functionality
    if(typeof $.fn.select2 == 'function') {
       $('form[name="lm_modify_marker"] select').select2("destroy");
    }

    $('input[name="defzoom"]').on('change', function(e) {
        $(this).next('span').html($(this).val());
    });

    $('div.lm_search button.lm_submit').on('click', function(e) {
        var section_id = $(this).data('id');
        lm_addr_search( section_id, $(this).parent().find('input[name="lm_addr"]').val(), '' );
    });

    $('a.lm-marker-id').unbind('click').on('click', function(e) {
        e.preventDefault();
        $('.fa_select').asIconPicker('clear');
        var section = $(this).data('section');
        var div = "lm__"+section+"_div";
        var map = lm_maps.div;
        var lat = $(this).parent().parent().find('td.marker-latlng').find('span.marker-lat').text().trim();
        var lng = $(this).parent().parent().find('td.marker-latlng').find('span.marker-lng').text().trim();
        if($(this).data('glyph')!='') {
            $('form[name="lm_modify_marker"] .asIconPicker-selected-icon').html('<i class="fa fa-'+$(this).data('glyph')+'" /> '+$(this).data('glyph'));
            $('form[name="lm_modify_marker"] .asIconPicker-selected-icon').removeClass('asIconPicker-none-selected');
        }
        $('form[name="lm_modify_marker"] select[name="marker_icon"] option:selected').prop("selected",false);
        $('form[name="lm_modify_marker"] select[name="marker_icon"] option[value="' + $(this).parent().parent().find('img').data('url') + '"]').prop("selected",true);
        $('form[name="lm_modify_marker"] img').attr('src', $(this).parent().parent().find('img').attr('src') );
        $('form[name="lm_modify_marker"] input[name="marker_id"]').val($(this).data('marker-id'));
        $('form[name="lm_modify_marker"] input[name="marker_name"]').val($(this).parent().next('td.marker-name').text().trim());
        $('form[name="lm_modify_marker"] input[name="marker_latitude"]').val(lat);
        $('form[name="lm_modify_marker"] input[name="marker_longitude"]').val(lng);
        $('form[name="lm_modify_marker"] input[name="marker_active"]').prop('checked', false);
        $('form[name="lm_modify_marker"] input[name="marker_active"][value="'+$(this).data('marker-active')+'"]').attr('checked', 'checked');
        $('form[name="lm_modify_marker"] textarea').html($(this).parent().find('span.lm-desc').text().trim());
        $('form[name="lm_modify_marker"] input[name="marker_url"]').val($(this).parent().find('span.lm-url').text().trim());
        lm_addr_set(lat, lng, '', div);
    });

    $('form[name="lm_modify_marker"] select[name="marker_icon"]').on('change', function(e) {
        var selected = $(this).find('option:selected');
        var newsrc   = WB_URL + selected.data('baseurl') + '/' + selected.text().trim();
        $(this).next('img').attr('src', newsrc );
    });

    $('form[name="lm_modify_marker"] input[type="reset"]').on('click', function(e) {
        $('form[name="lm_modify_marker"] input[name="marker_id"]').val('');
        $('form[name="lm_modify_marker"] textarea').html('');
        var img = $('form[name="lm_modify_marker"] select[name="marker_icon"]').next('img');
        var selected = $('form[name="lm_modify_marker"] select[name="marker_icon"] option:nth(0)');
        var newsrc   = WB_URL + selected.data('baseurl') + '/' + selected.text().trim();
        img.attr('src', newsrc );
        $('.fa_select').asIconPicker('clear');
    });

    $('form[name="lm_modify_marker"]').on('submit',function() {
        $('input[name="marker_glyph"]').val($('span.asIconPicker-selected-icon i').attr('class').replace('fa ','').replace('fa-',''));
    });
});