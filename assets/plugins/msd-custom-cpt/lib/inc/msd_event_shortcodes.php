<?php
if (!class_exists('MSDEventShortcodes')) {
    class MSDEventShortcodes {
        //Properties
        var $cpt = 'event';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDEventShortcodes(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            add_shortcode('upcoming-events', array(&$this,'upcoming_events'));
            add_shortcode('upcoming_events', array(&$this,'upcoming_events'));
        }
        
        function upcoming_events($atts){
            global $date_info;
            extract( shortcode_atts( array(
                'months' => '24',
                'number_posts' => 6,
                'display' => 'grid',
            ), $atts ) );
            $args = array(
                'posts_per_page' => $number_posts,
                'post_type' => $this->cpt,
                'meta_query' => array(
                    array(
                        'key' => '_date_event_end_datestamp',
                        'value' => time()-86400,
                        'compare' => '>'
                    ),
                    array(
                        'key' => '_date_event_end_datestamp',
                        'value' => mktime(0, 0, 0, date("m")+$months, date("d"), date("Y")),
                        'compare' => '<'
                    )
                ),
                'meta_key' => '_date_event_end_datestamp',
                'orderby'=>'meta_value_num',
                'order'=>'ASC',
            );
            //ts_data($args);
            $events = get_posts($args);
            //ts_data($events);
            $i = 0;
            foreach($events AS $up){
                $date_info->the_meta($up->ID);
                if($date_info->get_the_value('event_start_date') && $date_info->get_the_value('event_end_date')){
                    if($date_info->get_the_value('event_start_datestamp') == $date_info->get_the_value('event_end_datestamp')){
                        $events[$i]->event_date = date( "M d, Y",$date_info->get_the_value('event_end_datestamp'));
                    } else {
                        $events[$i]->event_date = date( "M d, Y",$date_info->get_the_value('event_start_datestamp')).'<br />to<br />'.date( "M d, Y",$date_info->get_the_value('event_end_datestamp'));
                    }
                } elseif($date_info->get_the_value('event_start_date')) {
                    $events[$i]->event_date = date( "M d, Y",$date_info->get_the_value('event_start_datestamp'));
                } elseif($date_info->get_the_value('event_end_date')) {
                    $events[$i]->event_date = date( "M d, Y",$date_info->get_the_value('event_end_datestamp'));
                } else {
                    $events[$i]->event_date = '';
                }
                if($date_info->get_the_value('event_start_time')!='' && $date_info->get_the_value('event_end_time')!=''){
                    if($date_info->get_the_value('event_start_time') == $date_info->get_the_value('event_end_time')){
                        $events[$i]->event_date .= '<br />'.$date_info->get_the_value('event_end_time');
                    } else {
                        $events[$i]->event_date .= '<br />'.$date_info->get_the_value('event_start_time').' to '.$date_info->get_the_value('event_end_time');
                    }
                } elseif($date_info->get_the_value('event_start_time')!='') {
                    $events[$i]->event_date .= '<br />'.$date_info->get_the_value('event_start_time');
                } elseif($date_info->get_the_value('event_end_time')!='') {
                    $events[$i]->event_date .= '<br />'.$date_info->get_the_value('event_end_time');
                } else {
                    $events[$i]->event_date .= '';
                }
                $events[$i]->event_date_start = $date_info->get_the_value('event_start_date')?$date_info->get_the_value('event_start_datestamp'):1609372800;
                $events[$i]->event_date_end = $date_info->get_the_value('event_end_date')?$date_info->get_the_value('event_end_datestamp'):1609372800;
                $events[$i]->url = $date_info->get_the_value('event_url');
                $events[$i]->hover = $date_info->get_the_value('event_hover_color');
                $events[$i]->hover_img = $date_info->get_the_value('event_hover_image');
                $events[$i]->title = $up->post_title;
                $i++;
            }
            $ret = '<div class="msdlab_upcoming_events grid row">';
            if ( !empty( $events ) ):
                
            if($display == 'carousel'):
                $ret .= '
                <div data-ride="carousel" class="msd_upcoming_event_list carousel slide" id="msdUpcomingEventCarousel">
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
                foreach ( $events as $event ):
                    $active = $i==0?' active':'';
                $ret .= '
                <div class="item'.$active.'" id="event_'.$event->ID.'">
                    <div class="event-title">'.$event->title.'</div>
                    <div class="event-date">'.date( "M d, Y", $event->event_date ).'</div>
               </div>';
               $i++;
                endforeach;
                    $ret .= '
                    </div>
                    <a href="'.get_post_type_archive_link($this->cpt).'" class="pull-right">View All Events</a>
                    </div>';
                else: //$display == carousel
                    foreach ( $events as $key => $event ):
                        $overlay_img = '';
                        if($event->hover_img!=''){
                            $overlay_img = 'background-image: url('.$event->hover_img.');';
                        }
                        $bkg = get_post_thumbnail_id($event->ID)!=''?'style="background-image: url('.msdlab_get_thumbnail_url($event->ID,'small-square').')"':'';
                        $wrapper = '<div class="wrapper">
                            <div class="event-title">'.$event->title.'</div>
                            <i class="fa fa-angle-right"></i>
                        </div>';
                    $ret .= '
                    <div class="item item-'.$key.' grid-item col-md-6" id="event_'.$event->ID.'">
                        <a href="'.$event->url.'" class="link" '.$bkg.'>
                        ';
                    if($event->hover_img!=''){$ret .= $wrapper;}
                    $ret .= '<div class="overlay" style="background-color: '.$event->hover.';'.$overlay_img.'">
                            &nbsp;
                        </div>';
                    if($event->hover_img==''){$ret .= $wrapper;}
                    $ret .= '
                        </a>
                   </div>';
                    endforeach;
                endif; //$display == carousel
            else:
                $ret .= '<p>No Upcoming Events</p>';
            endif;
            $ret .= '</div>';
            return $ret;
        }
        
        function sort_by_event_date( $a, $b ) {
            return $a->event_date == $b->event_date ? 0 : ( $a->event_date > $b->event_date ) ? 1 : -1;
        }
    }
}