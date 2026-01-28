<?php
/**
 * Template Name: Trending Page
 * Template Post Type: page
 *
 * @package haliyora
 */

get_header();
?>

<div class="trending-page-wrapper">
	<div class="container-1100">
		<div class="trending-page-header">
			<h1 class="trending-page-title">
				<span class="material-icons">trending_up</span>
				Berita Trending
			</h1>
			<p class="trending-page-subtitle">7 Berita Paling Populer Saat Ini</p>
		</div>

		<div class="trending-list">
			<?php
			$period = get_theme_mod( 'haliyora_trending_period', '7' );
			
			// Query 7 berita trending berdasarkan views
			$trending_args = array(
				'post_type'           => array( 'post', 'berita_foto' ),
				'posts_per_page'      => 7,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'meta_key'            => 'post_views_count',
				'orderby'             => 'meta_value_num',
				'order'               => 'DESC',
				'date_query'          => array(
					array(
						'after' => $period . ' days ago',
					),
				),
			);

			$trending_posts = new WP_Query( $trending_args );
			
			// Fallback if no posts in period
			if ( ! $trending_posts->have_posts() ) {
				unset( $trending_args['date_query'] );
				$trending_posts = new WP_Query( $trending_args );
			}

			// Fallback to date if no views
			if ( ! $trending_posts->have_posts() ) {
				unset( $trending_args['meta_key'] );
				$trending_args['orderby'] = 'date';
				$trending_posts = new WP_Query( $trending_args );
			}
			
			if ( $trending_posts->have_posts() ) :
				$rank = 1;
				while ( $trending_posts->have_posts() ) : $trending_posts->the_post();
					$categories = get_the_category();
					$views = get_comments_number(); // Simulasi views dengan comment count
					
					// Random sentiment untuk demo (bisa diganti dengan custom field)
					$sentiments = array('positive', 'neutral', 'negative');
					$sentiment = $sentiments[array_rand($sentiments)];
					$sentiment_label = array(
						'positive' => 'Positif',
						'neutral'  => 'Netral',
						'negative' => 'Negatif'
					);
					?>
					<article class="trending-item">
						<div class="trending-rank">
							<span class="rank-number"><?php echo $rank; ?></span>
						</div>
						
						<div class="trending-thumbnail">
							<a href="<?php the_permalink(); ?>">
								<?php 
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'medium', array( 'class' => 'trending-image' ) );
								} else {
									echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.jpg" alt="' . get_the_title() . '" class="trending-image">';
								}
								?>
							</a>
						</div>
						
						<div class="trending-content">
							<?php if ( ! empty( $categories ) ) : ?>
								<div class="trending-category">
									<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
										<?php echo esc_html( $categories[0]->name ); ?>
									</a>
								</div>
							<?php endif; ?>
							
							<h2 class="trending-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							
							<div class="trending-excerpt">
								<?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
							</div>
							
							<div class="trending-meta">
								<div class="trending-views">
									<i class="fas fa-eye"></i>
									<span><?php echo number_format( $views * 1000 ); ?> views</span>
								</div>
								
								<div class="trending-sentiment sentiment-<?php echo $sentiment; ?>">
									<i class="fas fa-chart-line"></i>
									<span><?php echo $sentiment_label[$sentiment]; ?></span>
								</div>
								
								<div class="trending-date">
									<i class="far fa-clock"></i>
									<span><?php echo haliyora_format_date(); ?></span>
								</div>
							</div>
						</div>
					</article>
					<?php
					$rank++;
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<p class="no-trending">Belum ada berita trending.</p>
				<?php
			endif;
			?>
		</div>
		
		<!-- Media Monitoring Section -->
		<div class="media-monitoring-section">
			<div class="media-monitoring-header">
				<h2 class="media-monitoring-title">
					<span class="material-icons">monitoring</span>
					Media Monitoring
				</h2>
				<p class="media-monitoring-subtitle">Analisis frekuensi pemberitaan terhadap institusi publik</p>
			</div>
			
			<div class="media-monitoring-charts">
				<div class="chart-container">
					<h3 class="chart-title">Frekuensi Pemberitaan</h3>
					<div class="chart-bars">
						<?php
					// Simulasi data monitoring
					$monitoring_data = array(
						'Polisi' => rand(45, 75),
						'TNI' => rand(30, 55),
						'Pemerintah' => rand(60, 90),
						'Kasus' => rand(50, 80),
						'Korupsi' => rand(40, 70),
					);
					
					foreach ($monitoring_data as $institution => $count) {
						$percentage = min(100, $count); // Batasi maksimal 100%
						?>
						<div class="chart-bar">
							<div class="bar-label">
								<span class="institution-name"><?php echo $institution; ?></span>
								<span class="count-value"><?php echo $count; ?> kali</span>
							</div>
							<div class="bar-container">
								<div class="bar-fill" style="width: <?php echo $percentage; ?>%"></div>
							</div>
						</div>
						<?php
					}
					?>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Performance Tracking Section -->
		<div class="performance-tracking-section">
			<div class="performance-tracking-header">
				<h2 class="performance-tracking-title">
					<span class="material-icons">assessment</span>
					Grafik Kinerja 10 Pemerintahan Kabupaten/Kota Maluku Utara
				</h2>
				<p class="performance-tracking-subtitle">Analisis sentimen pemberitaan terhadap pemerintahan daerah</p>
			</div>
			
			<div class="performance-charts">
				<div class="chart-container">
					<h3 class="chart-title">Sentimen Pemberitaan (Positif/Negatif)</h3>
					<div class="performance-bars">
						<?php
					$regions = array(
						'Halmahera Barat',
						'Halmahera Tengah',
						'Halmahera Selatan',
						'Halmahera Utara',
						'Halmahera Timur',
						'Kepulauan Sula',
						'Pulau Morotai',
						'Pulau Taliabu',
						'Kota Ternate',
						'Kota Tidore Kepulauan'
					);
					
					foreach ($regions as $region) {
						$positive = rand(30, 90); // Persentase positif
						$negative = 100 - $positive; // Sisanya negatif
						
						// Tentukan warna dominan berdasarkan mayoritas
						$dominant_color = $positive > $negative ? '#4CAF50' : ($negative > $positive ? '#F44336' : '#9E9E9E');
						?>
						<div class="performance-bar">
							<div class="region-label">
								<span class="region-name"><?php echo $region; ?></span>
							</div>
							<div class="performance-bar-container">
								<div class="performance-positive" style="width: <?php echo $positive; ?>%; background-color: #4CAF50;"></div>
								<div class="performance-negative" style="width: <?php echo $negative; ?>%; background-color: #F44336;"></div>
							</div>
							<div class="performance-stats">
								<span class="positive-stat"><?php echo $positive; ?>%</span>
								<span class="negative-stat"><?php echo $negative; ?>%</span>
							</div>
						</div>
						<?php
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
