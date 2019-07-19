<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
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

?><header class="top_panel top_panel_default<?php
					echo !empty($saveo_header_image) || !empty($saveo_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($saveo_header_video!='') echo ' with_bg_video';
					if ($saveo_header_image!='') echo ' '.esc_attr(saveo_add_inline_css_class('background-image: url('.esc_url($saveo_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (saveo_is_on(saveo_get_theme_option('header_fullheight'))) echo ' header_fullheight trx-stretch-height';
					?> scheme_<?php echo esc_attr(saveo_is_inherit(saveo_get_theme_option('header_scheme')) 
													? saveo_get_theme_option('color_scheme') 
													: saveo_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($saveo_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (saveo_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

	// Header for single posts
	get_template_part( 'templates/header-single' );

?></header>