<?php
/**
 * Theme customizer
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0
 */



//--------------------------------------------------------------
//-- New panel in the Customizer Controls
//--------------------------------------------------------------

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('saveo_customizer_setup3')) {
	add_action( 'after_setup_theme', 'saveo_customizer_setup3', 3 );
	function saveo_customizer_setup3() {
		saveo_storage_merge_array('options', '', array(
				'cpt' => array(
					"title" => esc_html__('Custom post types', 'saveo'),
					"desc" => '',
					"type" => "panel"
				)
			)
		);
	}
}
// 3 - add/remove Theme Options elements
if (!function_exists('saveo_customizer_setup9999')) {
	add_action( 'after_setup_theme', 'saveo_customizer_setup9999', 9999 );
	function saveo_customizer_setup9999() {
		saveo_storage_merge_array('options', '', array(
				'cpt_end' => array(
					"type" => "panel_end"
				)
			)
		);
	}
}


//--------------------------------------------------------------
//-- Register Customizer Controls
//--------------------------------------------------------------

define('CUSTOMIZE_PRIORITY', 200);		// Start priority for the new controls

if (!function_exists('saveo_customizer_register_controls')) {
	add_action( 'customize_register', 'saveo_customizer_register_controls', 11 );
	function saveo_customizer_register_controls( $wp_customize ) {

		// Setup standard WP Controls
		// ---------------------------------

		// Remove unused sections
		$wp_customize->remove_section( 'colors');
		$wp_customize->remove_section( 'static_front_page');

		// Reorder standard WP sections
		$sec = $wp_customize->get_panel( 'nav_menus' );
		if (is_object($sec)) $sec->priority = 30;
		$sec = $wp_customize->get_panel( 'widgets' );
		if (is_object($sec)) $sec->priority = 40;
		$sec = $wp_customize->get_section( 'title_tagline' );
		if (is_object($sec)) $sec->priority = 50;
		$sec = $wp_customize->get_section( 'background_image' );
		if (is_object($sec)) $sec->priority = 60;
		$sec = $wp_customize->get_section( 'header_image' );
		if (is_object($sec)) $sec->priority = 80;
		$sec = $wp_customize->get_section( 'custom_css' );
		if (is_object($sec)) {
			$sec->title = '* ' . $sec->title;
			$sec->priority = 2000;
		}

		// Modify standard WP controls
		$sec = $wp_customize->get_control( 'blogname' );
		if (is_object($sec))
			$sec->description = esc_html__('Use "[[" and "]]" to modify style and color of parts of the text, "||" to break current line',
				'saveo');
		$sec = $wp_customize->get_setting( 'blogname' );
		if (is_object($sec)) $sec->transport = 'postMessage';

		$sec = $wp_customize->get_setting( 'blogdescription' );
		if (is_object($sec)) $sec->transport = 'postMessage';

		$sec = $wp_customize->get_section( 'background_image' );
		if (is_object($sec)) {
			$sec->title = esc_html__('Background', 'saveo');
			$sec->description = esc_html__('Used only if "Content - Body style" equal to "boxed"', 'saveo');
		}

		// Move standard option 'Background Color' to the section 'Background Image'
		$wp_customize->add_setting( 'background_color', array(
			'default'        => get_theme_support( 'custom-background', 'default-color' ),
			'theme_supports' => 'custom-background',
			'transport'		 => 'postMessage',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
			'sanitize_js_callback' => 'maybe_hash_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
			'label'   => esc_html__( 'Background color', 'saveo' ),
			'section' => 'background_image',
		) ) );


		// Add Theme specific controls
		// ---------------------------------

		$panels = array('');
		$p = 0;
		$sections = array('');
		$s = 0;
		$i = 0;

		// Reload Theme Options before create controls
		if (is_admin()) {
			saveo_storage_set('options_reloaded', true);
			saveo_load_theme_options();
		}
		$options = saveo_storage_get('options');

		foreach ($options as $id=>$opt) {

			$i++;

			if (!empty($opt['hidden'])) continue;

			if ($opt['type'] == 'panel') {

				$sec = $wp_customize->get_panel( $id );
				if ( is_object($sec) && !empty($sec->title) ) {
					$sec->title      = $opt['title'];
					$sec->description= $opt['desc'];
					if ( !empty($opt['priority']) )	$sec->priority = $opt['priority'];
				} else {
					$wp_customize->add_panel( esc_attr($id) , array(
						'title'      => $opt['title'],
						'description'=> $opt['desc'],
						'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i
					) );
				}
				array_push($panels, $id);
				$p++;

			} else if ($opt['type'] == 'panel_end') {

				array_pop($panels);
				$p--;

			} else if ($opt['type'] == 'section') {

				$sec = $wp_customize->get_section( $id );
				if ( is_object($sec) && !empty($sec->title) ) {
					$sec->title      = $opt['title'];
					$sec->description= $opt['desc'];
					if ( !empty($opt['priority']) )	$sec->priority = $opt['priority'];
				} else {
					$wp_customize->add_section( esc_attr($id) , array(
						'title'      => $opt['title'],
						'description'=> $opt['desc'],
						'panel'  => esc_attr($panels[$p]),
						'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i
					) );
				}
				array_push($sections, $id);
				$s++;

			} else if ($opt['type'] == 'section_end') {

				array_pop($sections);
				$s--;

			} else if ($opt['type'] == 'select') {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'type'     => 'select',
					'choices'  => apply_filters('saveo_filter_options_get_list_choises', $opt['options'], $id)
				) );

			} else if ($opt['type'] == 'radio') {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'type'     => 'radio',
					'choices'  => apply_filters('saveo_filter_options_get_list_choises', $opt['options'], $id)
				) );

			} else if ($opt['type'] == 'switch') {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( new SAVEO_Customize_Switch_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'choices'  => apply_filters('saveo_filter_options_get_list_choises', $opt['options'], $id)
				) ) );

			} else if ($opt['type'] == 'checkbox') {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'type'     => 'checkbox'
				) );

			} else if ($opt['type'] == 'color') {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
				) ) );

			} else if ($opt['type'] == 'image') {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
				) ) );

			} else if (in_array($opt['type'], array('media', 'audio', 'video'))) {
				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
				) ) );

			} else if ($opt['type'] == 'icon') {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( new SAVEO_Customize_Icon_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'input_attrs' => array(
						'value' => saveo_get_theme_option($id),
					)
				) ) );

			} else if ($opt['type'] == 'scheme_editor') {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( new SAVEO_Customize_Scheme_Editor_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'input_attrs' => array(
						'value' => saveo_get_theme_option($id),
					)
				) ) );

			} else if ($opt['type'] == 'button') {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_value',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( new SAVEO_Customize_Button_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'input_attrs' => array(
						'caption' => $opt['caption'],
						'action' => $opt['action']
					),
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
				) ) );

			} else if ($opt['type'] == 'info') {

				$wp_customize->add_setting( $id, array(
					'default'           => '',
					'sanitize_callback' => 'saveo_sanitize_value',
					'transport'         => 'postMessage'
				) );

				$wp_customize->add_control( new SAVEO_Customize_Info_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
				) ) );

			} else if ($opt['type'] == 'hidden') {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_html',
					'transport'         => 'postMessage'
				) );

				$wp_customize->add_control( new SAVEO_Customize_Hidden_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
				) ) );

			} else {	// if (in_array($opt['type'], array('text', 'textarea'))) {

				$wp_customize->add_setting( $id, array(
					'default'           => saveo_get_theme_option($id),
					'sanitize_callback' => 'saveo_sanitize_html',
					'transport'         => !isset($opt['refresh']) || $opt['refresh'] ? 'refresh' : 'postMessage'
				) );

				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => !empty($opt['priority']) ? $opt['priority'] : CUSTOMIZE_PRIORITY+$i,
					'type'     => $opt['type']	//'text' | 'textarea'
				) );
			}

		}
	}
}


