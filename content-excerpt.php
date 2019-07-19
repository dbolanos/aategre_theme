<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

$saveo_post_format = get_post_format();
$saveo_post_format = empty($saveo_post_format) ? 'standard' : str_replace('post-format-', '', $saveo_post_format);
$saveo_animation = saveo_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($saveo_post_format) ); ?>
	<?php echo (!saveo_is_off($saveo_animation) ? ' data-animation="'.esc_attr(saveo_get_animation_classes($saveo_animation)).'"' : ''); ?>
	><?php

	// Featured image
	saveo_show_post_featured(array( 'thumb_size' => saveo_get_thumb_size( strpos(saveo_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));


    ?><div class="post-body"><?php
    // Title and post meta
    if (get_the_title() != '') {
        ?>
        <div class="post_header entry-header">
            <?php

            do_action('saveo_action_before_post_meta');

            $dt = apply_filters('saveo_filter_get_post_date', saveo_get_date('', 'j M'));
            $date = explode(' ', $dt);
            if (count($date) > 1) {
                $date[0] = '<span class="post-date">' . $date[0] .'</span>';
                $date[count($date) - 1] = ' <span class="post-day">' . $date[count($date) - 1] .'</span>';
            }
            $dt = '';
            foreach($date as $d ) {
                $dt = $dt . ' ' . $d;
            }
            if (!empty($dt)) {
                ?>
                <div class="post_meta_item post_date"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo wp_kses_post($dt); ?></a></div>
                <?php
            }


            do_action('saveo_action_before_post_title');

            // Post title
            the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );


            ?>
        </div><!-- .post_header --><?php
    }
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (saveo_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'saveo' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'saveo' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$saveo_show_learn_more = !in_array($saveo_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
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
			?></div><?php
			// More button
			if ( $saveo_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Continue reading', 'saveo'); ?></a></p><?php
			}

		}
            ?></div></div><!-- .entry-content -->
</article>