<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												. ' itemscope'
												); ?>
		itemscope itemtype="http://schema.org/<?php echo esc_attr(is_single() ? 'BlogPosting' : 'Article'); ?>">
	<?php
	// Structured data snippets
	if (saveo_is_on(saveo_get_theme_option('seo_snippets'))) {
		?>
		<div class="structured_data_snippets">
			<meta itemprop="headline" content="<?php echo esc_attr(get_the_title()); ?>">
			<meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
			<meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('Y-m-d')); ?>">
			<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php echo esc_url(get_the_permalink()); ?>" content="<?php echo esc_attr(get_the_title()); ?>"/>	
			<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
					<?php 
					$saveo_logo_image = saveo_get_retina_multiplier(2) > 1 
										? saveo_get_theme_option( 'logo_retina' )
										: saveo_get_theme_option( 'logo' );
					if (!empty($saveo_logo_image)) {
						$saveo_attr = saveo_getimagesize($saveo_logo_image);
						?>
						<img itemprop="url" src="<?php echo esc_url($saveo_logo_image); ?>">
						<meta itemprop="width" content="<?php echo esc_attr($saveo_attr[0]); ?>">
						<meta itemprop="height" content="<?php echo esc_attr($saveo_attr[1]); ?>">
						<?php
					}
					?>
				</div>
				<meta itemprop="name" content="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
				<meta itemprop="telephone" content="">
				<meta itemprop="address" content="">
			</div>
		</div>
		<?php
	}
    ?><div class="post-full"><?php
	// Featured image
	if ( !saveo_sc_layouts_showed('featured'))
		saveo_show_post_featured();

   ?><div class="post-body"><?php



        // Title and post meta
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

                // Post title
                if (!saveo_sc_layouts_showed('title')) {
                    the_title( '<h3 class="post_title entry-title"'.(saveo_is_on(saveo_get_theme_option('seo_snippets')) ? ' itemprop="headline"' : '').'>', '</h3>' );
                }
                ?>
            </div><!-- .post_header -->
            <?php


	// Post content
	?>
	<div class="post_content entry-content" itemprop="articleBody">
		<?php
			the_content( );

			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'saveo' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'saveo' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

        // Taxonomies and share
        if ( is_single() && !is_attachment() ) {
            ?>
            <div class="post_meta post_meta_single"><?php

                // Post taxonomies
                ?><div class="single-meta"><span class="post_meta_item post_categories"><span class="post_meta_label"><?php esc_html_e('Categories:', 'saveo'); ?></span> <?php

                        if ( !is_attachment() && !is_page() ) {
                            $cats = get_post_type()=='post' ? get_the_category_list(', ') : apply_filters('saveo_filter_get_post_categories', '');
                            if (!empty($cats)) {
                                ?>
                                <span class="post_meta_item post_categories"><?php saveo_show_layout($cats); ?></span>
                            <?php
                            }
                        }

                        ?></span><?php
                    if( get_the_tags() ) {
                        // Post taxonomies
                        ?><span class="post_meta_item post_tags"><span
                            class="post_meta_label"><?php esc_html_e('Tags:', 'saveo'); ?></span> <?php the_tags('', ', ', ''); ?></span>
                    <?php

                    }
                    ?> </div> <?php

                // Share
                saveo_show_share_links(array(
                    'type' => 'block',
                    'caption' => '',
                    'before' => '<span class="post_meta_item post_share">',
                    'after' => '</span>'
                ));
                ?>
            </div>
        <?php
        }
		?>
	</div></div></div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {	// && is_multi_author()
			get_template_part( 'templates/author-bio' );
		}
	?>
</article>
