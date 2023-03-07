<?php
/**
 * Components class.
 *
 * @package octo
 * @since 1.0.0
 */

namespace octo\frontend;

use octo\options\Options;
use octo\helper\Common;
use octo\admin\Metabox;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class creates html code for different components.
 * It is also responsible for setting the class html attribute for the header, navigation and footer.
 *
 * @since 1.0.0
 */
class Components {
	
	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.1.0
	 */
	public function init() {
		add_filter( 'octo_before_content', array( $this, 'feature_image_before_content' ) );
	}

	/**
	 * Prints html code for custom logo.
	 *
	 * @param Int    $id Custom Logo ID.
	 * @param String $class CSS class.
	 * @param Array  $args Custom Logo attributes.
	 * @since 1.0.0
	 */
	public static function custom_logo( $id, $class, $args = array() ) {

		$defaults = array(
			'class' => '',
			'alt'   => esc_attr( get_bloginfo( 'name' ) ),
			'size'  => 'full',
		);

		$args = wp_parse_args( $args, $defaults );

		if ( $id ) {

			$attr = array(
				'class' => $args['class'],
				'alt'   => $args['alt'],
			);

			// Change logo size for frontend html.
			if ( is_customize_preview() ) {
				$args['size'] = 'full';
			}

			$image = wp_get_attachment_image( $id, $args['size'], '', $attr );

			$html = sprintf(
				'<a href="%1$s" class="%2$s" rel="home">
					%3$s
				</a>',
				esc_url( home_url( '/' ) ),
				esc_attr( $class ),
				$image
			);

			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		}

	}
	
	/**
	 * Creates html class attribute for the header.
	 *
	 * @since 1.0.0
	 */
	public static function header_class() {

		$header_layout = Options::get_theme_option( 'header_layout' );		

		$classes = array( 'site-header' );
		
		// Add a class for the header alignment.
		$header_alignment = Options::get_theme_option( 'header_alignment' );

		if ( 'nav_top' === $header_layout || 'nav_bottom' === $header_layout ) {
			switch ( $header_alignment ) {
				case 'left':
					$classes[] = 'octo-main-header-align-left';
					break;
				case 'center':
					$classes[] = 'octo-main-header-align-center';
					break;
				case 'right':
					$classes[] = 'octo-main-header-align-right';
					break;
			}

		}

		// Add a class for the header width.
		$header_width = Options::get_theme_option( 'header_width' );
		
		switch ( $header_width ) {
			case 'full':
				$classes[] = 'octo-full-width';
				break;
			case 'content':
				$classes[] = 'octo-content-width';
				break;
		}
		
		// Add a class, if mobile logo is set.
		$mobile_logo = Options::get_theme_option( 'mobile_logo' );

		if ( ! empty( $mobile_logo ) ) {
			$classes[] = 'octo-has-mobile-logo';
		}
		
		// Add a class for navigation alignment.
		$nav_alignment = Options::get_theme_option( 'nav_alignment' );
		
		if ( 'nav_top' === $header_layout || 'nav_bottom' === $header_layout ) {
		switch ( $nav_alignment ) {
			case 'left':
				$classes[] = 'octo-nav-align-left';
				break;
			case 'center':
				$classes[] = 'octo-nav-align-center';
				break;
			case 'right':
				$classes[] = 'octo-nav-align-right';
				break;
			}
		}

		$classes = apply_filters( 'octo_header_classes', $classes );
		$classes = array_unique( $classes );
		$classes = array_map( 'sanitize_html_class', $classes );

		$class = join( ' ', $classes );

		echo 'class="' . esc_attr( $class ) . '"';

	}

	/**
	 * Creates html class attribute for the footer.
	 *
	 * @since 1.0.0
	 */
	public static function footer_class() {

		// Get theme settings.
		$container_layout = Options::get_theme_option( 'container_layout' );
		$footer_width     = Options::get_theme_option( 'footer_width' );

		$classes = array( '.site-footer' );

		if ( 'boxed' !== $container_layout ) {
			switch ( $footer_width ) {
				case 'full':
					$classes[] = 'octo-full-width';
					break;
				case 'content':
					$classes[] = 'octo-content-width';
					break;
			}	
		}		

		$classes = apply_filters( 'octo_footer_classes', $classes );
		$classes = array_unique( $classes );
		$classes = array_map( 'sanitize_html_class', $classes );

		$class = join( ' ', $classes );

		echo 'class="' . esc_attr( $class ) . '"';

	}

	/**
	 * Creates html class attribute for the main navigation.
	 *
	 * @since 1.0.0
	 */
	public static function main_nav_class() {

		$classes = array( 'main-navigation' );
		
		$classes = apply_filters( 'octo_main_nav_classes', $classes );
		$classes = array_unique( $classes );
		$classes = array_map( 'sanitize_html_class', $classes );

		$class = join( ' ', $classes );

		echo 'class="' . esc_attr( $class ) . '"';

	}
	
	/**
	 * Creates html class attribute for the mobile navigation.
	 *
	 * @since 1.1.0
	 */
	public static function mobile_nav_class() {

		$classes = array( 'mobile-navigation' );
		
		$classes = apply_filters( 'octo_mobile_nav_classes', $classes );
		$classes = array_unique( $classes );
		$classes = array_map( 'sanitize_html_class', $classes );

		$class = join( ' ', $classes );

		echo 'class="' . esc_attr( $class ) . '"';

	}

