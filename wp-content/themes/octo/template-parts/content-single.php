<?php
/**
 * Template part for displaying posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package octo
 * @since   1.0.0
 */

use octo\frontend\Content;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-inner">
		<?php Content::post_inner(); ?>
	</div><!-- .post-inner -->
</article><!-- #post-<?php the_ID(); ?> -->
