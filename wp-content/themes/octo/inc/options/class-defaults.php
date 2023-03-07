<?php
/**
 * Defaults class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\options;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class provides the theme defaults.
 *
 * @since 1.0.0
 */
class Defaults {
	
	/**
	 * Variable to store all default values.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private static $defaults = array();

	/**
	 * Get default theme option values
	 *
	 * @since  1.0.0
	 * @return $default values of the theme.
	 */
	public static function get_defaults() {

		// Defaults list of options.
		self::$defaults = apply_filters(
			'octo_option_defaults',
			array(
				/**
				 * Breakpoints
				 */
				'breakpoint_medium_devices'                   => array(
					'value' => '1024',
					'unit'  => 'px',
				),
				'breakpoint_small_devices'                    => array(
					'value' => '768',
					'unit'  => 'px',
				),
				/**
				 * Cache Custom CSS
				 */
				'cache_custom_css'                            => false,
				/**
				 * Icons.
				 */
				'icon_set'                                    => 'svg',
				/**
				 * Container layout
				 */
				'container_layout'                            => 'full',
				'container_width'                             => array(
					'value' => '1200',
					'unit'  => 'px',
				),				
				/**
				 * Background
				 */
				'body_bg_image'                               => '',							
				'body_bg_image_position'                      => 'center center',				
				'body_bg_image_size'                          => 'auto',				
				'body_bg_image_repeat'                        => false,				
				'body_bg_image_attachement'                   => false,
				'body_bg_color'                               => '#ffffff',
				'content_bg_color'                            => '#f9f9f9',
				/**
				 * Sidebar
				 */
				'sidebar_layout'                              => 'right',
				'sidebar_layout_post'                         => 'default',
				'sidebar_layout_page'                         => 'default',
				'sidebar_layout_archive'                      => 'default',
				'sidebar_breakpoint'                          => 'small',
				'sidebar_width'                               => array(
					'value' => '30',
					'unit'  => '%',
				),
				'sidebar_bg_color'                            => '#f9f9f9',
				'sidebar_separate_container'                  => false,
				'sidebar_separator'                           => false,
				'sidebar_separator_spacing'                   => array(
					'value' => '20',
					'unit'  => 'px',
				),
				'sidebar_font_color'                          => '',
				'sidebar_link_color'                          => '',
				'sidebar_link_color_hover'                    => '',
				'sidebar_headings_color'                      => '',
				'sidebar_font_size_desktop'                   => array(
					'value' => '14',
					'unit'  => 'px',
				),
				'sidebar_font_size_tablet'                    => array(
					'value' => '',
					'unit'  => 'px',
				),
				'sidebar_font_size_mobile'                    => array(
					'value' => '',
					'unit'  => 'px',
				),
				/**
				 * Header Layout
				 */
				'header_layout'                               => 'nav_inline',
				'header_width'                                => 'content',
				'header_alignment'                            => 'center',
				'header_bg_color'                             => '#ffffff',
				'header_border_bottom_width'                  => array(
					'value' => '1',
					'unit'  => 'px',
				),
				'header_border_bottom_color'                  => '#f9f9f9',
				'header_enable_widgets'                       => 'disabled',				
				'header_bg_image'                             => '',							
				'header_bg_image_position'                    => 'center center',				
				'header_bg_image_size'                        => 'auto',				
				'header_bg_image_repeat'                      => false,				
				'header_bg_image_attachement'                 => false,
				/**
				 * Site Identity
				 */
				'logo_width_desktop'                          => array(
					'value' => '200',
					'unit'  => 'px',
				),
				'logo_width_tablet'                           => array(
					'value' => '',
					'unit'  => 'px',
				),
				'logo_width_mobile'                           => array(
					'value' => '',
					'unit'  => 'px',
				),
				'mobile_logo'                                 => '',
				'mobile_logo_width'                           => array(
					'value' => '200',
					'unit'  => 'px',
				),
				'display_title'                               => true,
				'display_tagline'                             => true,
				'title_font_size_desktop'                     => array(
					'value' => '',
					'unit'  => 'px',
				),
				'title_font_size_tablet'                      => array(
					'value' => '',
					'unit'  => 'px',
				),
				'title_font_size_mobile'                      => array(
					'value' => '',
					'unit'  => 'px',
				),
				'title_text_transform'                        => '',
				'tagline_font_size_desktop'                   => array(
					'value' => '',
					'unit'  => 'px',
				),
				'tagline_font_size_tablet'                    => array(
					'value' => '',
					'unit'  => 'px',
				),
				'tagline_font_size_mobile'                    => array(
					'value' => '',
					'unit'  => 'px',
				),
				'title_font_color'                            => '',
				'title_font_color_hover'                      => '',
				'title_font_family'                           => '',
				'title_font_variant'                          => '',
				'tagline_font_color'                          => '',
				/**
				 * Navigation
				 */
				'nav_alignment'                               => 'center',
				'menu_bg_color'                               => '',
				'submenu_bg_color'                            => '#ffffff',
				'menu_item_width'                             => array(
					'value' => '10',
					'unit'  => 'px',
				),
				'menu_item_height'                            => array(
					'value' => '60',
					'unit'  => 'px',
				),
				'submenu_item_height'                         => array(
					'value' => '50',
					'unit'  => 'px',
				),
				'submenu_width'                               => array(
					'value' => '200',
					'unit'  => 'px',
				),
				'menu_dropdown_target'                        => 'hover',
				'menu_font_family'                            => '',
				'menu_font_variant'                           => '',
				'menu_text_transform'                         => '',
				'menu_font_size'                              => array(
						'value' => '',
						'unit'  => 'px',
					),
				'submenu_font_family'                         => '',
				'submenu_font_variant'                        => '',
				'submenu_text_transform'                      => '',
				'submenu_font_size'                           => array(
						'value' => '',
						'unit'  => 'px',
					),

				'submenu_font_size'                           => array(
					'value' => '',
					'unit'  => 'px',
				),

				'menu_link_color'                             => '',
				'menu_link_color_hover'                       => '',
				'submenu_link_color'                          => '',
				'submenu_link_color_hover'                    => '',
				'mobile_menu_breakpoint'                      => 'small',
				'toggle_button_text'                          => 'Menu',
				'menu_widget_area'                            => 'disabled',
				'mobile_menu_bg_color'                        => '#f9f9f9',
				'mobile_menu_link_color'                      => '',
				'mobile_menu_link_color_hover'                => '',
				'mobile_submenu_bg_color'                     => '',
				'mobile_submenu_link_color'                   => '',
				'mobile_submenu_link_color_hover'             => '',
				'mobile_menu_widget_area'                     => 'disabled',
				'mobile_menu_item_width'                      => array(
				'value' => '20',
				'unit'  => 'px',
				),
				'mobile_menu_item_height'                     => array(
					'value' => '50',
					'unit'  => 'px',
				),
				'mobile_menu_font_size'                       => array(
					'value' => '',
					'unit'  => 'px',
				),
				/**
				 * Footer
				 */
				'footer_widget_areas'                         => '3',
				'footer_width'                                => 'content',
				'footer_bg_color'                             => '#f9f9f9',
				'footer_headings_color'                       => '',
				'footer_font_color'                           => '',
				'footer_link_color'                           => '',
				'footer_link_color_hover'                     => '',
				'footer_widgets_heading_color'                => '',
				'footer_font_size_desktop'                    => array(
					'value' => '14',
					'unit'  => 'px',
				),
				'footer_font_size_tablet'                     => array(
					'value' => '',
					'unit'  => 'px',
				),
				'footer_font_size_mobile'                     => array(
					'value' => '',
					'unit'  => 'px',
				),
				/**
				 * Typography
				 */
				'body_font_family'                            => 'inherit',
				'body_font_variant'                           => '',
				'body_font_size_desktop'                      => array(
					'value' => '14',
					'unit'  => 'px',
				),
				'body_font_size_tablet'                       => array(
					'value' => '',
					'unit'  => 'px',
				),
				'body_font_size_mobile'                       => array(
					'value' => '',
					'unit'  => 'px',
				),
				'body_line_height'                            => '1.5',
				'body_text_transform'                         => '',
				'paragraph_spacing'                           => array(
					'value' => '1.5',
					'unit'  => 'em',
				),
				'body_font_color'                             => '#3d3d3d',
				'body_link_color'                             => '#3399cc',
				'body_link_color_hover'                       => '#006699',
				'headings_font_family'                        => '',
				'headings_font_variant'                       => '',
				'headings_line_height'                        => '1.5',
				'headings_text_transform'                     => '',
				'headings_font_color'                         => '#3d3d3d',
				'headings_spacing'                            => array(
					'value' => '0.625',
					'unit'  => 'em',
				),
				'h1_font_family'                              => '',
				'h1_font_variant'                             => '',
				'h1_text_transform'                           => '',
				'h1_font_size_desktop'                        => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h1_font_size_tablet'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h1_font_size_mobile'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h1_line_height'                              => '',			
				'h1_spacing_bottom'                           => array(
					'value' => '',
					'unit'  => 'em',
				),			
				'h1_font_color'                               => '',
				'h1_entry_title_font_size_desktop'            => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h1_entry_title_font_size_tablet'             => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h1_entry_title_font_size_mobile'             => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h1_entry_title_font_color'                   => '',
				'h2_font_family'                              => '',
				'h2_font_variant'                             => '',
				'h2_font_size_desktop'                        => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h2_font_size_tablet'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h2_font_size_mobile'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h2_line_height'                              => '',
				'h2_spacing_bottom'                           => array(
					'value' => '',
					'unit'  => 'em',
				),
				'h2_text_transform'                           => '',
				'h2_font_color'                               => '',
				'h2_entry_title_font_size_desktop'            => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h2_entry_title_font_size_tablet'             => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h2_entry_title_font_size_mobile'             => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h2_entry_title_line_height'                  => '',
				'h2_entry_title_text_transform'               => '',
				'h2_entry_title_link_color'                   => '',
				'h2_entry_title_link_color_hover'             => '',
				'h3_font_family'                              => '',
				'h3_font_variant'                             => '',
				'h3_font_size_desktop'                        => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h3_font_size_tablet'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h3_font_size_mobile'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h3_line_height'                              => '',
				'h3_spacing_bottom'                           => array(
					'value' => '',
					'unit'  => 'em',
				),
				'h3_text_transform'                           => '',
				'h3_font_color'                               => '',
				'h4_font_family'                              => '',
				'h4_font_variant'                             => '',
				'h4_font_size_desktop'                        => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h4_font_size_tablet'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h4_font_size_mobile'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h4_line_height'                              => '',
				'h4_text_transform'                           => '',
				'h4_font_color'                               => '',
				'h5_font_family'                              => '',
				'h5_font_variant'                             => '',
				'h5_font_size_desktop'                        => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h5_font_size_tablet'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h5_font_size_mobile'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h5_line_height'                              => '',
				'h5_text_transform'                           => '',
				'h5_font_color'                               => '',
				'h6_font_family'                              => '',
				'h6_font_variant'                             => '',
				'h6_font_size_desktop'                        => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h6_font_size_tablet'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h6_font_size_mobile'                         => array(
					'value' => '',
					'unit'  => 'px',
				),
				'h6_line_height'                              => '',
				'h6_text_transform'                           => '',
				'h6_font_color'                               => '',
				/**
				 * Breadcrumbs
				 */
				'breadcrumbs'                                 => 'disabled',
				'disable_breadcrumbs_front_page'              => false,
				'disable_breadcrumbs_page'                    => false,
				'disable_breadcrumbs_blog'                    => false,
				'disable_breadcrumbs_single'                  => false,
				'disable_breadcrumbs_archive'                 => false,
				'disable_breadcrumbs_search'                  => false,
				'disable_breadcrumbs_404'                     => false,
				'breadcrumbs_separator'                       => '\\',
				/**
				 * Content
				 */
				'blog_post_layout'                            => 'thumbnail_left',
				'blog_post_meta_icons'                        => 'enabled',
				'blog_post_meta_items'                        => array(
					'posted_on',
					'posted_by',
					'comments',
					'categories',
					'tags',
				),
				'blog_post_excerpt'                           => 'excerpt',
				'blog_post_structure_featured_image'          => array(
					'post_thumbnail',
					'post_title',
					'post_meta',
					'post_content',
				),
				'blog_post_structure_thumbnail'               => array(
					'post_title',
					'post_meta',
					'post_content',
				),
				'blog_container_width'                        => array(
					'value' => '',
					'unit'  => 'px',
				),
				'single_post_structure_featured_image_full_width' => array(
					'post_title',
					'post_meta',
					'post_content',
				),
				'single_post_structure_featured_image_inside_content' => array(
					'post_thumbnail',
					'post_title',
					'post_meta',
					'post_content',
				),
				'single_post_meta_items'                      => array(
					'posted_on',
					'posted_by',
					'comments',
					'categories',
					'tags',
				),
				'single_post_container_width'                 => array(
					'value' => '',
					'unit'  => 'px',
				),
				'single_post_layout'                          => 'inside_content',
				/**
				 * Buttons
				 */
				'button_font_color'                           => '#ffffff',
				'button_font_color_hover'                     => '#ffffff',
				'button_bg_color'                             => '#3399cc',
				'button_bg_color_hover'                       => '#006699',
				'button_border_radius'                        => array(
					'value' => '0',
					'unit'  => 'px',
				),
				'button_spacing'                              => array(
					'top'    => '10',
					'right'  => '15',
					'bottom' => '10',
					'left'   => '15',
					'unit'   => 'px',
				),
				'button_border_width'                         => array(
					'value' => '0',
					'unit'  => 'px',
				),
				'button_border_color'                         => '',
				'button_border_color_hover'                   => '',
				/*
				 * Forms
				 */
				'form_spacing'                                => array(
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10',
					'unit'   => 'px',
				),				
				'form_bg_color'                               => '#f9f9f9',
				'form_border_radius'                          => array(
					'value' => '0',
					'unit'  => 'px',
				),
				'form_border_width'                           => array(
					'value' => '1',
					'unit'  => 'px',
				),
				'form_border_color'                           => '#eeeeee',
				'form_border_color_focus'                     => '#f9f9f9',

			)
		);

		return self::$defaults;

	}
	
	/**
	 * Get default value for a specific key.
	 *
	 * @since  1.1.0
	 * @return $default Default value.
	 */
	public static function get_default( $key ) {
		
		if ( array_key_exists( $key, self::$defaults ) ) {
			
			return self::$defaults[ $key ];
			
		}
		
	}

}