	/**
	 * Creates a breadcrump trail.
	 *
	 * @since 1.0.0
	 */
	public static function breadcrumb_trail() {

		// Get settings for breadcrumbs.
		$breadcrumbs             = Options::get_theme_option( 'breadcrumbs' );
		$disable_breadcrumbs_front_page = Options::get_theme_option( 'disable_breadcrumbs_front_page' );
		$disable_breadcrumbs_page       = Options::get_theme_option( 'disable_breadcrumbs_page' );
		$disable_breadcrumbs_blog       = Options::get_theme_option( 'disable_breadcrumbs_blog' );
		$disable_breadcrumbs_single     = Options::get_theme_option( 'disable_breadcrumbs_single' );
		$disable_breadcrumbs_archive    = Options::get_theme_option( 'disable_breadcrumbs_archive' );
		$disable_breadcrumbs_search     = Options::get_theme_option( 'disable_breadcrumbs_search' );
		$disable_breadcrumbs_404        = Options::get_theme_option( 'disable_breadcrumbs_404' );
		$breadcrumbs_separator          = Options::get_theme_option( 'breadcrumbs_separator' );

		// Get metabox settings.
		$disable_breadcrumbs_meta = Metabox::get_meta_option( 'octo_disable_breadcrumbs' );

		// Create new breadcrumb object.
		$args = array(
			'show_browse' => false,
			'list_tag'    => 'div',
			'item_tag'    => 'span',
			'separator'   => esc_html( $breadcrumbs_separator ),
		);

		$breadcrumb = apply_filters( 'octo_breadcrumb_trail_object', null, $args );

		if ( ! is_object( $breadcrumb ) ) {
			$breadcrumb = new Breadcrumb_Trail( $args );
		}

		// Only show breadcrumbs, if not disabled for a specific element.
		if ( ! $disable_breadcrumbs_meta && 'disabled' !== $breadcrumbs && (
				( is_front_page() && ! $disable_breadcrumbs_front_page ) ||
				( ! is_front_page() && is_page() && ! $disable_breadcrumbs_page ) ||
				( ! is_front_page() && is_home() && ! $disable_breadcrumbs_blog ) ||
				( ! is_front_page() && is_single() && ! $disable_breadcrumbs_single ) ||
				( ! is_front_page() && is_archive() && ! $disable_breadcrumbs_archive ) ||
				( ! is_front_page() && is_search() && ! $disable_breadcrumbs_search ) ||
				( ! is_front_page() && is_404() && ! $disable_breadcrumbs_404 )
			)
		) {
			$breadcrumb_trail = $breadcrumb->trail();
		}

	}

	/**
	 * Prints the theme credits.
	 *
	 * @since 1.0.0
	 */
	public static function credits() {

		$display = apply_filters( 'octo_display_credits', true );

		if ( $display ) {
			$credits = '&copy; ' . gmdate( 'Y' ) . ' ' . get_bloginfo( 'name' ) . ' - ' . esc_html__( 'Proudly powered by theme ', 'octo' ) . '<a href="">Octo</a>';

			$html = sprintf(
				'<div class="site-credits">
					%s
				</div><!-- .site-credits -->',
				$credits
			);

			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		}

	}

	/**
	 * Prints the posts pagination.
	 *
	 * @since 1.0.0
	 */
	public static function posts_pagination() {
		
		$class = apply_filters( 'octo_pagination_class', 'pagination' );

		$args = array(
			'prev_text' => Common::get_icon( 'arrow_left' ) . esc_HTML__( 'Older Posts', 'octo' ),
			'next_text' => esc_HTML__( 'Newer Posts', 'octo' ) . Common::get_icon( 'arrow_right' ),
		);

		$html = apply_filters( 'octo_posts_pagination_markup', get_the_posts_pagination( $args ) );

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}

	/**
	 * Prints the navigation for a single post.
	 *
	 * @since 1.0.0
	 */
	public static function post_navigation() {
		
		$enable = apply_filters( 'octo_enable_post_navigation', true );
		
		if ( $enable ) {
			
			$prev_text = apply_filters( 'octo_post_navigation_prev_text', Common::get_icon( 'arrow_left' ) . esc_html__( 'Previous Post', 'octo' ) );
			$next_text = apply_filters( 'octo_post_navigation_next_text', esc_html__( 'Next Post', 'octo' ) . Common::get_icon( 'arrow_right' ) );
		
			$args = array(
				'prev_text' => $prev_text,
				'next_text' => $next_text,
			);

			$html = apply_filters( 'octo_post_navigation_markup', get_the_post_navigation( $args ) );

			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			
		}

	}
	
	/**
	 * Modify post navigation class to show navigation as button.
	 *
	 * @since 1.1.0
	 */
	public static function feature_image_before_content() {

		$single_post_layout = Options::get_theme_option( 'single_post_layout' );
		$show_featured_image                 = Common::show_featured_image();
		
		if ( is_single() && 'full_width' === $single_post_layout && $show_featured_image ) {
			printf( '<div class="octo-featured-image before-content">%s</div>', Content::get_post_thumbnail() );
		}

	}

}
