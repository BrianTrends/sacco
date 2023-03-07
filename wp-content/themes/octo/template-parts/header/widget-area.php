<?php
/**
 * Template part for displaying the header widget area.
 *
 * @package octo
 * @since   1.0.0
 */

use octo\helper\Common;
?>

<?php if ( Common::show_widget_area( 'header' ) ) : ?>
<div class="header-widget-area">
	<?php dynamic_sidebar( 'octo-header' ); ?>
</div>
<?php endif; ?>
