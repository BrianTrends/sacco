<?php
/**
 * Enqueue class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\setup;

use octo\style\Theme_Style;
use octo\admin\Block_Editor;
use octo\admin\Metabox;
use octo\options\Options;
use octo\helper\Common;
use octo\fonts\Google_Fonts_Api;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * Enqueue scripts and styles.
 *
 * @since   1.0.0
 */
class Enqueue {

	/**
	 * Register WordPress action hooks.
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_googl_fonts_api' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_googl_fonts_api' ), 10 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		$suffix = Common::get_minified_suffix();

		wp_enqueue_script( 'octo-navigation', get_template_directory_uri() . '/assets/js/navigation' . $suffix . '.js', array(), OCTO_VERSION, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	/**
	 * Enqueue styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

		$suffix = Common::get_minified_suffix();

		wp_enqueue_style( 'octo-styles', get_template_directory_uri() . '/assets/css/theme-style' . $suffix . '.css', array(), OCTO_VERSION, 'all' );
		wp_style_add_data( 'octo-styles', 'rtl', get_template_directory_uri() . '/assets/css/theme-style-rtl' . $suffix . '.css' );

		// Add support for icons.
		$icons = Options::get_theme_option( 'icon_set' );

		if ( 'dashicons' === $icons ) {
			wp_enqueue_style( 'dashicons' );
		} else if ( 'fontawesome' === $icons ) {
			wp_enqueue_style( 'octo-icons-fontawesome', get_template_directory_uri() . '/assets/fonts/fontawesome/css/fontawesome-octo' . $suffix . '.css', array(), OCTO_VERSION, 'all' );
		}

		// Custom stylesheets for this theme.
		$stylesheet = Theme_Style::get_style();

		wp_add_inline_style( 'octo-styles', $stylesheet );

		
	}

	/**
	 * Enqueue styles and scripts for Gutenberg block editor.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_editor_assets() {

		wp_enqueue_style( 'octo-editor-styles', get_template_directory_uri() . '/assets/css/block-editor.css', false, OCTO_VERSION, 'all' );

		// Custom stylesheets for Gutenberg block editor.
		$stylesheet = Block_Editor::get_style();

		wp_add_inline_style( 'octo-editor-styles', $stylesheet );

	}

	/**
	 * Enqueue scripts for admin sections.
	 *
	 * @param String $hook WordPress hook.
	 * @since 1.0.0
	 */
	public function enqueue_admin_scripts( $hook ) {

		if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
			wp_enqueue_style( 'octo-metabox-styles', get_template_directory_uri() . '/assets/css/metabox.css', array(), OCTO_VERSION, 'all' );
			wp_enqueue_script( 'octo-block-editor-scripts', get_template_directory_uri() . '/assets/js/block-editor.js', array( 'jquery' ), OCTO_VERSION, true );

			$post_type = Common::get_current_post_type();

			wp_localize_script(
				'octo-block-editor-scripts',
				'octoBlockEditor',
				array(
					'containerWidth'        => Common::get_value_from_array( Options::get_theme_option( 'container_width' ), 'value' ),
					'defaultSidebarLayout'  => Options::get_theme_option( 'sidebar_layout' ),
					'singularSidebarLayout' => Options::get_theme_option( 'sidebar_layout_' . $post_type ),
					'sidebarWidth'          => Common::get_value_from_array( Options::get_theme_option( 'sidebar_width' ), 'value' ),
					'outerContentSpacing'   => Common::get_outer_content_spacing(),
					'innerContentSpacing'   => Common::get_inner_content_spacing(),
					'sidebarMargin'         => Common::get_sidebar_separator_spacing(),
					'containerLayout'       => Options::get_theme_option( 'container_layout' ),
				)
			);
		}
		
		if ( 'appearance_page_octo-settings' === $hook ) {
			wp_enqueue_style( 'octo-theme-page', get_template_directory_uri() . '/assets/css/theme-page.css', array(), OCTO_VERSION, 'all' );	
		}

	}

	/**
	 * Enqueue Google Fonts API url.
	 *
	 * @param  Object $fonts Google_Fonts.
	 * @since 1.0.6
	 */
	public static function enqueue_googl_fonts_api() {
			
		$google_fonts_api = Google_Fonts_Api::get_instance();		
		$google_fonts_api->add_font( Options::get_theme_option( 'body_font_family' ), Options::get_theme_option( 'body_font_variant' ) );
		$google_fonts_api->add_font( Options::get_theme_option( 'headings_font_family' ), Options::get_theme_option( 'headings_font_variant' ) );
		$google_fonts_api->add_font( Options::get_theme_option( 'h1_font_family' ), Options::get_theme_option( 'h1_font_variant' ) );
		$google_fonts_api->add_font( Options::get_theme_option( 'h2_font_family' ), Options::get_theme_option( 'h2_font_variant' ) );
		$google_fonts_api->add_font( Options::get_theme_option( 'h3_font_family' ), Options::get_theme_option( 'h3_font_variant' ) );
		$google_fonts_api->add_font( Options::get_theme_option( 'h4_font_family' ), Options::get_theme_option( 'h4_font_variant' ) );
		$google_fonts_api->add_font( Options::get_theme_option( 'h5_font_family' ), Options::get_theme_option( 'h5_font_variant' ) );
		$google_fonts_api->add_font( Options::get_theme_option( 'h6_font_family' ), Options::get_theme_option( 'h6_font_variant' ) );
		$google_fonts_api->add_font( Options::get_theme_option( 'menu_font_family' ), Options::get_theme_option( 'menu_font_variant' ) );
		$google_fonts_api->add_font( Options::get_theme_option( 'submenu_font_family' ), Options::get_theme_option( 'submenu_font_variant' ) );
		$google_fonts_api->add_font( Options::get_theme_option( 'title_font_family' ), Options::get_theme_option( 'title_font_variant' ) );
		
		
		$download_google_fonts = Options::get_theme_option( 'download_google_fonts' );
		
		if ( ! $download_google_fonts || is_customize_preview() || is_admin() ) {
		
			$google_fonts_api_url = $google_fonts_api->get_api_url();
			wp_enqueue_style( 'octo-google-fonts-api', $google_fonts_api_url, array(), OCTO_VERSION, 'all' );
		}		

	}

}
