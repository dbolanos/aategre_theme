<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'saveo_vc_get_css' ) ) {
	add_filter( 'saveo_filter_get_css', 'saveo_vc_get_css', 10, 4 );
	function saveo_vc_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
.wpb-js-composer .vc_tta-tabs-list .vc_tta-tab > a,
.vc_tta.vc_tta-accordion .vc_tta-panel-title .vc_tta-title-text {
	{$fonts['h1_font-family']}
}

CSS;
		}

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Row and columns */
.scheme_self.vc_section,
.scheme_self.wpb_row,
.scheme_self.wpb_column > .vc_column-inner > .wpb_wrapper,
.scheme_self.wpb_text_column {
	color: {$colors['text']};
}
.scheme_self.vc_row.vc_parallax[class*="scheme_"] .vc_parallax-inner:before {
	background-color: {$colors['bg_color_08']};
}
/* Accordion */
.wpb-js-composer .vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon {
	color: {$colors['text_dark']};
}
.wpb-js-composer .vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon:before,
.wpb-js-composer .vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon:after {
	border-color: {$colors['text_link']};
	color: {$colors['text_link']};
}
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a {
    color: {$colors['text_link']};
	background-color: {$colors['alter_bg_color']};
}
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a,
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon,
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover .vc_tta-controls-icon {
	color: {$colors['inverse_text']};
}
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel:hover .vc_tta-panel-title > a .vc_tta-controls-icon:before,
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel:hover .vc_tta-panel-title > a .vc_tta-controls-icon:after,
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon:before,
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon:after {
	border-color: {$colors['inverse_link']};
	color: {$colors['inverse_link']};
}

/* Tabs */
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab > a {
	color: {$colors['text_link']};
	background-color: {$colors['alter_bg_color']};
}
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab > a:hover,
.wpb-js-composer .vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab.vc_active > a {
    color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
body.wpb-js-composer .vc_tta.vc_general .vc_tta-tabs-list {
    border-color: {$colors['text_link']};
}

/* Separator */
.vc_separator.vc_sep_color_grey .vc_sep_line {
	border-color: {$colors['bd_color']};
}

/* Progress bar */
.vc_progress_bar .vc_single_bar {
	background-color: {$colors['alter_bg_color']};
}
.vc_row-has-fill .vc_progress_bar.vc_progress_bar_narrow .vc_single_bar {
	background-color: {$colors['bg_color']};
}
.vc_progress_bar.vc_progress_bar_narrow.vc_progress-bar-color-bar_red .vc_single_bar .vc_bar {
	background-color: {$colors['alter_link']};
}
.vc_progress_bar .vc_single_bar .vc_label {
	color: {$colors['text']};
}
.vc_progress_bar .vc_single_bar .vc_label .vc_label_units {
	color: {$colors['text']};
}

a.eg-julymorison1-element-3,
a.eg-julymorison-element-3 {
    color: {$colors['inverse_text']};
}
a.eg-julymorison1-element-3:hover,
a.eg-julymorison-element-3:hover {
    color: {$colors['text_link']};
}
.vc_color-grey.vc_message_box {
    background-color: {$colors['alter_bg_color']};
    color: {$colors['text_link']};
}
.vc_color-grey.vc_message_box.vc_message_box_closeable:after,
.vc_color-grey.vc_message_box .vc_message_box-icon {
    color: {$colors['text_link']};
}

.vc_color-warning.vc_message_box {
    background-color: {$colors['text_link2']};
    color: {$colors['inverse_link']};
}
.vc_color-warning.vc_message_box.vc_message_box_closeable:after,
.vc_color-warning.vc_message_box .vc_message_box-icon {
    color: {$colors['inverse_link']};
}

.vc_color-info.vc_message_box {
    background-color: {$colors['text_link']};
    color: {$colors['inverse_link']};
}
.vc_color-info.vc_message_box.vc_message_box_closeable:after,
.vc_color-info.vc_message_box .vc_message_box-icon {
    color: {$colors['inverse_link']};
}

.vc_color-success.vc_message_box {
    background-color: {$colors['text_hover']};
    color: {$colors['inverse_link']};
}
.vc_color-success.vc_message_box.vc_message_box_closeable:after,
.vc_color-success.vc_message_box .vc_message_box-icon {
    color: {$colors['inverse_link']};
}
 .vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_bar {
    background: linear-gradient(to right, {$colors['text_link3']}, {$colors['text_hover3']});
}
CSS;
		}
		
		return $css;
	}
}
?>