<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
					<?php
					do_action( 'octo_before_content_inner' );
					Components::breadcrumb_trail();
					if ( have_posts() ) :
						if ( is_home() && ! is_front_page() ) :
							?>
							<header>
								<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
							</header>
							<?php
						endif;
					?>
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
							Template_Parts::load_content( 'index' );

						endwhile;
						
						?>
						</div><!-- .site-posts -->
						<?php
						Components::posts_pagination();

						else :
							Template_Parts::load_content( 'none' );

						endif; ?>					
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
