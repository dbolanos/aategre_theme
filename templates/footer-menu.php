<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0.10
 */

// Footer menu
$saveo_menu_footer = saveo_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($saveo_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php saveo_show_layout($saveo_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>