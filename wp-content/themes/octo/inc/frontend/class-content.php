<?php
/**
 * Content class.
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\frontend;

use octo\helper\Common;
use octo\options\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class creates html code for the content.
 * It is also responsible for custom template tags for this theme.
 *
 * @since 1.0.0
 */
class Content {

	/**
	 * Register WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_filter( 'excerpt_more', array( $this, 'excerpt_read_more' ) );
		add_filter( 'the_content_more_link', array( $this, 'content_read_more' ) );
	}

	/**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @since 1.0.0
	 */
	public static function get_posted_on() {

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		// Get meta icon.
		$meta_icon = self::get_meta_icon( 'posted_on' );

		$posted_on = $meta_icon . '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

		return '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}

	/**
	 * Prints HTML with meta information for the current author.
	 *
	 * @since 1.0.0
	 */
	public static function get_posted_by() {

		// Get meta icon.
		$meta_icon = self::get_meta_icon( 'posted_by' );

		$author = $meta_icon . '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';

		return '<span class="author"> ' . $author . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}

	/**
	 * Prints HTML with meta information for the categories.
	 *
	 * @since 1.0.0
	 */
	public static function get_post_categories() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Variable to store html code.
			$html = '';

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ',&#8194;', 'octo' ) );
			if ( $categories_list ) {
				// Get meta icon.
				$meta_icon = self::get_meta_icon( 'post_categories' );

				/* translators: 1: list of categories. */
				$html .= '<span class="cat-links">' . $meta_icon . $categories_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			return $html;

		}

	}

	/**
	 * Prints HTML with meta information for the tags.
	 *
	 * @since 1.0.0
	 */
	public static function get_post_tags() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Variable to store html code.
			$html = '';

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ',&#8194;', 'list item separator', 'octo' ) );
			if ( $tags_list ) {
				// Get meta icon.
				$meta_icon = self::get_meta_icon( 'post_tags' );

				/* translators: 1: list of tags. */
				$html .= '<span class="tags-links">' . $meta_icon . wp_kses_post( $tags_list ) . '</span>';
			}

			return $html;

		}

	}

	/**
	 * Prints HTML with meta information for the comments.
	 *
	 * @since 1.0.0
	 */
	public static function get_post_comments() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

			// Variable to store html code.
			$html = '';

			// Get meta icon.
			$meta_icon = self::get_meta_icon( 'post_comments' );

			$html .= '<span class="comments-link">' . $meta_icon;

			ob_start();
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'octo' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			$html .= ob_get_contents();
			ob_end_clean();

			$html .= '</span>';

			return $html;

		}

	}

	/**
	 * Prints HTML with all meta informations in a given order.
	 *
	 * @since 1.0.0
	 */
	public static function get_post_meta() {

		
		if ( is_single() ) {
			$meta_items = Options::get_theme_option( 'single_post_meta_items' );
		} else {
			$meta_items = Options::get_theme_option( 'blog_post_meta_items' );
		}

		if ( is_array( $meta_items ) && ! empty( $meta_items ) && 'post' === get_post_type() ) {

			// Variable to store html code for meta icons.
			$meta_items_ordered = '';

			// Hook for changing meta separator icon.
			$separator = apply_filters( 'octo_meta_icons_separator', '-' );

			// Bring everything in order.
			$count_items = count( $meta_items );
			for ( $i = 0; $i < $count_items; $i++ ) {

				$meta_item = '';

				switch ( $meta_items[ $i ] ) {
					case 'posted_on':
						$meta_item = self::get_posted_on();
						break;
					case 'posted_by':
						$meta_item = self::get_posted_by();
						break;
					case 'categories':
						$meta_item = self::get_post_categories();
						break;
					case 'tags':
						$meta_item = self::get_post_tags();
						break;
					case 'comments':
						$meta_item = self::get_post_comments();
						break;
				}

				if ( $meta_item ) {
					
					$blog_post_meta_icons = Options::get_theme_option( 'blog_post_meta_icons' );

					// Add a separator, if meta icons are disabled.
					if ( 'disabled' === $blog_post_meta_icons && $i < $count_items && 0 !== $i ) {
						$meta_items_ordered .= '<span class="meta-icon-separator">' . esc_html( $separator ) . '</span>';
					}

					$meta_items_ordered .= $meta_item;
				}
			}

			$html = sprintf(
				'<div class="entry-meta">
					%s    
				</div><!-- .entry-meta -->',
				$meta_items_ordered
			);
			
			return $html;

		}

	}
	
	/**
	 * Prints HTML with the content or excerpt.
	 *
	 * @since 1.1.0
	 */
	public static function get_post_content() {

		// Get theme options.
		$blog_post_excerpt = Options::get_theme_option( 'blog_post_excerpt' );

		if ( ! is_single() && 'excerpt' === $blog_post_excerpt ) {
			ob_start();
			the_excerpt();
			$content = ob_get_contents();
			ob_end_clean();
			$class = 'entry-summary';
        } else {
			ob_start();
			the_content();
			$content = ob_get_contents();
			ob_end_clean();
			$class = 'entry-content';
		}

		$html = sprintf(
			'<div class="%1$s">
				%2$s    
			</div><!-- .%1$s -->',
			esc_attr( $class ),
			$content, 
		);
		
		return $html;

	}
	
	/**
	 * Prints HTML with title, thumbnail meta icons and content in a given order.
	 *
	 * @since 1.1.0
	 */
	public static function post_inner() {
		
		// Declare needed variables.
		$thumbnail = '';
		$html = '';
		
		// Determin, if if is a blog post or single post.
		if ( is_single() ) {
			
			$single_post_layout = Options::get_theme_option( 'single_post_layout' );

			if ( is_single() && 'full_width' === $single_post_layout ) {
				$order = Options::get_theme_option( 'single_post_structure_featured_image_full_width' );
			} else {
				$order = Options::get_theme_option( 'single_post_structure_featured_image_inside_content' );
			}
			
		} else {
			
			// Get theme options.
			$blog_post_layout = Options::get_theme_option( 'blog_post_layout' );
			
			// Depending on the choosen blog post layout we have to use a different blog post structure.
			if ( 'featured_image' === $blog_post_layout ) {
				$order = Options::get_theme_option( 'blog_post_structure_featured_image' );	
			} else {
				$order = Options::get_theme_option( 'blog_post_structure_thumbnail' );
			}
			
			// In case the thumbnail is shown on the right or left side of the content, the thumbnail needs to be inserted before the post content container.						
			if ( 'thumbnail_left' === $blog_post_layout || 'thumbnail_right' === $blog_post_layout ) {
				$thumbnail = self::get_post_thumbnail();
			}
			
		}

		// Bring everything in order.
		if ( is_array( $order ) && ! empty( $order ) ) {

			foreach ( $order as $element ) {

				switch ( $element ) {
					case 'post_title':
						$html .= self::get_post_title();
						break;
					case 'post_thumbnail':
						$html .= self::get_post_thumbnail();
						break;
					case 'post_meta':
						$html .= self::get_post_meta();
						break;
					case 'post_content':
						$html .= self::get_post_content();
						break;
				}
			}
			
			printf( '%1$s<div class="post-content">%2$s</div><!-- .post-content -->',
			   $thumbnail,
			   $html
			); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		}

	}

	/**
	 * Returns html code for a meta icon.
	 *
	 * @param String $meta_item Meta Item.
	 * @since 1.0.0
	 */
	private static function get_meta_icon( $meta_item ) {

		// Get theme option.
		$blog_post_meta_icons = Options::get_theme_option( 'blog_post_meta_icons' );

		if ( 'disabled' !== $blog_post_meta_icons ) {
			switch ( $meta_item ) {
				case 'posted_on':
					$icon = Common::get_icon( 'calendar' );
					break;
				case 'posted_by':
					$icon = Common::get_icon( 'user' );
					break;
				case 'post_categories':
					$icon = Common::get_icon( 'category' );
					break;
				case 'post_tags':
					$icon = Common::get_icon( 'tag' );
					break;
				case 'post_comments':
					$icon = Common::get_icon( 'comment' );
					break;
			}

			return $icon;
		}
	}

	/**
	 * Returns HTML code for an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @since 1.0.0
	 */
	public static function get_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) {

			// Get metabox settings.
			$show_featured_image = Common::show_featured_image();

			if ( $show_featured_image ) {
				$html = sprintf(
					'<div class="post-thumbnail">%s</div><!-- .post-thumbnail -->',
					get_the_post_thumbnail( null, apply_filters('octo_single_post_image_size', 'full' ), null )
				);
			} else {
				$html = '';
			}
		} else {

			$attr = array(
				'alt' => the_title_attribute(
					array(
						'echo' => false,
					)
				),
			);
			
			$thumbnail = get_the_post_thumbnail( null, apply_filters('octo_blog_post_image_size', 'full' ), $attr );

			$html = sprintf(
				'<a class="post-thumbnail" href="%1$s" aria-hidden="true" tabindex="-1">%2$s</a>',
				esc_url( get_permalink() ),
				$thumbnail
			);

		}

		return $html;

	}

	/**
	 * Prints an optional post thumbnail.
	 *
	 * @since 1.0.0
	 */
	public static function post_thumbnail() {

		echo self::get_post_thumbnail(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped	
		
	}

	/**
	 * Returns HTML code with post title.
	 *
	 * @since 1.0.0
	 */
	public static function get_post_title() {

		if ( is_singular() ) {
			$disable_title = Common::show_title();
			if ( $disable_title ) {
				$heading = the_title( '<h1 class="entry-title">', '</h1>', false );
			} else {
				$heading = '';
			}
		} else {
			$heading = the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>', false );
		}
		
		$html = sprintf( 
			'<header class="entry-header">%s</header><!-- .entry-header -->',
			$heading
		); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		return $html;

	}

	/**
	 * Prints read more link HTML after the excerpt.
	 *
	 * @since 1.0.0
	 */
	public function excerpt_read_more( $more ) {

		$read_more_link = self::read_more_link();
		
		$html = ' &hellip;<p>' . $read_more_link . '</p>';

		return $html;

	}
	
	/**
	 * Prints read more link HTML after the content.
	 *
	 * @since 1.1.0
	 */
	public function content_read_more() {
		
		$read_more_link = self::read_more_link();

		$html = '<p>' . $read_more_link . '</p>';

		return $html;

	}
	
	/**
	 * Prints read more HTML link tag.
	 *
	 * @since 1.1.0
	 */
	private static function read_more_link() {

		$read_more_text = apply_filters( 'octo_read_more_text', __( 'Read more', 'octo' ) );
		
		$classes = apply_filters( 'octo_read_more_classes', array( 'more-link' ) );		
		$class = join( ' ', $classes );

		$link = sprintf(
			esc_html( '%s' ),
			'<a class="' . esc_attr( $class ) . '" href="' . esc_url( get_permalink() ) . '"> ' . the_title( '<span class="screen-reader-text">', '</span>', false ) . $read_more_text . '</a>'
		);

		return $link;

	}

}
