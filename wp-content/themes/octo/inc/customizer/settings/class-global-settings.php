<?php
/**
 * global_Settings class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\settings;

use octo\options\Options;
use octo\options\Defaults;
use octo\customizer\controls\register\Register_Control;
use octo\customizer\controls\color_alpha\Color_Alpha_Control;
use octo\customizer\controls\range\Range_Control;
use octo\customizer\controls\separator\Separator_Control;
use octo\customizer\controls\background_image_position\Background_Image_Position_Control;
use octo\customizer\controls\spacing\Spacing_Control;
use octo\customizer\settings\Section;
use WP_Customize_Color_Control;
use WP_Customize_Image_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class sets up the general settings and controls.
 *
 * @since 1.0.0
 */
class Global_Settings {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_register', array( $this, 'register_settings_container' ) );
		add_action( 'customize_register', array( $this, 'register_settings_buttons' ) );
		add_action( 'customize_register', array( $this, 'register_settings_forms' ) );
		add_action( 'customize_register', array( $this, 'register_settings_breadcrumbs' ) );
		add_action( 'customize_register', array( $this, 'register_settings_general_settings' ) );
		add_action( 'customize_register', array( $this, 'register_settings_background' ) );
	}

	/**
	 * Register container settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_container( $wp_customize ) {

		$section = Section::$global_container;

		/*
		 * Container layout.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[container_layout]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'container_layout' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control( 
			OCTO_SETTINGS . '[container_layout]',
			array(
				'type'    => 'select',
				'label'   => __( 'Container Layout', 'octo' ),
				'setting' => OCTO_SETTINGS . '[container_layout]',
				'section' => $section,
				'choices' => array(
					'full'      => __( 'Full Width', 'octo' ),
					'boxed'     => __( 'Boxed', 'octo' ),
					'separated' => __( 'Separated', 'octo' ),
				),
			)						
		);

		/*
		 * Container width.
		 */
		$wp_customize->add_setting(
				OCTO_SETTINGS . '[container_width]',
				array(
					'type'              => 'option',
					'transport'         => 'postMessage',
					'default'           => Defaults::get_default( 'container_width' ),
					'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
				)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[container_width]',
				array(
					'label'       => __( 'Container Width', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[container_width]',
					),
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '2560',
						'step' => '1',
					),
				)
			)
		);
				
	}

	/**
	 * Register buttons settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_buttons( $wp_customize ) {

		$section = Section::$global_buttons;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[global_buttons_register]',
				array(
					'settings'          => array(),
					'section'           => $section,
					'register'          => array(
						'general' => __( 'General', 'octo' ),
						'colors'  => __( 'Colors', 'octo' ),
					),
					'register_controls' => array(
						'general' => array(
							OCTO_SETTINGS . '[button_border_radius]',
							OCTO_SETTINGS .	'[button_border_width]',
							'separator_global_button_1',
							OCTO_SETTINGS . '[button_spacing]',
						),
						'colors'  => array(
							OCTO_SETTINGS . '[button_font_color]',
							OCTO_SETTINGS . '[button_font_color_hover]',
							OCTO_SETTINGS . '[button_bg_color]',
							OCTO_SETTINGS . '[button_bg_color_hover]',
							OCTO_SETTINGS . '[button_border_color]',
							OCTO_SETTINGS . '[button_border_color_hover]',
						),
					),
					'active_register'   => 'general',
				)
			)
		);

		/*
		 * Border radius.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[button_border_radius]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'button_border_radius' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[button_border_radius]',
				array(
					'label'       => __( 'Border Radius', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[button_border_radius]',
					'section'     => $section,
					'priority'    => 20,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '30',
						'step' => '1',
					),
				)
			)
		);
		
		/*
		 * Button border width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[button_border_width]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'button_border_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS .	'[button_border_width]',
				array(
					'label'       => __( 'Border Width', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[button_border_width]',
					'section'     => $section,
					'priority'    => 25,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '10',
						'step' => '1',
					),
				)
			)
		);
				
		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_global_button_1',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 25,
				)
			)
		);
		
		/*
		 * Button spacing.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[button_spacing]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'button_spacing' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Spacing_Control(
				$wp_customize,
				OCTO_SETTINGS . '[button_spacing]',
				array(
					'label'    => __( 'Spacing', 'octo' ),
					'settings' => array(
						'desktop' => OCTO_SETTINGS . '[button_spacing]',
					),
					'section'  => $section,
					'priority' => 25,
				)
			)
		);
				
		/*
		 * Button font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[button_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'button_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[button_font_color]',
				array(
					'label'   => __( 'Text Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[button_font_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Button font-color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[button_font_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'button_font_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[button_font_color_hover]',
				array(
					'label'   => __( 'Text Color Hover', 'octo' ),
					'setting' => OCTO_SETTINGS . '[button_font_color_hover]',
					'section' => $section,
				)
			)
		);

		/*
		 * Button background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[button_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'button_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[button_bg_color]',
				array(
					'label'   => __( 'Background Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[button_bg_color]',
					'section' => $section,
				)
			)
		);

		/*
		 * Button background color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[button_bg_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'button_bg_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[button_bg_color_hover]',
				array(
					'label'   => __( 'Background Color Hover', 'octo' ),
					'setting' => OCTO_SETTINGS . '[button_bg_color_hover]',
					'section' => $section,
				)
			)
		);

		/*
		 * Button border color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[button_border_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'button_border_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[button_border_color]',
				array(
					'label'    => __( 'Border Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[button_border_color]',
					'section'  => $section,
					'priority' => 20,
				)
			)
		);
		
		/*
		 * Button border color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[button_border_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'button_border_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[button_border_color_hover]',
				array(
					'label'    => __( 'Border Color Hover', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[button_border_color_hover]',
					'section'  => $section,
					'priority' => 30,
				)
			)
		);

	}

	/**
	 * Register breadcrumbs settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_breadcrumbs( $wp_customize ) {

		$section = Section::$global_breadcrumbs;

		/*
		 * Enable Breadcrumbs.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[breadcrumbs]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'breadcrumbs' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[breadcrumbs]',
			array(
				'type'    => 'select',
				'label'   => __( 'Breadcrumbs', 'octo' ),
				'setting' => OCTO_SETTINGS . '[breadcrumbs]',
				'section' => $section,
				'choices' => array(
					'disabled' => __( 'Disabled', 'octo' ),
					'enabled'  => __( 'Enabled', 'octo' ),
				),
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_global_breadcrumbs_1',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);

		/*
		 * Disable breadcrumbs front-page.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[disable_breadcrumbs_front_page]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'disable_breadcrumbs_front_page' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[disable_breadcrumbs_front_page]',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Disable for Frontpage', 'octo' ),
				'setting' => OCTO_SETTINGS . '[disable_breadcrumbs_front_page]',
				'section' => $section,
			)
		);

		/*
		 * Disable breadcrumbs page.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[disable_breadcrumbs_page]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'disable_breadcrumbs_page' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[disable_breadcrumbs_page]',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Disable for Page', 'octo' ),
				'setting' => OCTO_SETTINGS . '[disable_breadcrumbs_page]',
				'section' => $section,
			)
		);

		/*
		 * Disable breadcrumbs blog.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[disable_breadcrumbs_blog]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'disable_breadcrumbs_blog' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[disable_breadcrumbs_blog]',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Disable for Blog Page', 'octo' ),
				'setting' => OCTO_SETTINGS . '[disable_breadcrumbs_blog]',
				'section' => $section,
			)
		);

		/*
		 * Disable breadcrumbs single.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[disable_breadcrumbs_single]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'disable_breadcrumbs_single' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[disable_breadcrumbs_single]',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Disable for Single Post', 'octo' ),
				'setting' => OCTO_SETTINGS . '[disable_breadcrumbs_single]',
				'section' => $section,
			)
		);

		/*
		 * Disable breadcrumbs archive.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[disable_breadcrumbs_archive]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'disable_breadcrumbs_archive' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[disable_breadcrumbs_archive]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Disable for Archive Page', 'octo' ),
				'settings' => OCTO_SETTINGS . '[disable_breadcrumbs_archive]',
				'section'  => $section,
			)
		);

		/*
		 * Disable breadcrumbs search.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[disable_breadcrumbs_search]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'disable_breadcrumbs_search' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[disable_breadcrumbs_search]',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Disable for Search Result', 'octo' ),
				'setting' => OCTO_SETTINGS . '[disable_breadcrumbs_search]',
				'section' => $section,
			)
		);

		/*
		 * Disable breadcrumbs 404.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[disable_breadcrumbs_404]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'disable_breadcrumbs_404' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[disable_breadcrumbs_404]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Disable for 404 Page', 'octo' ),
				'settings' => OCTO_SETTINGS . '[disable_breadcrumbs_404]',
				'section'  => $section,
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_global_breadcrumbs_2',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);

		/*
		 * Breadcrumbs separator.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[breadcrumbs_separator]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'breadcrumbs_separator' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[breadcrumbs_separator]',
			array(
				//'type'            => 'textarea',
				'label'           => __( 'Breadcrumbs Separator', 'octo' ),
				'setting'         => OCTO_SETTINGS . '[breadcrumbs_separator]',
				'section'         => $section,
			)
		);

	}

	/**
	 * Register general settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_general_settings( $wp_customize ) {

		$section = Section::$global_general_settings;

		/*
		 * Cache custom css.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[cache_custom_css]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'cache_custom_css' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[cache_custom_css]',
			array(
				'type'        => 'checkbox',
				'label'       => __( 'Cache Custom CSS', 'octo' ),
				'description' => __( 'Cache custom generated CSS code in the database to boost the overall performance.', 'octo' ),
				'setting'     => OCTO_SETTINGS . '[cache_custom_css]',
				'section'     => $section,
				'priority'    => 20,
			)
		);
		
		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_general_settings_1',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 30,
				)
			)
		);

		/*
		 * Icon set.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[icon_set]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'icon_set' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[icon_set]',
			array(
				'type'        => 'select',
				'label'       => __( 'Icons', 'octo' ),
				'description' => __( 'Chose which icon set to load on all pages.', 'octo' ),
				'setting'     => OCTO_SETTINGS . '[icon_set]',
				'section'     => $section,
				'priority'    => 40,
				'choices'     => array(
					'svg'         => __( 'SVG', 'octo' ),
					'dashicons'   => __( 'Dashicons', 'octo' ),
					'fontawesome' => __( 'Font Awesome', 'octo' ),
				),
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_general_settings_2',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 50,
				)
			)
		);

		/*
		 * Breakpoint tablet.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[breakpoint_medium_devices]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'breakpoint_medium_devices' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[breakpoint_medium_devices]',
				array(
					'label'       => __( 'Medium Device Breakpoint', 'octo' ),
					'description' => __( 'Medium device behaviour starts below this screen size.', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[breakpoint_medium_devices]',
					'section'     => $section,
					'priority'    => 60,
					'input_attrs' => array(
						'min'  => '1',
						'max'  => '2000',
						'step' => '1',
					),
				)
			)
		);

		/*
		 * Breakpoint mobile.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[breakpoint_small_devices]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'breakpoint_small_devices' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[breakpoint_small_devices]',
				array(
					'label'       => __( 'Small Device Breakpoint', 'octo' ),
					'description' => __( 'Small device behaviour starts below this screen size.', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[breakpoint_small_devices]',
					'section'     => $section,
					'priority'    => 60,
					'input_attrs' => array(
						'min'  => '1',
						'max'  => '1500',
						'step' => '1',
					),
				)
			)
		);

	}
	
	/**
	 * Register background settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_background( $wp_customize ) {

		$section = Section::$global_background;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[global_background_register]',
				array(
					'settings'          => array(),
					'section'           => $section,
					'register'          => array(
						'general' => __( 'General', 'octo' ),
						'colors'  => __( 'Colors', 'octo' ),
					),
					'active_register'   => 'general',
					'register_controls' => array(
						'general'    => array(
							OCTO_SETTINGS . '[body_bg_image]',
							OCTO_SETTINGS . '[body_bg_image_position]',
							OCTO_SETTINGS . '[body_bg_image_size]',
							OCTO_SETTINGS . '[body_bg_image_repeat]',
							OCTO_SETTINGS . '[body_bg_image_attachement]',
						),
						'colors'        => array(
							OCTO_SETTINGS . '[body_bg_color]',
							OCTO_SETTINGS . '[content_bg_color]',
						),
					),
				)
			)
		);
		
		/*
		 * Background image.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_bg_image]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'body_bg_image' ),
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				OCTO_SETTINGS . '[body_bg_image]',
				array(
					'label'    => __( 'Body Background Image', 'octo' ),
					'section'  => $section,
					'settings' => OCTO_SETTINGS . '[body_bg_image]',
					'button_labels' => array(
						'remove' => __( 'Remove', 'octo' ),
						'change' => __( 'Change image', 'octo' ),
					),
				)
			)
		);
		
		/*
		 * Background image position.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_bg_image_position]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'body_bg_image_position' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);		
		
		$wp_customize->add_control(
			new Background_Image_Position_Control(
				$wp_customize,
				OCTO_SETTINGS . '[body_bg_image_position]',
				array(
					'label'   => __( 'Image Position', 'octo' ),
					'section' => $section,
					'setting' => OCTO_SETTINGS . '[body_bg_image_position]',
				)
			)
		);
		
		/*
		 * Background image size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_bg_image_size]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'body_bg_image_size' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);
		
		$wp_customize->add_control(
			OCTO_SETTINGS . '[body_bg_image_size]',
			array(
				'type'    => 'radio',
				'label'   => __( 'Image Size', 'octo' ),
				'setting' => OCTO_SETTINGS . '[body_bg_image_size]',
				'section' => $section,
				'choices' => array(
					'auto'    => __( 'Auto', 'octo' ),
					'cover'   => __( 'Cover', 'octo' ),
					'contain' => __( 'Contain', 'octo' ),
				),
			)
		);
		
		/*
		 * Background image repeat.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_bg_image_repeat]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'body_bg_image_repeat' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);
		
		$wp_customize->add_control(
			OCTO_SETTINGS . '[body_bg_image_repeat]',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Repeat Background Image', 'octo' ),
				'setting' => OCTO_SETTINGS . '[body_bg_image_repeat]',
				'section' => $section,
			)
		);
		
		/*
		 * Background image attachement.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_bg_image_attachement]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'body_bg_image_attachement' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);
		
		$wp_customize->add_control(
			OCTO_SETTINGS . '[body_bg_image_attachement]',
			array(
				'type'    => 'checkbox',
				'label'   => __( 'Fix Background Image on Scroll', 'octo' ),
				'setting' => OCTO_SETTINGS . '[body_bg_image_attachement]',
				'section' => $section,
			)
		);
		
		/*
		 * Body background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'body_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);
		
		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[body_bg_color]',
				array(
					'label'        => __( 'Body Background Color', 'octo' ),
					'setting'      => OCTO_SETTINGS . '[body_bg_color]',
					'section'      => $section,
				)
			),
		);

		/*
		 * Content background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[content_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'content_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[content_bg_color]',
				array(
					'label'        => __( 'Content Background Color', 'octo' ),
					'setting'      => OCTO_SETTINGS . '[content_bg_color]',
					'section'      => $section,
					'show_opacity' => true,
				)
			)
		);

	}
	
	/**
	 * Register forms settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_forms( $wp_customize ) {
		
		$section = Section::$global_forms;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[global_forms_register]',
				array(
					'settings'          => array(),
					'section'           => $section,
					'register'          => array(
						'general' => __( 'General', 'octo' ),
						'colors'  => __( 'Colors', 'octo' ),
					),
					'register_controls' => array(
						'general' => array(
							OCTO_SETTINGS . '[form_border_radius]',	
							OCTO_SETTINGS .	'[form_border_width]',
							'separator_global_form_1',
							OCTO_SETTINGS .	'[form_spacing]',
						),
						'colors'  => array(
							OCTO_SETTINGS . '[form_bg_color]',
							OCTO_SETTINGS . '[form_border_color]',
							OCTO_SETTINGS . '[form_border_color_focus]',
						),
					),
					'active_register'   => 'general',
				)
			)
		);
		
		/*
		 * Form border radius.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[form_border_radius]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'form_border_radius' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[form_border_radius]',
				array(
					'label'       => __( 'Border Radius', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[form_border_radius]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '50',
						'step' => '1',
					),
				)
			)
		);
		
		/*
		 * Form border width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[form_border_width]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'form_border_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS .	'[form_border_width]',
				array(
					'label'       => __( 'Border Width', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[form_border_width]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '10',
						'step' => '1',
					),
				)
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_global_form_1',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Form spacing.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[form_spacing]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'form_spacing' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Spacing_Control(
				$wp_customize,
				OCTO_SETTINGS .	'[form_spacing]',
				array(
					'label'    => __( 'Spacing', 'octo' ),
					'settings' => array(
						'desktop' => OCTO_SETTINGS . '[form_spacing]',
					),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Form background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[form_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'form_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[form_bg_color]',
				array(
					'label'   => __( 'Background Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[form_bg_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Form border color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[form_border_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'form_border_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[form_border_color]',
				array(
					'label'   => __( 'Border Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[form_border_color]',
					'section' => $section,
				)
			)
		);

		/*
		 * Form border color focus.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[form_border_color_focus]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'form_border_color_focus' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[form_border_color_focus]',
				array(
					'label'   => __( 'Border Color Focus', 'octo' ),
					'setting' => OCTO_SETTINGS . '[form_border_color_focus]',
					'section' => $section,
				)
			)
		);
	
	}

}
