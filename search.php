<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package haliyora
 */

get_header();
?>

<style>
@media (max-width: 768px) {
	/* Hanya untuk search page - jangan ganggu single post */
	body.search:not(.single):not(.single-post):not(.singular) .container-1100,
	body.search-results:not(.single):not(.single-post):not(.singular) .container-1100 {
		padding: 0 !important;
		margin-left: 0 !important;
		margin-right: 0 !important;
	}
	
	body.search:not(.single):not(.single-post):not(.singular) .page-header,
	body.search-results:not(.single):not(.single-post):not(.singular) .page-header {
		padding-left: 15px !important;
		padding-right: 15px !important;
		margin-left: 0 !important;
		margin-right: 0 !important;
	}
	
	body.search:not(.single):not(.single-post):not(.singular) .search-results,
	body.search-results:not(.single):not(.single-post):not(.singular) .search-results {
		padding-left: 15px !important;
		padding-right: 15px !important;
		margin-left: 0 !important;
		margin-right: 0 !important;
	}
}
</style>

<div class="shadcn-container">
	<div class="content-wrapper">
		<main id="primary" class="site-main">

			<?php if ( have_posts() ) : 
				global $wp_query;
				$total_results = $wp_query->found_posts;
				$current_page = max( 1, get_query_var( 'paged' ) );
				$posts_per_page = get_query_var( 'posts_per_page' );
				$start_result = ( $current_page - 1 ) * $posts_per_page + 1;
				$end_result = min( $current_page * $posts_per_page, $total_results );
			?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'haliyora' ), '<span>' . get_search_query() . '</span>' );
						?>
					</h1>
					<div class="search-results-info">
						<?php
						if ( $total_results > 0 ) {
							if ( $total_results == 1 ) {
								printf( esc_html__( 'Ditemukan %d artikel', 'haliyora' ), $total_results );
							} else {
								if ( $current_page == 1 ) {
									printf( esc_html__( 'Ditemukan sekitar %d artikel', 'haliyora' ), $total_results );
								} else {
									printf( esc_html__( 'Menampilkan %d-%d dari sekitar %d artikel', 'haliyora' ), $start_result, $end_result, $total_results );
								}
							}
						}
						?>
					</div>
				</header><!-- .page-header -->

				<!-- Search Form -->
				<div class="search-page-form-wrapper">
					<form role="search" method="get" class="search-page-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="search" 
						       class="search-page-input shadcn-input" 
						       placeholder="Cari artikel..." 
						       value="<?php echo esc_attr( get_search_query() ); ?>" 
						       name="s" 
						       required>
						<button type="submit" class="search-page-button shadcn-btn shadcn-btn-primary" aria-label="Search">
							<span class="material-icons">search</span>
						</button>
					</form>
				</div>

				<div class="search-results">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						?>
						<article class="search-result-item">
							<div class="search-result-wrapper">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="search-result-thumbnail">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( array( 100, 100 ), array( 'class' => 'search-result-image' ) ); ?>
										</a>
									</div>
								<?php endif; ?>
								<div class="search-result-content">
									<h2 class="search-result-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2>
									<div class="search-result-url">
										<?php echo esc_url( get_permalink() ); ?>
									</div>
									<?php if ( has_excerpt() ) : ?>
										<div class="search-result-excerpt">
											<?php the_excerpt(); ?>
										</div>
									<?php endif; ?>
									<div class="search-result-meta">
										<span class="material-icons">schedule</span>
										<?php 
										// Format: Hari, Tanggal Bulan Tahun (contoh: Senin, 15 Januari 2024)
										$date_format = 'l, j F Y';
										echo haliyora_format_date(); 
										?>
									</div>
								</div>
							</div>
						</article>
						<?php
					endwhile;
					?>

					<?php
					// Pagination
					$big = 999999999;
					?>
					<div class="berita-terbaru-pagination">
						<?php
						echo paginate_links( array(
							'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format'  => '?paged=%#%',
							'current' => max( 1, get_query_var( 'paged' ) ),
							'total'   => $wp_query->max_num_pages,
							'prev_text' => '<span class="material-icons">chevron_left</span>',
							'next_text' => '<span class="material-icons">chevron_right</span>',
						) );
						?>
					</div>
				</div>

			<?php else : ?>

				<div class="search-results">
					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'haliyora' ); ?></p>
				</div>

			<?php endif; ?>

		</main><!-- #main -->

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
