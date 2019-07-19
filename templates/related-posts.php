<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

$saveo_link = get_permalink();
$saveo_post_format = get_post_format();
$saveo_post_format = empty($saveo_post_format) ? 'standard' : str_replace('post-format-', '', $saveo_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($saveo_post_format) ); ?>><?php
	saveo_show_post_featured(array(
		'thumb_size' => saveo_get_thumb_size( 'big' ),
		'show_no_image' => false,
		'singular' => false,
		'post_info' => '<div class="post_header entry-header">'
							. '<div class="post_categories">' . saveo_get_post_categories('') . '</div>'
							. '<h4 class="post_title entry-title"><a href="' . esc_url($saveo_link) . '">' . get_the_title() . '</a></h4>'
							. (in_array(get_post_type(), array('post', 'attachment'))
									? '<span class="post_date"><a href="' . esc_url($saveo_link) . '">' . saveo_get_date() . '</a></span>'
									: '')
						. '</div>'
		)
	);
?></div>