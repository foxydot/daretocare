jQuery(document).ready(function($) {
    $('select[name="map_radius"]').val('5').trigger('change');
    var search_html = '<div class="search"><input class="wpgmp_search_input_visible" type="text" placeholder="Enter address, city, and ZIP code" name="wpgmp_search_input" rel="24"><input class="wpgmp_search_input_submit" type="submit" value="submit"></div>';
    var radius_html = '<div class="radius"><select id="map_radius_visible" class="map_radius_visible">' + $('select[name="map_radius"]').html() + '</select></div>';
    $('.wpgmp_map_container .wpgmp_map').before('<div class="visible_search">' + search_html + radius_html + '</div>');
    $('#map_radius_visible').val('5');
    $('.wpgmp_map_container .wpgmp_map .wpgmp_tabs_container .wpgmp_tab_item:first-child .wpgmp_specific_category_item').prop('checked', true).trigger('change');
    $('.wpgmp_search_input_visible').change(function(){
        $('.wpgmp_search_input').val($(this).val());
    });
    $('.wpgmp_search_input_submit').click(function(){
        var firstdc = '';
        $('.wpgmp_search_input').val($('.wpgmp_search_input_visible').val()).trigger('keyup');    
        $('.wpgmp_map_container .wpgmp_map .wpgmp_tabs_container .wpgmp_tab_item:first-child .wpgmp_specific_category_item').prop('checked', true).trigger('change');
        $('select[name="map_radius"]').val($('#map_radius_visible').val()).trigger('change');
        $('select[name="map_perpage_location_sorting"]').val(50).trigger('change');
        var checkExist = setInterval(function() {
           if ($('.wpgmp_listing_list .iwlist.Distribution.Center:first a.place_title').length) {
                $('.wpgmp_listing_list .iwlist.Distribution.Center:first').wrap('<div class="firstdc"></div>');
                firstdc = $('.firstdc').html();
                clearInterval(checkExist);
                $('select[name="map_perpage_location_sorting"]').val(5).trigger('change');
                $('.wpgmp_listing_list .iwlist.Distribution.Center:first').remove();
                $('.wpgmp_listing_list').prepend(firstdc);
                $('.wpgmp_listing_list .iwlist:first-child a.place_title').trigger('click');
           }
        }, 100);
        
    });
    $('#map_radius_visible').change(function(){
        var firstdc = '';
        $('.wpgmp_search_input').val($('.wpgmp_search_input_visible').val()).trigger('keyup');    
        $('.wpgmp_map_container .wpgmp_map .wpgmp_tabs_container .wpgmp_tab_item:first-child .wpgmp_specific_category_item').prop('checked', true).trigger('change');
        $('select[name="map_radius"]').val($(this).val()).trigger('change');
        $('select[name="map_perpage_location_sorting"]').val(50).trigger('change');
        var checkExist = setInterval(function() {
           if ($('.wpgmp_listing_list .iwlist.Distribution.Center:first a.place_title').length) {
                $('.wpgmp_listing_list .iwlist.Distribution.Center:first').wrap('<div class="firstdc"></div>');
                firstdc = $('.firstdc').html();
                clearInterval(checkExist);
                $('select[name="map_perpage_location_sorting"]').val(5).trigger('change');
                $('.wpgmp_listing_list .iwlist.Distribution.Center:first').remove();
                $('.wpgmp_listing_list').prepend(firstdc);
                $('.wpgmp_listing_list .iwlist:first-child a.place_title').trigger('click');
           }
        }, 100);
    });
    $('.wpgmp_specific_category_item').click(function(){
        var firstdc = '';
        $('select[name="map_perpage_location_sorting"]').val(50).trigger('change');
        var checkExist = setInterval(function() {
           if ($('.wpgmp_listing_list .iwlist.Distribution.Center:first a.place_title').length) {
                $('.wpgmp_listing_list .iwlist.Distribution.Center:first').wrap('<div class="firstdc"></div>');
                firstdc = $('.firstdc').html();
                clearInterval(checkExist);
                $('select[name="map_perpage_location_sorting"]').val(5).trigger('change');
                $('.wpgmp_listing_list .iwlist.Distribution.Center:first').remove();
                $('.wpgmp_listing_list').prepend(firstdc);
                $('.wpgmp_listing_list .iwlist:first-child a.place_title').trigger('click');
           }
        }, 100);
    });
});