<?php
/**
 * Template part for displaying the custom logo and the site title.
 *
 * @package octo
 * @since   1.0.0
 */

use octo\options\Options as Options;
use octo\frontend\Components as Components;

$site_title      = get_bloginfo( 'name' );
$description     = get_bloginfo( 'description', 'display' );
$display_title   = Options::get_theme_option( 'display_title' );
$display_tagline = Options::get_theme_option( 'display_tagline' );
$custom_logo_id  = get_theme_mod( 'custom_logo' );
$mobile_logo_id  = Options::get_theme_option( 'mobile_logo' );
?>

<?php if ( $display_title || $display_tagline || has_custom_logo() ) : ?>
	<div class="site-branding">    
		<?php if ( has_custom_logo() ) : ?>
		<?php	
				// Load custom logo.
				Components::custom_logo(
					$custom_logo_id,
					'custom-logo-link ',
					array(
						'class' => 'custom-logo',
						'size'  => 'octo-logo-size',
					)
				);

				// Load mobile logo.
				Components::custom_logo(
					$mobile_logo_id,
					'custom-logo-link mobile',
					array(
						'class' => 'custom-logo-mobile',
						'size'  => 'octo-mobile-logo-size',
					)
				);	
		?>
		<?php else : ?>
			<?php if ( $display_title ) : ?>
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( $site_title ); ?></a></h1>
				<?php else : ?>
					<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( $site_title ); ?></a></div>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ( $description && $display_tagline ) : ?>
				<p class="site-description"><?php echo esc_html( $description ); ?></p>        
			<?php endif; ?>
		<?php endif; ?>
	</div><!-- .site-branding -->
<?php endif; ?>
