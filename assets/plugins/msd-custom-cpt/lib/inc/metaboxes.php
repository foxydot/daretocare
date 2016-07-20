<?php 
global $county_data;

$county_data = new WPAlchemy_MetaBox(array
        (
            'id' => '_county_data',
            'title' => 'County Data',
            'types' => array('county'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/county-data.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_county_' // defaults to NULL
        ));