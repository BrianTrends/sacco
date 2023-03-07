<?php
/**
 * Template part for displaying header row layout.
 *
 * @package octo
 * @since: 1.0.0
 */

use octo\frontend\Template_Parts;

?>
<div class="site-container">
	<div class="site-container-inner">
		<?php Template_Parts::load_site_branding(); ?>
		<?php Template_Parts::load_header_widget_area(); ?>       
	</div><!-- .site-container-inner -->
</div><!-- .site-container -->
<?php Template_Parts::load_menu_toggle_button(); ?>
<?php Template_Parts::load_primary_menu(); ?>
<?php Template_Parts::load_mobile_menu(); ?>