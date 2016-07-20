<?php
if (!class_exists('MSDInvolvedShortcodes')) {
    class MSDInvolvedShortcodes {
        //Properties
        var $cpt = 'involved';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDInvolvedShortcodes(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            add_shortcode('get-involved', array(&$this,'get_involved'));
            add_shortcode('get_involved', array(&$this,'get_involved'));
        }
        
        function get_involved($atts){
            global $date_info;
            extract( shortcode_atts( array(
                'months' => '120',
                'number_posts' => 4,
                'display' => 'grid',
            ), $atts ) );
            $args = array(
                'posts_per_page' => $number_posts,
                'post_type' => $this->cpt,
            );
            //ts_data($args);
            $involveds = get_posts($args);
            //ts_data($involveds);
            $i = 0;
            foreach($involveds AS $up){
                $date_info->the_meta($up->ID);
                if($date_info->get_the_value('involved_start_date') && $date_info->get_the_value('involved_end_date')){
                    if($date_info->get_the_value('involved_start_datestamp') == $date_info->get_the_value('involved_end_datestamp')){
                        $involveds[$i]->involved_date = date( "M d, Y",$date_info->get_the_value('involved_end_datestamp'));
                    } else {
                        $involveds[$i]->involved_date = date( "M d, Y",$date_info->get_the_value('involved_start_datestamp')).'<br />to<br />'.date( "M d, Y",$date_info->get_the_value('involved_end_datestamp'));
                    }
                } elseif($date_info->get_the_value('involved_start_date')) {
                    $involveds[$i]->involved_date = date( "M d, Y",$date_info->get_the_value('involved_start_datestamp'));
                } elseif($date_info->get_the_value('involved_end_date')) {
                    $involveds[$i]->involved_date = date( "M d, Y",$date_info->get_the_value('involved_end_datestamp'));
                } else {
                    $involveds[$i]->involved_date = '';
                }
                if($date_info->get_the_value('involved_start_time')!='' && $date_info->get_the_value('involved_end_time')!=''){
                    if($date_info->get_the_value('involved_start_time') == $date_info->get_the_value('involved_end_time')){
                        $involveds[$i]->involved_date .= '<br />'.$date_info->get_the_value('involved_end_time');
                    } else {
                        $involveds[$i]->involved_date .= '<br />'.$date_info->get_the_value('involved_start_time').' to '.$date_info->get_the_value('involved_end_time');
                    }
                } elseif($date_info->get_the_value('involved_start_time')!='') {
                    $involveds[$i]->involved_date .= '<br />'.$date_info->get_the_value('involved_start_time');
                } elseif($date_info->get_the_value('involved_end_time')!='') {
                    $involveds[$i]->involved_date .= '<br />'.$date_info->get_the_value('involved_end_time');
                } else {
                    $involveds[$i]->involved_date .= '';
                }
                $involveds[$i]->involved_date_start = $date_info->get_the_value('involved_start_date')?$date_info->get_the_value('involved_start_datestamp'):1609372800;
                $involveds[$i]->involved_date_end = $date_info->get_the_value('involved_end_date')?$date_info->get_the_value('involved_end_datestamp'):1609372800;
                $involveds[$i]->url = $date_info->get_the_value('involved_url');
                $involveds[$i]->hover = $date_info->get_the_value('involved_hover_color');
                $involveds[$i]->hover_img = $date_info->get_the_value('involved_hover_image');
                $involveds[$i]->title = $up->post_title;
                $i++;
            }
            $ret = '<div class="msdlab_upcoming_involveds grid row">';
            if ( !empty( $involveds ) ):
                
            if($display == 'carousel'):
                $ret .= '
                <div data-ride="carousel" class="msd_upcoming_involved_list carousel slide" id="msdUpcomingEventCarousel">
                <h3 class="pull-left">Upcoming Events:</h3>
                <div class="carousel-controls">
                 <a data-slide="prev" role="button" href="#msdUpcomingEventCarousel" class="left carousel-control">
            <span aria-hidden="true" class="fa fa-arrow-circle-o-left"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a data-slide="next" role="button" href="#msdUpcomingEventCarousel" class="right carousel-control">
            <span aria-hidden="true" class="fa fa-arrow-circle-o-right"></span>
            <span class="sr-only">Next</span>
          </a>
          </div>
          <div role="listbox" class="carousel-inner">
                    ';
                    $i = 0;
                foreach ( $involveds as $involved ):
                    $active = $i==0?' active':'';
                $ret .= '
                <div class="item'.$active.'" id="involved_'.$involved->ID.'">
                    <div class="involved-title">'.$involved->title.'</div>
                    <div class="involved-date">'.date( "M d, Y", $involved->involved_date ).'</div>
               </div>';
               $i++;
                endforeach;
                    $ret .= '
                    </div>
                    <a href="'.get_post_type_archive_link($this->cpt).'" class="pull-right">View All Events</a>
                    </div>';
                else: //$display == carousel
                    foreach ( $involveds as $key => $involved ):
                        $overlay_img = '';
                        if($involved->hover_img!=''){
                            $overlay_img = 'background-image: url('.$involved->hover_img.');';
                        }
                        $bkg = get_post_thumbnail_id($involved->ID)!=''?'style="background-image: url('.msdlab_get_thumbnail_url($involved->ID,'small-square').')"':'';
                    $ret .= '
                    <div class="item item-'.$key.' grid-item col-md-6" id="involved_'.$involved->ID.'">
                        <a href="'.$involved->url.'" class="link" '.$bkg.'>
                        <div class="overlay" style="background-color: '.$involved->hover.';'.$overlay_img.'">
                            &nbsp;
                        </div>
                        <div class="wrapper">
                            <div class="involved-title">'.$involved->title.'</div>
                            <i class="fa fa-angle-right"></i>
                        </div>
                        </a>
                   </div>';
                    endforeach;
                endif; //$display == carousel
            else:
                $ret .= '<p>No Get Involved</p>';
            endif;
            $ret .= '</div>';
            return $ret;
        }
        
        function sort_by_involved_date( $a, $b ) {
            return $a->involved_date == $b->involved_date ? 0 : ( $a->involved_date > $b->involved_date ) ? 1 : -1;
        }
    }
}