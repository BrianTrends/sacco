<?php
/**
 * Common class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\helper;

use octo\options\Options;
use octo\admin\Metabox;
use octo\fonts\Font_Families;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class provides as set of repeatedly used helper functions.
 *
 * @since 1.0.0
 */
class Common {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_filter( 'post_class', array( $this, 'post_classes' ) );
		add_action( 'wp_head', array( $this, 'pingback_header' ) );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param  Array $classes Classes for the body element.
	 * @return Array
	 * @since  1.0.0
	 */
	public function body_classes( $classes ) {

		// Add a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Add a class for the selected site layout.
		$container_layout = Options::get_theme_option( 'container_layout' );

		switch ( $container_layout ) {
			case 'full':
				$classes[] = 'octo-layout-full';
				break;
			case 'boxed':
				$classes[] = 'octo-layout-boxed';
				break;
			case 'separated':
				$classes[] = 'octo-layout-separated';
				break;
		}

		// Add a class for the sidebar.
		$sidebar_layout = self::get_sidebar_layout();

		if ( ! is_active_sidebar( 'octo-sidebar' ) || 'disabled' === $sidebar_layout ) {

			$classes[] = 'octo-no-sidebar';

		} else {

			$classes[] = 'sidebar';

			switch ( $sidebar_layout ) {
				case 'right':
					$classes[] = 'octo-sidebar-right';
					break;
				case 'left':
					$classes[] = 'octo-sidebar-left';
					break;
			}
		}

		// Add a class for menu item dropdown type.
		$menu_dropdown_target = Options::get_theme_option( 'menu_dropdown_target' );

		switch ( $menu_dropdown_target ) {
			case 'hover':
				$classes[] = 'octo-dropdown-hover';
				break;
			case 'click_item':
				$classes[] = 'octo-dropdown-click octo-dropdown-click-item';
				break;
			case 'click_icon':
				$classes[] = 'octo-dropdown-click octo-dropdown-click-icon';
				break;
		}

		// Add a class for the metabox settings content layout.
		$meta_content_layout = Metabox::get_meta_option( 'octo_content_layout' );

		if ( 'full_width' === $meta_content_layout ) {
			$classes[] = 'octo-content-full-width';
		}
				
		// Add a class for the header layout.
		$header_layout = Options::get_theme_option( 'header_layout' );
		
		switch ( $header_layout ) {
			case 'nav_inline':
				$classes[] = 'octo-nav-inline';
				break;
			case 'nav_top':
				$classes[] = 'octo-nav-top';
				break;
			case 'nav_bottom':
				$classes[] = 'octo-nav-bottom';
				break;
		}
		
		// Add a class for separated sidebar containers.
		$sidebar_separate_container = Options::get_theme_option( 'sidebar_separate_container' );
		
		if ( $sidebar_separate_container ) {
			$classes[] = 'octo-sidebar-separate-container';
		}

		return $classes;

	}
	
	/**
	 * Adds custom classes to the array of post classes.
	 *
	 * @param  Array $classes Classes for the body element.
	 * @return Array
	 * @since  1.0.0
	 */
	public function post_classes( $classes ) {
		
		// Add a class for the selected blog layout.
		if ( ! is_singular() && has_post_thumbnail() ) {
			$blog_post_layout = Options::get_theme_option( 'blog_post_layout' );

			switch ( $blog_post_layout ) {
				case 'featured_image':
					$classes[] = 'octo-featured-image';
					break;
				case 'thumbnail_left':
					$classes[] = 'octo-thumbnail-left';
					break;
			}
		}
		
		return $classes;
		
	}

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 *
	 * @since 1.0.0
	 */
	public function pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
	
