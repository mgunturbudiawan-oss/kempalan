<?php
/**
 * The main template file
 *
 * @package haliyora
 */

get_header();
?>

<div class="container-1100">
	<div class="content-wrapper">
		<main id="primary" class="site-main">
			
			<?php
			// Headline Section - Slider dengan overlay
			$headline_query = new WP_Query( array(
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
											<?php echo get_the_date(); ?>
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
			// Ambil 6 posts terbaru (akan diubah ke views count nanti jika sudah ada data)
			$rekomendasi_query = new WP_Query( array(
				'posts_per_page' => 6,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			) );
			
			if ( $rekomendasi_query->have_posts() ) :
				?>
				<section class="rekomendasi-section">
					<div class="rekomendasi-header">
						<h2 class="rekomendasi-title">
							<span class="rekomendasi-title-line"></span>
							Rekomendasi
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
											<span class="rekomendasi-date"><?php echo get_the_date(); ?></span>
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
			// Berita Terbaru Section - List dengan gambar 215x161
			$berita_terbaru_query = new WP_Query( array(
				'post_type'      => 'post',
				'posts_per_page' => 10,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			) );
			
			if ( $berita_terbaru_query->have_posts() ) :
				$max_pages = $berita_terbaru_query->max_num_pages;
				$loaded_posts = array();
				$counter = 0; // Counter to track article position
				$video_stories_displayed = false; // Flag to ensure video stories are displayed only once
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
							$counter++;
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'berita-terbaru-item' ); ?> data-post-id="<?php the_ID(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="berita-terbaru-thumbnail">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'berita-terbaru', array( 'class' => 'berita-terbaru-image' ) ); ?>
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
										<?php echo get_the_date(); ?>
									</div>
								</div>
							</article>
							<?php
							
							// After the 3rd news article, display video stories
							if ($counter == 3 && !$video_stories_displayed) {
								// Video Stories Section
								$video_stories_query = new WP_Query(array(
									'post_type' => 'video_story',
									'posts_per_page' => 6,
									'post_status' => 'publish',
									'orderby' => 'date',
									'order' => 'DESC',
								));
								
								if ($video_stories_query->have_posts()) :
								?>
									<div class="video-stories-home-section">
										<div class="video-stories-header">
											<h2 class="video-stories-title">
												<span class="video-stories-title-line"></span>
												Video Stories
											</h2>
											<a href="<?php echo esc_url(get_post_type_archive_link('video_story')); ?>" class="video-stories-more">
												<span class="material-icons">add</span>
												Lihat Semua
											</a>
										</div>
										<div class="video-stories-grid">
											<?php
											while ($video_stories_query->have_posts()) : $video_stories_query->the_post();
												$video_type = get_post_meta(get_the_ID(), '_video_type', true);
												$video_duration = get_post_meta(get_the_ID(), '_video_duration', true);
												$video_source = get_post_meta(get_the_ID(), '_video_source', true);
												$youtube_shorts_url = get_post_meta(get_the_ID(), '_youtube_shorts_url', true);
												$tiktok_embed_url = get_post_meta(get_the_ID(), '_tiktok_embed_url', true);
											?>
												<article class="video-story-card">
													<a href="javascript:void(0);" onclick="openVideoStoryModal(<?php echo get_the_ID(); ?>, '<?php echo esc_js($video_type); ?>', '<?php echo esc_js($video_source); ?>', '<?php echo esc_js($youtube_shorts_url); ?>', '<?php echo esc_js($tiktok_embed_url); ?>')" class="video-story-link">
														<div class="video-story-thumbnail">
															<?php if (has_post_thumbnail()) : ?>
																<?php the_post_thumbnail('medium', array('class' => 'video-story-img')); ?>
															<?php else: ?>
																<img src="https://placehold.co/300x400/e0e0e0/9e9e9e?text=Video" alt="<?php the_title_attribute(); ?>" class="video-story-img">
															<?php endif; ?>
															<div class="video-overlay">
																<span class="video-play-icon">
																	<i class="fas fa-play"></i>
																</span>
															</div>
															<?php if ($video_duration) : ?>
																<div class="video-time-badge"><?php echo haliyora_format_video_duration($video_duration); ?></div>
															<?php endif; ?>
															<h3 class="video-story-card-title"><?php the_title(); ?></h3>
														</div>
													</a>
												</article>
											<?php endwhile; ?>
										</div>
									</div>
								<?php
									$video_stories_displayed = true;
									wp_reset_postdata();
								endif;
							}
							?>
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
			else:
				// Even if no regular posts, show video stories if available
				$video_stories_query = new WP_Query(array(
					'post_type' => 'video_story',
					'posts_per_page' => 6,
					'post_status' => 'publish',
					'orderby' => 'date',
					'order' => 'DESC',
				));
				
				if ($video_stories_query->have_posts()) :
				?>
					<div class="video-stories-home-section">
						<div class="video-stories-header">
							<h2 class="video-stories-title">
								<span class="video-stories-title-line"></span>
								Video Stories
							</h2>
							<a href="<?php echo esc_url(get_post_type_archive_link('video_story')); ?>" class="video-stories-more">
								<span class="material-icons">add</span>
								Lihat Semua
							</a>
						</div>
						<div class="video-stories-grid">
							<?php
							while ($video_stories_query->have_posts()) : $video_stories_query->the_post();
								$video_type = get_post_meta(get_the_ID(), '_video_type', true);
								$video_duration = get_post_meta(get_the_ID(), '_video_duration', true);
								$video_source = get_post_meta(get_the_ID(), '_video_source', true);
								$youtube_shorts_url = get_post_meta(get_the_ID(), '_youtube_shorts_url', true);
								$tiktok_embed_url = get_post_meta(get_the_ID(), '_tiktok_embed_url', true);
							?>
								<article class="video-story-card">
									<a href="javascript:void(0);" onclick="openVideoStoryModal(<?php echo get_the_ID(); ?>, '<?php echo esc_js($video_type); ?>', '<?php echo esc_js($video_source); ?>', '<?php echo esc_js($youtube_shorts_url); ?>', '<?php echo esc_js($tiktok_embed_url); ?>')" class="video-story-link">
										<div class="video-story-thumbnail">
											<?php if (has_post_thumbnail()) : ?>
												<?php the_post_thumbnail('medium', array('class' => 'video-story-img')); ?>
											<?php else: ?>
												<img src="https://placehold.co/300x400/e0e0e0/9e9e9e?text=Video" alt="<?php the_title_attribute(); ?>" class="video-story-img">
											<?php endif; ?>
											<div class="video-overlay">
												<span class="video-play-icon">
													<i class="fas fa-play"></i>
												</span>
											</div>
											<?php if ($video_duration) : ?>
												<div class="video-time-badge"><?php echo haliyora_format_video_duration($video_duration); ?></div>
											<?php endif; ?>
											<h3 class="video-story-card-title"><?php the_title(); ?></h3>
										</div>
									</a>
								</article>
							<?php endwhile; ?>
						</div>
					</div>
				<?php
					wp_reset_postdata();
				endif;
			endif;
			?>

		</main><!-- #main -->

		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
