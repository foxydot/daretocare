<?php 
if (!class_exists('MSDCountyCPT')) {
    class MSDCountyCPT {
        //Properties
        var $cpt = 'county';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDCountyCPT(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
            //Actions
            add_action( 'init', array(&$this,'register_cpt_county') );
            add_action('admin_head', array(&$this,'plugin_header'));
            add_action('admin_print_scripts', array(&$this,'add_admin_scripts') );
            add_action('admin_print_styles', array(&$this,'add_admin_styles') );
            add_action('admin_footer',array(&$this,'info_footer_hook') );
            // important: note the priority of 99, the js needs to be placed after tinymce loads
            add_action('admin_print_footer_scripts',array(&$this,'admin_print_footer_scripts'),99);
            add_action('template_redirect',array(&$this,'add_scripts'));
            
            //Filters
            add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_filter( 'enter_title_here', array(&$this,'change_default_title') );
            
            add_shortcode('county_data', array(&$this, 'county_data_shortcode_handler'));
            
            add_action('genesis_after_entry', array(&$this,'county_data_bio_display'));
        }

        function register_cpt_county() {
        
            $labels = array( 
                'name' => _x( 'Countys', 'county' ),
                'singular_name' => _x( 'County', 'county' ),
                'add_new' => _x( 'Add New', 'county' ),
                'add_new_item' => _x( 'Add New County', 'county' ),
                'edit_item' => _x( 'Edit County', 'county' ),
                'new_item' => _x( 'New County', 'county' ),
                'view_item' => _x( 'View County', 'county' ),
                'search_items' => _x( 'Search County', 'county' ),
                'not_found' => _x( 'No county found', 'county' ),
                'not_found_in_trash' => _x( 'No county found in Trash', 'county' ),
                'parent_item_colon' => _x( 'Parent County:', 'county' ),
                'menu_name' => _x( 'County', 'county' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'County',
                'supports' => array( 'title', 'editor', 'author', ),
                'taxonomies' => array( ),
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
                'rewrite' => array('slug'=>'county','with_front'=>false),
                'capability_type' => 'post'
            );
        
            register_post_type( $this->cpt, $args );
        }
        
        function plugin_header() {
            global $post_type;
            ?>
            <?php
        }
        
        function add_scripts() {
            global $post;
            if(is_cpt($this->cpt)){
                wp_register_script('chartjs', plugin_dir_url(dirname(__FILE__)).'js/chart.min.js', array('jquery'),0,0);
                wp_enqueue_script('chartjs');
            }
        }
         
        function add_admin_scripts() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                wp_register_script('my-upload', plugin_dir_url(dirname(__FILE__)).'js/msd-upload-file.js', array('jquery','media-upload','thickbox'),FALSE,TRUE);
                wp_enqueue_script('my-upload');
            }
        }
        
        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_style('thickbox');
                wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'css/meta.css');
            }
        }   
            
        function admin_print_footer_scripts()
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
                return __('County Title','county');
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
        

        function custom_query( $query ) {
            if(!is_admin()){
                $is_county = ($query->query_vars['state'])?TRUE:FALSE;
                if($query->is_main_query() && $query->is_search){
                    $searchterm = $query->query_vars['s'];
                    // we have to remove the "s" parameter from the query, because it will prevent the posts from being found
                    $query->query_vars['s'] = "";
                    
                    if ($searchterm != "") {
                        $query->set('meta_value',$searchterm);
                        $query->set('meta_compare','LIKE');
                    };
                    $query->set( 'post_type', array('post','page',$this->cpt) );
                    //ts_data($query);
                }
                elseif( $query->is_main_query() && $query->is_archive ) {
                    $query->set( 'post_type', array('post','page',$this->cpt) );
                }
            }
        }     
        
        function county_data_shortcode_handler($atts){
            global $post,$county_data;
            extract($atts = shortcode_atts( array(
                'key' => '',
                'county_id' => $post->ID,
            ), $atts ));
            $county_data->the_meta($county_id);
            switch($key){
                case 'insecurity_charts':
                    $ret = '<div class="pie-charts row">
                        <div class="col-sm-6 col-xs-12 row">
                            <h4>Food Insecurity</h4>
                            <div class="col-xs-6 chart">
                                <canvas id="insecurity-chart-area" width="120"/>
                            </div>
                            <div class="col-xs-6 data">
                                <strong class="percentage">'.$county_data->get_the_value('percent_insecurity').'%</strong>
                                of '.$post->post_title.'\'s population or '.$county_data->get_the_value('insecure_individuals').' individuals
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 row">
                            <h4>Child Food Insecurity</h4>
                            <div class="col-xs-6 chart">
                                <canvas id="child-insecurity-chart-area" width="120"/>
                            </div>
                            <div class="col-xs-6 data">
                                <strong class="percentage">'.$county_data->get_the_value('percent_child_insecurity').'%</strong>
                                of '.$post->post_title.'\'s population or '.$county_data->get_the_value('insecure_children').' children
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        var totalData = [
                            {
                                value: '.$county_data->get_the_value('percent_insecurity').',
                                color:"#A02515",
                                highlight: "#A02515",
                                label: "Insecure"
                            },
                            {
                                value: '.(100-$county_data->get_the_value('percent_insecurity')).',
                                color: "#C4C5C7",
                                highlight: "#C4C5C7",
                                label: "Total"
                            }
                        ];
                        var childData = [
                            {
                                value: '.$county_data->get_the_value('percent_child_insecurity').',
                                color:"#A02515",
                                highlight: "#A02515",
                                label: "Insecure"
                            },
                            {
                                value: '.(100-$county_data->get_the_value('percent_child_insecurity')).',
                                color: "#C4C5C7",
                                highlight: "#C4C5C7",
                                label: "Total"
                            }
                        ];
                        window.onload = function(){
                            var ctx1 = document.getElementById("insecurity-chart-area").getContext("2d");
                            window.myPie = new Chart(ctx1).Pie(totalData);
                            var ctx2 = document.getElementById("child-insecurity-chart-area").getContext("2d");
                            window.myPie = new Chart(ctx2).Pie(childData);
                        };
                    </script>';
                    break;
                case 'distribution_charts':
                    $ret = '<div class="distribution-charts row">
                        <div class="col-sm-6 col-xs-12 row">
                            <div class="col-xs-6 chart">
                                <i class="icon icon-plate"></i>
                            </div>
                            <div class="col-xs-6 data">
                                <strong class="served">'.$county_data->get_the_value('meals').'%</strong>
                                meals provided to hungry neighbors in '.$post->post_title.' in '.$county_data->get_the_value('data_year').'
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 row">
                            <div class="col-xs-6 chart">
                                <i class="icon icon-apple"></i>
                            </div>
                            <div class="col-xs-6 data">
                                <strong class="served">'.$county_data->get_the_value('pounds_produce').'%</strong>
                                pounds of free produce distributed in '.$post->post_title.' in '.$county_data->get_the_value('data_year').'
                            </div>
                        </div>
                    </div>';
                    break;
                default:
                    if(strlen($county_data->get_the_value($key)>0)){
                        $ret = $county_data->get_the_value($key);
                    } else {
                        $ret = '_____';
                    }
            }
            return $ret;
        }      
        
        function county_data_bio_display(){
            if(is_cpt('county')){
                global $post,$county_data;
                $county_data->the_meta();
                $image_id = get_attachment_id_from_src($county_data->get_the_value('bio_image'));
                $image = wp_get_attachment_image( $image_id, 'biopic' );
                $ret = '<div class="bio">
                '.$image.'
                <h3>'.$county_data->get_the_value('bio_name').'\'s Story</h3>
                <div class="story">
                '.$county_data->get_the_value('bio').'
                </div>
                </div>';
                print $ret;
            }
        }
  } //End Class
} //End if class exists statement