// Create custom controls for customizer
if (!function_exists('saveo_customizer_custom_controls')) {
	add_action( 'customize_register', 'saveo_customizer_custom_controls' );
	function saveo_customizer_custom_controls( $wp_customize ) {

		class SAVEO_Customize_Info_Control extends WP_Customize_Control {
			public $type = 'info';

			public function render_content() {
				?><label><?php
				if (!empty($this->label)) {
					?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
				}
				if (!empty($this->description)) {
					?><span class="customize-control-description desctiption"><?php saveo_show_layout( $this->description ); ?></span><?php
				}
				?></label><?php
			}
		}

		class SAVEO_Customize_Switch_Control extends WP_Customize_Control {
			public $type = 'switch';

			public function render_content() {
				?><label><?php
				if (!empty($this->label)) {
					?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
				}
				if (!empty($this->description)) {
					?><span class="customize-control-description desctiption"><?php saveo_show_layout( $this->description ); ?></span><?php
				}
				if (is_array($this->choices) && count($this->choices)>0) {
					foreach ($this->choices as $k=>$v) {
						?><label><input type="radio" name="_customize-radio-<?php echo esc_attr($this->id); ?>" <?php
						$this->link();
						?> value="<?php echo esc_attr($k); ?>">
						<?php echo esc_html($v); ?></label><?php
					}
				}
				?></label><?php
			}
		}

		class SAVEO_Customize_Icon_Control extends WP_Customize_Control {
			public $type = 'icon';

			public function render_content() {
				?><label><?php
				if (!empty($this->label)) {
					?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
				}
				if (!empty($this->description)) {
					?><span class="customize-control-description desctiption"><?php saveo_show_layout( $this->description ); ?></span><?php
				}
				?><span class="customize-control-field-wrap"><input type="text" <?php $this->link(); ?> /><?php
				saveo_show_layout(saveo_show_custom_field('_customize-icon-selector-'.esc_attr($this->id),
						array(
							'type'	 => 'icons',
							'button' => true,
							'icons'	 => true
						),
						$this->input_attrs['value']
					)
				);
				?></span></label><?php
			}
		}

		class SAVEO_Customize_Button_Control extends WP_Customize_Control {
			public $type = 'button';

			public function render_content() {
				?><label><?php
				if (!empty($this->label)) {
					?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
				}
				if (!empty($this->description)) {
					?><span class="customize-control-description desctiption"><?php saveo_show_layout( $this->description ); ?></span><?php
				}
				?>
                <input type="button"
                       name="_customize-button-<?php echo esc_attr($this->id); ?>"
                       value="<?php echo esc_attr($this->input_attrs['caption']); ?>"
                       data-action="<?php echo esc_attr($this->input_attrs['action']); ?>">
                </label>
				<?php
			}
		}

		class SAVEO_Customize_Hidden_Control extends WP_Customize_Control {
			public $type = 'info';

			public function render_content() {
				?><input type="hidden" name="_customize-hidden-<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?> value=""><?php
			}
		}

		class SAVEO_Customize_Scheme_Editor_Control extends WP_Customize_Control {
			public $type = 'scheme_editor';

			public function render_content() {
				?><label><?php
				if (!empty($this->label)) {
					?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php
				}
				if (!empty($this->description)) {
					?><span class="customize-control-description desctiption"><?php saveo_show_layout( $this->description ); ?></span><?php
				}
				?><span class="customize-control-field-wrap"><input type="hidden" <?php $this->link(); ?> /><?php
				saveo_show_layout(saveo_show_custom_field('_customize-scheme-editor-'.esc_attr($this->id),
						array('type' => 'scheme_editor'),
						saveo_unserialize($this->input_attrs['value'])
					)
				);
				?></span></label><?php
			}
		}

	}
}


// Sanitize plain value
if (!function_exists('saveo_sanitize_value')) {
	function saveo_sanitize_value($value) {
		return empty($value) ? $value : trim(strip_tags($value));
	}
}


// Sanitize html value
if (!function_exists('saveo_sanitize_html')) {
	function saveo_sanitize_html($value) {
		return empty($value) ? $value : wp_kses_post($value);
	}
}


