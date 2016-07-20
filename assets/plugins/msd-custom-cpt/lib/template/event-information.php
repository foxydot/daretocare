<?php global $wpalchemy_media_access,$wpdb; ?>
<?php
$all_locations = $wpdb->get_col("SELECT meta_value
    FROM $wpdb->postmeta WHERE meta_key = '_date_event_location'" );
    $location_values = array_unique($all_locations);
    asort($location_values);
    ?>
<div class="meta_control">
    <div class="table">
        <div class="row">
            <div class="cell">
                <?php $metabox->the_field('event_url'); ?>
                <label>Event URL</label>
                <div class="input_container half"><input type="text" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <?php $metabox->the_field('event_hover_color'); ?>
                <label>Hover Color</label>
                <div class="input_container half"><input class="colorpicker" type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></div>
            </div>
        </div>
        <div class="row">
            <div class="cell file">
            <label>Hover Image</label>
            <div class="input_container">
                <?php $mb->the_field('event_hover_image'); ?>
                <?php if($mb->get_the_value() != ''){
                    $thumb_array = wp_get_attachment_image_src( get_attachment_id_from_src($mb->get_the_value()), 'thumbnail' );
                    $thumb = $thumb_array[0];
                } else {
                    $thumb = WP_PLUGIN_URL.'/msd-specialty-pages/lib/img/spacer.gif';
                } ?>
                <img class="background-preview-img" src="<?php print $thumb; ?>">
                <?php $group_name = 'event_hover_img'. $mb->get_the_index(); ?>
                <?php $wpalchemy_media_access->setGroupName($group_name)->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
                <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
                <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <?php $metabox->the_field('event_start_datestamp'); ?>
                <input type="hidden" class="start_datestamp datestamp" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
                <label>Event Start</label>
                <?php $metabox->the_field('event_start_date'); ?>
                <div class="input_container half"><input type="text" class="datepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
                <?php $metabox->the_field('event_start_time'); ?>
                <div class="input_container half"><input type="text" class="timepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <?php $metabox->the_field('event_end_datestamp'); ?>
                <input type="hidden" class="end_datestamp datestamp" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
                <label>Event End</label>
                <?php $metabox->the_field('event_end_date'); ?>
                <div class="input_container half"><input type="text" class="datepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
                <?php $metabox->the_field('event_end_time'); ?>
                <div class="input_container half"><input type="text" class="timepicker" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(function($){
    $( ".datepicker" ).datepicker({
    onSelect : function(dateText, inst)
    {
        var epoch = $.datepicker.formatDate('@', $(this).datepicker('getDate')) / 1000;
        $(this).parents('.cell').find('.datestamp').val(epoch);
    }
    });
    $('.timepicker').timepicker({ 'scrollDefaultNow': true });
    $(".colorpicker").spectrum({
        preferredFormat: "rgb",
        showAlpha: true,
        showInput: true,
        allowEmpty: true,
    });
});

</script>