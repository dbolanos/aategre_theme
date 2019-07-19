<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('saveo_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'saveo_cf7_theme_setup9', 9 );
	function saveo_cf7_theme_setup9() {
		
		if (saveo_exists_cf7()) {
			add_action( 'wp_enqueue_scripts', 								'saveo_cf7_frontend_scripts', 1100 );
			add_filter( 'saveo_filter_merge_styles',						'saveo_cf7_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'saveo_filter_tgmpa_required_plugins',			'saveo_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'saveo_cf7_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('saveo_filter_tgmpa_required_plugins',	'saveo_cf7_tgmpa_required_plugins');
	function saveo_cf7_tgmpa_required_plugins($list=array()) {
		if (in_array('contact-form-7', saveo_storage_get('required_plugins'))) {
			// CF7 plugin
			$list[] = array(
					'name' 		=> esc_html__('Contact Form 7', 'saveo'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
//			// CF7 extension - datepicker
//			$params = array(
//					'name' 		=> esc_html__('Contact Form 7 Datepicker', 'saveo'),
//					'slug' 		=> 'contact-form-7-datepicker',
//					'required' 	=> false
//			);
//			$path = saveo_get_file_dir('plugins/contact-form-7/contact-form-7-datepicker.zip');
//			if ($path != '')
//				$params['source'] = $path;
//			$list[] = $params;
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( !function_exists( 'saveo_exists_cf7' ) ) {
	function saveo_exists_cf7() {
		return class_exists('WPCF7');
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'saveo_cf7_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'saveo_cf7_frontend_scripts', 1100 );
	function saveo_cf7_frontend_scripts() {
		if (saveo_is_on(saveo_get_theme_option('debug_mode')) && saveo_get_file_dir('plugins/contact-form-7/contact-form-7.css')!='')
			wp_enqueue_style( 'saveo-contact-form-7',  saveo_get_file_url('plugins/contact-form-7/contact-form-7.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'saveo_cf7_merge_styles' ) ) {
	//Handler of the add_filter('saveo_filter_merge_styles', 'saveo_cf7_merge_styles');
	function saveo_cf7_merge_styles($list) {
		$list[] = 'plugins/contact-form-7/contact-form-7.css';
		return $list;
	}
}
?>