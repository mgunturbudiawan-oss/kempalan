<?php
/**
 * The template for displaying kategori foto archive pages
 *
 * @package haliyora
 */

get_header();
?>

<div class="shadcn-container">
	<div class="content-wrapper">
		<main id="primary" class="site-main">
			
			<header class="page-header">
				<h1 class="page-title">
					<span class="material-icons">collections</span>
					<?php single_term_title(); ?>
				</h1>
				<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
			</header>

			<?php if ( have_posts() ) : ?>
				<div class="photo-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'berita_foto' );
					endwhile;
					?>
				</div>

				<?php
				// Pagination
				the_posts_pagination( array(
					'prev_text' => '<span class="material-icons">chevron_left</span>',
					'next_text' => '<span class="material-icons">chevron_right</span>',
				) );
				?>

			<?php else : ?>
				<div class="no-posts-found">
					<span class="material-icons">search_off</span>
					<p>Belum ada berita foto di kategori ini.</p>
				</div>
			<?php endif; ?>

		</main><!-- #main -->

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
