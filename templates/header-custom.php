<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0.06
 */

$saveo_header_css = $saveo_header_image = '';
$saveo_header_video = saveo_get_header_video();
if (true || empty($saveo_header_video)) {
	$saveo_header_image = get_header_image();
	if (saveo_is_on(saveo_get_theme_option('header_image_override')) && apply_filters('saveo_filter_allow_override_header_image', true)) {
		if (is_category()) {
			if (($saveo_cat_img = saveo_get_category_image()) != '')
				$saveo_header_image = $saveo_cat_img;
		} else if (is_singular() || saveo_storage_isset('blog_archive')) {
			if (has_post_thumbnail()) {
				$saveo_header_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				if (is_array($saveo_header_image)) $saveo_header_image = $saveo_header_image[0];
			} else
				$saveo_header_image = '';
		}
	}
}

$saveo_header_id = str_replace('header-custom-', '', saveo_get_theme_option("header_style"));
$saveo_header_meta = get_post_meta($saveo_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($saveo_header_id); 
						?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($saveo_header_id)));
						echo !empty($saveo_header_image) || !empty($saveo_header_video) 
							? ' with_bg_image' 
							: ' without_bg_image';
						if ($saveo_header_video!='') 
							echo ' with_bg_video';
						if ($saveo_header_image!='') 
							echo ' '.esc_attr(saveo_add_inline_css_class('background-image: url('.esc_url($saveo_header_image).');'));
						if (!empty($saveo_header_meta['margin']) != '') 
							echo ' '.esc_attr(saveo_add_inline_css_class('margin-bottom: '.esc_attr(saveo_prepare_css_value($saveo_header_meta['margin'])).';'));
						if (is_single() && has_post_thumbnail()) 
							echo ' with_featured_image';
						if (saveo_is_on(saveo_get_theme_option('header_fullheight'))) 
							echo ' header_fullheight trx-stretch-height';
						?> scheme_<?php echo esc_attr(saveo_is_inherit(saveo_get_theme_option('header_scheme')) 
														? saveo_get_theme_option('color_scheme') 
														: saveo_get_theme_option('header_scheme'));
						?>"><?php

	// Background video
	if (!empty($saveo_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('saveo_action_show_layout', $saveo_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>