	/**
	 * Get layout for the sidebar depending on the post type and metabox settings.
	 *
	 * @return String Return sidebar layout
	 * @since  1.0.0
	 */
	public static function get_sidebar_layout() {

		// Get global sidebar layout from the customizer.
		$sidebar_layout_default = Options::get_theme_option( 'sidebar_layout' );
		$sidebar_layout         = $sidebar_layout_default;

		// Get metabox settings.
		$sidebar_layout_metabox = Metabox::get_meta_option( 'octo_sidebar_layout' );

		// If sidebar layout is set in the metabox settings, overwrite the global customizer settings.
		if ( ! empty( $sidebar_layout_metabox ) && 'default' !== $sidebar_layout_metabox ) {
			$sidebar_layout = $sidebar_layout_metabox;
		} else {
			if ( is_singular() ) {
				$post_type = get_post_type();

				if ( 'page' === $post_type || 'post' === $post_type ) {
					$sidebar_layout_singular = Options::get_theme_option( 'sidebar_layout_' . $post_type );

					// Only overwrite the global settings, if a sidebar layout is set for pages or posts.
					if ( 'default' !== $sidebar_layout_singular ) {
						$sidebar_layout = $sidebar_layout_singular;
					}
				}
			} else {
				$sidebar_layout_archive = Options::get_theme_option( 'sidebar_layout_archive' );

				// Only overwrite the global settings, if a sidebar layout is set for archive pages.
				if ( 'default' !== $sidebar_layout_archive ) {
					$sidebar_layout = $sidebar_layout_archive;
				}
			}
		}

		return $sidebar_layout;

	}

	/**
	 * Creates the css code for the font family attribute.
	 *
	 * @param  String $font_family Font Family.
	 * @return String font_family
	 * @since  1.0.0
	 */
	public static function get_font_family( $font_family ) {

		$font_family  = esc_attr( $font_family );
		$system_fonts = Font_Families::get_system_fonts();
		$custom_fonts = Font_Families::get_custom_fonts();
		$google_fonts = Font_Families::get_google_fonts();

		if ( 'inherit' !== $font_family ) {
			if ( array_key_exists( $font_family, $system_fonts ) && $system_fonts[ $font_family ]['fallback'] ) {
				$font_family = $font_family . ', ' . $system_fonts[ $font_family ]['fallback'];
			} elseif ( array_key_exists( $font_family, $custom_fonts ) && $custom_fonts[ $font_family ]['fallback'] ) {
				$font_family = '\'' . $font_family . '\', ' . $custom_fonts[ $font_family ]['fallback'];
			} elseif ( array_key_exists( $font_family, $google_fonts ) && $google_fonts[ $font_family ]['category'] ) {
				$font_family = '\'' . $font_family . '\', ' . $google_fonts[ $font_family ]['category'];
			}
		} else {
			$font_family = '';
		}

		return $font_family;

	}

	/**
	 * Splits up the Google Font variant and returns the font weight.
	 *
	 * @param  String $font_variant Font Variant.
	 * @return String font_weight
	 * @since  1.0.0
	 */
	public static function get_font_weight( $font_variant ) {

		if ( $font_variant ) {

			if ( 'regular' === $font_variant || 'italic' === $font_variant ) {
				$font_weight = '400';
			} else {
				$font_weight = str_replace( 'italic', '', $font_variant );
			}

			return $font_weight;

		}

	}

	/**
	 * Splits up the Google Font variant and returns the font style.
	 *
	 * @param  String $font_variant Font Variant.
	 * @return String $font_weight
	 * @since  1.0.0
	 */
	public static function get_font_style( $font_variant ) {

		if ( $font_variant ) {

			if ( 'italic' !== $font_variant ) {

				$font_style = substr_replace( $font_variant, '', 0, 3 );

				if ( 'italic' !== $font_style ) {
					$font_style = 'normal';
				}
			} else {

				$font_style = $font_variant;

			}

			return $font_style;

		}

	}

	/**
	 * Determines, if title is disabled.
	 *
	 * @return Boolean
	 * @since  1.0.0
	 */
	public static function show_title() {

		return self::show_component( 'title' );

	}

	/**
	 * Determines, if sidebar is shown.
	 *
	 * @return Boolean
	 * @since  1.0.0
	 */
	public static function show_sidebar() {

		// Get sidebar layout.
		$sidebar_layout = self::get_sidebar_layout();

		if ( ! is_active_sidebar( 'octo-sidebar' ) || ! $sidebar_layout || 'disabled' === $sidebar_layout ) {
			return false;
		} else {
			return true;
		}

	}