//--------------------------------------------------------------
// Save custom settings in CSS file
//--------------------------------------------------------------

// Save CSS with custom colors and fonts after save custom options
if (!function_exists('saveo_customizer_action_save_after')) {
	add_action('customize_save_after', 'saveo_customizer_action_save_after');
	function saveo_customizer_action_save_after($api=false) {

		// Get saved settings
		$settings = $api->settings();

		// Store new schemes colors
		$schemes = saveo_unserialize($settings['scheme_storage']->value());
		if (is_array($schemes) && count($schemes) > 0)
			saveo_storage_set('schemes', $schemes);

		// Store new fonts parameters
		$fonts = saveo_get_theme_fonts();
		foreach ($fonts as $tag=>$v) {
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$fonts[$tag][$css_prop] = $settings["{$tag}_{$css_prop}"]->value();
			}
		}
		saveo_storage_set('theme_fonts', $fonts);

		// Regenerate CSS with new colors
		saveo_customizer_save_css();
	}
}

// Save CSS with custom colors and fonts after switch theme
if (!function_exists('saveo_customizer_action_switch_theme')) {
	add_action('after_switch_theme', 'saveo_customizer_action_switch_theme');
	function saveo_customizer_action_switch_theme() {
		// Remove condition if you want regenerate css after switch to this theme
		if (false) saveo_customizer_save_css();
	}
}

// Save CSS with custom colors and fonts into custom.css
if (!function_exists('saveo_customizer_save_css')) {
	add_action('trx_addons_action_save_options', 'saveo_customizer_save_css');
	function saveo_customizer_save_css() {
		$msg = 	'/* ' . esc_html__("ATTENTION! This file was generated automatically! Don't change it!!!", 'saveo')
		          . "\n----------------------------------------------------------------------- */\n";

		// Save CSS with custom colors and fonts into custom.css
		$css = saveo_customizer_get_css();
		$file = saveo_get_file_dir('css/__colors.css');
		if (file_exists($file)) saveo_fpc($file, $msg . $css );

		// Merge stylesheets
		$list = apply_filters( 'saveo_filter_merge_styles', array() );
		$css = '';
		foreach ($list as $f) {
			$css .= saveo_fgc(saveo_get_file_dir($f));
		}
		if ( $css != '') {
			saveo_fpc( saveo_get_file_dir('css/__styles.css'), $msg . apply_filters( 'saveo_filter_prepare_css', $css, true ) );
		}

		// Merge scripts
		$list = apply_filters( 'saveo_filter_merge_scripts', array(
				'js/skip-link-focus.js',
				'js/bideo.js',
				'js/jquery.tubular.js',
				'js/_utils.js',
				'js/_init.js'
			)
		);
		$js = '';
		foreach ($list as $f) {
			$js .= saveo_fgc(saveo_get_file_dir($f));
		}
		if ( $js != '') {
			saveo_fpc( saveo_get_file_dir('js/__scripts.js'), $msg . apply_filters( 'saveo_filter_prepare_js', $js, true ) );
		}
	}
}


//--------------------------------------------------------------
// Border radius settings
//--------------------------------------------------------------

// Return current theme-specific border radius for form's fields and buttons
if ( !function_exists( 'saveo_get_border_radius' ) ) {
	function saveo_get_border_radius() {
		$rad = str_replace(' ', '', saveo_get_theme_option('border_radius'));
		if (empty($rad)) $rad = 0;
		return saveo_prepare_css_value($rad);
	}
}


//--------------------------------------------------------------
// Color schemes manipulations
//--------------------------------------------------------------

// Load saved values into color schemes
if (!function_exists('saveo_load_schemes')) {
	add_action('saveo_action_load_options', 'saveo_load_schemes');
	function saveo_load_schemes() {
		$schemes = saveo_storage_get('schemes');
		$storage = saveo_unserialize(saveo_get_theme_option('scheme_storage'));
		if (is_array($storage) && count($storage) > 0)  {
			foreach ($storage as $k=>$v) {
				if (isset($schemes[$k])) {
					$schemes[$k] = $v;
				}
			}
			saveo_storage_set('schemes', $schemes);
		}
	}
}

// Return specified color from current (or specified) color scheme
if ( !function_exists( 'saveo_get_scheme_color' ) ) {
	function saveo_get_scheme_color($color_name, $scheme = '') {
		if (empty($scheme)) $scheme = saveo_get_theme_option( 'color_scheme' );
		if (empty($scheme) || saveo_storage_empty('schemes', $scheme)) $scheme = 'default';
		$colors = saveo_storage_get_array('schemes', $scheme, 'colors');
		return $colors[$color_name];
	}
}

// Return colors from current color scheme
if ( !function_exists( 'saveo_get_scheme_colors' ) ) {
	function saveo_get_scheme_colors($scheme = '') {
		if (empty($scheme)) $scheme = saveo_get_theme_option( 'color_scheme' );
		if (empty($scheme) || saveo_storage_empty('schemes', $scheme)) $scheme = 'default';
		return saveo_storage_get_array('schemes', $scheme, 'colors');
	}
}

// Return colors from all schemes
if ( !function_exists( 'saveo_get_scheme_storage' ) ) {
	function saveo_get_scheme_storage($scheme = '') {
		return serialize(saveo_storage_get('schemes'));
	}
}


// Return schemes list
if ( !function_exists( 'saveo_get_list_schemes' ) ) {
	function saveo_get_list_schemes($prepend_inherit=false) {
		$list = array();
		$schemes = saveo_storage_get('schemes');
		if (is_array($schemes) && count($schemes) > 0) {
			foreach ($schemes as $slug => $scheme) {
				$list[$slug] = $scheme['title'];
			}
		}
		return $prepend_inherit ? saveo_array_merge(array('inherit' => esc_html__("Inherit", 'saveo')), $list) : $list;
	}
}


//--------------------------------------------------------------
// Theme fonts
//--------------------------------------------------------------

