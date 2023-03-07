<?php
/**
 * Template part for displaying the menu toggle button.
 *
 * @package octo
 * @since   1.0.0
 */

use octo\options\Options;
use octo\helper\Common;

// Get them options.
$toggle_button_text = Options::get_theme_option( 'toggle_button_text' );

?>
<div class="menu-toggle">
	<div class="menu-toggle-inner">
		<a class="menu-toggle-button" aria-controls="primary-menu" aria-expanded="false">
			<span class="menu-toggle-icon"><?php Common::get_icon( 'burger_menu', true ); Common::get_icon( 'close', true ); ?></span>
			<?php if ( $toggle_button_text ) : ?>
			<span class="menu-toggle-text"><?php echo esc_html( $toggle_button_text ); ?></span>
			<?php endif; ?>
		</a>
	</div>
</div>
