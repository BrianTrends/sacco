<?php
/**
 * Register_Control class.
 *
 * @package octo
 * @since   1.1.0
 */

namespace octo\customizer\controls\register;

use WP_Customize_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class creates a jQuery register control.
 * It can be used for grouping multiple customizer controls into a register.
 * Grouped controls are only shown, if the register is active.
 *
 * @since 1.1.0
 */
class Register_Control extends WP_Customize_Control {

	/**
	 * Type.
	 *
	 * @var String
	 */
	public $type = 'octo-register';
	
	/**
	 * Groups.
	 *
	 * @var Array()
	 */
	public $register = array();
	
	/**
	 * Group Controls.
	 *
	 * @var Array()
	 */
	public $register_controls = array();
	
	/**
	 * Active group.
	 *
	 * @var String
	 */
	public $active_register = '';

	/**
	 * Enqueue scripts/styles for the range slider.
	 *
	 * @since 1.1.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'octo-register-control', get_template_directory_uri() . '/inc/customizer/controls/register/register-control.js', array( 'jquery', 'customize-base' ), OCTO_VERSION, true );
		wp_enqueue_style( 'octo-register-control', get_template_directory_uri() . '/inc/customizer/controls/register/register-control.css', array(), OCTO_VERSION, 'all' );

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 1.1.0
	 * @uses  WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['register']         = $this->register;
		$this->json['registerControls'] = $this->register_controls;
		$this->json['id']               = $this->id;
		$this->json['activeRegister']   = $this->active_register;

	}

	/**
	 * Don't render the control content from PHP, as it's rendered via JS on load.
	 *
	 * @since 1.1.0
	 */
	public function render_content() {}

	/**
	 * Render a JS template for the content of the color picker control.
	 *
	 * @since 1.1.0
	 */
	public function content_template() {

		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title <# if ( data.description ) { #>has-description<# } #>">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
			
		<div class="customize-control-content octo-register-wrapper">
			<# _.each( data.register, function( label, card ) { #>
				<input id="octo-register-{{ card }}-{{ data.id }}" type="radio" value="{{ card }}" name="octo-register-{{ data.id }}" <# if ( data.activeRegister === card ) { #> checked="checked" <# } #>>
				<label for="octo-register-{{ card }}-{{ data.id }}">{{ label }}</label>
			<# } ); #>
		</div>                 
		<?php
	}

}
