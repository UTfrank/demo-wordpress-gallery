<?php
// this file is loaded in the modal window of tinyMCE
global $wp_version, $wpdb, $wp_post_types;
if (!empty($this->social_gallery_plugin_data)) {
    $social_gallery_plugin_data = $this->social_gallery_plugin_data;
} else {
    $social_gallery_plugin_data[0] = false;
}
$settings = $this->settings;
$custom_presets = $this->custom_presets;
foreach ($this as $key => $value) {
    $this->{$key} = null;
    unset($this->{$key});
}
$key = $value = null;
unset($key, $value);

$dotmin = '.min';
$plugin_version = '4.6';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title><?php _e('Justified Image Grid shortcode editor', 'jig_td'); ?></title>

    <link rel="stylesheet" href="<?php echo plugins_url('css/jig-sce' . $dotmin . '.css?ver=' . $plugin_version, __FILE__); ?>" />
    <style type="text/css">
        #fbIcon {
            background-image: url("<?php echo plugins_url('images/facebook-icon.png', __FILE__); ?>");
        }

        #fliIcon {
            background-image: url("<?php echo plugins_url('images/flickr-icon.png', __FILE__); ?>");
        }

        #igIcon {
            background-image: url("<?php echo plugins_url('images/instagram-icon.png', __FILE__); ?>");
        }

        #fbLoadingInner,
        #fliLoadingInner,
        #igLoadingInner {
            background-image: url("<?php echo plugins_url('images/ajax-loader.gif', __FILE__); ?>");
        }

        #jig-sc-editor-loading {
            background-image: url("<?php echo plugins_url('images/ajax-loader.gif', __FILE__); ?>");
        }
    </style>
    <!--[if IE]> <style type='text/css'>
            .fbAlbumCount, .fbMouseIndicator, .fbLoadingIndicator, .fliElementCount, .fliMouseIndicator, .fliLoadingIndicator, .fbAlbumTitle, .fliElementTitle { background:transparent; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000); zoom: 1; }
            .fbLoadingAJAX, .fliLoadingAJAX, .igLoadingAJAX, { background:transparent; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#CCF7F7F7,endColorstr=#CCF7F7F7); zoom: 1; }
         </style> <![endif]-->

</head>

<body>
    <div id="jig-sc-editor" style="display:none;">
        <form action="/" method="get" accept-charset="utf-8">
            <div id="inputShortcodeBlock" class="clearfix">
                <div id="shortcodeLabel"><?php _e('Enter shortcode to edit (optional)', 'jig_td'); ?>:</div>
                <input type="text" name="inputShortcode" id="inputShortcode" value='' />
            </div>
            <div id="jigTabs" class="clearfix">
                <div class="tabHeadings"><?php _e('Settings', 'jig_td'); ?>:</div>
                <div class="JIGupdateButton tabButton selectedTabButton" id="jigTabGeneralSettings"><?php _e('General settings', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabLoadMore"><?php _e('Load more', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabFiltering"><?php _e('Filtering', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabLightboxes"><?php _e('Lightboxes', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabCaptions"><?php _e('Captions', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabOverlayEffects"><?php _e('Overlay effects', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabSpecialEffects"><?php _e('Special effects', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabTemplateTag"><?php _e('Template Tag', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabShortcode"><?php _e('Shortcode', 'jig_td'); ?></div>

                <div class="tabHeadings"><?php _e('Sources', 'jig_td'); ?>:</div>
                <div class="JIGupdateButton tabButton" id="jigTabNextGEN"><?php _e('NextGEN', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabRML"><?php _e('WP RML', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabRecentPosts"><?php _e('Recent posts', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabFacebook"><?php _e('Facebook', 'jig_td'); ?></div>
                <div class="JIGupdateButton tabButton" id="jigTabFlickr"><?php _e('Flickr', 'jig_td'); ?></div>
                <!--<div class="JIGupdateButton tabButton" id="jigTabInstagram"><?php _e('Instagram', 'jig_td'); ?></div>-->
                <div class="JIGupdateButton tabButton" id="jigTabRSS"><?php _e('RSS', 'jig_td'); ?></div>


            </div>

            <h3 class="jigTabTitle selectedTab" id="jigGeneralSettings"><?php _e('General settings', 'jig_td'); ?></h3>
            <div id="jig_general_settings_tab_content" class="jigSettingsTab selectedTab jig_settings_group clearfix">

                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e("Override the Plugin Settings or choose/extend a saved JIG", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('JIG Gallery', 'jig_td'); ?></div>
                    <label>gallery</label>
                    <select name="gallery" class="long_select">
                        <option value="default" selected="selected"><?php _e('Start fresh', 'jig_td'); ?></option>
<?php

$jigs_as_options = '';
$jigs_list = get_posts([
    'post_status' => 'any',
    'post_type' => 'justified-image-grid',
    'numberposts' => -1
]);
if (!empty($jigs_list)) {
    foreach ($jigs_list as $single_jig) {
        $jigs_as_options .= '<option value="' . $single_jig->ID . '">' . $single_jig->post_title . ' (#' . $single_jig->ID . ')</option>';
    }
}

echo $jigs_as_options;
$jigs_as_options = $single_jig = $jigs_list = null;
unset($jigs_as_options, $single_jig, $jigs_list);

?>
                    </select>


                    <div class="minihelp minihelpShort"><?php _e('You can choose an existing grid for this shortcode. Feel free to use it as a base.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Preset', 'jig_td'); ?></div>
                    <label>preset</label>
                    <select name="preset" class="long_select">
                        <option value="default" selected="selected"><?php _e('Global settings', 'jig_td'); ?></option>
<?php

if (!empty($custom_presets) && count($custom_presets) > 1) {
    $custom_presets_output = '<optgroup label="' . __('Custom presets', 'jig_td') . '">';
    foreach ($custom_presets as $custom_preset_index => $custom_preset) {
        if ($custom_preset_index > 0) {
            $custom_presets_output .= '<option value="c' . $custom_preset_index . '">' . $custom_preset['preset_name'] . '</option>';
        }
    }
    $custom_presets_output .= '</optgroup>';
    echo $custom_presets_output;
}

?>
                        <optgroup label="<?php _e('Built-in presets', 'jig_td'); ?>">
                            <option value="1"><?php _e('Preset 1: Out of the box', 'jig_td'); ?></option>
                            <option value="2"><?php _e("Preset 2: Author's favorite", 'jig_td'); ?></option>
                            <option value="3"><?php _e('Preset 3: Flickr style', 'jig_td'); ?></option>
                            <option value="4"><?php _e('Preset 4: Google style', 'jig_td'); ?></option>
                            <option value="5"><?php _e('Preset 5: Fixed height, no fancy', 'jig_td'); ?></option>
                            <option value="6"><?php _e('Preset 6: Artistic-zen', 'jig_td'); ?></option>
                            <option value="7"><?php _e('Preset 7: Color magic fancy style', 'jig_td'); ?></option>
                            <option value="8"><?php _e('Preset 8: Big images no click', 'jig_td'); ?></option>
                            <option value="9"><?php _e('Preset 9: Focus on the text', 'jig_td'); ?></option>
                            <option value="10"><?php _e('Preset 10: Hidden', 'jig_td'); ?></option>
                            <option value="11"><?php _e('Preset 11: Magnifier blur', 'jig_td'); ?></option>
                            <option value="12"><?php _e("Preset 12: Author's other favorite", 'jig_td'); ?></option>
                            <option value="13"><?php _e('Preset 13: Orton effect', 'jig_td'); ?></option>
                            <option value="14"><?php _e('Preset 14: Animated border and glow', 'jig_td'); ?></option>
                            <option value="15"><?php _e('Preset 15: Borders and shadow', 'jig_td'); ?></option>
                            <option value="16"><?php _e('Preset 16: Facebok inspired', 'jig_td'); ?></option>
                            <option value="17"><?php _e('Preset 17: Vertical center', 'jig_td'); ?></option>
                            <option value="18"><?php _e('Preset 18: Vertical creative', 'jig_td'); ?></option>
                            <option value="19"><?php _e('Preset 19: Caption fun, gray background', 'jig_td'); ?></option>
                            <option value="20"><?php _e('Preset 20: Caption below the thumbs', 'jig_td'); ?></option>
                        </optgroup>
                    </select>
                    <div class="minihelp minihelpShort"><?php _e('Choose a built-in or a custom preset.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Mobile preset', 'jig_td'); ?></div>
                    <label>mobile_preset</label>
                    <select name="mobile_preset" class="long_select">
                        <option value="default" selected="selected"><?php _e('Same as desktop', 'jig_td'); ?></option>
<?php

if (!empty($custom_presets_output)) {
    echo $custom_presets_output;
    $custom_presets_output = null;
    unset($custom_presets_output);
}

?>
                        <optgroup label="<?php _e('Built-in presets', 'jig_td'); ?>">
                            <option value="1"><?php _e('Preset 1: Out of the box', 'jig_td'); ?></option>
                            <option value="2"><?php _e("Preset 2: Author's favorite", 'jig_td'); ?></option>
                            <option value="3"><?php _e('Preset 3: Flickr style', 'jig_td'); ?></option>
                            <option value="4"><?php _e('Preset 4: Google style', 'jig_td'); ?></option>
                            <option value="5"><?php _e('Preset 5: Fixed height, no fancy', 'jig_td'); ?></option>
                            <option value="6"><?php _e('Preset 6: Artistic-zen', 'jig_td'); ?></option>
                            <option value="7"><?php _e('Preset 7: Color magic fancy style', 'jig_td'); ?></option>
                            <option value="8"><?php _e('Preset 8: Big images no click', 'jig_td'); ?></option>
                            <option value="9"><?php _e('Preset 9: Focus on the text', 'jig_td'); ?></option>
                            <option value="10"><?php _e('Preset 10: Hidden', 'jig_td'); ?></option>
                            <option value="11"><?php _e('Preset 11: Magnifier blur', 'jig_td'); ?></option>
                            <option value="12"><?php _e("Preset 12: Author's other favorite", 'jig_td'); ?></option>
                            <option value="13"><?php _e('Preset 13: Orton effect', 'jig_td'); ?></option>
                            <option value="14"><?php _e('Preset 14: Animated border and glow', 'jig_td'); ?></option>
                            <option value="15"><?php _e('Preset 15: Borders and shadow', 'jig_td'); ?></option>
                            <option value="16"><?php _e('Preset 16: Facebok inspired', 'jig_td'); ?></option>
                            <option value="17"><?php _e('Preset 17: Vertical center', 'jig_td'); ?></option>
                            <option value="18"><?php _e('Preset 18: Vertical creative', 'jig_td'); ?></option>
                            <option value="19"><?php _e('Preset 19: Caption fun, gray background', 'jig_td'); ?></option>
                            <option value="20"><?php _e('Preset 20: Caption below the thumbs', 'jig_td'); ?></option>
                        </optgroup>
                    </select>
                    <div class="minihelp minihelpShort"><?php _e('Choose an entirely different preset for mobile devices, you likely want to use a custom preset.', 'jig_td'); ?></div>
                </div>
                <div class="flexirow">
                    <div class="longHelp"><?php _e('Note: Using a preset causes this instance to disregard global settings that are blue in the <strong>preset authority</strong> of the Justified Image Grid settings. If you need settings like lightboxes to be global (regardless of preset) change them to orange there.  Any setting can be used differently for mobile users, if you choose a mobile preset. Certain common settings have a mobile variant for quicker setup without the need of a mobile preset.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('WordPress image sources - Media Library', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('IDs', 'jig_td'); ?></div>
                    <label>ids</label>
                    <input type="text" name="ids" id="ids" value='' autocomplete="off" />
                    <div class="minihelp">
                        <button id="imagePicker" type="button"></button>
<?php

_e('Image IDs, accepts ranges too.', 'jig_td');
echo ' ';
_e('Use * for all images.', 'jig_td');

?>
                    </div>
                </div>

                <div class="row">
                    <div class="normalName"><?php _e('Exclude these images', 'jig_td'); ?></div>
                    <label>exclude</label>
                    <input type="text" name="exclude" value='' />
                    <div class="minihelp"><?php _e('This is only used when you display images attached to the post/page. You can get the ID by looking at the Permalink of each image in the Media Library. Add them here, separated by a comma. For example: 21,featured,652 (you can use the word "featured").', 'jig_td'); ?></div>
                </div>
<?php

$attachment_taxonomies = get_object_taxonomies('attachment', 'objects');
if (!empty($attachment_taxonomies)) {
    ?>
                    <div class="row">
                        <div class="normalName"><?php _e('Image categories', 'jig_td'); ?></div>
                        <label>image_categories</label>
                        <input type="text" name="image_categories" value='' />
                        <div class="minihelp"><?php _e('Enter category slugs, comma separated. Can be narrowed by combining with the "Image tags" setting.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Image tags', 'jig_td'); ?></div>
                        <label>image_tags</label>
                        <input type="text" name="image_tags" value='' />
                        <div class="minihelp"><?php _e('Enter tag slugs, comma separated. Can be narrowed by "Image categories".', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Image taxonomy', 'jig_td'); ?></div>
                        <label>image_taxonomy</label>
                        <select name="image_taxonomy">
                            <option value="default" selected="selected"><?php _e('No taxomony.', 'jig_td'); ?></option>
<?php

    $ml_taxonomies_as_options = '';
    foreach ($attachment_taxonomies as $attachment_taxonomy_name => $attachment_taxonomy_value) {
        $ml_taxonomies_as_options .= '<option value="' . $attachment_taxonomy_name . '">' . $attachment_taxonomy_value->label . ' (' . $attachment_taxonomy_name . ')</option>';
    }
    echo $ml_taxonomies_as_options;

    $attachment_taxonomies = $attachment_taxonomy_name = $attachment_taxonomy_value = null;
    unset($attachment_taxonomies, $attachment_taxonomy_name, $attachment_taxonomy_value); ?>
                        </select>
                        <div class="minihelp"><?php _e('Choose a taxonomy to show images by, if any (not always available).', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Image taxonomy term', 'jig_td'); ?></div>
                        <label>image_tax_term</label>
                        <input type="text" name="image_tax_term" value='' />
                        <div class="minihelp"><?php _e('Enter term slugs, comma separated. Can be narrowed by combining with "Image categories" and "Image tags" from above (AND relationship).', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Exclude taxonomy', 'jig_td'); ?></div>
                        <label>ex_image_taxonomy</label>
                        <select name="ex_image_taxonomy">
                            <option value="default" selected="selected"><?php _e('No taxomony.', 'jig_td'); ?></option>
<?php

    echo $ml_taxonomies_as_options; ?>
                        </select>
                        <div class="minihelp"><?php _e('Choose a taxonomy to exclude images by (also choose a term if you do so).', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Exclude taxonomy term', 'jig_td'); ?></div>
                        <label>ex_image_tax_term</label>
                        <input type="text" name="ex_image_tax_term" value='' />
                        <div class="minihelp"><?php _e('Enter term slugs, comma separated. Works with any source based on the Media Library.', 'jig_td'); ?></div>
                    </div>
<?php
} else {
    ?>
                    <div class="flexirow">
                        <div class="longHelp">
<?php

    echo sprintf(
        __('Tip: To reveal settings for <a href="%s">Category, Tag, and other Taxonomy-based galleries</a>, enable "Additional tools or utilities -> WP image tags and categories" in the Settings or use the free <a href="%s" target="_blank">Media Library Assistant</a> plugin!', 'jig_td'),
        esc_url('https://justifiedgrid.com/sources/wordpress/images-by-taxonomy/'),
        esc_url('https://wordpress.org/plugins/media-library-assistant/')
    ); ?>
                        </div>
                    </div>

<?php
} /* end of taxonomy check */

?>
                <div class="row">
                    <div class="normalName"><?php _e('Other post/page ID', 'jig_td'); ?></div>
                    <label>id</label>
                    <input type="text" name="id" value='' />
                    <div class="minihelp"><?php _e('Use this to show images attached to another page/post: postID, a number which you can get by looking at the URL bar when editing it).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Parent ID', 'jig_td'); ?></div>
                    <label>parent_id</label>
                    <input type="text" name="parent_id" value='' />
                    <div class="minihelp"><?php _e('Show all of the photos from each child page of certain parent page.', 'jig_td'); ?></div>
                </div>

                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Row behavior', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Target row height', 'jig_td'); ?></div>
                    <label>row_height</label>
                    <input type="text" name="row_height" value='' />
                    <div class="minihelp"><?php _e('Desired row height in pixels, e.g. 200 (without px).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Row height max deviation (+-)', 'jig_td'); ?></div>
                    <label>height_deviation</label>
                    <input type="text" name="height_deviation" value='' />
                    <div class="minihelp"><?php _e('The row height will vary +/- by this value, e.g. 50 (without px).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Limit height to viewport', 'jig_td'); ?></div>
                    <label>limit_by_viewport</label>
                    <select name="limit_by_viewport">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: Device/browser viewport (usable height of the screen) dictates how tall rows can be.', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: Unlock tall rows.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Prevents rows from appearing taller than the viewport. This avoids the need for scrolling to wholly explore a thumbnail.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Max rows', 'jig_td'); ?></div>
                    <label>max_rows</label>
                    <input type="text" name="max_rows" value='' />
                    <div class="minihelp"><?php _e('Only show up to this amount of rows. 0 to force unlimited. Combined with a fixed row height (0 deviation), this can result in a banner.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Incomplete last row', 'jig_td'); ?></div>
                    <label>last_row</label>
                    <select name="last_row">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="normal"><?php _e('Normal: Try to fill width OR fall back to target height (visibly incomplete).', 'jig_td'); ?></option>
                        <option value="center"><?php _e('Center the images (whenever they would be left aligned).', 'jig_td'); ?></option>
                        <option value="hide"><?php _e('Hide: Form a perfect justified block.', 'jig_td'); ?></option>
                        <option value="match"><?php _e("Match previous row's height, useful for same aspect ratio photos.", 'jig_td'); ?></option>
                        <option value="flexible"><?php _e('Flexible: For Load More: only allow the very last row to be orphan.', 'jig_td'); ?></option>
                        <option value="flexible-center"><?php _e('Flexible + Center', 'jig_td'); ?></option>
                        <option value="flexible-match"><?php _e('Flexible + Match', 'jig_td'); ?></option>
                        <option value="flexible-match-center"><?php _e('Flexible + Match + Center', 'jig_td'); ?></option>
                        <option value="match-center"><?php _e('Match + Center', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('The last row is not always full - choose how to handle it.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Mobile row height', 'jig_td'); ?></div>
                    <label>mobile_row_height</label>
                    <input type="text" name="mobile_row_height" value='' />
                    <div class="minihelp"><?php _e('Same as "Target row height", but only for mobiles. Optional!', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Mobile row height deviation (+-)', 'jig_td'); ?></div>
                    <label>mobile_height_dev</label>
                    <input type="text" name="mobile_height_dev" value='' />
                    <div class="minihelp"><?php _e('Same as "Row height max deviation", but for mobiles. Optional!', 'jig_td'); ?></div>
                </div>

                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Thumbnail count and dimensions', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Limit image count *', 'jig_td'); ?></div>
                    <label>limit</label>
                    <input type="text" name="limit" value='' />
                    <div class="minihelp"><?php _e('Only show up to this number of images. Set 0 for unlimited.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Hidden limit *', 'jig_td'); ?></div>
                    <label>hidden_limit</label>
                    <input type="text" name="hidden_limit" value='' />
                    <div class="minihelp"><?php _e('More images can still be added to the lightbox, until the Hidden limit.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Spacing between the thumbnails', 'jig_td'); ?></div>
                    <label>thumbs_spacing</label>
                    <input type="text" name="thumbs_spacing" value='' />
                    <div class="minihelp"><?php _e('Enter a number like 0, 1, 4 or 10 (without px).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Thumbnail aspect ratio', 'jig_td'); ?></div>
                    <label>aspect_ratio</label>
                    <input type="text" name="aspect_ratio" value='' />
                    <div class="minihelp"><?php _e('To crop your thumbs enter a ratio: 1, 1:1 or 1/1 (square) 2.35:1 or 16:9 (wide), 4/3, 1.5 or similar - to lock it, look at the next setting.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Disable cropping', 'jig_td'); ?></div>
                    <label>disable_cropping</label>
                    <select name="disable_cropping">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No, respect the row height and allow some cropping.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, lock aspect ratio and use 50px minimum row height.', 'jig_td'); ?></option>
                        <option value="yes-mobile"><?php _e('Yes, but only on mobile devices.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Use this to avoid cropping or to lock your selected aspect ratio.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Randomize thumbnail width ', 'jig_td'); ?></div>
                    <label>randomize_width</label>
                    <input type="text" name="randomize_width" value='' />
                    <div class="minihelp"><?php _e('A number (without px) to make images randomly cropped or extended within this range.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="longHelp"><?php _e('* Note: Facebook and Flickr have a default limit of 100 and a maximum of 500.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Settings that affect the entire grid', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Order by', 'jig_td'); ?></div>
                    <label>orderby</label>
                    <select name="orderby">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="menu_order"><?php _e('Menu order', 'jig_td'); ?></option>
                        <option value="rand"><?php _e('Random', 'jig_td'); ?></option>
                        <option value="title_asc"><?php _e('Title ascending', 'jig_td'); ?></option>
                        <option value="title_desc"><?php _e('Title descending', 'jig_td'); ?></option>
                        <option value="date_asc"><?php _e('Date ascending', 'jig_td'); ?></option>
                        <option value="date_desc"><?php _e('Date descending', 'jig_td'); ?></option>
                        <option value="custom"><?php _e('Force menu order for Recent posts', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('The order of images (only for images/posts from WP, or NextGEN, except Random).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Width mode', 'jig_td'); ?></div>
                    <label>width_mode</label>
                    <select name="width_mode">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="responsive_fallback"><?php _e('Responsive fallback, automatic', 'jig_td'); ?></option>
                        <option value="fixed"><?php _e('Non-responsive, fixed', 'jig_td'); ?></option>
                        <option value="fixed-mobile"><?php _e('Fixed width for mobile - Responsive on desktop', 'jig_td'); ?></option>
                        <option value="fixed-desktop"><?php _e('Fixed width for desktop - Responsive on mobile', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Set to Fixed if you have the "element is too thin" error. You must set a width at the next setting if you selected any of the Fixed modes.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Custom width (whole grid)', 'jig_td'); ?></div>
                    <label>custom_width</label>
                    <input type="text" name="custom_width" value='' />
                    <div class="minihelp"><?php _e('The width to use by "Width mode", (empty is default). Without px.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Margin around gallery', 'jig_td'); ?></div>
                    <label>margin</label>
                    <input type="text" name="margin" value='' />
                    <div class="minihelp"><?php _e('A CSS margin value e.g. 10px (around) or 0 10px (sides only).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Animation speed', 'jig_td'); ?></div>
                    <label>animation_speed</label>
                    <input type="text" name="animation_speed" value='' />
                    <div class="minihelp"><?php _e('For every animation, in milliseconds: 200 is fast, 600 is slow.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Custom class', 'jig_td'); ?></div>
                    <label>custom_class</label>
                    <input type="text" name="custom_class" value='' />
                    <div class="minihelp"><?php _e('To make it easier to target this gallery with CSS.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Min height to avoid "jumping"', 'jig_td'); ?></div>
                    <label>min_height</label>
                    <input type="text" name="min_height" value='' />
                    <div class="minihelp"><?php _e('To avoid seeing the footer if you have no sidebar, e.g. 500 (without px). Makes the grid take up some space even without images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Background behind thumbnails', 'jig_td'); ?></div>
                    <label>loading_background</label>
                    <input type="text" name="loading_background" value='' />
                    <div class="minihelp"><?php _e('You could specify a grey color like Flickr #cccccc or #eaeaea or even a loader animation. Accepts CSS background property.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Custom link override', 'jig_td'); ?></div>
                    <label>link_override</label>
                    <input type="text" name="link_override" value='' />
                    <div class="minihelp"><?php _e('Use this custom link on every image in the grid, for special purposes.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Separator character', 'jig_td'); ?></div>
                    <label>separator_character</label>
                    <input type="text" name="separator_character" value='' />
                    <div class="minihelp"><?php _e('Used for separating the download link and NG tags from the description, the default is a dash.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Show custom text before', 'jig_td'); ?></div>
                    <label>show_text_before</label>
                    <select name="show_text_before">
                        <option value="default" selected="selected"><?php _e('default (yes)', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e('Leave unchanged to allow custom text or disable.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Show custom text after', 'jig_td'); ?></div>
                    <label>show_text_after</label>
                    <select name="show_text_after">
                        <option value="default" selected="selected"><?php _e('default (yes)', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e('You can set these before & after texts in the settings.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Behavior of the plugin', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Allow animated GIFs', 'jig_td'); ?></div>
                    <label>allow_animated_gifs</label>
                    <select name="allow_animated_gifs">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No, resize and freeze them.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, let them display as-is.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Show animated GIFs as-is, animated, not freezed nor broken.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Allow transparent PNGs', 'jig_td'); ?></div>
                    <label>allow_transp_pngs</label>
                    <select name="allow_transp_pngs">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, let them display with transparency.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Only enable if you really want to use transparent PNGs.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Process shortcodes', 'jig_td'); ?></div>
                    <label>process_shortcodes</label>
                    <select name="process_shortcodes">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Process shortcodes in all captions from all image sources.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Wrap text', 'jig_td'); ?></div>
                    <label>wrap_text</label>
                    <select name="wrap_text">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No, clear the block.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, let the text wrap around JIG.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Let the text flow to the left/right, for single images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Reading direction', 'jig_td'); ?></div>
                    <label>reading_direction</label>
                    <select name="reading_direction">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="ltr"><?php _e('LTR: left-to-right', 'jig_td'); ?></option>
                        <option value="rtl"><?php _e('RTL: right-to-left', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Switch this for a different reading direction.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Disable mobile hover interaction', 'jig_td'); ?></div>
                    <label>disable_mobile_hover</label>
                    <select name="disable_mobile_hover">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose yes if you wish to avoid "double tapping" to open images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Disable right mouse menu', 'jig_td'); ?></div>
                    <label>mouse_disable</label>
                    <select name="mouse_disable">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose yes if you wish to disable right click menu (prevent copy).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Error checking', 'jig_td'); ?></div>
                    <label>error_checking</label>
                    <select name="error_checking">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Yes to hide unloadable images from the grid, No to show them all.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Suppress errors', 'jig_td'); ?></div>
                    <label>suppress_errors</label>
                    <select name="suppress_errors">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="publicly"><?php _e('Hide from the public, show for logged-in users.', 'jig_td'); ?></option>
                        <option value="wp-debug"><?php _e('According to WP_DEBUG', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Hide server-related errors that are mostly only useful for the owner.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e("Custom link's target", 'jig_td'); ?></div>
                    <label>link_target</label>
                    <select name="link_target">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="_self"><?php _e('Self: The same tab or same window.', 'jig_td'); ?></option>
                        <option value="_blank"><?php _e('Blank: A new tab or new window.', 'jig_td'); ?></option>
                        <option value="video"><?php _e('Lightbox: video / iframe / different image.', 'jig_td'); ?></option>
                        <option value="videoplayer"><?php _e('Video player in the lightbox.', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off: Disregard custom links.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose where you wish to open custom links.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Follow mode for custom links', 'jig_td'); ?></div>
                    <label>custom_link_follow</label>
                    <select name="custom_link_follow">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: dofollow', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: add nofollow', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Tell search engines to follow the custom link to the external site.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Only for logged in users', 'jig_td'); ?></div>
                    <label>only_for_logged_in</label>
                    <select name="only_for_logged_in">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No, public.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, private: only show gallery for logged in users.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Restrict the gallery to users who have logged in.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Developer link', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Display developer link', 'jig_td'); ?></div>
                    <label>developer_link</label>
                    <select name="developer_link">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="show"><?php _e('Show', 'jig_td'); ?></option>
                        <option value="hide"><?php _e('Hide', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Show a "Powered by" affiliate link. Set this up in the settings.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('TimThumb', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('TimThumb quality', 'jig_td'); ?></div>
                    <label>quality</label>
                    <input type="text" name="quality" value='' />
                    <div class="minihelp"><?php _e('Leave empty or enter a number between 0 and 100.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Retina ready', 'jig_td'); ?></div>
                    <label>retina_ready</label>
                    <select name="retina_ready">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, load higher resolution thumbnails on HDPI displays.', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No, just load normal resolution thumbnails on all devices.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('The thumbnails will look crisp on modern mobile devices or other high resolution displays.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Retina quality', 'jig_td'); ?></div>
                    <label>retina_quality</label>
                    <input type="text" name="retina_quality" value='' />
                    <div class="minihelp"><?php _e("This determines the thumbnails' file size. Same as TimThumb quality. Best set to auto (or empty), which will divide TimThumb quality by the pixel aspect ratio of the device.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Minimum retina quality', 'jig_td'); ?></div>
                    <label>min_retina_quality</label>
                    <input type="text" name="min_retina_quality" value='' />
                    <div class="minihelp"><?php _e('When retina quality is automatic, this controls the minimum calculated quality. Set it higher if you have smooth gradients on your images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Maximum retina density', 'jig_td'); ?></div>
                    <label>max_retina_density</label>
                    <input type="text" name="max_retina_density" value='' />
                    <div class="minihelp"><?php _e('Decide what screens to support according to the level of density / device pixel ratio. 2 is double density, the most common, extra file size cost rarely occurs. 3 is the density of the latest phones, 50% extra file size cost is usual.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Crop zone', 'jig_td'); ?></div>
                    <label>timthumb_crop_zone</label>
                    <select name="timthumb_crop_zone">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="c"><?php _e('Center', 'jig_td'); ?></option>
                        <option value="t"><?php _e('Top', 'jig_td'); ?></option>
                        <option value="tr"><?php _e('Top right', 'jig_td'); ?></option>
                        <option value="tl"><?php _e('Top left', 'jig_td'); ?></option>
                        <option value="b"><?php _e('Bottom', 'jig_td'); ?></option>
                        <option value="br"><?php _e('Bottom right', 'jig_td'); ?></option>
                        <option value="bl"><?php _e('Bottom left', 'jig_td'); ?></option>
                        <option value="l"><?php _e('Left', 'jig_td'); ?></option>
                        <option value="r"><?php _e('Right', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Only used when you are cropping using a fixed aspect ratio, this determines where to crop the images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Custom TimThumb path', 'jig_td'); ?></div>
                    <label>timthumb_path</label>
                    <input type="text" name="timthumb_path" value='' />
                    <div class="minihelp"><?php _e('Absolute path (full URL), most likely just leave it empty.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Use TimThumb', 'jig_td'); ?></div>
                    <label>use_timthumb</label>
                    <select name="use_timthumb">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: Use TimThumb (recommended).', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: Do not use TimThumb (not recommended).', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Only disable TimThumb if you know what you are doing, for logos, testing purposes or as a last resort.', 'jig_td'); ?></div>
                </div>
<?php

global $_wp_additional_image_sizes;
$wp_image_sizes = get_intermediate_image_sizes();
$wp_native_i_size_maxes = [
    'large' => [],
    'large_size_w' => get_option('large_size_w'),
    'large_size_h' => get_option('large_size_h'),
    'medium_large' => [],
    'medium_large_size_w' => get_option('medium_large_size_w'),
    'medium_large_size_h' => get_option('medium_large_size_h'),
    'medium' => [],
    'medium_size_w' => get_option('medium_size_w'),
    'medium_size_h' => get_option('medium_size_h'),
    'thumbnail' => [],
    'thumbnail_size_w' => get_option('thumbnail_size_w'),
    'thumbnail_size_h' => get_option('thumbnail_size_h')

];
if ($wp_native_i_size_maxes['large_size_w']) {
    $wp_native_i_size_maxes['large'][] = $wp_native_i_size_maxes['large_size_w'].'w';
}
if ($wp_native_i_size_maxes['large_size_h']) {
    $wp_native_i_size_maxes['large'][] = $wp_native_i_size_maxes['large_size_h'].'h';
}
if ($wp_native_i_size_maxes['medium_large_size_w']) {
    $wp_native_i_size_maxes['medium_large'][] = $wp_native_i_size_maxes['medium_large_size_w'].'w';
}
if ($wp_native_i_size_maxes['medium_large_size_h']) {
    $wp_native_i_size_maxes['medium_large'][] = $wp_native_i_size_maxes['medium_large_size_h'].'h';
}
if ($wp_native_i_size_maxes['medium_size_w']) {
    $wp_native_i_size_maxes['medium'][] = $wp_native_i_size_maxes['medium_size_w'].'w';
}
if ($wp_native_i_size_maxes['medium_size_h']) {
    $wp_native_i_size_maxes['medium'][] = $wp_native_i_size_maxes['medium_size_h'].'h';
}
if ($wp_native_i_size_maxes['thumbnail_size_w']) {
    $wp_native_i_size_maxes['thumbnail'][] = $wp_native_i_size_maxes['thumbnail_size_w'].'w';
}
if ($wp_native_i_size_maxes['thumbnail_size_h']) {
    $wp_native_i_size_maxes['thumbnail'][] = $wp_native_i_size_maxes['thumbnail_size_h'].'h';
}
$image_size_options = [
    'full' => __('Full.', 'jig_td'),
    'large' => sprintf(
        __('Large (fits %s).', 'jig_td'),
        implode(' x ', $wp_native_i_size_maxes['large'])
    ),
    'medium_large' => sprintf(
        __('Medium Large (fits %s).', 'jig_td'),
        implode(' x ', $wp_native_i_size_maxes['medium_large'])
    ),
    'medium' => sprintf(
        __('Medium (fits %s).', 'jig_td'),
        implode(' x ', $wp_native_i_size_maxes['medium'])
    ),
    'thumbnail' => sprintf(
        __('Thumbnail (%s %s).', 'jig_td'),
        get_option("thumbnail_crop") ? __('cropped to', 'jig_td') : __('fits', 'jig_td'),
        implode(' x ', $wp_native_i_size_maxes['thumbnail'])
    )
];
if (!empty($wp_image_sizes)) {
    foreach ($wp_image_sizes as $i_size) {
        if (!empty($_wp_additional_image_sizes[$i_size]['width']) || !empty($_wp_additional_image_sizes[$i_size]['height'])) {
            $i_size_maxes = [];
            if ($_wp_additional_image_sizes[$i_size]['width'] && $_wp_additional_image_sizes[$i_size]['width'] < 9000) {
                $i_size_maxes[] = $_wp_additional_image_sizes[$i_size]['width'].'w';
            }
            if ($_wp_additional_image_sizes[$i_size]['height'] && $_wp_additional_image_sizes[$i_size]['height'] < 9000) {
                $i_size_maxes[] = $_wp_additional_image_sizes[$i_size]['height'].'h';
            }
            $image_size_options[$i_size] = sprintf(
                '%s (%s%s).',
                ucfirst(str_replace(['_', '-'], ' ', $i_size)),
                ($_wp_additional_image_sizes[$i_size]['crop'] ? __('cropped to', 'jig_td') : __('fits', 'jig_td')).' ',
                implode(' x ', $i_size_maxes)
            );
        }
    }
    unset($i_size_maxes);
}

$thumbnail_image_sizes = array_merge(
    ['same_as_lightbox' => __('Same as lightbox.', 'jig_td')],
    $image_size_options
);

?>
                <div class="row">
                    <div class="normalName"><?php _e('Base thumbnail on an image size', 'jig_td'); ?></div>
                    <label>thumbnail_base</label>
                    <select name="thumbnail_base">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
<?php

foreach ($thumbnail_image_sizes as $thumbnail_image_sizes_name => $thumbnail_image_size_value) {
    echo '<option value="' . $thumbnail_image_sizes_name . '">' . $thumbnail_image_size_value . '</option>';
}
$thumbnail_image_sizes_name = $thumbnail_image_size_value = null;
unset($thumbnail_image_sizes_name, $thumbnail_image_size_value);

?>
                    </select>
                    <div class="minihelp"><?php _e('Only for WP Media Library images. TimThumb will use this size as thumbnail generation source. Alternatively, when TimThumb is disabled, you can use one of the built-in sizes for the thumbnail (advanced users).', 'jig_td'); ?></div>
                </div>
            </div>
            <h3 class="jigTabTitle" id="jigLoadMore"><?php _e('Load more', 'jig_td'); ?></h3>
            <div id="jig_load_more_tab_content" class="jigSettingsTab jig_settings_group_load_more clearfix">
                <div class="flexirow">
                    <div class="helpText"><a href="https://justifiedgrid.com/features/load-more/" target="_blank"><?php _e('See examples and learn more about the Load More feature!', 'jig_td'); ?></a>
                    </div>
                </div>
                <div class="dashedLine"></div>
                <div class="row">
                    <div class="normalName"><?php _e('Load more (behavior)', 'jig_td'); ?></div>
                    <label>load_more</label>
                    <select name="load_more">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off: All images are loaded in one go.', 'jig_td'); ?></option>
                        <option value="click"><?php _e("Click: 'Load more' button.", 'jig_td'); ?></option>
                        <option value="scroll"><?php _e('Infinite Scroll (+ the button).', 'jig_td'); ?></option>
                        <option value="hybrid"><?php _e('Hybrid: One click on Load More is required then infinite scroll.', 'jig_td'); ?></option>
                        <option value="once"><?php _e('Once: Load More shows all.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Enable this to break down loading into smaller batches.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Load more only on mobile', 'jig_td'); ?></div>
                    <label>load_more_mobile</label>
                    <select name="load_more_mobile">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: Not just mobiles.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: above choice only for mobile devices.', 'jig_td'); ?></option>
                        <option value="click"><?php _e("Click: 'Load more' button.", 'jig_td'); ?></option>
                        <option value="scroll"><?php _e('Infinite Scroll (+ the button).', 'jig_td'); ?></option>
                        <option value="hybrid"><?php _e('Hybrid: One click on Load More is required then infinite scroll.', 'jig_td'); ?></option>
                        <option value="once"><?php _e('Once: Load More shows all.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Use this if you only want use Load More on mobile devices.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Initially load', 'jig_td'); ?></div>
                    <label>initially_load</label>
                    <input type="text" name="initially_load" value='' />
                    <div class="minihelp"><?php _e('Amount of images to fetch initially (optional).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Load more limit (per load)', 'jig_td'); ?></div>
                    <label>load_more_limit</label>
                    <input type="text" name="load_more_limit" value='' />
                    <div class="minihelp"><?php _e("Amount of images to fetch initially (if not specified above), then per load. This should be something smaller than the 'Limit' (if set).", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Load more text', 'jig_td'); ?></div>
                    <label>load_more_text</label>
                    <input type="text" name="load_more_text" value='' />
                    <div class="minihelp"><?php _e("The text to show on the button, instead of 'Load more'.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Load more count text', 'jig_td'); ?></div>
                    <label>load_more_count_text</label>
                    <input type="text" name="load_more_count_text" value='' />
                    <div class="minihelp"><?php _e('Second line of the button, *count* is replaced with the actual remaining count. To turn off, enter the word: none.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Infinite scroll offset', 'jig_td'); ?></div>
                    <label>load_more_offset</label>
                    <input type="text" name="load_more_offset" value='' />
                    <div class="minihelp"><?php _e('Start the next batch of load more before the end of gallery is scrolled into view. Set in pixels, without px. Larger number means earlier, less noticeable load more.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Load more auto width', 'jig_td'); ?></div>
                    <label>load_more_auto_width</label>
                    <select name="load_more_auto_width">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="on"><?php _e('On: Automatic width, overrides any CSS.', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off: Width is controlled by CSS.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e("Automatically set the Load more button's width to smallest possible.", 'jig_td'); ?></div>
                </div>
                <div class="flexirow">
                    <div class="longHelp"><?php _e("Tip: Set the 'General settings -> Incomplete last row' setting to be 'flexible' (last_row=flexible), as it'll hide the orphan rows except the last when there is no more images to display. It's been designed for this Load More feature.", 'jig_td'); ?></div>
                </div>
            </div>

            <h3 class="jigTabTitle" id="jigFiltering"><?php _e('Filtering', 'jig_td'); ?></h3>
            <div id="jig_filtering_tab_content" class="jigSettingsTab jig_settings_group clearfix">
                <div class="flexirow">
                    <div class="helpText"><a href="https://justifiedgrid.com/features/filtering/" target="_blank"><?php _e('See examples and learn more about Filtering!', 'jig_td'); ?></a>
                    </div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Filtering behavior and style - level 1', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter by', 'jig_td'); ?></div>
                    <label>filterby</label>
                    <select name="filterby">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Nothing, turn filtering off.', 'jig_td'); ?></option>
                        <option value="on"><?php _e('Automatic (on): Choose a tag taxonomy automatically, this should work in most cases.', 'jig_td'); ?></option>

<?php

$post_types_for_filtering = $taxonomies_for_filtering = [];
if (!empty($wp_post_types)) {
    foreach ($wp_post_types as $post_type_name => $post_type_value) {
        if ($post_type_name !== 'revision' && $post_type_name !== 'nav_menu_item') {
            $post_types_for_filtering[$post_type_name] = $post_type_value->labels->name;
        }
    }
    $post_type_name = $post_type_value = null;
    unset($post_type_name, $post_type_value);
} else {
    $post_types_for_filtering = [['post', 'Posts'], ['page', 'Pages']];
}
$taxonomies_as_options = '';
foreach ($post_types_for_filtering as $post_type_name => $post_type_label) {
    $post_type_taxonomies = get_object_taxonomies($post_type_name, 'objects');
    if (!empty($post_type_taxonomies)) {
        foreach ($post_type_taxonomies as $post_type_taxonomy_name => $post_type_taxonomy_value) {
            if (empty($taxonomies_for_filtering[$post_type_taxonomy_name])) {
                $taxonomies_for_filtering[$post_type_taxonomy_name] = true;
                $taxonomies_as_options .= '<option value="' . $post_type_taxonomy_name . '">' . $post_type_taxonomy_value->label . ' (' . $post_type_taxonomy_name . ')</option>';
            }
        }
    }
}
$post_types_for_filtering = $taxonomies_for_filtering = $post_type_name = $post_type_label = $post_type_taxonomies = $post_type_taxonomy_name = $post_type_taxonomy_value = null;
unset(
    $post_types_for_filtering,
    $taxonomies_for_filtering,
    $post_type_name,
    $post_type_label,
    $post_type_taxonomies,
    $post_type_taxonomy_name,
    $post_type_taxonomy_value
);
echo $taxonomies_as_options;
$additional_filtering_options = '';
$additional_filtering_options .= '<option value="az">' . __("A to Z letters based on the title's first character.", 'jig_td') . '</option>';
$additional_filtering_options .= '<option value="author_name">' . __("Author name (Recent Posts, Media Library, Flickr).", 'jig_td') . '</option>';
if (isset($wpdb->nggallery) !== false) {
    $additional_filtering_options .= '<option value="ng_galleries">' . __('NextGEN galleries (of pictures in the grid).', 'jig_td') . '</option>';
}
if (class_exists('RML_Core') || class_exists('MatthiasWeb\RealMediaLibrary\general\Core')) {
    $additional_filtering_options .= '<option value="rml_parents">' . __('WP RML Galleries or Folders (of pictures in the grid).', 'jig_td') . '</option>';
}
echo $additional_filtering_options;

?>
                    </select>
                    <div class="minihelp"><?php _e('Choose a taxonomy to filter the thumbnails, more info in the settings.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter style', 'jig_td'); ?></div>
                    <label>filter_style</label>
                    <select name="filter_style">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="buttons"><?php _e('Buttons', 'jig_td'); ?></option>
                        <option value="tags"><?php _e('Tag cloud', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose how the filtering interface should look like.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Order filter terms by', 'jig_td'); ?></div>
                    <label>filter_orderby</label>
                    <select name="filter_orderby">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="appearance"><?php _e('In order of appearance in images', 'jig_td'); ?></option>
                        <option value="title_asc"><?php _e('Title ascending (A-Z)', 'jig_td'); ?></option>
                        <option value="title_desc"><?php _e('Title descending (Z-A)', 'jig_td'); ?></option>
                        <option value="random"><?php _e('Random', 'jig_td'); ?></option>
                        <option value="popularity"><?php _e('Popularity among images (top terms first)', 'jig_td'); ?></option>
                        <option value="custom"><?php _e('Custom (use the next setting)', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Set an order for the filter buttons or tags. This does not change the order of images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter terms custom order', 'jig_td'); ?></div>
                    <label>filter_custom_order</label>
                    <input type="text" name="filter_custom_order" value='' />
                    <div class="minihelp"><?php _e('Manually enter filter buttons or tags by name, comma separated, Case Sensitive! Only those that you specify will be used and in the exact order. This is a manual setting and requires you to know the term names, furthermore filter_orderby needs to be on custom.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Exclude filter terms', 'jig_td'); ?></div>
                    <label>exclude_filter_terms</label>
                    <input type="text" name="exclude_filter_terms" value='' />
                    <div class="minihelp"><?php _e('Enter filter terms as they appear (comma separated, Case Sensitive) to hide them.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Min count for term', 'jig_td'); ?></div>
                    <label>filter_min_count</label>
                    <input type="text" name="filter_min_count" value='' />
                    <div class="minihelp"><?php _e('Only show those filter buttons or tags that have at least this number of images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Top x terms', 'jig_td'); ?></div>
                    <label>filter_top_x</label>
                    <input type="text" name="filter_top_x" value='' />
                    <div class="minihelp"><?php _e('Limit the number of filter buttons or tags to the top x (any number) that occur in the most images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Use All button', 'jig_td'); ?></div>
                    <label>filter_all_button</label>
                    <select name="filter_all_button">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Whether or not to use the All button. When not used, the first filter button or tag will be active instead of an All button.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter: "All" button/tag text', 'jig_td'); ?></div>
                    <label>filter_all_text</label>
                    <input type="text" name="filter_all_text" value='' />
                    <div class="minihelp"><?php _e('Change what appears on the "All" button/tag, e.g. "All posts" etc.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Allow multiple filters', 'jig_td'); ?></div>
                    <label>filter_multiple</label>
                    <select name="filter_multiple">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="or"><?php _e('OR (expanding selection, union)', 'jig_td'); ?></option>
                        <option value="and"><?php _e('AND (narrowing selection, intersect)', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Normally, the visitors can only select one term at a time. If this is set to OR, then all images matching any of the selected terms will be displayed. In case of AND, only images that match all selected terms will be shown.', 'jig_td'); ?></div>
                </div>


                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Filtering behavior and style - level 2 (advanced, additional set of filters)', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter by', 'jig_td'); ?></div>
                    <label>l2_filterby</label>
                    <select name="l2_filterby">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Nothing, turn filtering off.', 'jig_td'); ?></option>
                        <option value="on"><?php _e('Automatic (on): Choose a tag taxonomy automatically, this should work in most cases.', 'jig_td'); ?></option>
<?php

echo $taxonomies_as_options;
echo $additional_filtering_options;

?>
                    </select>
                    <div class="minihelp"><?php _e('Choose a taxonomy to filter the thumbnails, more info in the settings.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter style', 'jig_td'); ?></div>
                    <label>l2_filter_style</label>
                    <select name="l2_filter_style">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="buttons"><?php _e('Buttons', 'jig_td'); ?></option>
                        <option value="tags"><?php _e('Tag cloud', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose how the filtering interface should look like.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Order filter terms by', 'jig_td'); ?></div>
                    <label>l2_filter_orderby</label>
                    <select name="l2_filter_orderby">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="appearance"><?php _e('In order of appearance in images', 'jig_td'); ?></option>
                        <option value="title_asc"><?php _e('Title ascending (A-Z)', 'jig_td'); ?></option>
                        <option value="title_desc"><?php _e('Title descending (Z-A)', 'jig_td'); ?></option>
                        <option value="random"><?php _e('Random', 'jig_td'); ?></option>
                        <option value="popularity"><?php _e('Popularity among images (top terms first)', 'jig_td'); ?></option>
                        <option value="custom"><?php _e('Custom (use the next setting)', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Set an order for the filter buttons or tags. This does not change the order of images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter terms custom order ', 'jig_td'); ?></div>
                    <label>l2_filter_custom_order</label>
                    <input type="text" name="l2_filter_custom_order" value='' />
                    <div class="minihelp"><?php _e('Manually enter filter buttons or tags by name, comma separated, Case Sensitive! Only those that you specify will be used and in the exact order. This is a manual setting and requires you to know the term names, furthermore filter_orderby needs to be on custom.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Exclude filter terms', 'jig_td'); ?></div>
                    <label>l2_exclude_filter_terms</label>
                    <input type="text" name="l2_exclude_filter_terms" value='' />
                    <div class="minihelp"><?php _e('Enter filter terms as they appear (comma separated, Case Sensitive) to hide them.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Min count for term', 'jig_td'); ?></div>
                    <label>l2_filter_min_count</label>
                    <input type="text" name="l2_filter_min_count" value='' />
                    <div class="minihelp"><?php _e('Only show those filter buttons or tags that have at least this number of images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Top x terms', 'jig_td'); ?></div>
                    <label>l2_filter_top_x</label>
                    <input type="text" name="l2_filter_top_x" value='' />
                    <div class="minihelp"><?php _e('Limit the number of filter buttons or tags to the top x (any number) that occur in the most images.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Use All button', 'jig_td'); ?></div>
                    <label>l2_filter_all_button</label>
                    <select name="l2_filter_all_button">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Whether or not to use the All button. When not used, the first filter button or tag will be active instead of an All button.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter: "All" button/tag text', 'jig_td'); ?></div>
                    <label>l2_filter_all_text</label>
                    <input type="text" name="l2_filter_all_text" value='' />
                    <div class="minihelp"><?php _e('Change what appears on the "All" button/tag, e.g. "All posts" etc.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Allow multiple filters', 'jig_td'); ?></div>
                    <label>l2_filter_multiple</label>
                    <select name="l2_filter_multiple">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="or"><?php _e('OR (expanding selection, union)', 'jig_td'); ?></option>
                        <option value="and"><?php _e('AND (narrowing selection, intersect)', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Normally, the visitors can only select one term at a time. If this is set to OR, then all images matching any of the selected terms will be displayed. In case of AND, only images that match all selected terms will be shown.', 'jig_td'); ?></div>
                </div>
            </div>

            <h3 class="jigTabTitle" id="jigLightboxes"><?php _e('Lightboxes', 'jig_td'); ?></h3>
            <div id="jig_lightboxes_tab_content" class="jigSettingsTab jig_settings_group clearfix">
                <div class="flexirow">
                    <div class="helpText">
                        <a href="https://justifiedgrid.com/lightboxes/" target="_blank"><?php _e('See examples, compare and learn more about the different lightboxes!', 'jig_td'); ?></a>
                    </div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('What to do when clicking on a thumbnail', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Lightbox type', 'jig_td'); ?></div>
                    <label>lightbox</label>
                    <select name="lightbox">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="prettyphoto">prettyPhoto</option>
                        <option value="colorbox">ColorBox</option>
                        <option value="magnific">Magnific Popup</option>
                        <option value="photoswipe">PhotoSwipe 4 by Dmitry Semenov</option>
<?php

if (class_exists('fooboxV2') || class_exists('foobox')) {
    echo '<option value="foobox">FooBox</option>';
}
if ((class_exists('Jetpack') && method_exists('Jetpack', 'get_active_modules') && in_array('carousel', Jetpack::get_active_modules()) && class_exists('Jetpack_Carousel')) || class_exists('CarouselWithoutJetpack')) {
    echo '<option value="carousel">Jetpack\'s Carousel  for WP images ONLY.</option>';
}
?>
                        <option value="custom"><?php _e('Custom', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: Open by the browser', 'jig_td'); ?></option>
                        <option value="new_tab"><?php _e('New tab: Open by the browser', 'jig_td'); ?></option>
                        <option value="attachment"><?php _e('Attachment page', 'jig_td'); ?></option>
                        <option value="links-off"><?php _e('Links-off', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Decide what happens when an image is clicked.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Mobile lightbox', 'jig_td'); ?></div>
                    <label>mobile_lightbox</label>
                    <select name="mobile_lightbox">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="magnific">Magnific Popup</option>
                        <option value="photoswipe">PhotoSwipe 4 by Dmitry Semenov (new)</option>
<?php

if (class_exists('fooboxV2') || class_exists('foobox')) {
    echo '<option value="foobox">FooBox</option>';
}

?>
                        <option value="new_tab"><?php _e('New tab: Open by the browser', 'jig_td'); ?></option>
                        <option value="attachment"><?php _e('Attachment page', 'jig_td'); ?></option>
                        <option value="links-off"><?php _e('Links-off', 'jig_td'); ?></option>
                        <option value="no"><?php _e('Same as desktop.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose to force a certain lightbox on mobile devices.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Maximum size for lightbox', 'jig_td'); ?></div>
                    <label>lightbox_max_size</label>
                    <select name="lightbox_max_size">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
<?php

foreach ($image_size_options as $image_size_name => $image_size_value) {
    echo '<option value="' . $image_size_name . '">' . $image_size_value . '</option>';
}
$image_size_name = $image_size_value = null;
unset($image_size_name, $image_size_value);

?>
                    </select>
                    <div class="minihelp"><?php _e('Maximum size of the WP image that loads in the lightbox.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Download link for the image', 'jig_td'); ?></div>
                    <label>download_link</label>
                    <select name="download_link">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: link title (the default position).', 'jig_td'); ?></option>
                        <option value="alt"><?php _e('Add to img alt.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('A link that displays a browser dialog to download the photo.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('What text to show inside the lightbox', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('WP field for link title *', 'jig_td'); ?></div>
                    <label>link_title_field</label>
                    <select name="link_title_field">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="description"><?php _e('Description', 'jig_td'); ?></option>
                        <option value="title"><?php _e('Title', 'jig_td'); ?></option>
                        <option value="caption"><?php _e('Caption', 'jig_td'); ?></option>
                        <option value="alternate"><?php _e('Alternate', 'jig_td'); ?></option>
                        <option value="custom"><?php _e('Custom field', 'jig_td'); ?></option>

                        <option value="off"><?php _e('Off: Do not use', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose a WP field as link title from the image details.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('WP field for img alt *', 'jig_td'); ?></div>
                    <label>img_alt_field</label>
                    <select name="img_alt_field">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="title"><?php _e('Title', 'jig_td'); ?></option>
                        <option value="description"><?php _e('Description', 'jig_td'); ?></option>
                        <option value="caption"><?php _e('Caption', 'jig_td'); ?></option>
                        <option value="alternate"><?php _e('Alternate', 'jig_td'); ?></option>
                        <option value="custom"><?php _e('Custom field', 'jig_td'); ?></option>

                        <option value="off"><?php _e('Off: Do not use', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose a WP field as img alt from the image details.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Lightbox custom field', 'jig_td'); ?></div>
                    <label>lightbox_custom_field</label>
                    <input type="text" name="lightbox_custom_field" value='' />
                    <div class="minihelp"><?php _e('1 or 2 WP custom field(s), comma separated, to be used with one or both of the above settings, respectively.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="longHelp"><?php _e('* Note: NextGEN, Facebook, Flickr title/description (or equivalent) fields act in place of WP Title and Description fields.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Link attributes (also for custom lightbox)', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Link class(es)', 'jig_td'); ?></div>
                    <label>link_class</label>
                    <input type="text" name="link_class" value='' />
                    <div class="minihelp"><?php _e("Class of the image's anchor tag.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Link rel', 'jig_td'); ?></div>
                    <label>link_rel</label>
                    <input type="text" name="link_rel" value='' />
                    <div class="minihelp"><?php _e("This groups images together (prev/next arrows). Can't use [] square brackets here, so format it like this: gallery(modal) or just leave empty for the automatic, best results. It can be set to auto as well.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Custom attribute name', 'jig_td'); ?></div>
                    <label>link_attribute_name</label>
                    <input type="text" name="link_attribute_name" value='' />
                    <div class="minihelp"><?php _e('Custom attribute for the image anchors. This is used together with the next setting. Example: data-lightbox or data-lightbox-gallery.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Custom attribute value', 'jig_td'); ?></div>
                    <label>link_attribute_value</label>
                    <input type="text" name="link_attribute_value" value='' />
                    <div class="minihelp"><?php _e('The *instance* is replaced by the JIG instance id. Example: gallery1 or gallery*instance* or mygallerygroup.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Use link attributes', 'jig_td'); ?></div>
                    <label>use_link_attributes</label>
                    <select name="use_link_attributes">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="everywhere"><?php _e('Everywhere (desktops AND mobile devices).', 'jig_td'); ?></option>
                        <option value="desktop"><?php _e('Only on desktops.', 'jig_td'); ?></option>
                        <option value="mobile"><?php _e('Only on mobile devices.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Use this if you want use these (class, rel, custom attribute) - probably your custom lightbox - only on a certain type of devices.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('PrettyPhoto settings', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('prettyPhoto social tools', 'jig_td'); ?></div>
                    <label>prettyphoto_social</label>
                    <select name="prettyphoto_social">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: display the social sharing buttons.', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Toggle Like+Share, Tweet, Pin and +1 buttons in prettyPhoto.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('prettyPhoto social buttons', 'jig_td'); ?></div>
                    <label>pp_social_buttons</label>
                    <input type="text" name="pp_social_buttons" value='' />
                    <div class="minihelp"><?php _e('Toggle individual social buttons or re-order them. Default is FTP.<br />F = Facebook Like+Share, T = Twitter, P = Pinterest', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('prettyPhoto theme', 'jig_td'); ?></div>
                    <label>prettyphoto_theme</label>
                    <select name="prettyphoto_theme">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="pp_default"><?php _e('Default theme', 'jig_td'); ?></option>
                        <option value="light_rounded"><?php _e('Light rounded', 'jig_td'); ?></option>
                        <option value="dark_rounded"><?php _e('Dark rounded', 'jig_td'); ?></option>
                        <option value="light_square"><?php _e('Light square', 'jig_td'); ?></option>
                        <option value="dark_square"><?php _e('Dark square', 'jig_td'); ?></option>
                        <option value="facebook"><?php _e('Facebook style', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose one of the six built-in themes of prettyPhoto.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('prettyPhoto title position', 'jig_td'); ?></div>
                    <label>prettyphoto_title_pos</label>
                    <select name="prettyphoto_title_pos">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="inside"><?php _e('Inside the lightbox.', 'jig_td'); ?></option>
                        <option value="outside"><?php _e('Outside the frame (legacy).', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Inside is a new, more space efficient and overall better layout, a customization of prettyPhoto for JIG.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('prettyPhoto Google Analytics', 'jig_td'); ?></div>
                    <label>prettyphoto_analytics</label>
                    <select name="prettyphoto_analytics">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, track photo views as events.', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('You can track images viewed in the lightbox as events.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('PhotoSwipe 4 settings', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('PhotoSwipe 4 social tools', 'jig_td'); ?></div>
                    <label>photoswipe_social</label>
                    <select name="photoswipe_social">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: display the social sharing buttons.', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Toggle Share, Tweet, Pin and +1 buttons in PhotoSwipe 4.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('PhotoSwipe 4 social buttons', 'jig_td'); ?></div>
                    <label>ps_social_buttons</label>
                    <input type="text" name="ps_social_buttons" value='' />
                    <div class="minihelp"><?php _e('Toggle individual social buttons or re-order them. Default is FTP.<br />F = Facebook Share, T = Twitter, P = Pinterest', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('PhotoSwipe theme', 'jig_td'); ?></div>
                    <label>photoswipe_theme</label>
                    <select name="photoswipe_theme">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="dark"><?php _e('Dark theme (default).', 'jig_td'); ?></option>
                        <option value="light"><?php _e('Light theme (JIG exclusive).', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose between dark and light theme for PhotoSwipe.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('PhotoSwipe 4 zoom effect', 'jig_td'); ?></div>
                    <label>photoswipe_zoom</label>
                    <select name="photoswipe_zoom">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, both: Zoom open the thumbnails. Allow zooming the large picture.', 'jig_td'); ?></option>
                        <option value="only-thumbnails"><?php _e('Zoom open the thumbnails. Prevent zooming the large picture.', 'jig_td'); ?></option>
                        <option value="only-large"><?php _e('Open photos without animation. Allow zooming the large picture.', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No, neither: Disable zoom for both thumbnail and opened.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose to open and close the lightbox with a zoom effect. Also, you may disable zooming the large picture, once opened.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Other lightbox settings', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Magnific Popup zoom effect', 'jig_td'); ?></div>
                    <label>magnific_zoom</label>
                    <select name="magnific_zoom">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes zoom the thumbnails.', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No, just open the photos without any animation.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Zoom animation for thumbnails that open in Magnific Popup.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Lightbox only for logged in user', 'jig_td'); ?></div>
                    <label>private_lightbox</label>
                    <select name="private_lightbox">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: lightbox is for everyone.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: lightbox only opens when a user is logged in.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e("Prevent the public from opening your photos in the lightbox to get a larger view. The public can't see links or click on the images.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Load bundled lightbox versions', 'jig_td'); ?></div>
                    <label>load_bundled_lightbox</label>
                    <select name="load_bundled_lightbox">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: Load the script for the selected lightbox, if bundled (recommended).', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: I already have that script loaded in the page.', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e("Only disable if you know what you are doing and do not wish to load JIG's version of the desired lightbox script.", 'jig_td'); ?></div>
                </div>
            </div>
            <h3 class="jigTabTitle" id="jigCaptions"><?php _e('Captions', 'jig_td'); ?></h3>
            <div id="jig_captions_tab_content" class="jigSettingsTab jig_settings_group clearfix">
                <div class="flexirow">
                    <div class="helpText">
                        <a href="https://justifiedgrid.com/features/thumbnail-captions/" target="_blank"><?php _e("See what these settings do and lots of Caption examples on our demo site!", 'jig_td'); ?></a>
                    </div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Caption appearance and style', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Caption style', 'jig_td'); ?></div>
                    <label>caption</label>
                    <select name="caption">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="fade"><?php _e('Fade', 'jig_td'); ?></option>
                        <option value="slide"><?php _e('Slide', 'jig_td'); ?></option>
                        <option value="mixed"><?php _e('Mixed', 'jig_td'); ?></option>
                        <option value="fixed"><?php _e('Fixed', 'jig_td'); ?></option>
                        <option value="reverse-fade"><?php _e('Reverse Fade', 'jig_td'); ?></option>
                        <option value="reverse-slide"><?php _e('Reverse Slide', 'jig_td'); ?></option>
                        <option value="reverse-mixed"><?php _e('Reverse Mixed', 'jig_td'); ?></option>
                        <option value="below"><?php _e('Below the image', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose how would you like the caption to appear. Reverse does the opposite, shows all text then fades/slides them out on mouse over.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Mobile caption', 'jig_td'); ?></div>
                    <label>mobile_caption</label>
                    <select name="mobile_caption">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="same"><?php _e('Same as desktop.', 'jig_td'); ?></option>
                        <option value="fixed"><?php _e('Fixed - Whole caption is always visible.', 'jig_td'); ?></option>
                        <option value="below"><?php _e('Below the image', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Caption behavior for mobile devices.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Caption opacity', 'jig_td'); ?></div>
                    <label>caption_opacity</label>
                    <input type="text" name="caption_opacity" value='' />
                    <div class="minihelp"><?php _e('Opacity for the entire caption, enter a number between 0 and 1.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Caption background color', 'jig_td'); ?></div>
                    <label>caption_bg_color</label>
                    <input type="text" name="caption_bg_color" value='' />
                    <div class="minihelp"><?php _e('Enter any CSS color, or the word transparent. You can use the color picker in the top right corner. For opacity use rgba(0,0,0,0.3) but only when the Caption opacity is set to 1.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Title bg matches text width', 'jig_td'); ?></div>
                    <label>caption_match_width</label>
                    <select name="caption_match_width">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No, display the caption background at full width.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, only show the background as far as the text goes.', 'jig_td'); ?></option>
                        <option value="yes-rounded"><?php _e('Yes, and also add some rounded corners (dossier style).', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Show the caption title background only behind the text.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Caption text color', 'jig_td'); ?></div>
                    <label>caption_text_color</label>
                    <input type="text" name="caption_text_color" value='' />
                    <div class="minihelp"><?php _e('Any CSS color (HEX, name of the color) except rgba.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Caption height only for the "Below the image" style', 'jig_td'); ?></div>
                    <label>caption_height</label>
                    <input type="text" name="caption_height" value='' />
                    <div class="minihelp"><?php _e('Set a uniform caption height that will only be used when caption is set to "Below the image". Accepts a number without px.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Caption height on mobiles', 'jig_td'); ?></div>
                    <label>mobile_caption_height</label>
                    <input type="text" name="mobile_caption_height" value='' />
                    <div class="minihelp"><?php _e('Same as previous but you can set a different height for mobiles.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Caption title size', 'jig_td'); ?></div>
                    <label>caption_title_size</label>
                    <input type="text" name="caption_title_size" value='' />
                    <div class="minihelp"><?php _e('Any CSS font-size, e.g. 16<strong>px</strong>, leave empty to use the global CSS.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Caption description size', 'jig_td'); ?></div>
                    <label>caption_desc_size</label>
                    <input type="text" name="caption_desc_size" value='' />
                    <div class="minihelp"><?php _e('Any CSS font-size, e.g. 12<strong>px</strong>, leave empty to use the global CSS.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Align', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Horizontal caption text-align', 'jig_td'); ?></div>
                    <label>caption_align</label>
                    <select name="caption_align">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="css"><?php _e('CSS: Respect the text-align settings below (Caption title CSS + Caption description CSS).', 'jig_td'); ?></option>
                        <option value="left"><?php _e('Left', 'jig_td'); ?></option>
                        <option value="center"><?php _e('Center', 'jig_td'); ?></option>
                        <option value="right"><?php _e('Right', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Align both captions horizontally.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Vertically center captions', 'jig_td'); ?></div>
                    <label>v_center_captions</label>
                    <select name="v_center_captions">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off: Display them at the bottom.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: (center both axes, animate from center, overrides text-align CSS).', 'jig_td'); ?></option>
                        <option value="simple"><?php _e("Simple: Same as 'Yes', but doesn't animate from center (slide and mixed styles).", 'jig_td'); ?></option>
                        <option value="vertical_only"><?php _e('Vertical only: (no horizontal centering, keeps text-align CSS, animate from center).', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Makes captions appear in the middle of the image.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Vertically center: Custom fonts', 'jig_td'); ?></div>
                    <label>custom_fonts</label>
                    <select name="custom_fonts">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, I use custom fonts, apply a fix.', 'jig_td'); ?></option>
                        <option value="no"><?php _e("No, I don't use custom fonts.", 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('If the vertical centering is not perfect, you are using custom fonts.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('What text to show on the thumbnails', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('WP field to use for title (main) *', 'jig_td'); ?></div>
                    <label>title_field</label>
                    <select name="title_field">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="title"><?php _e('Title', 'jig_td'); ?></option>
                        <option value="description"><?php _e('Description', 'jig_td'); ?></option>
                        <option value="caption"><?php _e('Caption', 'jig_td'); ?></option>
                        <option value="alternate"><?php _e('Alternate', 'jig_td'); ?></option>
                        <option value="custom"><?php _e('Custom field', 'jig_td'); ?></option>

                        <option value="off"><?php _e('Off: Do not display.', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e('Choose a WP field as title from the image details.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('WP field to use for caption *', 'jig_td'); ?></div>
                    <label>caption_field</label>
                    <select name="caption_field">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="title"><?php _e('Title', 'jig_td'); ?></option>
                        <option value="description"><?php _e('Description', 'jig_td'); ?></option>
                        <option value="caption"><?php _e('Caption', 'jig_td'); ?></option>
                        <option value="alternate"><?php _e('Alternate', 'jig_td'); ?></option>
                        <option value="custom"><?php _e('Custom field', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off: Do not display.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose a WP field as caption description from the image details.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Caption custom field', 'jig_td'); ?></div>
                    <label>caption_custom_field</label>
                    <input type="text" name="caption_custom_field" value='' />
                    <div class="minihelp"><?php _e('1 or 2 WP custom field(s), comma separated, to be used with one or both of the above settings, respectively.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="longHelp"><?php _e('* Note: NextGEN, Facebook, Instagram, Flickr title/description (or equivalent) fields act in place of WP Title and Description fields.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Extra', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Text shadow', 'jig_td'); ?></div>
                    <label>caption_text_shadow</label>
                    <input type="text" name="caption_text_shadow" value='' />
                    <div class="minihelp"><?php _e("Set shadow on the text of the caption. Example: 1px 1px 0 black<br/>(x, y, blur, color - respectively). It's only applied when Caption opacity is set to 1. Doesn't work under IE10 so don't depend on it.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Gradient caption background', 'jig_td'); ?></div>
                    <label>gradient_caption_bg</label>
                    <select name="gradient_caption_bg">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No, use the simple color options.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, use the CSS gradient (set up in the settings).', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Use a Facebook-style gradient for the caption background.', 'jig_td'); ?></div>
                </div>

            </div>
            <h3 class="jigTabTitle" id="jigOverlayEffects"><?php _e('Overlay effects', 'jig_td'); ?></h3>
            <div id="jig_overlay_tab_content" class="jigSettingsTab jig_settings_group clearfix">
                <div class="flexirow">
                    <div class="helpText"><a href="https://justifiedgrid.com/features/adaptive-colors-customization/" target="_blank"><?php _e("See what's possible with Overlay effects!", 'jig_td'); ?></a>
                    </div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Overlay appearance and style', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Overlay type', 'jig_td'); ?></div>
                    <label>overlay</label>
                    <select name="overlay">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="others"><?php _e('Others', 'jig_td'); ?></option>
                        <option value="hovered"><?php _e('Hovered', 'jig_td'); ?></option>
                        <option value="everything"><?php _e('Everything has color overlay', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose a behavior for the overlay.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Mobile overlay type', 'jig_td'); ?></div>
                    <label>mobile_overlay</label>
                    <select name="mobile_overlay">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="same"><?php _e('Same as desktop.', 'jig_td'); ?></option>
                        <option value="everything"><?php _e('Everything has color overlay.', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off: No overlay.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Overlay behavior for mobile devices.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Overlay opacity', 'jig_td'); ?></div>
                    <label>overlay_opacity</label>
                    <input type="text" name="overlay_opacity" value='' />
                    <div class="minihelp"><?php _e('A number between 0 and 1.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Overlay color', 'jig_td'); ?></div>
                    <label>overlay_color</label>
                    <input type="text" name="overlay_color" value='' />
                    <div class="minihelp"><?php _e('Any CSS color (HEX, name of the color) except rgba.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Overlay icon on the thumbnails', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Overlay icon', 'jig_td'); ?></div>
                    <label>overlay_icon</label>
                    <select name="overlay_icon">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="off"><?php _e("Off: Don't display the icon in the overlay.", 'jig_td'); ?></option>
                        <option value="on"><?php _e('On: Display the icon.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Enable to display an icon in the middle of the thumbnails.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Overlay icon opacity', 'jig_td'); ?></div>
                    <label>overlay_icon_opacity</label>
                    <input type="text" name="overlay_icon_opacity" value='' />
                    <div class="minihelp"><?php _e('A number between 0 and 1.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Overlay icon URL', 'jig_td'); ?></div>
                    <label>overlay_icon_url</label>
                    <input type="text" name="overlay_icon_url" value='' />
                    <div class="minihelp"><?php _e('Path to your icon or leave empty for the default magnifier icon.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Overlay icon retina URL', 'jig_td'); ?></div>
                    <label>overlay_icon_retina</label>
                    <input type="text" name="overlay_icon_retina" value='' />
                    <div class="minihelp"><?php _e('2x size image of your Overlay icon. Default is the 2x version of the magnifier, or if set, the 1x version of your Overlay icon.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Shadows', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Outer shadow', 'jig_td'); ?></div>
                    <label>outer_shadow</label>
                    <input type="text" name="outer_shadow" value='' />
                    <div class="minihelp"><?php _e('CSS3 shadow value: "0 0 3px black" - may decrease performance.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Inner shadow', 'jig_td'); ?></div>
                    <label>inner_shadow</label>
                    <input type="text" name="inner_shadow" value='' />
                    <div class="minihelp"><?php _e('CSS3 shadow value: "0 0 30px black" - only when overlay is in use.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Borders', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Outer (standard) border width', 'jig_td'); ?></div>
                    <label>outer_border_width</label>
                    <input type="text" name="outer_border_width" value='' />
                    <div class="minihelp"><?php _e('A number in pixels, without "px" - 0 to turn off, empty for default.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Outer (standard) border color', 'jig_td'); ?></div>
                    <label>outer_border_color</label>
                    <input type="text" name="outer_border_color" value='' />
                    <div class="minihelp"><?php _e('Any CSS color value.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Outer border behavior', 'jig_td'); ?></div>
                    <label>outer_border</label>
                    <select name="outer_border">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="always"><?php _e('Always', 'jig_td'); ?></option>
                        <option value="others"><?php _e('Others', 'jig_td'); ?></option>
                        <option value="hovered"><?php _e('Hovered', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Control the outer border with the mouse or let it be static.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Middle (spacing) border width', 'jig_td'); ?></div>
                    <label>middle_border_width</label>
                    <input type="text" name="middle_border_width" value='' />
                    <div class="minihelp"><?php _e('A number in pixels, without "px" - 0 to turn off, empty for default.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Middle (spacing) border color', 'jig_td'); ?></div>
                    <label>middle_border_color</label>
                    <input type="text" name="middle_border_color" value='' />
                    <div class="minihelp"><?php _e('Any CSS color, usually white, also affects tile background color.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Middle border behavior', 'jig_td'); ?></div>
                    <label>middle_border</label>
                    <select name="middle_border">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="always"><?php _e('Always', 'jig_td'); ?></option>
                        <option value="others"><?php _e('Others', 'jig_td'); ?></option>
                        <option value="hovered"><?php _e('Hovered', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Control the middle border with the mouse or let it be static.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Inner (on-image) border width', 'jig_td'); ?></div>
                    <label>inner_border_width</label>
                    <input type="text" name="inner_border_width" value='' />
                    <div class="minihelp"><?php _e('A number in pixels, without "px" - 0 to turn off, empty for default.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Inner (on-image) border color', 'jig_td'); ?></div>
                    <label>inner_border_color</label>
                    <input type="text" name="inner_border_color" value='' />
                    <div class="minihelp"><?php _e('Any CSS color, especially recommended rgba(0,0,0,0.1) this is Facebook-style.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Inner border behavior', 'jig_td'); ?></div>
                    <label>inner_border</label>
                    <select name="inner_border">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="always"><?php _e('Always', 'jig_td'); ?></option>
                        <option value="others"><?php _e('Others', 'jig_td'); ?></option>
                        <option value="hovered"><?php _e('Hovered', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Control the inner border with the mouse or let it be static.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Inner border animate', 'jig_td'); ?></div>
                    <label>inner_border_animate</label>
                    <select name="inner_border_animate">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="width"><?php _e('Width only', 'jig_td'); ?></option>
                        <option value="opacity"><?php _e('Opacity only', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e("The mouse controlled inner border's animation style.", 'jig_td'); ?></div>
                </div>
            </div>
            <h3 class="jigTabTitle" id="jigSpecialEffects"><?php _e('Special effects', 'jig_td'); ?></h3>
            <div id="jig_specialfx_tab_content" class="jigSettingsTab jig_settings_group clearfix">
                <div class="flexirow">
                    <div class="helpText">
                        <a href="https://justifiedgrid.com/features/special-effects/" target="_blank"><?php _e('See examples and learn more about the Special effects!', 'jig_td'); ?></a>
                    </div>
                </div>
                <div class="dashedLine"></div>
                <div class="row">
                    <div class="normalName"><?php _e('Special effects behavior', 'jig_td'); ?></div>
                    <label>specialfx</label>
                    <select name="specialfx">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off', 'jig_td'); ?></option>
                        <option value="others"><?php _e('Others', 'jig_td'); ?></option>
                        <option value="hovered"><?php _e('Hovered', 'jig_td'); ?></option>
                        <option value="everything"><?php _e('Everything', 'jig_td'); ?></option>
                        <option value="captions"><?php _e('Only apply behind captions, if any.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose a behavior for the special effects like desaturation.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Mobile special effects', 'jig_td'); ?></div>
                    <label>mobile_specialfx</label>
                    <select name="mobile_specialfx">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="same"><?php _e('Same as desktop', 'jig_td'); ?></option>
                        <option value="off"><?php _e('Off', 'jig_td'); ?></option>
                        <option value="everything"><?php _e('Everything', 'jig_td'); ?></option>
                        <option value="captions"><?php _e('Only apply behind captions, if any.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Alternative behavior for special effects on mobile devices. Turn off if you have lots of images as it may decrease performance.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Special effects type', 'jig_td'); ?></div>
                    <label>specialfx_type</label>
                    <select name="specialfx_type">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="desaturate"><?php _e('Desaturate', 'jig_td'); ?></option>
                        <option value="blur"><?php _e('Blur', 'jig_td'); ?></option>
                        <option value="glow"><?php _e('Glow', 'jig_td'); ?></option>
                        <option value="sepia"><?php _e('Sepia', 'jig_td'); ?></option>
                        <option value="laplace_dark"><?php _e('Laplace dark (edge detection).', 'jig_td'); ?></option>
                        <option value="laplace_light"><?php _e('Laplace light (edge detection).', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Choose a special effect to apply.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Caption special effect visibility', 'jig_td'); ?></div>
                    <label>caption_fx_visibility</label>
                    <select name="caption_fx_visibility">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="in_front_of_overlay"><?php _e('In front of the overlay (unaffected by it).', 'jig_td'); ?></option>
                        <option value="behind_overlay"><?php _e('Behind the overlay (affected by it).', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Only when special effect is set to only apply behind captions! Whether or not the overlay effects affect the special effect.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Special effects blend', 'jig_td'); ?></div>
                    <label>specialfx_blend</label>
                    <input type="text" name="specialfx_blend" value='' />
                    <div class="minihelp"><?php _e('Enter a value between 0.1 and 1 to control how much you see the special effect over the original image.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Special effects options', 'jig_td'); ?></div>
                    <label>specialfx_options</label>
                    <input type="text" name="specialfx_options" value='' />
                    <div class="minihelp"><?php echo sprintf(__('Advanced setting, refer to JIG documentation and the %1$s docs. Example (default for glow): amount:0.3,radius:0.2', 'jig_td'), '<a href="http://www.pixastic.com/lib/docs/" target="_blank">Pixastic</a>'); ?></div>
                </div>
            </div>

            <h3 class="jigTabTitle" id="jigNextGEN"><?php _e('NextGEN', 'jig_td'); ?></h3>
            <div id="jig_nextgen_tab_content" class="jigSettingsTab jig_settings_group_nextgen clearfix" id="nextgen">
<?php

if (isset($wpdb->nggallery) !== false) {
    $galleries = $wpdb->get_results("SELECT gid,title FROM {$wpdb->nggallery} ORDER BY gid LIMIT 0,10000");
    $albums = $wpdb->get_results("SELECT id,name FROM {$wpdb->nggalbum} ORDER BY id LIMIT 0,10000"); ?>
                    <div class="flexirow">
                        <div class="helpText">
                            <a href="https://justifiedgrid.com/sources/nextgen-gallery/" target="_blank"><?php _e('See examples and learn more about NextGEN Gallery!', 'jig_td'); ?></a>
                        </div>
                    </div>
                    <div class="row generalDashedRow">
                        <div class="longHelp"><?php _e('What content to show from NextGEN gallery (choose one type)', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Gallery ID', 'jig_td'); ?></div>
                        <label>ng_gallery</label>
                        <select name="ng_gallery" class="long_select abilityToMorph">
<?php

    if (!empty($galleries)) {
        echo '<option class="noCheckboxForThis" value="">' . __('I want to use multiple (switch to checkboxes)', 'jig_td') . '</option>';
        echo '<option value="default" selected="selected" class="noCheckboxForThis">' . __('Do not use.', 'jig_td') . '</option>';
        foreach ($galleries as $val) {
            echo '<option value="' . $val->gid . '">' . stripcslashes($val->gid . ' - ' . $val->title) . '</option>';
        }
        $val = null;
        unset($val);
    } else {
        echo '<option value="default" selected="selected">' . __('No galleries.', 'jig_td') . '</option>';
    } ?>
                        </select>
                        <div class="minihelp minihelpShort"><?php _e('Choose a NextGEN gallery.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Album ID', 'jig_td'); ?></div>
                        <label>ng_album</label>
                        <select name="ng_album" class="long_select abilityToMorph">
<?php

    if (!empty($albums)) {
        echo '<option class="noCheckboxForThis" value="">' . __('I want to use multiple (switch to checkboxes)', 'jig_td') . '</option>';
        echo '<option value="default" selected="selected" class="noCheckboxForThis">' . __('Do not use.', 'jig_td') . '</option>';
        if (!empty($galleries)) {
            echo '<option class="noCheckboxForThis" value="all" >' . __('Overview album (all galleries).', 'jig_td') . '</option>';
        }
        foreach ($albums as $val) {
            echo '<option value="' . $val->id . '">' . stripcslashes($val->id . ' - ' . $val->name) . '</option>';
        }
        $val = null;
        unset($val);
    } else {
        echo '<option value="default" selected="selected">' . __('No albums.', 'jig_td') . '</option>';
        if (!empty($galleries)) {
            echo '<option value="all" >' . __('Overview album (all galleries).', 'jig_td') . '</option>';
        }
    } ?>
                        </select>
                        <div class="minihelp minihelpShort"><?php _e('OR choose a NextGEN album.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Single picture(s) by ID', 'jig_td'); ?></div>
                        <label>ng_pics</label>
                        <input type="text" name="ng_pics" value='' />
                        <div class="minihelp"><?php _e('OR image IDs, comma separated if more than one, accepts ranges.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Tags gallery', 'jig_td'); ?></div>
                        <label>ng_tags_gallery</label>
                        <input type="text" name="ng_tags_gallery" value='' />
                        <div class="minihelp"><?php _e('OR tag(s), comma separated, to be displayed as a gallery.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Tags album', 'jig_td'); ?></div>
                        <label>ng_tags_album</label>
                        <input type="text" name="ng_tags_album" value='' />
                        <div class="minihelp"><?php _e('OR tag(s), comma separated, to be displayed as an album.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Recent galleries', 'jig_td'); ?></div>
                        <label>ng_recent_galleries</label>
                        <input type="text" name="ng_recent_galleries" value='' />
                        <div class="minihelp"><?php _e('Number of recent galleries to show in an album created on the fly.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Recent images', 'jig_td'); ?></div>
                        <label>ng_recent_images</label>
                        <select name="ng_recent_images">
                            <option value="default" selected="selected"><?php _e('Do not use.', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes: by upload date (NG 1.9.x style).', 'jig_td'); ?></option>
                            <option value="yes_exif"><?php _e('Yes: by image/exif date (NG 2 style).', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('OR show the 25 most recent images regardless of gallery. You can modify the limit in the general settings.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Random images', 'jig_td'); ?></div>
                        <label>ng_random_images</label>
                        <select name="ng_random_images" class="abilityToMorph">
                            <option value="default" selected="selected" class="noCheckboxForThis"><?php _e('Do not use.', 'jig_td'); ?></option>
                            <option value="yes" class="noCheckboxForThis"><?php _e('Yes: all random images.', 'jig_td'); ?></option>
<?php

    if (!empty($galleries)) {
        echo '<option class="noCheckboxForThis" value="">' . __('I want to use multiple (switch to checkboxes)', 'jig_td') . '</option>';
        foreach ($galleries as $val) {
            echo '<option value="' . $val->gid . '">' . stripcslashes($val->gid . ' - ' . $val->title) . '</option>';
        }
        $val = null;
        unset($val);
    } ?>
                        </select>
                        <div class="minihelp"><?php _e("OR show random images regardless of gallery or from a specific one. Don't forget to limit, which is applied <b>after</b> the randomization. The default limit is 25, which you can modify in the general settings.", 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Search query', 'jig_td'); ?></div>
                        <label>ng_search_query</label>
                        <input type="text" name="ng_search_query" value='' />
                        <div class="minihelp"><?php _e('OR search for anything in NextGEN. Accepts comma separated multiple queries. Useful in a template tag!', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Search options', 'jig_td'); ?></div>
                        <label>ng_search_options</label>
                        <select name="ng_search_options" class="abilityToMorph">
                            <option value="default" selected="selected" class="noCheckboxForThis"><?php _e('Everywhere.', 'jig_td'); ?></option>
                            <option class="noCheckboxForThis" value=""><?php _e('I want to use multiple (switch to checkboxes)', 'jig_td'); ?></option>
                            <option value="tag">Tags</option>
                            <option value="filename">File name</option>
                            <option value="alttext">Alt &amp; Title Text</option>
                            <option value="description">Description</option>
                        </select>
                        <div class="minihelp"><?php _e('Choose where to search with the previous setting.', 'jig_td'); ?></div>
                    </div>
                    <div class="row generalDashedRow">
                        <div class="longHelp"><?php _e('Behavior options', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Display album and photo count', 'jig_td'); ?></div>
                        <label>ng_count</label>
                        <select name="ng_count">
                            <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes: display the counters.', 'jig_td'); ?></option>
                            <option value="no"><?php _e('No: do not display the counters.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e("Make the thumbnail's caption display the count of photos in a gallery. Also, the count of subalbums/galleries in albums.", 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Open galleries in lightbox', 'jig_td'); ?></div>
                        <label>ng_lightbox_gallery</label>
                        <select name="ng_lightbox_gallery">
                            <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                            <option value="no"><?php _e('No: open them on their own page.', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes: Open them in the lightbox.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('In album views, open the galleries in the lightbox on the same page.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Show album/gallery description', 'jig_td'); ?></div>
                        <label>ng_description</label>
                        <select name="ng_description">
                            <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                            <option value="no"><?php _e('No', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('Display gallery or album description (if any) above the grid.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Intersect tags or search query', 'jig_td'); ?></div>
                        <label>ng_intersect_tags</label>
                        <select name="ng_intersect_tags">
                            <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                            <option value="no"><?php _e('No, match ANY of the chosen tags / queries', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes, match ALL of the chosen tags / queries', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('Match mode for NG tag galleries or NG search queries.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Narrow by tags', 'jig_td'); ?></div>
                        <label>ng_narrow_by_tags</label>
                        <input type="text" name="ng_narrow_by_tags" value='' />
                        <div class="minihelp"><?php _e('Only images with any of these will be shown.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Display tags', 'jig_td'); ?></div>
                        <label>ng_display_tags</label>
                        <select name="ng_display_tags">
                            <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                            <option value="no"><?php _e("No: Don't show the tags.", 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes: Shows tags on thumbnails and in the lightbox.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('Tags (italic, comma separated) will be added to  the description field.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Gallery-wide custom links', 'jig_td'); ?></div>
                        <label>ng_gallery_links</label>
                        <select name="ng_gallery_links">
                            <option value="default" selected="selected"><?php _e('Do not use.', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes: make use of gallery-wide custom links.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('Link to the parent gallery from a thumbnail with this. Use "Link to page" on a NextGEN gallery or add the URL of the gallery to a field by NGG Custom Fields plugin on the gallery.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('NextGEN custom field for Links', 'jig_td'); ?></div>
                        <label>nextgen_cf_link</label>
                        <input type="text" name="nextgen_cf_link" value='' />
                        <div class="minihelp"><?php _e('Enter the name of the custom field you set up for links.', 'jig_td'); ?></div>
                    </div>
                    <div class="row generalDashedRow">
                        <div class="longHelp"><?php _e('Settings for the built-in JIG Breadcrumb for NextGEN', 'jig_td'); ?></div>
                    </div>
                    <div class="row" id="ngBcRow">
                        <div class="longHelp"><?php _e('Breadcrumb example: <span class="ngBcHelp">base:</span> You are here: <span class="ngBcHelp">home:</span> Overview <span class="ngBcHelp">separator:</span> &raquo; <span class="ngBcHelp">album:</span> Colors <span class="ngBcHelp">separator:</span> &raquo; <span class="ngBcHelp">gallery, last element:</span> Orange <span class="ngBcHelp">additional separator:</span> &raquo; ', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Breadcrumb', 'jig_td'); ?></div>
                        <label>ng_breadcrumb</label>
                        <select name="ng_breadcrumb">
                            <option value="default" selected="selected"><?php _e('Do not use.', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes: use the breadcrumb.', 'jig_td'); ?></option>

                        </select>
                        <div class="minihelp"><?php _e('Show a path to the current gallery. Set up with the settings below.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Separator character', 'jig_td'); ?></div>
                        <label>ng_bc_separator</label>
                        <select name="ng_bc_separator">
                            <option value="default" selected="selected">&raquo;</option>
                            <option value="greater">&gt;</option>
                            <option value="comma">,</option>
                            <option value="slash">/</option>
                            <option value="doubleslash">//</option>
                            <option value="minus">-</option>
                            <option value="plus">+</option>
                            <option value="arrow">&rarr;</option>
                            <option value="bslash">\</option>
                            <option value="doublebslash">\\</option>
                            <option value="middledot">·</option>
                            <option value="dobulecolon">::</option>
                            <option value="numbersign">#</option>
                        </select>
                        <div class="minihelp"><?php _e('This is the character that separates path elements.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Base element: custom text', 'jig_td'); ?></div>
                        <label>ng_bc_base</label>
                        <input type="text" name="ng_bc_base" value='' />
                        <div class="minihelp"><?php _e("This is the first, non-clickable text of the breadcrumb, default is 'You are here:', to turn off, enter the word: none.", 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Home element', 'jig_td'); ?></div>
                        <label>ng_bc_home</label>
                        <select name="ng_bc_home">
                            <option value="default" selected="selected"><?php _e('Post title.', 'jig_td'); ?></option>
                            <option value="custom_text"><?php _e('Custom text.', 'jig_td'); ?></option>
                            <option value="album_name"><?php _e('Album name (automatic).', 'jig_td'); ?></option>
                            <option value="none"><?php _e('Do not use.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('This is the second, optionally-clickable text that is the gallery home.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Home element: custom text', 'jig_td'); ?></div>
                        <label>ng_bc_home_text</label>
                        <input type="text" name="ng_bc_home_text" value='' />
                        <div class="minihelp"><?php _e("This is for the 'Custom text' from above, default is Home.", 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Home element: clickable', 'jig_td'); ?></div>
                        <label>ng_bc_home_clickable</label>
                        <select name="ng_bc_home_clickable">
                            <option value="default" selected="selected"><?php _e('Clickable', 'jig_td'); ?></option>
                            <option value="no"><?php _e('Not clickable.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('When clickable, the home element links back to the original page.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Last element: clickable', 'jig_td'); ?></div>
                        <label>ng_bc_last_clickable</label>
                        <select name="ng_bc_last_clickable">
                            <option value="default" selected="selected"><?php _e('Not clickable.', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Clickable', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('The last (current) element in the breadcrumb can be a link.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Show top level breadcrumb', 'jig_td'); ?></div>
                        <label>ng_bc_top_level</label>
                        <select name="ng_bc_top_level">
                            <option value="default" selected="selected"><?php _e('Yes', 'jig_td'); ?></option>
                            <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('Show breadcrumb on the top level page: When only the base and home elements are visible. This is when no albums or galleries are in the breadcrumb path. The breacrumb may be unncessary then.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Add separator at the end', 'jig_td'); ?></div>
                        <label>ng_bc_add_separator</label>
                        <select name="ng_bc_add_separator">
                            <option value="default" selected="selected"><?php _e('No', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('Show an additional separator at the very end of the breadcrumb.', 'jig_td'); ?></div>
                    </div>
<?php
    $galleries = $albums = null;
    unset($galleries, $albums);
} else {
    ?>
                    <div class="row">
                        <div class="normalName notInstalled"><?php _e('NextGEN is not installed!', 'jig_td'); ?><br><a href="https://justifiedgrid.com/sources/nextgen-gallery/" target="_blank"><?php _e('See examples and learn more about NextGEN Gallery!', 'jig_td'); ?></a></div>
                    </div>
<?php
} // end of NextGEN

?>
            </div>

            <h3 class="jigTabTitle" id="jigRML"><?php _e('WP Real Media Library', 'jig_td'); ?></h3>
            <div id="jig_rml_tab_content" class="jigSettingsTab jig_settings_group_rml clearfix" id="rml">
<?php

if (!class_exists('RML_Core') && !class_exists('MatthiasWeb\RealMediaLibrary\general\Core')) {
    ?>
                    <div class="row">
                        <div class="normalName notInstalled">
                            <?php echo sprintf(__('WP Real Media Library is not installed! Purchase your copy on %s', 'jig_td'), '<a href="https://1.envato.market/LVqKZ" target="_blank">CodeCanyon</a>') ?><br><a href="https://justifiedgrid.com/sources/wp-real-media-library/" target="_blank"><?php _e('See examples and learn more about WP Real Media Library!', 'jig_td'); ?></a>
                        </div>
                    </div>
<?php
} elseif (defined('RML_VERSION') && version_compare(RML_VERSION, '2.3', '<')) {
    echo '<div class="row"><div class="normalName notInstalled">' . __('Your WP Real Media Library is too old and is not yet compatible with Justified Image Grid, please update it!', 'jig_td') . '</div></div>';
} else {
    ?>
                    <div class="flexirow">
                        <div class="helpText">
                            <a href="https://justifiedgrid.com/sources/wp-real-media-library/" target="_blank"><?php _e('See examples and learn more about WP Real Media Library!', 'jig_td'); ?></a>
                        </div>
                    </div>
                    <div class="row generalDashedRow">
                        <div class="longHelp"><?php _e('What content to show from WP Real Media Library', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('RML content', 'jig_td'); ?></div>
                        <label>rml_id</label>
                        <select id="rml_id" name="rml_id" class="long_select abilityToMorph" <?php
    if (version_compare(RML_VERSION, '4.0.0', '>=')) {
        echo 'data-tree="' . esc_attr(json_encode(wp_rml_structure()->getPlainTree())) . '"';
    } ?>>
                            <option value="default" selected="selected" class="noCheckboxForThis"><?php _e('Do not use.', 'jig_td'); ?></option>
                            <option class="noCheckboxForThis" value=""><?php _e('I want to use multiple (switch to checkboxes)', 'jig_td'); ?></option>
                            <option value="overview" class="rml-type-folder noCheckboxForThis"><?php _e('Overview of top level objects', 'jig_td'); ?></option>
                            <option value="-1" class="rml-type-gallery noCheckboxForThis"><?php _e('Unorganized pictures', 'jig_td'); ?></option>
                        </select>
<?php

    if (version_compare(RML_VERSION, '4.0.0', '<')) {
        $tree = wp_rml_select_tree('unused', null, wp_rml_root_childs());
        echo str_replace('<input type="hidden" name="unused" value="" />', '', $tree);
    } ?>

                        <div class="minihelp minihelpShort"><?php _e('Choose a folder, collection, gallery or everything.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Flatten hierarchy', 'jig_td'); ?></div>
                        <label>rml_flatten</label>
                        <select name="rml_flatten" class="long_select">
                            <option value="no" selected="selected"><?php _e('No: show the tree as is.', 'jig_td'); ?></option>
                            <option value="contents"><?php _e('Contents: expand everything to a single big gallery.', 'jig_td'); ?></option>
                            <option value="galleries"><?php _e('Galleries: look for and stop at galleries for an on-the-fly collection.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e("Show everything under selected point(s) in the RML tree.", 'jig_td'); ?></div>
                    </div>
                    <div class="row generalDashedRow">
                        <div class="longHelp"><?php _e('Behavior options', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Display content count', 'jig_td'); ?></div>
                        <label>rml_count</label>
                        <select name="rml_count">
                            <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes: display the counters.', 'jig_td'); ?></option>
                            <option value="no"><?php _e('No: do not display the counters.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e("Make the thumbnail's caption display the count of contained folders, collections, galleries and photos in RML objects.", 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Show description', 'jig_td'); ?></div>
                        <label>rml_description</label>
                        <select name="rml_description">
                            <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                            <option value="no"><?php _e("No: Don't display the description.", 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes: Display description above the grid and on the thumbnail.', 'jig_td'); ?></option>
                            <option value="grid"><?php _e('Only above the grid.', 'jig_td'); ?></option>
                            <option value="thumbnail"><?php _e('Only on the thumbnail.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('Display the description (if any) belonging to folders, collections or galleries.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Open galleries in lightbox', 'jig_td'); ?></div>
                        <label>rml_lightbox_groups</label>
                        <select name="rml_lightbox_groups">
                            <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                            <option value="no"><?php _e('No: open them on their own page.', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes: Open them in the lightbox.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('When showing an RML collection, open the contained galleries in the lightbox on the same page. Note: not compatible with Social Gallery and Jetpack Carousel lightboxes.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Extend filtering beyond galleries', 'jig_td'); ?></div>
                        <label>rml_extend_filtering</label>
                        <select name="rml_extend_filtering">
                            <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                            <option value="no"><?php _e('No: Only allow filtering the gallery.', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes: Allow filtering in folders / collections.', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('In special cases, filtering can be extended to folder and collection views. Terms are pulled from the cover picture.', 'jig_td'); ?></div>
                    </div>
                    <div class="row generalDashedRow">
                        <div class="longHelp"><?php _e('Settings for the built-in JIG Breadcrumb for WP RML', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Breadcrumb', 'jig_td'); ?></div>
                        <label>rml_breadcrumb</label>
                        <select name="rml_breadcrumb">
                            <option value="default" selected="selected"><?php _e('Yes: use it.', 'jig_td'); ?></option>
                            <option value="no"><?php _e('Do not use.', 'jig_td'); ?></option>

                        </select>
                        <div class="minihelp"><?php _e('Show a path to the current content. Set up with the settings below.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Show top level breadcrumb', 'jig_td'); ?></div>
                        <label>rml_bc_top_level</label>
                        <select name="rml_bc_top_level">
                            <option value="default" selected="selected"><?php _e('No', 'jig_td'); ?></option>
                            <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                        </select>
                        <div class="minihelp"><?php _e('Show breadcrumb on the top level page: When only the base and home elements are visible. This is when no folder, collections or galleries are in the breadcrumb path. The breacrumb is usually unncessary then.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Separator character', 'jig_td'); ?></div>
                        <label>rml_bc_separator</label>
                        <select name="rml_bc_separator">
                            <option value="default" selected="selected">&raquo;</option>
                            <option value="greater">&gt;</option>
                            <option value="comma">,</option>
                            <option value="slash">/</option>
                            <option value="doubleslash">//</option>
                            <option value="minus">-</option>
                            <option value="plus">+</option>
                            <option value="arrow">&rarr;</option>
                            <option value="bslash">\</option>
                            <option value="doublebslash">\\</option>
                            <option value="middledot">·</option>
                            <option value="dobulecolon">::</option>
                            <option value="numbersign">#</option>
                        </select>
                        <div class="minihelp"><?php _e('This is the character that separates path elements.', 'jig_td'); ?></div>
                    </div>
                    <div class="row">
                        <div class="normalName"><?php _e('Breadcrumb home text', 'jig_td'); ?></div>
                        <label>rml_bc_home_text</label>
                        <input type="text" name="rml_bc_home_text" value='' />
                        <div class="minihelp"><?php _e("You can override the home element's name with custom text.", 'jig_td'); ?></div>
                    </div>
                <?php
} ?>
            </div>

            <h3 class="jigTabTitle" id="jigRecentPosts"><?php _e('Recent posts', 'jig_td'); ?></h3>
            <div id="jig_recent_posts_tab_content" class="jigSettingsTab jig_settings_group_recents clearfix">
                <div class="flexirow">
                    <div class="helpText"><?php _e("Create a gallery of posts by their featured images. They'll automatically link to the posts. You are not limited to posts, nor the order or the number of pictures is written in stone. The automatic excerpt helps you when you do not have a manual one so you can have both: manual excerpt when set, automatic otherwise. You can create a homepage banner with this feature.", 'jig_td'); ?> <a href="https://justifiedgrid.com/sources/wordpress/recent-posts-pages/" target="_blank"><?php _e('See examples and learn more about the Recent Posts feature!', 'jig_td'); ?></a></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Core settings', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Use recent posts', 'jig_td'); ?></div>
                    <label>recent_posts</label>
                    <select name="recent_posts">
                        <option value="default" selected="selected"><?php _e('Do not use.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: use recent posts.', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e('Choose yes if you wish to create a grid of recent posts.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Post type', 'jig_td'); ?></div>
                    <label>recents_post_type</label>
                    <select name="recents_post_type" class="abilityToMorph">
                        <option class="noCheckboxForThis" value=""><?php _e('I want to use multiple (switch to checkboxes)', 'jig_td'); ?></option>
<?php

if (!empty($wp_post_types)) {
    foreach ($wp_post_types as $post_type => $post_type_value) {
        if ($post_type !== 'attachment' && $post_type !== 'revision' && $post_type !== 'nav_menu_item' && strpos($post_type_value->labels->name, 'NextGEN Gallery') === false) {
            if ($post_type !== 'post') {
                echo '<option value="' . $post_type . '">' . $post_type_value->labels->name . ' (' . $post_type . ')</option>';
            } else {
                echo '<option selected="selected" class="selectedByDefault" value="post">Post (post)</option>';
            }
        }
    }
    $post_type = $post_type_value = null;
    unset($post_type, $post_type_value);
} else {
    echo '<option selected="selected" value="post">post</option><option value="page">page</option>';
}

?>
                    </select>
                    <div class="minihelp"><?php _e('The custom post types/pages must still have featured images!', 'jig_td'); ?></div>
                </div>

                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('What to display as caption on the thumbnails', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Display in the description', 'jig_td'); ?></div>
                    <label>recents_description</label>
                    <select name="recents_description">
<?php

$recents_description_options =
'<option value="default" selected="selected">' . __('Nothing.', 'jig_td') . '</option>
<option value="auto_excerpt">' . __('Auto excerpt only.', 'jig_td') . '</option>
<option value="manual_excerpt">' . __('Manual excerpt only.', 'jig_td') . '</option>
<option value="auto_manual_excerpt">' . __('Auto or manual excerpt.', 'jig_td') . '</option>
<option value="categories">' . __('Categorie(s), comma separated.', 'jig_td') . '</option>
<option value="tags">' . __('Tag(s), comma separated.', 'jig_td') . '</option>
<option value="datetime">' . __('Date and time.', 'jig_td') . '</option>
<option value="date">' . __('Date only.', 'jig_td') . '</option>
<option value="nicetime">' . __("Nice time (FB style 'ago').", 'jig_td') . '</option>
<option value="comments">' . __('Comments count.', 'jig_td') . '</option>
<option value="author">' . __('Author name.', 'jig_td') . '</option>
' . (function_exists('wc_price') ? '<option value="woocommerce_price">' . __('Woocommerce price.', 'jig_td') . '</option>' : '') . '
<option value="custom_post_metadata">' . __('Custom post metadata.', 'jig_td') . '</option>
<option disabled>' . __('-- Custom taxonomy, comma separated:', 'jig_td') . '</option>
' . str_replace('value="', 'value="custom_taxonomy_', $taxonomies_as_options);
echo $recents_description_options;

?>
                    </select>
                    <div class="minihelp"><?php _e('Choose what to display on the thumbnails under the post title, line 1.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Add to the description', 'jig_td'); ?></div>
                    <label>recents_description_2</label>
                    <select name="recents_description_2">
                        <?php echo $recents_description_options; ?>
                    </select>
                    <div class="minihelp"><?php _e('Additional information to display in the description. Line 2.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Also add to the description', 'jig_td'); ?></div>
                    <label>recents_description_3</label>
                    <select name="recents_description_3">
<?php

echo $recents_description_options;
$recents_description_options = null;
unset($recents_description_options);

?>
                    </select>
                    <div class="minihelp"><?php _e('Additional information to display in the description. Line 3.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Post metadata fields', 'jig_td'); ?></div>
                    <label>post_metadata_fields</label>
                    <input type="text" name="post_metadata_fields" value='' />
                    <div class="minihelp"><?php _e('Comma separated metadata field names, max 3, when "Custom post metadata" is selected for any of the description texts.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Word count for auto excerpt', 'jig_td'); ?></div>
                    <label>excerpt_length</label>
                    <input type="text" name="excerpt_length" value='' />
                    <div class="minihelp"><?php _e('Limit the length of automatic excerpt, defaults to 20 words.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Ending for auto excerpt', 'jig_td'); ?></div>
                    <label>excerpt_ending</label>
                    <input type="text" name="excerpt_ending" value='' />
                    <div class="minihelp"><?php _e('Add this to the end of the auto excerpt like - Read more...<br />Converts ( ) to [ ], defaults to [...], enter <strong>none</strong> to have no ending.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Prefix for author name', 'jig_td'); ?></div>
                    <label>author_prefix</label>
                    <input type="text" name="author_prefix" value='' />
                    <div class="minihelp"><?php _e('This is before the name, e.g. "written by", defaults to "by". Only if author name is selected above. Enter <strong>none</strong> to have no prefix.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Comments text', 'jig_td'); ?></div>
                    <label>comments_text</label>
                    <input type="text" name="comments_text" value='' />
                    <div class="minihelp"><?php _e('Rewrite the word comments text here, single and a plural separated by a pipe. Default: "comment | comments".', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Title override custom field', 'jig_td'); ?></div>
                    <label>recents_title_override</label>
                    <input type="text" name="recents_title_override" value='' />
                    <div class="minihelp"><?php _e('Display something else for the post title, accepts a custom field set on posts.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Filter/narrow what posts to show', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Post IDs', 'jig_td'); ?></div>
                    <label>post_ids</label>
                    <input type="text" name="post_ids" value='' />
                    <div class="minihelp"><?php _e('Optionally, you can manually specify posts by IDs, comma separated. You need to select the appropriate post type as well.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Exclude posts by ID', 'jig_td'); ?></div>
                    <label>post_ids_exclude</label>
                    <input type="text" name="post_ids_exclude" value='' />
                    <div class="minihelp"><?php _e("Don't show these posts (specify IDs, comma separated). Use the word 'current' to automatically exclude the current post (for example, related posts). Not compatible with the post_ids setting.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Exclude category', 'jig_td'); ?></div>
                    <label>recents_exclude</label>
                    <input type="text" name="recents_exclude" value='' />
                    <div class="minihelp"><?php _e('Show posts from all WP categories except these OR...', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Include category', 'jig_td'); ?></div>
                    <label>recents_include</label>
                    <input type="text" name="recents_include" value='' />
                    <div class="minihelp"><?php _e('Only show posts from these categories. Both exclude and include take comma separated list of category slugs or IDs. This is the built-in WP Category taxonomy, may not be applicable for custom post types.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter by tag', 'jig_td'); ?></div>
                    <label>recents_tags</label>
                    <input type="text" name="recents_tags" value='' />
                    <div class="minihelp"><?php _e('Enter comma separated WP tag slugs to filter by. This can be combined with the categories above.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter by taxonomy', 'jig_td'); ?></div>
                    <label>recents_filter_tax</label>
                    <select name="recents_filter_tax">
                        <option value="default" selected="selected"><?php _e('No filter.', 'jig_td'); ?></option>
<?php

echo $taxonomies_as_options;
$taxonomies_as_options = null;
unset($taxonomies_as_options);

?>
                    </select>
                    <div class="minihelp"><?php _e('Choose a taxonomy to filter recent posts by.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Taxonomy filter term', 'jig_td'); ?></div>
                    <label>recents_filter_term</label>
                    <input type="text" name="recents_filter_term" value='' />
                    <div class="minihelp"><?php _e('Enter the term(s) for your taxonomy (comma separated slugs).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Filter by author', 'jig_td'); ?></div>
                    <label>recents_author</label>
                    <select name="recents_author">
                        <option value="default" selected="selected"><?php _e('No filter.', 'jig_td'); ?></option>
                        <option value="currently_logged_in"><?php _e("Automatic: currently logged in user's own posts.", 'jig_td'); ?></option>
<?php

$users_as_options = '';
$users_for_filtering = new WP_User_Query([
    'capabilities' => ['edit_posts'],
    'fields' => ['user_login', 'display_name'],
]);
$users_for_filtering = $users_for_filtering->results;

if (!empty($users_for_filtering)) {
    foreach ($users_for_filtering as $user) {
        if (!empty($user->display_name)) {
            $users_as_options .= '<option value="' . $user->user_login . '">' . ucfirst($user->display_name) . '</option>';
        } else {
            $users_as_options .= '<option value="' . $user->user_login . '">' . ucfirst($user->user_login) . '</option>';
        }
    }
}

echo $users_as_options;
$users_as_options = $user = $users_for_filtering = null;
unset($users_as_options, $user, $users_for_filtering);

?>
                    </select>
                    <div class="minihelp"><?php _e('Choose an author to filter recent posts by.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Use sticky posts', 'jig_td'); ?></div>
                    <label>recents_sticky</label>
                    <select name="recents_sticky">
                        <option selected="selected" value="default"><?php _e('No preference', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: Only sticky posts', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: Do not display sticky posts at all', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Only usable when displaying regular WP posts. Narrow thumbnails to the sticky posts or exclude them.', 'jig_td'); ?></div>
                </div>

                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Advanced date queries (WP 3.7+)', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Last x days', 'jig_td'); ?></div>
                    <label>recents_last_x_days</label>
                    <input type="text" name="recents_last_x_days" value='' />
                    <div class="minihelp"><?php _e('Enter the number of days to only show content published in the most recent period.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Date range', 'jig_td'); ?></div>
                    <label>recents_date_range</label>
                    <input type="text" name="recents_date_range" value='' />
                    <div class="minihelp"><?php _e("OR the date to show posts from,to: YYYY-MM-DD,YYYY-MM-DD (start and end day is included) for example <strong>2013-07-01,2013-07-31</strong> (posts from July, 2013) or <strong>2013-12-01,today</strong> (posts since December, 2013). The word 'today' can be used as the 'to' date.", 'jig_td'); ?></div>
                </div>

                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Recent posts behavior and lightbox related options', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Click on a thumbnail links to', 'jig_td'); ?></div>
                    <label>recents_link_to</label>
                    <select name="recents_link_to">
                        <option selected="selected" value="post"><?php _e('The post.', 'jig_td'); ?></option>
                        <option value="image"><?php _e('The image (opens in the lightbox).', 'jig_td'); ?></option>
                        <option value="attachment"><?php _e('The WP attachment page of the image.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Link to the posts like a regular slider or you can create a gallery of their featured images, opening them in the lightbox.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Link to the post from lightbox', 'jig_td'); ?></div>
                    <label>recents_link</label>
                    <select name="recents_link">
                        <option selected="selected" value="no"><?php _e('No, just a gallery of post images.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: link title (the default position).', 'jig_td'); ?></option>
                        <option value="alt"><?php _e('Add to img alt.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Provides a way of still going to the permalink, only used when Click on a thumbnail links to an image.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Lightbox link text', 'jig_td'); ?></div>
                    <label>recents_link_text</label>
                    <input type="text" name="recents_link_text" value='' />
                    <div class="minihelp"><?php _e('The text for the permalink in the lightbox, e.g. Read more, Go to post.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Placeholder image', 'jig_td'); ?></div>
                    <label>recents_placeholder</label>
                    <input type="text" name="recents_placeholder" value='' />
                    <div class="minihelp"><?php _e('To still show posts without a featured image, specify the full URL of a desired placeholder image (upload to the media library).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Use custom links', 'jig_td'); ?></div>
                    <label>recents_custom_links</label>
                    <select name="recents_custom_links">
                        <option selected="selected" value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Use the JIG Link of featured images, can override recents_link_to.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Post field for custom links', 'jig_td'); ?></div>
                    <label>recents_link_field</label>
                    <input type="text" name="recents_link_field" value='' />
                    <div class="minihelp"><?php _e("Specify a custom post metadata field to get the link from, else it uses the featured image's JIG Link field.", 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Show children of a page (advanced)', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Parent post ID', 'jig_td'); ?></div>
                    <label>recents_parent_id</label>
                    <input type="text" name="recents_parent_id" value='' />
                    <div class="minihelp"><?php _e('Use if you wish to display children of a page, only when using pages.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Tree depth', 'jig_td'); ?></div>
                    <label>recents_tree_depth</label>
                    <input type="text" name="recents_tree_depth" value='' />
                    <div class="minihelp"><?php _e("When displaying children of a page, you can set the level of descendants. It's like 1 or 3 levels deep, default is 10 levels which is a practical limit. Enter a number.", 'jig_td'); ?></div>
                </div>
            </div>
            <h3 class="jigTabTitle" id="jigFacebook"><?php _e('Facebook', 'jig_td'); ?><div id="jigFbAllowMultiple"><input id="jigFbAllowMultipleInput" type="checkbox" name="jigFbAllowMultiple"><label for="jigFbAllowMultipleInput"><?php _e('Select multiple albums', 'jig_td'); ?></label></div>
            </h3>
            <div class="jigSettingsTab jig_settings_group_facebook clearfix" id="facebook">
                <div class="flexirow">
                    <div class="helpText">
<?php

printf(
    __("If you don't have any Profiles or Pages below, go to the settings and authorize/add some. Once added, you can select one and view the album list. You'll need to choose an album or the overview to display. Don't edit the Facebook IDs (%s and %s) manually. You can set the order on Facebook, or use the random order in JIG. You might want to limit how many images to load (e.g. for Wall Photos), using the limit in the general settings above.", 'jig_td'),
    '<span class="fbBlue">facebook_id</span>',
    '<span class="fbBlue">facebook_album</span>'
);
echo ' <strong>' . __("The default limit is 100 when nothing is set.", 'jig_td') . '</strong>';

?>
                        <a href="https://justifiedgrid.com/sources/facebook/" target="_blank"><?php _e('See examples and learn more about the Facebook feature!', 'jig_td'); ?></a>
                    </div>
                </div>
                <div class="dashedLine"></div>
                <div id="fbRow" class="flexirow">
                    <div id="fbLoadingAJAX">
                        <div id="fbLoadingInner">
                            <?php _e('loading albums from Facebook', 'jig_td'); ?><br />
                            <span id="fbLoadingInnerSmallText"><?php _e('please be patient, this can take a while', 'jig_td'); ?></span>
                            <div id="fbIcon"></div>
                        </div>
                    </div>
                    <div id="fbSources" class="clearfix">
                        <div class="JIGupdateButton fbSourceBtn fbSelected" id="fbOffBtn"><?php _e('Do not use Facebook', 'jig_td'); ?></div>
<?php

if (isset($settings['fb_authed']) && $settings['fb_authed'] != '') {
    foreach ($settings['fb_authed'] as $key => $val) {
        if ($settings['fb_app_type'] === "business" && $val['type'] === "current_user") {
            // Don't show user profiles in SCE when Business is the app type
            continue;
        }
        echo '<div class="JIGupdateButton fbSourceBtn" data-access-token="' . $val['access_token'] . '" id="' . $val['user_id'] . '">' . (isset($val['picture']) ? '<img src="' . $val['picture'] . '" />' : '') . $val['user_name'] . '</div>';
    }
}

?>
                    </div>
                    <div id="fbAlbums" class="clearfix"></div>
                    <input type="hidden" name="facebook_id" value='' />
                    <input type="hidden" name="facebook_album" value='' />
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Facebook caching time', 'jig_td'); ?></div>
                    <label>facebook_caching</label>
                    <input type="text" name="facebook_caching" value='' />
                    <div class="minihelp"><?php _e('The time it takes to see the Facebook album change on the site. This greatly speeds up loading as the photo list for each album is cached, saving a request to Facebook! Set in minutes: 4 hours is 240, a day is 1440, a week is 10080.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Image size in the lightbox', 'jig_td'); ?></div>
                    <label>facebook_image_size</label>
                    <select name="facebook_image_size">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="normal"><?php _e('Normal (720px wide)', 'jig_td'); ?></option>
                        <option value="larger"><?php _e('Larger (most useful)', 'jig_td'); ?></option>
                        <option value="maximum"><?php _e('Maximum (up to 4MP - 2048px)', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e('Select a preferred image size that opens in the lightbox.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Show album description', 'jig_td'); ?></div>
                    <label>facebook_description</label>
                    <select name="facebook_description">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                        <option value="above"><?php _e('Only above the grid', 'jig_td'); ?></option>
                        <option value="thumbnails"><?php _e('Only on thumbnails', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Display album description (if any) above the grid or on thumbnails.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Display photo count', 'jig_td'); ?></div>
                    <label>facebook_count</label>
                    <select name="facebook_count">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e("Make the thumbnail's caption display the count of photos in an album.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Open albums in lightbox', 'jig_td'); ?></div>
                    <label>fb_lightbox_album</label>
                    <select name="fb_lightbox_album">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: Open them on their own page.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: Open them in the lightbox.', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e('Only when using the overview feature! Open Facebook albums in the lightbox (on the same page, instead of linking to separate pages). Optimal for a few hundred photos or many albums with just a few images. You can show <strong>max 2000 photos</strong> in total. Load performance may suffer near the limit. Note: not compatible with Social Gallery lightbox.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Use the actual cover photo', 'jig_td'); ?></div>
                    <label>fb_actual_cover_photo</label>
                    <select name="fb_actual_cover_photo">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: Always use the first image (faster).', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: Use the actual cover photo when set.', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e("Use your manually-set cover photo for Facebook albums, only when you are not using the 'Open albums in lightbox' setting.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Exclude selected album(s)', 'jig_td'); ?></div>
                    <label>fb_album_exclude</label>
                    <select name="fb_album_exclude">
                        <option value="default" selected="selected"><?php _e('No, display the selected albums.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes, exclude the selected albums instead.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e("Instead of choosing what to display this setting inverts your selection to mark what you don't want to display in the overview.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Overview mini-breadcrumb', 'jig_td'); ?></div>
                    <label>fb_breadcrumb</label>
                    <select name="fb_breadcrumb">
                        <option value="default" selected="selected"><?php _e('Yes: use the breadcrumb.', 'jig_td'); ?></option>
                        <option value="no"><?php _e('Do not use', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e('Show title of current Facebook album and a link back to the overview. This is only used when the overview is selected and the albums are not set to open in the lightbox.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Breadcrumb separator character', 'jig_td'); ?></div>
                    <label>fb_bc_separator</label>
                    <select name="fb_bc_separator">
                        <option value="default" selected="selected">&raquo;</option>
                        <option value="greater">&gt;</option>
                        <option value="comma">,</option>
                        <option value="slash">/</option>
                        <option value="doubleslash">//</option>
                        <option value="minus">-</option>
                        <option value="plus">+</option>
                        <option value="arrow">&rarr;</option>
                        <option value="bslash">\</option>
                        <option value="doublebslash">\\</option>
                        <option value="middledot">·</option>
                        <option value="dobulecolon">::</option>
                        <option value="numbersign">#</option>
                    </select>
                    <div class="minihelp"><?php _e('This is the character that separates path elements in the Facebook breadcrumb (previous setting).', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Breadcrumb home text', 'jig_td'); ?></div>
                    <label>fb_bc_home_text</label>
                    <input type="text" name="fb_bc_home_text" value='' />
                    <div class="minihelp"><?php _e('You can override the home element page/profile name with custom text.', 'jig_td'); ?></div>
                </div>
            </div>
            <h3 class="jigTabTitle" id="jigFlickr"><?php _e('Flickr', 'jig_td'); ?></h3>
            <div class="jigSettingsTab jig_settings_group_flickr clearfix" id="flickr">
                <div class="flexirow">
                    <div class="helpText">
<?php

_e("If you don't have any users below, go to the settings and add some. Once added, you can select one then a content source: Photostream, Favorites, Groups, Albums, and Galleries. They may open a third set of options where you need to select exactly which Group, Album, or Gallery you wish to use. Don't to edit the Flickr attributes manually in the shortcode. You can set the order on Flickr, or use the random order in JIG. Titles/captions for photos from Flickr are recognized as Title and Description fields. You might want to limit how many images to load (e.g. for Photostreams), using the limit in the general settings above.", 'jig_td');

echo ' <strong>' . __("The default limit is 100 when nothing is set.", 'jig_td') . '</strong>';

?>
                        <a href="https://justifiedgrid.com/sources/flickr/" target="_blank"><?php _e('See examples and learn more about the Flickr feature!', 'jig_td'); ?></a>
                    </div>
                </div>
                <div class="dashedLine"></div>
                <div id="fliRow" class="flexirow">
                    <div id="fliLoadingAJAX">
                        <div id="fliLoadingInner">
                            <?php _e('loading user data from Flickr', 'jig_td'); ?><br />
                            <span id="fliLoadingInnerSmallText"><?php _e('please be patient, this can take a while', 'jig_td'); ?></span>
                            <div id="fliIcon"></div>
                        </div>
                    </div>
                    <div id="fliSources" class="clearfix">
                        <div class="JIGupdateButton fliSourceBtn fliSelected" id="fliOffBtn"><?php _e('Do not use Flickr', 'jig_td'); ?></div>
<?php

if (!empty($settings['fli_added'])) {
    echo '<div class="JIGupdateButton fliSourceBtn" id="fliSearchBtn">' . __('Search', 'jig_td') . '</div>';
    foreach ($settings['fli_added'] as $key => $val) {
        echo '<div class="JIGupdateButton fliSourceBtn" id="' . $val['user_id'] . '">' . (isset($val['icon']) ? '<img src="' . $val['icon'] . '" />' : '') . $val['user_name'] . '</div>';
    }
    $key = $val = null;
    unset($key, $val);
}

?>
                    </div>

                    <div id="fliTypes" class="clearfix"></div>
                    <div id="fliElements" class="clearfix"></div>
                    <div id="fliSearchPanel" class="clearfix">
                        <div class="flexirow">
                            <div class="longHelp"><?php echo __("Search global Flickr photos using this tool. The results will vary over time, depending on the supply of new images and caching time. Searching for either 'text' OR 'tags' is mandatory. You can exclude results that match a term by prepending it with a - character.", 'jig_td'); ?></div>
                        </div>


                        <div class="row">
                            <div class="normalName"><?php _e('Text', 'jig_td'); ?></div>
                            <label>flickr_search_text</label>
                            <input type="text" name="flickr_search_text" value='' />
                            <div class="minihelpNarrow"><?php _e("A free text search. Photos who's title, description or tags contain the text will be returned.", 'jig_td'); ?></div>
                        </div>
                        <div class="row">
                            <div class="normalName"><?php _e('Tags', 'jig_td'); ?></div>
                            <label>flickr_search_tags</label>
                            <input type="text" name="flickr_search_tags" value='' />
                            <div class="minihelpNarrow"><?php _e('OR A comma-delimited list of tags. Photos with one or more of the tags listed will be returned.', 'jig_td'); ?></div>
                        </div>
                        <div class="row">
                            <div class="normalName"><?php _e('Tags mode', 'jig_td'); ?></div>
                            <label>flickr_search_tags_m</label>
                            <select name="flickr_search_tags_m">
                                <option value="default" selected="selected">any / OR</option>
                                <option value="all">all / AND</option>
                            </select>
                            <div class="minihelpNarrow"><?php _e("Either 'any' for an OR combination of tags, or 'all' for an AND combination. ", 'jig_td'); ?></div>
                        </div>
                        <div class="row">
                            <div class="normalName"><?php _e('User', 'jig_td'); ?></div>
                            <label>flickr_search_user</label>
                            <input type="text" name="flickr_search_user" value='' />
                            <div class="minihelpNarrow"><?php printf(__('Flickr user NSID to search in. Use %s to get the ID.', 'jig_td'), '<a href="http://idgettr.com/" target="_blank">idGettr</a>'); ?></div>
                        </div>
                        <div class="row">
                            <div class="normalName"><?php _e('Group', 'jig_td'); ?></div>
                            <label>flickr_search_group</label>
                            <input type="text" name="flickr_search_group" value='' />
                            <div class="minihelpNarrow"><?php printf(__('Flickr group ID to search in. Use %s to get the ID.', 'jig_td'), '<a href="http://idgettr.com/" target="_blank">idGettr</a>'); ?></div>
                        </div>
                        <div class="row">
                            <div class="normalName"><?php _e('Sort', 'jig_td'); ?></div>
                            <label>flickr_search_sort</label>
                            <select name="flickr_search_sort" class="long_select">
                                <option value="default" selected="selected">Date posted descending</option>
                                <option value="date-posted-asc">Date posted ascending</option>
                                <option value="date-taken-desc">Date taken descending</option>
                                <option value="date-taken-asc">Date taken ascending</option>
                                <option value="interestingness-desc">Interestingness descending</option>
                                <option value="interestingness-asc">Interestingness ascending</option>
                                <option value="relevance">Relevance</option>
                            </select>
                            <div class="minihelp minihelpShort"><?php _e('The order in which to sort returned photos.', 'jig_td'); ?></div>
                        </div>
                        <div class="row">
                            <div class="normalName"><?php _e('Geo', 'jig_td'); ?></div>
                            <label>flickr_search_geo</label>
                            <select name="flickr_search_geo" class="long_select">
                                <option value="default" selected="selected">No preference</option>
                                <option value="0">Only non-geotagged</option>
                                <option value="1">Only geotagged</option>
                            </select>
                            <div class="minihelp minihelpShort"><?php _e('Only show photos that have been geotagged.', 'jig_td'); ?></div>
                        </div>
                        <div class="row">
                            <div class="normalName"><?php _e('License', 'jig_td'); ?></div>
                            <label>flickr_search_license</label>
                            <div class="checkboxes">
                                <input type="checkbox" class="checkbox" id="flickr_search_license[0]" name="flickr_search_license[]" value="0">
                                <label class="checkboxLabel" for="flickr_search_license[0]">0 - All Rights Reserved</label>
                                <br>
                                <input type="checkbox" class="checkbox" id="flickr_search_license[1]" name="flickr_search_license[]" value="1">
                                <label class="checkboxLabel" for="flickr_search_license[1]">1 - Attribution-NonCommercial-ShareAlike License</label>
                                <br>
                                <input type="checkbox" class="checkbox" id="flickr_search_license[2]" name="flickr_search_license[]" value="2">
                                <label class="checkboxLabel" for="flickr_search_license[2]">2 - Attribution-NonCommercial License</label>
                                <br>
                                <input type="checkbox" class="checkbox" id="flickr_search_license[3]" name="flickr_search_license[]" value="3">
                                <label class="checkboxLabel" for="flickr_search_license[3]">3 - Attribution-NonCommercial-NoDerivs License</label>
                                <br>
                                <input type="checkbox" class="checkbox" id="flickr_search_license[4]" name="flickr_search_license[]" value="4">
                                <label class="checkboxLabel" for="flickr_search_license[4]">4 - Attribution License</label>
                                <br>
                                <input type="checkbox" class="checkbox" id="flickr_search_license[5]" name="flickr_search_license[]" value="5">
                                <label class="checkboxLabel" for="flickr_search_license[5]">5 - Attribution-ShareAlike License</label>
                                <br>
                                <input type="checkbox" class="checkbox" id="flickr_search_license[6]" name="flickr_search_license[]" value="6">
                                <label class="checkboxLabel" for="flickr_search_license[6]">6 - Attribution-NoDerivs License</label>
                                <br>
                                <input type="checkbox" class="checkbox" id="flickr_search_license[7]" name="flickr_search_license[]" value="7">
                                <label class="checkboxLabel" for="flickr_search_license[7]">7 - No known copyright restrictions</label>
                                <br>
                                <input type="checkbox" class="checkbox" id="flickr_search_license[8]" name="flickr_search_license[]" value="8">
                                <label class="checkboxLabel" for="flickr_search_license[8]">8 - United States Government Work</label>
                            </div>
                            <div class="minihelpNarrow minihelpCheckbox minihelpFlickrLicense"><?php _e('The license id for photos.', 'jig_td'); ?></div>
                        </div>
                    </div>

                    <input type="hidden" name="flickr_photostream" value='' />
                    <input type="hidden" name="flickr_favorites" value='' />
                    <input type="hidden" name="flickr_user" value='' />
                    <input type="hidden" name="flickr_group" value='' />
                    <input type="hidden" name="flickr_photoset" value='' />
                    <input type="hidden" name="flickr_collection" value='' />
                    <input type="hidden" name="flickr_gallery" value='' />
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Flickr caching time', 'jig_td'); ?></div>
                    <label>flickr_caching</label>
                    <input type="text" name="flickr_caching" value='' />
                    <div class="minihelp"><?php _e('The time it takes to see the Flickr content change on the site. This greatly speeds up loading as the photo list for each content is cached, saving a request to Flickr each time the album is shown! Set in minutes: 4 hours is 240, a day is 1440, a week is 10080.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Link to the photo on Flickr', 'jig_td'); ?></div>
                    <label>flickr_link</label>
                    <select name="flickr_link">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: link title (default position)', 'jig_td'); ?></option>
                        <option value="alt"><?php _e('Add to img alt', 'jig_td'); ?></option>
                        <option value="direct"><?php _e('Link directly, skip lightbox', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Display a link back to the photo on Flickr in the lightbox.<br/>Highly recommended!', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Collection related settings', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Collection mini-breadcrumb', 'jig_td'); ?></div>
                    <label>flickr_breadcrumb</label>
                    <select name="flickr_breadcrumb">
                        <option value="default" selected="selected"><?php _e('Yes: use the breadcrumb.', 'jig_td'); ?></option>
                        <option value="no"><?php _e('Do not use', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e('Show title of current Flickr collections or album and a link back to all parents in the hierarchy. This is only used when a collection is selected for display.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Separator character', 'jig_td'); ?></div>
                    <label>flickr_bc_separator</label>
                    <select name="flickr_bc_separator">
                        <option value="default" selected="selected">&raquo;</option>
                        <option value="greater">&gt;</option>
                        <option value="comma">,</option>
                        <option value="slash">/</option>
                        <option value="doubleslash">//</option>
                        <option value="minus">-</option>
                        <option value="plus">+</option>
                        <option value="arrow">&rarr;</option>
                        <option value="bslash">\</option>
                        <option value="doublebslash">\\</option>
                        <option value="middledot">·</option>
                        <option value="dobulecolon">::</option>
                        <option value="numbersign">#</option>
                    </select>
                    <div class="minihelp"><?php _e('This is the character that separates path elements.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Breadcrumb home text', 'jig_td'); ?></div>
                    <label>flickr_bc_home_text</label>
                    <input type="text" name="flickr_bc_home_text" value='' />
                    <div class="minihelp"><?php _e('You can override the home element (parent collection name or user name) with a custom text.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Display photo / content count', 'jig_td'); ?></div>
                    <label>flickr_count</label>
                    <select name="flickr_count">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: display the counters.', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: do not display the counters.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e("Make the thumbnail's caption display the count of photos in a set. Also subcollections or sets in a collection.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Display collection / set description', 'jig_td'); ?></div>
                    <label>flickr_description</label>
                    <select name="flickr_description">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes', 'jig_td'); ?></option>
                        <option value="above"><?php _e('Only above the grid', 'jig_td'); ?></option>
                        <option value="thumbnails"><?php _e('Only on thumbnails', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Display the collection or set description description (if any) above the grid.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Open Flickr sets in lightbox', 'jig_td'); ?></div>
                    <label>flickr_lightbox_set</label>
                    <select name="flickr_lightbox_set">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No: Open them on their own page.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: Open them in the lightbox.', 'jig_td'); ?></option>

                    </select>
                    <div class="minihelp"><?php _e('Only when using the Flickr collections source! Open Flickr sets in the lightbox (on the same page, instead of linking to separate pages). Note: currently not compatible with Social Gallery lightbox.', 'jig_td'); ?></div>
                </div>

            </div>
            <!--
            <h3 class="jigTabTitle" id="jigInstagram"><?php _e('Instagram', 'jig_td'); ?></h3>
            <div class="jigSettingsTab jig_settings_group_instagram clearfix" id="instagram">
                <div class="flexirow">
                    <div class="helpText"><?php _e("If you don't have any Users below, please go to the settings and add yourself. Once added, you can select various content sources from Instagram. You'll have access the Your feed, Your recent photos, Photos you like, Someone else's recent photos, Photos by a tag and last but not least photos that are from a specific Location! Please don't edit the Instagram attributes manually in the shortcode. You might want to limit how many images to load, using the <span class=\"fbBlue\">limit</span> in the general settings above. The default limit is about 20 when nothing is set.", 'jig_td'); ?></div>
                </div>
                <div id="igRow" class="flexirow">
                    <div id="igLoadingAJAX">
                        <div id="igLoadingInner">
                            <?php _e('loading data from Instagram', 'jig_td'); ?><br />
                            <span id="igLoadingInnerSmallText"><?php _e('please wait, this can take a little time', 'jig_td'); ?></span>
                            <div id="igIcon"></div>
                        </div>
                    </div>
                    <div id="igSources" class="clearfix">
                        <div class="JIGupdateButton igSourceBtn igSelected" id="igOffBtn"><?php _e('Do not use Instagram', 'jig_td'); ?></div>
<?php

if (!empty($settings['ig_authed'])) {
    foreach ($settings['ig_authed'] as $key => $val) {
        echo '<div class="JIGupdateButton igSourceBtn igRecentsBtn" data-instagram-user-id="' . $val['id'] . '">' . (isset($val['picture']) ? '<img src="' . $val['picture'] . '" />' : '') . __('Recent pictures of', 'jig_td') . ' ' . $val['full_name'] . ' (' . $val['user_name'] . ')</div>';
    }
    foreach ($settings['ig_authed'] as $key => $val) {
        echo '<div class="JIGupdateButton igSourceBtn igLikedBtn" data-instagram-user-id="' . $val['id'] . '">' . (isset($val['picture']) ? '<img src="' . $val['picture'] . '" />' : '') . __('Liked by', 'jig_td') . ' ' . $val['full_name'] . ' (' . $val['user_name'] . ')</div>';
    }
    $key = $val = null;
    unset($key, $val);
    echo '<div class="JIGupdateButton igSourceBtn igAnyRecentsBtn">' . __('Recent pictures of any user (+)', 'jig_td') . ' </div>';

    echo '<div class="JIGupdateButton igSourceBtn igByTagBtn">' . __('By tag (+)', 'jig_td') . ' </div>';
    echo '<div class="JIGupdateButton igSourceBtn igByLocationBtn" data-instagram-type="location">' . __('By location (+)', 'jig_td') . ' </div>';
}

?>
                    </div>
                </div>
                <div class="flexirow igPanelsRow">
                    <div id="igRecentsPanel" class="clearfix">
                        <div class="flexirow">
                            <div class="normalName"><?php _e('Search for Instagram users', 'jig_td'); ?></div>
                            <label>name</label>
                            <input id="instagramUserSeach" type="text" name="instagram_user_search" value='' />
                            <div class="minihelpNarrow">
                                <div class="JIGupdateButton igSmallBtn" id="igSearchUsers"><?php _e('Search user', 'jig_td'); ?></div>
                            </div>
                        </div>
                        <div class="flexirow">
                            <div id="igNameContainer"></div>
                        </div>
                        <div class="row">
                            <div class="normalName"><?php _e('User ID', 'jig_td'); ?></div>
                            <label>instagram_recents</label>
                            <input type="text" id="igSelectedUser" name="instagram_recents_helper" value='' disabled readonly />
                            <div class="minihelpNarrow"><?php _e('This is the user ID of your selected user.', 'jig_td'); ?></div>
                        </div>
                    </div>
                    <div id="igTagPanel" class="clearfix">
                        <div class="flexirow">
                            <div class="normalName"><?php _e('Search for Instagram tags', 'jig_td'); ?></div>
                            <label>tag</label>
                            <input id="instagramTagSeach" type="text" name="instagram_tag_search" value='' />
                            <div class="minihelpNarrow">
                                <div class="JIGupdateButton igSmallBtn" id="igSearchTags"><?php _e('Search tag', 'jig_td'); ?></div>
                            </div>
                        </div>
                        <div class="flexirow">
                            <div id="igTagContainer"></div>
                        </div>
                        <div class="row">
                            <div class="normalName"><?php _e('Tag slug', 'jig_td'); ?></div>
                            <label>instagram_tag</label>
                            <input type="text" id="igSelectedTag" name="instagram_tag" value='' disabled readonly />
                            <div class="minihelpNarrow"><?php _e('This is your selected tag.', 'jig_td'); ?></div>
                        </div>
                    </div>
                    <div id="igLocationPanel" class="clearfix">
                        <div class="flexirow">
                            <div class="longHelp"><?php echo sprintf(__('How to search for locations? Go to %s and find your desired place based on a Facebook page. Then copy-paste the ID of the page here. For example %s for Times Square. Instagram uses the Facebook place ID for this feature.', 'jig_td'), '<a href="https://developers.facebook.com/tools/explorer/?method=GET&path=timessquarenyc%2F&version=v2.8" target="_blank">Facebook Graph API Explorer</a>', '39875583837'); ?></div>
                        </div>
                        <div class="flexirow">
                            <div class="normalName"><?php _e('Search for Instagram locations', 'jig_td'); ?></div>
                            <label>location</label>
                            <input id="instagramLocationSearch" type="text" name="instagram_location_search" value='' />
                            <div class="minihelpNarrow">
                                <div class="JIGupdateButton igSmallBtn" id="igSearchLocations"><?php _e('Search location', 'jig_td'); ?></div>
                            </div>
                        </div>
                        <div class="flexirow">
                            <div id="igLocationContainer"></div>
                        </div>
                        <div class="row">
                            <div class="normalName"><?php _e('Location ID', 'jig_td'); ?></div>
                            <label>instagram_location</label>
                            <input type="text" id="igSelectedLocation" name="instagram_location" value='' disabled readonly />
                            <div class="minihelpNarrow"><?php _e("This is your selected location's ID.", 'jig_td'); ?></div>
                        </div>
                    </div>
                    <input type="hidden" name="instagram_recents" value='' />
                    <input type="hidden" name="instagram_liked" value='' />
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Instagram tag filter', 'jig_td'); ?></div>
                    <label>instagram_tag_filter</label>
                    <input type="text" name="instagram_tag_filter" value='' />
                    <div class="minihelp"><?php _e('Only show Instagram photos that are tagged with at least one of these tags, comma separated, lowercase.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Tag filter matching mode', 'jig_td'); ?></div>
                    <label>instagram_tag_mode</label>
                    <select name="instagram_tag_mode">
                        <option value="default" selected="selected"><?php _e('OR', 'jig_td'); ?></option>
                        <option value="and"><?php _e('AND', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e(' If this is set to OR, then all images matching any of the selected tags will be displayed. In case of AND, only images that match all your terms will be shown.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Instagram user blacklist', 'jig_td'); ?></div>
                    <label>instagram_blacklist</label>
                    <input type="text" name="instagram_blacklist" value='' />
                    <div class="minihelp"><?php _e("Enter the Instagram usernames or IDs you don't want to see photos from. Comma separated. ", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Instagram caching time', 'jig_td'); ?></div>
                    <label>instagram_caching</label>
                    <input type="text" name="instagram_caching" value='' />
                    <div class="minihelp"><?php _e('The time it takes to see the Instagram content change on the site. This greatly speeds up loading as the photo list for each content type is cached, saving many requests to Instagram! Set in minutes: 4 hours is 240, a day is 1440, a week is 10080.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Show Instagram username', 'jig_td'); ?></div>
                    <label>instagram_show_user</label>
                    <select name="instagram_show_user">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e("No, don't display it.", 'jig_td'); ?></option>
                        <option value="title"><?php _e("Title field (next to the photo's text)", 'jig_td'); ?></option>
                        <option value="description"><?php _e('Description field (on its own)', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e("Display the photo owner's username, turns into a link in the lightbox.<br/>Recommended when showing photos from multiple users!", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('Link to the photo on Instagram', 'jig_td'); ?></div>
                    <label>instagram_link</label>
                    <select name="instagram_link">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: link title (default position)', 'jig_td'); ?></option>
                        <option value="alt"><?php _e('Add to img alt', 'jig_td'); ?></option>
                        <option value="direct"><?php _e('Link directly, skip lightbox', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('Display a link back to the photo on Instagram in the lightbox.<br/>Highly recommended!', 'jig_td'); ?></div>
                </div>
            </div>
            -->

            <h3 class="jigTabTitle" id="jigRSS"><?php _e('RSS', 'jig_td'); ?></h3>
            <div id="jig_rss_tab_content" class="jigSettingsTab jig_settings_group_rss clearfix">
                <div class="flexirow">
                    <div class="helpText"><?php _e('Feeds are the most flexible and fun image sources. Scroll down for a tool to convert regular links of popular sites to feed URLs. The only limitation is that the feed items need to have an image in order to show up. Advanced users can create a custom feed and connect it to JIG. Note: If the feed images are small, you need to decrease row height and deviation to avoid upscaling.', 'jig_td'); ?> <a href="https://justifiedgrid.com/sources/rss-feeds/" target="_blank"><?php _e('See examples and learn more about the RSS feeds feature!', 'jig_td'); ?></a></div>
                </div>
                <div class="dashedLine"></div>
                <div class="row">
                    <div class="normalName"><?php _e('Feed URL(s)', 'jig_td'); ?></div>
                    <label>rss_url</label>
                    <textarea name="rss_url" class="long_input" rows="2" cols="50"></textarea>
                    <div class="minihelp minihelpShort"><?php _e('Specify the URL of the RSS/Atom feed you wish to use. Can combine multiple feeds and sorts them by date - put a comma between URLs in that case.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('RSS links to', 'jig_td'); ?></div>
                    <label>rss_links_to</label>
                    <select name="rss_links_to">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="permalink"><?php _e('Permalink (the link of the feed item).', 'jig_td'); ?></option>
                        <option value="image"><?php _e('Image (lightbox, a gallery of RSS items).', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e("What should open when clicking on thumbnails from an RSS feed? Go to General -> Behavior of the plugin -> <strong>Custom link's target</strong> to open permalink in the lightbox (iframe, videos) or on a new tab.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('RSS description', 'jig_td'); ?></div>
                    <label>rss_description</label>
                    <select name="rss_description">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="none"><?php _e('Nothing, just the title.', 'jig_td'); ?></option>
                        <option value="description"><?php _e('Description (full, can be too long).', 'jig_td'); ?></option>
                        <option value="excerpt"><?php _e('Excerpt: description cut to x words (automatic, HTML off).', 'jig_td'); ?></option>
                        <option value="datetime"><?php _e('Date and time.', 'jig_td'); ?></option>
                        <option value="date"><?php _e('Date only.', 'jig_td'); ?></option>
                        <option value="nicetime"><?php _e("Nice time (FB style 'ago').", 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e('This controls what text to show as description on the thumbnails.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('RSS exceprt length (words)', 'jig_td'); ?></div>
                    <label>rss_excerpt_length</label>
                    <input type="text" name="rss_excerpt_length" value='' />
                    <div class="minihelp"><?php _e('Limit the length of automatic excerpt, defaults to 20 - word count.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('RSS exceprt ending', 'jig_td'); ?></div>
                    <label>rss_excerpt_ending</label>
                    <input type="text" name="rss_excerpt_ending" value='' />
                    <div class="minihelp"><?php _e('Add this to the end of the auto excerpt like - Read more... or " [...]"<br />Converts ( ) to [ ], defaults to [...], enter <strong>none</strong> to have no ending."', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('RSS lightbox backlink', 'jig_td'); ?></div>
                    <label>rss_link</label>
                    <select name="rss_link">
                        <option value="default" selected="selected"><?php _e('default', 'jig_td'); ?></option>
                        <option value="no"><?php _e('No I really just want a gallery of RSS images.', 'jig_td'); ?></option>
                        <option value="yes"><?php _e('Yes: link title (the default position).', 'jig_td'); ?></option>
                        <option value="alt"><?php _e('Add to img alt.', 'jig_td'); ?></option>
                    </select>
                    <div class="minihelp"><?php _e("This the RSS item's backlink in the lightbox, only used when RSS links to image, to provide a way of still going to the permalink.", 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('RSS lightbox backlink text', 'jig_td'); ?></div>
                    <label>rss_link_text</label>
                    <input type="text" name="rss_link_text" value='' />
                    <div class="minihelp"><?php _e('The text to show as RSS lightbox backlink, e.g. Read more, Go to story etc.', 'jig_td'); ?></div>
                </div>
                <div class="row">
                    <div class="normalName"><?php _e('RSS caching time', 'jig_td'); ?></div>
                    <label>rss_caching</label>
                    <input type="text" name="rss_caching" value='' />
                    <div class="minihelp"><?php _e('By default the caching is 12 hours (set by WP), you can override that for this feature. Set in minutes.', 'jig_td'); ?></div>
                </div>
                <div class="row generalDashedRow">
                    <div class="longHelp"><?php _e('Tool to get the Feed URL from popular sites', 'jig_td'); ?></div>
                </div>
                <div class="flexirow">
                    <div class="helpText"><?php _e("Enter the regular link to your desired site (following the format of <span class='rssRegularLink'>regular links</span> below), and get the <span class='rssFeedLink'>feed URLs</span> generated for you. Then you can easily add it to the Feed URL(s) - <span class='darkBlue'>rss_url</span> setting above. It's often not trivial how to get <span class='rssFeedLink'>feed URLs</span>, so this should be of help.", 'jig_td'); ?></div>
                </div>
                <div class="flexirow">
                    <div class="normalName"><span class="rssRegularLink"><?php _e('Regular link', 'jig_td'); ?></span></div>
                    <input type="text" class="long_input" id="rssRegularLinkField" value='' />
                    <div class="minihelp"><?php _e('Enter a regular link according to the blue examples below.', 'jig_td'); ?></div>
                </div>
                <div class="flexirow">
                    <div class="normalName"><span class="rssFeedLink"><?php _e('Feed URL', 'jig_td'); ?></span></div>
                    <input type="text" class="long_input" id="rssFeedUrlField" value='' />
                    <div class="minihelp"><?php _e('This is the Feed URL that is based on your regular link.', 'jig_td'); ?></div>
                </div>
                <div class="flexirow" id="rssButtons">
                    <div id="rssGenerateButton" class="JIGupdateButton rssSmallBtn"><?php _e('Generate Feed URL', 'jig_td'); ?></div>
                    <div id="rssSetButton" class="JIGupdateButton rssSmallBtn"><?php _e('Set it as', 'jig_td'); ?> <span class="darkBlue">rss_url</span></div>
                    <div id="rssAppendButton" class="JIGupdateButton rssSmallBtn"><?php _e('Append to', 'jig_td'); ?> <span class="darkBlue">rss_url</span></div>
                </div>
                <div class="flexirow">
                    <div class="helpText">
                        <?php _e('Sites available for this tool with example links (<span class="rssRegularLink">regular links</span>, <span class="rssFeedLink">feed URLs</span> - the tool converts regular links to feed URLs)', 'jig_td'); ?>:
                        <ul class="rssHelpList">
                            <li><?php _e('Youtube (non-RSS exception)', 'jig_td'); ?>
                                <ul>
                                    <li><?php _e('Youtube no longer offers RSS Feeds, but JIG fills the gap! Just use <span class="rssRegularLink">regular links</span> (or continue using old <span class="rssFeedLink">feed URLs</span>).', 'jig_td'); ?></li>
                                    <li><?php _e('Channels (recent videos)', 'jig_td'); ?>: <span class="rssRegularLink">https://www.youtube.com/user/TaylorSwiftVEVO</span></li>
                                    <li><?php _e('Playlists', 'jig_td'); ?>: <span class="rssRegularLink">https://www.youtube.com/playlist?list=PLKvJeqYUGmRP7LR3Xy5-D7KP3N7y5oXV0</span><br /><?php _e('(very flexible, as long as playlist ID is in the URL)', 'jig_td'); ?></li>
                                </ul>
                            </li>
                            <li><?php _e('Vimeo', 'jig_td'); ?>
                                <ul>
                                    <li><?php _e("User's videos", 'jig_td'); ?>: <span class="rssRegularLink">https://vimeo.com/terjes/videos</span></li>
                                    <li><?php _e('Albums', 'jig_td'); ?>: <span class="rssRegularLink">https://vimeo.com/album/189653</span></li>
                                    <li><?php _e("User's likes", 'jig_td'); ?>: <span class="rssRegularLink">https://vimeo.com/terjes/likes</span></li>
                                    <li><?php _e('Channels', 'jig_td'); ?>: <span class="rssRegularLink">https://vimeo.com/channels/hdmusicvideos</span></li>
                                    <li><?php _e('Groups', 'jig_td'); ?>: <span class="rssRegularLink">https://vimeo.com/groups/travelhd</span></li>
                                    <li><?php _e('Subscriptions, Shares and Watch Later feeds can be found in your own profile, left side at the bottom', 'jig_td'); ?></li>
                                </ul>
                            </li>
                            <li><?php _e('500px', 'jig_td'); ?>
                                <ul>
                                    <li><?php _e("User's photos", 'jig_td'); ?>: <span class="rssRegularLink">https://500px.com/mikc84</span></li>
                                    <li><?php _e('Custom searches', 'jig_td'); ?>: <span class="rssRegularLink">https://500px.com/search?q=house&amp;type=photos&amp;sort=relevance</span></li>
                                </ul>
                            </li>
                            <li><?php _e('Pinterest', 'jig_td'); ?>
                                <ul>
                                    <li><?php _e("A user's pins", 'jig_td'); ?>: <span class="rssRegularLink">https://pinterest.com/iewachka/pins/</span></li>
                                    <li><?php _e('Pins from a board of a user', 'jig_td'); ?>: <span class="rssRegularLink">https://pinterest.com/iewachka/pretty-kitchens</span></li>
                                </ul>
                            </li>
                            <li><?php _e('DeviantArt', 'jig_td'); ?>
                                <ul>
                                    <li><?php _e("To get RSS URLs directly, find the RSS icon, left of the pagination, just after the images. It's applicable for user deviations (favorites, collections in favorites, galleries, gallery folders, category galleries) and group deviations (collections in favorites, gallery folders).", 'jig_td'); ?></li>
                                    <li><?php _e('All new deviations by user', 'jig_td'); ?>: <span class="rssRegularLink">https://trichardsen.deviantart.com/gallery/</span></li>
                                    <li><?php _e('A gallery of a user or group', 'jig_td'); ?>: <span class="rssRegularLink">https://trichardsen.deviantart.com/gallery/37519255</span></li>
                                    <li><?php _e('A category gallery of a user', 'jig_td'); ?>: <span class="rssRegularLink">https://trichardsen.deviantart.com/gallery/?catpath=%2Fphotography%2Fconceptual</span></li>
                                    <li><?php _e('A set of favorites by user or group', 'jig_td'); ?>: <span class="rssRegularLink">https://natureweb.deviantart.com/favourites/47112653</span></li>
                                </ul>
                            </li>
                            <li><?php _e('Tumblr', 'jig_td'); ?>
                                <ul>
                                    <li><?php _e('Append /rss to tumblr blogs that are on their own domain.', 'jig_td'); ?></li>
                                    <li><?php _e("A blog's recent posts", 'jig_td'); ?>: <span class="rssRegularLink">https://chickadeefriend.tumblr.com/</span></li>
                                </ul>
                            </li>
                            <li><?php _e('WordPress', 'jig_td'); ?>
                                <ul>
                                    <li><?php _e('Append /feed/ to WordPress blogs that are on their own domain. Gravatars are skipped and the posts must have featured images!', 'jig_td'); ?></li>
                                    <li><?php _e("A blog's recent posts", 'jig_td'); ?>: <span class="rssRegularLink">https://suzywalker.wordpress.com/</span></li>
                                    <li><?php _e('Add /feed to post list views like tags, categories etc.', 'jig_td'); ?>: <span class="rssRegularLink">https://suzywalker.wordpress.com/category/photography/macro/</span></li>
                                </ul>
                            </li>
                        </ul>
                        <?php _e('The RSS feature is not limited to the list, this is just an easier way to convert your <span class="rssRegularLink">regular links</span> to <span class="rssFeedLink">feed URLs</span> for a few, selected popular sites. Use of the tool is optional and the <span class="rssFeedLink">feed URL</span> is subject to change by the sites without notification.', 'jig_td'); ?>
                    </div>
                </div>
            </div>
            <h3 class="jigTabTitle" id="jigTemplateTag"><?php _e('Template Tag', 'jig_td'); ?></h3>
            <div id="jig_template_tag_tab_content" class="jigSettingsTab jig_settings_group clearfix">
                <div class="row">
                    <div id="templateTagButton" class="JIGupdateButton"><?php _e('Generate template tag (optional / advanced users)', 'jig_td'); ?></div>
                </div>
                <div class="row" id="templateTagContainer">
                    <div class="normalName"><?php _e('Template tag', 'jig_td'); ?>:</div>
                    <div id="templateTag"></div>
                    <div id="templateTagHelp" class="minihelp"><?php _e('Add this to a PHP file of your template', 'jig_td'); ?></div>

                </div>
                <div class="row" id="doShortcodeContainer">
                    <div class="normalName"><?php _e('Do shortcode', 'jig_td'); ?>:</div>
                    <div id="doShortcode"></div>
                    <div id="doShortcodeHelp" class="minihelp"><?php _e('OR add this, whichever you like better (they do the same thing).', 'jig_td'); ?></div>
                </div>
            </div>
            <h3 class="jigTabTitle" id="jigShortcode"><?php _e('Shortcode import/export', 'jig_td'); ?></h3>
            <div id="jig_shortcode_tab_content" class="jigSettingsTab jig_settings_group clearfix">
                <div class="flexirow">
                    <div class="helpText"><?php _e("Since these grids are saved there is no need to copy paste the full shortcode, but you might want to import an existing shortcode into a new grid. You may also see a grid's output shortcode in its entirety. However, when using a grid you create here, you simply use the shortcode with a single gallery attribute from above. You can also find JIG among your builder's blocks (if compatibility exists).", 'jig_td'); ?></div>
                </div>
                <div class="flexirow dashedRow" id="shortcodeImportContainer">
                </div>
                <div class="flexirow" id="shortcodeExportContainer">
                </div>
            </div>
            <div id="bottomSpacer"></div>
            <div id="shortcodeButtonsParent">
                <div id="saveShortcode" class="shortcodeButton"><?php _e('Save shortcode & close', 'jig_td'); ?></div>
                <div id="previewShortcode" class="shortcodeButton"><?php _e('Live preview', 'jig_td'); ?></div>
                <div id="createShortcode" class="shortcodeButton"><?php _e('Create shortcode', 'jig_td'); ?></div>
                <div id="outputShortcodeLabel" class="stillEmpty"><?php _e('Copy shortcode', 'jig_td'); ?>:</div>
                <input type="text" name="outputShortcode" id="outputShortcode" class="stillEmpty" value='' />
            </div>
        </form>
    </div>
    <div id="jig-sc-editor-loading"></div>
    <script type="text/javascript">
 <?php

 $l10n = [
    'jig_sce_title' => __('Justified Image Grid shortcode editor', 'jig_td'),
    'ajax_error_check_console' => __('AJAX error. Check browser console for more information.', 'jig_td'),
    'site_not_supported' => __('The site is not supported by this tool.', 'jig_td'),
    'seems_like_an_invalid_link' => __('Seems like an invalid link.', 'jig_td'),
    'regular_link_is_not_supported' => __('The regular link is not supported.', 'jig_td'),
    'currently_editing_this_shortcode' =>  __('Currently editing this shortcode', 'jig_td'),
    'error_loading_cover_photo' => __('error loading cover photo, album is now disabled to prevent further errors', 'jig_td'),
    'template_tag_help_set_up_ids' => __('Please set up a content source, such as Media Library images or Recent posts, otherwise the template tag will not work. You can also use Facebook, Flickr, NextGEN, WP RML or RSS feeds instead.', 'jig_td'),
    'error' => __('error', 'jig_td'),
    'full_shortcode_output' => __('Full shortcode output', 'jig_td'),
    'add_images' => __('Add Images', 'jig_td'),
    'edit_gallery' => __('Edit Gallery', 'jig_td'),
    'shorcode_copied' => __('Shortcode copied!', 'jig_td'),
    'shorcode_loaded' => __('Shortcode loaded!', 'jig_td'),
    'template_tag_created' => __('Template tag created!', 'jig_td'),
    'nonce' => [
        'jig_get_fb_albums' => wp_create_nonce('jig_get_fb_albums'),
        'jig_get_fli_types' => wp_create_nonce('jig_get_fli_types'),
        'jig_instagram_search_users' => wp_create_nonce('jig_instagram_search_users'),
        'jig_instagram_search_locations' => wp_create_nonce('jig_instagram_search_locations'),
        'jig_get_fli_elements' => wp_create_nonce('jig_get_fli_elements'),
        'jig_instagram_search_tags' => wp_create_nonce('jig_instagram_search_tags')
    ],
    'admin_ajax_url' => admin_url('admin-ajax.php'),
    'nggallery' => isset($wpdb->nggallery) === false ? 'no' : 'yes',
    'add_to_sc_regex' => ($settings['take_over_gallery'] === 'yes' ? '|gallery' : '') . ($settings['shortcode_alias'] !== 'justified_image_grid' && $settings['shortcode_alias'] !== '' ? '|' . $settings['shortcode_alias'] : ''),
];

foreach ($l10n as $key => $value) {
    if (!is_scalar($value)) {
        continue;
    }
    $l10n[$key] = html_entity_decode((string) $value, ENT_QUOTES, 'UTF-8');
}

echo "var SCE = " . wp_json_encode($l10n) . ';';

?>
    </script>

    <script type='text/javascript' src='<?php echo plugins_url('js/jquery-3.6.0.min.js', __FILE__); ?>'></script>
    <script type='text/javascript' src='<?php echo plugins_url('js/jig-sce' . $dotmin . '.js?ver=' . $plugin_version, __FILE__); ?>'></script>

</body>

</html>