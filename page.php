<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package haliyora
 */

get_header();
?>

<div class="shadcn-container">
	<div class="content-wrapper">
		<main id="primary" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post();
				?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
					<header class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</header>

					<div class="page-content">
						<?php
						the_content();

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'haliyora' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>

				</article>

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
