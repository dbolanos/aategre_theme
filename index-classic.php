<?php
/**
 * The template for homepage posts with "Classic" style
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

saveo_storage_set('blog_archive', true);

// Load scripts for 'Masonry' layout
if (substr(saveo_get_theme_option('blog_style'), 0, 7) == 'masonry') {
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'masonry' );
	wp_enqueue_script( 'classie', saveo_get_file_url('js/theme.gallery/classie.min.js'), array(), null, true );
	wp_enqueue_script( 'saveo-gallery-script', saveo_get_file_url('js/theme.gallery/theme.gallery.js'), array(), null, true );
}

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	$saveo_classes = 'posts_container '
						. (substr(saveo_get_theme_option('blog_style'), 0, 7) == 'classic' ? 'columns_wrap' : 'masonry_wrap');
	$saveo_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$saveo_sticky_out = saveo_get_theme_option('sticky_style')=='columns' 
							&& is_array($saveo_stickies) && count($saveo_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($saveo_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$saveo_sticky_out) {
		if (saveo_get_theme_option('first_post_large') && !is_paged() && !in_array(saveo_get_theme_option('body_style'), array('fullwide', 'fullscreen'))) {
			the_post();
			get_template_part( 'content', 'excerpt' );
		}
		
		?><div class="<?php echo esc_attr($saveo_classes); ?>"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($saveo_sticky_out && !is_sticky()) {
			$saveo_sticky_out = false;
			?></div><div class="<?php echo esc_attr($saveo_classes); ?>"><?php
		}
		get_template_part( 'content', $saveo_sticky_out && is_sticky() ? 'sticky' : 'classic' );
	}
	
	?></div><?php

	saveo_show_pagination();

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>