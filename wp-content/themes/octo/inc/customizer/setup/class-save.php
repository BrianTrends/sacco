<?php
/**
 * Save class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\setup;

use octo\options\Options;
use octo\helper\Common;
use octo\style\Theme_Style;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class handles actions and task after a customizer safe.
 *
 * @since 1.0.0
 */
class Save {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'customize_save_after', array( $this, 'create_custom_logo_image_file' ) );
		add_action( 'customize_save_after', array( $this, 'refresh_options' ) );
		add_action( 'customize_save_after', array( $this, 'update_cached_css' ) );
	}

	/**
	 * Create a new image file depending on the choosen logo width in the customizer settings.
	 *
	 * @since 1.0.0
	 */
	public function create_custom_logo_image_file() {

		// Refresh theme options
		Options::refresh();

		// Resize custom logo image.
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( 0 < $custom_logo_id ) {
			add_filter( 'octo_custom_logo_image_size', array( $this, 'filter_custom_logo_image_size' ) );
			self::create_logo( $custom_logo_id );	
		}

		// Resize mobile logo image.
		$custom_logo_mobile_id  = Options::get_theme_option( 'mobile_logo' );
		if ( 0 < $custom_logo_mobile_id ) {
			add_filter( 'octo_custom_logo_image_size', array( $this, 'filter_custom_logo_mobile_image_size' ) );
			self::create_logo( $custom_logo_mobile_id );	
		}			

	}
	
	/**
	 * Adds image size for custom logo.
	 *
	 * @param Array $sizes      Associative array of image sizes to be created.
	 * @since 1.1.0
	 */
	public function filter_custom_logo_image_size( $sizes ) {

		// Add image size for custom logo.
		$custom_logo_width = Common::get_value_from_array( Options::get_theme_option( 'logo_width_desktop' ), 'value' );

		if ( is_array( $sizes ) && ! empty( $custom_logo_width ) ) {
			$sizes['octo-logo-size'] = array(
				'width'  => $custom_logo_width,
				'height' => 0,
				'crop'   => false,
			);
		}
		
		return $sizes;

	}
	
	/**
	 * Adds image size for custom mobile logo.
	 *
	 * @param Array $sizes      Associative array of image sizes to be created.
	 * @since 1.1.0
	 */
	public function filter_custom_logo_mobile_image_size( $sizes ) {

		// Add image size for custom mobile logo.
		$custom_logo_mobile_width = Common::get_value_from_array( Options::get_theme_option( 'mobile_logo_width' ), 'value' );

		if ( is_array( $sizes ) && ! empty( $custom_logo_mobile_width ) ) {
			$sizes['octo-mobile-logo-size'] = array(
				'width'  => $custom_logo_mobile_width,
				'height' => 0,
				'crop'   => false,
			);
		}
		
		return $sizes;

	}

	/**
	 * Adds logo images size in filter.
	 *
	 * @param Array $sizes      Associative array of image sizes to be created.
	 * @param Array $image_meta The image meta data: width, height, file, sizes, etc.
	 * @since 1.0.0
	 */
	public function custom_logo_image_size( $sizes, $image_meta ) {
		return apply_filters( 'octo_custom_logo_image_size', $sizes );
	}

	/**
	 * Creates sub-image for custom logo depending on its width.
	 *
	 * @param Int $logo_id Logo id.
	 * @since 1.0.0
	 */
	public function create_logo( $logo_id ) {

		if ( $logo_id ) {

			$fullsizepath = get_attached_file( $logo_id );

			if ( isset( $fullsizepath ) && file_exists( $fullsizepath ) ) {

				if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
					require_once ABSPATH . 'wp-admin/includes/image.php';// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
				}

				add_filter( 'intermediate_image_sizes_advanced', array( $this, 'custom_logo_image_size' ), 10, 2 );

				$meta = wp_generate_attachment_metadata( $logo_id, $fullsizepath );

				if ( ! is_wp_error( $metadata ) && ! empty( $metadata ) ) {
					wp_update_attachment_metadata( $logo_id, $meta );
				}

				remove_filter( 'intermediate_image_sizes_advanced', array( $this, 'custom_logo_image_size' ), 10 );

			}
		}

	}
	
	/**
	 * Refresh the theme options after a customizer save.
	 *
	 * @since 1.0.0
	 */
	public function refresh_options() {

		Options::refresh();

	}
	
	/**
	 * Update the cached CSS in the database after a customizer save.
	 *
	 * @since 1.0.3
	 */
	
	public function update_cached_css() {

		$cache_custom_css = Options::get_theme_option( 'cache_custom_css' );

		if ( $cache_custom_css ) {
			Theme_Style::update_cached_css();	
		}

	}

}
