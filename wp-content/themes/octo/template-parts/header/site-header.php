<?php
/**
 * Displays the site header.
 *
 * @package octo
 * @since   1.0.0
 */

use octo\helper\Common;
use octo\frontend\Components;
use octo\frontend\Template_Parts;
?>

<header id="masthead" <?php Components::header_class(); ?>>
	<?php do_action( 'octo_above_main_header' ); ?>
	<?php if ( Common::show_main_header() ) : ?>
	<div id="main-header" class="main-header">
		<?php Template_Parts::load_main_header(); ?>
	</div><!-- #main-header -->
	<?php endif; ?>
	<?php do_action( 'octo_below_main_header' ); ?>
</header><!-- #masthead -->