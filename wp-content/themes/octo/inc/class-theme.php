<?php
/**
 * Theme class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * Theme class to init theme.
 *
 * @since 1.0.0
 */
class Theme {

	/**
	 * Store all classes in an Array.
	 *
	 * @since  1.0.0
	 * @return Array List of all classes.
	 */
	public function get_classes() {

		return array(			
			options\Options::class,
			setup\Setup::class,
			setup\Menu::class,
			setup\Widget::class,
			setup\Enqueue::class,
			frontend\Content::class,
			helper\Common::class,
			frontend\Template_Parts::class,
			frontend\Comments::class,
			frontend\Components::class,
			admin\Metabox::class,
			admin\Theme_Page::class,
			update\Theme_Update::class,
			plugins\Elementor_Pro::class,
			plugins\Beaver_Themer::class,
			customizer\setup\Enqueue::class,
			customizer\setup\Save::class,
			customizer\setup\Preview::class,
			customizer\setup\Register::class,			
			customizer\settings\Panel::class,
			customizer\settings\Section::class,
			customizer\settings\Content_Settings::class,
			customizer\settings\Header_Settings::class,
			customizer\settings\Footer_Settings::class,
			customizer\settings\Global_Settings::class,
			customizer\settings\Typography_Settings::class,
			customizer\settings\Sidebar_Settings::class,
		);

	}

	/**
	 * Instantiates all classes and starts the theme.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		foreach ( self::get_classes() as $class ) {
			$object = new $class();

			if ( method_exists( $object, 'init' ) ) {
				$object->init();
			}
		}

	}

}
