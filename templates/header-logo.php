<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */

$saveo_args = get_query_var('saveo_logo_args');

// Site logo
$saveo_logo_image  = saveo_get_logo_image(isset($saveo_args['type']) ? $saveo_args['type'] : '');
$saveo_logo_text   = saveo_is_on(saveo_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$saveo_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($saveo_logo_image) || !empty($saveo_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($saveo_logo_image)) {
			$saveo_attr = saveo_getimagesize($saveo_logo_image);
			echo '<img src="'.esc_url($saveo_logo_image).'" '.(!empty($saveo_attr[3]) ? sprintf(' %s', $saveo_attr[3]) : '').'>' ;
		} else {
			saveo_show_layout(saveo_prepare_macros($saveo_logo_text), '<span class="logo_text">', '</span>');
			saveo_show_layout(saveo_prepare_macros($saveo_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>