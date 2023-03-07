<?php
/**
 * Template Parts class.
 *
 * @package octo
 * @since 1.0.7
 */

namespace octo\frontend;

use octo\options\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class loads specific template partials.
 *
 * @since 1.0.7
 */
class Template_Parts {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.7
	 */
	public function init() {
		
		add_action( 'octo_header', array( 'octo\frontend\Template_Parts', 'load_header' ) );
		add_action( 'octo_footer', array( 'octo\frontend\Template_Parts', 'load_footer' ) );
	}

	/**
	 * Print template partials for the header.
	 *
	 * @since 1.0.7
	 */
	public static function load_header() {

		get_template_part( 'template-parts/header/site-header' );

	}

	/**
	 * Print template partials for the footer.
	 *
	 * @since 1.0.7
	 */
	public static function load_footer() {

		get_template_part( 'template-parts/footer/site-footer' );

	}
	
	/**
	 * Print template partials for the primary menu.
	 *
	 * @since 1.0.7
	 */
	public static function load_primary_menu() {

		get_template_part( 'template-parts/header/primary-menu' );

	}
	
	/**
	 * Print template partials for the mobile menu.
	 *
	 * @since 1.0.7
	 */
	public static function load_mobile_menu() {
		
		$mobile_menu_style = Options::get_theme_option( 'mobile_menu_style' );
		
		if ( ! isset( $mobile_menu_style ) || 'dropdown' === $mobile_menu_style ) {
			get_template_part( 'template-parts/header/mobile-menu' );	
		} else {
			do_action( 'octo_load_template_mobile_menu' );
		}
		
	}
	
	/**
	 * Print template partials for the menu toggle button.
	 *
	 * @since 1.0.7
	 */
	public static function load_menu_toggle_button() {

		get_template_part( 'template-parts/header/menu-toggle-button' );

	}
	
	/**
	 * Print template partials for the site branding.
	 *
	 * @since 1.0.7
	 */
	public static function load_site_branding() {
		
		$tp_header = Options::get_theme_option( 'tp_header' );
		
		if( ! isset( $tp_header ) || 'disabled' === $tp_header ) {
			get_template_part( 'template-parts/header/site-branding' );	
		} else {
			do_action( 'octo_load_template_site_branding' );
		}		

	}
	
	/**
	 * Print template partials for the header widget area.
	 *
	 * @since 1.0.7
	 */
	public static function load_header_widget_area() {

		get_template_part( 'template-parts/header/widget-area' );

	}
	
	/**
	 * Print template partials for the header inner area.
	 *
	 * @since 1.0.7
	 */
	public static function load_main_header() {
		
		$header_layout = Options::get_theme_option( 'header_layout' );

		if ( 'nav_inline' === $header_layout ) {
			$file = 'template-parts/header/nav-inline';
		} elseif ( 'nav_top' === $header_layout ) {
			$file = 'template-parts/header/nav-top';
		} elseif ( 'nav_bottom' === $header_layout ) {
			$file = 'template-parts/header/nav-bottom';
		}
		
		if ( isset( $file ) ) {
			get_template_part( $file );
		} else {
			do_action( 'octo_load_template_header_layout', $header_layout );
		}

	}
	
	/**
	 * Print template partials for the content.
	 *
	 * @since 1.0.7
	 */
	public static function load_content( $template ) {

		if ( 'index' === $template || 'archive' === $template ) {
			$post_format = get_post_format();
			if ( $post_format ) {
				$template = $post_format;
			} else {
				$template = get_post_type();	
			}
		}

		get_template_part( 'template-parts/content', $template );

	}

}
