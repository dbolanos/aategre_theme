<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('saveo_booked_theme_setup9')) {
	add_action( 'after_setup_theme', 'saveo_booked_theme_setup9', 9 );
	function saveo_booked_theme_setup9() {
		if (saveo_exists_booked()) {
			add_action( 'wp_enqueue_scripts', 							'saveo_booked_frontend_scripts', 1100 );
			add_filter( 'saveo_filter_merge_styles',					'saveo_booked_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'saveo_filter_tgmpa_required_plugins',		'saveo_booked_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'saveo_exists_booked' ) ) {
	function saveo_exists_booked() {
		return class_exists('booked_plugin');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'saveo_booked_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('saveo_filter_tgmpa_required_plugins',	'saveo_booked_tgmpa_required_plugins');
	function saveo_booked_tgmpa_required_plugins($list=array()) {
		if (in_array('booked', saveo_storage_get('required_plugins'))) {
			$path = saveo_get_file_dir('plugins/booked/booked.zip');
			$list[] = array(
					'name' 		=> esc_html__('Booked Appointments', 'saveo'),
					'slug' 		=> 'booked',
					'source' 	=> !empty($path) ? $path : 'upload://booked.zip',
					'required' 	=> false
			);
		}
		return $list;
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'saveo_booked_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'saveo_booked_frontend_scripts', 1100 );
	function saveo_booked_frontend_scripts() {
		if (saveo_is_on(saveo_get_theme_option('debug_mode')) && saveo_get_file_dir('plugins/booked/booked.css')!='')
			wp_enqueue_style( 'saveo-booked',  saveo_get_file_url('plugins/booked/booked.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'saveo_booked_merge_styles' ) ) {
	//Handler of the add_filter('saveo_filter_merge_styles', 'saveo_booked_merge_styles');
	function saveo_booked_merge_styles($list) {
		$list[] = 'plugins/booked/booked.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (saveo_exists_booked()) { require_once SAVEO_THEME_DIR . 'plugins/booked/booked.styles.php'; }
?>