<?php
/**
 * Template Name: React SPA Home
 * Description: Home page rendered by React SPA
 * 
 * @package haliyora
 */

get_header();
?>

<div class="container-1100">
	<div class="content-wrapper">
		<main id="primary" class="site-main">
			
			<!-- React SPA Root -->
			<div id="react-spa-root" data-page-type="home">
				<!-- Loading placeholder -->
				<div style="text-align: center; padding: 60px 20px;">
					<span class="material-icons" style="font-size: 48px; color: #d32f2f; animation: spin 1s linear infinite;">refresh</span>
					<p style="margin-top: 15px; color: #757575;">Loading React SPA...</p>
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

.react-loading {
	text-align: center;
	padding: 40px;
	color: #757575;
}

.react-loading .material-icons {
	font-size: 48px;
	animation: spin 1s linear infinite;
}

.react-error {
	padding: 20px;
	background: #ffebee;
	border: 1px solid #ef5350;
	border-radius: 4px;
	color: #c62828;
	margin: 20px 0;
}

.react-home-page,
.react-category-page,
.react-single-page {
	animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
	from { opacity: 0; transform: translateY(10px); }
	to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
// Inline initialization to ensure React SPA knows the page type
window.haliyoraPageType = 'home';
console.log('Page Type: home (React SPA Mode)');
</script>

<?php
get_footer();
