<?php
add_filter('wpgmp_map_output','msdlab_add_map_override_js');
function msdlab_add_map_override_js($output){
    wp_enqueue_script('msd-map',get_stylesheet_directory_uri().'/lib/js/map_style_overrides.js',array('jquery'),'',TRUE);
    return $output;
}
