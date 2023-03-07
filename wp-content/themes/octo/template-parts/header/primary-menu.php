<?php
/**
 * Template part for displaying the navigation menu.
 *
 * @package octo
 * @since   1.0.0
 */

use octo\helper\Common;
use octo\frontend\Components;
?>
<nav id="site-navigation" <?php Components::main_nav_class(); ?>>
	<div class="nav-container">
		<div class="nav-container-inner">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<?php 
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_id'    => 'primary-menu',
						'container_class' => 'nav-menu primary',
						'menu_class'      => 'menu',
					)
				)
			?>
			<?php endif; ?>
			<?php if ( Common::show_widget_area( 'main_nav' ) ) : ?>
			<div class="nav-widget-area">
				<?php dynamic_sidebar( 'octo-navigation' ); ?>
			</div>
			<?php endif; ?>
		</div><!-- .nav-container-inner -->
	</div><!-- .nav-container -->
</nav><!-- #site-navigation -->
