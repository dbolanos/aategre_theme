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
$saveo_columns = empty($saveo_blog_style[1]) ? 1 : max(1, $saveo_blog_style[1]);
$saveo_expanded = !saveo_sidebar_present() && saveo_is_on(saveo_get_theme_option('expand_content'));
$saveo_post_format = get_post_format();
$saveo_post_format = empty($saveo_post_format) ? 'standard' : str_replace('post-format-', '', $saveo_post_format);
$saveo_animation = saveo_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($saveo_columns).' post_format_'.esc_attr($saveo_post_format) ); ?>
	<?php echo (!saveo_is_off($saveo_animation) ? ' data-animation="'.esc_attr(saveo_get_animation_classes($saveo_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($saveo_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.esc_attr(get_the_title()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	saveo_show_post_featured( array(
											'class' => $saveo_columns == 1 ? 'trx-stretch-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => saveo_get_thumb_size(
																	strpos(saveo_get_theme_option('body_style'), 'full')!==false
																		? ( $saveo_columns > 1 ? 'huge' : 'original' )
																		: (	$saveo_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('saveo_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('saveo_action_before_post_meta'); 

			// Post meta
			$saveo_post_meta = saveo_show_post_meta(array(
									'categories' => false,
									'date' => true,
									'edit' => false,
                                    'author' => $saveo_columns < 2 ? true : false,
									'seo' => false,
									'share' => false,
									'counters' => $saveo_columns < 3 ? 'comments, views' : '',
									'echo' => false
									)
								);
			saveo_show_layout($saveo_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$saveo_show_learn_more = !in_array($saveo_post_format, array('link', 'aside', 'status', 'quote'));
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
				saveo_show_layout($saveo_post_meta);
			}
			// More button
			if ( $saveo_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'saveo'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>