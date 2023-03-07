<?php
/**
 * Theme_Update class.
 *
 * @package octo
 * @since   1.0.6
 */

namespace octo\update;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class performs certain migration tasks necessary for theme updates.
 *
 * @since 1.0.6
 */
class Theme_Update {

	/**
	 * Init
	 *
	 * @since 1.0.6
	 */
	public static function init() {

		if ( is_customize_preview() ) {
			return;
		}

		$options_version = get_option( 'octo_options_version' );

		if ( ! $options_version ) {
			// This means, we have a new installation.
			update_option( 'octo_options_version', OCTO_VERSION );
			return;
		}

		update_option( 'octo_options_version', OCTO_VERSION );

	}

}
