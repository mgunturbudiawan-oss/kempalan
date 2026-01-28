<?php
/**
 * The template for displaying category archive pages
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
			// Get current category
			$current_category = get_queried_object();
			$category_id = $current_category->term_id;
			
			// Featured Headline - 1 post saja (tidak pakai slide)
			$featured_query = new WP_Query( array(
				'posts_per_page' => 1,
				'post_status'    => 'publish',
				'cat'            => $category_id,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'ignore_sticky_posts' => true,
			) );
			
			if ( $featured_query->have_posts() ) :
				$featured_query->the_post();
				$featured_post_id = get_the_ID();
				?>
				<section class="category-featured-headline">
					<div class="category-featured-headline-image">
						<a href="<?php the_permalink(); ?>">
							<?php echo haliyora_get_post_thumbnail( null, 'large', array( 'class' => 'category-featured-headline-thumbnail' ) ); ?>
							<div class="category-featured-headline-overlay"></div>
						</a>
					</div>
					<div class="category-featured-headline-content">
						<?php
						$categories = get_the_category();
						if ( ! empty( $categories ) ) {
							echo '<span class="category-featured-headline-category"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></span>';
						}
						?>
						<h2 class="category-featured-headline-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="category-featured-headline-date">
							<span class="material-icons">schedule</span>
							<?php echo haliyora_format_date(); ?>
						</div>
					</div>
				</section>
				<?php
				wp_reset_postdata();
			endif;
			?>

			<?php
			// Berita Terbaru Section - List dengan gambar 215x161 (sama persis dengan home)
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$berita_terbaru_query = new WP_Query( array(
				'post_type'      => array( 'post', 'berita_foto' ),
				'posts_per_page' => 9,
				'post_status'    => 'publish',
				'cat'            => $category_id,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'paged'          => $paged,
				'ignore_sticky_posts' => true,
				'post__not_in'   => isset( $featured_post_id ) && $paged == 1 ? array( $featured_post_id ) : array(),
			) );
			
			if ( $berita_terbaru_query->have_posts() ) :
				?>
				<section class="berita-terbaru-section">
					<div class="berita-terbaru-header">
						<h2 class="berita-terbaru-title">
							<span class="berita-terbaru-title-line"></span>
							Berita Terbaru
						</h2>
						<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>" class="berita-terbaru-more">
							<span class="material-icons">add</span>
							Lihat Lainnya
						</a>
					</div>
					<div class="berita-terbaru-list">
						<?php
						while ( $berita_terbaru_query->have_posts() ) :
							$berita_terbaru_query->the_post();
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'berita-terbaru-item' ); ?>>
								<div class="berita-terbaru-thumbnail">
									<a href="<?php the_permalink(); ?>">
										<?php echo haliyora_get_post_thumbnail( null, 'berita-terbaru', array( 'class' => 'berita-terbaru-image' ) ); ?>
										<?php if ( get_post_type() === 'berita_foto' ) : ?>
											<div class="photo-icon-overlay">
												<span class="material-icons">photo_camera</span>
												<span>FOTO</span>
											</div>
										<?php endif; ?>
									</a>
								</div>
								<div class="berita-terbaru-content">
									<?php
									$categories = get_the_category();
									if ( ! empty( $categories ) ) {
										echo '<span class="berita-terbaru-category"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></span>';
									}
									?>
									<h3 class="berita-terbaru-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<div class="berita-terbaru-date">
										<span class="material-icons">schedule</span>
										<?php echo haliyora_format_date(); ?>
									</div>
								</div>
							</article>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
					
					<?php
					// Pagination
					if ( $berita_terbaru_query->max_num_pages > 1 ) :
						$big = 999999999;
						?>
						<div class="berita-terbaru-pagination">
							<?php
							echo paginate_links( array(
								'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format'  => '?paged=%#%',
								'current' => max( 1, $paged ),
								'total'   => $berita_terbaru_query->max_num_pages,
								'prev_text' => '<span class="material-icons">chevron_left</span>',
								'next_text' => '<span class="material-icons">chevron_right</span>',
							) );
							?>
						</div>
					<?php endif; ?>
				</section>
				<?php
			endif;
			?>

		</main><!-- #main -->

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
