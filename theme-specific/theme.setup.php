<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0.22
 */

// Theme init priorities:
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
if ( !function_exists('saveo_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'saveo_customizer_theme_setup1', 1 );
	function saveo_customizer_theme_setup1() {
		
		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// For example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		saveo_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Source Sans Pro',
				'family' => 'sans-serif',
				'styles' => '300,400,700'		// Parameter 'style' used only for the Google fonts
				),
            array(
                'name'	 => 'Sanchez',
                'family' => 'serif',
                'styles' => '400,400italic'		// Parameter 'style' used only for the Google fonts
            )

		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		saveo_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		saveo_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'saveo'),
				'description'		=> esc_html__('Font settings of the main text of the site', 'saveo'),
				'font-family'		=> 'Source Sans Pro, sans-serif',
				'font-size' 		=> '16px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '23px',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.02px',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.45em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'saveo'),
				'font-family'		=> 'Sanchez, serif',
				'font-size' 		=> '5em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-2px',
				'margin-top'		=> '3.9rem',
				'margin-bottom'		=> '2.8rem'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'saveo'),
				'font-family'		=> 'Sanchez, serif',
				'font-size' 		=> '3.75em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-1.5px',
				'margin-top'		=> '4.2rem',
				'margin-bottom'		=> '2.5rem'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'saveo'),
				'font-family'		=> 'Sanchez, serif',
				'font-size' 		=> '2.75em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-1.1px',
				'margin-top'		=> '4.6rem',
				'margin-bottom'		=> '1.7rem'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'saveo'),
				'font-family'		=> 'Sanchez, serif',
				'font-size' 		=> '1.5em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.22em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '4.85rem',
				'margin-bottom'		=> '2.35rem'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'saveo'),
				'font-family'		=> 'Sanchez, serif',
				'font-size' 		=> '1em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.3em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '5.1rem',
				'margin-bottom'		=> '1.7rem'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'saveo'),
				'font-family'		=> 'Sanchez, serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.29em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0.35px',
				'margin-top'		=> '5.1rem',
				'margin-bottom'		=> '1.4rem'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'saveo'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'saveo'),
				'font-family'		=> 'Sanchez, serif',
				'font-size' 		=> '1.85em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'saveo'),
				'font-family'		=> 'Sanchez, serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0.4px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'saveo'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'saveo'),
				'font-family'		=> 'Sanchez, serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'saveo'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'saveo'),
				'font-family'		=> 'Source Sans Pro, sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'italic',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.3px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'saveo'),
				'description'		=> esc_html__('Font settings of the main menu items', 'saveo'),
				'font-family'		=> 'Sanchez, serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0.1px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'saveo'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'saveo'),
				'font-family'		=> 'Source Sans Pro, sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		saveo_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> __('Main', 'saveo'),
							'description'	=> __('Colors of the main content area', 'saveo')
							),
			'alter'	=> array(
							'title'			=> __('Alter', 'saveo'),
							'description'	=> __('Colors of the alternative blocks (sidebars, etc.)', 'saveo')
							),
			'extra'	=> array(
							'title'			=> __('Extra', 'saveo'),
							'description'	=> __('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'saveo')
							),
			'inverse' => array(
							'title'			=> __('Inverse', 'saveo'),
							'description'	=> __('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'saveo')
							),
			'input'	=> array(
							'title'			=> __('Input', 'saveo'),
							'description'	=> __('Colors of the form fields (text field, textarea, select, etc.)', 'saveo')
							),
			)
		);
		saveo_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> __('Background color', 'saveo'),
							'description'	=> __('Background color of this block in the normal state', 'saveo')
							),
			'bg_hover'	=> array(
							'title'			=> __('Background hover', 'saveo'),
							'description'	=> __('Background color of this block in the hovered state', 'saveo')
							),
			'bd_color'	=> array(
							'title'			=> __('Border color', 'saveo'),
							'description'	=> __('Border color of this block in the normal state', 'saveo')
							),
			'bd_hover'	=>  array(
							'title'			=> __('Border hover', 'saveo'),
							'description'	=> __('Border color of this block in the hovered state', 'saveo')
							),
			'text'		=> array(
							'title'			=> __('Text', 'saveo'),
							'description'	=> __('Color of the plain text inside this block', 'saveo')
							),
			'text_dark'	=> array(
							'title'			=> __('Text dark', 'saveo'),
							'description'	=> __('Color of the dark text (bold, header, etc.) inside this block', 'saveo')
							),
			'text_light'=> array(
							'title'			=> __('Text light', 'saveo'),
							'description'	=> __('Color of the light text (post meta, etc.) inside this block', 'saveo')
							),
			'text_link'	=> array(
							'title'			=> __('Link', 'saveo'),
							'description'	=> __('Color of the links inside this block', 'saveo')
							),
			'text_hover'=> array(
							'title'			=> __('Link hover', 'saveo'),
							'description'	=> __('Color of the hovered state of links inside this block', 'saveo')
							),
			'text_link2'=> array(
							'title'			=> __('Link 2', 'saveo'),
							'description'	=> __('Color of the accented texts (areas) inside this block', 'saveo')
							),
			'text_hover2'=> array(
							'title'			=> __('Link 2 hover', 'saveo'),
							'description'	=> __('Color of the hovered state of accented texts (areas) inside this block', 'saveo')
							),
			'text_link3'=> array(
							'title'			=> __('Link 3', 'saveo'),
							'description'	=> __('Color of the other accented texts (buttons) inside this block', 'saveo')
							),
			'text_hover3'=> array(
							'title'			=> __('Link 3 hover', 'saveo'),
							'description'	=> __('Color of the hovered state of other accented texts (buttons) inside this block', 'saveo')
							)
			)
		);
		saveo_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'saveo'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff',   //
					'bd_color'			=> '#e0e0e0',   //
		
					// Text and links colors
					'text'				=> '#7f7f7f',   //
					'text_light'		=> '#b3b3b3',   //
					'text_dark'			=> '#435460',   //
					'text_link'			=> '#3174b4',   //  blue
					'text_hover'		=> '#37b6ab',   //  green
					'text_link2'		=> '#e48184',   //
					'text_hover2'		=> '#8be77c',
                    'text_link3'		=> '#46b8c8',   //
                    'text_hover3'		=> '#3dc7a8',   //
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#f5efec',   //
					'alter_bg_hover'	=> '#f8f4f1',   //
					'alter_bd_color'	=> '#ebe9e8',   //
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#333333',
					'alter_light'		=> '#b7b7b7',
					'alter_dark'		=> '#435460',   //
					'alter_link'		=> '#fe7259',
					'alter_hover'		=> '#72cfd5',
					'alter_link2'		=> '#80d572',
					'alter_hover2'		=> '#8be77c',
					'alter_link3'		=> '#ddb837',
					'alter_hover3'		=> '#eec432',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#1e1d22',
					'extra_bg_hover'	=> '#28272e',
					'extra_bd_color'	=> '#313131',
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#bfbfbf',
					'extra_light'		=> '#afafaf',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#72cfd5',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#ededed',   //
					'input_bg_hover'	=> '#fafafa',   //
					'input_bd_color'	=> '#ededed',   //
					'input_bd_hover'	=> '#37b6ab',   //
					'input_text'		=> '#7f7f7f',   //
					'input_light'		=> '#7f7f7f',   //
					'input_dark'		=> '#7f7f7f',   //
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#333333',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'saveo'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#0e0d12',
					'bd_color'			=> '#1c1b1f',
		
					// Text and links colors
					'text'				=> '#ffffff',   //
					'text_light'		=> '#5f5f5f',
					'text_dark'			=> '#ffffff',
					'text_link'			=> '#3174b4',   //
					'text_hover'		=> '#37b6ab',   //
					'text_link2'		=> '#80d572',
					'text_hover2'		=> '#8be77c',
					'text_link3'		=> '#46b8c8',   //
					'text_hover3'		=> '#3dc7a8',   //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#1e1d22',
					'alter_bg_hover'	=> '#28272e',
					'alter_bd_color'	=> '#313131',
					'alter_bd_hover'	=> '#3d3d3d',
					'alter_text'		=> '#a6a6a6',
					'alter_light'		=> '#5f5f5f',
					'alter_dark'		=> '#ffffff',
					'alter_link'		=> '#ffaa5f',
					'alter_hover'		=> '#fe7259',
					'alter_link2'		=> '#80d572',
					'alter_hover2'		=> '#8be77c',
					'alter_link3'		=> '#ddb837',
					'alter_hover3'		=> '#eec432',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#1e1d22',
					'extra_bg_hover'	=> '#28272e',
					'extra_bd_color'	=> '#313131',
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#a6a6a6',
					'extra_light'		=> '#5f5f5f',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#ffaa5f',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#2e2d32',
					'input_bg_hover'	=> '#2e2d32',
					'input_bd_color'	=> '#2e2d32',
					'input_bd_hover'	=> '#353535',
					'input_text'		=> '#b7b7b7',
					'input_light'		=> '#5f5f5f',
					'input_dark'		=> '#ffffff',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#5f5f5f',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			)
		
		));
	}
}

			
// Additional (calculated) theme-specific colors
// Attention! Don't forget setup custom colors also in the theme.customizer.color-scheme.js
if (!function_exists('saveo_customizer_add_theme_colors')) {
	function saveo_customizer_add_theme_colors($colors) {
		if (substr($colors['text'], 0, 1) == '#') {
			$colors['bg_color_0']  = saveo_hex2rgba( $colors['bg_color'], 0 );
			$colors['bg_color_02']  = saveo_hex2rgba( $colors['bg_color'], 0.2 );
            $colors['bg_color_04']  = saveo_hex2rgba( $colors['bg_color'], 0.4 );
            $colors['bg_color_05']  = saveo_hex2rgba( $colors['bg_color'], 0.5 );
			$colors['bg_color_07']  = saveo_hex2rgba( $colors['bg_color'], 0.7 );
			$colors['bg_color_08']  = saveo_hex2rgba( $colors['bg_color'], 0.8 );
			$colors['bg_color_09']  = saveo_hex2rgba( $colors['bg_color'], 0.9 );
			$colors['alter_bg_color_07']  = saveo_hex2rgba( $colors['alter_bg_color'], 0.7 );
			$colors['alter_bg_color_04']  = saveo_hex2rgba( $colors['alter_bg_color'], 0.4 );
			$colors['alter_bg_color_02']  = saveo_hex2rgba( $colors['alter_bg_color'], 0.2 );
			$colors['alter_bd_color_02']  = saveo_hex2rgba( $colors['alter_bd_color'], 0.2 );
			$colors['extra_bg_color_07']  = saveo_hex2rgba( $colors['extra_bg_color'], 0.7 );
			$colors['text_dark_07']  = saveo_hex2rgba( $colors['text_dark'], 0.7 );
            $colors['text_dark_05']  = saveo_hex2rgba( $colors['text_dark'], 0.5 );
			$colors['text_link_02']  = saveo_hex2rgba( $colors['text_link'], 0.2 );
			$colors['text_link_06']  = saveo_hex2rgba( $colors['text_link'], 0.6 );
			$colors['text_link_07']  = saveo_hex2rgba( $colors['text_link'], 0.7 );
			$colors['inverse_link_07']  = saveo_hex2rgba( $colors['inverse_link'], 0.7 );
            $colors['text_hover_08']  = saveo_hex2rgba( $colors['text_hover'], 0.8 );
			$colors['text_link_blend'] = saveo_hsb2hex(saveo_hex2hsb( $colors['text_link'], 2, -5, 5 ));
			$colors['alter_link_blend'] = saveo_hsb2hex(saveo_hex2hsb( $colors['alter_link'], 2, -5, 5 ));
		} else {
			$colors['bg_color_0'] = '{{ data.bg_color_0 }}';
			$colors['bg_color_02'] = '{{ data.bg_color_02 }}';
			$colors['bg_color_07'] = '{{ data.bg_color_07 }}';
			$colors['bg_color_08'] = '{{ data.bg_color_08 }}';
			$colors['bg_color_09'] = '{{ data.bg_color_09 }}';
			$colors['alter_bg_color_07'] = '{{ data.alter_bg_color_07 }}';
			$colors['alter_bg_color_04'] = '{{ data.alter_bg_color_04 }}';
			$colors['alter_bg_color_02'] = '{{ data.alter_bg_color_02 }}';
			$colors['alter_bd_color_02'] = '{{ data.alter_bd_color_02 }}';
			$colors['extra_bg_color_07'] = '{{ data.extra_bg_color_07 }}';
			$colors['text_dark_07'] = '{{ data.text_dark_07 }}';
			$colors['text_link_02'] = '{{ data.text_link_02 }}';
			$colors['text_link_07'] = '{{ data.text_link_07 }}';
			$colors['text_link_blend'] = '{{ data.text_link_blend }}';
			$colors['alter_link_blend'] = '{{ data.alter_link_blend }}';
		}
		return $colors;
	}
}


			
// Additional theme-specific fonts rules
// Attention! Don't forget setup fonts rules also in the theme.customizer.color-scheme.js
if (!function_exists('saveo_customizer_add_theme_fonts')) {
	function saveo_customizer_add_theme_fonts($fonts) {
		$rez = array();	
		foreach ($fonts as $tag => $font) {
			//$rez[$tag] = $font;
			if (substr($font['font-family'], 0, 2) != '{{') {
				$rez[$tag.'_font-family'] 		= !empty($font['font-family']) && !saveo_is_inherit($font['font-family'])
														? 'font-family:' . trim($font['font-family']) . ';' 
														: '';
				$rez[$tag.'_font-size'] 		= !empty($font['font-size']) && !saveo_is_inherit($font['font-size'])
														? 'font-size:' . saveo_prepare_css_value($font['font-size']) . ";"
														: '';
				$rez[$tag.'_line-height'] 		= !empty($font['line-height']) && !saveo_is_inherit($font['line-height'])
														? 'line-height:' . trim($font['line-height']) . ";"
														: '';
				$rez[$tag.'_font-weight'] 		= !empty($font['font-weight']) && !saveo_is_inherit($font['font-weight'])
														? 'font-weight:' . trim($font['font-weight']) . ";"
														: '';
				$rez[$tag.'_font-style'] 		= !empty($font['font-style']) && !saveo_is_inherit($font['font-style'])
														? 'font-style:' . trim($font['font-style']) . ";"
														: '';
				$rez[$tag.'_text-decoration'] 	= !empty($font['text-decoration']) && !saveo_is_inherit($font['text-decoration'])
														? 'text-decoration:' . trim($font['text-decoration']) . ";"
														: '';
				$rez[$tag.'_text-transform'] 	= !empty($font['text-transform']) && !saveo_is_inherit($font['text-transform'])
														? 'text-transform:' . trim($font['text-transform']) . ";"
														: '';
				$rez[$tag.'_letter-spacing'] 	= !empty($font['letter-spacing']) && !saveo_is_inherit($font['letter-spacing'])
														? 'letter-spacing:' . trim($font['letter-spacing']) . ";"
														: '';
				$rez[$tag.'_margin-top'] 		= !empty($font['margin-top']) && !saveo_is_inherit($font['margin-top'])
														? 'margin-top:' . saveo_prepare_css_value($font['margin-top']) . ";"
														: '';
				$rez[$tag.'_margin-bottom'] 	= !empty($font['margin-bottom']) && !saveo_is_inherit($font['margin-bottom'])
														? 'margin-bottom:' . saveo_prepare_css_value($font['margin-bottom']) . ";"
														: '';
			} else {
				$rez[$tag.'_font-family']		= '{{ data["'.$tag.'_font-family"] }}';
				$rez[$tag.'_font-size']			= '{{ data["'.$tag.'_font-size"] }}';
				$rez[$tag.'_line-height']		= '{{ data["'.$tag.'_line-height"] }}';
				$rez[$tag.'_font-weight']		= '{{ data["'.$tag.'_font-weight"] }}';
				$rez[$tag.'_font-style']		= '{{ data["'.$tag.'_font-style"] }}';
				$rez[$tag.'_text-decoration']	= '{{ data["'.$tag.'_text-decoration"] }}';
				$rez[$tag.'_text-transform']	= '{{ data["'.$tag.'_text-transform"] }}';
				$rez[$tag.'_letter-spacing']	= '{{ data["'.$tag.'_letter-spacing"] }}';
				$rez[$tag.'_margin-top']		= '{{ data["'.$tag.'_margin-top"] }}';
				$rez[$tag.'_margin-bottom']		= '{{ data["'.$tag.'_margin-bottom"] }}';
			}
		}
		return $rez;
	}
}


