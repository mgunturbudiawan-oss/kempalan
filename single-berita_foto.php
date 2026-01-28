<?php
/**
 * The template for displaying single berita foto posts
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
					$terms = get_the_terms( $post_id, 'kategori_foto' );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						echo '<a href="' . esc_url( get_term_link( $terms[0]->term_id ) ) . '">' . esc_html( $terms[0]->name ) . '</a>';
						echo '<span class="breadcrumb-separator">/</span>';
					}
					?>
					<span class="breadcrumb-current"><?php the_title(); ?></span>
				</nav>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-article berita-foto-article' ); ?>>
					
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

					<!-- Photo Slider Section -->
					<?php
					// Get images attached to post or featured image
					$images = get_children( array(
						'post_parent'    => $post_id,
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
					) );
					
					$featured_id = get_post_thumbnail_id( $post_id );
					$all_image_ids = array();
					
					if ( $featured_id ) {
						$all_image_ids[] = $featured_id;
					}
					
					if ( ! empty( $images ) ) {
						foreach ( $images as $image ) {
							if ( $image->ID != $featured_id ) {
								$all_image_ids[] = $image->ID;
							}
						}
					}
					
					if ( ! empty( $all_image_ids ) ) :
						?>
						<div class="berita-foto-slider-wrapper">
							<div class="headline-slider">
								<div class="headline-slides">
									<?php
									$count = 0;
									foreach ( $all_image_ids as $img_id ) :
										$count++;
										$active_class = ( $count === 1 ) ? 'active' : '';
										$caption = wp_get_attachment_caption( $img_id );
										?>
										<div class="headline-slide <?php echo esc_attr( $active_class ); ?>" data-slide="<?php echo esc_attr( $count ); ?>">
											<a href="<?php echo esc_url( wp_get_attachment_url( $img_id ) ); ?>" class="featured-image-lightbox headline-image" data-caption="<?php echo esc_attr( $caption ); ?>">
												<?php echo wp_get_attachment_image( $img_id, 'full', false, array( 'class' => 'headline-thumbnail' ) ); ?>
												<div class="photo-slide-overlay"></div>
											</a>
											<div class="photo-slide-info">
												<?php if ( $caption ) : ?>
													<div class="photo-slide-caption">
														<span class="material-icons">photo_camera</span>
														<?php echo esc_html( $caption ); ?>
													</div>
												<?php endif; ?>
												<div class="photo-slide-counter">
													<span class="material-icons">collections</span>
													<?php echo esc_html( $count ); ?> / <?php echo esc_html( count( $all_image_ids ) ); ?>
												</div>
											</div>
										</div>
										<?php
									endforeach;
									?>
								</div>
								
								<?php if ( count( $all_image_ids ) > 1 ) : ?>
									<div class="headline-nav">
										<button class="headline-nav-prev" aria-label="Previous">
											<span class="material-icons">chevron_left</span>
										</button>
										<button class="headline-nav-next" aria-label="Next">
											<span class="material-icons">chevron_right</span>
										</button>
									</div>
									
									<div class="headline-dots">
										<?php
										for ( $i = 1; $i <= count( $all_image_ids ); $i++ ) {
											$active_dot = ( $i === 1 ) ? 'active' : '';
											echo '<button class="headline-dot ' . esc_attr( $active_dot ) . '" data-slide="' . esc_attr( $i ) . '" aria-label="Slide ' . esc_attr( $i ) . '"></button>';
										}
										?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<!-- Post Content -->
					<div class="single-post-content">
						<?php 
						$content = apply_filters('the_content', get_the_content());
						// Hapus tag figure (biasanya membungkus gambar di Gutenberg)
						$content = preg_replace('/<figure[^>]*>([\s\S]*?)<\/figure>/i', '', $content);
						// Hapus tag img yang mungkin tersisa
						$content = preg_replace('/<img[^>]+>/i', '', $content);
						// Hapus div gallery jika masih ada
						$content = preg_replace('/<div[^>]*class="[^"]*wp-block-gallery[^"]*"[^>]*>([\s\S]*?)<\/div>/i', '', $content);
						echo $content; 
						?>
					</div>

					<!-- Tags and Related -->
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

						<!-- Related Photo News -->
						<?php
						$related_query = new WP_Query( array(
							'post_type'      => 'berita_foto',
							'posts_per_page' => 4,
							'post__not_in'   => array( $post_id ),
							'orderby'        => 'date',
							'order'          => 'DESC',
							'post_status'    => 'publish',
							'ignore_sticky_posts' => true,
						) );
						
						if ( $related_query->have_posts() ) :
							?>
							<div class="single-post-related-list">
								<h3 class="related-title">
									<span class="material-icons">collections</span>
									Berita Foto Terkait
								</h3>
								<div class="berita-terbaru-list">
									<?php
									while ( $related_query->have_posts() ) : $related_query->the_post();
										?>
										<article class="berita-terbaru-item">
											<div class="berita-terbaru-thumbnail">
												<a href="<?php the_permalink(); ?>">
													<?php echo haliyora_get_post_thumbnail( null, 'berita-terbaru', array( 'class' => 'berita-terbaru-image' ) ); ?>
													<div class="photo-icon-overlay">
														<span class="material-icons">photo_camera</span>
														<span>FOTO</span>
													</div>
												</a>
											</div>
											<div class="berita-terbaru-content">
												<?php
												$terms = get_the_terms( get_the_ID(), 'kategori_foto' );
												if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
													echo '<div class="berita-terbaru-category"><a href="' . esc_url( get_term_link( $terms[0]->term_id ) ) . '">' . esc_html( $terms[0]->name ) . '</a></div>';
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
							</div>
						<?php endif; ?>

						<!-- Share Section -->
						<div class="single-post-share">
							<span class="share-label">Bagikan:</span>
							<div class="share-buttons">
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" class="share-btn share-fb">
									<i class="fab fa-facebook-f"></i>
								</a>
								<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" class="share-btn share-twitter">
									<i class="fab fa-twitter"></i>
								</a>
								<a href="https://wa.me/?text=<?php echo urlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" class="share-btn share-wa">
									<i class="fab fa-whatsapp"></i>
								</a>
							</div>
						</div>
					</div>

				</article>

				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>

			<?php endwhile; ?>

		</main>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php
get_footer();
