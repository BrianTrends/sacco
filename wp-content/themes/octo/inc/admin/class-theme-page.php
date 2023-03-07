<?php
/**
 * Theme Page class.
 *
 * @package octo
 * @since   1.0.3
 */

namespace octo\admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class adds a theme page in the backend to provide certain informations and to set up the theme basics.
 *
 * @since 1.0.3
 */
class Theme_Page {

	/**
	 * Init
	 *
	 * @since 1.0.3
	 */
	public static function init() {
		add_action( 'admin_menu', array( 'octo\admin\Theme_Page', 'add_theme_page' ) );
	}

	/**
	 * Add theme page.
	 *
	 * @since 1.0.3
	 */
	public static function add_theme_page() {
		
		$page_title = __( 'Octo', 'octo' );
		$menu_title = __( 'Octo', 'octo' );
		$capability = 'manage_options';
		$menu_slug = 'octo-settings';
		$function = array( 'octo\admin\Theme_Page', 'theme_page_callback' );

		add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );

	}
	
	/**
	 * Add theme page.
	 *
	 * @since 1.0.3
	 */
	public static function theme_page_callback() {		
		?>
		<div class="octo-theme-page octo-theme-page-container">
			<div class="octo-theme-page-container-inner">
				<div class="octo-theme-page-header">
					<div class="octo-theme-page-logo">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/octo-logo.png' ); ?>" alt="Octo ">
					</div>
					<div class="octo-theme-page-version">
						<?php esc_html_e( 'Version: ' . OCTO_VERSION, 'octo' ) ; ?>
					</div>					
				</div>
				<div class="octo-theme-page-content">
					<div class="octo-theme-page-main">
						<div class="octo-theme-page-customizer-settings octo-theme-page-content-box">
							<h2><?php esc_html_e( 'Customizer Settings', 'octo' ); ?></h2>
							<?php esc_html_e( 'Start setting up your theme by using the theme customizer. Explore the variety of options you can choose from to adapt the theme to your needs. ', 'octo' ); ?>
							<ul>
								<li>
									<span class="dashicons dashicons-layout"></span><a href="<?php echo admin_url( '/customize.php?autofocus[section]=octo_section_general_container' ); ?>"><?php esc_html_e( 'Site Layout', 'octo' ); ?></a>
								</li>
								<li>
									<span class="dashicons dashicons-format-image"></span><a href="<?php echo admin_url( '/customize.php?autofocus[section]=octo_section_header_site_identity' ); ?>"><?php esc_html_e( 'Upload Logo', 'octo' ); ?></a>
								</li>
								<li>
									<span class="dashicons dashicons-align-center"></span><a href="<?php echo admin_url( '/customize.php?autofocus[section]=octo_section_header_layout' ); ?>"><?php esc_html_e( 'Header', 'octo' ); ?></a>
								</li>
								<li>
									<span class="dashicons dashicons-align-wide"></span></span><a href="<?php echo admin_url( '/customize.php?autofocus[section]=octo_section_footer_widget_areas' ); ?>"><?php esc_html_e( 'Footer', 'octo' ); ?></a>
								</li>
								<li>
									<span class="dashicons dashicons-editor-textcolor"></span><a href="<?php echo admin_url( '/customize.php?autofocus[panel]=octo_panel_typography' ); ?>"><?php esc_html_e( 'Typography', 'octo' ); ?></a>
								</li>								
								<li>
									<span class="dashicons dashicons-welcome-write-blog"></span><a href="<?php echo admin_url( '/customize.php?autofocus[panel]=octo_section_content_archive' ); ?>"><?php esc_html_e( 'Blog Layout', 'octo' ); ?></a>
								</li>
								<li>
									<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo admin_url( '/customize.php' ); ?>"><?php esc_html_e( 'All Customizer Options', 'octo' ); ?></a>
								</li>
							</ul>
						</div>
					</div>
					<div class="octo-theme-page-sidebar">
						<div class="octo-theme-page-support octo-theme-page-content-box">
							<h2><?php esc_html_e( 'Help and Support', 'octo' ); ?></h2>
							<p>
								<?php esc_html_e( 'If you need help setting up the theme, just reach out to us. Also in case of any errors or issues with our theme, don´t hesitate to create a post in the support forum.', 'octo' ); ?>
							</p>
							<a href="<?php echo esc_url( 'https://wordpress.org/support/theme/octo' ); ?>" class="button button-primary button-larger">Support Forum</a>
						</div>
						<div class="octo-theme-page-review octo-theme-page-content-box">
							<h2><?php esc_html_e( 'Leave a Review', 'octo' ); ?></h2>
							<p>
								<?php esc_html_e( 'Do you like our theme? Tell us what you think and leave a review. We highly appreciate your feedback.', 'octo' ); ?>
							</p>
							<a href="<?php echo esc_url( 'https://wordpress.org/support/theme/octo/reviews/#new-post' ); ?>" class="button button-primary button-larger">Write a Review</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php		
	}

}