// Load saved values into fonts list
if (!function_exists('saveo_load_fonts')) {
	add_action('saveo_action_load_options', 'saveo_load_fonts');
	function saveo_load_fonts() {
		// Fonts to load when theme starts
		$fonts = array();
		for ($i=1; $i<=saveo_get_theme_setting('max_load_fonts'); $i++) {
			if (($name = saveo_get_theme_option("load_fonts-{$i}-name")) != '') {
				$fonts[] = array(
					'name'	 => $name,
					'family' => saveo_get_theme_option("load_fonts-{$i}-family"),
					'styles' => saveo_get_theme_option("load_fonts-{$i}-styles")
				);
			}
		}
		saveo_storage_set('load_fonts', $fonts);
		saveo_storage_set('load_fonts_subset', saveo_get_theme_option("load_fonts_subset"));

		// Font parameters of the main theme's elements
		$fonts = saveo_get_theme_fonts();
		foreach ($fonts as $tag=>$v) {
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$fonts[$tag][$css_prop] = saveo_get_theme_option("{$tag}_{$css_prop}");
			}
		}
		saveo_storage_set('theme_fonts', $fonts);
	}
}

// Return slug of the loaded font
if (!function_exists('saveo_get_load_fonts_slug')) {
	function saveo_get_load_fonts_slug($name) {
		return str_replace(' ', '-', $name);
	}
}

// Return load fonts parameter's default value
if (!function_exists('saveo_get_load_fonts_option')) {
	function saveo_get_load_fonts_option($option_name) {
		$rez = '';
		$parts = explode('-', $option_name);
		$load_fonts = saveo_storage_get('load_fonts');
		if ($parts[0] == 'load_fonts' && count($load_fonts) > $parts[1]-1 && isset($load_fonts[$parts[1]-1][$parts[2]])) {
			$rez = $load_fonts[$parts[1]-1][$parts[2]];
		}
		return $rez;
	}
}

// Return load fonts subset's default value
if (!function_exists('saveo_get_load_fonts_subset')) {
	function saveo_get_load_fonts_subset($option_name) {
		return saveo_storage_get('load_fonts_subset');
	}
}

// Return load fonts list
if (!function_exists('saveo_get_list_load_fonts')) {
	function saveo_get_list_load_fonts($prepend_inherit=false) {
		$list = array();
		$load_fonts = saveo_storage_get('load_fonts');
		if (is_array($load_fonts) && count($load_fonts) > 0) {
			foreach ($load_fonts as $font) {
				$list[sprintf('%s%s',
					strpos($font['name'], ' ')!==false ? sprintf('"%s"', $font['name']) : $font['name'],
					!empty($font['family']) ? ', '.trim($font['family']): '')] = $font['name'];
			}
		}
		return $prepend_inherit ? saveo_array_merge(array('inherit' => esc_html__("Inherit", 'saveo')), $list) : $list;
	}
}

// Return font settings of the theme specific elements
if ( !function_exists( 'saveo_get_theme_fonts' ) ) {
	function saveo_get_theme_fonts() {
		return saveo_storage_get('theme_fonts');
	}
}

// Return theme fonts parameter's default value
if (!function_exists('saveo_get_theme_fonts_option')) {
	function saveo_get_theme_fonts_option($option_name) {
		$rez = '';
		$parts = explode('_', $option_name);
		$theme_fonts = saveo_storage_get('theme_fonts');
		if (!empty($theme_fonts[$parts[0]][$parts[1]])) {
			$rez = $theme_fonts[$parts[0]][$parts[1]];
		}
		// For the font-families update options list also
		if ($parts[1] == 'font-family') {
			saveo_storage_set_array2('options', $option_name, 'options', saveo_get_list_load_fonts(true));
		}
		return $rez;
	}
}


//--------------------------------------------------------------
// Customizer JS and CSS
//--------------------------------------------------------------

// Binds JS listener to make Customizer color_scheme control.
// Passes color scheme data as colorScheme global.
if ( !function_exists( 'saveo_customizer_control_js' ) ) {
	add_action( 'customize_controls_enqueue_scripts', 'saveo_customizer_control_js' );
	function saveo_customizer_control_js() {
		wp_enqueue_style( 'saveo-customizer', saveo_get_file_url('theme-options/theme.customizer.css') );
		wp_enqueue_script( 'saveo-customizer-color-scheme-control',
			saveo_get_file_url('theme-options/theme.customizer.color-scheme.js'),
			array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), null, true );
		wp_localize_script( 'saveo-customizer-color-scheme-control', 'saveo_color_schemes', saveo_storage_get('schemes') );
		wp_localize_script( 'saveo-customizer-color-scheme-control', 'saveo_theme_fonts', saveo_storage_get('theme_fonts') );
		wp_localize_script( 'saveo-customizer-color-scheme-control', 'saveo_customizer_vars', array(
			'max_load_fonts' => saveo_get_theme_setting('max_load_fonts'),
			'msg_refresh' => esc_html__('Refresh', 'saveo'),
			'msg_reset' => esc_html__('Reset', 'saveo'),
			'msg_reset_confirm' => esc_html__('Are you sure you want to reset all Theme Options?', 'saveo'),
		) );
		wp_localize_script( 'saveo-customizer-color-scheme-control', 'saveo_dependencies', saveo_get_theme_dependencies() );
	}
}

// Binds JS handlers to make the Customizer preview reload changes asynchronously.
if ( !function_exists( 'saveo_customizer_preview_js' ) ) {
	add_action( 'customize_preview_init', 'saveo_customizer_preview_js' );
	function saveo_customizer_preview_js() {
		wp_enqueue_script( 'saveo-customize-preview',
			saveo_get_file_url('theme-options/theme.customizer.preview.js'),
			array( 'customize-preview' ), null, true );
	}
}

