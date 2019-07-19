<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0.10
 */

$saveo_footer_scheme =  saveo_is_inherit(saveo_get_theme_option('footer_scheme')) ? saveo_get_theme_option('color_scheme') : saveo_get_theme_option('footer_scheme');
$saveo_footer_id = str_replace('footer-custom-', '', saveo_get_theme_option("footer_style"));
$saveo_footer_meta = get_post_meta($saveo_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($saveo_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($saveo_footer_id))); 
						if (!empty($saveo_footer_meta['margin']) != '') 
							echo ' '.esc_attr(saveo_add_inline_css_class('margin-top: '.esc_attr(saveo_prepare_css_value($saveo_footer_meta['margin'])).';'));
						?> scheme_<?php echo esc_attr($saveo_footer_scheme); 
						?>">
	<?php
    // Custom footer's layout
    var_dump($saveo_footer_id);
    do_action('saveo_action_show_layout', $saveo_footer_id);
    var_dump('termino');
	?>
</footer><!-- /.footer_wrap -->
