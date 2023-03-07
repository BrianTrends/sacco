<?php
/**
 * Panels class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class registers all necessary panels for the theme.
 *
 * @since   1.0.0
 */
class Panel {
	
	/**
	 * Variable to store the panel name.
	 *
	 * @var $general
	 */
	public static $global = 'octo_panel_global';
	
	/**
	 * Variable to store the panel name.
	 *
	 * @var $header
	 */
	public static $header = 'octo_panel_header';
	
	/**
	 * Variable to store the panel name.
	 *
	 * @var $content
	 */
	public static $content = 'octo_panel_content';
	
	/**
	 * Variable to store the panel name.
	 *
	 * @var $footer
	 */
	public static $footer = 'octo_panel_footer';
	
	/**
	 * Variable to store the panel name.
	 *
	 * @var $colors
	 */
	public static $colors = 'octo_panel_Colors';
	
	/**
	 * Variable to store the panel name.
	 *
	 * @var $typography
	 */
	public static $typography = 'octo_panel_typography';

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_register', array( $this, 'register_panels' ) );
	}

	/**
	 * Register panels for customizer settings.
	 *
	 * @param Object $wp_customize WP_Customize object.
	 * @since 1.0.0
	 */
	public static function register_panels( $wp_customize ) {

		$panels = array(
			self::$global    => array(
				'title'    => __( 'Global', 'octo' ),
				'priority' => 30,
			),
			self::$header     => array(
				'title'    => __( 'Header', 'octo' ),
				'priority' => 40,
			),
			self::$content    => array(
				'title'    => __( 'Content', 'octo' ),
				'priority' => 50,
			),
			self::$footer     => array(
				'title'    => __( 'Footer', 'octo' ),
				'priority' => 70,
			),
			self::$colors     => array(
				'title'    => __( 'Colors', 'octo' ),
				'priority' => 80,
			),
			self::$typography => array(
				'title'    => __( 'Typography', 'octo' ),
				'priority' => 90,
			),
		);

		foreach ( $panels as $panel => $args ) {

			$wp_customize->add_panel(
				$panel,
				$args
			);

		}

	}

}