//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------

if ( !function_exists('saveo_customizer_theme_setup') ) {
	add_action( 'after_setup_theme', 'saveo_customizer_theme_setup' );
	function saveo_customizer_theme_setup() {

		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size(370, 0, false);
		
		// Add thumb sizes
		// ATTENTION! If you change list below - check filter's names in the 'trx_addons_filter_get_thumb_size' hook
		$thumb_sizes = apply_filters('saveo_filter_add_thumb_sizes', array(
			'saveo-thumb-huge'		=> array(1170, 658, true),
			'saveo-thumb-big' 		=> array( 1540, 820, true),
			'saveo-thumb-med' 		=> array( 740, 500, true),
                'saveo-thumb-team' 		=> array( 500, 500, true),
			'saveo-thumb-tiny' 		=> array(  90,  90, true),
			'saveo-thumb-masonry-big' => array( 760,   0, false),		// Only downscale, not crop
			'saveo-thumb-masonry'		=> array( 370,   0, false),		// Only downscale, not crop
			)
		);
		$mult = saveo_get_theme_option('retina_ready', 1);
		if ($mult > 1) $GLOBALS['content_width'] = apply_filters( 'saveo_filter_content_width', 1170*$mult);
		foreach ($thumb_sizes as $k=>$v) {
			// Add Original dimensions
			add_image_size( $k, $v[0], $v[1], $v[2]);
			// Add Retina dimensions
			if ($mult > 1) add_image_size( $k.'-@retina', $v[0]*$mult, $v[1]*$mult, $v[2]);
		}

	}
}