	/**
	 * Determines, if widget-area has active widgets and is enabled.
	 *
	 * @param  String $section Section, widget-area is shown.
	 * @return Boolean
	 * @since  1.0.0
	 */
	public static function show_widget_area( $section ) {

		$enable_widgets = 'disabled';
		$show           = false;

		switch ( $section ) {
			case 'header':
				$enable_widgets = Options::get_theme_option( 'header_enable_widgets' );
				if ( is_active_sidebar( 'octo-header' ) && 'disabled' !== $enable_widgets ) {
					$show = true;
				}
				break;
			case 'main_nav':
				$enable_widgets = Options::get_theme_option( 'menu_widget_area' );
				if ( is_active_sidebar( 'octo-navigation' ) && 'disabled' !== $enable_widgets ) {
					$show = true;
				}
				break;
			case 'mobile_nav':
				$enable_widgets = Options::get_theme_option( 'mobile_menu_widget_area' );
				if ( is_active_sidebar( 'octo-navigation' ) && 'disabled' !== $enable_widgets ) {
					$show = true;
				}
				break;
			case 'footer':
				$footer_widget_areas = Options::get_theme_option( 'footer_widget_areas' );
				for ( $i = 1; $i <= $footer_widget_areas; $i++ ) {
					if ( is_active_sidebar( 'octo-footer-' . $i ) && 0 < $footer_widget_areas ) {
						$show = true;
					}
				}
				break;
		}

		return $show;

	}

	/**
	 * Determines, if header is shown.
	 *
	 * @return Boolean
	 * @since  1.0.0
	 */
	public static function show_main_header() {

		return self::show_component( 'header' );

	}

	/**
	 * Determines, if footer is shown.
	 *
	 * @return Boolean
	 * @since  1.0.0
	 */
	public static function show_main_footer() {

		return self::show_component( 'footer' );

	}

	/**
	 * Determines, if featured image is shown.
	 *
	 * @return Boolean
	 * @since  1.0.0
	 */
	public static function show_featured_image() {

		return self::show_component( 'featured_image' );

	}

	/**
	 * Determines, if a certain element is shown or not, depending on the metabox settings.
	 *
	 * @param  String $element Metabox Setting Element.
	 * @return Boolean
	 * @since  1.0.0
	 */
	public static function show_component( $element ) {

		// Get metabox settings.
		$disable = Metabox::get_meta_option( 'octo_disable_' . $element );

		if ( $disable ) {
			return false;
		} else {
			return true;
		}

	}

	/**
	 * Returns the current post-type.
	 *
	 * @return String
	 * @since 1.0.0
	 */
	public static function get_current_post_type() {

		$screen    = get_current_screen();
		$post_type = $screen->post_type;

		return $post_type;

	}

	/**
	 * Returns the media query attribute.
	 *
	 * @param  String $device Breakpoint Device.
	 * @param  String $width  Media Query Width.
	 * @return Array
	 * @since  1.0.0
	 */
	public static function get_media_query_width( $device, $width ) {

		$media_query_width = '';

		if ( 'medium' === $device ) {
			$media_query_width = Common::get_value_from_array( Options::get_theme_option( 'breakpoint_medium_devices' ), 'value' );
		} elseif ( 'small' === $device ) {
			$media_query_width = Common::get_value_from_array( Options::get_theme_option( 'breakpoint_small_devices' ), 'value' );
		}

		if ( 0 < $media_query_width ) {
			if ( 'min-width' === $width ) {
				$media_query_width = ++$media_query_width;
			}

			return $media_query_width . 'px';

		}

	}

