<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

$saveo_sidebar_position = saveo_get_theme_option('sidebar_position');
if (saveo_sidebar_present()) {
	ob_start();
	$saveo_sidebar_name = saveo_get_theme_option('sidebar_widgets');
	saveo_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($saveo_sidebar_name) ) {
		dynamic_sidebar($saveo_sidebar_name);
	}
	$saveo_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($saveo_out)) {
		?>
		<div class="sidebar <?php echo esc_attr($saveo_sidebar_position); ?> widget_area<?php if (!saveo_is_inherit(saveo_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(saveo_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'saveo_action_before_sidebar' );
				saveo_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $saveo_out));
				do_action( 'saveo_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>