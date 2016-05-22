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
function how_to_help_shortcode_handler($atts, $content){
    //the header
    $helps = array(
        'funds' => array(
            'nav' => 'Give Funds',
            'ID' => '37',
            'img' => 'slide-funds.jpg',
        ),
        'food' => array(
            'nav' => 'Give Food',
            'ID' => '8',
            'img' => 'slide-food.jpg',
        ),
        'volunteer' => array(
            'nav' => 'Volunteer',
            'ID' => '34',
            'img' => 'slide-volunteer.jpg',
        ),
        'drives' => array(
            'nav' => 'Host a Food/Funds Drive',
            'ID' => '35',
            'img' => 'slide-drives.jpg',
        ),/*
        'virtual' => array(
            'nav' => 'Virtual Food Drives',
            'ID' => '',
            'img' => 'slide-virtual.jpg',
        ),*/
    );
    $i=0;
    foreach($helps AS $help){
        $active = $i==0?' active':'';
        $hdr .= '<li class="item-nav'.$active.'" slide="'.$i.'"><a href="'.get_permalink($help[ID]).'">'.$help['nav'].'</a></li>';
        $i++;
    }
    $hdr = '<ol class="carousel-indicators">'.$hdr.'</ol>';
    
    //the body
    $body = '';
    $i=0;
    foreach($helps AS $help){
        $active = $i==0?' active':'';
        $body .= '
        <div class="item'.$active.'">
            <a href="'.get_permalink($help[ID]).'" style="background-image:url('.get_stylesheet_directory_uri().'/lib/img/howToHelpSlides/'.$help['img'].');"> 
                <img src="'.get_stylesheet_directory_uri().'/lib/img/spacer.gif" />
            </a>
        </div>';
        $i++;
    }
    
    $ret = '<div id="help" class="carousel slide">
      <div class="carousel-inner" role="listbox">
      '.$body.'
      </div>
    '.$hdr.'
    </div>
    <script>
        jQuery(document).ready(function($) {
            $("#help").carousel({
              interval: 5000
            });
            $("#help .item-nav").mouseenter(function(){
                $("#help").carousel(Number($(this).attr(\'slide\')));
            });
        });
    </script>';
    return $ret;
}   
