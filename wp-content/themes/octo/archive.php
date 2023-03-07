<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package octo
 * @since   1.0.0
 */

use octo\frontend\Components;
use octo\frontend\Template_Parts;
get_header();
?>
<?php do_action( 'octo_before_content' ); ?>
<div id="content" class="site-content">
	<div class="site-container">
		<div class="site-container-inner">                    
			<main id="primary" class="site-main">                
				<div class="site-main-inner">
					<?php do_action( 'octo_before_content_inner' ); ?>
					<?php Components::breadcrumb_trail(); ?>
					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
							?>
						</header><!-- .page-header -->
						<div class="site-posts">
						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							Template_Parts::load_content( 'archive' );
							
						endwhile;
						?>
					</div><!-- .site-posts -->
					<?php
					Components::posts_pagination();

					else :

						Template_Parts::load_content( 'none' );

					endif;
					?>
					<?php do_action( 'octo_after_content_inner' ); ?>
				</div>
			</main><!-- #main -->
			<?php get_sidebar(); ?>
		</div><!-- .site-container-inner -->
	</div><!-- .site-container -->
</div><!-- #content -->
<?php do_action( 'octo_after_content' ); ?>
<?php
get_footer();
