<?php
/**
 * Spacing_Control class.
 *
 * @package     octo
 * @since       1.0.0
 */

namespace octo\customizer\controls\spacing;

use WP_Customize_Control;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access
}

/**
 * This class creates a jQuery spacing control.
 * It can be used for a single setting as well as for responsive settings.
 * You can assign a separate setting for each device and save the respective value.
 * If you want to use the control for a single value, just assign one setting.
 *
 * @since 1.0.0
 */
class Spacing_Control extends WP_Customize_Control {
    
    /**
     * Type.
     *
     * @var String
     */
    public $type = 'octo-spacing';
		
	/**
	 * Unit.
	 *
	 * @var String
	 */
	public $units = '';
 
    /**
     * Enqueue scripts/styles for the padding input.
     *
     * @since 1.0.0
     */
    public function enqueue() {
        wp_enqueue_script( 'octo-spacing-control', get_template_directory_uri() . '/inc/customizer/controls/spacing/spacing-control.js', array( 'jquery', 'customize-base' ), OCTO_VERSION, true );
        wp_enqueue_style( 'octo-spacing-control', get_template_directory_uri() . '/inc/customizer/controls/spacing/spacing-control.css', array(), OCTO_VERSION, 'all' );
        
    }
 
    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @since 1.0.0
     * @uses WP_Customize_Control::to_json()
     */
    public function to_json() {
       parent::to_json();
		
		if ( 1 < count( $this->settings ) ) {
			$this->json['responsive'] = true;
		}

		foreach ( $this->settings as $device => $setting ) {
			$choices = array();
			foreach ( $this->value( $device ) as $key => $value ) {
				
				if ( 'unit' !== $key ) {
					$choices[] = $key;
				}
			}

			$this->json['devices'][$device] = array(
				'default'    => $setting->default,
				'value'     => $this->value( $device ),
				'choices'   => $choices,
				'inputAttrs' => $this->render_input_attrs( $this->value( $device )['unit'] )
			);				

		}
        
		$this->json['units']               = $this->units;		
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
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		
        <div class="customize-control-content octo-spacing-wrapper">
			<# _.each( data.devices, function( attr, device ) { #>						
				<ul class="octo-controls-wrapper {{ device }} <# if ( data.responsive ) { #> responsive <# } #> <# if ( data.responsive && 'desktop' === device ) { #> active <# } #>" data-device="{{ device }}" > 
					<li>
						<button type="button" class="octo-link-inputs">
							<span class="dashicons dashicons-editor-unlink"></span>
							<span class="dashicons dashicons-admin-links"></span>
						</button>
					</li>
					<# _.each( attr.choices, function( id ) { #>							
						<li>
							<input class="octo-spacing-number {{ device }}" data-item="{{ id }}" {{{ attr.inputAttrs }}} type="number" value="{{ attr.value[id] }}" data-default="{{ attr.default[id] }}"/> 
						</li>                
					<# } ); #>
						<li>
						<# if ( data.units && _.isArray( data.units ) ) { #>
							<select class="octo-spacing-unit" data-default="{{ attr.default.unit }}">
								<# _.each( data.units, function( unit ) { #>
									<option class="{{{ unit }}}" value="{{{ unit }}}" <# if ( attr.value.unit === unit ) { #> selected="selected" <# } #>>{{{ unit }}}</option>
								<# }); #>
							</select> 
						<# } else { #>
							<input disabled type="text" class="octo-spacing-unit" value="{{ attr.value.unit }}">
						<# }#>									
						</li>                            
				</ul>		
			<# } ); #>
		</div>
        <?php
    }
	
	/**
	 * Returns the html code for the input attributes depending on the device.
	 *
	 * @param Array  $input_attrs Attributes for Input field.
	 * @param String $unit        Unit.
	 * @since 1.0.0
	 */
	public function render_input_attrs( $unit ) {

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