<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package octo
 * @since   1.0.0
 */

/**
 * Define theme constants.
 */
if ( ! defined( 'OCTO_VERSION' ) ) {
	define( 'OCTO_VERSION', '1.1.2' );
}

if ( ! defined( 'OCTO_SETTINGS' ) ) {
	define( 'OCTO_SETTINGS', 'octo_settings' );
}

/**
 * Class autoloader.
 */
if ( ! class_exists( '\octoplus\Plugin' ) ) {
	require_once get_template_directory() . '/autoloader/class-autoloader.php';

	$loader = new Autoloader( 'octo', __DIR__ . '/inc' );
	$loader->register();
		
}

/**
 * Init theme.
 */
$theme = new octo\Theme();
$theme->init();