// Output an Underscore template for generating CSS for the color scheme.
// The template generates the css dynamically for instant display in the Customizer preview.
if ( !function_exists( 'saveo_customizer_css_template' ) ) {
	add_action( 'customize_controls_print_footer_scripts', 'saveo_customizer_css_template' );
	function saveo_customizer_css_template() {
		$colors = array();
		foreach (saveo_get_scheme_colors() as $k=>$v)
			$colors[$k] = '{{ data.'.esc_attr($k).' }}';

		$tmpl_holder = 'script';

		$schemes = array_keys(saveo_get_list_schemes());
		if (count($schemes) > 0) {
			foreach ($schemes as $scheme) {
				echo '<' . esc_html($tmpl_holder) . ' type="text/html" id="tmpl-saveo-color-scheme-'.esc_attr($scheme).'">'
				     . saveo_customizer_get_css( $colors, false, false, $scheme )
				     . '</' . esc_html($tmpl_holder) . '>';
			}
		}


		// Fonts
		$fonts = saveo_get_theme_fonts();
		if (is_array($fonts) && count($fonts) > 0) {
			foreach ($fonts as $tag => $font) {
				$fonts[$tag]['font-family']		= '{{ data["'.$tag.'"]["font-family"] }}';
				$fonts[$tag]['font-size']		= '{{ data["'.$tag.'"]["font-size"] }}';
				$fonts[$tag]['line-height']		= '{{ data["'.$tag.'"]["line-height"] }}';
				$fonts[$tag]['font-weight']		= '{{ data["'.$tag.'"]["font-weight"] }}';
				$fonts[$tag]['font-style']		= '{{ data["'.$tag.'"]["font-style"] }}';
				$fonts[$tag]['text-decoration']	= '{{ data["'.$tag.'"]["text-decoration"] }}';
				$fonts[$tag]['text-transform']	= '{{ data["'.$tag.'"]["text-transform"] }}';
				$fonts[$tag]['letter-spacing']	= '{{ data["'.$tag.'"]["letter-spacing"] }}';
				$fonts[$tag]['margin-top']		= '{{ data["'.$tag.'"]["margin-top"] }}';
				$fonts[$tag]['margin-bottom']	= '{{ data["'.$tag.'"]["margin-bottom"] }}';
			}
			echo '<'.trim($tmpl_holder).' type="text/html" id="tmpl-saveo-fonts">'
			     . trim(saveo_customizer_get_css( false, $fonts, false, false ))
			     . '</'.trim($tmpl_holder).'>';
		}

	}
}


// Add scheme name in each selector in the CSS (priority 100 - after complete css)
if (!function_exists('saveo_customizer_add_scheme_in_css')) {
	add_action( 'saveo_filter_get_css', 'saveo_customizer_add_scheme_in_css', 100, 4 );
	function saveo_customizer_add_scheme_in_css($css, $colors, $fonts, $scheme) {
		if ($colors && !empty($css['colors'])) {
			$rez = '';
			$in_comment = $in_rule = false;
			$allow = true;
			$scheme_class = sprintf('.scheme_%s ', $scheme);
			$self_class = '.scheme_self';
			$self_class_len = strlen($self_class);
			$css_str = str_replace(array('{{', '}}'), array('[[',']]'), $css['colors']);
			for ($i=0; $i<strlen($css_str); $i++) {
				$ch = $css_str[$i];
				if ($in_comment) {
					$rez .= $ch;
					if ($ch=='/' && $css_str[$i-1]=='*') {
						$in_comment = false;
						$allow = !$in_rule;
					}
				} else if ($in_rule) {
					$rez .= $ch;
					if ($ch=='}') {
						$in_rule = false;
						$allow = !$in_comment;
					}
				} else {
					if ($ch=='/' && $css_str[$i+1]=='*') {
						$rez .= $ch;
						$in_comment = true;
					} else if ($ch=='{') {
						$rez .= $ch;
						$in_rule = true;
					} else if ($ch==',') {
						$rez .= $ch;
						$allow = true;
					} else if (strpos(" \t\r\n", $ch)===false) {
						if ($allow) {
							$pos_comma = strpos($css_str, ',', $i+1);
							$pos_bracket = strpos($css_str, '{', $i+1);
							$pos = $pos_comma === false
								? $pos_bracket
								: ($pos_bracket === false
									? $pos_comma
									: min($pos_comma, $pos_bracket)
								);
							$selector = $pos > 0 ? substr($css_str, $i, $pos-$i) : '';
							if (strpos($selector, $self_class) !== false) {
								$rez .= str_replace($self_class, trim($scheme_class), $selector);
								$i += strlen($selector) - 1;
							} else {
								$rez .= $scheme_class . trim($ch);
							}
							$allow = false;
						} else
							$rez .= $ch;
					} else {
						$rez .= $ch;
					}
				}
			}
			$rez = str_replace(array('[[',']]'), array('{{', '}}'), $rez);
			$css['colors'] = $rez;
		}
		return $css;
	}
}




// -----------------------------------------------------------------
// -- Page Options section
// -----------------------------------------------------------------

if ( !function_exists('saveo_init_override') ) {
	add_action( 'after_setup_theme', 'saveo_init_override' );
	function saveo_init_override() {
		if ( is_admin() ) {
			add_action('admin_enqueue_scripts',	'saveo_add_override_scripts');
			add_action('save_post',				'saveo_options_override_save_options');
			//add_action('add_meta_boxes',		'saveo_add_override');
			add_filter( 'saveo_filter_override_options', 'saveo_options_override_add_options' );
		}
	}
}

// Check if meta box is allow
if (!function_exists('saveo_options_allow_override')) {
	function saveo_options_allow_override($post_type) {
		return apply_filters('saveo_filter_allow_override', in_array($post_type, array('page', 'post')), $post_type);
	}
}

// Load required styles and scripts for admin mode
if ( !function_exists( 'saveo_add_override_scripts' ) ) {
	//Handler of the add_action("admin_enqueue_scripts", 'saveo_add_override_scripts');
	function saveo_add_override_scripts() {
		// If current screen is 'Edit Page' - load font icons
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && saveo_options_allow_override(!empty($screen->post_type) ? $screen->post_type : $screen->id)) {
			wp_enqueue_style( 'saveo-fontello',  saveo_get_file_url('css/fontello/fontello-embedded.css') );
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui'), null, true);
			wp_enqueue_script( 'saveo-meta-box', saveo_get_file_url('theme-options/theme.meta-box.js'), array('jquery'), null, true );
			wp_localize_script( 'saveo-meta-box', 'saveo_dependencies', saveo_get_theme_dependencies() );
		}
	}
}




