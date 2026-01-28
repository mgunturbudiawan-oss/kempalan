<?php
/**
 * Trending Widget - Kumparan Style
 *
 * @package haliyora
 */

class Haliyora_Trending_Widget extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			'haliyora_trending_widget',
			__( 'Trending (Kumparan)', 'haliyora' ),
			array(
				'description' => __( 'Display trending posts in Kumparan style', 'haliyora' ),
			)
		);
	}

	/**
	 * Widget output
	 */
	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Trending', 'haliyora' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 7;

		echo $args['before_widget'];
		?>
		<style>
		.trending-kumparan-widget { background: #fff; width: 100%; box-shadow: none !important; }
		.trending-kumparan-widget.shadcn-card, .trending-kumparan-widget.shadcn-card:hover { box-shadow: none !important; transform: none; }
		.trending-kumparan-header { display: flex; align-items: center; justify-content: space-between; padding-bottom: 16px; border-bottom: 1px solid #e5e5e5; margin-bottom: 8px; }
		.trending-kumparan-header-left { display: flex; align-items: center; gap: 10px; }
		.trending-red-bar { width: 4px; height: 24px; background: #dc2626; border-radius: 2px; }
		.trending-kumparan-label { font-size: 20px; font-weight: 700; margin: 0; color: #1a1a1a; }
		.trending-kumparan-more { color: #00a9b8; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 4px; }
		.trending-kumparan-item { display: flex; align-items: flex-start; gap: 14px; padding: 14px 0; border-bottom: 1px solid #f0f0f0; }
		.trending-number { width: 32px; height: 32px; background: #dc2626; color: #fff; font-size: 16px; font-weight: 700; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
		.trending-kumparan-info { flex: 1; min-width: 0; }
		.trending-kumparan-item-title { font-size: 15px; font-weight: 600; line-height: 1.4; margin: 0 0 6px 0; color: #1a1a1a; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
		.trending-kumparan-item-title a { text-decoration: none; color: inherit; }
		.trending-kumparan-item-title a:hover { color: #00a9b8; }
		.trending-kumparan-time { font-size: 12px; color: #999; }
		.trending-kumparan-views { font-size: 12px; color: #999; display: flex; align-items: center; gap: 4px; }
		.trending-kumparan-views .material-icons { font-size: 14px; }
		.trending-kumparan-meta { display: flex; align-items: center; gap: 12px; }
		@media (max-width: 768px) { .trending-kumparan-widget { padding: 0 16px; } }
		body.dark-mode .trending-kumparan-widget, body.dark-mode .trending-kumparan-list { background: transparent; }
		body.dark-mode .trending-kumparan-label, body.dark-mode .trending-kumparan-item-title, body.dark-mode .trending-kumparan-item-title a { color: #fff; }
		body.dark-mode .trending-kumparan-header, body.dark-mode .trending-kumparan-item { border-bottom-color: #333; }
		body.dark-mode .trending-kumparan-time, body.dark-mode .trending-kumparan-views { color: #999; }
		</style>
		<div class="trending-kumparan-widget shadcn-card">
			<div class="trending-kumparan-header">
				<div class="trending-kumparan-header-left">
					<div class="trending-red-bar"></div>
					<h2 class="trending-kumparan-label"><?php echo esc_html( $title ); ?></h2>
				</div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="trending-kumparan-more">
					Lihat lainnya 
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none">
						<path d="M4 2L8 6L4 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>
			</div>
			
			<div class="trending-kumparan-list">
				<?php
				$period = get_theme_mod( 'haliyora_trending_period', '7' );
				$date_query = array(
					array(
						'after' => $period . ' days ago',
					),
				);

				$trending_args = array(
					'post_type'           => array( 'post', 'berita_foto' ),
					'posts_per_page'      => $number,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'meta_key'            => 'post_views_count',
					'orderby'             => 'meta_value_num',
					'order'               => 'DESC',
					'date_query'          => $date_query,
				);

				$trending_query = new WP_Query( $trending_args );

				// Fallback if no posts in the period (e.g. site is new or period is too short)
				if ( ! $trending_query->have_posts() ) {
					unset( $trending_args['date_query'] );
					$trending_query = new WP_Query( $trending_args );
				}

				if ( $trending_query->have_posts() ) :
					$index = 1;
					while ( $trending_query->have_posts() ) : $trending_query->the_post();
						?>
						<article class="trending-kumparan-item">
							<div class="trending-number"><?php echo $index; ?></div>
							<div class="trending-kumparan-info">
								<h3 class="trending-kumparan-item-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<div class="trending-kumparan-meta">
									<div class="trending-kumparan-time">
										<?php echo haliyora_format_date(); ?>
									</div>
									<div class="trending-kumparan-views">
										<span class="material-icons">visibility</span>
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
				?>
			</div>
		</div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Widget form
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Trending', 'haliyora' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 7;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php _e( 'Title:', 'haliyora' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
			       type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
				<?php _e( 'Number of posts:', 'haliyora' ); ?>
			</label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" 
			       name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" 
			       type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
		</p>
		<?php
	}

	/**
	 * Update widget settings
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 7;
		return $instance;
	}
}

/**
 * Register widget
 */
function haliyora_register_trending_widget() {
	register_widget( 'Haliyora_Trending_Widget' );
}
add_action( 'widgets_init', 'haliyora_register_trending_widget' );
