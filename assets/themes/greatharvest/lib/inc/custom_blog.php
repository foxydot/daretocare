<?php
add_action('genesis_before_loop','msdlab_replace_generic_loop');

function msdlab_replace_generic_loop(){
    if(is_home()){
        remove_action('genesis_loop','genesis_do_loop');
        add_action('genesis_loop','msdlab_custom_loop_by_cat');
        remove_action('genesis_entry_content','genesis_do_post_content');
        add_action('genesis_entry_content','the_excerpt');
    }
}

function msdlab_custom_loop_by_cat(){
    
    global $wp_query, $more;
    
    $cats = get_categories(array(
    'orderby' => 'name',
    'parent'  => 11,//0
    ));
    if(class_exists('Su_Shortcodes')){
        print '<div class="su-accordion">';
    }
    foreach($cats AS $cat){
        $subcats = get_categories(array(
            'orderby' => 'name',
            'parent'  => $cat->term_id
            ));
        if(count($subcats)==0){
        $args = array(
            'cat'              => $cat->term_id,
            'showposts'        => 3,
        );
        $wp_query = new WP_Query( $args );
        
        //* Use old loop hook structure if not supporting HTML5
        if ( ! genesis_html5() ) {
            genesis_legacy_loop();
            return;
        }
    
        if ( have_posts() ) :
            if(class_exists('Su_Shortcodes')){
                print '<div class="su-spoiler su-spoiler-style-default su-spoiler-icon-plus even su-spoiler-closed" data-anchor="accordion-'.$cat->slug.'">
                <div class="su-spoiler-title">
                <span class="su-spoiler-icon"></span>
                '.$cat->name.'
                </div>
                <div class="su-spoiler-content su-clearfix"><div class="articles">';
            }
            while ( have_posts() ) : the_post();
    
                do_action( 'genesis_before_entry' );
    
                printf( '<article %s>', genesis_attr( 'entry' ) );
    
                    do_action( 'genesis_entry_header' );
    
                    do_action( 'genesis_before_entry_content' );
    
                    printf( '<div %s>', genesis_attr( 'entry-content' ) );
                    do_action( 'genesis_entry_content' );
                    echo '</div>';
    
                    do_action( 'genesis_after_entry_content' );
    
                    do_action( 'genesis_entry_footer' );
    
                echo '</article>';
    
                do_action( 'genesis_after_entry' );
    
            endwhile; //* end of one post
            if(class_exists('Su_Shortcodes')){
                print '</div>';
                print '<a href="'.get_category_link($cat->term_id).'" class="related">More Related Articles</a>';
                print '</div>';
                print '</div>';
            }
            
        endif; //* end loop
        } else {
            if(class_exists('Su_Shortcodes')){
                print '<div class="su-spoiler su-spoiler-style-default su-spoiler-icon-plus even su-spoiler-closed" data-anchor="accordion-'.$cat->slug.'">
                <div class="su-spoiler-title">
                <span class="su-spoiler-icon"></span>
                '.$cat->name.'
                </div>
                <div class="su-spoiler-content su-clearfix">';
            }
            foreach($subcats AS $subcat){
                $args = array(
                    'cat'              => $subcat->term_id,
                    'showposts'        => 8,
                );
                $wp_query = new WP_Query( $args );
                if ( have_posts() ) :
                    if(class_exists('Su_Shortcodes')){
                        print '<div class="su-spoiler su-spoiler-style-default su-spoiler-icon-plus even su-spoiler-closed" data-anchor="accordion-'.$subcat->slug.'">
                        <div class="su-spoiler-title">
                        <span class="su-spoiler-icon"></span>
                        '.$subcat->name.'
                        </div>
                        <div class="su-spoiler-content su-clearfix">';
                    }
                    while ( have_posts() ) : the_post();
            
                        do_action( 'genesis_before_entry' );
            
                        printf( '<article %s>', genesis_attr( 'entry' ) );
            
                            do_action( 'genesis_entry_header' );
            
                            do_action( 'genesis_before_entry_content' );
            
                            printf( '<div %s>', genesis_attr( 'entry-content' ) );
                            do_action( 'genesis_entry_content' );
                            echo '</div>';
            
                            do_action( 'genesis_after_entry_content' );
            
                            do_action( 'genesis_entry_footer' );
            
                        echo '</article>';
            
                        do_action( 'genesis_after_entry' );
            
                    endwhile; //* end of one post
                    if(class_exists('Su_Shortcodes')){
                        print '</div></div>';
                    }
                    
                endif; //* end loop
            }
            if(class_exists('Su_Shortcodes')){
                print '</div></div>';
            }
        }
    }
    if(class_exists('Su_Shortcodes')){
        print '</div>';
        print do_shortcode('[su_spoiler class="hidden"]');
    }
}
