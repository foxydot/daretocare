jQuery(document).ready(function($) {
    var search_html = '<div class="search"><input class="wpgmp_search_input_visible" type="text" placeholder="Enter address, city, or ZIP code" name="wpgmp_search_input" rel="24"><input class="wpgmp_search_input_submit" type="submit" value="submit"></div>';
    var radius_html = '<div class="radius"><select id="map_radius_visible" class="map_radius_visible">' + $('select[name="map_radius"]').html() + '</select></div>';
    $('.wpgmp_map_container .wpgmp_map').before('<div class="visible_search">' + search_html + radius_html + '</div>');
    $('.wpgmp_map_container .wpgmp_map .wpgmp_tabs_container .wpgmp_tab_item:first-child .wpgmp_specific_category_item').prop('checked', true).trigger('change');
    $('.wpgmp_search_input_visible').change(function(){
        $('.wpgmp_search_input').val($(this).val());
    });
    $('.wpgmp_search_input_submit').click(function(){
        $('.wpgmp_search_input').val($('.wpgmp_search_input_visible').val()).trigger('keyup');
    });
    $('#map_radius_visible').change(function(){
        $('select[name="map_radius"]').val($(this).val()).trigger('change');
    });
});