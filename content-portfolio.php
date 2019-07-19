<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($saveo_columns).' post_format_'.esc_attr($saveo_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!saveo_is_off($saveo_animation) ? ' data-animation="'.esc_attr(saveo_get_animation_classes($saveo_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$saveo_image_hover = saveo_get_theme_option('image_hover');
	// Featured image
	saveo_show_post_featured(array(
		'thumb_size' => saveo_get_thumb_size(strpos(saveo_get_theme_option('body_style'), 'full')!==false || $saveo_columns < 3 ? 'masonry-big' : 'masonry'),
		'show_no_image' => true,
		'class' => $saveo_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $saveo_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>