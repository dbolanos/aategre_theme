<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the Visual Composer to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$saveo_content = '';
$saveo_blog_archive_mask = '%%CONTENT%%';
$saveo_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $saveo_blog_archive_mask);
if ( have_posts() ) {
	the_post(); 
	if (($saveo_content = apply_filters('the_content', get_the_content())) != '') {
		if (($saveo_pos = strpos($saveo_content, $saveo_blog_archive_mask)) !== false) {
			$saveo_content = preg_replace('/(\<p\>\s*)?'.$saveo_blog_archive_mask.'(\s*\<\/p\>)/i', $saveo_blog_archive_subst, $saveo_content);
		} else
			$saveo_content .= $saveo_blog_archive_subst;
		$saveo_content = explode($saveo_blog_archive_mask, $saveo_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) saveo_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$saveo_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$saveo_args = saveo_query_add_posts_and_cats($saveo_args, '', saveo_get_theme_option('post_type'), saveo_get_theme_option('parent_cat'));
$saveo_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($saveo_page_number > 1) {
	$saveo_args['paged'] = $saveo_page_number;
	$saveo_args['ignore_sticky_posts'] = true;
}
$saveo_ppp = saveo_get_theme_option('posts_per_page');
if ((int) $saveo_ppp != 0)
	$saveo_args['posts_per_page'] = (int) $saveo_ppp;
// Make a new query
query_posts( $saveo_args );
// Set a new query as main WP Query
$GLOBALS['wp_the_query'] = $GLOBALS['wp_query'];

// Set query vars in the new query!
if (is_array($saveo_content) && count($saveo_content) == 2) {
	set_query_var('blog_archive_start', $saveo_content[0]);
	set_query_var('blog_archive_end', $saveo_content[1]);
}

get_template_part('index');
?>