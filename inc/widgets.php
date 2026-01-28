<?php
/**
 * Custom Widgets for Haliyora Theme
 *
 * @package haliyora
 */

/**
 * Widget: Berita Kategori Featured
 */
class Haliyora_Category_Featured_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname'   => 'haliyora_category_featured_widget',
			'description' => __( 'Menampilkan berita berdasarkan kategori dengan 1 featured image besar dan list berita.', 'haliyora' ),
		);
		parent::__construct( 'haliyora_category_featured', __( 'Berita Kategori Featured', 'haliyora' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$category = ! empty( $instance['category'] ) ? absint( $instance['category'] ) : 0;
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;

		if ( ! $category ) {
			return;
		}

		echo $args['before_widget'];
		
		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		$query_args = array(
			'posts_per_page' => $number,
			'post_status'    => 'publish',
			'cat'            => $category,
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		$cat_query = new WP_Query( $query_args );

		if ( $cat_query->have_posts() ) {
			$first_post = true;
			echo '<div class="category-featured-content">';
			
			while ( $cat_query->have_posts() ) {
				$cat_query->the_post();
				
				if ( $first_post ) {
					// Featured post dengan image besar dan judul overlay
					?>
					<div class="category-featured-main">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="category-featured-image-link">
								<?php the_post_thumbnail( 'large', array( 'class' => 'category-featured-image' ) ); ?>
								<div class="category-featured-overlay"></div>
							</a>
						<?php endif; ?>
						<div class="category-featured-info">
							<h3 class="category-featured-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
						</div>
					</div>
					<?php
					$first_post = false;
					echo '<ul class="category-featured-list">';
				} else {
					// List berita lainnya tanpa gambar
					?>
					<li class="category-featured-item">
						<div class="category-featured-item-content">
							<h4 class="category-featured-item-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
							<span class="category-featured-item-date"><?php echo haliyora_format_date(); ?></span>
						</div>
					</li>
					<?php
				}
			}
			
			if ( ! $first_post ) {
				echo '</ul>';
			}
			echo '</div>';
			wp_reset_postdata();
		}

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$category = ! empty( $instance['category'] ) ? absint( $instance['category'] ) : 0;
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		
		$categories = get_categories();
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'haliyora' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php _e( 'Category:', 'haliyora' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
				<option value="0"><?php _e( '-- Select Category --', 'haliyora' ); ?></option>
				<?php
				foreach ( $categories as $cat ) {
					printf(
						'<option value="%s"%s>%s</option>',
						esc_attr( $cat->term_id ),
						selected( $category, $cat->term_id, false ),
						esc_html( $cat->name )
					);
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts:', 'haliyora' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['category'] = absint( $new_instance['category'] );
		$instance['number'] = absint( $new_instance['number'] );
		return $instance;
	}
}

/**
 * Register Custom Widgets
 */
if ( ! function_exists( 'haliyora_register_widgets' ) ) {
	function haliyora_register_widgets() {
		register_widget( 'Haliyora_Category_Featured_Widget' );
	}
	add_action( 'widgets_init', 'haliyora_register_widgets' );
}
