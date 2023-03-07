<?php
/**
 * Section class.
 *
 * @package octo
 * @since 1.0.0
 */

namespace octo\customizer\settings;

use octo\customizer\settings\Panel;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class registers all necessary sections for the theme.
 *
 * @since 1.0.0
 */
class Section {

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_container
	 */
	public static $global_container = 'octo_section_global_container';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_sidebar
	 */
	public static $sidebar = 'octo_section_sidebar';
	
	/**
	 * Variable to store the section name.
	 *
	 * @var $global_colors
	 */
	public static $global_background = 'octo_section_global_background';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $global_buttons = 'octo_section_global_buttons';
	
	/**
	 * Variable to store the section name.
	 *
	 * @var $global_forms
	 */
	public static $global_forms = 'octo_section_global_forms';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $global_breadcrumbs = 'octo_section_global_breadcrumbs';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $global_general_settings = 'octo_section_global_general_settings';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $header_site_identity = 'octo_section_header_site_identity';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $header_layout = 'octo_section_header_layout';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $header_primary_navigation = 'octo_section_header_primary_navigation';
	
	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $header_mobile_navigation = 'octo_section_header_mobile_navigation';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $footer_widget_areas = 'octo_section_footer_widget_areas';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $content_archive = 'octo_section_content_archive';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $content_single = 'octo_section_content_single';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $typography_body = 'octo_section_typography_body';

	/**
	 * Variable to store the section name.
	 *
	 * @var $global_buttons
	 */
	public static $typography_headings = 'octo_section_typography_headings';
	
	/**
	 * Variable to store the section name.
	 *
	 * @var $colors_container
	 */
	public static $colors_container = 'octo_section_colors_container';
	
	/**
	 * Variable to store the section name.
	 *
	 * @var $colors_sidebar
	 */
	public static $colors_sidebar = 'octo_section_colors_sidebar';
	
	/**
	 * Variable to store the section name.
	 *
	 * @var $colors_buttons
	 */
	public static $colors_buttons = 'octo_section_colors_buttons';
	
	/**
	 * Variable to store the section name.
	 *
	 * @var $colors_headings
	 */
	public static $colors_headings = 'octo_section_colors_headings';
	
	/**
	 * Variable to store the section name.
	 *
	 * @var $colors_header
	 */
	public static $colors_header = 'octo_section_colors_header';
	
	/**
	 * Variable to store the section name.
	 *
	 * @var $primary_navigation
	 */
	public static $primary_navigation = 'octo_section_primary_navigation';
	
	/**
	 * Variable to store the section name.
	 *
	 * @var $colors_footer
	 */
	public static $colors_footer = 'octo_section_colors_footer';

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_register', array( $this, 'register_sections' ) );
	}

	/**
	 * Register sections for customizer settings.
	 *
	 * @param Object $wp_customize WP_Customize object.
	 * @since 1.0.0
	 */
	public static function register_sections( $wp_customize ) {

		$sections = array(
			self::$global_container    => array(
				'title' => __( 'Container', 'octo' ),
				'panel' => Panel::$global,
			),		
			self::$global_background   => array(
				'title'    => __( 'Background', 'octo' ),
				'panel'    => Panel::$global,
				'priority' => 170,
			),
			self::$global_buttons      => array(
				'title'    => __( 'Buttons', 'octo' ),
				'panel'    => Panel::$global,
				'priority' => 180,
			),
			self::$global_forms             => array(
				'title'    => __( 'Forms', 'octo' ),
				'panel'    => Panel::$global,
				'priority' => 190,
			),
			self::$global_breadcrumbs  => array(
				'title'    => __( 'Breadcrumbs', 'octo' ),
				'panel'    => Panel::$global,
				'priority' => 200,
			),
			self::$global_general_settings     => array(
				'title'    => __( 'General Settings', 'octo' ),
				'panel'    => Panel::$global,
				'priority' => 210,
			),
			self::$header_site_identity => array(
				'title' => __( 'Site Identity', 'octo' ),
				'panel' => Panel::$header,
			),
			self::$header_layout        => array(
				'title'    => __( 'Layout', 'octo' ),
				'panel'    => Panel::$header,
				'priority' => 170,
			),
			self::$header_primary_navigation    => array(
				'title'    => __( 'Primary Navigation', 'octo' ),
				'panel'    => Panel::$header,
				'priority' => 180,
			),
			self::$header_mobile_navigation    => array(
				'title'    => __( 'Mobile Navigation', 'octo' ),
				'panel'    => Panel::$header,
				'priority' => 190,
			),
			self::$footer_widget_areas  => array(
				'title' => __( 'Widget Areas', 'octo' ),
				'panel' => Panel::$footer,
			),
			self::$content_archive      => array(
				'title' => __( 'Blog/Archive', 'octo' ),
				'panel' => Panel::$content,
			),
			self::$content_single       => array(
				'title' => __( 'Single Post', 'octo' ),
				'panel' => Panel::$content,
			),
			self::$typography_body      => array(
				'title' => __( 'Body', 'octo' ),
				'panel' => Panel::$typography,
			),
			self::$typography_headings  => array(
				'title'    => __( 'Headings', 'octo' ),
				'panel'    => Panel::$typography,
				'priority' => 170,
			),
			self::$colors_container  => array(
				'title'    => __( 'Container', 'octo' ),
				'panel'    => Panel::$colors,
			),
			self::$colors_sidebar  => array(
				'title'    => __( 'Sidebar', 'octo' ),
				'panel'    => Panel::$colors,
				'priority' => 170,
			),
			self::$colors_buttons  => array(
				'title'    => __( 'Buttons', 'octo' ),
				'panel'    => Panel::$colors,
				'priority' => 180,
			),
			self::$colors_headings  => array(
				'title'    => __( 'Headings', 'octo' ),
				'panel'    => Panel::$colors,
				'priority' => 190,
			),
			self::$colors_header  => array(
				'title'    => __( 'Header', 'octo' ),
				'panel'    => Panel::$colors,
				'priority' => 200,
			),
			self::$primary_navigation  => array(
				'title'    => __( 'Primary Navigation', 'octo' ),
				'panel'    => Panel::$colors,
				'priority' => 210,
			),
			self::$colors_footer  => array(
				'title'    => __( 'Footer', 'octo' ),
				'panel'    => Panel::$colors,
				'priority' => 220,
			),
			self::$sidebar      => array(
				'title'    => __( 'Sidebar', 'octo' ),
				'priority' => 60,
			),	
		);

		foreach ( $sections as $section => $args ) {

			$wp_customize->add_section(
				$section,
				$args
			);

		}

	}

}
