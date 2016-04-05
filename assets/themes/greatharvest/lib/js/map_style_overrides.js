jQuery(document).ready(function($) {
    $('.wpgmp_map_container .wpgmp_map .wpgmp_tabs_container').before('<div class="visible_search"><input class="wpgmp_search_input_visible" type="text" placeholder="Enter address or latitude or longitude or title or city or state or country or postal code here..." name="wpgmp_search_input" rel="24"></div>');
    $('.wpgmp_search_input_visible').change(function(){
        $('.wpgmp_search_input').val($(this).val());
    });
});