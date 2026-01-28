<?php
/**
 * The main template file with React integration
 *
 * @package haliyora
 */

get_header();

// Prepare data for React components
$recent_posts = get_posts(array('numberposts' => 5, 'post_status' => 'publish'));
$react_recent_posts = array();
foreach ($recent_posts as $post) {
    $react_recent_posts[] = array(
        'id' => $post->ID,
        'title' => array('rendered' => get_the_title($post->ID)),
        'excerpt' => array('rendered' => wp_trim_words(get_the_excerpt($post->ID), 20)),
        'link' => get_permalink($post->ID),
        'featured_media_url' => get_the_post_thumbnail_url($post->ID, 'medium'),
        'date' => get_the_date('', $post->ID)
    );
}
?>

<div class="container-1100">
	<div class="content-wrapper">
		<main id="primary" class="site-main">
			
			<?php
			// React-powered welcome card
			echo haliyora_react_component('MaterialCard', array(
				'title' => 'Welcome to Haliyora',
				'children' => 'This homepage demonstrates React components working throughout the theme.'
			), array('style' => 'margin-bottom: 20px;'));
			
			// Headline Section - Slider with overlay
			$headline_query = new WP_Query( array(
				'post_type'      => array( 'post', 'berita_foto' ),
				'posts_per_page' => 5,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			) );
			
			if ( $headline_query->have_posts() ) :
				?>
				<section class="headline-section">
					<div class="headline-slider">
						<div class="headline-slides">
							<?php
							$slide_count = 0;
							while ( $headline_query->have_posts() ) :
								$headline_query->the_post();
								$slide_count++;
								$active_class = ( $slide_count === 1 ) ? 'active' : '';
								?>
								<div class="headline-slide <?php echo esc_attr( $active_class ); ?>" data-slide="<?php echo esc_attr( $slide_count ); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="headline-image">
											<?php the_post_thumbnail( 'large', array( 'class' => 'headline-thumbnail' ) ); ?>
											<div class="headline-overlay"></div>
											<?php if ( get_post_type() === 'berita_foto' ) : ?>
												<div class="photo-icon-overlay">
													<span class="material-icons">photo_camera</span>
													<span>FOTO</span>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
									<div class="headline-content-overlay">
										<?php
										$categories = get_the_category();
										if ( ! empty( $categories ) ) {
											echo '<span class="headline-category"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></span>';
										}
										?>
										<h2 class="headline-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h2>
										<div class="headline-date">
											<span class="material-icons">schedule</span>
											<?php echo haliyora_format_date(); ?>
										</div>
									</div>
								</div>
								<?php
							endwhile;
							?>
						</div>
						
						<!-- Slider Navigation -->
						<div class="headline-nav">
							<button class="headline-nav-prev" aria-label="Previous">
								<span class="material-icons">chevron_left</span>
							</button>
							<button class="headline-nav-next" aria-label="Next">
								<span class="material-icons">chevron_right</span>
							</button>
						</div>
						
						<!-- Slider Dots -->
						<div class="headline-dots">
							<?php
							for ( $i = 1; $i <= $slide_count; $i++ ) {
								$active_dot = ( $i === 1 ) ? 'active' : '';
								echo '<button class="headline-dot ' . esc_attr( $active_dot ) . '" data-slide="' . esc_attr( $i ) . '" aria-label="Slide ' . esc_attr( $i ) . '"></button>';
							}
							?>
						</div>
					</div>
				</section>
				<?php
				wp_reset_postdata();
			endif;
			?>

			<?php
			// Rekomendasi Carousel Section - 6 berita populer
			$reko_title = get_theme_mod( 'haliyora_rekomendasi_title', 'Rekomendasi' );
			$reko_cat = get_theme_mod( 'haliyora_rekomendasi_category', 0 );
			$reko_orderby = get_theme_mod( 'haliyora_rekomendasi_orderby', 'date' );

			$rekomendasi_args = array(
				'post_type'      => array( 'post', 'berita_foto' ),
				'posts_per_page' => 6,
				'post_status'    => 'publish',
				'orderby'        => $reko_orderby,
			);

			if ( $reko_orderby === 'date' ) {
				$rekomendasi_args['order'] = 'DESC';
			}

			if ( $reko_cat > 0 ) {
				$rekomendasi_args['cat'] = $reko_cat;
			}

			$rekomendasi_query = new WP_Query( $rekomendasi_args );
			
			if ( $rekomendasi_query->have_posts() ) :
				?>
				<section class="rekomendasi-section">
					<div class="rekomendasi-header">
						<h2 class="rekomendasi-title">
							<span class="rekomendasi-title-line"></span>
							<?php echo esc_html( $reko_title ); ?>
						</h2>
						<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="rekomendasi-more">
							<span class="material-icons">add</span>
							Lihat lainnya
						</a>
					</div>
					<div class="rekomendasi-carousel">
						<div class="rekomendasi-slides">
							<?php
							while ( $rekomendasi_query->have_posts() ) :
								$rekomendasi_query->the_post();
								?>
								<div class="rekomendasi-item">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="rekomendasi-thumbnail">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'medium', array( 'class' => 'rekomendasi-image' ) ); ?>
												<?php if ( get_post_type() === 'berita_foto' ) : ?>
													<div class="photo-icon-overlay">
														<span class="material-icons">photo_camera</span>
														<span>FOTO</span>
													</div>
												<?php endif; ?>
											</a>
										</div>
									<?php endif; ?>
									<div class="rekomendasi-content">
										<?php
										$categories = get_the_category();
										if ( ! empty( $categories ) ) {
											echo '<span class="rekomendasi-category"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></span>';
										}
										?>
										<h3 class="rekomendasi-item-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										<div class="rekomendasi-meta">
											<span class="rekomendasi-date"><?php echo haliyora_format_date(); ?></span>
										</div>
									</div>
								</div>
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</div>
				</section>
				<?php
			endif;
			?>

			<!-- Analisis Section -->
			<section class="regional-section">
				<div class="regional-header">
					<h2 class="regional-title">
						<span class="regional-title-line"></span>
						Analisis
					</h2>
				</div>
				<div class="regional-carousel">
					<div class="regional-slides">
						<a href="<?php echo esc_url( home_url( '/?s=Analisis' ) ); ?>" class="regional-item">
							<div class="regional-icon" style="background: linear-gradient(135deg, #FF6B6B, #EE5A6F);">
								<i class="fas fa-chart-line"></i>
							</div>
							<span class="regional-name">Analisis</span>
						</a>
						
						<a href="<?php echo esc_url( home_url( '/?s=Sports' ) ); ?>" class="regional-item">
							<div class="regional-icon" style="background: linear-gradient(135deg, #4ECDC4, #44A08D);">
								<i class="fas fa-running"></i>
							</div>
							<span class="regional-name">Sports</span>
						</a>
						
						<a href="<?php echo esc_url( home_url( '/?s=Opini' ) ); ?>" class="regional-item">
							<div class="regional-icon" style="background: linear-gradient(135deg, #F7B731, #F79F1F);">
								<i class="fas fa-pen-nib"></i>
							</div>
							<span class="regional-name">Opini</span>
						</a>
						
						<a href="<?php echo esc_url( home_url( '/?s=Kolomnis' ) ); ?>" class="regional-item">
							<div class="regional-icon" style="background: linear-gradient(135deg, #5F27CD, #341F97);">
								<i class="fas fa-user-edit"></i>
							</div>
							<span class="regional-name">Kolomnis</span>
						</a>
						
						<a href="<?php echo esc_url( home_url( '/?s=Peta+Politik' ) ); ?>" class="regional-item">
							<div class="regional-icon" style="background: linear-gradient(135deg, #00D2FF, #3A7BD5);">
								<i class="fas fa-map-marked-alt"></i>
							</div>
							<span class="regional-name">Peta Politik</span>
						</a>
						
						<a href="<?php echo esc_url( home_url( '/?s=Jatim' ) ); ?>" class="regional-item">
							<div class="regional-icon" style="background: linear-gradient(135deg, #FA8BFF, #2BD2FF);">
								<i class="fas fa-map-marker-alt"></i>
							</div>
							<span class="regional-name">Jatim</span>
						</a>
						
						<a href="<?php echo esc_url( home_url( '/?s=Jateng' ) ); ?>" class="regional-item">
							<div class="regional-icon" style="background: linear-gradient(135deg, #FD79A8, #E84393);">
								<i class="fas fa-map-marker-alt"></i>
							</div>
							<span class="regional-name">Jateng</span>
						</a>
						
						<a href="<?php echo esc_url( home_url( '/?s=Jabar' ) ); ?>" class="regional-item">
							<div class="regional-icon" style="background: linear-gradient(135deg, #A29BFE, #6C5CE7);">
								<i class="fas fa-map-marker-alt"></i>
							</div>
							<span class="regional-name">Jabar</span>
						</a>
						
						<a href="<?php echo esc_url( home_url( '/?s=Jakarta' ) ); ?>" class="regional-item">
							<div class="regional-icon" style="background: linear-gradient(135deg, #FF7979, #F53B57);">
								<i class="fas fa-city"></i>
							</div>
							<span class="regional-name">Jakarta</span>
						</a>
						
						<a href="<?php echo esc_url( home_url( '/?s=Bali' ) ); ?>" class="regional-item">
							<div class="regional-icon" style="background: linear-gradient(135deg, #FDCB6E, #FFA502);">
								<i class="fas fa-umbrella-beach"></i>
							</div>
							<span class="regional-name">Bali</span>
						</a>
					</div>
				</div>
			</section>

			<?php
			// Berita Terbaru Section - List with gambar 215x161
			$berita_terbaru_query = new WP_Query( array(
				'post_type'      => array( 'post', 'berita_foto' ),
				'posts_per_page' => 10,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			) );
			
			if ( $berita_terbaru_query->have_posts() ) :
				$max_pages = $berita_terbaru_query->max_num_pages;
				$loaded_posts = array();
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
					<div class="berita-terbaru-list" data-page="1" data-max-pages="<?php echo esc_attr( $max_pages ); ?>">
						<?php
						while ( $berita_terbaru_query->have_posts() ) :
							$berita_terbaru_query->the_post();
							$loaded_posts[] = get_the_ID();
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'berita-terbaru-item' ); ?> data-post-id="<?php the_ID(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="berita-terbaru-thumbnail">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'berita-terbaru', array( 'class' => 'berita-terbaru-image' ) ); ?>
											<?php if ( get_post_type() === 'berita_foto' ) : ?>
												<div class="photo-icon-overlay">
													<span class="material-icons">photo_camera</span>
													<span>FOTO</span>
												</div>
											<?php endif; ?>
										</a>
									</div>
								<?php endif; ?>
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
					
					<?php if ( $max_pages > 1 ) : ?>
						<div class="berita-terbaru-load-more-wrapper">
							<button class="berita-terbaru-load-more" data-loaded-ids="<?php echo esc_attr( implode( ',', $loaded_posts ) ); ?>">
								<span class="material-icons">expand_more</span>
								Tampilkan Lebih
							</button>
						</div>
					<?php endif; ?>
				</section>
				<?php
			endif;
			?>

			<!-- React-powered search component -->
			<div style="margin: 30px 0;">
				<h3>Cari dengan React</h3>
				<?php echo haliyora_react_component('SearchComponent', array(
					'placeholder' => 'Cari berita...',
					'searchEndpoint' => '/wp-json/wp/v2/posts'
				), array('style' => 'max-width: 600px; margin: 0 auto;')); ?>
			</div>

		</main><!-- #main -->

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();