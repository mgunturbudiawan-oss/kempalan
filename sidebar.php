<?php
/**
 * The sidebar containing the main widget area
 *
 * @package haliyora
 */
?>

<style>
/* BERITA POPULER - KUMPARAN STYLE */
.widget-area.sidebar-sticky {
  position: sticky !important;
  top: 140px !important;
  padding: 0 !important;
  width: 320px !important;
  flex: 0 0 320px !important;
  margin-top: 0 !important; /* Ensure it starts at the very top */
}

.widget {
  box-shadow: none !important;
  margin-bottom: 24px;
  padding: 0 !important; /* Ensure no padding on widget container */
  width: 100% !important;
  box-sizing: border-box !important;
}

.trending-kumparan-widget {
  background: #fff;
  padding: 16px;
  border-radius: var(--radius, 0.375rem);
  width: 100% !important;
  box-shadow: none !important;
  border: 1px solid #e5e5e5;
  box-sizing: border-box !important;
}

.trending-kumparan-widget.shadcn-card {
  transform: none;
  box-shadow: none;
}

.trending-kumparan-widget.shadcn-card:hover {
  transform: none;
  box-shadow: none;
}

.trending-kumparan-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-bottom: 16px;
  border-bottom: 1px solid #e5e5e5;
  margin-bottom: 8px;
}

.trending-kumparan-header-left {
  display: flex;
  align-items: center;
  gap: 10px;
}

.trending-red-bar {
  width: 4px;
  height: 24px;
  background: #dc2626;
  border-radius: 2px;
}

.trending-kumparan-label {
  font-size: 20px;
  font-weight: 700;
  margin: 0;
  color: #1a1a1a;
}

.trending-kumparan-more {
  color: #00a9b8;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 4px;
}

.trending-kumparan-item {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  padding: 14px 0;
  border-bottom: 1px solid #f0f0f0;
}

