<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0.10
 */


// Socials
if ( saveo_is_on(saveo_get_theme_option('socials_in_footer')) && ($saveo_output = saveo_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php saveo_show_layout($saveo_output); ?>
		</div>
	</div>
	<?php
}
?>