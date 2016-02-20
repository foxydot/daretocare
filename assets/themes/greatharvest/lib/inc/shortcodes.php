<?php
add_shortcode('button','msdlab_button_function');
function msdlab_button_function($atts, $content = null){	
	extract( shortcode_atts( array(
      'url' => null,
	  'target' => '_self'
      ), $atts ) );
      if(strstr($url,'mailto:',0)){
          $parts = explode(':',$url);
          if(is_email($parts[1])){
              $url = $parts[0].':'.antispambot($parts[1]);
          }
      }
	$ret = '<div class="button-wrapper">
<a class="button" href="'.$url.'" target="'.$target.'">'.remove_wpautop($content).'</a>
</div>';
	return $ret;
}
add_shortcode('hero','msdlab_landing_page_hero');
function msdlab_landing_page_hero($atts, $content = null){
	$ret = '<div class="hero">'.remove_wpautop($content).'</div>';
	return $ret;
}
add_shortcode('callout','msdlab_landing_page_callout');
function msdlab_landing_page_callout($atts, $content = null){
	$ret = '<div class="callout">'.remove_wpautop($content).'</div>';
	return $ret;
}
function column_shortcode($atts, $content = null){
	extract( shortcode_atts( array(
	'cols' => '3',
	'position' => '',
	), $atts ) );
	switch($cols){
		case 5:
			$classes[] = 'one-fifth';
			break;
		case 4:
			$classes[] = 'one-fouth';
			break;
		case 3:
			$classes[] = 'one-third';
			break;
		case 2:
			$classes[] = 'one-half';
			break;
	}
	switch($position){
		case 'first':
		case '1':
			$classes[] = 'first';
		case 'last':
			$classes[] = 'last';
	}
	return '<div class="'.implode(' ',$classes).'">'.$content.'</div>';
}
add_shortcode('mailto','msdlab_mailto_function');
function msdlab_mailto_function($atts, $content){
    extract( shortcode_atts( array(
    'email' => '',
    ), $atts ) );
    $content = trim($content);
    if($email == '' && preg_match('|[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}|i', $content, $matches)){
        $email = $matches[0];
    }
    $email = antispambot($email);
    return '<a href="mailto:'.$email.'">'.$content.'</a>';
}

add_shortcode('columns','column_shortcode');

add_shortcode('sitemap','msdlab_sitemap');

add_shortcode('sitename','msdlab_sitename');

function msdlab_sitename(){
    return get_option('blogname');
}

add_shortcode('fa','msdlab_fontawesome_shortcodes');
function msdlab_fontawesome_shortcodes($atts){
    $classes[] = 'msd-fa fa';
    foreach($atts AS $att){
        switch($att){
            case "circle":
            case "square":
            case "block":
                $classes[] = $att;
                break;
            default:
                $classes[] = 'fa-'.$att;
                break;
        }
    }
    return '<i class="'.implode(" ",$classes).'"></i>';
}
add_shortcode('icon','msdlab_icon_shortcodes');
function msdlab_icon_shortcodes($atts){
    $classes[] = 'msd-icon icon';
    foreach($atts AS $att){
        switch($att){
            case "circle":
            case "square":
            case "block":
                $classes[] = $att;
                break;
            default:
                $classes[] = 'icon-'.$att;
                break;
        }
    }
    return '<i class="'.implode(" ",$classes).'"></i>';
}

add_shortcode('fb_code','fb_code_function');
function fb_code_function(){
    print('
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1385994154976512";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, \'script\', \'facebook-jssdk\'));</script>
    ');
}

add_shortcode('how-to-help-nav','how_to_help_shortcode_handler');
function how_to_help_shortcode_handler($atts){
    //the header
    $i=0;
    $helps = array(
        'funds' => array(
            'nav' => 'Give Funds',
            'ID' => '',
            'img' => 'slide-funds.jpg',
        ),
        'food' => array(
            'nav' => 'Give Food',
            'ID' => '',
            'img' => 'slide-food.jpg',
        ),
        'volunteer' => array(
            'nav' => 'Volunteer',
            'ID' => '',
            'img' => 'slide-volunteer.jpg',
        ),
        'drives' => array(
            'nav' => 'Food Drives',
            'ID' => '',
            'img' => 'slide-drives.jpg',
        ),
        'virtual' => array(
            'nav' => 'Virtual Food Drives',
            'ID' => '',
            'img' => 'slide-virtual.jpg',
        ),
    );
    foreach($helps AS $help){
        $state = $county->state;
        $active = $i==0?' active':'';
        $state_str = $state != $old_state?'<span class="state '.strtolower($state).'">'.$state.': </span>':'';
        $title_short = preg_replace('/\sCounty/i','',$county->post_title);
        $hdr .= '<li class="item-nav'.$active.'" data-target="#counties" data-slide-to="'.$i.'">'.$state_str.'<span class="county">'.$title_short.'</span></li>';
        $old_state = $state; $i++;
    }
    $hdr = '<ol class="carousel-indicators">'.$hdr.'</ol>';
    
    //the body
    $body = '';
    $i=0;
    foreach($counties AS $county){
        $active = $i==0?' active':'';
        $image_id = get_attachment_id_from_src($county->bio_image);
        $image = wp_get_attachment_image( $image_id, 'thumbnail' );
        $body .= '
        <div class="item'.$active.'">
            <div class="titles">
                <h3>Our Mission: Helping Those in Needs</h3>
                <h2>Hunger in '.$county->post_title.'</h2>
            </div>
            <div class="row">
              <div class="col-sm-4 people">
                <div class="icon icon-people"></div>
                <strong>'.$county->insecure_individuals.'</strong>
                people who lack the food to live a healthy life
              </div>
              <div class="col-sm-4 bio">
                <a href="'.get_post_permalink($county->ID).'#bio">
                '.$image.'
                <strong>Meet</strong>
                '.$county->bio_name.'
                </a>
              </div>
              <div class="col-sm-4 veggies">
                <div class="icon icon-veggies"></div>
                <strong>'.$county->pounds_food.'</strong>
                pounds of free food distributed to those in need in '.$county->data_year.'
              </div>
            </div>
        </div>';
        $i++;
    }
    
    $ret = '<div id="counties" class="carousel slide" data-interval="0" data-ride="carousel">
    '.$hdr.'
      <div class="carousel-inner" role="listbox">
      '.$body.'
      </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $(".counties").carousel({
              interval: 0
            })
        });
    </script>';
    return $ret;
}   