// Add overriden options
if (!function_exists('saveo_options_override_add_options')) {
	add_filter('saveo_filter_override_options', 'saveo_options_override_add_options');
	function saveo_options_override_add_options($list) {
		global $post_type;
		if (saveo_options_allow_override($post_type)) {
			$list[] = array(sprintf('saveo_override_options_%s', $post_type),
				esc_html__('Theme Options', 'saveo'),
				'saveo_options_override_show',
				$post_type,
				$post_type == 'post' ? 'side' : 'advanced',
				'default'
			);
		}
		return $list;
	}
}

// Callback function to show fields in meta box
if (!function_exists('saveo_options_override_show')) {
	function saveo_options_override_show() {
		global $post, $post_type;
		if (saveo_options_allow_override($post_type)) {
			// Load saved options 
			$meta = get_post_meta($post->ID, 'saveo_options', true);
			$tabs_titles = $tabs_content = array();
			global $SAVEO_STORAGE;
			// Refresh linked data if this field is controller for the another (linked) field
			// Do this before show fields to refresh data in the $SAVEO_STORAGE
			foreach ($SAVEO_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
				if (!empty($v['linked'])) {
					$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
					if (!empty($v['val']) && !saveo_is_inherit($v['val']))
						saveo_refresh_linked_data($v['val'], $v['linked']);
				}
			}
			// Show fields
			foreach ($SAVEO_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
				if (empty($v['override']['section']))
					$v['override']['section'] = esc_html__('General', 'saveo');
				if (!isset($tabs_titles[$v['override']['section']])) {
					$tabs_titles[$v['override']['section']] = $v['override']['section'];
					$tabs_content[$v['override']['section']] = '';
				}
				$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
				$tabs_content[$v['override']['section']] .= saveo_show_meta_box_field($k, $v);
			}
			if (count($tabs_titles) > 0) {
				?>
                <div class="saveo_meta_box">
                    <input type="hidden" name="meta_box_post_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
                    <input type="hidden" name="meta_box_post_type" value="<?php echo esc_attr($post_type); ?>" />
                    <div id="saveo_meta_box_tabs">
                        <ul><?php
							$cnt = 0;
							foreach ($tabs_titles as $k=>$v) {
								$cnt++;
								?><li><a href="#saveo_meta_box_<?php echo esc_attr($cnt); ?>"><?php echo esc_html($v); ?></a></li><?php
							}
							?></ul>
						<?php
						$cnt = 0;
						foreach ($tabs_content as $k=>$v) {
							$cnt++;
							?>
                            <div id="saveo_meta_box_<?php echo esc_attr($cnt); ?>" class="saveo_meta_box_section">
								<?php saveo_show_layout($v); ?>
                            </div>
							<?php
						}
						?>
                    </div>
                </div>
				<?php
			}
		}
	}
}

// Display single option's field
if ( !function_exists('saveo_show_meta_box_field') ) {
	function saveo_show_meta_box_field($name, $field) {

		if ($field['type'] == 'hidden') return '';

		$inherit_state = saveo_is_inherit($field['val']);
		$output = '<div class="saveo_meta_box_item saveo_meta_box_item_'.esc_attr($field['type'])
		          . ' saveo_meta_box_inherit_'.($inherit_state ? 'on' : 'off' )
		          . '">'
		          . '<h4 class="saveo_meta_box_item_title">'
		          . esc_html($field['title'])
		          . '<span class="saveo_meta_box_inherit_lock" id="saveo_meta_box_inherit_'.esc_attr($name).'"></span>'
		          . '</h4>'
		          . '<div class="saveo_meta_box_item_data">'
		          . '<div class="saveo_meta_box_item_field" data-param="'.esc_attr($name).'"'
		          . (!empty($field['linked']) ? ' data-linked="'.esc_attr($field['linked']).'"' : '')
		          . '>';

		// Type 'checkbox'
		if ($field['type']=='checkbox') {
			$output .= '<label class="saveo_meta_box_item_label">'
			           . '<input type="checkbox" name="saveo_meta_box_field_'.esc_attr($name).'" value="1"'
			           .($field['val']==1 ? ' checked="checked"' : '')
			           .' />'
			           . esc_html($field['title'])
			           . '</label>';

			// Type 'switch' (2 choises) or 'radio' (3+ choises)
		} else if (in_array($field['type'], array('switch', 'radio'))) {
			$field['options'] = apply_filters('saveo_filter_options_get_list_choises', $field['options'], $name);
			foreach ($field['options'] as $k=>$v) {
				$output .= '<label class="saveo_meta_box_item_label">'
				           . '<input type="radio" name="saveo_meta_box_field_'.esc_attr($name).'"'
				           . ' value="'.esc_attr($k).'"'.($field['val']==$k ? ' checked="checked"' : '')
				           . ' />'
				           . esc_html($v)
				           . '</label>';
			}

			// Type 'text' or 'time' or 'date'
		} else if (in_array($field['type'], array('text', 'time', 'date'))) {
			$output .= '<input type="text" name="saveo_meta_box_field_'.esc_attr($name).'"'
			           . ' value="'.esc_attr(saveo_is_inherit($field['val']) ? '' : $field['val']).'"'
			           . ' />';

			// Type 'textarea'
		} else if ($field['type']=='textarea') {
			$output .= '<textarea name="saveo_meta_box_field_'.esc_attr($name).'">'
			           . esc_html(saveo_is_inherit($field['val']) ? '' : $field['val'])
			           . '</textarea>';

			// Type 'select'
		} else if ($field['type']=='select') {
			$field['options'] = apply_filters('saveo_filter_options_get_list_choises', $field['options'], $name);
			$output .= '<select size="1" name="saveo_meta_box_field_'.esc_attr($name).'">';
			foreach ($field['options'] as $k=>$v) {
				$output .= '<option value="'.esc_attr($k).'"'.($field['val']==$k ? ' selected="selected"' : '').'>'.esc_html($v).'</option>';
			}
			$output .= '</select>';

			// Type 'image', 'media', 'video' or 'audio'
		} else if (in_array($field['type'], array('image', 'media', 'video', 'audio'))) {
			$output .= (!empty($field['multiple'])
					? '<input type="hidden" id="saveo_meta_box_field_'.esc_attr($name).'"'
					  . ' name="saveo_meta_box_field_'.esc_attr($name).'"'
					  . ' value="'.esc_attr(saveo_is_inherit($field['val']) ? '' : $field['val']).'"'
					  . ' />'
					: '<input type="text" id="saveo_meta_box_field_'.esc_attr($name).'"'
					  . ' name="saveo_meta_box_field_'.esc_attr($name).'"'
					  . ' value="'.esc_attr(saveo_is_inherit($field['val']) ? '' : $field['val']).'"'
					  . ' />')
			           . saveo_show_custom_field('saveo_meta_box_field_'.esc_attr($name).'_button',
					array(
						'type'			 => 'mediamanager',
						'multiple'		 => !empty($field['multiple']),
						'data_type'		 => $field['type'],
						'linked_field_id'=> 'saveo_meta_box_field_'.esc_attr($name)
					),
					saveo_is_inherit($field['val']) ? '' : $field['val']);

			// Type 'icon'
		} else if ($field['type']=='icon') {
			$output .= '<input type="text" id="saveo_meta_box_field_'.esc_attr($name).'"'
			           . ' name="saveo_meta_box_field_'.esc_attr($name).'"'
			           . ' value="'.esc_attr(saveo_is_inherit($field['val']) ? '' : $field['val']).'"'
			           . ' />'
			           . saveo_show_custom_field('saveo_meta_box_field_'.esc_attr($name).'_button',
					array(
						'type'	 => 'icons',
						'button' => true,
						'icons'	 => true
					),
					$field['val']);
		}

		$output .= '<div class="saveo_meta_box_inherit_cover'.(!$inherit_state ? ' saveo_hidden' : '').'">'
		           . '<span class="saveo_meta_box_inherit_label">' . esc_html__('Inherit', 'saveo') . '</span>'
		           . '<input type="hidden" name="saveo_meta_box_inherit_'.esc_attr($name).'"'
		           . ' value="'.esc_attr($inherit_state ? 'inherit' : '').'"'
		           . ' />'
		           . '</div>'
		           . '</div>'
		           . '<div class="saveo_meta_box_item_description">'
		           . (!empty($field['override']['desc']) 	// param 'desc' already processed with wp_kses()!
				? $field['override']['desc']
				: $field['desc'])
		           . '</div>'
		           . '</div>'
		           . '</div>';
		return $output;
	}
}

