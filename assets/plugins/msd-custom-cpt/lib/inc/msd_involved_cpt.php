<?php 
if (!class_exists('MSDInvolvedCPT')) {
    class MSDInvolvedCPT {
        //Properties
        var $cpt = 'involved';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDInvolvedCPT(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
            //Actions
            add_action( 'init', array(&$this,'register_cpt_involved') );
            add_action( 'init', array(&$this,'register_metaboxes') );
            add_action('admin_head', array(&$this,'plugin_header'));
            add_action('admin_enqueue_scripts', array(&$this,'add_admin_scripts') );
            add_action('admin_enqueue_scripts', array(&$this,'add_admin_styles') );
            add_action('admin_footer',array(&$this,'info_footer_hook') );
            // important: note the priority of 99, the js needs to be placed after tinymce loads
            add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
            add_action('template_redirect', array(&$this,'my_theme_redirect'));
            add_action('admin_head', array(&$this,'codex_custom_help_tab'));
            
            //Filters
            add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_filter( 'enter_title_here', array(&$this,'change_default_title') );
            
            add_image_size('sponsor',275,120,FALSE);
            add_action('genesis_entry_header',array(&$this,'display_involved_info'),40);
            
            if(class_exists('MSDInvolvedShortcodes')){
                $this->involved_shortcodes = new MSDInvolvedShortcodes();
            }
        }
       
        function register_cpt_involved() {
        
            $labels = array( 
                'name' => _x( 'Get Involved', 'involved' ),
                'singular_name' => _x( 'Get Involved', 'involved' ),
                'add_new' => _x( 'Add New', 'involved' ),
                'add_new_item' => _x( 'Add New Get Involved', 'involved' ),
                'edit_item' => _x( 'Edit Get Involved', 'involved' ),
                'new_item' => _x( 'New Get Involved', 'involved' ),
                'view_item' => _x( 'View Get Involved', 'involved' ),
                'search_items' => _x( 'Search Get Involved', 'involved' ),
                'not_found' => _x( 'No Get Involved found', 'involved' ),
                'not_found_in_trash' => _x( 'No Get Involved found in Trash', 'involved' ),
                'parent_item_colon' => _x( 'Parent Get Involved:', 'involved' ),
                'menu_name' => _x( 'Get Involved', 'involved' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'Get Involved',
                'supports' => array( 'title', 'thumbnail' ),
                'taxonomies' => array('involved_type', 'involved_category' ),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                
                'show_in_nav_menus' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => true,
                'has_archive' => true,
                'query_var' => true,
                'can_export' => true,
                'rewrite' => array('slug'=>'involved','with_front'=>false),
                'capability_type' => 'post'
            );
        
            register_post_type( $this->cpt, $args );
        }

        function codex_custom_help_tab() {
            global $current_screen;
            if($current_screen->post_type != $this->cpt)
            return;
        
          // Setup help tab args.
          $args = array(
            'id'      => 'title', //unique id for the tab
            'title'   => 'Title', //unique visible title for the tab
            'content' => '<h3>The Program Title</h3>
                          <p>The title of the program.</p>
                          <h3>The Permalink</h3>
                          <p>The permalink is created by the title, but it doesn\'t change automatically if you change the title. To change the permalink when editing an involved, click the [Edit] button next to the permalink. 
                          Remove the text that becomes editable and click [OK]. The permalink will repopulate with the new Location and date!</p>
                          ',  //actual help text
          );
          
          // Add the help tab.
          $current_screen->add_help_tab( $args );
          
          // Setup help tab args.
          $args = array(
            'id'      => 'involved_info', //unique id for the tab
            'title'   => 'Program Info', //unique visible title for the tab
            'content' => '<h3>Program URL</h3>
                          <p>The link to the page describing the program.</p>'
          );
          
          // Add the help tab.
          $current_screen->add_help_tab( $args );
        
        }
        
        function plugin_header() {
            global $post_type;
            ?>
            <?php
        }
         
        function add_admin_scripts() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-datepicker');
                wp_enqueue_script('jquery-ui-button');
                wp_enqueue_script('jquery-ui-autocomplete');
                wp_enqueue_script('jquery-ui-tooltip');
                wp_enqueue_script('jquery-timepicker',plugin_dir_url(dirname(__FILE__)).'/js/jquery.timepicker.min.js',array('jquery'));
                wp_enqueue_script('my-upload');                
                wp_enqueue_script('spectrum',plugin_dir_url(dirname(__FILE__)).'/js/spectrum.js',array('jquery'));
                
            }
        }
        
        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_style('thickbox');
                wp_enqueue_style('jquery-ui-style','//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css');
                wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'/css/meta.css');
                wp_enqueue_style('spectrum',plugin_dir_url(dirname(__FILE__)).'/css/spectrum.css');
            }
        }   
            
        function print_footer_scripts()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                print '<script type="text/javascript">/* <![CDATA[ */
                    jQuery(function($)
                    {
                        var i=1;
                        $(\'.customEditor textarea\').each(function(e)
                        {
                            var id = $(this).attr(\'id\');
             
                            if (!id)
                            {
                                id = \'customEditor-\' + i++;
                                $(this).attr(\'id\',id);
                            }
             
                            tinyMCE.execCommand(\'mceAddControl\', false, id);
             
                        });
                    });
                /* ]]> */</script>';
            }
        }
        function change_default_title( $title ){
            global $current_screen;
            if  ( $current_screen->post_type == $this->cpt ) {
                return __('Get Involved Title','involved');
            } else {
                return $title;
            }
        }
        
        function info_footer_hook()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                ?><script type="text/javascript">
                        jQuery('#postdivrich').before(jQuery('#_contact_info_metabox'));
                    </script><?php
            }
        }
        
        function my_theme_redirect() {
            global $wp;
        
            //A Specific Custom Post Type
            if ($wp->query_vars["post_type"] == $this->cpt) {
                $templatefilename = 'single-'.$this->cpt.'.php';
                if (file_exists(STYLESHEETPATH . '/' . $templatefilename)) {
                    $return_template = STYLESHEETPATH . '/' . $templatefilename;
                } else {
                    $return_template = plugin_dir_path(dirname(__FILE__)). 'template/' . $templatefilename;
                }
                do_theme_redirect($return_template);
            } 
        }

        function custom_query( $query ) {
            if(!is_admin()){
                $post_types = $query->query_vars['post_type'];
                if($query->is_main_query() && $query->is_search){
                    if(is_array($query->query_vars['post_type'])){
                    $searchterm = $query->query_vars['s'];
                    // we have to remove the "s" parameter from the query, because it will prevent the posts from being found
                    //$query->query_vars['s'] = "";
                    
                    if ($searchterm != "") {
                        $query->set('meta_value',$searchterm);
                        $query->set('meta_compare','LIKE');
                    };
                    $post_types[] = $this->cpt;
                    $query->set( 'post_type', $post_types );
                    }
                }
                elseif( $query->is_main_query() && $query->is_archive && !$query->query_vars['product_cat'] ) {
                    $post_types[] = $this->cpt;
                    $query->set( 'post_type', $post_types );
                }
            }
        }           
        
        function register_metaboxes(){
            global $date_info,$location_info,$involved_info;
            
            $date_info = new WPAlchemy_MetaBox(array
                    (
                        'id' => '_date_information',
                        'title' => 'Get Involved Info',
                        'types' => array($this->cpt),
                        'context' => 'normal',
                        'priority' => 'high',
                        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/involved-information.php',
                        'autosave' => TRUE,
                        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
                        'prefix' => '_date_' // defaults to NULL
                    ));
        }

        function display_involved_info(){
            global $post,$date_info;
            if(is_single() && is_cpt($this->cpt)){
                $date_info->the_meta($post->ID);
                if($date_info->get_the_value('involved_start_date') && $date_info->get_the_value('involved_end_date')){
                    if($date_info->get_the_value('involved_start_datestamp') == $date_info->get_the_value('involved_end_datestamp')){
                        $involved_date = date( "M d, Y",$date_info->get_the_value('involved_end_datestamp'));
                    } else {
                        $involved_date = date( "M d, Y",$date_info->get_the_value('involved_start_datestamp')).' to '.date( "M d, Y",$date_info->get_the_value('involved_end_datestamp'));
                    }
                } elseif($date_info->get_the_value('involved_start_date')) {
                    $involved_date = date( "M d, Y",$date_info->get_the_value('involved_start_datestamp'));
                } elseif($date_info->get_the_value('involved_end_date')) {
                    $involved_date = date( "M d, Y",$date_info->get_the_value('involved_end_datestamp'));
                } else {
                    $involved_date = '';
                }
                if($date_info->get_the_value('involved_start_time')!='' && $date_info->get_the_value('involved_end_time')!=''){
                    if($date_info->get_the_value('involved_start_time') == $date_info->get_the_value('involved_end_time')){
                        $involved_time = $date_info->get_the_value('involved_end_time');
                    } else {
                        $involved_time = $date_info->get_the_value('involved_start_time').' to '.$date_info->get_the_value('involved_end_time');
                    }
                } elseif($date_info->get_the_value('involved_start_time')!='') {
                    $involved_time = $date_info->get_the_value('involved_start_time');
                } elseif($date_info->get_the_value('involved_end_time')!='') {
                    $involved_time = $date_info->get_the_value('involved_end_time');
                } else {
                    $involved_time = '';
                }
                $venue = $date_info->get_the_value('venue');
                $title = $post->post_title;
                print '<h3>'.$involved_date.' '.$involved_time.'</h3>';
                print '<h4>'.$venue.'</h4>';
            }
        }
  } //End Class
} //End if class exists statement