<?php
/**
 * Theme_Style class
 *
 * This class is responsible for creating the custom stylesheet for the theme.
 *
 * @package octo
 * @since 1.0.0
 */

namespace octo\style;

use octo\style\CSSParser;
use octo\options\Options;
use octo\helper\Common;
use octo\admin\Metabox;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * Creates stylesheet for inline css.
 *
 * @since 1.0.0
 */
class Theme_Style {

	/**
	 * Build custom stylesheet for the theme.
	 *
	 * @since  1.0.0
	 * @return String Custom styleseheet.
	 */
	private static function create_stylesheet() {

		// Get new CSSParser object.
		$parser = new CSSParser();

		/**
		 * Site layout
		 */
		$container_width  = Common::get_value_from_array( Options::get_theme_option('container_width'), 'value', true );
		$body_bg_color    = Options::get_theme_option( 'body_bg_color' );
		$content_bg_color = Options::get_theme_option( 'content_bg_color' );

		$parser->add_rule(
			':root',
			array(
				'--octo-container-width'  => $container_width,
			)
		);

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

		$parser->add_rule(
			':root',
			array(
				'--octo-body-bg-image'             => 'url("' . $body_bg_image . '")',
				'--octo-body-bg-image-size'        => $body_bg_image_size,
				'--octo-body-bg-image-repeat'      => ( ( $body_bg_image_repeat ) ? 'repeat' : 'no-repeat' ),
				'--octo-body-bg-image-attachement' => ( ( $body_bg_image_image_attachement ) ? 'fixed' : 'scroll' ),
				'--octo-body-bg-image-position'    => $body_bg_image_position,
				'--octo-body-bg-color'             => $body_bg_color,
				'--octo-content-bg-color'          => $content_bg_color,
			)
		);

		/**
		 * Sidebar
		 */
		$sidebar_width             = Common::get_value_from_array( Options::get_theme_option( 'sidebar_width' ), 'value', true );
		$sidebar_breakpoint        = Options::get_theme_option( 'sidebar_breakpoint' );
		$sidebar_separator_spacing = Common::get_value_from_array( Options::get_theme_option( 'sidebar_separator_spacing' ), 'value', true );
		$sidebar_separator         = Options::get_theme_option( 'sidebar_separator' );
		$sidebar_bg_color          = Options::get_theme_option( 'sidebar_bg_color' );
		$sidebar_headings_color    = Options::get_theme_option( 'sidebar_headings_color' );
		$sidebar_font_color        = Options::get_theme_option( 'sidebar_font_color' );
		$sidebar_link_color        = Options::get_theme_option( 'sidebar_link_color' );
		$sidebar_link_color_hover  = Options::get_theme_option( 'sidebar_link_color_hover' );
		$sidebar_font_size_desktop = Common::get_value_from_array( Options::get_theme_option( 'sidebar_font_size_desktop' ), 'value', true );
		$sidebar_font_size_tablet  = Common::get_value_from_array( Options::get_theme_option( 'sidebar_font_size_tablet' ), 'value', true );
		$sidebar_font_size_mobile  = Common::get_value_from_array( Options::get_theme_option( 'sidebar_font_size_mobile' ), 'value', true );

		$parser->add_rule(
			':root',
			array(
				'--octo-sidebar-width'            => $sidebar_width,
				'--octo-sidebar-bg-color'         => $sidebar_bg_color,
				'--octo-sidebar-font-size'        => $sidebar_font_size_desktop,
				'--octo-sidebar-font-color'       => $sidebar_font_color,
				'--octo-sidebar-link-color'       => $sidebar_link_color,
				'--octo-sidebar-link-color-hover' => $sidebar_link_color_hover,
				'--octo-sidebar-h1-color'         => $sidebar_headings_color,
				'--octo-sidebar-h2-color'         => $sidebar_headings_color,
				'--octo-sidebar-h3-color'         => $sidebar_headings_color,
				'--octo-sidebar-h4-color'         => $sidebar_headings_color,
				'--octo-sidebar-h5-color'         => $sidebar_headings_color,
				'--octo-sidebar-h6-color'         => $sidebar_headings_color,
			)
		);

		$parser->open_media_query( 'min-width', Common::get_media_query_width( $sidebar_breakpoint, 'min-width' ) );

			$parser->add_rule(
				':root',
				array(
					'--octo-sidebar-separator-spacing' => $sidebar_separator_spacing,
				)
			);

			$parser->add_rule(
				'.sidebar .site-content .site-container-inner',
				array(
					'display'     => 'flex',
					'align-items' => 'flex-start',
				)
			);

			$parser->add_rule(
				'.sidebar .site-content .site-container-inner #primary',
				array(
					'width' => 'calc(100% - var(--octo-sidebar-width))',
				)
			);

			$parser->add_rule(
				'.sidebar .site-content .site-container-inner #secondary',
				array(
					'width' => 'var(--octo-sidebar-width)',
				)
			);

			if ( $sidebar_separator ) {
				$parser->add_rule(
					'.octo-sidebar-right #primary, .octo-sidebar-left #secondary',
					array(
						'border-right' => '1px solid var(--octo-separator-color)',
					)
				);

				$parser->add_rule(
					'.octo-sidebar-left #primary, .octo-sidebar-right #secondary',
					array(
						'border-left' => '1px solid var(--octo-separator-color)',
					)
				);

				$parser->add_rule(
					'.octo-sidebar-left #secondary',
					array(
						'margin-right' => '-1px',
					)
				);

				$parser->add_rule(
					'.octo-sidebar-right #secondary',
					array(
						'margin-left' => '-1px',
					)
				);

			}

		$parser->close_media_query();
		
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

			$parser->add_rule(
				'.sidebar #secondary',
				array(
					'margin' => '3em 0 0 0',
				)
			);

			$parser->add_rule(
				'.octo-layout-separated',
				array(
					'--octo-sidebar-spacing-top'    => '24px',
					'--octo-sidebar-spacing-right'  => '24px',
					'--octo-sidebar-spacing-left'   => '24px',
					'--octo-sidebar-spacing-bottom' => '24px',
				)
			);

		$parser->close_media_query();
		
		/**
		 * Header layout
		 */
		$header_layout                     = Options::get_theme_option( 'header_layout' );
		$header_bg_color                   = Options::get_theme_option( 'header_bg_color' );
		$header_widget_width               = Options::get_theme_option( 'header_widget_width' ) . '%';
		$header_enable_widgets             = Options::get_theme_option( 'header_enable_widgets' );
		$header_border_bottom_width        = Common::get_value_from_array( Options::get_theme_option( 'header_border_bottom_width' ), 'value', true );
		$header_border_bottom_color        = Options::get_theme_option( 'header_border_bottom_color' );
		$logo_width_desktop                = Common::get_value_from_array( Options::get_theme_option( 'logo_width_desktop' ), 'value', true );
		$logo_width_tablet                 = Common::get_value_from_array( Options::get_theme_option( 'logo_width_tablet' ), 'value', true );
		$logo_width_mobile                 = Common::get_value_from_array( Options::get_theme_option( 'logo_width_mobile' ), 'value', true );
		$mobile_logo_width                 = Common::get_value_from_array( Options::get_theme_option( 'mobile_logo_width' ), 'value', true );
		$header_bg_image                   = Options::get_theme_option( 'header_bg_image' );
		$header_bg_image_size              = Options::get_theme_option( 'header_bg_image_size' );
		$header_bg_image_repeat            = Options::get_theme_option( 'header_bg_image_repeat' );
		$header_bg_image_image_attachement = Options::get_theme_option( 'header_bg_image_attachement' );
		$header_bg_image_position          = Options::get_theme_option( 'header_bg_image_position' );

		$parser->add_rule(
			':root',
			array(
				'--octo-header-bg-color'            => $header_bg_color,
				'--octo-header-border-bottom-width' => $header_border_bottom_width,
				'--octo-header-border-bottom-color' => $header_border_bottom_color,
				'--octo-custom-logo-width'          => $logo_width_desktop,
				'--octo-custom-logo-mobile-width'   => $mobile_logo_width,
				'--octo-header-bg-image'             => 'url("' . $header_bg_image . '")',
				'--octo-header-bg-image-size'        => $header_bg_image_size,
				'--octo-header-bg-image-repeat'      => ( ( $header_bg_image_repeat ) ? 'repeat' : 'no-repeat' ),
				'--octo-header-bg-image-attachement' => ( ( $header_bg_image_image_attachement ) ? 'fixed' : 'scroll' ),
				'--octo-header-bg-image-position'    => $header_bg_image_position,
				'--octo-header-bg-color'             => $header_bg_color,
			),
		);

		if ( 'disabled' !== $header_enable_widgets ) {
			$parser->open_media_query( 'min-width', Common::get_media_query_width( $header_enable_widgets, 'min-width' ) );

				$parser->add_rule(
					'.main-header .header-widget-area',
					array(
						'display'     => 'flex',
					)
				);

			$parser->close_media_query();
		}

		$parser->open_media_query( 'min-width', Common::get_media_query_width( 'small', 'min-width' ) );

			$parser->add_rule(
				'.octo-has-mobile-logo .custom-logo-link',
				array(
					'display' => 'flex',
				)
			);

			$parser->add_rule(
				'.octo-has-mobile-logo .custom-logo-link.mobile',
				array(
					'display' => 'none',
				)
			);

		$parser->close_media_query();

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'medium', 'max-width' ) );

			$parser->add_rule(
				':root',
				array(
					'--octo-custom-logo-width' => $logo_width_tablet,
				),
			);

		$parser->close_media_query();

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'small', 'max-width' ) );

			$parser->add_rule(
				':root',
				array(
					'--octo-custom-logo-width' => $logo_width_mobile,
				),
			);

		$parser->close_media_query();
		
		/**
		 * Site identity
		 */
		$title_font_size_desktop   = Common::get_value_from_array( Options::get_theme_option( 'title_font_size_desktop' ), 'value', true );
		$title_font_size_tablet    = Common::get_value_from_array( Options::get_theme_option( 'title_font_size_tablet' ), 'value', true );
		$title_font_size_mobile    = Common::get_value_from_array( Options::get_theme_option( 'title_font_size_mobile' ), 'value', true );
		$tagline_font_size_desktop = Common::get_value_from_array( Options::get_theme_option( 'tagline_font_size_desktop' ), 'value', true );
		$tagline_font_size_tablet  = Common::get_value_from_array( Options::get_theme_option( 'tagline_font_size_tablet' ), 'value', true );
		$tagline_font_size_mobile  = Common::get_value_from_array( Options::get_theme_option( 'tagline_font_size_mobile' ), 'value', true );
		$title_font_family         = Common::get_font_family( Options::get_theme_option( 'title_font_family' ) );
		$title_font_weight         = Common::get_font_weight( Options::get_theme_option( 'title_font_variant' ) );
		$title_font_style          = Common::get_font_style( Options::get_theme_option( 'title_font_variant' ) );
		$title_text_transform      = Options::get_theme_option( 'title_text_transform' );
		$title_font_color          = Options::get_theme_option( 'title_font_color' );
		$title_font_color_hover    = Options::get_theme_option( 'title_font_color_hover' );
		$stagline_font_color       = Options::get_theme_option( 'tagline_font_color' );

		$parser->add_rule(
			':root',
			array(
				'--octo-title-font-size'        => $title_font_size_desktop,
				'--octo-title-text-transform'   => $title_text_transform,
				'--octo-title-font-family'      => $title_font_family,
				'--octo-title-font-weight'      => $title_font_weight,
				'--octo-title-font-style'       => $title_font_style,
				'--octo-title-link-color'       => $title_font_color,
				'--octo-title-link-color-hover' => $title_font_color_hover,
				'--octo-tagline-font-size'      => $tagline_font_size_desktop,
				'--octo-tagline-font-color'     => $stagline_font_color,
			)
		);

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'medium', 'max-width' ) );

			$parser->add_rule(
				':root',
				array(
					'--octo-title-font-size'   => $title_font_size_tablet,
					'--octo-tagline-font-size' => $tagline_font_size_tablet,
				)
			);

		$parser->close_media_query();

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'small', 'max-width' ) );

			$parser->add_rule(
				':root',
				array(
					'--octo-title-font-size'   => $title_font_size_mobile,
					'--octo-tagline-font-size' => $tagline_font_size_mobile,
				)
			);

		$parser->close_media_query();

		/**
		 * Primave Navigation
		 */
		$menu_item_height         = Common::get_value_from_array( Options::get_theme_option( 'menu_item_height' ), 'value', true );
		$menu_item_width          = Common::get_value_from_array( Options::get_theme_option( 'menu_item_width' ), 'value', true );
		$submenu_item_height      = Common::get_value_from_array( Options::get_theme_option( 'submenu_item_height' ), 'value', true );
		$submenu_width            = Common::get_value_from_array( Options::get_theme_option( 'submenu_width' ), 'value', true );
		$mobile_menu_breakpoint   = Options::get_theme_option( 'mobile_menu_breakpoint' );
		$menu_font_size           = Common::get_value_from_array( Options::get_theme_option( 'menu_font_size' ), 'value', true );
		$menu_font_family         = Common::get_font_family( Options::get_theme_option( 'menu_font_family' ) );
		$menu_font_weight         = Common::get_font_weight( Options::get_theme_option( 'menu_font_variant' ) );
		$menu_font_style          = Common::get_font_style( Options::get_theme_option( 'menu_font_variant' ) );
		$menu_text_transform      = Options::get_theme_option( 'menu_text_transform' );
		$submenu_font_size        = Common::get_value_from_array( Options::get_theme_option( 'submenu_font_size' ), 'value', true );
		$submenu_font_family      = Common::get_font_family( Options::get_theme_option( 'submenu_font_family' ) );
		$submenu_font_weight      = Common::get_font_weight( Options::get_theme_option( 'submenu_font_variant' ) );
		$submenu_font_style       = Common::get_font_style( Options::get_theme_option( 'submenu_font_variant' ) );
		$submenu_font_size        = Common::get_value_from_array( Options::get_theme_option( 'submenu_font_size' ), 'value', true );
		$submenu_text_transform   = Options::get_theme_option( 'submenu_text_transform' );
		$menu_bg_color            = Options::get_theme_option( 'menu_bg_color' );
		$submenu_bg_color         = Options::get_theme_option( 'submenu_bg_color' );
		$menu_link_color          = Options::get_theme_option( 'menu_link_color' );
		$menu_link_color_hover    = Options::get_theme_option( 'menu_link_color_hover' );
		$submenu_link_color       = Options::get_theme_option( 'submenu_link_color' );
		$submenu_link_color_hover = Options::get_theme_option( 'submenu_link_color_hover' );

		$parser->add_rule(
			':root',
			array(
				'--octo-menu-item-width'          => $menu_item_width,
				'--octo-menu-item-height'         => $menu_item_height,
				'--octo-submenu-item-height'      => $submenu_item_height,
				'--octo-submenu-width'            => $submenu_width,
				'--octo-menu-bg-color'            => $menu_bg_color,
				'--octo-submenu-bg-color'         => $submenu_bg_color,
				'--octo-menu-font-family'         => $menu_font_family,
				'--octo-menu-font-weight'         => $menu_font_weight,
				'--octo-menu-font-style'          => $menu_font_style,
				'--octo-menu-font-size'           => $menu_font_size,
				'--octo-menu-text-transform'      => $menu_text_transform,
				'--octo-menu-link-color'          => $menu_link_color,
				'--octo-menu-link-color-hover'    => $menu_link_color_hover,
				'--octo-submenu-font-family'      => $submenu_font_family,
				'--octo-submenu-font-weight'      => $submenu_font_weight,
				'--octo-submenu-font-style'       => $submenu_font_style,
				'--octo-submenu-font-size'        => $submenu_font_size,
				'--octo-submenu-text-transform'   => $submenu_text_transform,
				'--octo-submenu-link-color'       => $submenu_link_color,
				'--octo-submenu-link-color-hover' => $submenu_link_color_hover,
			)
		);

		$parser->open_media_query( 'min-width', Common::get_media_query_width( $mobile_menu_breakpoint, 'min-width' ) );

			$parser->add_rule(
				':is( .octo-nav-inline, .octo-nav-top, .octo-nav-bottom ) .menu-toggle, :is( .octo-nav-inline, .octo-nav-top, .octo-nav-bottom ) .mobile-navigation',
				array(
					'display' => 'none',
				)
			);

			$parser->add_rule(
				':is( .octo-nav-inline, .octo-nav-top, .octo-nav-bottom ) .main-navigation',
				array(
					'display' => 'block',
				)
			);

		$parser->close_media_query();
		
		/**
		 * Mobile Navigation
		 */
		$mobile_menu_item_width          = Common::get_value_from_array( Options::get_theme_option( 'mobile_menu_item_width' ), 'value', true );
		$mobile_menu_item_height         = Common::get_value_from_array( Options::get_theme_option( 'mobile_menu_item_height' ), 'value', true );
		$mobile_menu_font_size           = Common::get_value_from_array( Options::get_theme_option( 'mobile_menu_font_size' ), 'value', true );
		$mobile_menu_bg_color            = Options::get_theme_option( 'mobile_menu_bg_color' );
		$mobile_menu_link_color          = Options::get_theme_option( 'mobile_menu_link_color' );
		$mobile_menu_link_color_hover    = Options::get_theme_option( 'mobile_menu_link_color_hover' );
		$mobile_submenu_bg_color         = Options::get_theme_option( 'mobile_submenu_bg_color' );
		$mobile_submenu_link_color       = Options::get_theme_option( 'mobile_submenu_link_color' );
		$mobile_submenu_link_color_hover = Options::get_theme_option( 'mobile_submenu_link_color_hover' );
		
		$parser->add_rule(
			':root',
			array(
				'--octo-mobile-menu-item-width'          => $mobile_menu_item_width,
				'--octo-mobile-menu-item-height'         => $mobile_menu_item_height,
				'--octo-mobile-menu-bg-color'            => $mobile_menu_bg_color,
				'--octo-mobile-menu-font-size'           => $mobile_menu_font_size,
				'--octo-mobile-submenu-bg-color'         => $mobile_submenu_bg_color,
				'--octo-mobile-menu-link-color'          => $mobile_menu_link_color,
				'--octo-mobile-menu-link-color-hover'    => $mobile_menu_link_color_hover,
				'--octo-mobile-submenu-link-color'       => $mobile_submenu_link_color,
				'--octo-mobile-submenu-link-color-hover' => $mobile_submenu_link_color_hover,
			)
		);
	
		/**
		 * Footer
		 */
		$footer_bg_color          = Options::get_theme_option( 'footer_bg_color' );
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
					'--octo-footer-font-size' => $footer_font_size_tablet,
				),
			);

		$parser->close_media_query();

		$parser->open_media_query( 'min-width', Common::get_media_query_width( 'small', 'min-width' ) );

			$parser->add_rule(
				'.main-footer .site-container-inner',
				array(
					'display'   => 'flex',
					'flex-wrap' => 'wrap',
				)
			);

			$parser->add_rule(
				'.main-footer .site-container-inner > div:not(:last-child)',
				array(
					'margin-right' => '3rem',
				)
			);

			$parser->add_rule(
				'.main-footer .footer-widget-area',
				array(
					'flex' => '1 1 0',
				)
			);

		$parser->close_media_query();

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'small', 'max-width' ) );
		
			$parser->add_rule(
				':root',
				array(
					'--octo-footer-font-size' => $footer_font_size_mobile,
				),
			);

			$parser->add_rule(
				'.main-footer .site-container-inner > div:not(:last-child)',
				array(
					'margin-bottom' => '2.5rem',
				)
			);

		$parser->close_media_query();

		/**
		 * Typography
		 */
		$body_font_family                 = Common::get_font_family( Options::get_theme_option( 'body_font_family' ) );
		$body_font_weight                 = Common::get_font_weight( Options::get_theme_option( 'body_font_variant' ) );
		$body_font_style                  = Common::get_font_style( Options::get_theme_option( 'body_font_variant' ) );
		$body_font_size_desktop           = Common::get_value_from_array( Options::get_theme_option( 'body_font_size_desktop' ), 'value', true );
		$body_font_size_tablet            = Common::get_value_from_array( Options::get_theme_option( 'body_font_size_tablet' ), 'value', true );
		$body_font_size_mobile            = Common::get_value_from_array( Options::get_theme_option( 'body_font_size_mobile' ), 'value', true );
		$body_line_height                 = Options::get_theme_option( 'body_line_height' );
		$body_text_transform              = Options::get_theme_option( 'body_text_transform' );
		$paragraph_spacing                = Common::get_value_from_array( Options::get_theme_option( 'paragraph_spacing' ), 'value', true );
		$body_font_color                  = Options::get_theme_option( 'body_font_color' );
		$body_link_color                  = Options::get_theme_option( 'body_link_color' );
		$body_link_color_hover            = Options::get_theme_option( 'body_link_color_hover' );
		$headings_font_family             = Common::get_font_family( Options::get_theme_option( 'headings_font_family' ) );
		$headings_font_weight             = Common::get_font_weight( Options::get_theme_option( 'headings_font_variant' ) );
		$headings_font_style              = Common::get_font_style( Options::get_theme_option( 'headings_font_variant' ) );
		$headings_line_height             = Options::get_theme_option( 'headings_line_height' );
		$headings_text_transform          = Options::get_theme_option( 'headings_text_transform' );
		$headings_spacing                 = Common::get_value_from_array( Options::get_theme_option( 'headings_spacing' ), 'value', true );
		$headings_font_color              = Options::get_theme_option( 'headings_font_color', 'inherit' );
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
				'--octo-body-font-color'                 => $body_font_color,
				'--octo-body-font-size'                  => $body_font_size_desktop,
				'--octo-body-line-height'                => $body_line_height,
				'--octo-body-font-style'                 => $body_font_weight,
				'--octo-body-font-weight'                => $body_font_style,
				'--octo-body-text-transform'             => $body_text_transform,
				'--octo-body-font-family'                => $body_font_family,
				'--octo-headings-color'                  => $headings_font_color,
				'--octo-headings-font-weight'            => $headings_font_weight,
				'--octo-headings-font-style'             => $headings_font_style,
				'--octo-headings-font-family'            => $headings_font_family,
				'--octo-headings-line-height'            => $headings_line_height,
				'--octo-headings-text-transform'         => $headings_text_transform,
				'--octo-body-link-color'                 => $body_link_color,
				'--octo-body-link-color-hover'           => $body_link_color_hover,
				'--octo-paragraph-spacing'               => $paragraph_spacing,
				'--octo-headings-spacing'                => $headings_spacing,
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
					'--octo-body-font-size'           => $body_font_size_tablet,
					'--octo-h1-font-size'             => $h1_font_size_tablet,
					'--octo-h1-entry-title-font-size' => $h1_entry_title_font_size_tablet,
					'--octo-h2-font-size'             => $h2_font_size_tablet,
					'--octo-h2-entry-title-font-size' => $h2_entry_title_font_size_tablet,
					'--octo-h3-font-size'             => $h3_font_size_tablet,
					'--octo-h4-font-size'             => $h4_font_size_tablet,
					'--octo-h5-font-size'             => $h5_font_size_tablet,
					'--octo-h6-font-size'             => $h6_font_size_tablet,
				),
			);

		$parser->close_media_query();

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'small', 'max-width' ) );

			$parser->add_rule(
				':root',
				array(
					'--octo-body-font-size'           => $body_font_size_mobile,
					'--octo-h1-font-size'             => $h1_font_size_mobile,
					'--octo-h1-entry-title-font-size' => $h1_entry_title_font_size_mobile,
					'--octo-h2-font-size'             => $h2_font_size_mobile,
					'--octo-h2-entry-title-font-size' => $h2_entry_title_font_size_mobile,
					'--octo-h3-font-size'             => $h3_font_size_mobile,
					'--octo-h4-font-size'             => $h4_font_size_mobile,
					'--octo-h5-font-size'             => $h5_font_size_mobile,
					'--octo-h6-font-size'             => $h6_font_size_mobile,
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

		/**
		 * Alignment
		 */
		$parser->open_media_query( 'min-width', Common::get_media_query_width( 'medium', 'min-width' ) );

			$parser->add_rule(
				'.octo-layout-full.octo-no-sidebar:not(.octo-content-full-width, [class*="octo-blog-columns-"]) .site-main article:not(.has-post-thumbnail[class*="octo-thumbnail-"]) .alignwide',
				array(
					'margin-left'  => 'calc(-34vw + 50%)',
					'margin-right' => 'calc(-34vw + 50%)',
					'max-width'    => 'unset',
					'width'        => 'unset',
				)
			);
		
			$parser->add_rule(
				'.octo-layout-full.octo-no-sidebar:not(.octo-content-full-width, [class*="octo-blog-columns-"]) .site-main article:not([class*="octo-thumbnail-"]) [class*="wp-block-"].alignwide [class$="__inner-container"]',
				array(
					'padding-left'  => 'var(--octo-outer-content-spacing-left)',
					'padding-right' => 'var(--octo-outer-content-spacing-right)',
				)
			);

		$parser->close_media_query();

		/**
		 * Content
		 */
		$blog_container_width        = Common::get_value_from_array( Options::get_theme_option( 'blog_container_width' ), 'value', true );
		$single_post_container_width = Common::get_value_from_array( Options::get_theme_option( 'single_post_container_width' ), 'value', true );

		$parser->add_rule(
			':root',
			array(
				'--octo-container-width-archive' => $blog_container_width,
				'--octo-container-width-post'    => $single_post_container_width,
			)
		);

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'medium', 'max-width' ) );

			$parser->add_rule(
				':root',
				array(
					'--octo-featured-image-height' => '200px',
				)
			);

		$parser->close_media_query();

		$parser->open_media_query( 'max-width', Common::get_media_query_width( 'small', 'max-width' ) );

			$parser->add_rule(
				':root',
				array(
					'--octo-featured-image-height' => '100px',
				)
			);

			$parser->add_rule(
				'.octo-layout-separated',
				array(
					'--octo-inner-content-spacing-top'    => '24px',
					'--octo-inner-content-spacing-right'  => '24px',
					'--octo-inner-content-spacing-bottom' => '24px',
					'--octo-inner-content-spacing-left'   => '24px',
				)
			);

		$parser->close_media_query();

		$parser->open_media_query( 'min-width', Common::get_media_query_width( 'small', 'min-width' ) );

			$parser->add_rule(
				'.site-posts > article[class*="thumbnail-"] > .post-inner',
				array(
					'display'     => 'flex',
					'align-items' => 'flex-start',
				)
			);

			$parser->add_rule(
				'.site-posts > article[class*="thumbnail-"] .post-content',
				array(
					'flex-grow' => 1,
				)
			);

			$parser->add_rule(
				'.site-posts > article[class*="thumbnail-"] a.post-thumbnail',
				array(
					'flex-basis' => '40%',
				)
			);

			$parser->add_rule(
				'.site-posts > article[class*="thumbnail-"] .post-thumbnail',
				array(
					'margin' => '0',
				)
			);

			$parser->add_rule(
				'.site-posts > article[class*="thumbnail-"] a.post-thumbnail + div.post-content',
				array(
					'flex-basis'   => '60%',
				)
			);

			$parser->add_rule(
				'.site-posts > article.octo-thumbnail-left a.post-thumbnail + div.post-content',
				array(
					'padding-left' => '1.5rem',
				)
			);

		$parser->close_media_query();
		
		/**
		 * Posts and pages
		 */
		$parser->open_media_query( 'min-width', Common::get_media_query_width( 'medium', 'min-width' ) );
		
			$parser->add_rule(
				'p.has-background, h1.has-background, h2.has-background, h3.has-background, h4.has-background, h5.has-background, h6.has-background, .wp-block-columns.has-background',
				array(
					'padding' => '40px',
				)
			);

			$parser->add_rule(
				'.wp-block-cover [class$="__inner-container"], .has-background [class$="__inner-container"]',
				array(
					'padding-top'    => '40px',
					'padding-bottom' => '40px',
				)
			);
		
			$parser->add_rule(
				'.has-background [class$="__inner-container"], .wp-block-columns.alignfull .wp-block-column > :not(.has-background)',
				array(
					'padding-left'  => '40px',
					'padding-right' => '40px',
				)
			);
		
		$parser->close_media_query();
		
		return apply_filters( 'octo_inline_css', $parser->get_parsed_css() );

	}
	
	/**
	 * Build custom rtl stylesheet for the theme.
	 *
	 * @since  1.0.6
	 * @return String Custom styleseheet.
	 */
	private static function create_rtl_stylesheet() {

		// Get new CSSParser object.
		$parser = new CSSParser();

		/*
		 * Footer
		 */
		$parser->open_media_query( 'min-width', Common::get_media_query_width( 'small', 'min-width' ) );

			$parser->add_rule(
				'.main-footer .site-container-inner > div:not(:last-child)',
				array(
					'margin-right' => 'unset',
					'margin-left'  => '3rem',
				)
			);

		$parser->close_media_query();
		
		return apply_filters( 'octo_inline_css_rtl', $parser->get_parsed_css() );

	}

	/**
	 * Returns custom stylesheet.
	 *
	 * @since  1.0.0
	 * @return String Custom stylesheet
	 */
	public static function get_style() {

		$cache_custom_css = Options::get_theme_option( 'cache_custom_css' );

		if ( $cache_custom_css && ! is_customize_preview() ) {

			$cached_css_output = get_option( 'octo_cached_css_output' );
			$cached_css_version = get_option( 'octo_cached_css_version' );

			// Cache CSS output in database, if necessary.
			if ( ! $cached_css_output || OCTO_VERSION !== $cached_css_version ) {
				self::update_cached_css();
				$css_output = get_option( 'octo_cached_css_output' ) . '/* End Cached CSS*/';
			} else {
				$css_output = $cached_css_output . '/* End Cached CSS*/';
			}
		} else {

			$css_output = self::create_stylesheet();

			if ( is_rtl() ) {
				$css_output .= self::create_rtl_stylesheet();
			}

		}

		return $css_output;

	}

	/**
	 * Update cached CSS in the database.
	 *
	 * @since  1.0.3
	 */
	public static function update_cached_css() {

		if ( is_rtl() ) {
			update_option( 'octo_cached_css_output', self::create_stylesheet() . self::create_rtl_stylesheet() );
		} else {
			update_option( 'octo_cached_css_output', self::create_stylesheet() );
		}

		update_option( 'octo_cached_css_version', OCTO_VERSION );

	}

}
