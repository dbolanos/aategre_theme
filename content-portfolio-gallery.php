<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

$saveo_blog_style = explode('_', saveo_get_theme_option('blog_style'));
$saveo_columns = empty($saveo_blog_style[1]) ? 2 : max(2, $saveo_blog_style[1]);
$saveo_post_format = get_post_format();
$saveo_post_format = empty($saveo_post_format) ? 'standard' : str_replace('post-format-', '', $saveo_post_format);
$saveo_animation = saveo_get_theme_option('blog_animation');
$saveo_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($saveo_columns).' post_format_'.esc_attr($saveo_post_format) ); ?>
	<?php echo (!saveo_is_off($saveo_animation) ? ' data-animation="'.esc_attr(saveo_get_animation_classes($saveo_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($saveo_image[1]) && !empty($saveo_image[2])) echo intval($saveo_image[1]) .'x' . intval($saveo_image[2]); ?>"
	data-src="<?php if (!empty($saveo_image[0])) echo esc_url($saveo_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$saveo_image_hover = 'icon';	//saveo_get_theme_option('image_hover');
	if (in_array($saveo_image_hover, array('icons', 'zoom'))) $saveo_image_hover = 'dots';
	saveo_show_post_featured(array(
		'hover' => $saveo_image_hover,
		'thumb_size' => saveo_get_thumb_size( strpos(saveo_get_theme_option('body_style'), 'full')!==false || $saveo_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. saveo_show_post_meta(array(
									'categories' => true,
									'date' => true,
									'edit' => false,
									'seo' => false,
									'share' => true,
									'counters' => 'comments',
									'echo' => false
									))
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'saveo') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>