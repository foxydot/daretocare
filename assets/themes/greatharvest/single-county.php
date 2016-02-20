<?php
add_action('genesis_after_header','greatharvest_county_title');
function greatharvest_county_title(){
    ?>
    <div class="page-title-area" id="page-title-area">
        <div class="wrap">
            <h1 itemprop="headline" class="entry-title">Helping those in need.</h1> 
        </div>
    </div>
    <?php
}
add_filter('genesis_post_title_text','greatharvest_page_title_filter');
function greatharvest_page_title_filter($title){
    $title = 'Hunger in '.$title;
    return $title;
}
genesis();
