<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0.10
 */

// Copyright area
$saveo_footer_scheme =  saveo_is_inherit(saveo_get_theme_option('footer_scheme')) ? saveo_get_theme_option('color_scheme') : saveo_get_theme_option('footer_scheme');
$saveo_copyright_scheme = saveo_is_inherit(saveo_get_theme_option('copyright_scheme')) ? $saveo_footer_scheme : saveo_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($saveo_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and [[...]] on the <i>...</i> and <b>...</b>
                $date = new DateTime();
                $show_copyright = 'Aategre '. $date->format('Y');
                //Esta vara tiraba un copyright
				//$saveo_copyright = saveo_prepare_macros(saveo_get_theme_option('copyright'));
                $saveo_copyright = saveo_prepare_macros($show_copyright);
				if (!empty($saveo_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $saveo_copyright, $saveo_matches)) {
						$saveo_copyright = str_replace($saveo_matches[1], date(str_replace(array('{', '}'), '', $saveo_matches[1])), $saveo_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($saveo_copyright));
				}
			?></div>
		</div>
	</div>
</div>
