<?php
/**
 * Enqueue class.

 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\setup;

use octo\options\Options;
use octo\helper\Common;
use octo\fonts\Font_Families;
use octo\admin\Block_Editor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * Enqueue scripts and styles for the customizer.
 *
 * @since 1.0.0
 */
class Enqueue {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_scripts' ) );		
		add_action( 'customize_preview_init', array( $this, 'customizer_preview_init' ) );
	}

	/**
	 * Enque scripts for customizer controls.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_customizer_scripts() {

		wp_enqueue_script( 'octo-customizer-controls-helper', get_template_directory_uri() . '/assets/js/customizer-controls-helper.js', array( 'jquery', 'customize-preview' ), OCTO_VERSION, true );
		wp_enqueue_script( 'octo-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array( 'jquery', 'customize-base', 'octo-customizer-controls-helper' ), OCTO_VERSION, true );
		wp_enqueue_style( 'octo-style-customizer', get_template_directory_uri() . '/assets/css/customizer.css', array(), OCTO_VERSION, 'all' );
				
		wp_localize_script(
			'octo-typography-control',
			'octoTypography',
			array(
				'systemFonts' => Font_Families::get_system_fonts(),
				'googleFonts' => Font_Families::get_google_fonts(),
				'customFonts' => Font_Families::get_custom_fonts(),
			)
		);
		
		wp_enqueue_style( 'octo-editor-styles', get_template_directory_uri() . '/assets/css/block-editor.css', false, OCTO_VERSION, 'all' );

		// Custom stylesheets for Gutenberg block editor.
		$stylesheet = Block_Editor::get_style();

		wp_add_inline_style( 'octo-editor-styles', $stylesheet );

	}
	
	/**
	 * Enque scripts for customizer preview.
	 *
	 * @since 1.0.4
	 */
	public function customizer_preview_init() {

		wp_enqueue_script( 'octo-customizer-preview-helper', get_template_directory_uri() . '/assets/js/customizer-preview-helper.js', array( 'jquery', 'customize-preview' ), OCTO_VERSION, true );
		wp_enqueue_script( 'octo-customizer-preview', get_template_directory_uri() . '/assets/js/customizer-preview.js', array( 'jquery', 'customize-preview', 'octo-customizer-preview-helper' ), OCTO_VERSION, true );
		
		$medium_device = Options::get_theme_option( 'breakpoint_medium_devices' );
		$small_device = Options::get_theme_option( 'breakpoint_small_devices' );
		
		wp_localize_script(
			'octo-customizer-preview-helper',
			'octoBreakpoints',
			array(
				'medium_max_width'                 => Common::get_media_query_width( 'medium', 'max-width' ),
				'small_max_width'                  => Common::get_media_query_width( 'small', 'max-width' ),
				'mobile_menu_breakpoint_min_width' => Common::get_media_query_width( Options::get_theme_option( 'mobile_menu_breakpoint' ), 'min-width' ),
				'sidebar_breakpoint_min_width'     => Common::get_media_query_width( Options::get_theme_option( 'sidebar_breakpoint' ), 'min-width' ),
			)
		);
		
	}

}
