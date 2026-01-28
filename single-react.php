<?php
/**
 * React SPA Single Post Template
 * Renders single posts using React SPA
 * 
 * @package haliyora
 */

get_header();

// Get post ID for React
global $post;
$post_id = get_the_ID();
?>

<div class="container-1100">
	<div class="content-wrapper">
		<main id="primary" class="site-main single-post-main">
			
			<!-- React SPA Root -->
			<div id="react-spa-root" 
			     data-page-type="single" 
			     data-post-id="<?php echo esc_attr($post_id); ?>">
				<!-- Loading placeholder -->
				<div style="text-align: center; padding: 60px 20px;">
					<span class="material-icons" style="font-size: 48px; color: #d32f2f; animation: spin 1s linear infinite;">refresh</span>
					<p style="margin-top: 15px; color: #757575;">Loading Post...</p>
				</div>
			</div>

		</main><!-- #main -->

		<?php get_sidebar(); ?>
	</div>
</div>

<style>
@keyframes spin {
	from { transform: rotate(0deg); }
	to { transform: rotate(360deg); }
}

#react-spa-root {
	min-height: 400px;
}

.react-single-page {
	animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
	from { opacity: 0; transform: translateY(10px); }
	to { opacity: 1; transform: translateY(0); }
}

/* Ensure single post styling works with React */
.react-single-page .single-post-content img {
	max-width: 100%;
	height: auto;
	border-radius: 4px;
	margin: 20px 0;
}

.react-single-page .single-post-content p {
	margin-bottom: 20px;
	line-height: 1.8;
}

.react-single-page .single-post-content h2,
.react-single-page .single-post-content h3 {
	margin-top: 30px;
	margin-bottom: 15px;
	color: #212121;
	font-weight: 600;
}
</style>

<script>
// Inline initialization for single post
window.haliyoraPageType = 'single';
window.haliyoraPostData = {
	id: <?php echo json_encode($post_id); ?>,
	title: <?php echo json_encode(get_the_title()); ?>,
	permalink: <?php echo json_encode(get_permalink()); ?>
};
console.log('Page Type: single (React SPA Mode)', window.haliyoraPostData);
</script>

<?php
get_footer();
