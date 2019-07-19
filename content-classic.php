<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

$saveo_blog_style = explode('_', saveo_get_theme_option('blog_style'));
$saveo_columns = empty($saveo_blog_style[1]) ? 2 : max(2, $saveo_blog_style[1]);
$saveo_expanded = !saveo_sidebar_present() && saveo_is_on(saveo_get_theme_option('expand_content'));
$saveo_post_format = get_post_format();
$saveo_post_format = empty($saveo_post_format) ? 'standard' : str_replace('post-format-', '', $saveo_post_format);
$saveo_animation = saveo_get_theme_option('blog_animation');

?><div class="<?php echo trim($saveo_blog_style[0] == 'classic' ? 'column' : 'masonry_item masonry_item'); ?>-1_<?php echo esc_attr($saveo_columns); ?>"><article id="post-<?php the_ID(); ?>"
	<?php post_class( 'post_item post_format_'.esc_attr($saveo_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($saveo_columns)
					. ' post_layout_'.esc_attr($saveo_blog_style[0]) 
					. ' post_layout_'.esc_attr($saveo_blog_style[0]).'_'.esc_attr($saveo_columns)
					); ?>
	<?php echo (!saveo_is_off($saveo_animation) ? ' data-animation="'.esc_attr(saveo_get_animation_classes($saveo_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	saveo_show_post_featured( array( 'thumb_size' => saveo_get_thumb_size($saveo_blog_style[0] == 'classic'
													? (strpos(saveo_get_theme_option('body_style'), 'full')!==false 
															? ( $saveo_columns > 2 ? 'big' : 'huge' )
															: (	$saveo_columns > 2
																? ($saveo_expanded ? 'med' : 'small')
																: ($saveo_expanded ? 'big' : 'med')
																)
														)
													: (strpos(saveo_get_theme_option('body_style'), 'full')!==false 
															? ( $saveo_columns > 2 ? 'masonry-big' : 'full' )
															: (	$saveo_columns <= 2 && $saveo_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($saveo_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('saveo_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('saveo_action_before_post_meta'); 

			// Post meta
			saveo_show_post_meta(array(
				'categories' => false,
				'date' => true,
				'edit' => false,
				'seo' => false,
				'share' => false,
				'counters' => 'comments,views',
				)
			);
			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$saveo_show_learn_more = false; //!in_array($saveo_post_format, array('link', 'aside', 'status', 'quote'));
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($saveo_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($saveo_post_format == 'quote') {
				if (($quote = saveo_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					saveo_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 1)!='[') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($saveo_post_format, array('link', 'aside', 'status', 'quote'))) {
			saveo_show_post_meta(array(
				'share' => false,
				'counters' => 'comments'
				)
			);
		}
		// More button
		if ( $saveo_show_learn_more ) {
			?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'saveo'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>