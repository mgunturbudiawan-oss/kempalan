<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package haliyora
 */

get_header();
?>

<div class="shadcn-container">
	<div class="content-wrapper">
		<main id="primary" class="site-main single-post-main">
			
			<?php
			while ( have_posts() ) :
				the_post();
				$post_id = get_the_ID();
				?>
				
				<!-- Breadcrumb -->
				<nav class="breadcrumb">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Beranda</a>
					<span class="breadcrumb-separator">/</span>
					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) ) {
						echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
						echo '<span class="breadcrumb-separator">/</span>';
					}
					?>
					<span class="breadcrumb-current"><?php the_title(); ?></span>
				</nav>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-article' ); ?>>
					
					<!-- Post Header -->
					<header class="single-post-header">
						<h1 class="single-post-title"><?php the_title(); ?></h1>
						
						<div class="single-post-meta">
							<div class="single-post-meta-item">
								<span class="material-icons">person</span>
								<span class="single-post-author">Pewarta: <?php the_author(); ?></span>
							</div>
							<div class="single-post-meta-item">
								<span class="material-icons">schedule</span>
								<span class="single-post-date"><?php echo haliyora_format_date(); ?></span>
							</div>
							<div class="single-post-meta-item">
								<span class="material-icons">visibility</span>
								<span class="single-post-views"><?php echo number_format( haliyora_get_post_views( $post_id ) ); ?> pembaca</span>
							</div>
						</div>
					</header>

					<!-- Featured Image dengan Lightbox -->
					<?php if ( has_post_thumbnail() ) : 
						$thumbnail_id = get_post_thumbnail_id();
						$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full' );
						$thumbnail_caption = get_post( $thumbnail_id )->post_excerpt;
					?>
						<div class="single-post-featured-image">
							<a href="<?php echo esc_url( $thumbnail_url[0] ); ?>" class="featured-image-lightbox" data-caption="<?php echo esc_attr( $thumbnail_caption ); ?>">
								<?php the_post_thumbnail( 'full', array( 'class' => 'single-post-thumbnail' ) ); ?>
							</a>
							<?php if ( $thumbnail_caption ) : ?>
								<div class="featured-image-caption">
									<span class="material-icons">photo</span>
									<?php echo esc_html( $thumbnail_caption ); ?>
								</div>
								<div class="featured-image-caption-line"></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<!-- Post Content -->
					<div class="single-post-content">
						<?php
						the_content();
											
						wp_link_pages(
							array(
								'before'      => '<div class="page-links"><span class="page-links-label">Halaman:</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							)
						);
						?>
					</div>

					<!-- Tags dan Share -->
					<div class="single-post-footer">
						<?php
						$post_tags = get_the_tags();
						if ( $post_tags ) :
							?>
							<div class="single-post-tags">
								<span class="tags-label">Tag:</span>
								<div class="tags-list">
									<?php
									foreach ( $post_tags as $tag ) {
										echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="tag-link">#' . esc_html( $tag->name ) . '</a>';
									}
									?>
								</div>
							</div>
						<?php endif; ?>
						
							<!-- Berita Terkait - Tag Model List -->
							<?php
							$tags = get_the_tags();
							if ( $tags ) :
								$tag_ids = array();
								foreach ( $tags as $tag ) {
									$tag_ids[] = $tag->term_id;
								}
								$current_post_id = get_the_ID();
													
								// Query untuk berita terkait dari tag yang sama
								$related_posts = new WP_Query( array(
									'tag__in' => $tag_ids,
									'post__not_in' => array( $current_post_id ),
									'posts_per_page' => 4,
									'orderby' => 'rand',
									'post_status' => 'publish'
								) );
													
								if ( $related_posts->have_posts() ) :
									?>
									<div class="single-post-related-list">
										<h3 class="related-title">
											<span class="material-icons">article</span>
											Berita Terkait
										</h3>
										<div class="berita-terbaru-list">
											<?php
											while ( $related_posts->have_posts() ) : $related_posts->the_post();
												$categories = get_the_category();
												?>
												<article class="berita-terbaru-item">
													<div class="berita-terbaru-thumbnail">
														<a href="<?php the_permalink(); ?>">
															<?php 
															if ( has_post_thumbnail() ) {
																the_post_thumbnail( 'berita-terbaru', array( 'class' => 'berita-terbaru-image' ) );
															} else {
																echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.jpg" alt="' . get_the_title() . '" class="berita-terbaru-image">';
															}
															?>
														</a>
													</div>
													<div class="berita-terbaru-content">
														<?php if ( ! empty( $categories ) ) : ?>
															<div class="berita-terbaru-category">
																<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
																	<?php echo esc_html( $categories[0]->name ); ?>
																</a>
															</div>
														<?php endif; ?>
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
									</div>
									<?php
								endif;
							else :
								// Fallback ke kategori jika tidak ada tag
								$categories = get_the_category();
								if ( ! empty( $categories ) ) :
									$category_id = $categories[0]->term_id;
									$current_post_id = get_the_ID();
														
									$related_posts = new WP_Query( array(
										'cat' => $category_id,
										'posts_per_page' => 4,
										'post__not_in' => array( $current_post_id ),
										'orderby' => 'date',
										'order' => 'DESC',
										'post_status' => 'publish'
									) );
														
									if ( $related_posts->have_posts() ) :
										?>
										<div class="single-post-related-list">
											<h3 class="related-title">
												<span class="material-icons">article</span>
												Berita Terkait
											</h3>
											<div class="berita-terbaru-list">
												<?php
												while ( $related_posts->have_posts() ) : $related_posts->the_post();
													$inner_categories = get_the_category();
													?>
													<article class="berita-terbaru-item">
														<div class="berita-terbaru-thumbnail">
															<a href="<?php the_permalink(); ?>">
																<?php 
																if ( has_post_thumbnail() ) {
																	the_post_thumbnail( 'berita-terbaru', array( 'class' => 'berita-terbaru-image' ) );
																} else {
																	echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.jpg" alt="' . get_the_title() . '" class="berita-terbaru-image">';
																}
																?>
															</a>
														</div>
														<div class="berita-terbaru-content">
															<?php if ( ! empty( $inner_categories ) ) : ?>
																<div class="berita-terbaru-category">
																	<a href="<?php echo esc_url( get_category_link( $inner_categories[0]->term_id ) ); ?>">
																		<?php echo esc_html( $inner_categories[0]->name ); ?>
																	</a>
																</div>
															<?php endif; ?>
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
										</div>
										<?php
									endif;
								endif;
							endif;
							?>

						<div class="single-post-share">
							<span class="share-label">Bagikan:</span>
							<div class="share-buttons">
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" class="share-btn share-fb" title="Share di Facebook">
									<i class="fab fa-facebook-f"></i>
								</a>
								<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" class="share-btn share-twitter" title="Share di Twitter/X">
									<i class="fab fa-twitter"></i>
								</a>
								<a href="https://wa.me/?text=<?php echo urlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" class="share-btn share-wa" title="Share di WhatsApp">
									<i class="fab fa-whatsapp"></i>
								</a>
								<button class="share-btn share-copy" onclick="copyToClipboard('<?php echo esc_js( get_permalink() ); ?>')" title="Salin Link">
									<i class="fas fa-link"></i>
								</button>
							</div>
						</div>
						
						<!-- Floating Share Buttons Mobile -->
						<div class="floating-share-mobile">
							<div class="floating-share-buttons">
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" class="floating-share-btn floating-share-fb" title="Share di Facebook">
									<i class="fab fa-facebook-f"></i>
								</a>
								<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" class="floating-share-btn floating-share-twitter" title="Share di Twitter/X">
									<i class="fab fa-twitter"></i>
								</a>
								<a href="https://wa.me/?text=<?php echo urlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" class="floating-share-btn floating-share-wa" title="Share di WhatsApp">
									<i class="fab fa-whatsapp"></i>
								</a>
								<button class="floating-share-btn floating-share-copy" onclick="copyToClipboard('<?php echo esc_js( get_permalink() ); ?>')" title="Salin Link">
									<i class="fas fa-link"></i>
								</button>
							</div>
						</div>
					</div>
				
					<!-- Post Navigation - Detikcom Style -->
					<nav class="post-navigation">
						<?php
						$prev_post = get_previous_post();
						$next_post = get_next_post();
						?>
								
						<?php if ( $prev_post ) : ?>
						<div class="post-nav-item post-nav-prev">
							<div class="post-nav-label">
								<i class="fas fa-chevron-left"></i>
								<span>Sebelumnya</span>
							</div>
							<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="post-nav-link">
								<div class="post-nav-content">
									<?php if ( has_post_thumbnail( $prev_post->ID ) ) : ?>
									<div class="post-nav-thumbnail">
										<?php echo get_the_post_thumbnail( $prev_post->ID, 'thumbnail' ); ?>
									</div>
									<?php endif; ?>
									<div class="post-nav-text">
										<h4 class="post-nav-title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></h4>
										<?php
										$prev_categories = get_the_category( $prev_post->ID );
										if ( ! empty( $prev_categories ) ) :
										?>
										<span class="post-nav-category"><?php echo esc_html( $prev_categories[0]->name ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</a>
						</div>
						<?php endif; ?>
								
						<?php if ( $next_post ) : ?>
						<div class="post-nav-item post-nav-next">
							<div class="post-nav-label">
								<span>Berikutnya</span>
								<i class="fas fa-chevron-right"></i>
							</div>
							<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="post-nav-link">
								<div class="post-nav-content">
									<?php if ( has_post_thumbnail( $next_post->ID ) ) : ?>
									<div class="post-nav-thumbnail">
										<?php echo get_the_post_thumbnail( $next_post->ID, 'thumbnail' ); ?>
									</div>
									<?php endif; ?>
									<div class="post-nav-text">
										<h4 class="post-nav-title"><?php echo esc_html( get_the_title( $next_post ) ); ?></h4>
										<?php
										$next_categories = get_the_category( $next_post->ID );
										if ( ! empty( $next_categories ) ) :
										?>
										<span class="post-nav-category"><?php echo esc_html( $next_categories[0]->name ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</a>
						</div>
						<?php endif; ?>
					</nav>
				
				</article>

				<!-- Comments -->
				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>

				<!-- Berita Terbaru -->
				<section class="berita-terbaru-section single-post-berita-terbaru">
					<div class="berita-terbaru-header">
						<h2 class="berita-terbaru-title">
							<span class="berita-terbaru-title-line"></span>
							Berita Terbaru
						</h2>
					</div>
					
					<div class="berita-terbaru-list">
						<?php
						// Query untuk berita terbaru (6 post, exclude post saat ini)
						$current_post_id = get_the_ID();
						$latest_posts = new WP_Query( array(
							'posts_per_page' => 6,
							'post__not_in' => array( $current_post_id ),
							'orderby' => 'date',
							'order' => 'DESC',
							'post_status' => 'publish',
							'ignore_sticky_posts' => true,
						) );
						
						if ( $latest_posts->have_posts() ) :
							while ( $latest_posts->have_posts() ) : $latest_posts->the_post();
								$categories = get_the_category();
								?>
								<article class="berita-terbaru-item">
									<div class="berita-terbaru-thumbnail">
										<a href="<?php the_permalink(); ?>">
											<?php echo haliyora_get_post_thumbnail( null, 'medium', array( 'class' => 'berita-terbaru-image' ) ); ?>
										</a>
									</div>
									<div class="berita-terbaru-content">
										<?php if ( ! empty( $categories ) ) : ?>
											<div class="berita-terbaru-category">
												<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
													<?php echo esc_html( $categories[0]->name ); ?>
												</a>
											</div>
										<?php endif; ?>
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
						else :
							?>
							<p>Tidak ada berita terbaru.</p>
							<?php
						endif;
						?>
					</div>
				</section>

			<?php endwhile; ?>

		</main><!-- #main -->

		<?php get_sidebar(); ?>
	</div>
</div>

<!-- Lightbox Modal -->
<div id="image-lightbox" class="lightbox-modal">
	<span class="lightbox-close">&times;</span>
	<img class="lightbox-image" src="" alt="">
	<div class="lightbox-caption"></div>
</div>

<script>
function copyToClipboard(text) {
	navigator.clipboard.writeText(text).then(function() {
		alert('Link berhasil disalin!');
	}, function() {
		alert('Gagal menyalin link');
	});
}

// Floating Share Buttons - Show immediately on mobile
(function() {
	'use strict';
	
	function initFloatingShare() {
		const floatingShare = document.querySelector('.floating-share-mobile');
		
		if (!floatingShare) {
			return;
		}
		
		function checkScreenSize() {
			if (window.innerWidth <= 768) {
				// Show on mobile immediately
				floatingShare.style.setProperty('display', 'block', 'important');
				setTimeout(function() {
					floatingShare.classList.add('show');
				}, 100);
			} else {
				// Hide on desktop
				floatingShare.classList.remove('show');
				setTimeout(function() {
					if (!floatingShare.classList.contains('show')) {
						floatingShare.style.setProperty('display', 'none', 'important');
					}
				}, 300);
			}
		}
		
		// Check on load
		checkScreenSize();
		
		// Check on resize
		window.addEventListener('resize', checkScreenSize);
	}
	
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initFloatingShare);
	} else {
		initFloatingShare();
	}
})();
</script>

<?php
get_footer();
