<?php 
global $wpalchemy_media_access; 
$fields = array(
        'state'=>'State',
        'data_year'=>'Data Year',
        'families_served'=>'Families Served',
        'people_served'=>'People Served',
        'meals'=>'Meals Provided',
        'pounds_food'=>'Pounds of Food',
        'pounds_produce'=>'Pounds of Fresh Produce',
        'percent_insecurity'=>'Percent of Food Insecurity',
        'insecure_individuals'=>'Number of Food Insecure Individuals',
        'pop_general'=>'Total Population',
        'percent_child_insecurity'=>'Percent of Child Food Insecurity',
        'insecure_children'=>'Number of Food Insecure Children',
        'pop_children'=>'Total Population of Children',
        'bio_name'=>'Bio Name',
        'bio_image'=>'Bio Image',
        'bio'=>'Bio Story'
    );
$states = array('AL'=>"Alabama",
        'AK'=>"Alaska",
        'AZ'=>"Arizona",
        'AR'=>"Arkansas",
        'CA'=>"California",
        'CO'=>"Colorado",
        'CT'=>"Connecticut",
        'DE'=>"Delaware",
        'DC'=>"District Of Columbia",
        'FL'=>"Florida",
        'GA'=>"Georgia",
        'HI'=>"Hawaii",
        'ID'=>"Idaho",
        'IL'=>"Illinois",
        'IN'=>"Indiana",
        'IA'=>"Iowa",
        'KS'=>"Kansas",
        'KY'=>"Kentucky",
        'LA'=>"Louisiana",
        'ME'=>"Maine",
        'MD'=>"Maryland",
        'MA'=>"Massachusetts",
        'MI'=>"Michigan",
        'MN'=>"Minnesota",
        'MS'=>"Mississippi",
        'MO'=>"Missouri",
        'MT'=>"Montana",
        'NE'=>"Nebraska",
        'NV'=>"Nevada",
        'NH'=>"New Hampshire",
        'NJ'=>"New Jersey",
        'NM'=>"New Mexico",
        'NY'=>"New York",
        'NC'=>"North Carolina",
        'ND'=>"North Dakota",
        'OH'=>"Ohio",
        'OK'=>"Oklahoma",
        'OR'=>"Oregon",
        'PA'=>"Pennsylvania",
        'RI'=>"Rhode Island",
        'SC'=>"South Carolina",
        'SD'=>"South Dakota",
        'TN'=>"Tennessee",
        'TX'=>"Texas",
        'UT'=>"Utah",
        'VT'=>"Vermont",
        'VA'=>"Virginia",
        'WA'=>"Washington",
        'WV'=>"West Virginia",
        'WI'=>"Wisconsin",
        'WY'=>"Wyoming");
?>

<ul class="location_meta_control">
    <li>
    <?php $metabox->the_field('state'); ?>
    <label id="<?php $metabox->the_name(); ?>_label" for="<?php $metabox->the_name(); ?>">State</label>
    <div class="ginput_container">
    <select tabindex="4" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>">
        <option value="">--SELECT--</option>
        <?php foreach($states AS $k =>$v){ ?>
            <option value="<?php print $v; ?>"<?php print $metabox->get_the_value()==$v?' SELECTED':''?>><?php print $v; ?></option>
        <?php } ?>
    </select>
    </div>
    </li>
    <?php $mb->the_field('data_year'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Year of this data</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('families_served'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Families Served</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('people_served'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">People Served</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('meals'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Meals Provided</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('pounds_food'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Pounds of Food (Total)</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('pounds_produce'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Pounds of Fresh Produce</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('percent_insecurity'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Percent of Food Insecurity</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('insecure_individuals'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Number of Food Insecure Individuals</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('pop_general'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Total Population</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('percent_child_insecurity'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Percent of Child Food Insecurity</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('insecure_children'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Number of Food Insecure Children</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('pop_children'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Total Population of Children</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('bio_name'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Bio Name</label>
    <div class="ginput_container">
            <div class="ginput_container"><input type="text" tabindex="5" value="<?php $metabox->the_value(); ?>" id="<?php $metabox->the_name(); ?>" name="<?php $metabox->the_name(); ?>"></div>
        </div>
    </li>
    <?php $mb->the_field('bio_image'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Bio Image</label>
        <div class="ginput_container"> 
    <?php if($mb->get_the_value() != ''){
                    $thumb_array = wp_get_attachment_image_src( get_attachment_id_from_src($mb->get_the_value()), 'thumbnail' );
                    $thumb = $thumb_array[0];
                } else {
                    $thumb = WP_PLUGIN_URL.'/msd-specialty-pages/lib/img/spacer.gif';
                } ?>
                <img class="preview-img" src="<?php print $thumb; ?>">
                <?php $group_name = 'bio_image'; ?>
                <?php $wpalchemy_media_access->setGroupName($group_name)->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
                <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
                <?php echo $wpalchemy_media_access->getButton(array('label' => '+')); ?>
        </div>
    </li>
    <?php $mb->the_field('bio'); ?>
    <li class="gfield" id="field_<?php $mb->the_name(); ?>"><label for="<?php $mb->the_name(); ?>"
        class="gfield_label">Bio Story</label>
    <div class="ginput_container">          
        
        <?php 
        $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
        $mb_editor_id = sanitize_key($mb->get_the_name());
        $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '10',);
        wp_editor( $mb_content, $mb_editor_id, $mb_settings );
        ?>
    </div>
    </li>
</ul>