if ( !function_exists('saveo_customizer_image_sizes') ) {
	add_filter( 'image_size_names_choose', 'saveo_customizer_image_sizes' );
	function saveo_customizer_image_sizes( $sizes ) {
		$thumb_sizes = apply_filters('saveo_filter_add_thumb_sizes', array(
			'saveo-thumb-huge'		=> esc_html__( 'Fullsize image', 'saveo' ),
			'saveo-thumb-big'			=> esc_html__( 'Large image', 'saveo' ),
			'saveo-thumb-med'			=> esc_html__( 'Medium image', 'saveo' ),
			'saveo-thumb-tiny'		=> esc_html__( 'Small square avatar', 'saveo' ),
			'saveo-thumb-masonry-big'	=> esc_html__( 'Masonry Large (scaled)', 'saveo' ),
			'saveo-thumb-masonry'		=> esc_html__( 'Masonry (scaled)', 'saveo' ),
			)
		);
		$mult = saveo_get_theme_option('retina_ready', 1);
		foreach($thumb_sizes as $k=>$v) {
			$sizes[$k] = $v;
			if ($mult > 1) $sizes[$k.'-@retina'] = $v.' '.esc_html__('@2x', 'saveo' );
		}
		return $sizes;
	}
}

// Remove some thumb-sizes from the ThemeREX Addons list
if ( !function_exists( 'saveo_customizer_trx_addons_add_thumb_sizes' ) ) {
	add_filter( 'trx_addons_filter_add_thumb_sizes', 'saveo_customizer_trx_addons_add_thumb_sizes');
	function saveo_customizer_trx_addons_add_thumb_sizes($list=array()) {
		if (is_array($list)) {
			foreach ($list as $k=>$v) {
				if (in_array($k, array(
								'trx_addons-thumb-huge',
								'trx_addons-thumb-big',
								'trx_addons-thumb-medium',
								'trx_addons-thumb-tiny',
								'trx_addons-thumb-masonry-big',
								'trx_addons-thumb-masonry',
								)
							)
						) unset($list[$k]);
			}
		}
		return $list;
	}
}

