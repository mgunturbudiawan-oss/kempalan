<?php
/**
 * The main template file - Kumparan Style
 *
 * @package haliyora
 */

get_header();
?>

<div class="shadcn-container">
	<div class="content-wrapper">
		<main id="primary" class="site-main kumparan-home">
			
			<?php
			// Hero section: 1 headline utama + 3 artikel samping, Kumparan-style
			$headline_query = new WP_Query( array(
				'posts_per_page' => 4,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			) );
			
			if ( $headline_query->have_posts() ) :
				$headline_posts = array();
				while ( $headline_query->have_posts() ) :
					$headline_query->the_post();
					$headline_posts[] = get_post();
				endwhile;
				wp_reset_postdata();
				?>
				<section class="kumparan-hero-section">
					<div class="shadcn-grid shadcn-grid-cols-3 kumparan-hero-grid">
						<?php if ( ! empty( $headline_posts[0] ) ) : $post = $headline_posts[0]; setup_postdata( $post ); ?>
							<article class="kumparan-hero-card">
								<a href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'large', array( 'class' => 'kumparan-hero-image' ) ); ?>
									<?php endif; ?>
									<div class="kumparan-hero-overlay">
										<?php
										$categories = get_the_category();
										if ( ! empty( $categories ) ) {
											echo '<span class="kumparan-hero-category">' . esc_html( $categories[0]->name ) . '</span>';
										}
										?>
										<h2 class="kumparan-hero-title"><?php the_title(); ?></h2>
										<div class="kumparan-hero-meta">
											<span class="hero-meta-date"><?php echo haliyora_format_date(); ?></span>
										</div>
									</div>
								</a>
							</article>
						<?php endif; wp_reset_postdata(); ?>
						
						<div class="kumparan-hero-side">
							<?php for ( $i = 1; $i < count( $headline_posts ); $i++ ) : $post = $headline_posts[ $i ]; setup_postdata( $post ); ?>
								<article class="kumparan-article-card kumparan-hero-side-card">
									<a href="<?php the_permalink(); ?>">
										<div class="kumparan-article-content">
											<?php
											$categories = get_the_category();
											if ( ! empty( $categories ) ) {
												echo '<span class="kumparan-article-category">' . esc_html( $categories[0]->name ) . '</span>';
											}
											?>
											<h3 class="kumparan-article-title"><?php the_title(); ?></h3>
											<div class="kumparan-article-meta">
												<span><?php echo haliyora_format_date(); ?></span>
											</div>
										</div>
									</a>
								</article>
							<?php endfor; wp_reset_postdata(); ?>
						</div>
					</div>
				</section>
			<?php endif; ?>
			
			<div class="shadcn-separator"></div>
			
			<?php
			// Berita Terbaru - grid Kumparan style
			$berita_terbaru_query = new WP_Query( array(
				'post_type'      => 'post',
				'posts_per_page' => 12,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
				'offset'         => 4, // Skip first 4 (used in hero)
			) );
			
			if ( $berita_terbaru_query->have_posts() ) :
				?>
				<section class="kumparan-latest-section">
					<div class="kumparan-section-header">
						<h2 class="section-title">Berita Terbaru</h2>
						<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>" class="shadcn-btn shadcn-btn-link">
							Lihat Semua <i class="fas fa-arrow-right"></i>
						</a>
					</div>
					<div class="shadcn-grid shadcn-grid-cols-3 kumparan-articles-grid">
						<?php
						while ( $berita_terbaru_query->have_posts() ) :
							$berita_terbaru_query->the_post();
							?>
							<article class="kumparan-article-card">
								<a href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium_large', array( 'class' => 'kumparan-article-image' ) ); ?>
									<?php endif; ?>
									<div class="kumparan-article-content">
										<?php
										$categories = get_the_category();
										if ( ! empty( $categories ) ) {
											echo '<span class="kumparan-article-category">' . esc_html( $categories[0]->name ) . '</span>';
										}
										?>
										<h3 class="kumparan-article-title"><?php the_title(); ?></h3>
										<div class="kumparan-article-meta">
											<span><?php echo haliyora_format_date(); ?></span>
										</div>
									</div>
								</a>
							</article>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
					
					<div class="kumparan-load-more-wrapper">
						<button class="shadcn-btn shadcn-btn-outline shadcn-btn-lg kumparan-load-more">
							Muat Lebih Banyak
						</button>
					</div>
				</section>
			<?php endif; ?>
			
		</main><!-- #main -->

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
