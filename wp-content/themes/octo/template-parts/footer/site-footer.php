<?php
/**
 * Displays the site footer.
 *
 * @package octo
 * @since   1.0.0
 */

use octo\options\Options;
use octo\helper\Common;
use octo\frontend\Components;

$footer_widget_areas = Options::get_theme_option( 'footer_widget_areas' );
?>
<footer id="colophon" <?php Components::footer_class(); ?>>
	<?php do_action( 'octo_above_main_footer' ); ?>
	<?php if ( Common::show_widget_area( 'footer' ) && Common::show_main_footer() ) : ?>
		<div id="main-footer" class="main-footer">
			<div class="site-container">
				<div class="site-container-inner">

				<?php for ( $i = 1; $i <= $footer_widget_areas; $i++ ) { ?>
					<div class="footer-widget-area-<?php esc_attr( $i ); ?> footer-widget-area">
					<?php dynamic_sidebar( 'octo-footer-' . $i ); ?>
					</div>
				<?php } ?>

				</div><!-- .site-container-inner -->
			</div><!-- .site-container -->
		</div><!-- #main-footer -->
	<?php endif; ?>
	<?php do_action( 'octo_below_main_footer' ); ?>
</footer><!-- #colophon -->
