<?php
/**
 * Register class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class registers different customizer settings and options.
 *
 * @since 1.0.0
 */
class Register {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_register', array( $this, 'register_custom_controls' ) );
	}
	
	/**
	 * Register custom controls for the theme customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_custom_controls( $wp_customize ) {

		// Register JS control types.
		$wp_customize->register_control_type( 'octo\customizer\controls\register\Register_Control' );
		$wp_customize->register_control_type( 'octo\customizer\controls\color_alpha\Color_Alpha_Control' );
		$wp_customize->register_control_type( 'octo\customizer\controls\background_image_position\Background_Image_Position_Control' );
		$wp_customize->register_control_type( 'octo\customizer\controls\range\Range_Control' );
		$wp_customize->register_control_type( 'octo\customizer\controls\sortable\Sortable_Control' );
		$wp_customize->register_control_type( 'octo\customizer\controls\typography\Typography_Control' );
		$wp_customize->register_control_type( 'octo\customizer\controls\separator\Separator_Control' );
		$wp_customize->register_control_type( 'octo\customizer\controls\spacing\Spacing_Control' );

	}

}

