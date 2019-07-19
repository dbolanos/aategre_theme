<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

// Header sidebar
$saveo_header_name = saveo_get_theme_option('header_widgets');
$saveo_header_present = !saveo_is_off($saveo_header_name) && is_active_sidebar($saveo_header_name);
if ($saveo_header_present) { 
	saveo_storage_set('current_sidebar', 'header');
	$saveo_header_wide = saveo_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($saveo_header_name) ) {
		dynamic_sidebar($saveo_header_name);
	}
	$saveo_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($saveo_widgets_output)) {
		$saveo_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $saveo_widgets_output);
		$saveo_need_columns = strpos($saveo_widgets_output, 'columns_wrap')===false;
		if ($saveo_need_columns) {
			$saveo_columns = max(0, (int) saveo_get_theme_option('header_columns'));
			if ($saveo_columns == 0) $saveo_columns = min(6, max(1, substr_count($saveo_widgets_output, '<aside ')));
			if ($saveo_columns > 1)
				$saveo_widgets_output = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($saveo_columns).' widget ', $saveo_widgets_output);
			else
				$saveo_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($saveo_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$saveo_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($saveo_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'saveo_action_before_sidebar' );
				saveo_show_layout($saveo_widgets_output);
				do_action( 'saveo_action_after_sidebar' );
				if ($saveo_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$saveo_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>