<?php
/**
 * Options class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\options;

use octo\options\Defaults;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class provides custom theme options.
 *
 * @since 1.0.0
 */
class Options {

	/**
	 * Theme option defaults.
	 *
	 * @var $defaults
	 */
	private static $defaults;

	/**
	 * A static option variable
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    Array $options
	 */
	private static $options = array();

	/**
	 * Init
	 *
	 * @since 1.0.0
	 */
	public static function init() {

		// Set the static variables, if not yet set.
		if ( ! self::$defaults || self::$options ) {
			self::$defaults = Defaults::get_defaults();
			self::refresh();
		}
	}

	/**
	 * Refresh theme options.
	 *
	 * @since 1.0.0
	 */
	public static function refresh() {

		$options_no_default = apply_filters( 'octo_option', get_option( OCTO_SETTINGS, array() ) );

		self::$options = wp_parse_args( $options_no_default, self::$defaults );

	}

	/**
	 * Get a specific theme option
	 *
	 * @param  String $theme_option Theme option name.
	 * @param  String $default      Default value.
	 * @return mixed                Return option for a specific setting
	 * @since  1.0.0
	 */
	public static function get_theme_option( $theme_option, $default = '' ) {

		if ( array_key_exists( $theme_option, self::$options ) ) {
			
			if ( isset( self::$options[ $theme_option ] ) ) {
				return self::$options[ $theme_option ];
			} else {
				if ( $default ) {
					return $default;
				}				
			}
			
		}

	}

	/**
	 * Get all theme options
	 *
	 * @return Array    Return all options as array
	 * @since  1.0.0
	 */
	public static function get_theme_options() {

		return self::$options;

	}

}
