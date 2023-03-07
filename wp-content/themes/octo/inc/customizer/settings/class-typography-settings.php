<?php
/**
 * Typography_Settings class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\settings;

use octo\options\Defaults;
use octo\customizer\controls\register\Register_Control;
use octo\customizer\controls\typography\Typography_Control;
use octo\customizer\controls\range\Range_Control;
use octo\customizer\controls\separator\Separator_Control;
use octo\customizer\settings\Section;
use WP_Customize_Color_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class sets up the settings and controls for typography.
 *
 * @since 1.0.0
 */
class Typography_Settings {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_register', array( $this, 'register_settings_body' ) );
		add_action( 'customize_register', array( $this, 'register_settings_headings' ) );
	}

	/**
	 * Register text settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_body( $wp_customize ) {

		$section = Section::$typography_body;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[typography_body_register]',
				array(
					'settings'          => array(),
					'section'           => $section,					
					'register'          => array(
						'typography' => __( 'Typography', 'octo' ),
						'colors'     => __( 'Colors', 'octo' ),
					),
					'register_controls' => array(
						'typography' => array(
							OCTO_SETTINGS . '[body_typograhpy]',
							OCTO_SETTINGS . '[body_font_size]',
							OCTO_SETTINGS . '[body_line_height]',
							OCTO_SETTINGS . '[paragraph_spacing]',
						),
						'colors'     => array(
							OCTO_SETTINGS . '[body_font_color]',
							OCTO_SETTINGS . '[body_link_color]',
							OCTO_SETTINGS . '[body_link_color_hover]',
						),
					),
					'active_register'   => 'typography',
				)
			)
		);

		/*
		 * Text typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'body_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'body_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'body_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[body_typograhpy]',
				array(
					'label'                 => __( 'Body', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'              => array(
						'family'    => OCTO_SETTINGS . '[body_font_family]',
						'variant'   => OCTO_SETTINGS . '[body_font_variant]',
						'transform' => OCTO_SETTINGS . '[body_text_transform]',
					),
					'section'               => $section,
					'choices'               => array(
						''           => __( 'Default', 'octo' ),
						'none'       => __( 'None', 'octo' ),
						'capitalize' => __( 'Capitalize', 'octo' ),
						'lowercase'  => __( 'Lowercase', 'octo' ),
						'uppercase'  => __( 'Uppercase', 'octo' ),
					),
				)
			)
		);

		/*
		 * Body font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'body_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'body_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'body_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[body_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[body_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[body_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[body_font_size_mobile]',
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
					'responsive'  => true,
				)
			)
		);

		/*
		 * Body line height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_line_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'body_line_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[body_line_height]',
				array(
					'label'       => __( 'Line Height', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[body_line_height]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '3',
						'step' => '0.05',
					),
				)
			)
		);
		
		/*
		 * Paragraph spacing.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[paragraph_spacing]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'paragraph_spacing' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[paragraph_spacing]',
				array(
					'label'       => __( 'Paragraph Spacing', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[paragraph_spacing]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '5',
						'step' => '0.05',
					),
				)
			)
		);
		
		/*
		 * Body font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'body_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[body_font_color]',
				array(
					'label'   => __( 'Text Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[body_font_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Body link color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_link_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'body_link_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[body_link_color]',
				array(
					'label'   => __( 'Link Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[body_link_color]',
					'section' => $section,
				)
			)
		);

		/*
		 * Body link color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[body_link_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'body_link_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[body_link_color_hover]',
				array(
					'label'   => __( 'Link Color Hover', 'octo' ),
					'setting' => OCTO_SETTINGS . '[body_link_color_hover]',
					'section' => $section,
				)
			)
		);

	}

	/**
	 * Register heading settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_headings( $wp_customize ) {

		$section = Section::$typography_headings;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[typography_headings_register]',
				array(
					'settings'          => array(),
					'section'           => $section,					
					'register'          => array(
						'typography' => __( 'Typography', 'octo' ),
						'colors'     => __( 'Colors', 'octo' ),
					),
					'register_controls' => array(
						'typography' => array(
							OCTO_SETTINGS . '[headings_typograhpy]',
							OCTO_SETTINGS . '[headings_line_height]',
							OCTO_SETTINGS . '[headings_spacing]',
							'separator_typography_headings_1',
							OCTO_SETTINGS . '[h1_typography]',
							OCTO_SETTINGS . '[h1_font_size]',
							OCTO_SETTINGS . '[h1_line_height]',
							OCTO_SETTINGS . '[h1_spacing_bottom]',
							'separator_typography_headings_2',
							OCTO_SETTINGS . '[h1_entry_title_font_size]',
							'separator_typography_headings_3',
							OCTO_SETTINGS . '[h2_typography]',
							OCTO_SETTINGS . '[h2_font_size]',
							OCTO_SETTINGS . '[h2_line_height]',
							OCTO_SETTINGS . '[h2_spacing_bottom]',
							'separator_typography_headings_4',
							OCTO_SETTINGS .	'[h2_entry_title_font_size]',
							'separator_typography_headings_5',
							OCTO_SETTINGS . '[h3_typography]',
							OCTO_SETTINGS . '[h3_font_size]',
							OCTO_SETTINGS . '[h3_line_height]',
							OCTO_SETTINGS . '[h3_spacing_bottom]',
							'separator_typography_headings_6',
							OCTO_SETTINGS . '[h4_typography]',
							OCTO_SETTINGS . '[h4_font_size]',
							OCTO_SETTINGS . '[h4_line_height]',
							'separator_typography_headings_7',
							OCTO_SETTINGS . '[h5_typography]',
							OCTO_SETTINGS . '[h5_font_size]',
							OCTO_SETTINGS . '[h5_line_height]',
							'separator_typography_headings_8',
							OCTO_SETTINGS . '[h6_typography]',
							OCTO_SETTINGS . '[h6_font_size]',
							OCTO_SETTINGS . '[h6_line_height]',
						),
						'colors'     => array(
							OCTO_SETTINGS . '[headings_font_color]',
							OCTO_SETTINGS . '[h1_font_color]',
							OCTO_SETTINGS . '[h1_entry_title_font_color]',
							OCTO_SETTINGS . '[h2_font_color]',
							OCTO_SETTINGS . '[h2_entry_title_link_color]',
							OCTO_SETTINGS . '[h2_entry_title_link_color_hover]',
							OCTO_SETTINGS . '[h3_font_color]',
							OCTO_SETTINGS . '[h4_font_color]',
							OCTO_SETTINGS . '[h5_font_color]',
							OCTO_SETTINGS . '[h6_font_color]',
						),
					),
					'active_register'   => 'typography',
				)
			)
		);

		/*
		 * Heading typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[headings_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'headings_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[headings_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'headings_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[headings_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'headings_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[headings_typograhpy]',
				array(
					'label'                 => __( 'H1-H6 Headings', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'       => array(
						'family'    => OCTO_SETTINGS . '[headings_font_family]',
						'variant'   => OCTO_SETTINGS . '[headings_font_variant]',
						'transform' => OCTO_SETTINGS . '[headings_text_transform]',
					),
					'section'               => $section,
					'choices'     => array(
						''           => __( 'Default', 'octo' ),
						'none'       => __( 'None', 'octo' ),
						'capitalize' => __( 'Capitalize', 'octo' ),
						'lowercase'  => __( 'Lowercase', 'octo' ),
						'uppercase'  => __( 'Uppercase', 'octo' ),
					),
				)
			)
		);

		/*
		 * Heading line height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[headings_line_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'headings_line_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[headings_line_height]',
				array(
					'label'       => __( 'Line Height', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[headings_line_height]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '3',
						'step' => '0.05',
					),
				)
			)
		);
		
		/*
		 * Headings spacing bottom.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[headings_spacing]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'headings_spacing' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[headings_spacing]',
				array(
					'label'       => __( 'Spacing Bottom', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[headings_spacing]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '5',
						'step' => '0.05',
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
				'separator_typography_headings_1',
				array(
					'settings' => array(),
					'section'  => $section,
					'group'    => 'typography',
				)
			)
		);
		
		/*
		 * H1 typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h1_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h1_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h1_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h1_typography]',
				array(
					'label'                 => __( 'H1 Heading', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'            => array(
						'family'    => OCTO_SETTINGS . '[h1_font_family]',
						'variant'   => OCTO_SETTINGS . '[h1_font_variant]',
						'transform' => OCTO_SETTINGS . '[h1_text_transform]',
					),
					'section'               => $section,
					'choices'     => array(
						''           => __( 'Default', 'octo' ),
						'none'       => __( 'None', 'octo' ),
						'capitalize' => __( 'Capitalize', 'octo' ),
						'lowercase'  => __( 'Lowercase', 'octo' ),
						'uppercase'  => __( 'Uppercase', 'octo' ),
					),
				)
			)
		);

		/*
		 * H1 font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h1_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h1_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h1_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h1_font_size]',
				array(
					'label' => __( 'Font Size', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[h1_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[h1_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[h1_font_size_mobile]',
					),
					'section'     => $section,
					'group'       => 'typography',
					'input_attrs' => array(
						'px'  => array(
							'min'  => '6',
							'max'  => '64',
							'step' => '1',
						),
						'%'   => array(
							'min'  => '20',
							'max'  => '400',
							'step' => '1',
						),
						'em'  => array(
							'min'  => '0.375',
							'max'  => '4',
							'step' => '0.005',
						),
						'rem' => array(
							'min'  => '0.375',
							'max'  => '4',
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
		 * H1 line height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_line_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h1_line_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h1_line_height]',
				array(
					'label'       => __( 'Line Height', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[h1_line_height]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '3',
						'step' => '0.05',
					),
				)
			)
		);
		
		/*
		 * H1 spacing bottom.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_spacing_bottom]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h1_spacing_bottom' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h1_spacing_bottom]',
				array(
					'label'       => __( 'Spacing Bottom', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[h1_spacing_bottom]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '5',
						'step' => '0.05',
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
				'separator_typography_headings_2',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H1 entry title page font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_entry_title_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h1_entry_title_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_entry_title_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h1_entry_title_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_entry_title_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h1_entry_title_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h1_entry_title_font_size]',
				array(
					'label'       => __( 'H1 Entry Title Font Size', 'octo' ),
					'description' => __( 'Font-family, text transform and line height settings are inherited from the H1 headings settings.', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[h1_entry_title_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[h1_entry_title_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[h1_entry_title_font_size_mobile]',
					),
					'section'     => $section,
					'input_attrs' => array(
						'px'  => array(
							'min'  => '6',
							'max'  => '64',
							'step' => '1',
						),
						'%'   => array(
							'min'  => '20',
							'max'  => '400',
							'step' => '1',
						),
						'em'  => array(
							'min'  => '0.475',
							'max'  => '4',
							'step' => '0.005',
						),
						'rem' => array(
							'min'  => '0.475',
							'max'  => '4',
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
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_typography_headings_3',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H2 typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h2_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h2_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h2_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h2_typography]',
				array(
					'label'                 => __( 'H2 Heading', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'            => array(
						'family'    => OCTO_SETTINGS . '[h2_font_family]',
						'variant'   => OCTO_SETTINGS . '[h2_font_variant]',
						'transform' => OCTO_SETTINGS . '[h2_text_transform]',
					),
					'section'               => $section,
					'choices'     => array(
						''           => __( 'Default', 'octo' ),
						'none'       => __( 'None', 'octo' ),
						'capitalize' => __( 'Capitalize', 'octo' ),
						'lowercase'  => __( 'Lowercase', 'octo' ),
						'uppercase'  => __( 'Uppercase', 'octo' ),
					),
				)
			)
		);

		/*
		 * H2 font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h2_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[h2_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[h2_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[h2_font_size_mobile]',
					),
					'section'     => $section,
					'input_attrs' => array(
						'px'  => array(
							'min'  => '6',
							'max'  => '64',
							'step' => '1',
						),
						'%'   => array(
							'min'  => '20',
							'max'  => '400',
							'step' => '1',
						),
						'em'  => array(
							'min'  => '0.375',
							'max'  => '4',
							'step' => '0.005',
						),
						'rem' => array(
							'min'  => '0.375',
							'max'  => '4',
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
		 * H2 line height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_line_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_line_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h2_line_height]',
				array(
					'label'       => __( 'Line Height', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[h2_line_height]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '3',
						'step' => '0.05',
					),
				)
			)
		);
		
		/*
		 * H2 spacing bottom.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_spacing_bottom]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_spacing_bottom' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h2_spacing_bottom]',
				array(
					'label'       => __( 'Spacing Bottom', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[h2_spacing_bottom]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '5',
						'step' => '0.05',
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
				'separator_typography_headings_4',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H2 entry title archive font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_entry_title_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_entry_title_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_entry_title_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_entry_title_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_entry_title_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_entry_title_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS .	'[h2_entry_title_font_size]',
				array(
					'label'       => __( 'H2 Entry Title Font Size', 'octo' ),
					'description' => __( 'Font-family, text transform and line height settings are inherited from the H2 headings settings.', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[h2_entry_title_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[h2_entry_title_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[h2_entry_title_font_size_mobile]',
					),
					'section'     => $section,
					'input_attrs' => array(
						'px'  => array(
							'min'  => '6',
							'max'  => '64',
							'step' => '1',
						),
						'%'   => array(
							'min'  => '20',
							'max'  => '400',
							'step' => '1',
						),
						'em'  => array(
							'min'  => '0.375',
							'max'  => '4',
							'step' => '0.005',
						),
						'rem' => array(
							'min'  => '0.375',
							'max'  => '4',
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
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_typography_headings_5',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H3 typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h3_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h3_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h3_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h3_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h3_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h3_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h3_typography]',
				array(
					'label'                 => __( 'H3 Heading', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'              => array(
						'family'    => OCTO_SETTINGS . '[h3_font_family]',
						'variant'   => OCTO_SETTINGS . '[h3_font_variant]',
						'transform' => OCTO_SETTINGS . '[h3_text_transform]',
					),
					'section'               => $section,
					'choices'     => array(
						''           => __( 'Default', 'octo' ),
						'none'       => __( 'None', 'octo' ),
						'capitalize' => __( 'Capitalize', 'octo' ),
						'lowercase'  => __( 'Lowercase', 'octo' ),
						'uppercase'  => __( 'Uppercase', 'octo' ),
					),
				)
			)
		);

		/*
		 * H3 font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h3_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h3_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h3_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h3_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h3_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h3_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS .
				'[h3_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[h3_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[h3_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[h3_font_size_mobile]',
					),
					'section'     => $section,
					'input_attrs' => array(
						'px'  => array(
							'min'  => '6',
							'max'  => '64',
							'step' => '1',
						),
						'%'   => array(
							'min'  => '20',
							'max'  => '400',
							'step' => '1',
						),
						'em'  => array(
							'min'  => '0.375',
							'max'  => '4',
							'step' => '0.005',
						),
						'rem' => array(
							'min'  => '0.375',
							'max'  => '4',
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
		 * H3 line height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h3_line_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h3_line_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h3_line_height]',
				array(
					'label'       => __( 'Line Height', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[h3_line_height]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '3',
						'step' => '0.05',
					),
				)
			)
		);
		
		/*
		 * H3 spacing bottom.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h3_spacing_bottom]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h3_spacing_bottom' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h3_spacing_bottom]',
				array(
					'label'       => __( 'Spacing Bottom', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[h3_spacing_bottom]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '5',
						'step' => '0.05',
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
				'separator_typography_headings_6',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H4 typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h4_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h4_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h4_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h4_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h4_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h4_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h4_typography]',
				array(
					'label'                 => __( 'H4 Heading', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'              => array(
						'family'    => OCTO_SETTINGS . '[h4_font_family]',
						'variant'   => OCTO_SETTINGS . '[h4_font_variant]',
						'transform' => OCTO_SETTINGS . '[h4_text_transform]',
					),
					'section'               => $section,
					'choices'     => array(
						''           => __( 'Default', 'octo' ),
						'none'       => __( 'None', 'octo' ),
						'capitalize' => __( 'Capitalize', 'octo' ),
						'lowercase'  => __( 'Lowercase', 'octo' ),
						'uppercase'  => __( 'Uppercase', 'octo' ),
					),
				)
			)
		);

		/*
		 * H4 font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h4_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h4_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h4_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h4_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h4_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h4_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS .
				'[h4_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[h4_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[h4_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[h4_font_size_mobile]',
					),
					'section'     => $section,
					'input_attrs' => array(
						'px'  => array(
							'min'  => '6',
							'max'  => '64',
							'step' => '1',
						),
						'%'   => array(
							'min'  => '20',
							'max'  => '400',
							'step' => '1',
						),
						'em'  => array(
							'min'  => '0.375',
							'max'  => '4',
							'step' => '0.005',
						),
						'rem' => array(
							'min'  => '0.375',
							'max'  => '4',
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
		 * H4 line height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h4_line_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h4_line_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h4_line_height]',
				array(
					'label'       => __( 'Line Height', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[h4_line_height]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '3',
						'step' => '0.05',
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
				'separator_typography_headings_7',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H5 typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h5_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h5_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h5_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h5_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h5_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h5_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h5_typography]',
				array(
					'label'              => __( 'H5 Heading', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'              => array(
						'family'    => OCTO_SETTINGS . '[h5_font_family]',
						'variant'   => OCTO_SETTINGS . '[h5_font_variant]',
						'transform' => OCTO_SETTINGS . '[h5_font_variant]',
					),
					'section'            => $section,
					'choices'            => array(
						''           => __( 'Default', 'octo' ),
						'none'       => __( 'None', 'octo' ),
						'capitalize' => __( 'Capitalize', 'octo' ),
						'lowercase'  => __( 'Lowercase', 'octo' ),
						'uppercase'  => __( 'Uppercase', 'octo' ),
					),
				)
			)
		);

		/*
		 * H5 font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h5_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h5_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h5_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h5_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h5_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h5_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS .
				'[h5_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[h5_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[h5_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[h5_font_size_mobile]',
					),
					'section'     => $section,
					'input_attrs' => array(
						'px'  => array(
							'min'  => '6',
							'max'  => '64',
							'step' => '1',
						),
						'%'   => array(
							'min'  => '20',
							'max'  => '400',
							'step' => '1',
						),
						'em'  => array(
							'min'  => '0.375',
							'max'  => '4',
							'step' => '0.005',
						),
						'rem' => array(
							'min'  => '0.375',
							'max'  => '4',
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
		 * H5 line height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h5_line_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h5_line_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h5_line_height]',
				array(
					'label'       => __( 'Line Height', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[h5_line_height]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '3',
						'step' => '0.05',
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
				'separator_typography_headings_8',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H6 typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h6_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h6_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h6_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h6_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h6_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'h6_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h6_typography]',
				array(
					'label'                 => __( 'H6 Heading', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'              => array(
						'family'    => OCTO_SETTINGS . '[h6_font_family]',
						'variant'   => OCTO_SETTINGS . '[h6_font_variant]',
						'transform' => OCTO_SETTINGS . '[h6_text_transform]',
					),
					'section'               => $section,
					'choices'     => array(
						''           => __( 'Default', 'octo' ),
						'none'       => __( 'None', 'octo' ),
						'capitalize' => __( 'Capitalize', 'octo' ),
						'lowercase'  => __( 'Lowercase', 'octo' ),
						'uppercase'  => __( 'Uppercase', 'octo' ),
					),
				)
			)
		);

		/*
		 * H6 font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h6_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h6_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h6_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h6_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h6_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h6_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS .
				'[h6_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[h6_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[h6_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[h6_font_size_mobile]',
					),
					'section'     => $section,
					'input_attrs' => array(
						'px'  => array(
							'min'  => '6',
							'max'  => '64',
							'step' => '1',
						),
						'%'   => array(
							'min'  => '20',
							'max'  => '400',
							'step' => '1',
						),
						'em'  => array(
							'min'  => '0.375',
							'max'  => '4',
							'step' => '0.005',
						),
						'rem' => array(
							'min'  => '0.375',
							'max'  => '4',
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
		 * H6 line height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h6_line_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h6_line_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'float' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h6_line_height]',
				array(
					'label'       => __( 'Line Height', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[h6_line_height]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '3',
						'step' => '0.03',
					),
				)
			)
		);
		
		/*
		 * Heading font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[headings_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'headings_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[headings_font_color]',
				array(
					'label'   => __( 'H1-H6 Text Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[headings_font_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * H1 font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h1_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h1_font_color]',
				array(
					'label'    => __( 'H1 Text Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[h1_font_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H1 entry title font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h1_entry_title_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h1_entry_title_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h1_entry_title_font_color]',
				array(
					'label'    => __( 'H1 Entry Title Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[h1_entry_title_font_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H2 font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h2_font_color]',
				array(
					'label'    => __( 'H2 Text Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[h2_font_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H2 entry title font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_entry_title_link_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_entry_title_link_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h2_entry_title_link_color]',
				array(
					'label'    => __( 'H2 Entry Title Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[h2_entry_title_link_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H2 entry title font-color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h2_entry_title_link_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h2_entry_title_link_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h2_entry_title_link_color_hover]',
				array(
					'label'    => __( 'H2 Entry Title Color Hover', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[h2_entry_title_link_color_hover]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H3 font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h3_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h3_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h3_font_color]',
				array(
					'label'    => __( 'H3 Text Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[h3_font_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H4 font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h4_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h4_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h4_font_color]',
				array(
					'label'    => __( 'H4 Text Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[h4_font_color]',
					'section'  => $section,					
				)
			)
		);
		
		/*
		 * H5 font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h5_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h5_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h5_font_color]',
				array(
					'label'    => __( 'H5 Text Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[h5_font_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * H6 font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[h6_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'h6_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[h6_font_color]',
				array(
					'label'    => __( 'H6 Text Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[h6_font_color]',
					'section'  => $section,
				)
			)
		);

	}

}
