<?php
/**
 * Template part for displaying the mobile navigation menu.
 *
 * @package octo
 * @since   1.0.7
 */

use octo\helper\Common;
use octo\frontend\Components;
?>
<nav id="site-mobile-navigation" <?php Components::mobile_nav_class(); ?>>
	<div class="nav-container">
		<div class="nav-container-inner">
			<?php if ( has_nav_menu( 'mobile' ) ) : ?>
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'mobile',
					'container_id'    => 'mobile-menu',
					'container_class' => 'nav-menu mobile',
					'menu_class'      => 'menu',
				)
			);
			?>
			<?php endif; ?>
			<?php if ( Common::show_widget_area( 'mobile_nav' ) ) : ?>
			<div class="nav-widget-area">
				<?php dynamic_sidebar( 'octo-navigation' ); ?>
			</div>
			<?php endif; ?>
		</div><!-- .nav-container-inner -->
	</div><!-- .nav-container -->
</nav><!-- #site-navigation -->
