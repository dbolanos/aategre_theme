<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0.10
 */

// Footer sidebar
$saveo_footer_name = saveo_get_theme_option('footer_widgets');
$saveo_footer_present = !saveo_is_off($saveo_footer_name) && is_active_sidebar($saveo_footer_name);
if ($saveo_footer_present) { 
	saveo_storage_set('current_sidebar', 'footer');
	$saveo_footer_wide = saveo_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($saveo_footer_name) ) {
		dynamic_sidebar($saveo_footer_name);
	}
	$saveo_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($saveo_out)) {
		$saveo_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $saveo_out);
		$saveo_need_columns = true;	//or check: strpos($saveo_out, 'columns_wrap')===false;
		if ($saveo_need_columns) {
			$saveo_columns = max(0, (int) saveo_get_theme_option('footer_columns'));
			if ($saveo_columns == 0) $saveo_columns = min(4, max(1, substr_count($saveo_out, '<aside ')));
			if ($saveo_columns > 1)
				$saveo_out = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($saveo_columns).' widget ', $saveo_out);
			else
				$saveo_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($saveo_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row  sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$saveo_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($saveo_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'saveo_action_before_sidebar' );
				saveo_show_layout($saveo_out);
				do_action( 'saveo_action_after_sidebar' );
				if ($saveo_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$saveo_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>