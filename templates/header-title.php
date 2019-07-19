<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

// Page (category, tag, archive, author) title

if ( saveo_need_page_title() ) {
	saveo_sc_layouts_showed('title', true);
	saveo_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$saveo_blog_title = saveo_get_blog_title();
							$saveo_blog_title_text = $saveo_blog_title_class = $saveo_blog_title_link = $saveo_blog_title_link_text = '';
							if (is_array($saveo_blog_title)) {
								$saveo_blog_title_text = $saveo_blog_title['text'];
								$saveo_blog_title_class = !empty($saveo_blog_title['class']) ? ' '.$saveo_blog_title['class'] : '';
								$saveo_blog_title_link = !empty($saveo_blog_title['link']) ? $saveo_blog_title['link'] : '';
								$saveo_blog_title_link_text = !empty($saveo_blog_title['link_text']) ? $saveo_blog_title['link_text'] : '';
							} else
								$saveo_blog_title_text = $saveo_blog_title;
							?>
							<h1 class="sc_layouts_title_caption<?php echo esc_attr($saveo_blog_title_class); ?>"><?php
								$saveo_top_icon = saveo_get_category_icon();
								if (!empty($saveo_top_icon)) {
									$saveo_attr = saveo_getimagesize($saveo_top_icon);
									?><img src="<?php echo esc_url($saveo_top_icon); ?>"  <?php if (!empty($saveo_attr[3])) saveo_show_layout($saveo_attr[3]);?>><?php
								}
								echo wp_kses_data($saveo_blog_title_text);
							?></h1>
							<?php
							if (!empty($saveo_blog_title_link) && !empty($saveo_blog_title_link_text)) {
								?><a href="<?php echo esc_url($saveo_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($saveo_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'saveo_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>