// and replace removed styles with theme-specific thumb size
if ( !function_exists( 'saveo_customizer_trx_addons_get_thumb_size' ) ) {
	add_filter( 'trx_addons_filter_get_thumb_size', 'saveo_customizer_trx_addons_get_thumb_size');
	function saveo_customizer_trx_addons_get_thumb_size($thumb_size='') {
		return str_replace(array(
							'trx_addons-thumb-huge',
							'trx_addons-thumb-huge-@retina',
							'trx_addons-thumb-big',
							'trx_addons-thumb-big-@retina',
							'trx_addons-thumb-medium',
							'trx_addons-thumb-medium-@retina',
                'trx_addons-thumb-team',
                'trx_addons-thumb-team-@retina',
							'trx_addons-thumb-tiny',
							'trx_addons-thumb-tiny-@retina',
							'trx_addons-thumb-masonry-big',
							'trx_addons-thumb-masonry-big-@retina',
							'trx_addons-thumb-masonry',
							'trx_addons-thumb-masonry-@retina',
							),
							array(
							'saveo-thumb-huge',
							'saveo-thumb-huge-@retina',
							'saveo-thumb-big',
							'saveo-thumb-big-@retina',
							'saveo-thumb-med',
							'saveo-thumb-med-@retina',
                                'saveo-thumb-team',
                                'saveo-thumb-team-@retina',
							'saveo-thumb-tiny',
							'saveo-thumb-tiny-@retina',
							'saveo-thumb-masonry-big',
							'saveo-thumb-masonry-big-@retina',
							'saveo-thumb-masonry',
							'saveo-thumb-masonry-@retina',
							),
							$thumb_size);
	}
}
?>