.trending-number {
  width: 32px;
  height: 32px;
  background: #dc2626;
  color: #fff;
  font-size: 16px;
  font-weight: 700;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.trending-kumparan-info {
  flex: 1;
  min-width: 0;
}

.trending-kumparan-title {
  font-size: 15px;
  font-weight: 600;
  line-height: 1.4;
  margin: 0 0 6px 0;
  color: #1a1a1a;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.trending-kumparan-title a {
  text-decoration: none;
  color: inherit;
}

.trending-kumparan-title a:hover {
  color: #00a9b8;
}

.trending-kumparan-time {
  font-size: 12px;
  color: #999;
}

.trending-kumparan-views {
  font-size: 12px;
  color: #999;
  display: flex;
  align-items: center;
  gap: 4px;
}

.trending-kumparan-views .material-icons {
  font-size: 14px;
}

.trending-kumparan-meta {
  display: flex;
  align-items: center;
  gap: 12px;
}

@media (max-width: 768px) {
  .widget-area.sidebar-sticky {
    padding: 0 16px !important;
    width: 100% !important;
    flex: 0 0 100% !important;
  }
}

/* Dark Mode */
body.dark-mode .trending-kumparan-widget,
body.dark-mode .trending-kumparan-list {
  background: transparent;
}

body.dark-mode .trending-kumparan-label,
body.dark-mode .trending-kumparan-title,
body.dark-mode .trending-kumparan-title a {
  color: #fff;
}

body.dark-mode .trending-kumparan-header {
  border-bottom-color: #333;
}

body.dark-mode .trending-kumparan-item {
  border-bottom-color: #333;
}

body.dark-mode .trending-kumparan-time,
body.dark-mode .trending-kumparan-views {
  color: #999;
}
</style>

<!-- Haliyora Sidebar Start -->
<aside id="secondary" class="widget-area sidebar-sticky">
	<?php
	// Standard WordPress Sidebar (Primary Sidebar)
	if ( is_active_sidebar( 'sidebar-1' ) ) :
		dynamic_sidebar( 'sidebar-1' );
	endif;

	// Section: Kolomnis (Customizable)
	$kolomnis_title = get_theme_mod( 'haliyora_kolomnis_title', 'Kolomnis' );
	$kolomnis_cat = get_theme_mod( 'haliyora_kolomnis_category', 0 );

	$kolomnis_args = array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( $kolomnis_cat > 0 ) {
		$kolomnis_args['cat'] = $kolomnis_cat;
	}

	$kolomnis_query = new WP_Query( $kolomnis_args );

	if ( $kolomnis_query->have_posts() ) :
		?>
		<div class="kolomnis-sidebar-widget">
			<div class="kolomnis-header">
				<div class="kolomnis-red-bar"></div>
				<h2 class="kolomnis-label"><?php echo esc_html( $kolomnis_title ); ?></h2>
			</div>
			<div class="kolomnis-list">
				<?php
				while ( $kolomnis_query->have_posts() ) : $kolomnis_query->the_post();
					?>
					<article class="kolomnis-item">
						<div class="kolomnis-photo">
							<a href="<?php the_permalink(); ?>">
								<?php echo haliyora_get_post_thumbnail( null, 'thumbnail' ); ?>
							</a>
						</div>
						<div class="kolomnis-info">
							<h3 class="kolomnis-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<div class="kolomnis-date"><?php echo haliyora_format_date(); ?></div>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<div class="kolomnis-footer">
				<a href="<?php echo $kolomnis_cat > 0 ? esc_url( get_category_link( $kolomnis_cat ) ) : esc_url( home_url( '/' ) ); ?>" class="kolomnis-more">
					Lihat lainnya
					<i class="fas fa-chevron-right" style="font-size: 10px;"></i>
				</a>
			</div>
		</div>
		<?php
	endif;

	// Widget Area: Trend 7 Berita (Kumparan Style)
	// Jika ada widget yang dipasang di area ini, tampilkan widget tersebut.
	// Jika tidak, tampilkan fallback trending berita populer.
	if ( is_active_sidebar( 'trend-7-berita' ) ) :
		dynamic_sidebar( 'trend-7-berita' );
	else :
		// Fallback: Trending Berita Populer (Kumparan Style)
		?>
		<div class="trending-kumparan-widget shadcn-card">
			<div class="trending-kumparan-header">
				<div class="trending-kumparan-header-left">
					<div class="trending-red-bar"></div>
					<h2 class="trending-kumparan-label">Trending</h2>
				</div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="trending-kumparan-more">
					Lihat lainnya 
					<i class="fas fa-chevron-right" style="font-size: 10px;"></i>
				</a>
			</div>

			<div class="trending-kumparan-list">
				<?php
				$period = get_theme_mod( 'haliyora_trending_period', '7' );
				$transient_key = 'haliyora_trending_sidebar_html_' . $period;
				$cached_html = get_transient($transient_key);

				if (false === $cached_html) {
					// Ambil berita populer berdasarkan views (jika ada meta 'post_views_count')
					$trending_args = array(
						'post_type'           => array( 'post', 'berita_foto' ),
						'posts_per_page'      => 7,
						'post_status'         => 'publish',
						'ignore_sticky_posts' => true,
						'meta_key'            => 'post_views_count',
						'orderby'             => 'meta_value_num',
						'order'               => 'DESC',
						'no_found_rows'       => true,
						'date_query'          => array(
							array(
								'after' => $period . ' days ago',
							),
						),
					);
					
					$trending_query = new WP_Query( $trending_args );
					
					// Fallback
					if ( ! $trending_query->have_posts() ) {
						unset($trending_args['date_query']);
						$trending_query = new WP_Query( $trending_args );
					}

					if ( ! $trending_query->have_posts() ) {
						unset($trending_args['meta_key']);
						$trending_args['orderby'] = 'date';
						$trending_query = new WP_Query( $trending_args );
					}
					
					ob_start();
					if ( $trending_query->have_posts() ) :
						$index = 1;
						while ( $trending_query->have_posts() ) : $trending_query->the_post();
							?>
							<article class="trending-kumparan-item">
								<div class="trending-number"><?php echo $index; ?></div>
								<div class="trending-kumparan-info">
									<h3 class="trending-kumparan-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<div class="trending-kumparan-meta">
										<div class="trending-kumparan-time">
											<i class="far fa-clock"></i> <?php echo haliyora_format_date(); ?>
										</div>
										<div class="trending-kumparan-views">
											<i class="far fa-eye"></i> 
											<?php 
											$views = get_post_meta( get_the_ID(), 'post_views_count', true );
											echo $views ? number_format( $views ) : '0';
											?>
										</div>
									</div>
								</div>
							</article>
							<?php
							$index++;
						endwhile;
						wp_reset_postdata();
					endif;
					$cached_html = ob_get_clean();
					// Cache for 15 minutes
					set_transient($transient_key, $cached_html, 15 * MINUTE_IN_SECONDS);
				}
				echo $cached_html;
				?>
			</div>
		</div>
		<?php
	endif;

	// Iklan Sidebar Area
	if ( is_active_sidebar( 'iklan-sidebar' ) ) :
		echo '<div class="iklan-sidebar-area" style="margin-top: 24px;">';
		dynamic_sidebar( 'iklan-sidebar' );
		echo '</div>';
	endif;
	?>
</aside><!-- #secondary -->
<!-- Haliyora Sidebar End -->

