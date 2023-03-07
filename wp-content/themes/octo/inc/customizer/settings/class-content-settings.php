<?php
/**
 * Content_Settings class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\settings;

use octo\options\Options;
use octo\options\Defaults;
use octo\customizer\controls\sortable\Sortable_Control;
use octo\customizer\controls\separator\Separator_Control;
use octo\customizer\controls\range\Range_Control;
use octo\customizer\settings\Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class sets up the settings and controls for the content.
 *
 * @since 1.0.0
 */
class Content_Settings {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_register', array( $this, 'register_settings_archive' ) );
		add_action( 'customize_register', array( $this, 'register_settings_single' ) );
	}

	/**
	 * Register blog/archive settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_archive( $wp_customize ) {

		$section = Section::$content_archive;
		
		/*
		 * Blog layout.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[blog_post_layout]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'blog_post_layout' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[blog_post_layout]',
			array(
				'type'    => 'select',
				'label'   => __( 'Layout', 'octo' ),
				'setting' => OCTO_SETTINGS . '[blog_post_layout]',
				'section' => $section,
				'choices' => array(
					'featured_image' => __( 'Featured Image', 'octo' ),
					'thumbnail_left' => __( 'Thumbnail Left', 'octo' ),
				),
			)
		);		
		
		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_content_archive_1',
				array(
					'settings'  => array(),
					'section'  => $section,
					'priority' => 20,
				)
			)
		);
		
		/*
		 * Blog container width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[blog_container_width]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'blog_container_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[blog_container_width]',
				array(
					'label'       => __( 'Container Width', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[blog_container_width]',
					),
					'section'     => $section,
					'priority'    => 30,
					'input_attrs' => array(
						'min'  => '0',
						'max'  => '2560',
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
				'separator_content_archive_2',
				array(
					'settings'  => array(),
					'section'  => $section,
					'priority' => 40,
				)
			)
		);

		/**
		 * Blog post heading.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[blog_post_structure_featured_image]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'blog_post_structure_featured_image' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'sortable' ),
			)
		);

		$wp_customize->add_control(
			new Sortable_Control(
				$wp_customize,
				OCTO_SETTINGS . '[blog_post_structure_featured_image]',
				array(
					'label'    => esc_html__( 'Post Structure', 'octo' ),
					'section'  => $section,
					'setting'  => OCTO_SETTINGS . '[blog_post_structure_featured_image]',
					'priority' => 50,
					'choices'  => array(
						'post_thumbnail' => esc_html__( 'Featured Image', 'octo' ),
						'post_title'     => esc_html__( 'Title', 'octo' ),
						'post_meta'      => esc_html__( 'Meta Items', 'octo' ),
						'post_content'   => esc_html__( 'Content', 'octo' ),
					),
				)
			)
		);
		
		/**
		 * Blog post heading thumbnail.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[blog_post_structure_thumbnail]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'blog_post_structure_thumbnail' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'sortable' ),
			)
		);

		$wp_customize->add_control(
			new Sortable_Control(
				$wp_customize,
				OCTO_SETTINGS . '[blog_post_structure_thumbnail]',
				array(
					'label'    => esc_html__( 'Post Structure', 'octo' ),
					'section'  => $section,
					'setting'  => OCTO_SETTINGS . '[blog_post_structure_thumbnail]',
					'priority' => 50,
					'choices'  => array(
						'post_title'     => esc_html__( 'Title', 'octo' ),
						'post_meta'      => esc_html__( 'Meta Items', 'octo' ),
						'post_content'   => esc_html__( 'Content', 'octo' ),
					),
				)
			)
		);
		
		/**
		 * Meta items order.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[blog_post_meta_items]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'blog_post_meta_items' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'sortable' ),
			)
		);

		$wp_customize->add_control(
			new Sortable_Control(
				$wp_customize,
				OCTO_SETTINGS . '[blog_post_meta_items]',
				array(
					'label'    => esc_html__( 'Meta Items', 'octo' ),
					'section'  => $section,
					'setting'  => OCTO_SETTINGS . '[blog_post_meta_items]',
					'priority' => 50,
					'choices'  => array(
						'posted_on'  => esc_html__( 'Posted On', 'octo' ),
						'posted_by'  => esc_html__( 'Posted By', 'octo' ),
						'comments'   => esc_html__( 'Comments', 'octo' ),
						'categories' => esc_html__( 'Categories', 'octo' ),
						'tags'       => esc_html__( 'Tags', 'octo' ),
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
				'separator_content_archive_3',
				array(
					'settings' => array(),
					'section'  => $section,
					'priority' => 60,
				)
			)
		);
		
		/*
		 * Meta items icons.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[blog_post_meta_icons]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'blog_post_meta_icons' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[blog_post_meta_icons]',
			array(
				'type'     => 'select',
				'label'    => __( 'Meta Item Icons', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[blog_post_meta_icons]',
				'section'  => $section,
				'priority' => 70,
				'choices'  => array(
					'disabled'  => __( 'Disabled', 'octo' ),
					'enabled'   => __( 'Enabled', 'octo' ),
				),
			)
		);

		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_content_archive_4',
				array(
					'settings'  => array(),
					'section'  => $section,
					'priority' => 80,
				)
			)
		);

		/*
		 * Blog post content excerpt.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[blog_post_excerpt]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'blog_post_excerpt' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);

		$wp_customize->add_control(
			OCTO_SETTINGS . '[blog_post_excerpt]',
			array(
				'type'     => 'select',
				'label'    => __( 'Post Content', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[blog_post_excerpt]',
				'section'  => $section,
				'priority' => 90,
				'choices'  => array(
					'full'    => __( 'Full Content', 'octo' ),
					'excerpt' => __( 'Excerpt', 'octo' ),
				),
			)
		);

	}

	/**
	 * Register single post settings and controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @since 1.0.0
	 */
	public static function register_settings_single( $wp_customize ) {

		$section = Section::$content_single;
		
		/*
		 * Single post featured image position.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[single_post_layout]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'single_post_layout' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'choices' ),
			)
		);
		
		$wp_customize->add_control(
			OCTO_SETTINGS . '[single_post_layout]',
			array(
				'type'     => 'select',
				'label'    => __( 'Layout', 'octo' ),
				'setting'  => OCTO_SETTINGS . '[single_post_layout]',
				'section'  => $section,
				'choices' => array(
					'full_width'     => __( 'Full Width Featured Image', 'octo' ),
					'inside_content' => __( 'Featured Image Inside Content', 'octo' ),
				),
			)
		);
		
		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_content_single_post_1',
				array(
					'settings'  => array(),
					'section'  => $section,
				)
			)
		);
		
		/*
		 * Blog container width.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[single_post_container_width]',
			array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => Defaults::get_default( 'single_post_container_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'int_string' ),
			)
		);

		$wp_customize->add_control(
			new Range_Control(
				$wp_customize,
				OCTO_SETTINGS . '[single_post_container_width]',
				array(
					'label'       => __( 'Container Width', 'octo' ),
					'settings'    => array(
						'desktop' => OCTO_SETTINGS . '[single_post_container_width]',
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
		
		/*
		 * Separator.
		 */
		$wp_customize->add_control(
			new Separator_Control(
				$wp_customize,
				'separator_content_single_post_2',
				array(
					'settings'  => array(),
					'section'  => $section,
					'priority' => 20,
				)
			)
		);
		
		/**
		 * Single post structure, when featured image is before the content container.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[single_post_structure_featured_image_full_width]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'single_post_structure_featured_image_full_width' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'sortable' ),
			)
		);

		$wp_customize->add_control(
			new Sortable_Control(
				$wp_customize,
				OCTO_SETTINGS . '[single_post_structure_featured_image_full_width]',
				array(
					'label'    => esc_html__( 'Single Post Structure', 'octo' ),
					'section'  => $section,
					'priority' => 30,
					'setting'  => OCTO_SETTINGS . '[single_post_structure_featured_image_full_width]',
					'choices'  => array(
						'post_title'     => esc_html__( 'Title', 'octo' ),
						'post_meta'      => esc_html__( 'Meta Items', 'octo' ),
						'post_content'   => esc_html__( 'Content', 'octo' ),
					),
				)
			)
		);

		/**
		 * Single post structure, when featured image is inside the content container.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[single_post_structure_featured_image_inside_content]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'single_post_structure_featured_image_inside_content' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'sortable' ),
			)
		);

		$wp_customize->add_control(
			new Sortable_Control(
				$wp_customize,
				OCTO_SETTINGS . '[single_post_structure_featured_image_inside_content]',
				array(
					'label'    => esc_html__( 'Single Post Structure', 'octo' ),
					'section'  => $section,
					'priority' => 30,
					'setting'  => OCTO_SETTINGS . '[single_post_structure_featured_image_inside_content]',
					'choices'  => array(
						'post_thumbnail' => esc_html__( 'Featured Image', 'octo' ),
						'post_title'     => esc_html__( 'Title', 'octo' ),
						'post_meta'      => esc_html__( 'Meta Items', 'octo' ),
						'post_content'   => esc_html__( 'Content', 'octo' ),
					),
				)
			)
		);
		
		/**
		 * Meta items order.
		 */
		$wp_customize->add_setting(
			OCTO_SETTINGS . '[single_post_meta_items]',
			array(
				'type'              => 'option',
				'default'           => Defaults::get_default( 'single_post_meta_items' ),
				'sanitize_callback' => array( 'octo\customizer\callbacks\Sanitize', 'sortable' ),
			)
		);

		$wp_customize->add_control(
			new Sortable_Control(
				$wp_customize,
				OCTO_SETTINGS . '[single_post_meta_items]',
				array(
					'label'    => esc_html__( 'Meta Items', 'octo' ),
					'section'  => $section,
					'setting'  => OCTO_SETTINGS . '[single_post_meta_items]',
					'priority' => 30,
					'choices'  => array(
						'posted_on'  => esc_html__( 'Posted On', 'octo' ),
						'posted_by'  => esc_html__( 'Posted By', 'octo' ),
						'comments'   => esc_html__( 'Comments', 'octo' ),
						'categories' => esc_html__( 'Categories', 'octo' ),
						'tags'       => esc_html__( 'Tags', 'octo' ),
					),
				)
			)
		);

	}
}
