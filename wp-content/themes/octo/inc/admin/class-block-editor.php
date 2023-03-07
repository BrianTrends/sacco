<?php
/**
 * Gutenberg block editor class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\admin;

use octo\style\CSSParser;
use octo\options\Options;
use octo\helper\Common;
use octo\admin\Metabox;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class is responsible for the appearance of the Gutenberg block editor.
 * It creates a custom stylesheet for the block editor, reflecting all the customizer settings in the block editor.
 *
 * @since 1.0.0
 */
class Block_Editor {

	/**
	 * Create custom stylesheet for Gutenberg block editor.
	 *
	 * @since  1.0.0
	 * @return String Custom styleseheet.
	 */
	private static function create_stylesheet() {

		// Get new CSSParser object.
		$parser = new CSSParser();

		/**
		 * Container layout
		 */
		$container_layout = Options::get_theme_option( 'container_layout' );
		$content_layout   = get_post_meta( get_the_ID(), 'octo_content_layout', true );
		$content_width    = self::get_content_width();		

		$parser->add_rule(
			':root',
			array(
				'--octo-post-editor-content-width' => $content_width,
			),
		);

		if ( 'full_width' === $content_layout ) {
			$parser->add_rule(
				'.block-editor .editor-styles-wrapper',
				array(
					'padding-left'  => '0',
					'padding-right' => '0',
				),
			);

			$parser->add_rule(
				'.block-editor .editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .wp-block[data-align="full"]',
				array(
					'margin-left'  => '0',
					'margin-right' => '0',
				),
			);

		}
		
		/**
		 * Background
		 */
		$body_bg_image                   = Options::get_theme_option( 'body_bg_image' );
		$body_bg_image_size              = Options::get_theme_option( 'body_bg_image_size' );
		$body_bg_image_repeat            = Options::get_theme_option( 'body_bg_image_repeat' );
		$body_bg_image_image_attachement = Options::get_theme_option( 'body_bg_image_attachement' );
		$body_bg_image_position          = Options::get_theme_option( 'body_bg_image_position' );
		$body_bg_color                   = Options::get_theme_option( 'body_bg_color' );
		$content_bg_color                = Options::get_theme_option( 'content_bg_color' );
		
		if ( 'boxed' === $container_layout || 'separated' === $container_layout ) {
			$background_color = $content_bg_color;
		} else {
			$background_color = $body_bg_color;
		}
		
		$parser->add_rule(
			':root',
			array(
				'--octo-body-bg-color'             => $background_color,
				'--octo-content-bg-color'          => $content_bg_color,
			)
		);
		
		if ( 'full' === $container_layout ) {
			$parser->add_rule(
			':root',
				array(
					'--octo-body-bg-image'             => 'url("' . $body_bg_image . '")',
					'--octo-body-bg-image-size'        => $body_bg_image_size,
					'--octo-body-bg-image-repeat'      => ( ( $body_bg_image_repeat ) ? 'repeat' : 'no-repeat' ),
					'--octo-body-bg-image-attachement' => ( ( $body_bg_image_image_attachement ) ? 'fixed' : 'scroll' ),
					'--octo-body-bg-image-position'    => $body_bg_image_position,
				)
			);
			
		}

		/**
		 * Typography
		 */
		$body_font_family       = Common::get_font_family( Options::get_theme_option( 'body_font_family' ) );
		$body_font_weight       = Common::get_font_weight( Options::get_theme_option( 'body_font_variant' ) );
		$body_font_style        = Common::get_font_style( Options::get_theme_option( 'body_font_variant' ) );
		$body_font_size_desktop = Common::get_value_from_array( Options::get_theme_option( 'body_font_size_desktop' ), 'value', true );
		$body_font_size_tablet  = Common::get_value_from_array( Options::get_theme_option( 'body_font_size_tablet' ), 'value', true );
		$body_font_size_mobile  = Common::get_value_from_array( Options::get_theme_option( 'body_font_size_mobile' ), 'value', true );
		$body_line_height       = Options::get_theme_option( 'body_line_height' );
		$body_text_transform    = Options::get_theme_option( 'body_text_transform' );
		$paragraph_spacing      = Common::get_value_from_array( Options::get_theme_option( 'paragraph_spacing' ), 'value', true );
		$body_font_color        = Options::get_theme_option( 'body_font_color' );
		$body_link_color        = Options::get_theme_option( 'body_link_color' );
		$body_link_color_hover  = Options::get_theme_option( 'body_link_color_hover' );

		$headings_font_family    = Common::get_font_family( Options::get_theme_option( 'headings_font_family' ) );
		$headings_font_weight    = Common::get_font_weight( Options::get_theme_option( 'headings_font_variant' ) );
		$headings_font_style     = Common::get_font_style( Options::get_theme_option( 'headings_font_variant' ) );
		$headings_line_height    = Options::get_theme_option( 'headings_line_height' );
		$headings_text_transform = Options::get_theme_option( 'headings_text_transform' );
		$headings_spacing        = Common::get_value_from_array( Options::get_theme_option( 'headings_spacing' ), 'value', true );
		$headings_font_color     = Options::get_theme_option( 'headings_font_color' );
		
		$h1_font_family                   = Common::get_font_family( Options::get_theme_option( 'h1_font_family' ) );
		$h1_font_weight                   = Common::get_font_weight( Options::get_theme_option( 'h1_font_variant' ) );
		$h1_font_style                    = Common::get_font_style( Options::get_theme_option( 'h1_font_variant' ) );
		$h1_text_transform                = Options::get_theme_option( 'h1_text_transform' );
		$h1_font_size_desktop             = Common::get_value_from_array( Options::get_theme_option( 'h1_font_size_desktop' ), 'value', true );
		$h1_font_size_tablet              = Common::get_value_from_array( Options::get_theme_option( 'h1_font_size_tablet' ), 'value', true );
		$h1_font_size_mobile              = Common::get_value_from_array( Options::get_theme_option( 'h1_font_size_mobile' ), 'value', true );
		$h1_line_height                   = Options::get_theme_option( 'h1_line_height' );
		$h1_spacing_bottom                = Common::get_value_from_array( Options::get_theme_option( 'h1_spacing_bottom' ), 'value', true );
		$h1_font_color                    = Options::get_theme_option( 'h1_font_color' );
		$h1_entry_title_font_size_desktop = Common::get_value_from_array( Options::get_theme_option( 'h1_entry_title_font_size_desktop' ), 'value', true );
		$h1_entry_title_font_size_tablet  = Common::get_value_from_array( Options::get_theme_option( 'h1_entry_title_font_size_tablet' ), 'value', true );
		$h1_entry_title_font_size_mobile  = Common::get_value_from_array( Options::get_theme_option( 'h1_entry_title_font_size_mobile' ), 'value', true );
		$h1_entry_title_font_color        = Options::get_theme_option( 'h1_entry_title_font_color' );
		$h2_font_family                   = Common::get_font_family( Options::get_theme_option( 'h2_font_family' ) );
		$h2_font_weight                   = Common::get_font_weight( Options::get_theme_option( 'h2_font_variant' ) );
		$h2_font_style                    = Common::get_font_style( Options::get_theme_option( 'h2_font_variant' ) );
		$h2_text_transform                = Options::get_theme_option( 'h2_text_transform' );
		$h2_font_size_desktop             = Common::get_value_from_array( Options::get_theme_option( 'h2_font_size_desktop' ), 'value', true );
		$h2_font_size_tablet              = Common::get_value_from_array( Options::get_theme_option( 'h2_font_size_tablet' ), 'value', true );
		$h2_font_size_mobile              = Common::get_value_from_array( Options::get_theme_option( 'h2_font_size_mobile' ), 'value', true );
		$h2_line_height                   = Options::get_theme_option( 'h2_line_height' );
		$h2_spacing_bottom                = Common::get_value_from_array( Options::get_theme_option( 'h2_spacing_bottom' ), 'value', true );
		$h2_font_color                    = Options::get_theme_option( 'h2_font_color' );
		$h2_entry_title_font_size_desktop = Common::get_value_from_array( Options::get_theme_option( 'h2_entry_title_font_size_desktop' ), 'value', true );
		$h2_entry_title_font_size_tablet  = Common::get_value_from_array( Options::get_theme_option( 'h2_entry_title_font_size_tablet' ), 'value', true );
		$h2_entry_title_font_size_mobile  = Common::get_value_from_array( Options::get_theme_option( 'h2_entry_title_font_size_mobile' ), 'value', true );
		$h2_entry_title_link_color        = Options::get_theme_option( 'h2_entry_title_link_color' );
		$h2_entry_title_link_color_hover  = Options::get_theme_option( 'h2_entry_title_link_color_hover' );
		$h3_font_family                   = Common::get_font_family( Options::get_theme_option( 'h3_font_family' ) );
		$h3_font_weight                   = Common::get_font_weight( Options::get_theme_option( 'h3_font_variant' ) );
		$h3_font_style                    = Common::get_font_style( Options::get_theme_option( 'h3_font_variant' ) );
		$h3_text_transform                = Options::get_theme_option( 'h3_text_transform' );
		$h3_font_size_desktop             = Common::get_value_from_array( Options::get_theme_option( 'h3_font_size_desktop' ), 'value', true );
		$h3_font_size_tablet              = Common::get_value_from_array( Options::get_theme_option( 'h3_font_size_tablet' ), 'value', true );
		$h3_font_size_mobile              = Common::get_value_from_array( Options::get_theme_option( 'h3_font_size_mobile' ), 'value', true );
		$h3_line_height                   = Options::get_theme_option( 'h3_line_height' );
		$h3_spacing_bottom                = Common::get_value_from_array( Options::get_theme_option( 'h3_spacing_bottom' ), 'value', true );
		$h3_font_color                    = Options::get_theme_option( 'h3_font_color' );
		$h4_font_family                   = Common::get_font_family( Options::get_theme_option( 'h4_font_family' ) );
		$h4_font_weight                   = Common::get_font_weight( Options::get_theme_option( 'h4_font_variant' ) );
		$h4_font_style                    = Common::get_font_style( Options::get_theme_option( 'h4_font_variant' ) );
		$h4_text_transform                = Options::get_theme_option( 'h4_text_transform' );
		$h4_font_size_desktop             = Common::get_value_from_array( Options::get_theme_option( 'h4_font_size_desktop' ), 'value', true );
		$h4_font_size_tablet              = Common::get_value_from_array( Options::get_theme_option( 'h4_font_size_tablet' ), 'value', true );
		$h4_font_size_mobile              = Common::get_value_from_array( Options::get_theme_option( 'h4_font_size_mobile' ), 'value', true );
		$h4_line_height                   = Options::get_theme_option( 'h4_line_height' );
		$h4_font_color                    = Options::get_theme_option( 'h4_font_color' );
		$h5_font_family                   = Common::get_font_family( Options::get_theme_option( 'h5_font_family' ) );
		$h5_font_weight                   = Common::get_font_weight( Options::get_theme_option( 'h5_font_variant' ) );
		$h5_font_style                    = Common::get_font_style( Options::get_theme_option( 'h5_font_variant' ) );
		$h5_text_transform                = Options::get_theme_option( 'h5_text_transform' );
		$h5_font_size_desktop             = Common::get_value_from_array( Options::get_theme_option( 'h5_font_size_desktop' ), 'value', true );
		$h5_font_size_tablet              = Common::get_value_from_array( Options::get_theme_option( 'h5_font_size_tablet' ), 'value', true );
		$h5_font_size_mobile              = Common::get_value_from_array( Options::get_theme_option( 'h5_font_size_mobile' ), 'value', true );
		$h5_line_height                   = Options::get_theme_option( 'h5_line_height' );
		$h5_font_color                    = Options::get_theme_option( 'h5_font_color' );
		$h6_font_family                   = Common::get_font_family( Options::get_theme_option( 'h6_font_family' ) );
		$h6_font_weight                   = Common::get_font_weight( Options::get_theme_option( 'h6_font_variant' ) );
		$h6_font_style                    = Common::get_font_style( Options::get_theme_option( 'h6_font_variant' ) );
		$h6_text_transform                = Options::get_theme_option( 'h6_text_transform' );
		$h6_font_size_desktop             = Common::get_value_from_array( Options::get_theme_option( 'h6_font_size_desktop' ), 'value', true );
		$h6_font_size_tablet              = Common::get_value_from_array( Options::get_theme_option( 'h6_font_size_tablet' ), 'value', true );
		$h6_font_size_mobile              = Common::get_value_from_array( Options::get_theme_option( 'h6_font_size_mobile' ), 'value', true );
		$h6_line_height                   = Options::get_theme_option( 'h6_line_height' );
		$h6_font_color                    = Options::get_theme_option( 'h6_font_color' );
		
		$parser->add_rule(
			':root',
			array(
				'--octo-body-font-size'                  => $body_font_size_desktop,
				'--octo-body-font-style'                 => $body_font_style,
				'--octo-body-font-weight'                => $body_font_weight,
				'--octo-body-font-family'                => $body_font_family,
				'--octo-body-font-color'                 => $body_font_color,
				'--octo-body-font-text-transform'        => $body_text_transform,
				'--octo-body-line-height'                => $body_line_height,				
				'--octo-paragraph-spacing'               => $paragraph_spacing,				
				'--octo-headings-color'                  => $headings_font_color,				
				'--octo-headings-line-height'            => $headings_line_height,				
				'--octo-headings-font-style'             => $headings_font_style,				
				'--octo-headings-font-weight'            => $headings_font_weight,				
				'--octo-headings-text-transform'         => $headings_text_transform,				
				'--octo-headings-font-family'            => $headings_font_family,				
				'--octo-headings-spacing'                => $headings_spacing,				
				'--octo-body-link-color'                 => $body_link_color,				
				'--octo-body-link-color-hover'           => $body_link_color_hover,
				'--octo-h1-font-color'                   => $h1_font_color,
				'--octo-h1-font-style'                   => $h1_font_style,
				'--octo-h1-font-weight'                  => $h1_font_weight,
				'--octo-h1-font-family'                  => $h1_font_family,
				'--octo-h1-font-size'                    => $h1_font_size_desktop,
				'--octo-h1-line-height'                  => $h1_line_height,
				'--octo-h1-text-transform'               => $h1_text_transform,
				'--octo-h1-spacing'                      => $h1_spacing_bottom,
				'--octo-h1-entry-title-font-size'        => $h1_entry_title_font_size_desktop,
				'--octo-h1-entry-title-font-color'       => $h1_entry_title_font_color,
				'--octo-h2-font-color'                   => $h2_font_color,
				'--octo-h2-font-style'                   => $h2_font_style,
				'--octo-h2-font-weight'                  => $h2_font_weight,
				'--octo-h2-font-family'                  => $h2_font_family,
				'--octo-h2-font-size'                    => $h2_font_size_desktop,
				'--octo-h2-line-height'                  => $h2_line_height,
				'--octo-h2-text-transform'               => $h2_text_transform,
				'--octo-h2-spacing'                      => $h2_spacing_bottom,
				'--octo-h2-entry-title-font-size'        => $h2_entry_title_font_size_desktop,
				'--octo-h2-entry-title-font-color'       => $h2_entry_title_link_color,
				'--octo-h2-entry-title-font-color-hover' => $h2_entry_title_link_color_hover,
				'--octo-h3-font-color'                   => $h3_font_color,
				'--octo-h3-font-style'                   => $h3_font_style,
				'--octo-h3-font-weight'                  => $h3_font_weight,
				'--octo-h3-font-family'                  => $h3_font_family,
				'--octo-h3-font-size'                    => $h3_font_size_desktop,
				'--octo-h3-line-height'                  => $h3_line_height,
				'--octo-h3-text-transform'               => $h3_text_transform,
				'--octo-h3-spacing'                      => $h3_spacing_bottom,
				'--octo-h4-font-color'                   => $h4_font_color,
				'--octo-h4-font-style'                   => $h4_font_style,
				'--octo-h4-font-weight'                  => $h4_font_weight,
				'--octo-h4-font-family'                  => $h4_font_family,
				'--octo-h4-font-size'                    => $h4_font_size_desktop,
				'--octo-h4-line-height'                  => $h4_line_height,
				'--octo-h4-text-transform'               => $h4_text_transform,
				'--octo-h5-font-color'                   => $h5_font_color,
				'--octo-h5-font-style'                   => $h5_font_style,
				'--octo-h5-font-weight'                  => $h5_font_weight,
				'--octo-h5-font-family'                  => $h5_font_family,
				'--octo-h5-font-size'                    => $h5_font_size_desktop,
				'--octo-h5-line-height'                  => $h5_line_height,
				'--octo-h5-text-transform'               => $h5_text_transform,
				'--octo-h6-font-color'                   => $h6_font_color,
				'--octo-h6-font-style'                   => $h6_font_style,
				'--octo-h6-font-weight'                  => $h6_font_weight,
				'--octo-h6-font-family'                  => $h6_font_family,
				'--octo-h6-font-size'                    => $h6_font_size_desktop,
				'--octo-h6-line-height'                  => $h6_line_height,
				'--octo-h6-text-transform'               => $h6_text_transform,
			),
		);

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'medium', 'max-width' ) );
		
			$parser->add_rule(
				':root',
				array(
					'--octo-body-font-size' => $body_font_size_tablet,
				),
			);

		$parser->close_media_query();

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'small', 'max-width' ) );
		
			$parser->add_rule(
				':root',
				array(
					'--octo-body-font-size' => $body_font_size_mobile,
				),
			);

		$parser->close_media_query();

		/**
		 * Button
		 */
		$button_font_color         = Options::get_theme_option( 'button_font_color' );
		$button_font_color_hover   = Options::get_theme_option( 'button_font_color_hover' );
		$button_bg_color           = Options::get_theme_option( 'button_bg_color' );
		$button_bg_color_hover     = Options::get_theme_option( 'button_bg_color_hover' );
		$button_border_radius      = Common::get_value_from_array( Options::get_theme_option( 'button_border_radius' ), 'value', true );
		$button_spacing_top        = Common::get_value_from_array( Options::get_theme_option( 'button_spacing' ), 'top', true );
		$button_spacing_right      = Common::get_value_from_array( Options::get_theme_option( 'button_spacing' ), 'right', true );
		$button_spacing_bottom     = Common::get_value_from_array( Options::get_theme_option( 'button_spacing' ), 'bottom', true );
		$button_spacing_left       = Common::get_value_from_array( Options::get_theme_option( 'button_spacing' ), 'left', true );
		$button_border_width       = Common::get_value_from_array( Options::get_theme_option( 'button_border_width' ), 'value', true );
		$button_border_color       = Options::get_theme_option( 'button_border_color' );
		$button_border_color_hover = Options::get_theme_option( 'button_border_color_hover' );

		$parser->add_rule(
			':root',
			array(
				'--octo-button-border-radius'      => $button_border_radius,
				'--octo-button-font-color'         => $button_font_color,
				'--octo-button-font-color-hover'   => $button_font_color_hover,
				'--octo-button-bg-color'           => $button_bg_color,
				'--octo-button-bg-color-hover'     => $button_bg_color_hover,
				'--octo-button-border-width'       => $button_border_width,
				'--octo-button-border-color'       => $button_border_color,
				'--octo-button-border-color-hover' => $button_border_color_hover,
				'--octo-button-spacing-top'        => $button_spacing_top,
				'--octo-button-spacing-right'      => $button_spacing_right,
				'--octo-button-spacing-bottom'     => $button_spacing_bottom,
				'--octo-button-spacing-left'       => $button_spacing_left,
			),
		);
		
		/**
		 * Forms
		 */
		$form_spacing_top        = Common::get_value_from_array( Options::get_theme_option( 'form_spacing' ), 'top', true );
		$form_spacing_right      = Common::get_value_from_array( Options::get_theme_option( 'form_spacing' ), 'right', true );
		$form_spacing_bottom     = Common::get_value_from_array( Options::get_theme_option( 'form_spacing' ), 'bottom', true );
		$form_spacing_left       = Common::get_value_from_array( Options::get_theme_option( 'form_spacing' ), 'left', true );
		$form_border_radius      = Common::get_value_from_array( Options::get_theme_option( 'form_border_radius' ), 'value', true );
		$form_border_width       = Common::get_value_from_array( Options::get_theme_option( 'form_border_width' ), 'value', true );
		$form_bg_color           = Options::get_theme_option( 'form_bg_color' );
		$form_border_color       = Options::get_theme_option( 'form_border_color' );
		$form_border_color_focus = Options::get_theme_option( 'form_border_color_focus' );

		$parser->add_rule(
			':root',
			array(
				'--octo-forms-spacing-top'        => $form_spacing_top,
				'--octo-forms-spacing-bottom'     => $form_spacing_right,
				'--octo-forms-spacing-left'       => $form_spacing_bottom,
				'--octo-forms-spacing-right'      => $form_spacing_left,
				'--octo-forms-border-radius'      => $form_border_radius,
				'--octo-forms-border-width'       => $form_border_width,
				'--octo-forms-border-color'       => $form_border_color,
				'--octo-forms-border-color-focus' => $form_border_color_focus,
				'--octo-forms-bg-color'           => $form_bg_color,
			)
		);
		
		/*
		 * Sidebar
		 */		
		$sidebar_bg_color 		   = Options::get_theme_option( 'sidebar_bg_color' );
		$sidebar_headings_color    = Options::get_theme_option( 'sidebar_headings_color' );
		$sidebar_font_color        = Options::get_theme_option( 'sidebar_font_color' );
		$sidebar_link_color        = Options::get_theme_option( 'sidebar_link_color' );
		$sidebar_link_color_hover  = Options::get_theme_option( 'sidebar_link_color_hover' );
		$sidebar_font_size_desktop = Common::get_value_from_array( Options::get_theme_option( 'sidebar_font_size_desktop' ), 'value', true );
		$sidebar_font_size_tablet  = Common::get_value_from_array( Options::get_theme_option( 'sidebar_font_size_tablet' ), 'value', true );
		$sidebar_font_size_mobile  = Common::get_value_from_array( Options::get_theme_option( 'sidebar_font_size_mobile' ), 'value', true );
			
		$parser->add_rule(
			':root, .octo-layout-separated',
			array(
				'--octo-sidebar-bg-color'          => $sidebar_bg_color,
				'--octo-sidebar-font-size'         => $sidebar_font_size_desktop,
				'--octo-sidebar-font-color'        => $sidebar_font_color,
				'--octo-sidebar-link-color'        => $sidebar_link_color,
				'--octo-sidebar-link-color-hover'  => $sidebar_link_color_hover,
				'--octo-sidebar-h1-color'          => $sidebar_headings_color,
				'--octo-sidebar-h2-color'          => $sidebar_headings_color,
				'--octo-sidebar-h3-color'          => $sidebar_headings_color,
				'--octo-sidebar-h4-color'          => $sidebar_headings_color,
				'--octo-sidebar-h5-color'          => $sidebar_headings_color,
				'--octo-sidebar-h6-color'          => $sidebar_headings_color,
			),
		);
		
		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'medium', 'max-width' ) );
						
			$parser->add_rule(
				':root, .octo-layout-separated',
				array(
					'--octo-sidebar-font-size' => $sidebar_font_size_tablet,
				),
			);

		$parser->close_media_query();

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'small', 'max-width' ) );

			$parser->add_rule(
				':root, .octo-layout-separated',
				array(
					'--octo-sidebar-font-size' => $sidebar_font_size_mobile,
				),
			);

		$parser->close_media_query();
		
		/**
		 * Header
		 */
		$header_bg_color  = Options::get_theme_option( 'header_bg_color' );
		
		$parser->add_rule(
			':root',
			array(
				'--octo-header-bg-color' => $header_bg_color,
			),
		);
		
		/**
		 * Primary Menu
		 */
		$menu_bg_color   = Options::get_theme_option( 'menu_bg_color' );
		
		$parser->add_rule(
			':root',
			array(
				'--octo-menu-bg-color' => $menu_bg_color,
			),
		);
		
		/*
		 * Footer
		 */
		$footer_bg_color       = Options::get_theme_option( 'footer_bg_color' );
		$footer_headings_color    = Options::get_theme_option( 'footer_headings_color' );
		$footer_font_color        = Options::get_theme_option( 'footer_font_color' );
		$footer_link_color        = Options::get_theme_option( 'footer_link_color' );
		$footer_link_color_hover  = Options::get_theme_option( 'footer_link_color_hover' );
				
		$footer_font_size_desktop = Common::get_value_from_array( Options::get_theme_option( 'footer_font_size_desktop' ), 'value', true );
		$footer_font_size_tablet  = Common::get_value_from_array( Options::get_theme_option( 'footer_font_size_tablet' ), 'value', true );
		$footer_font_size_mobile  = Common::get_value_from_array( Options::get_theme_option( 'footer_font_size_mobile' ), 'value', true );		
			
		$parser->add_rule(
			':root',
			array(
				'--octo-footer-bg-color'         => $footer_bg_color,
				'--octo-footer-font-size'        => $footer_font_size_desktop,
				'--octo-footer-font-color'       => $footer_font_color,
				'--octo-footer-link-color'       => $footer_link_color,
				'--octo-footer-link-color-hover' => $footer_link_color_hover,
				'--octo-footer-h1-color'         => $footer_headings_color,
				'--octo-footer-h2-color'         => $footer_headings_color,
				'--octo-footer-h3-color'         => $footer_headings_color,
				'--octo-footer-h4-color'         => $footer_headings_color,
				'--octo-footer-h5-color'         => $footer_headings_color,
				'--octo-footer-h6-color'         => $footer_headings_color,
			),
		);

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'medium', 'max-width' ) );

			$parser->add_rule(
				':root',
				array(
					'--octo-footer-font-size'      => $footer_font_size_tablet,
				),
			);

		$parser->close_media_query();

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'small', 'max-width' ) );

			$parser->add_rule(
				':root',
				array(
					'--octo-footer-font-size'      => $footer_font_size_mobile,
				),
			);

		$parser->close_media_query();
		
		/*
		 * Posts and pages
		 */
		$parser->open_media_query( 'min-width', Common::get_media_query_width( 'medium', 'min-width' ) );
		
			$parser->add_rule(
				'.editor-styles-wrapper .has-background [class*="__inner-container"], .wp-block-widget-area .editor-styles-wrapper .has-background, .editor-styles-wrapper p.has-background, .editor-styles-wrapper h1.has-background, .editor-styles-wrapper h2.has-background, .editor-styles-wrapper h3.has-background, .editor-styles-wrapper h4.has-background, .editor-styles-wrapper h5.has-background, .editor-styles-wrapper h6.has-background, .editor-styles-wrapper .wp-block-columns.has-background',
				array(
					'padding' => '40px',
				),
			);

			$parser->add_rule(
				'.editor-styles-wrapper .wp-block-cover [class*="__inner-container"], .editor-styles-wrapper :is([data-align="wide"], [data-align="full"]) .has-background [class*="__inner-container"]',
				array(
					'padding' => '40px 20px',
				),
			);
		$parser->add_rule(
				'[data-align="full"] .wp-block-columns .wp-block-column > :not(.has-background)',
				array(
					'padding-left' => '40px',
					'padding-right' => '40px',
				),
			);

		$parser->close_media_query();
		
		return apply_filters( 'octo_block_editor_inline_css', $parser->get_parsed_css() );

	}

	/**
	 * Returns the sidebar layout for the block editor.
	 *
	 * @since 1.0.0
	 * Return String custom stylesheet
	 */
	private static function get_sidebar_layout() {

		// Get selected sidebar layout from metabox settings.
		$meta_sidebar_layout = get_post_meta( get_the_ID(), 'octo_sidebar_layout', true );

		// If metabox settings are set, then overwrite the sidebar settings from the customizer settings.
		if ( 'default' !== $meta_sidebar_layout && $meta_sidebar_layout ) {
			$sidebar_layout = $meta_sidebar_layout;
		} else {

			// Get customizer settings for the sidebar layout.
			$sidebar_layout_default = Options::get_theme_option( 'sidebar_layout' );
			$sidebar_layout         = $sidebar_layout_default;

			$post_type = Common::get_current_post_type();

			if ( 'page' === $post_type || 'post' === $post_type ) {
				// Get sidebar layout for pages or posts.
				$sidebar_layout_singular = Options::get_theme_option( 'sidebar_layout_' . $post_type );

				// Overwrite the global customizer settings, if sidebar layout for page or post is set.
				if ( 'default' !== $sidebar_layout_singular ) {
					$sidebar_layout = $sidebar_layout_singular;
				}
			}
		}

		return $sidebar_layout;

	}

	/**
	 * Calculates the content width depending on different theme settings.
	 *
	 * @since 1.0.0
	 * Return String custom stylesheet
	 */
	private static function get_content_width() {

		$container_layout      = Options::get_theme_option( 'container_layout' );
		$container_width       = Common::get_value_from_array( Options::get_theme_option( 'container_width' ), 'value' );
		$content_layout        = get_post_meta( get_the_ID(), 'octo_content_layout', true );
		$sidebar_layout        = self::get_sidebar_layout();
		$sidebar_width         = Common::get_value_from_array( Options::get_theme_option( 'sidebar_width' ), 'value' );
		$sidebar_margin        = Common::get_sidebar_separator_spacing();
		$outer_content_spacing = Common::get_outer_content_spacing();
		$inner_content_spacing = Common::get_inner_content_spacing();

		if ( 'full_width' === $content_layout ) {
			$content_width = '100%';
		} else {
			if ( 'disabled' === $sidebar_layout || ! $sidebar_layout ) {
				$content_width = $container_width - ( $outer_content_spacing + $inner_content_spacing ) . 'px';
			} else {
				$content_width = ( ( $container_width - $outer_content_spacing ) / 100 * ( 100 - $sidebar_width ) - ( $sidebar_margin + $inner_content_spacing ) ) . 'px';
			}
		}

		return esc_attr( $content_width );

	}

	/**
	 * Returns custom stylesheet.
	 *
	 * @since 1.0.0
	 * Return String Custom stylesheet
	 */
	public static function get_style() {

		return self::create_stylesheet();

	}

}
