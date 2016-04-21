<?php
add_filter('wpgmp_map_output','msdlab_add_map_override_js');
function msdlab_add_map_override_js($output){
    wp_enqueue_script('msd-map',get_stylesheet_directory_uri().'/lib/js/map_style_overrides.js',array('jquery'),'',TRUE);
    return $output;
}
if(class_exists('Google_Maps_Pro')){
    add_shortcode('directions','msdlab_directions_handler');
    function msdlab_directions_handler($atts){
        global $post;
        extract( shortcode_atts( array(
        'destination' => '',
        ), $atts ) );
        //$current_location = wp_is_mobile()?'&saddr=Current+Location':'';
        $current_location = '&saddr=Current+Location';
        $link = 'https://maps.google.com/?daddr=' . $destination . $current_location;
        return '<a href="' . $link . '" class="directions" target="_google_maps">Get directions</a>';
    }
}
