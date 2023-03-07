<?php
/**
 * Sidebar_Settings class.
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
class Sidebar_Settings {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_register', array( $this, 'register_settings_sidebar' ) );
	}
	
	/**
	 * Register sidebar settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_sidebar( $wp_customize ) {

		$section = Section::$sidebar;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[sidebar_register]',
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
							OCTO_SETTINGS . '[sidebar_layout]',
							OCTO_SETTINGS . '[sidebar_layout_page]',
							OCTO_SETTINGS . '[sidebar_layout_archive]',
							OCTO_SETTINGS . '[sidebar_layout_post]',
							'separator_sidebar_1',
							OCTO_SETTINGS . '[sidebar_breakpoint]',
							'separator_sidebar_2',
							OCTO_SETTINGS . '[sidebar_width]',
							OCTO_SETTINGS . '[sidebar_separator_spacing]',
							'separator_sidebar_3',
							OCTO_SETTINGS . '[sidebar_separate_container]',
							OCTO_SETTINGS . '[sidebar_separator]',
						),
						'typography'  => array(
							OCTO_SETTINGS . '[sidebar_font_size]',
						),
						'colors'  => array(
							OCTO_SETTINGS . '[sidebar_bg_color]',
							OCTO_SETTINGS . '[sidebar_font_color]',
							OCTO_SETTINGS . '[sidebar_headings_color]',
							OCTO_SETTINGS . '[sidebar_link_color]',
							OCTO_SETTINGS . '[sidebar_link_color_hover]',
						),
					),
					'active_register'   => 'general',
				)
			)
		);

		/*
		 * Sidebar layout.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_layout]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'sidebar_layout' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[sidebar_layout]',
			array(
				'type'    => 'select',
				'label'   => __( 'Sidebar Layout', 'octo' ),
				'setting' => OCTO_SETTINGS . '[sidebar_layout]',
				'section' => $section,
				'choices' => array(
					'disabled' => __( 'Disabled', 'octo' ),
					'left'     => __( 'Sidebar Left', 'octo' ),
					'right'    => __( 'Sidebar Right', 'octo' ),
				),
			)
		);

		/*
		 * Sidebar layout for pages.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_layout_page]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'sidebar_layout_page' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[sidebar_layout_page]',
			array(
				'type'    => 'select',
				'label'   => __( 'Sidebar Layout Pages', 'octo' ),
				'setting' => OCTO_SETTINGS . '[sidebar_layout_page]',
				'section' => $section,
				'choices' => array(
					'default'  => __( 'Default', 'octo' ),
					'disabled' => __( 'Disabled', 'octo' ),
					'left'     => __( 'Sidebar Left', 'octo' ),
					'right'    => __( 'Sidebar Right', 'octo' ),
				),
			)
		);

		/*
		 * Sidebar layout for bloch/archive.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_layout_archive]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'sidebar_layout_archive' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);
		
		$wp_customize->add_control(
			OCTO_SETTINGS . '[sidebar_layout_archive]',
			array(
				'type'    => 'select',
				'label'   => __( 'Sidebar Layout Blog/Archive', 'octo' ),
				'setting' => OCTO_SETTINGS . '[sidebar_layout_archive]',
				'section' => $section,
				'choices' => array(
					'default'  => __( 'Default', 'octo' ),
					'disabled' => __( 'Disabled', 'octo' ),
					'left'     => __( 'Sidebar Left', 'octo' ),
					'right'    => __( 'Sidebar Right', 'octo' ),
				),
			)
		);

		/*
		 * Sidebar layout for single posts.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_layout_post]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'sidebar_layout_post' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[sidebar_layout_post]',
			array(
				'type'    => 'select',
				'label'   => __( 'Sidebar Layout Single Posts', 'octo' ),
				'setting' => OCTO_SETTINGS . '[sidebar_layout_post]',
				'section' => $section,
				'choices' => array(
					'default'  => __( 'Default', 'octo' ),
					'disabled' => __( 'Disabled', 'octo' ),
					'left'     => __( 'Sidebar Left', 'octo' ),
					'right'    => __( 'Sidebar Right', 'octo' ),
				),
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_sidebar_1',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 20,
				)
			)
		);

		/*
		 * Mobile menu breakpoint.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_breakpoint]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'sidebar_breakpoint' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[sidebar_breakpoint]',
			array(
				'type'     => 'select',
				'label'    => __( 'Sidebar Breakpoint', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[sidebar_breakpoint]',
				'section'  => $section,
				'priority' => 30,
				'choices'  => array(
					'small'  => __( 'Small Device', 'octo' ),
					'medium' => __( 'Medium Device', 'octo' ),
				),
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_sidebar_2',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 40,
				)
			)
		);

		/*
		 * Sidebar width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_width]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'sidebar_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[sidebar_width]',
				array(
					'label'       => __( 'Sidebar Width', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[sidebar_width]',
					'section'     => $section,
					'priority'    => 50,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '100',
						'step' => '1',
					),
				)
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_separator_spacing]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'sidebar_separator_spacing' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS .
				'[sidebar_separator_spacing]',
				array(
					'label'       => __( 'Separator Spacing', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[sidebar_separator_spacing]',
					'section'     => $section,
					'priority'    => 50,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '100',
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
				'separator_sidebar_3',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 60,
				)
			)
		);
						
		/*
		 * Separate container.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_separate_container]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'sidebar_separate_container' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[sidebar_separate_container]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Separate Container', 'octo' ),
				'settings' => OCTO_SETTINGS . '[sidebar_separate_container]',
				'section'  => $section,
				'priority' => 70,
			)
		);
		
		/*
		 * Separate widgets.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_separator]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'sidebar_separate_container' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[sidebar_separator]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Enable Separator', 'octo' ),
				'settings' => OCTO_SETTINGS . '[sidebar_separator]',
				'section'  => $section,
				'priority' => 70,
			)
		);
		
		/*
		 * Font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'sidebar_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'sidebar_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'sidebar_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[sidebar_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[sidebar_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[sidebar_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[sidebar_font_size_mobile]',
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
		 * Sidebar background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'sidebar_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);
		
		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[sidebar_bg_color]',
				array(
					'label'   => __( 'Background Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[sidebar_bg_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Sidebar font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'sidebar_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[sidebar_font_color]',
				array(
					'label'    => __( 'Text Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[sidebar_font_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Sidebar headings font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_headings_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'sidebar_headings_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[sidebar_headings_color]',
				array(
					'label'    => __( 'Headings Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[sidebar_headings_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Sidebar link color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_link_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'sidebar_link_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[sidebar_link_color]',
				array(
					'label'    => __( 'Link Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[sidebar_link_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Sidebar link color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[sidebar_link_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'sidebar_link_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[sidebar_link_color_hover]',
				array(
					'label'    => __( 'Link Color Hover', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[sidebar_link_color_hover]',
					'section'  => $section,
				)
			)
		);
		
	}

}