	/**
	 * Returns .min suffix, if SCRIPT_DEBUG is defined.
	 *
	 * @return String
	 * @since  1.0.0
	 */
	public static function get_minified_suffix() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		return $suffix;

	}

	/**
	 * Returns a specific icon.
	 *
	 * @return String
	 * @since  1.0.3
	 */
	public static function get_icon( $icon, $echo = false ) {

		$icon_set = Options::get_theme_option( 'icon_set' );

		if ( 'dashicons' === $icon_set ) {

			$html = self::get_dashicon( $icon );

		} else if ( 'fontawesome' === $icon_set ) {

			$html = self::get_fontawesome_icon( $icon );

		} else if ( 'svg' === $icon_set ) {

			$html = self::get_svg_icon( $icon );

		}

		if ( $echo ) {
			echo $html;	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return $html;
		}

	}

	/**
	 * Returns a specific dashicon.
	 *
	 * @return String
	 * @since  1.1.0
	 */
	public static function get_dashicon( $icon ) {

		switch ( $icon ) {
				case 'calendar':
					$html = '<span class="dashicons dashicons-calendar-alt"></span>';
					break;
				case 'user':
					$html = '<span class="dashicons dashicons-admin-users"></span>';
					break;
				case 'category':
					$html = '<span class="dashicons dashicons-category"></span>';
					break;
				case 'tag':
					$html = '<span class="dashicons dashicons-tag"></span>';
					break;
				case 'comment':
					$html = '<span class="dashicons dashicons-testimonial"></span>';
					break;
				case 'chevron_down':
					$html = '<span class="dashicons dashicons-arrow-down-alt2"></span>';
					break;
				case 'arrow_left':
					$html = '<span class="dashicons dashicons-arrow-left-alt"></span>';
					break;
				case 'arrow_right':
					$html = '<span class="dashicons dashicons-arrow-right-alt"></span>';
					break;
				case 'arrow_up':
					$html = '<span class="dashicons dashicons-arrow-up-alt"></span>';
					break;
				case 'close':
					$html = '<span class="dashicons dashicons-no-alt"></span>';
					break;
				case 'burger_menu':
					$html = '<span class="dashicons dashicons-menu"></span>';
					break;
			}

		return $html;

	}

	/**
	 * Returns a specific dashicon.
	 *
	 * @return String
	 * @since  1.1.0
	 */
	public static function get_fontawesome_icon( $icon ) {

		switch ( $icon ) {
				case 'calendar':
					$html = '<i class="fas fa-calendar"></i>';
					break;
				case 'user':
					$html = '<i class="fas fa-user"></i>';
					break;
				case 'category':
					$html = '<i class="fas fa-folder"></i>';
					break;
				case 'tag':
					$html = '<i class="fas fa-tag"></i>';
					break;
				case 'comment':
					$html = '<i class="fas fa-comment-dots"></i>';
					break;
				case 'chevron_down':
					$html = '<i class="fas fa-chevron-down"></i>';
					break;
				case 'arrow_left':
					$html = '<i class="fas fa-arrow-left"></i>';
					break;
				case 'arrow_right':
					$html = '<i class="fas fa-arrow-right"></i>';
					break;
				case 'arrow_up':
					$html = '<i class="fas fa-arrow-up"></i>';
					break;
				case 'close':
					$html = '<i class="fas fa-times"></i>';
					break;
				case 'burger_menu':
					$html = '<i class="fas fa-bars"></i>';
					break;
			}

		return $html;

	}

	/**
	 * Returns a specific svg icon.
	 *
	 * @return String
	 * @since  1.1.0
	 */
	public static function get_svg_icon( $icon ) {

		switch ( $icon ) {
				case 'calendar':
					$html = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M492,51h-76V20c0-11-9-20-20-20h-40c-11,0-20,9-20,20v31H176V20c0-11-9-20-20-20h-40c-11,0-20,9-20,20v31H20C9,51,0,60,0,71v13v12v10v20v1v32v324c0,16.542,13.458,30,30,30h452c16.542,0,30-13.458,30-30V159v-32v-1v-20V96V84V71C512,60,503,51,492,51z M492,483c0,5.514-4.486,10-10,10H30c-5.514,0-10-4.486-10-10V137l472,0.667V483z"/><path d="M356,241h20c8.25,0,15-6.75,15-15v-20c0-8.25-6.75-15-15-15h-20c-8.25,0-15,6.75-15,15v20C341,234.25,347.75,241,356,241z"/><path d="M356,341h20c8.25,0,15-6.75,15-15v-20c0-8.25-6.75-15-15-15h-20c-8.25,0-15,6.75-15,15v20C341,334.25,347.75,341,356,341z"/><path d="M356,441h20c8.25,0,15-6.75,15-15v-20c0-8.25-6.75-15-15-15h-20c-8.25,0-15,6.75-15,15v20C341,434.25,347.75,441,356,441z"/><path d="M246,241h20c8.25,0,15-6.75,15-15v-20c0-8.25-6.75-15-15-15h-20c-8.25,0-15,6.75-15,15v20C231,234.25,237.75,241,246,241z"/><path d="M246,341h20c8.25,0,15-6.75,15-15v-20c0-8.25-6.75-15-15-15h-20c-8.25,0-15,6.75-15,15v20C231,334.25,237.75,341,246,341z"/><path d="M246,441h20c8.25,0,15-6.75,15-15v-20c0-8.25-6.75-15-15-15h-20c-8.25,0-15,6.75-15,15v20C231,434.25,237.75,441,246,441z"/><path d="M136,241h20c8.25,0,15-6.75,15-15v-20c0-8.25-6.75-15-15-15h-20c-8.25,0-15,6.75-15,15v20C121,234.25,127.75,241,136,241z"/><path d="M136,341h20c8.25,0,15-6.75,15-15v-20c0-8.25-6.75-15-15-15h-20c-8.25,0-15,6.75-15,15v20C121,334.25,127.75,341,136,341z"/><path d="M136,441h20c8.25,0,15-6.75,15-15v-20c0-8.25-6.75-15-15-15h-20c-8.25,0-15,6.75-15,15v20C121,434.25,127.75,441,136,441z"/></svg>';
					break;
				case 'user':
					$html = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M256.688,228.396c51.774,0,93.895-50.948,93.895-113.571c0-62.623-42.121-113.569-93.895-113.569c-51.773,0-93.894,50.947-93.894,113.569C162.794,177.448,204.915,228.396,256.688,228.396z M256.688,21.255c40.746,0,73.895,41.975,73.895,93.569c0,51.595-33.149,93.571-73.895,93.571c-40.745,0-73.894-41.976-73.894-93.571C182.794,63.23,215.943,21.255,256.688,21.255z"/><path d="M420.116,307.113c-22.604-33.079-55.598-53.044-101.105-61.038l-4.235-0.744l-3.452,2.562c-24.908,18.476-45.348,32.259-54.635,38.396c-9.265-6.123-29.629-19.854-54.46-38.268l-3.464-2.566l-4.246,0.76c-45.639,8.125-78.792,28.168-101.355,61.257c-26.28,38.54-38.676,95.075-37.898,172.804l0.074,7.403l7.064,2.174c3.126,0.934,77.9,23.146,194.623,23.146h1.089c0.007,0,0.004,0,0.012,0c116.126,0,190.746-22.213,193.871-23.152l7.003-2.271v-7.434C459,402.115,446.358,345.517,420.116,307.113z M258.114,493h-1.064c-93.532,0-160.633-15.064-181.819-20.413c0.095-69.563,11.387-119.966,34.456-153.798c18.962-27.807,45.772-44.476,84.148-52.101c32.813,24.164,57.213,39.814,57.464,39.976l5.389,3.451l5.389-3.439c0.252-0.161,24.747-15.854,57.651-40.093c38.237,7.511,65.001,24.087,83.99,51.877c23.063,33.752,34.688,84.278,35.47,154.167C417.991,478.025,351.218,493,258.114,493z"/></svg>';
					break;
				case 'category':
					$html = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M482.387,453h-451C14.631,453,1,439.558,1,423.034V90.79C1,74.364,14.631,61,31.387,61H214.57c15,0,31.183,10.807,36.843,24.603l22.878,55.937c2.673,6.517,11.414,12.46,18.335,12.46h189.761C498.992,154,512,166.98,512,183.552v239.482C512,439.558,498.716,453,482.387,453z M31.387,81C25.756,81,21,85.483,21,90.79v332.245c0,5.402,4.756,9.966,10.387,9.966h451c5.391,0,9.613-4.378,9.613-9.966V183.552c0-5.445-4.133-9.552-9.613-9.552H292.626c-14.937,0-31.119-10.928-36.843-24.879l-22.878-55.937C230.292,86.812,221.55,81,214.57,81H31.387z"/></svg>';
					break;
				case 'tag':
					$html = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="1.5rem" height="1.5rem" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M501.939,218.115l-10.488-167c-1.013-16.128-14.44-29.555-30.568-30.567L293.888,10.064c-0.795-0.05-1.617-0.075-2.444-0.075c-13.606,0-30.158,6.676-39.356,15.874L25.903,252.047c-11.697,11.697-11.697,30.73,0,42.428L217.53,486.101c5.65,5.65,13.184,8.763,21.213,8.763s15.563-3.112,21.213-8.763l226.186-226.186C496.023,250.033,502.815,232.063,501.939,218.115z M471.999,245.773L245.813,471.958c-1.873,1.873-4.384,2.905-7.071,2.905s-5.198-1.032-7.071-2.905L40.045,280.332c-3.899-3.899-3.899-10.243,0-14.143L266.229,40.005c5.429-5.429,16.976-10.016,25.214-10.016c0.404,0,0.803,0.012,1.191,0.036L459.63,40.509c5.944,0.373,11.487,5.915,11.86,11.86l10.488,167C482.486,227.457,477.73,240.042,471.999,245.773z"/><path d="M325.243,116.521c-18.698,0-36.276,7.281-49.498,20.502c-27.292,27.293-27.292,71.701,0,98.994c13.222,13.222,30.801,20.503,49.498,20.503s36.275-7.281,49.497-20.502c13.221-13.222,20.503-30.8,20.503-49.498c0-18.698-7.282-36.276-20.503-49.498C361.519,123.802,343.94,116.521,325.243,116.521z M360.598,221.875c-9.443,9.444-21.999,14.645-35.354,14.645c-13.354,0-25.911-5.201-35.355-14.646c-19.495-19.495-19.495-51.214,0-70.709c9.443-9.444,22-14.645,35.355-14.645c13.354,0,25.911,5.201,35.354,14.645c9.444,9.444,14.646,22,14.646,35.355S370.042,212.431,360.598,221.875z"/></svg>';
					break;
				case 'comment':
					$html = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M436.521,64.223C388.196,25.515,324.074,4.197,255.967,4.197c-68.106,0-132.228,21.317-180.553,60.026C26.439,103.452-0.532,155.806-0.532,211.642c0,37.693,12.596,74.588,36.426,106.695c21.176,28.531,50.642,52.603,85.616,70.024L72.684,509.986l205.778-91.707c63.016-4.424,121.502-27.428,164.854-64.878c44.593-38.522,69.151-88.867,69.151-141.76C512.468,155.806,485.496,103.452,436.521,64.223z M275.372,398.442l-1.789,0.115l-163.947,73.063l37.49-93.388l-8.695-3.96C65.052,340.856,19.468,278.54,19.468,211.642c0-103.357,106.093-187.444,236.5-187.444c130.407,0,236.5,84.087,236.5,187.444C492.468,308.54,397.108,390.593,275.372,398.442z"/><circle cx="256.667" cy="211.333" r="30"/><circle cx="136.667" cy="211.333" r="30"/><circle cx="376.666" cy="211.333" r="30"/></svg>';
					break;
				case 'chevron_down':
					$html = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M266.607,400.831c-5.834,5.833-15.38,5.833-21.213,0L11.022,166.459c-5.833-5.833-5.833-15.379,0-21.213l32.449-32.449c5.833-5.833,15.379-5.833,21.213,0l180.709,180.709c5.833,5.833,15.379,5.833,21.213,0l180.708-180.709c5.833-5.833,15.38-5.833,21.213,0l32.449,32.449c5.833,5.833,5.833,15.379,0,21.213L266.607,400.831z"/></svg>';
					break;
				case 'arrow_left':
					$html = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M245.063,502.331c5.833,5.833,15.379,5.833,21.213,0l32.482-32.483c5.834-5.833,5.833-15.38,0-21.213L155.927,305.804c-5.833-5.833-3.856-10.604,4.394-10.6l336.894,0.15c8.25,0.004,15.003-6.743,15.007-14.993l0.02-45.937c0.004-8.25-6.743-15.003-14.993-15.007l-337.005-0.151c-8.25-0.004-10.227-4.78-4.394-10.613L298.758,65.744c5.833-5.833,5.834-15.379,0-21.213l-32.482-32.483c-5.834-5.834-15.379-5.834-21.213,0L10.525,246.583c-5.833,5.833-5.833,15.38,0,21.213L245.063,502.331z"/></svg>';
					break;
				case 'arrow_right':
					$html = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M267.138,11.079c-5.834-5.833-15.38-5.833-21.213,0l-32.477,32.477c-5.833,5.833-5.833,15.379,0,21.213l142.811,142.81c5.833,5.833,3.856,10.604-4.394,10.6l-336.847-0.151c-8.25-0.004-15.003,6.743-15.007,14.993l-0.021,45.929c-0.004,8.25,6.743,15.003,14.993,15.007l336.959,0.152c8.25,0.004,10.227,4.779,4.394,10.613L213.448,447.607c-5.834,5.834-5.834,15.38,0,21.213l32.477,32.479c5.833,5.833,15.379,5.833,21.213,0l234.503-234.504c5.833-5.833,5.833-15.379,0-21.213L267.138,11.079z"/></svg>';	
					break;
				case 'arrow_up':
					$html = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M10.94,245.168c-5.833,5.833-.833,15.379,0,21.213l32.482,32.482c5.834,5.834,15.38,5.833,21.213,0l142.831-142.831c5.833-5.833,10.604-3.856,10.6,4.394l-0.15,336.894c-0.004,8.25,6.743,15.003,14.993,15.007l45.938,0.02c8.25,0.004,15.003-6.743,15.007-14.993l0.15-337.005c0.004-8.25,4.78-10.227,10.613-4.394l142.91,142.909c5.833,5.834,15.38,5.834,21.213,0l32.484-32.482c5.833-5.834,5.833-15.379,0-21.213L266.688,10.631c-5.833-5.833-15.379-5.833-21.213,0L10.94,245.168z"/></svg>';	
					break;
				case 'close':
					$html = '<svg aria-hidden="true" cversion="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M312.552,256.5L506.32,62.73c7.49-7.49,7.49-19.747,0-27.237L477.507,6.679c-7.488-7.49-19.747-7.49-27.237,0L256.5,200.449L62.729,6.679c-7.49-7.49-19.747-7.49-27.238,0L6.679,35.491c-7.49,7.491-7.49,19.748,0,27.238L200.449,256.5L6.679,450.271c-7.49,7.489-7.49,19.748,0,27.236l28.812,28.813c7.491,7.49,19.748,7.49,27.238,0L256.5,312.55L450.27,506.32c7.49,7.49,19.749,7.49,27.237,0l28.813-28.813c7.49-7.488,7.49-19.747,0-27.237L312.552,256.5z"/></svg>';
					break;
				case 'burger_menu':
					$html = '<svg aria-hidden="true" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M383,244.228c0-10.067-8.16-18.228-18.227-18.228H19.227C9.16,226,1,234.161,1,244.228v23.545C1,277.839,9.16,286,19.227,286h345.547C374.84,286,383,277.839,383,267.772V244.228z"/><path d="M257,414.967c0-10.065-8.442-17.967-18.509-17.967H19.665C9.598,397,1,404.901,1,414.967v23.807C1,448.84,9.598,457,19.665,457h218.826c10.067,0,18.509-8.16,18.509-18.227V414.967z"/><path fill="currentColor" d="M512,74.227C512,64.161,503.839,56,493.772,56H19.228C9.161,56,1,64.161,1,74.227v23.546C1,107.839,9.161,116,19.228,116h474.545C503.839,116,512,107.839,512,97.773V74.227z"/></svg>';
					break;
			}

		return $html;

	}

	/**
	 * Returns specific values from an array as string.
	 *
	 * @param  Array  $theme_option Theme option value.
	 * @param  String $key          Key of value to be fetched.
	 * @param  String $unit         Include unit in the return value.
	 * @return String
	 * @since  1.1.0
	 */
	public static function get_value_from_array( $theme_option, $key, $unit = false ) {

		$output = '';

		if ( is_array( $theme_option ) ) {

			if ( array_key_exists( $key, $theme_option ) ) {

				$output = $theme_option[ $key ];

				if ( $unit && array_key_exists( 'unit', $theme_option ) && '' !== $output ) {
					$output .= $theme_option['unit'];
				}

				return $output;
			}
		}

	}

	/**
	 * Negate a CSS value.
	 *
	 * @param  String $value Value to be negated.
	 * @since  1.1.0
	 */
	public static function negate_css_value( $value ) {

		$output = '';

		if ( $value ) {
			$value = '-' . $value;
			return $value;
		}

	}

	/**
	 * Returns the left and right spacing for the outer content as a sum.
	 *
	 * @since  1.1.0
	 */
	public static function get_outer_content_spacing() {

		return apply_filters( 'octo_outer_content_spacing_left_right', 40 );

	}

	/**
	 * Returns the left and right spacing for the inner content as a sum.
	 *
	 * @since  1.1.0
	 */
	public static function get_inner_content_spacing() {

		$container_layout      = Options::get_theme_option( 'container_layout' );
		$inner_content_spacing = 0;

		if ( 'separated' === $container_layout ) {
			$inner_content_spacing = 96;
		}
		
		return apply_filters( 'octo_inner_content_spacing_left_right', $inner_content_spacing );

	}

	/**
	 * Returns the spacing for the sidebar separator.
	 *
	 * @since  1.1.0
	 */
	public static function get_sidebar_separator_spacing() {

		return apply_filters( 'octo_sidebar_separator_margin', 20 );

	}

}