// Save data from meta box
if (!function_exists('saveo_options_override_save_options')) {
	//Handler of the add_action('save_post', 'saveo_options_override_save_options');
	function saveo_options_override_save_options($post_id) {

		// verify nonce
		if ( !wp_verify_nonce( saveo_get_value_gp('meta_box_post_nonce'), admin_url() ) )
			return $post_id;

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		$post_type = isset($_POST['override_post_type']) ? $_POST['override_post_type'] : $_POST['post_type'];

		// check permissions
		$capability = 'page';
		$post_types = get_post_types( array( 'name' => $post_type), 'objects' );
		if (!empty($post_types) && is_array($post_types)) {
			foreach ($post_types  as $type) {
				$capability = $type->capability_type;
				break;
			}
		}
		if (!current_user_can('edit_'.($capability), $post_id)) {
			return $post_id;
		}

		// Save meta
		$meta = array();
		$options = saveo_storage_get('options');
		foreach ($options as $k=>$v) {
			// Skip not overriden options
			if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
			// Skip inherited options
			if (!empty($_POST['saveo_options_inherit_' . $k])) continue;
			// Get option value from POST
			$meta[$k] = isset($_POST['saveo_options_field_' . $k])
				? $_POST['saveo_options_field_' . $k]
				: ($v['type']=='checkbox' ? 0 : '');
		}
		update_post_meta($post_id, 'saveo_options', $meta);

		// Save separate meta options to search template pages
		if ($post_type=='page' && !empty($_POST['page_template']) && $_POST['page_template']=='blog.php') {
			update_post_meta($post_id, 'saveo_options_post_type', isset($meta['post_type']) ? $meta['post_type'] : 'post');
			update_post_meta($post_id, 'saveo_options_parent_cat', isset($meta['parent_cat']) ? $meta['parent_cat'] : 0);
		}
	}
}

// Refresh data in the linked field
// according the main field value
if (!function_exists('saveo_refresh_linked_data')) {
	function saveo_refresh_linked_data($value, $linked_name) {
		if ($linked_name == 'parent_cat') {
			$tax = saveo_get_post_type_taxonomy($value);
			$terms = !empty($tax) ? saveo_get_list_terms(false, $tax) : array();
			$terms = saveo_array_merge(array(0 => esc_html__('- Select category -', 'saveo')), $terms);
			saveo_storage_set_array2('options', $linked_name, 'options', $terms);
		}
	}
}

