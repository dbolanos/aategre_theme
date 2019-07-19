<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('saveo_mailchimp_get_css')) {
	add_filter('saveo_filter_get_css', 'saveo_mailchimp_get_css', 10, 4);
	function saveo_mailchimp_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

CSS;
		
			
			$rad = saveo_get_border_radius();
			$css['fonts'] .= <<<CSS

.mc4wp-form .mc4wp-form-fields input[type="email"],
.mc4wp-form .mc4wp-form-fields input[type="submit"] {
	-webkit-border-radius: {$rad};
	    -ms-border-radius: {$rad};
			border-radius: {$rad};
}

CSS;
		}

		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

.mc4wp-form input[type="email"] {
	color: {$colors['input_text']};
	border-color: {$colors['input_bd_color']};
	background-color: {$colors['input_bg_color']};
}
.mc4wp-form .mc4wp-alert {
	background-color: {$colors['text_link']};
	border-color: {$colors['text_hover']};
	color: {$colors['inverse_link']};
}
.scheme_dark .mc4wp-form input[type="email"] {
    color: {$colors['inverse_link']};
	border-color: {$colors['bg_color_0']};
	background-color: {$colors['bg_color_05']};
}
CSS;
		}

		return $css;
	}
}
?>