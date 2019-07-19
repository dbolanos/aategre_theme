<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

$saveo_post_id    = get_the_ID();
$saveo_post_date  = saveo_get_date();
$saveo_post_title = get_the_title();
$saveo_post_link  = get_permalink();
$saveo_post_author_id   = get_the_author_meta('ID');
$saveo_post_author_name = get_the_author_meta('display_name');
$saveo_post_author_url  = get_author_posts_url($saveo_post_author_id, '');

$saveo_args = get_query_var('saveo_args_widgets_posts');
$saveo_show_date = isset($saveo_args['show_date']) ? (int) $saveo_args['show_date'] : 1;
$saveo_show_image = isset($saveo_args['show_image']) ? (int) $saveo_args['show_image'] : 1;
$saveo_show_author = isset($saveo_args['show_author']) ? (int) $saveo_args['show_author'] : 1;
$saveo_show_counters = isset($saveo_args['show_counters']) ? (int) $saveo_args['show_counters'] : 1;
$saveo_show_categories = isset($saveo_args['show_categories']) ? (int) $saveo_args['show_categories'] : 1;

$saveo_output = saveo_storage_get('saveo_output_widgets_posts');

$saveo_post_counters_output = '';
if ( $saveo_show_counters ) {
	$saveo_post_counters_output = '<span class="post_info_item post_info_counters">'
								. saveo_get_post_counters('comments')
							. '</span>';
}


$saveo_output .= '<article class="post_item with_thumb">';

if ($saveo_show_image) {
	$saveo_post_thumb = get_the_post_thumbnail($saveo_post_id, saveo_get_thumb_size('tiny'), array(
		'alt' => get_the_title()
	));
	if ($saveo_post_thumb) $saveo_output .= '<div class="post_thumb">' . ($saveo_post_link ? '<a href="' . esc_url($saveo_post_link) . '">' : '') . ($saveo_post_thumb) . ($saveo_post_link ? '</a>' : '') . '</div>';
}

$saveo_output .= '<div class="post_content">'
			. ($saveo_show_categories 
					? '<div class="post_categories">'
						. saveo_get_post_categories()
						. $saveo_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($saveo_post_link ? '<a href="' . esc_url($saveo_post_link) . '">' : '') . ($saveo_post_title) . ($saveo_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('saveo_filter_get_post_info', 
								'<div class="post_info">'
									. ($saveo_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($saveo_post_link ? '<a href="' . esc_url($saveo_post_link) . '" class="post_info_date">' : '') 
											. esc_html($saveo_post_date) 
											. ($saveo_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($saveo_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'saveo') . ' ' 
											. ($saveo_post_link ? '<a href="' . esc_url($saveo_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($saveo_post_author_name) 
											. ($saveo_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$saveo_show_categories && $saveo_post_counters_output
										? $saveo_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
saveo_storage_set('saveo_output_widgets_posts', $saveo_output);
?>