// AJAX: Refresh data in the linked fields
if (!function_exists('saveo_callback_get_linked_data')) {
	add_action('wp_ajax_saveo_get_linked_data', 		'saveo_callback_get_linked_data');
	add_action('wp_ajax_nopriv_saveo_get_linked_data','saveo_callback_get_linked_data');
	function saveo_callback_get_linked_data() {
		if ( !wp_verify_nonce( saveo_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
		$chg_name = $_REQUEST['chg_name'];
		$chg_value = $_REQUEST['chg_value'];
		$response = array('error' => '');
		if ($chg_name == 'post_type') {
			$tax = saveo_get_post_type_taxonomy($chg_value);
			$terms = !empty($tax) ? saveo_get_list_terms(false, $tax) : array();
			$response['list'] = saveo_array_merge(array(0 => esc_html__('- Select category -', 'saveo')), $terms);
		}
		echo json_encode($response);
		die();
	}
}

// Show theme specific fields in the meta box
function saveo_show_custom_field($id, $field, $value) {
	$output = '';
	switch ($field['type']) {

		case 'mediamanager':
			wp_enqueue_media( );
			$title = empty($field['data_type']) || $field['data_type']=='image'
				? esc_html__( 'Choose Image', 'saveo')
				: esc_html__( 'Choose Media', 'saveo');
			$output .= '<a id="'.esc_attr($id).'"'
			           . ' class="button mediamanager saveo_media_selector"'
			           . '	data-param="' . esc_attr($id) . '"'
			           . '	data-choose="'.esc_attr(!empty($field['multiple']) ? esc_html__( 'Choose Images', 'saveo') : $title).'"'
			           . ' data-update="'.esc_attr(!empty($field['multiple']) ? esc_html__( 'Add to Gallery', 'saveo') : $title).'"'
			           . '	data-multiple="'.esc_attr(!empty($field['multiple']) ? '1' : '0').'"'
			           . '	data-type="'.esc_attr(!empty($field['data_type']) ? $field['data_type'] : 'image').'"'
			           . '	data-linked-field="'.esc_attr($field['linked_field_id']).'"'
			           . '>'
			           . (!empty($field['multiple'])
					? (empty($field['data_type']) || $field['data_type']=='image'
						? esc_html__( 'Add Images', 'saveo')
						: esc_html__( 'Add Files', 'saveo')
					)
					: esc_html($title)
			           )
			           . '</a>';
			$output .= '<span class="saveo_meta_box_field_preview">';
			$images = explode('|', $value);
			if (is_array($images)) {
				foreach ($images as $img)
					$output .= $img && !saveo_is_inherit($img)
						? '<span>'
						  . (in_array(saveo_get_file_ext($img), array('gif', 'jpg', 'jpeg', 'png'))
							? '<img src="' . esc_url($img) . '" >'
							: '<a href="' . esc_attr($img) . '">' . esc_html(basename($img)) . '</a>'
						  )
						  . '</span>'
						: '';
			}
			$output .= '</span>';
			break;

		case 'icons':
			$icons_type = !empty($field['style'])
				? $field['style']
				: saveo_get_theme_setting('icons_type');
			if (empty($field['return']))
				$field['return'] = 'full';
			$saveo_icons = $icons_type=='images'
				? saveo_get_list_images()
				: saveo_array_from_list(saveo_get_list_icons());
			if (is_array($saveo_icons)) {
				if (!empty($field['button']))
					$output .= '<span id="'.esc_attr($id).'"'
					           . ' class="saveo_list_icons_selector'
					           . ($icons_type=='icons' && !empty($value) ? ' '.esc_attr($value) : '')
					           .'"'
					           . ' title="'.esc_attr__('Select icon', 'saveo').'"'
					           . ' data-style="'.($icons_type=='images' ? 'images' : 'icons').'"'
					           . ($icons_type=='images' && !empty($value)
							? ' style="background-image: url('.esc_url($field['return']=='slug'
								? $saveo_icons[$value]
								: $value).');"'
							: '')
					           . '></span>';
				if (!empty($field['icons'])) {
					$output .= '<div class="saveo_list_icons">';
					foreach($saveo_icons as $slug=>$icon) {
						$output .= '<span class="'.esc_attr($icons_type=='icons' ? $icon : $slug)
						           . (($field['return']=='full' ? $icon : $slug) == $value ? ' saveo_list_active' : '')
						           . '"'
						           . ' title="'.esc_attr($slug).'"'
						           . ' data-icon="'.esc_attr($field['return']=='full' ? $icon : $slug).'"'
						           . ($icons_type=='images' ? ' style="background-image: url('.esc_url($icon).');"' : '')
						           . '></span>';
					}
					$output .= '</div>';
				}
			}
			break;

		case 'scheme_editor':
			if (!is_array($value)) break;
			$output .= '<select class="saveo_scheme_editor_selector">';
			foreach ($value as $scheme=>$v)
				$output .= '<option value="' . esc_attr($scheme) . '">' . esc_html($v['title']) . '</option>';
			$output .= '</select>';
			$groups = saveo_storage_get('scheme_color_groups');
			$colors = saveo_storage_get('scheme_color_names');
			$output .= '<div class="saveo_scheme_editor_colors">';
			foreach ($value as $scheme=>$v) {
				$output .= '<div class="saveo_scheme_editor_header">'
				           . '<span class="saveo_scheme_editor_header_cell"></span>';
				foreach ($groups as $group_name=>$group_data) {
					$output .= '<span class="saveo_scheme_editor_header_cell" title="'.esc_html($group_data['description']).'">'
					           . esc_html($group_data['title'])
					           . '</span>';
				}
				$output .= '</div>';
				foreach ($colors as $color_name=>$color_data) {
					$output .= '<div class="saveo_scheme_editor_row">'
					           . '<span class="saveo_scheme_editor_row_cell" title="'.esc_html($color_data['description']).'">'
					           . esc_html($color_data['title'])
					           . '</span>';
					foreach ($groups as $group_name=>$group_data) {
						$slug = $group_name == 'main'
							? $color_name
							: str_replace('text_', '', "{$group_name}_{$color_name}");
						$output .= '<span class="saveo_scheme_editor_row_cell">'
						           . (isset($v['colors'][$slug])
								? "<input type=\"text\" name=\"{$slug}\" class=\"iColorPicker\" value=\"".esc_attr($v['colors'][$slug])."\">"
								: ''
						           )
						           . '</span>';
					}
					$output .= '</div>';
				}
				break;
			}
			break;
	}
	return apply_filters('saveo_filter_show_custom_field', $output, $id, $field, $value);
}



//--------------------------------------------------------------
//-- Load Options list and styles
//--------------------------------------------------------------
require_once SAVEO_THEME_DIR . 'theme-specific/theme.setup.php';
require_once SAVEO_THEME_DIR . 'theme-options/theme.options.php';
require_once SAVEO_THEME_DIR . 'theme-specific/theme.styles.php';
?>