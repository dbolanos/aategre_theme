<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('saveo_trx_addons_get_mycss')) {
	add_filter('saveo_filter_get_css', 'saveo_trx_addons_get_mycss', 10, 4);
	function saveo_trx_addons_get_mycss($css, $colors, $fonts, $scheme='') {

        if (isset($css['fonts']) && $fonts) {
            $css['fonts'] .= <<<CSS
            body .mejs-container *,
            .sc_testimonials_item_author_title,
            .sc_testimonials_item_content:before,
            .vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label .vc_label_units {
                {$fonts['p_font-family']}
            }
            .price-header,
            .sc_testimonials [class*="column"] .sc_testimonials_item_content,
            .sc_price_title,
            .vc_message_box,
            .sc_skills_counter .sc_skills_total,
            .sc_skills .sc_skills_total,
            .sc_table table tr:first-child th,
            .sc_table table tr:first-child td,
            .trx_addons_dropcap {
                {$fonts['h1_font-family']}
            }

CSS;
        }

        if (isset($css['colors']) && $colors) {
            $css['colors'] .= <<<CSS
            .trx_addons_accent,
            .trx_addons_accent > a,
            .trx_addons_accent > * {
                color: {$colors['text_hover']};
            }
            .trx_addons_accent_hovered,
            .trx_addons_accent_hovered > a,
            .trx_addons_accent_hovered > * {
                color: {$colors['text_link']};
            }
            .trx_addons_accent_bg {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_hover']};
            }
            .trx_addons_accent_hovered_bg {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_link']};
            }
            .trx_addons_tooltip:before {
                background-color: {$colors['text_dark']};
                color: {$colors['inverse_link']};
            }
            .trx_addons_tooltip:after {
                border-top-color: {$colors['text_dark']};
            }
            .trx_addons_dropcap_style_1 {
                background: {$colors['text_hover']};
                color: {$colors['inverse_link']};
            }
            .trx_addons_dropcap_style_2 {
                background: {$colors['text_link']};
                color: {$colors['inverse_link']};
            }
            ul[class*="trx_addons_list_custom"] > li:before {
            }
            ol > li::before,
            ul[class*="trx_addons_list_custom"] > li:before,
            ul[class*="trx_addons_list"] > li:before{
                color: {$colors['text_hover']};
            }
            .sc_table table tr:first-child th,
            .sc_table table tr:first-child td {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_hover']};
                border-color: {$colors['bg_color_02']};
            }
            .sc_table table tr:nth-child(n+2) td:first-child {
                color: {$colors['text_hover']};
            }
            .sc_form_field_title {
                color: {$colors['text']};
            }
            .socials_wrap .social_item .social_icon {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_link']};
            }
            .socials_wrap .social_item:hover .social_icon {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_hover']};
            }
            .sc_layouts_item_icon,
            .sc_layouts_item_details_line1 {
                color: {$colors['text_hover']};
            }
            .sc_layouts_menu_nav>li>a {
                color: {$colors['text_dark']} !important;
            }
            .sc_layouts_menu_nav>li.current-menu-item>a,
            .sc_layouts_menu_nav>li.current-menu-parent>a,
            .sc_layouts_menu_nav>li.current-menu-ancestor>a {
                color: {$colors['text_link']} !important;
            }
            .sc_layouts_menu_nav>li>ul:before,
            .sc_layouts_menu_popup .sc_layouts_menu_nav,
            .sc_layouts_menu_nav>li ul {
                background-color: {$colors['text_hover']};
            }
            .sc_layouts_menu_popup .sc_layouts_menu_nav>li>a,
            .sc_layouts_menu_nav>li li>a {
                color: {$colors['inverse_link']} !important;
            }
            .sc_layouts_menu_popup .sc_layouts_menu_nav>li>a:hover,
            .sc_layouts_menu_popup .sc_layouts_menu_nav>li.sfHover>a,
            .sc_layouts_menu_nav>li li>a:hover,
            .sc_layouts_menu_nav>li li.sfHover>a,
            .sc_layouts_menu_nav>li li.current-menu-item>a,
            .sc_layouts_menu_nav>li li.current-menu-parent>a,
            .sc_layouts_menu_nav>li li.current-menu-ancestor>a {
                color: {$colors['text_dark']} !important;
                background-color: {$colors['bg_color_0']};
            }
            .sc_layouts_title_breadcrumbs a:hover {
                color: {$colors['text_hover']} !important;
            }
            .sc_skills .sc_skills_total {
                color: {$colors['text_dark']};
            }
            .sc_skills .sc_skills_item_title {
                color: {$colors['text']};
            }
            .sc_skills_counter .sc_skills_item_title,
            .sc_skills_counter .sc_skills_icon+.sc_skills_total,
            .sc_skills_counter .sc_skills_icon {
                color: {$colors['text_hover']};
            }
            .scheme_dark .slider_swiper_outer .slider_pagination_wrap .swiper-pagination-bullet, .scheme_dark .slider_swiper .slider_pagination_wrap .swiper-pagination-bullet, .scheme_dark .slider_swiper_outer .slider_pagination_wrap .swiper-pagination-bullet, .scheme_dark .swiper-pagination-custom .swiper-pagination-button,
            .slider_swiper_outer .slider_pagination_wrap .swiper-pagination-bullet,
            .slider_swiper .slider_pagination_wrap .swiper-pagination-bullet,
            .slider_swiper_outer .slider_pagination_wrap .swiper-pagination-bullet,
            .swiper-pagination-custom .swiper-pagination-button {
                background-color: {$colors['bg_color_04']};
            }
            .slider_swiper_outer .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
            .swiper-pagination-custom .swiper-pagination-button.swiper-pagination-button-active,
            .slider_swiper .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
            .slider_swiper_outer .slider_pagination_wrap .swiper-pagination-bullet.swiper-pagination-bullet-active,
            .slider_swiper .slider_pagination_wrap .swiper-pagination-bullet:hover,
            .slider_swiper_outer .slider_pagination_wrap .swiper-pagination-bullet:hover {
                background-color: {$colors['bg_color_0']};
            }
            .trx_addons_audio_player.without_cover {
                background-color: {$colors['text_link']};
            }
            .trx_addons_audio_player .mejs-container .mejs-controls .mejs-time,
            .trx_addons_audio_player .audio_caption,
            .trx_addons_audio_player.without_cover .audio_author {
                color: {$colors['inverse_link']};
            }
            .trx_addons_audio_player .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total:before, .trx_addons_audio_player .mejs-controls .mejs-time-rail .mejs-time-total:before {
                 background-color: {$colors['bg_color_05']};
            }
            .sc_price {
                color: {$colors['text']};
                background-color: {$colors['alter_bg_color']};
            }
            .sc_price:hover {
                color: {$colors['text']};
                background-color: {$colors['alter_bg_hover']};
            }
            .price-header {
                background-color: {$colors['text_link']};
            }
            .sc_price_info .sc_price_details {
                color: {$colors['text']};
            }
            .sc_price_info .sc_price_title,
            .sc_price_info .sc_price_title a {
                color: {$colors['text_dark']};
            }
            .sc_price:hover .sc_price_link, .sc_price_link:hover {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_link']};
            }
            .sc_price:hover .sc_price_info .sc_price_title,
            .sc_price:hover .sc_price_info .sc_price_title a {
                color: {$colors['text_link']};
            }
            .sc_googlemap_content {
                background-color: {$colors['text_hover']};
            }
            .sc_googlemap_content h5 {
                color: {$colors['inverse_link']};
            }
            .sc_services_default .sc_services_item {
                background-color: transparent;
                color: {$colors['text']};
            }
            .scheme_dark .sc_services_default .sc_services_item {
                color: {$colors['bg_color_07']};
            }
            .sc_services_default .sc_services_item_icon {
                 color: {$colors['text_link']};
                background-color: {$colors['text_dark']};
                border-color: {$colors['text_dark']};
            }
            .sc_services_default .sc_services_item_icon {
                 color: {$colors['text_link']};
                background-color: {$colors['text_dark']};
            }
            .sc_services_default .sc_services_item:hover .sc_services_item_icon,
            .sc_services_default .sc_services_item_icon:hover {
                 color: {$colors['text_dark']};
                background-color: {$colors['text_dark_05']};
            }
            .sc_services_default .sc_services_item_featured_left .sc_services_item_icon,
            .sc_services_default .sc_services_item_featured_right .sc_services_item_icon {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_link']};
                border-color: {$colors['text_link']};
            }
            .sc_services_default .sc_services_item_featured_left:hover .sc_services_item_icon,
            .sc_services_default .sc_services_item_featured_right:hover .sc_services_item_icon,
            .sc_services_list .sc_services_item_featured_left:hover .sc_services_item_icon,
            .sc_services_list .sc_services_item_featured_right:hover .sc_services_item_icon {
                color: {$colors['inverse_link']};
                background-color: {$colors['text_hover']};
                border-color: {$colors['text_hover']};
            }
            .sc_services_default .sc_services_item_featured_left.with_icon .sc_services_item_title,
            .sc_services_default .sc_services_item_featured_left.with_icon .sc_services_item_title a {
                color: {$colors['text_link']};
            }
            .sc_services_default .sc_services_item_featured_left.with_icon .sc_services_item_title:hover,
            .sc_services_default .sc_services_item_featured_left.with_icon .sc_services_item_title a:hover {
                color: {$colors['text_hover']};
            }
            .sc_services_hover .sc_services_item.with_image .sc_services_item_content:before {
                background-color: {$colors['text_hover']};
            }
            .sc_services_hover .sc_services_item_content_inner h5:before,
            .sc_services_hover .sc_services_item_text {
                color: {$colors['inverse_link']};
            }
            .scheme_dark .sc_skills_counter .sc_skills_item_title, .scheme_dark .sc_skills_counter .sc_skills_icon+.sc_skills_total, .scheme_dark .sc_skills_counter .sc_skills_icon {
                color: {$colors['inverse_link']};
            }
            .sc_team_default .sc_team_item {
                background-color: {$colors['bg_color']};
            }
            .sc_team_default .sc_team_item_title:before {
                color: {$colors['text_link']};
            }
            .sc_team_default .sc_team_item_subtitle {
                color: {$colors['text']};
            }
            ul[class*="trx_addons_list_custom"] li a:hover {
                color: {$colors['text_hover']};
            }
            .sc_blogger_item_title a:hover,
            .sc_blogger .sc_blogger_item .sc_blogger_item_title:before,
            .sc_action_item_title {
                color: {$colors['text_link']};
            }
            .sc_blogger_item {
                background-color: {$colors['bg_color']};
            }
            .sc_blogger_item_content {
                color: {$colors['text']};
            }
            .widget_twitter .widget_content .sc_twitter_item a,
            .widget_twitter .widget_content ul > li a {
                color: {$colors['text_dark']};
            }
            .widget_twitter .widget_content .sc_twitter_item a:hover,
            .widget_twitter .widget_content ul > li a:hover {
                color: {$colors['text_dark_05']};
            }
            .widget_twitter .widget_content .sc_twitter_item .sc_twitter_item_icon {
                color: {$colors['text_dark']} !important;
            }
            .sc_promo .sc_promo_icon a {
                color: {$colors['bg_color']};
            }
            .sc_promo .sc_promo_icon a:hover {
                color: {$colors['text_hover']};
            }
            .sc_promo {
                background-color: {$colors['alter_bg_color']};
            }
            .sc_promo .sc_item_title {
                color: {$colors['text_link']};
            }
            .sc_promo .vc_progress_bar .vc_single_bar {
                background-color: {$colors['bg_color']};
            }
            .sc_testimonials_item_content:before,
            .sc_testimonials_item_author_title {
                color: {$colors['text_dark']};
            }
            blockquote.trx_addons_blockquote_style_1:before {
                color: {$colors['text_link']};
                background-color: {$colors['bg_color_0']};
            }
            blockquote.trx_addons_blockquote_style_1 {
                color: {$colors['text']};
                background-color: {$colors['bg_color']};
            }
            .scheme_dark .sc_layouts_menu_nav .menu-collapse>a:after {
                background-color: {$colors['bg_color']} !important;
            }
            blockquote.trx_addons_blockquote_style_1 b {
                color: {$colors['text_dark']};
            }
            blockquote.trx_addons_blockquote_style_1 a,
            blockquote.trx_addons_blockquote_style_1 cite {
                color: {$colors['text_dark']};
            }
            .sc_button_simple:not(.sc_button_bg_image):hover,
            .sc_services_default .with_image .sc_services_item_title:before,
            blockquote.trx_addons_blockquote_style_1 a:hover {
                color: {$colors['text_link']} !important;
            }
            .sc_button_simple:not(.sc_button_bg_image) {
                color: {$colors['text_hover']};
            }
            .scheme_dark .sc_slider_controls .slider_controls_wrap>a:hover, .scheme_dark .slider_swiper.slider_controls_side .slider_controls_wrap>a:hover, .scheme_dark .slider_outer_controls_side .slider_controls_wrap>a:hover,
            .scheme_dark .sc_layouts_menu_nav>li>a:hover, .scheme_dark .sc_layouts_menu_nav>li.sfHover>a,
            .scheme_dark .sc_layouts_menu_nav>li.current-menu-item>a, .scheme_dark .sc_layouts_menu_nav>li.current-menu-parent>a, .scheme_dark .sc_layouts_menu_nav>li.current-menu-ancestor>a {
                color: {$colors['bg_color_05']} !important;
            }
            .content .search_wrap .search_submit,
            .scheme_dark .sc_layouts_menu_popup .sc_layouts_menu_nav>li>a:hover, .scheme_dark .sc_layouts_menu_popup .sc_layouts_menu_nav>li.sfHover>a, .scheme_dark .sc_layouts_menu_nav>li li>a:hover, .scheme_dark .sc_layouts_menu_nav>li li.sfHover>a, .scheme_dark .sc_layouts_menu_nav>li li.current-menu-item>a, .scheme_dark .sc_layouts_menu_nav>li li.current-menu-parent>a, .scheme_dark .sc_layouts_menu_nav>li li.current-menu-ancestor>a {
                 color: {$colors['text_dark']} !important;
            }
            .scheme_dark .sc_layouts_row_type_compact .sc_layouts_item_icon, .scheme_dark.sc_layouts_row_type_compact .sc_layouts_item_icon {
                color: {$colors['bg_color']};
            }
CSS;
		}

		return $css;
	}
}
?>