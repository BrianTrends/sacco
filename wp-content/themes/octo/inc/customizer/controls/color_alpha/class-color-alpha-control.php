<?php
/**
 * Color_Control class.
 *
 * @package octo
 * @since   1.1.0
 */

namespace octo\customizer\controls\color_alpha;

use WP_Customize_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class enhances the WP_Customize_Color_Control class to provide in order to provide more funtionlities.
 *
 * @since 1.1.0
 */
class Color_Alpha_Control extends WP_Customize_Control {
	
	/**
	 * Official control name.
	 */
	public $type = 'alpha-color';

	/**
	 * Add support for palettes to be passed in.
	 *
	 * Supported palette values are true, false, or an array of RGBa and Hex colors.
	 */
	public $palette;

	/**
	 * Add support for showing the opacity value on the slider handle.
	 */
	public $show_opacity = true;
	
	/**
	 * Control group.
	 *
	 * @var String
	 */
	public $group;

	/**
	 * Enqueue scripts and styles.
	 *
	 * Ideally these would get registered and given proper paths before this control object
	 * gets initialized, then we could simply enqueue them here, but for completeness as a
	 * stand alone class we'll register and enqueue them here.
	 */
	public function enqueue() {
		wp_enqueue_script(
			'alpha-color-picker',
			get_template_directory_uri() . '/inc/customizer/controls/color_alpha/color-alpha-control.js',
			array( 'jquery', 'wp-color-picker' ),
			'1.0.0',
			true
		);
		wp_enqueue_style(
			'alpha-color-picker',
			get_template_directory_uri() . '/inc/customizer/controls/color_alpha/color-alpha-control.css',
			array( 'wp-color-picker' ),
			'1.0.0'
		);
	}
	
	public function to_json() {
		parent::to_json();
		$this->json['palette'] = $this->palette;
		$this->json['default'] = $this->setting->default;
		$this->json[ 'link' ] = $this->get_link();
		$this->json[ 'show_opacity' ] = $this->show_opacity;
		$this->json['group'] = $this->group;

		if ( is_array( $this->json['palette'] ) ) {
			$this->json['palette'] = implode( '|', $this->json['palette'] );
		} else {
			// Default to true.
			$this->json['palette'] = ( false === $this->json['palette'] || 'false' === $this->json['palette'] ) ? 'false' : 'true';
		}

		// Support passing show_opacity as string or boolean. Default to true.
		$this->json[ 'show_opacity' ] = ( false === $this->json[ 'show_opacity' ] || 'false' === $this->json[ 'show_opacity' ] ) ? 'false' : 'true';
	}

	/**
	 * Render the control.
	 */
	public function render_content() {}

	public function content_template() {
		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title <# if ( data.description ) { #>has-description<# } #>">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content octo-color-alpha-wrapper">
			<input class="octo-color-alpha-control" type="text" data-show-opacity="{{ data.show_opacity }}" data-palette="{{{ data.palette }}}" data-default-color="{{ data.default }}" {{{ data.link }}} />
		</div>
		<?php
	}

}
