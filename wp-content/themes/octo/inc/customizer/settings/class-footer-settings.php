<?php
/**
 * Footer_Settings class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\settings;

use octo\options\Options;
use octo\options\Defaults;
use octo\customizer\controls\register\Register_Control;
use octo\customizer\controls\color_alpha\Color_Alpha_Control;
use octo\customizer\controls\separator\Separator_Control;
use octo\customizer\controls\range\Range_Control;
use octo\customizer\settings\Section;
use WP_Customize_Color_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class sets up the settings and controls for the footer.
 *
 * @since 1.0.0
 */
class Footer_Settings {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_register', array( $this, 'register_settings_widget_areas' ) );
	}

	/**
	 * Register widget area settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_widget_areas( $wp_customize ) {

		$section = Section::$footer_widget_areas;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[footer_widget_areas_register]',
				array(
					'settings'          => array(),
					'section'           => $section,
					'register'          => array(
						'general'    => __( 'General', 'octo' ),
						'typography' => __( 'Typography', 'octo' ),
						'colors'     => __( 'Colors', 'octo' ),
					),
					'register_controls' => array(
						'general' => array(
							OCTO_SETTINGS . '[footer_widget_areas]',
							'separator_footer_widget_areas_1',
							OCTO_SETTINGS . '[footer_width]',
						),
						'typography'  => array(
							OCTO_SETTINGS . '[footer_font_size]',
						),
						'colors'  => array(
							OCTO_SETTINGS . '[footer_bg_color]',
							OCTO_SETTINGS . '[footer_font_color]',
							OCTO_SETTINGS . '[footer_headings_color]',
							OCTO_SETTINGS . '[footer_link_color]',
							OCTO_SETTINGS . '[footer_link_color_hover]',
						),
					),
					'active_register'   => 'general',
				)
			)
		);

		/*
		 * Footer widget areas.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[footer_widget_areas]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'footer_widget_areas' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[footer_widget_areas]',
			array(
				'type'    => 'select',
				'label'   => __( 'Widget Areas', 'octo' ),
				'setting' => OCTO_SETTINGS . '[footer_widget_areas]',
				'section' => $section,
				'choices' => array(
					'0' => __( 'Disabled', 'octo' ),
					'1' => __( '1', 'octo' ),
					'2' => __( '2', 'octo' ),
					'3' => __( '3', 'octo' ),
					'4' => __( '4', 'octo' ),
					'5' => __( '5', 'octo' ),
				),
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_footer_widget_areas_1',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);

		/*
		 * Footer width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[footer_width]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'footer_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[footer_width]',
			array(
				'type'     => 'radio',
				'label'    => __( 'Width', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[footer_width]',
				'section'  => $section,
				'priority' => 20,
				'choices'  => array(
					'full'    => __( 'Full Width', 'octo' ),
					'content' => __( 'Content Width', 'octo' ),
				),
			)
		);
		
		/*
		 * Widget content font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[footer_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'footer_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[footer_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'footer_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[footer_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'footer_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[footer_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[footer_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[footer_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[footer_font_size_mobile]',
					),
					'section'     => $section,
					'input_attrs' => array(
						'px'  => array(
							'min'  => '6',
							'max'  => '32',
							'step' => '1',
						),
						'%'   => array(
							'min'  => '20',
							'max'  => '200',
							'step' => '1',
						),
						'em'  => array(
							'min'  => '0.375',
							'max'  => '2',
							'step' => '0.005',
						),
						'rem' => array(
							'min'  => '0.375',
							'max'  => '2',
							'step' => '0.005',
						),
					),
					'units'       => array(
						'px',
						'%',
						'em',
						'rem',
					),
				)
			)
		);
		
		/*
		 * Footer background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[footer_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'footer_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[footer_bg_color]',
				array(
					'label'   => __( 'Background Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[footer_bg_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Footer font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[footer_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'footer_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[footer_font_color]',
				array(
					'label'    => __( 'Text Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[footer_font_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Footer heading font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[footer_headings_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'footer_headings_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[footer_headings_color]',
				array(
					'label'    => __( 'Heading Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[footer_headings_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Footer link color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[footer_link_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'footer_link_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[footer_link_color]',
				array(
					'label'    => __( 'Link Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[footer_link_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Footer link color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[footer_link_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'footer_link_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[footer_link_color_hover]',
				array(
					'label'    => __( 'Link Color Hover', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[footer_link_color_hover]',
					'section'  => $section,
				)
			)
		);

	}
}
