<?php
/**
 * Menu class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\setup;

use octo\options\Options;
use octo\helper\Common;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * Setup the theme menu.
 *
 * @since 1.0.0
 */
class Menu {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'after_setup_theme', array( $this, 'register' ) );
		add_filter( 'nav_menu_item_title', array( $this, 'dropdown_icon' ), 10, 4 );
	}

	/**
	 * Register navigation menu.
	 *
	 * @since 1.0.0
	 */
	public function register() {

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'octo' ),
				'mobile'  => __( 'Mobile Menu', 'octo' ),
			)
		);

	}

	/**
	 * Add icon for drop down menu item, in chase the menu item has children.
	 *
	 * @param String  $title The menu item's title.
	 * @param WP_POST $item  The current menu item.
	 * @param Object  $args  An object of wp_nav_menu() arguments.
	 * @param Int     $depth Depth of menu item. Used for padding.
	 * @since 1.0.0
	 */
	public function dropdown_icon( $title, $item, $args, $depth ) {

		if ( 'primary-menu' === $args->container_id || 'mobile-menu' === $args->container_id || 'off-canvas-menu' === $args->container_id ) {

			// Get theme options.
			$menu_dropdown_target = Options::get_theme_option( 'menu_dropdown_target' );

			$tabindex = '';
			if ( ( 'click_icon' === $menu_dropdown_target && '#' !== $item->url ) ||
			   ( 'hover' === $menu_dropdown_target && 'mobile-menu' === $args->menu_id && '#' !== $item->url ) ) {
				$tabindex = 'tabindex=0';
			}

			foreach ( $item->classes as $class ) {
				if ( 'menu-item-has-children' === $class ) {
					$title .= '<span class="submenu-toggle-icon" ' . esc_attr( $tabindex ) . '>' . Common::get_icon( 'chevron_down' ) . '</span>';
				}
			}
		}

		return $title;

	}

}
