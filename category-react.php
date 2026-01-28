<?php
/**
 * React SPA Category Template
 * Renders category pages using React SPA
 * 
 * @package haliyora
 */

get_header();

$category = get_queried_object();
?>

<div class="container-1100">
	<div class="content-wrapper">
		<main id="primary" class="site-main">
			
			<!-- React SPA Root -->
			<div id="react-spa-root" 
			     data-page-type="category" 
			     data-category-id="<?php echo esc_attr($category->term_id); ?>"
			     data-category-slug="<?php echo esc_attr($category->slug); ?>">
				<!-- Loading placeholder -->
				<div style="text-align: center; padding: 60px 20px;">
					<span class="material-icons" style="font-size: 48px; color: #d32f2f; animation: spin 1s linear infinite;">refresh</span>
					<p style="margin-top: 15px; color: #757575;">Loading Category: <?php echo esc_html($category->name); ?>...</p>
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

.react-category-page {
	animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
	from { opacity: 0; transform: translateY(10px); }
	to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
// Inline initialization for category page
window.haliyoraPageType = 'category';
window.haliyoraCategoryData = {
	id: <?php echo json_encode($category->term_id); ?>,
	slug: <?php echo json_encode($category->slug); ?>,
	name: <?php echo json_encode($category->name); ?>
};
console.log('Page Type: category (React SPA Mode)', window.haliyoraCategoryData);
</script>

<?php
get_footer();
