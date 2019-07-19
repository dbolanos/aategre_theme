<?php
/* gdpr-compliance support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('saveo_gdpr_theme_setup9')) {
	add_action( 'after_setup_theme', 'saveo_gdpr_theme_setup9', 9 );
	function saveo_gdpr_theme_setup9() {
		if (saveo_exists_gdpr()) {
			add_filter( 'saveo_filter_merge_styles',					'saveo_gdpr_merge_styles');
		}
		if (is_admin()) {
			add_filter( 'saveo_filter_tgmpa_required_plugins',		'saveo_gdpr_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'saveo_exists_gdpr' ) ) {
	function saveo_exists_gdpr() {
		return function_exists('__gdpr_load_plugin') || defined('GDPR_VERSION');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'saveo_gdpr_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('saveo_filter_tgmpa_required_plugins',	'saveo_gdpr_tgmpa_required_plugins');
	function saveo_gdpr_tgmpa_required_plugins($list=array()) {
		if (in_array('wp-gdpr-compliance', saveo_storage_get('required_plugins')))
			$list[] = array(
				'name' 		=> esc_html__('WP GDPR Compliance', 'saveo'),
				'slug' 		=> 'wp-gdpr-compliance',
				'required' 	=> false
			);
		return $list;
	}
}

