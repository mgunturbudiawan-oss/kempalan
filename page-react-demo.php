<?php
/**
 * Template Name: React Components Demo
 * Description: Demonstrates React components working throughout the Haliyora theme
 *
 * @package haliyora
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header>

				<div class="entry-content">
					<?php
					the_content();

					// Example of using React components throughout the page
					echo '<h2>Material Card Example</h2>';
					echo haliyora_react_component('MaterialCard', array(
						'title' => 'React Component in WordPress',
						'children' => 'This card is rendered using React inside a WordPress template!'
					));

					echo '<h2>Dynamic Content Loader Example</h2>';
					echo haliyora_react_component('DynamicContentLoader', array(
						'endpoint' => '/wp-json/wp/v2/posts?per_page=5',
						'renderFunction' => 'function(posts) { return React.createElement("div", null, posts.map(post => React.createElement("div", { key: post.id }, post.title.rendered))); }'
					), array('style' => 'min-height: 200px;'));

					echo '<h2>News Carousel Example</h2>';
					echo haliyora_react_component('NewsCarousel', array(
						'posts' => array_slice(array_map(function($post) {
							return array(
								'id' => $post->ID,
								'title' => array('rendered' => get_the_title($post->ID)),
								'excerpt' => array('rendered' => wp_trim_words(get_the_excerpt($post->ID), 20)),
								'link' => get_permalink($post->ID),
								'featured_media_url' => get_the_post_thumbnail_url($post->ID, 'medium')
							);
						}, get_posts(array('numberposts' => 5))), 0, 5),
						'autoPlay' => true,
						'interval' => 4000
					), array('style' => 'max-width: 800px; margin: 20px auto;'));

					echo '<h2>Interactive Button Example</h2>';
					echo '<div id="button-example-container"></div>';
					?>
					<script type="text/javascript">
						// Example of rendering a button dynamically
						document.addEventListener('DOMContentLoaded', function() {
							if (window.HaliyoraReact && window.ReactDOM && document.getElementById('button-example-container')) {
								var container = document.getElementById('button-example-container');
								var root = window.ReactDOM.createRoot(container);
								
								var handleClick = function() {
									alert('Button clicked from React!');
								};
								
								root.render(window.HaliyoraReact.MaterialButton({
									children: 'Click Me!',
									onClick: handleClick,
									variant: 'contained'
								}));
							}
						});
					</script>

					<h2>Comment System Example</h2>
					<?php
					$current_post_id = get_the_ID();
					$current_user_data = haliyora_get_current_user_data();
					echo haliyora_react_component('CommentSystem', array(
						'postId' => $current_post_id,
						'currentUser' => $current_user_data,
						'enableReplies' => true
					), array('style' => 'margin-top: 20px;'));
					?>
				</div>
			</article>

			<?php

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();