<?php
/**
 * Header_Settings class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\settings;

use octo\options\Options;
use octo\options\Defaults;
use octo\customizer\controls\register\Register_Control;
use octo\customizer\controls\range\Range_Control;
use octo\customizer\controls\separator\Separator_Control;
use octo\customizer\controls\color_alpha\Color_Alpha_Control;
use octo\customizer\controls\background_image_position\Background_Image_Position_Control;
use octo\customizer\controls\typography\Typography_Control;
use octo\customizer\settings\Section;
use WP_Customize_Image_Control;
use WP_Customize_Cropped_Image_Control;
use WP_Customize_Color_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class sets up the settings and controls for the header.
 *
 * @since 1.0.0
 */
class Header_Settings {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_register', array( $this, 'register_settings_site_identity' ) );
		add_action( 'customize_register', array( $this, 'register_settings_layout' ) );
		add_action( 'customize_register', array( $this, 'register_settings_primary_navigation' ) );
		add_action( 'customize_register', array( $this, 'register_settings_mobile_navigation' ) );
	}

	/**
	 * Register layout settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_layout( $wp_customize ) {

		$section = Section::$header_layout;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[header_layout_register]',
				array(
					'settings'          => array(),
					'section'           => $section,
					'register'          => array(
						'general' => __( 'General', 'octo' ),
						'colors'  => __( 'Colors', 'octo' ),
					),
					'register_controls' => array(
						'general' => array(
							OCTO_SETTINGS . '[header_layout]',
							OCTO_SETTINGS . '[header_width]',
							OCTO_SETTINGS . '[header_alignment]',
							'separator_header_layout_1',
							OCTO_SETTINGS . '[header_border_bottom_width]',
							'separator_header_layout_2',
							OCTO_SETTINGS . '[header_enable_widgets]',
							'separator_header_layout_3',
							OCTO_SETTINGS . '[header_bg_image]',
							OCTO_SETTINGS . '[header_bg_image_position]',
							OCTO_SETTINGS . '[header_bg_image_size]',
							OCTO_SETTINGS . '[header_bg_image_repeat]',
							OCTO_SETTINGS . '[header_bg_image_attachement]',
						),
						'colors'  => array(
							OCTO_SETTINGS . '[header_bg_color]',
							OCTO_SETTINGS . '[header_border_bottom_color]',
						),
					),
					'active_register'   => 'general',
				)
			)
		);

		/*
		 * Header layout.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[header_layout]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'header_layout' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[header_layout]',
			array(
				'type'    => 'select',
				'label'   => __( 'Layout', 'octo' ),
				'setting' => OCTO_SETTINGS . '[header_layout]',
				'section' => $section,
				'choices' => array(
					'nav_inline' => __( 'Navigation Inline', 'octo' ),
					'nav_top'    => __( 'Navigation Top', 'octo' ),
					'nav_bottom' => __( 'Navigation Bottom', 'octo' ),
				),
			)
		);

		/*
		 * Header width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[header_width]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'header_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[header_width]',
			array(
				'type'    => 'radio',
				'label'   => __( 'Width', 'octo' ),
				'setting' => OCTO_SETTINGS . '[header_width]',
				'section' => $section,
				'choices' => array(
					'full'    => __( 'Full Width', 'octo' ),
					'content' => __( 'Content Width', 'octo' ),
				),
			)
		);

		/*
		 * Header alignment.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[header_alignment]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'header_alignment' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[header_alignment]',
			array(
				'type'    => 'radio',
				'label'   => __( 'Alignment', 'octo' ),
				'setting' => OCTO_SETTINGS . '[header_alignment]',
				'section' => $section,
				'choices' => array(
					'left'   => __( 'Left', 'octo' ),
					'center' => __( 'Center', 'octo' ),
					'right'  => __( 'Right', 'octo' ),
				),
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_header_layout_1',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);

		/*
		 * Header separator height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[header_border_bottom_width]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'header_border_bottom_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[header_border_bottom_width]',
				array(
					'label'       => __( 'Border Bottom Width', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[header_border_bottom_width]',
					'section'     => $section,
					'priority'    => 20,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '50',
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
				'separator_header_layout_2',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 20,
				)
			)
		);

		/*
		 * Header enable widget area.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[header_enable_widgets]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'header_enable_widgets' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[header_enable_widgets]',
			array(
				'type'     => 'select',
				'label'    => __( 'Enable Widget Area', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[header_enable_widgets]',
				'section'  => $section,
				'priority' => 30,
				'choices'  => array(
					'disabled' => __( 'Disabled', 'octo' ),
					'all'      => __( 'Enable for All Devices', 'octo' ),
					'small'    => __( 'Enable for Big and Medium Devices', 'octo' ),
					'medium'   => __( 'Enable for Big Devices only', 'octo' ),
				),
			)
		);
		
		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_header_layout_3',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 30,
				)
			)
		);
		
		/*
		 * Background image.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[header_bg_image]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'header_bg_image' ),
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				OCTO_SETTINGS . '[header_bg_image]',
				array(
					'label'    => __( 'Background Image', 'octo' ),
					'section'  => $section,
					'priority' => 30,
					'settings' => OCTO_SETTINGS . '[header_bg_image]',
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
			OCTO_SETTINGS . '[header_bg_image_position]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'header_bg_image_position' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);		
		
		$wp_customize->add_control(
			new Background_Image_Position_Control(
				$wp_customize,
				OCTO_SETTINGS . '[header_bg_image_position]',
				array(
					'label'    => __( 'Image Position', 'octo' ),
					'section'  => $section,
					'priority' => 30,
					'setting'  => OCTO_SETTINGS . '[header_bg_image_position]',
				)
			)
		);
		
		/*
		 * Background image size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[header_bg_image_size]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'header_bg_image_size' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);
		
		$wp_customize->add_control(
			OCTO_SETTINGS . '[header_bg_image_size]',
			array(
				'type'     => 'radio',
				'label'    => __( 'Image Size', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[header_bg_image_size]',
				'section'  => $section,
				'priority' => 30,
				'choices'  => array(
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
			OCTO_SETTINGS . '[header_bg_image_repeat]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'header_bg_image_repeat' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);
		
		$wp_customize->add_control(
			OCTO_SETTINGS . '[header_bg_image_repeat]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Repeat Background Image', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[header_bg_image_repeat]',
				'section'  => $section,
				'priority' => 30,
			)
		);
		
		/*
		 * Background image attachement.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[header_bg_image_attachement]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'header_bg_image_attachement' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);
		
		$wp_customize->add_control(
			OCTO_SETTINGS . '[header_bg_image_attachement]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Fix Background Image on Scroll', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[header_bg_image_attachement]',
				'section'  => $section,
				'priority' => 30,
			)
		);

		/*
		 * Header background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[header_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'header_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[header_bg_color]',
				array(
					'label'   => __( 'Background Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[header_bg_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Header border bottom color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[header_border_bottom_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'header_border_bottom_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[header_border_bottom_color]',
				array(
					'label'   => __( 'Border Bottom Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[header_border_bottom_color]',
					'section' => $section,
				)
			)
		);

	}

	/**
	 * Register primary navigation settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_primary_navigation( $wp_customize ) {

		$section = Section::$header_primary_navigation;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[header_primary_navigation_register]',
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
							OCTO_SETTINGS . '[menu_item_width]',
							OCTO_SETTINGS . '[menu_item_height]',
							OCTO_SETTINGS . '[submenu_item_height]',
							OCTO_SETTINGS . '[submenu_width]',
							'separator_header_primary_navigation_1',
							OCTO_SETTINGS . '[nav_alignment]',
							'separator_header_primary_navigation_2',
							OCTO_SETTINGS . '[menu_dropdown_target]',
							OCTO_SETTINGS . '[menu_widget_area]',
						),
						'typography' => array(
							OCTO_SETTINGS . '[menu_typography]',
							OCTO_SETTINGS . '[menu_font_size]',
							'separator_header_primary_navigation_3',
							OCTO_SETTINGS . '[submenu_typography]',
							OCTO_SETTINGS . '[submenu_font_size]',
						),
						'colors'  => array(							
							OCTO_SETTINGS . '[menu_bg_color]',
							OCTO_SETTINGS . '[menu_link_color]',
							OCTO_SETTINGS . '[menu_link_color_hover]',
							OCTO_SETTINGS . '[submenu_bg_color]',
							OCTO_SETTINGS . '[submenu_link_color]',
							OCTO_SETTINGS . '[submenu_link_color_hover]',
						)
						,
					),
					'active_register'   => 'general',
				)
			)
		);

		/*
		 * Menu item width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_item_width]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'menu_item_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[menu_item_width]',
				array(
					'label'       => __( 'Menu Item Width', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[menu_item_width]',
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
		 * Menu item height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_item_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'menu_item_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[menu_item_height]',
				array(
					'label'       => __( 'Menu Item Height', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[menu_item_height]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '150',
						'step' => '1',
					),
				)
			)
		);
		
		/*
		 * Submenu item height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[submenu_item_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'submenu_item_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[submenu_item_height]',
				array(
					'label'       => __( 'Submenu Item Height', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[submenu_item_height]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '100',
						'step' => '1',
					),
				)
			)
		);
		
		/*
		 * Submenu width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[submenu_width]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'submenu_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[submenu_width]',
				array(
					'label'       => __( 'Submenu Width', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[submenu_width]',
					'section'     => $section,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '400',
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
				'separator_header_primary_navigation_1',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 20,
				)
			)
		);

		/*
		 * Navigation alignment.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[nav_alignment]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'nav_alignment' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[nav_alignment]',
			array(
				'type'     => 'radio',
				'label'    => __( 'Alignment', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[nav_alignment]',
				'section'  => $section,
				'priority' => 30,
				'choices'  => array(
					'left'   => __( 'Left', 'octo' ),
					'center' => __( 'Center', 'octo' ),
					'right'  => __( 'Right', 'octo' ),
				),
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_header_primary_navigation_2',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 40,
				)
			)
		);

		/*
		 * Navigation dropdown click.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_dropdown_target]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'menu_dropdown_target' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[menu_dropdown_target]',
			array(
				'type'     => 'select',
				'label'    => __( 'Menu Dropdown Target', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[menu_dropdown_target]',
				'section'  => $section,
				'priority' => 50,
				'choices'  => array(
					'hover'      => __( 'Hover', 'octo' ),
					'click_icon' => __( 'Click Icon', 'octo' ),
					'click_item' => __( 'Click Menu Item', 'octo' ),
				),
			)
		);

		/*
		 * Menu enable widget area.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_widget_area]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'menu_widget_area' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[menu_widget_area]',
			array(
				'type'     => 'select',
				'label'    => __( 'Widget Area', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[menu_widget_area]',
				'section'  => $section,
				'priority' => 50,
				'choices' => array(
					'disabled' => __( 'Disabled', 'octo' ),
					'enabled'  => __( 'Enabled', 'octo' ),
				),
			)
		);
		
		/*
		 * Menu typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'menu_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'menu_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'menu_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[menu_typography]',
				array(
					'label'                 => __( 'Menu', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'              => array(
						'family'    => OCTO_SETTINGS . '[menu_font_family]',
						'variant'   => OCTO_SETTINGS . '[menu_font_variant]',
						'transform' => OCTO_SETTINGS . '[menu_text_transform]',
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
		 * Menu font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_font_size]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'menu_font_size' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[menu_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[menu_font_size]',
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
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_header_primary_navigation_3',
				array(
					'settings' => array(),
					'section'  => $section,
					'group'    => 'typography',
				)
			)
		);
		
		/*
		 * Submenu typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[submenu_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'submenu_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[submenu_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'submenu_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[submenu_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'submenu_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[submenu_typography]',
				array(
					'label'                 => __( 'Submenu', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'              => array(
						'family'    => OCTO_SETTINGS . '[submenu_font_family]',
						'variant'   => OCTO_SETTINGS . '[submenu_font_variant]',
						'transform' => OCTO_SETTINGS . '[submenu_text_transform]',
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
		 * Submenu font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[submenu_font_size]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'submenu_font_size' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS .
				'[submenu_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[submenu_font_size]',
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
		 * Menu background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'menu_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[menu_bg_color]',
				array(
					'label'   => __( 'Menu Background Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[menu_bg_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Menu text color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_link_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'menu_link_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[menu_link_color]',
				array(
					'label'    => __( 'Menu Link Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[menu_link_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Menu text color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[menu_link_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'menu_link_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[menu_link_color_hover]',
				array(
					'label'    => __( 'Menu Link Color Hover', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[menu_link_color_hover]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Submenu background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[submenu_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'submenu_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[submenu_bg_color]',
				array(
					'label'    => __( 'Submenu Background Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[submenu_bg_color]',
					'section'  => $section,
				)
			)
		);
					
		/*
		 * Submenu link color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[submenu_link_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'submenu_link_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[submenu_link_color]',
				array(
					'label'    => __( 'Submenu Link Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[submenu_link_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Submenu link color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[submenu_link_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'submenu_link_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[submenu_link_color_hover]',
				array(
					'label'    => __( 'Submenu Link Color Hover', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[submenu_link_color_hover]',
					'section'  => $section,
				)
			)
		);

	}
	
	/**
	 * Register mobile navigation settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_mobile_navigation( $wp_customize ) {

		$section = Section::$header_mobile_navigation;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[header_mobile_menu_register]',
				array(
					'settings'          => array(),
					'section'           => $section,
					'priority'          => 5,
					'register'          => array(
						'general'    => __( 'General', 'octo' ),
						'typography' => __( 'Typography', 'octo' ),
						'colors'     => __( 'Colors', 'octo' ),
					),
					'register_controls' => array(
						'general' => array(
							OCTO_SETTINGS . '[mobile_menu_item_width]',
							OCTO_SETTINGS . '[mobile_menu_item_height]',
							'separator_header_mobile_navigation_1',
							OCTO_SETTINGS . '[mobile_menu_breakpoint]',
							OCTO_SETTINGS . '[mobile_menu_widget_area]',
							OCTO_SETTINGS . '[toggle_button_text]',
						),
						'typography' => array(
							OCTO_SETTINGS . '[mobile_menu_font_size]',
						),
						'colors'  => array(
							OCTO_SETTINGS . '[mobile_menu_bg_color]',
							OCTO_SETTINGS . '[mobile_menu_link_color]',
							OCTO_SETTINGS . '[mobile_menu_link_color_hover]',
							OCTO_SETTINGS . '[mobile_submenu_bg_color]',
							OCTO_SETTINGS . '[mobile_submenu_link_color]',
							OCTO_SETTINGS . '[mobile_submenu_link_color_hover]',
						),
					),
					'active_register'   => 'general',
				)
			)
		);
		
		/*
		 * Mobile menu item width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_menu_item_width]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'mobile_menu_item_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);
		
		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_menu_item_width]',
				array(
					'label'       => __( 'Menu Item Width', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[mobile_menu_item_width]',
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
		 * Mobile menu item height.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_menu_item_height]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'mobile_menu_item_height' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);
		
		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_menu_item_height]',
				array(
					'label'       => __( 'Menu Item Height', 'octo' ),
					'setting'     => OCTO_SETTINGS . '[mobile_menu_item_height]',
					'section'     => $section,
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
				'separator_header_mobile_navigation_1',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);

		/*
		 * Mobile menu breakpoint.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_menu_breakpoint]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'mobile_menu_breakpoint' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);
		
		$wp_customize->add_control(
			OCTO_SETTINGS . '[mobile_menu_breakpoint]',
			array(
				'type'     => 'select',
				'label'    => __( 'Mobile Menu Breakpoint', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[mobile_menu_widget_area]',
				'section'  => $section,
				'choices' => array(
					'small'  => __( 'Small Device', 'octo' ),
					'medium' => __( 'Medium Device', 'octo' ),
				),
			)
		);
		
		/*
		 * Mobile menu enable widget area.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_menu_widget_area]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'mobile_menu_widget_area' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[mobile_menu_widget_area]',
			array(
				'type'     => 'select',
				'label'    => __( 'Widget Area', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[mobile_menu_widget_area]',
				'section'  => $section,
				'priority' => 20,
				'choices' => array(
					'disabled' => __( 'Disabled', 'octo' ),
					'enabled'  => __( 'Enabled', 'octo' ),
				),
			)
		);

		/*
		 * Mobile menu text.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[toggle_button_text]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'toggle_button_text' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[toggle_button_text]',
			array(
				'type'     => 'text',
				'label'    => __( 'Mobile Menu Text', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[toggle_button_text]',
				'section'  => $section,
				'priority' => 30,
			)
		);
		
		/*
		 * Mobile menu font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_menu_font_size]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'mobile_menu_font_size' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_menu_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'description' => __( 'Font-family and text transform settings are inherited from the primary menu settings.', 'octo' ),
					'settings'    => OCTO_SETTINGS . '[mobile_menu_font_size]',
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
		 * Mobil menu background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_menu_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'mobile_menu_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_menu_bg_color]',
				array(
					'label'   => __( 'Background Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[mobile_menu_bg_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Mobile menu text color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_menu_link_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'mobile_menu_link_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_menu_link_color]',
				array(
					'label'   => __( 'Menu Link Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[mobile_menu_link_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Mobile menu text color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_menu_link_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'mobile_menu_link_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_menu_link_color_hover]',
				array(
					'label'   => __( 'Menu Link Color Hover', 'octo' ),
					'setting' => OCTO_SETTINGS . '[mobile_menu_link_color_hover]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Mobile submenu background color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_submenu_bg_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'mobile_submenu_bg_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new Color_Alpha_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_submenu_bg_color]',
				array(
					'label'   => __( 'Submenu Background Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[mobile_submenu_bg_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Mobile submenu text color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_submenu_link_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'mobile_submenu_link_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_submenu_link_color]',
				array(
					'label'   => __( 'Submenu Link Color', 'octo' ),
					'setting' => OCTO_SETTINGS . '[mobile_submenu_link_color]',
					'section' => $section,
				)
			)
		);
		
		/*
		 * Mobile submenu text color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_submenu_link_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'mobile_submenu_link_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_submenu_link_color_hover]',
				array(
					'label'   => __( 'Submenu Link Color Hover', 'octo' ),
					'setting' => OCTO_SETTINGS . '[mobile_submenu_link_color_hover]',
					'section' => $section,
				)
			)
		);

	}

	/**
	 * Register layout settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_site_identity( $wp_customize ) {

		$section = Section::$header_site_identity;
		
		/*
		 * Register.
		 */
		$wp_customize->add_control( 
			new Register_Control(
				$wp_customize, 													 
				OCTO_SETTINGS . '[header_site_identity_groups]',
				array(
					'settings'          => array(),
					'section'           => $section,
					'register'          => array(
						'general'    => __( 'General', 'octo' ),
						'typography' => __( 'Typography', 'octo' ),
						'colors'     => __( 'Colors', 'octo' ),
					),
					'register_controls' => array(
						'general'    => array(
							'custom_logo',
							OCTO_SETTINGS . '[logo_width]',
							OCTO_SETTINGS . '[mobile_logo]',
							OCTO_SETTINGS . '[mobile_logo_width]',
							'separator_header_site_identity_1',
							'blogname',
							OCTO_SETTINGS . '[display_title]',
							'blogdescription',
							OCTO_SETTINGS . '[display_tagline]',
							'separator_header_site_identity_2',
							'site_icon',
						),
						'typography' => array(
							OCTO_SETTINGS . '[title_typography]',
							OCTO_SETTINGS . '[title_font_size]',
							'separator_header_site_identity_3',
							OCTO_SETTINGS . '[tagline_font_size]',
						),
						'colors'     => array(
							OCTO_SETTINGS . '[title_font_color]',
							OCTO_SETTINGS . '[title_font_color_hover]',
							OCTO_SETTINGS . '[tagline_font_color]',
						),
					),
					'active_register'   => 'general',
					'priority'          => 5,
				)
			)
		);

		/*
		 * Custom logo.
		 */
		$custom_logo_setting = $wp_customize->get_setting( 'custom_logo' );
		$custom_logo_control = $wp_customize->get_control( 'custom_logo' );
		$custom_logo_control->section = $section;

		/*
		 * Custom logo width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[logo_width_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'logo_width_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[logo_width_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'logo_width_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[logo_width_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'logo_width_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);
		
		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[logo_width]',
				array(
					'label'           => __( 'Logo Max Width', 'octo' ),
					'settings'        => array(
						'desktop' => OCTO_SETTINGS . '[logo_width_desktop]',
						'tablet'  => OCTO_SETTINGS . '[logo_width_tablet]',
						'mobile'  => OCTO_SETTINGS . '[logo_width_mobile]',
					),
					'section'         => $section,
					'input_attrs'     => array(
						'min'  => '0',
						'max'  => '500',
						'step' => '1',
					),
				)
			)
		);

		/*
		 * Custom mobile logo width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_logo]',
			array(
				'type'              => 'option',
				'default'           => '',
				'sanitize_callback' => 'absint',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Cropped_Image_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_logo]',
				array(
					'label'         => __( 'Mobile Logo', 'octo' ),
					'section'       => $section,
					'settings'      => OCTO_SETTINGS . '[mobile_logo]',
					'flex_width'    => $custom_logo_control->flex_width,
					'flex_height'   => $custom_logo_control->flex_height,
					'button_labels' => array(
						'remove' => __( 'Remove', 'octo' ),
						'change' => __( 'Change logo', 'octo' ),
					),
				)
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[mobile_logo_width]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'mobile_logo_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[mobile_logo_width]',
				array(
					'label'           => __( 'Mobile Logo Max Width', 'octo' ),
					'setting'         => OCTO_SETTINGS . '[mobile_logo_width]',
					'section'         => $section,
					'input_attrs'     => array(
						'min'  => '0',
						'max'  => '500',
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
				'separator_header_site_identity_1',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Site title.
		 */
		$blogname_setting            = $wp_customize->get_setting( 'blogname' );
		$blogname_setting->transport = 'postMessage';
		$blogname_control            = $wp_customize->get_control( 'blogname' );
		$blogname_control->section   = $section;
		$blogname_control->priority  = 20;
		
		/*
		 * Display title.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[display_title]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'display_title' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[display_title]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Display Site Title', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[display_title]',
				'section'  => $section,
				'priority' => 30,
			)
		);

		/*
		 * Site tagline.
		 */
		$blogdescription_setting            = $wp_customize->get_setting( 'blogdescription' );
		$blogdescription_setting->transport = 'postMessage';
		$blogdescription_control            = $wp_customize->get_control( 'blogdescription' );
		$blogdescription_control->section   = $section;
		$blogdescription_control->priority  = 40;
		
		/*
		 * Display description.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[display_tagline]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'display_tagline' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'checkbox' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[display_tagline]',
			array(
				'type'     => 'checkbox',
				'label'    => __( 'Display Tagline', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[display_tagline]',
				'section'  => $section,
				'priority' => 50,
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_header_site_identity_2',
				array(
					'settings'  => array(),
					'section'  => $section,
					'priority' => 60,
				)
			)
		);

		/*
		 * Site icon.
		 */
		$site_icon_setting           = $wp_customize->get_setting( 'site_icon' );
		$site_icon_control           = $wp_customize->get_control( 'site_icon' );
		$site_icon_control->section  = $section;
		$site_icon_control->priority = 70;
					
		/*
		 * Title typography.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[title_font_family]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'title_font_family' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[title_font_variant]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'title_font_variant' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);
		
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[title_text_transform]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'title_text_transform' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'typography' ),
			)
		);

		$wp_customize->add_control(
			new Typography_Control(
				$wp_customize,
				OCTO_SETTINGS . '[title_typography]',
				array(
					'label'                 => __( 'Title', 'octo' ),
					'family_sublabel'    => __( 'Font-Family', 'octo' ),
					'variants_sublabel'  => __( 'Variants', 'octo' ),
					'transform_sublabel' => __( 'Text Transform', 'octo' ),
					'settings'              => array(
						'family'    => OCTO_SETTINGS . '[title_font_family]',
						'variant'   => OCTO_SETTINGS . '[title_font_variant]',
						'transform' => OCTO_SETTINGS . '[title_text_transform]',
					),
					'section'             => $section,
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
		 * Title font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[title_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'title_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[title_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'title_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[title_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'title_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[title_font_size]',
				array(
					'label'       => __( 'Font Size', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[title_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[title_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[title_font_size_mobile]',
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
				'separator_header_site_identity_3',
				array(
					'settings' => array(),
					'section'  => $section,
				)
			)
		);

		/*
		 * Tagline font size.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[tagline_font_size_desktop]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'tagline_font_size_desktop' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[tagline_font_size_tablet]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'tagline_font_size_tablet' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_setting(
			OCTO_SETTINGS . '[tagline_font_size_mobile]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'tagline_font_size_mobile' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS .
				'[tagline_font_size]',
				array(
					'label'       => __( 'Tagline Font Size', 'octo' ),
					'description' => __( 'Font-family and text transform settings are inherited from the body typography settings.', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[tagline_font_size_desktop]',
						'tablet'  => OCTO_SETTINGS . '[tagline_font_size_tablet]',
						'mobile'  => OCTO_SETTINGS . '[tagline_font_size_mobile]',
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
		 * Site title font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[title_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'title_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[title_font_color]',
				array(
					'label'    => __( 'Title Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[title_font_color]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Site title font-color hover.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[title_font_color_hover]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'title_font_color_hover' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[title_font_color_hover]',
				array(
					'label'    => __( 'Title Color Hover', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[title_font_color_hover]',
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Tagline font-color.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[tagline_font_color]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'tagline_font_color' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'color' ),
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				OCTO_SETTINGS . '[tagline_font_color]',
				array(
					'label'    => __( 'Tagline Color', 'octo' ),
					'setting'  => OCTO_SETTINGS . '[title_font_color_hover]',
					'section'  => $section,
				)
			)
		);

	}

}
