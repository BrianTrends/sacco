<?php
/**
 * Range_Control class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\controls\range;

use WP_Customize_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class creates a jQuery range control.
 * It can be used for a single setting as well as for responsive settings.
 * You can assign a separate setting for each device and save the respective value.
 * If you want to use the control for a single value, just assign one setting.
 *
 * @since 1.0.0
 */
class Range_Control extends WP_Customize_Control {

	/**
	 * Type.
	 *
	 * @var String
	 */
	public $type = 'octo-range';

	/**
	 * Unit.
	 *
	 * @var String
	 */
	public $units = '';

	/**
	 * Enqueue scripts/styles for the range slider.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'octo-range-control', get_template_directory_uri() . '/inc/customizer/controls/range/range-control.js', array( 'jquery', 'customize-base' ), OCTO_VERSION, true );
		wp_enqueue_style( 'octo-range-control', get_template_directory_uri() . '/inc/customizer/controls/range/range-control.css', array(), OCTO_VERSION, 'all' );

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 1.0.0
	 * @uses  WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		
		if ( 1 < count( $this->settings ) ) {
			$this->json['responsive'] = true;
		}
		
		foreach ( $this->settings as $device => $setting ) {
			$this->json['devices'][ $device ] = array(
				'default'    => ( isset( $setting->default['value'] ) ? $setting->default['value'] : $setting->default ),
				'value'      => ( isset( $this->value( $device )['value'] ) ? $this->value( $device )['value'] : $this->value( $device ) ),
				'unit'       => ( isset( $this->value( $device )['unit'] ) ? $this->value( $device )['unit'] : null ),
				'inputAttrs' => ( isset( $this->value( $device )['unit'] ) ? $this->render_input_attrs( $this->value( $device )['unit'] ) : $this->render_input_attrs( $this->value( $device ) ) ),
			);	
		}

		$this->json['units']              = $this->units;
		$this->json['inputAttrsDefaults'] = $this->input_attrs;

	}

	/**
	 * Don't render the control content from PHP, as it's rendered via JS on load.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}

	/**
	 * Render a JS template for the content of the color picker control.
	 *
	 * @since 1.0.0
	 */
	public function content_template() {

		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title <# if ( data.description ) { #>has-description<# } #>">
				{{{ data.label }}}				
				<div class="octo-buttons-wrapper">
					<div class="octo-reset-button-wrapper">
						<button type="button" class="octo-reset-button"><span class="dashicons dashicons-image-rotate"></span></button>
					</div>
					<# if ( data.responsive ) { #>
						<div class="octo-responsive-buttons-wrapper">
							<ul class="octo-responsive-buttons">
								<# if ( data.devices.desktop ) { #>
									<li class="desktop active">
										<button type="button" class="preview-desktop" data-device="desktop">
											<span class="dashicons dashicons-desktop"></span>
										</button>    
									</li>
								<# } #>
								<# if ( data.devices.tablet ) { #>
									<li class="tablet">
										<button type="button" class="preview-tablet" data-device="tablet">
											<span class="dashicons dashicons-tablet"></span>
										</button>    
									</li>
								<# } #>
								<# if ( data.devices.mobile ) { #>
									<li class="mobile">
										<button type="button" class="preview-mobile" data-device="mobile">
											<span class="dashicons dashicons-smartphone"></span>
										</button>    
									</li>
								<# } #>
							</ul>
						</div>
					<# } #>			
				</div>					
			</span>
		<# } #>			
		<div class="customize-control-content octo-range-wrapper">
			<# _.each( data.devices, function( attr, device ) { #>
				<div class="octo-controls-wrapper {{ device }} <# if ( data.responsive ) { #> responsive <# } #> <# if ( data.responsive && 'desktop' === device ) { #> active <# } #>">    
					<input {{{ attr.inputAttrs }}} type="range" class="octo-range-slider" value="{{ attr.value }}" data-default="{{ attr.default }}">
					<input type="number" class="octo-range-number" value="{{ attr.value }}" {{{ attr.inputAttrs }}} data-device="{{ device }}">                        
					<# if ( data.units && _.isArray( data.units ) ) { #>
						<select class="octo-range-unit" data-default="{{ attr.default.unit }}">
							<# _.each( data.units, function( unit ) { #>
								<option class="{{{ unit }}}" value="{{{ unit }}}" <# if ( attr.unit === unit ) { #> selected="selected" <# } #>>{{{ unit }}}</option>
							<# } ); #>
						</select> 
					<# } else if ( attr.unit ) { #>
						<input disabled type="text" class="octo-range-unit" value="{{ attr.unit }}">
					<# }#>
				</div>
			<# } ); #>
		</div>    
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<?php
	}

	/**
	 * Returns the html code for the input attributes depending on the device.
	 *
	 * @param Array  $input_attrs Attributes for Input field.
	 * @param String $unit        Unit.
	 * @since 1.0.0
	 */
	public function render_input_attrs( $unit = '' ) {

		$input_attrs = $this->input_attrs;
		
		if ( $unit && array_key_exists( $unit, $input_attrs ) ) {
			$input_attrs = $input_attrs[ $unit ];
		}

		$attr = '';
		foreach ( $input_attrs as $key => $value ) {
			$attr .= $key . '="' . esc_attr( $value ) . '" ';
		}

		return $attr;

	}

}
