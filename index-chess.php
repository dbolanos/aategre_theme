<?php
/**
 * The template for homepage posts with "Chess" style
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

saveo_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	$saveo_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$saveo_sticky_out = saveo_get_theme_option('sticky_style')=='columns' 
							&& is_array($saveo_stickies) && count($saveo_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($saveo_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$saveo_sticky_out) {
		?><div class="chess_wrap posts_container"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($saveo_sticky_out && !is_sticky()) {
			$saveo_sticky_out = false;
			?></div><div class="chess_wrap posts_container"><?php
		}
		get_template_part( 'content', $saveo_sticky_out && is_sticky() ? 'sticky' :'chess' );
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