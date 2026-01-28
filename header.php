<?php
/**
 * The header for our theme
 *
 * @package haliyora
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<!-- Preload Critical Resources -->
	<link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"></noscript>
	
	<link rel="preload" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"></noscript>
	
	<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/style.css?ver=<?php echo _S_VERSION; ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?ver=<?php echo _S_VERSION; ?>"></noscript>
	
	<?php
	// Google News SEO
	$google_news_id = get_theme_mod( 'haliyora_google_news_id', '' );
	if ( $google_news_id ) {
		echo '<meta name="news_keywords" content="' . esc_attr( $google_news_id ) . '">';
	}
	?>
	
	<?php wp_head(); ?>
	
	<style>
	/* Modern Header Enhancement */
	.shadcn-container {
		max-width: 1100px !important;
		margin: 0 auto !important;
		padding: 0 0 !important;
	}
	
	.kumparan-header {
		box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08) !important;
		backdrop-filter: blur(10px);
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
	}
	
	.kumparan-header-top {
		padding: 6px 0 !important;
		height: 64px !important;
		display: flex !important;
		align-items: center !important;
	}
	
	.breaking-news-bar {
		padding: 0 !important;
		height: 24px !important;
	}
	
	.header-logo {
		display: flex !important;
		align-items: center !important;
		justify-content: flex-start !important;
		height: 100% !important;
	}
	
	.header-logo a,
	.header-logo img {
		max-height: 44px !important;
		display: block !important;
		margin: 0 !important;
		line-height: 1 !important;
	}
	
	.kumparan-header.scrolled .header-logo a,
	.kumparan-header.scrolled .header-logo img {
		max-height: 32px !important;
	}

	/* Top Header Bar */
	.top-header-bar {
		background-color: #f8f9fa;
		border-bottom: 1px solid #eee;
		padding: 8px 0;
		font-size: 12px;
		color: #666;
	}

	body.dark-mode .top-header-bar {
		background-color: #1a1a1a;
		border-bottom-color: #333;
		color: #ccc;
	}

	.top-header-content {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.top-header-left {
		display: flex;
		align-items: center;
		gap: 15px;
	}

	.header-weather {
		display: flex;
		align-items: center;
		gap: 8px;
		padding-left: 15px;
		border-left: 1px solid #ddd;
		margin-left: 5px;
	}

	body.dark-mode .header-weather {
		border-left-color: #444;
	}

	.weather-temp {
		font-weight: 700;
		color: #333;
	}

	body.dark-mode .weather-temp {
		color: #fff;
	}

	.weather-city {
		font-weight: 500;
		cursor: pointer;
		display: flex;
		align-items: center;
		gap: 4px;
		padding: 2px 8px;
		border-radius: 4px;
		transition: background 0.2s;
	}

	.weather-city:hover {
		background: rgba(0, 169, 184, 0.1);
		color: #00a9b8;
	}

	.weather-city-select {
		position: relative;
	}

	.weather-dropdown {
		position: absolute;
		top: 100%;
		left: 0;
		background: #fff;
		border: 1px solid #ddd;
		border-radius: 8px;
		box-shadow: 0 4px 12px rgba(0,0,0,0.15);
		z-index: 2000;
		min-width: 180px;
		max-height: 250px;
		overflow-y: auto;
		display: none;
		margin-top: 5px;
	}

	body.dark-mode .weather-dropdown {
		background: #1e1e1e;
		border-color: #333;
	}

	.weather-dropdown.active {
		display: block;
	}

	.weather-dropdown-item {
		padding: 8px 15px;
		cursor: pointer;
		transition: background 0.2s;
		color: #333;
	}

	body.dark-mode .weather-dropdown-item {
		color: #eee;
	}

	.weather-dropdown-item:hover {
		background: rgba(0, 169, 184, 0.1);
		color: #00a9b8;
	}

	body.dark-mode .weather-dropdown-item:hover {
		background: rgba(0, 169, 184, 0.2);
	}

	.weather-icon {
		display: flex;
		align-items: center;
	}

	.weather-icon img {
		filter: drop-shadow(0 0 2px rgba(0,0,0,0.1));
	}

	.top-header-right {
		display: flex;
		align-items: center;
		gap: 15px;
	}

	.top-header-auth {
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.top-header-auth a {
		color: inherit;
		text-decoration: none;
		transition: color 0.2s;
	}

	.top-header-auth a:hover {
		color: #00a9b8;
	}

	.auth-separator {
		color: #ddd;
	}

	@media (max-width: 768px) {
		.top-header-bar {
			display: none;
		}
	}
	
	.header-logo a {
		font-size: 34px !important;
		font-weight: 800 !important;
		background: linear-gradient(135deg, #00a9b8 0%, #008c99 100%);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		transition: all 0.2s ease;
		display: inline-block !important;
		line-height: 1 !important;
	}
	
	.header-logo a:hover {
		transform: scale(1.05);
	}
	
	.header-search-form .search-icon {
		position: absolute;
		left: 16px;
		top: 50%;
		transform: translateY(-50%);
		color: #999;
		font-size: 16px;
		pointer-events: none;
		z-index: 1;
	}
	
	.header-search-input {
		border-radius: 24px !important;
		transition: all 0.3s ease !important;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
		padding-left: 50px !important;
	}
	
	.header-search-input:focus {
		box-shadow: 0 0 0 4px rgba(0, 169, 184, 0.1) !important;
		transform: translateY(-1px);
	}
	
	.header-search-wrapper {
		flex: 1 !important;
		max-width: 600px !important;
	}
	
	/* Social Media Icons */
	.social-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 36px;
		height: 36px;
		border-radius: 50%;
		color: #666;
		transition: all 0.2s ease;
		text-decoration: none;
	}
	
	.social-icon:hover {
		transform: translateY(-2px);
	}
	
	.social-icon .fa-facebook-f:hover {
		color: #1877f2;
	}
	
	.social-icon:has(.fa-facebook-f):hover {
		color: #1877f2;
		background: rgba(24, 119, 242, 0.1);
	}
	
	.social-icon:has(svg):hover {
		color: #000;
		background: rgba(0, 0, 0, 0.1);
	}
	
	.social-icon:has(.fa-instagram):hover {
		color: #e4405f;
		background: rgba(228, 64, 95, 0.1);
	}
	
	.social-icon:has(.fa-youtube):hover {
		color: #ff0000;
		background: rgba(255, 0, 0, 0.1);
	}
	
	.header-actions {
		display: flex !important;
		align-items: center !important;
		gap: 8px !important;
	}
	
	.shadcn-btn-primary {
		box-shadow: 0 2px 8px rgba(0, 169, 184, 0.3);
		transition: all 0.2s ease !important;
	}
	
	.shadcn-btn-primary:hover {
		box-shadow: 0 4px 12px rgba(0, 169, 184, 0.4);
		transform: translateY(-2px);
	}
	
	.shadcn-btn-secondary {
		box-shadow: 0 2px 8px rgba(44, 95, 45, 0.3);
		transition: all 0.2s ease !important;
	}
	
	.shadcn-btn-secondary:hover {
		box-shadow: 0 4px 12px rgba(44, 95, 45, 0.4);
		transform: translateY(-2px);
	}
	
	.kumparan-nav-item-wrapper {
		position: relative !important;
		display: inline-block !important;
	}
	
	.kumparan-nav-item-wrapper:hover .kumparan-dropdown {
		opacity: 1 !important;
		visibility: visible !important;
		transform: translateY(0) !important;
	}
	
	.kumparan-nav-item {
		transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
		padding: 6px 16px !important;
		display: flex !important;
		align-items: center !important;
		gap: 6px !important;
		font-size: 14px !important;
		font-weight: 500 !important;
		color: #333 !important;
		text-decoration: none !important;
		border-radius: 4px !important;
		position: relative !important;
		white-space: nowrap !important;
		flex-shrink: 0 !important;
	}
		
	.kumparan-nav-item:hover {
		background: rgba(0, 169, 184, 0.1) !important;
		color: #00a9b8 !important;
		transform: translateY(-2px);
	}
	
	.kumparan-nav-item .nav-icon {
		font-size: 18px !important;
		margin-right: 4px !important;
		vertical-align: middle !important;
	}
		
	.kumparan-nav-item .dropdown-arrow {
		font-size: 18px !important;
		margin-left: -2px !important;
		transition: transform 0.2s ease !important;
	}
	
	.kumparan-nav-item-wrapper:hover .dropdown-arrow {
		transform: rotate(180deg) !important;
	}
	
	/* Dropdown Styles */
	.kumparan-dropdown {
		position: absolute !important;
		top: 100% !important;
		left: 0 !important;
		margin-top: 8px !important;
		opacity: 0 !important;
		visibility: hidden !important;
		transform: translateY(-10px) !important;
		transition: all 0.2s ease !important;
		z-index: 1000 !important;
	}
	
	.kumparan-dropdown-content {
		background: white !important;
		border-radius: 8px !important;
		box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
		padding: 8px 0 !important;
		min-width: 200px !important;
	}
	
	.kumparan-dropdown-item {
		display: block !important;
		padding: 10px 20px !important;
		font-size: 14px !important;
		color: #333 !important;
		text-decoration: none !important;
		transition: all 0.2s ease !important;
	}
	
	.kumparan-dropdown-item:hover {
		background: rgba(0, 169, 184, 0.1) !important;
		color: #00a9b8 !important;
		padding-left: 24px !important;
	}
	
	.shadcn-badge {
		transition: all 0.2s ease !important;
		box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
	}
	
	.shadcn-badge:hover {
		transform: translateY(-2px);
		box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
	}
	
	/* Breaking News Bar */
	.breaking-news-bar {
		display: flex;
		align-items: center;
		gap: 16px;
		padding: 12px 0;
		margin-top: 8px;
		overflow: hidden;
	}
	
	.breaking-news-label {
		display: flex;
		align-items: center;
		gap: 6px;
		padding: 6px 14px;
		background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
		color: white;
		border-radius: 20px;
		font-size: 13px;
		font-weight: 600;
		white-space: nowrap;
		box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
	}
	
	.breaking-icon {
		font-size: 16px;
		animation: pulse 2s infinite;
	}
	
	@keyframes pulse {
		0%, 100% { opacity: 1; }
		50% { opacity: 0.6; }
	}
	
	.breaking-news-scroll {
		flex: 1;
		display: flex;
		gap: 12px;
		overflow-x: auto;
		scrollbar-width: none;
		-ms-overflow-style: none;
	}
	
	.breaking-news-scroll::-webkit-scrollbar {
		display: none;
	}
	
	.breaking-news-item {
		white-space: nowrap;
		text-decoration: none;
		color: #1a1a1a;
		font-size: 14px;
		font-weight: 500;
		transition: color 0.2s ease;
	}
	
	.breaking-news-item:hover {
		color: #dc2626;
	}
	
	.breaking-separator {
		color: #d0d0d0;
		font-size: 14px;
	}
	
	/* Mobile Menu - Fixed Z-Index */
	.mobile-menu-slide {
		z-index: 2147483647 !important;
		position: fixed !important;
		top: 0 !important;
		left: 0 !important;
		right: 0 !important;
		bottom: 0 !important;
	}
	
	.mobile-menu-overlay {
		z-index: 2147483646 !important;
		position: fixed !important;
		top: 0 !important;
		left: 0 !important;
		right: 0 !important;
		bottom: 0 !important;
	}
	
	.mobile-menu-content {
		z-index: 2147483647 !important;
		position: fixed !important;
		top: 0 !important;
		left: 0 !important;
		height: 100vh !important;
		width: 85% !important;
		max-width: 320px !important;
	}
	
	@media (max-width: 768px) {
		.shadcn-container {
			padding: 0 0 !important;
		}
		
		.mobile-menu-toggle {
			display: flex !important;
			align-items: center !important;
			justify-content: center !important;
		}
		
		.header-search-wrapper,
		.social-icon {
			display: none !important;
		}
		
		/* Keep breaking news visible on mobile */
		.breaking-news-bar {
			display: flex !important;
			font-size: 11px !important;
			height: 20px !important;
			padding: 0 !important;
			margin-top: 4px !important;
			overflow: hidden !important;
		}
		
		.breaking-news-label {
			font-size: 9px !important;
			padding: 2px 8px !important;
			border-radius: 12px !important;
		}
		
		.breaking-icon {
			font-size: 10px !important;
		}
		
		.breaking-news-scroll {
			gap: 8px !important;
			animation: scroll-mobile 8s linear infinite !important;
		}
		
		@keyframes scroll-mobile {
			0% { transform: translateX(0); }
			100% { transform: translateX(-50%); }
		}
		
		.breaking-news-item {
			font-size: 11px !important;
		}
		
		.breaking-separator {
			font-size: 11px !important;
		}
		
		/* Keep nav visible on mobile - horizontal scroll */
		.kumparan-primary-nav {
			display: block !important;
			overflow-x: auto !important;
			-webkit-overflow-scrolling: touch !important;
		}
		
		.kumparan-nav-scroll {
			display: flex !important;
			flex-wrap: nowrap !important;
			gap: 0 !important;
			padding-bottom: 8px !important;
		}
		
		.kumparan-nav-item {
			white-space: nowrap !important;
			padding: 6px 12px !important;
			font-size: 13px !important;
		}
		
		.kumparan-header-top {
			height: 64px !important;
			padding: 0 !important;
		}
		
		.header-logo a {
			font-size: 30px !important;
		}
		
		.header-logo img {
			max-height: 40px !important;
		}
	}
	
	/* Dark Mode - Kumparan Nav */
	body.dark-mode .kumparan-nav-scroll,
	body.dark-mode .kumparan-nav-scroll a,
	body.dark-mode .kumparan-nav-item {
		color: #fff !important;
	}
	
	body.dark-mode .header-logo a {
		background: none !important;
		-webkit-text-fill-color: #fff !important;
		color: #fff !important;
	}
	
	body.dark-mode .header-logo img {
		filter: brightness(0) invert(1);
	}
	</style>
	
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Mobile menu toggle - Original style
		const menuToggle = document.querySelector('.mobile-menu-toggle');
		const mobileMenu = document.querySelector('.mobile-menu-slide');
		const menuOverlay = document.querySelector('.mobile-menu-overlay');
		
		function toggleMenu() {
			if (mobileMenu) {
				mobileMenu.classList.toggle('active');
				if (menuToggle) {
					menuToggle.classList.toggle('active');
				}
			}
		}
		
		function closeMenu() {
			if (mobileMenu) {
				mobileMenu.classList.remove('active');
				if (menuToggle) {
					menuToggle.classList.remove('active');
				}
			}
		}
		
		if (menuToggle) {
			menuToggle.addEventListener('click', toggleMenu);
		}
		
		if (menuOverlay) {
			menuOverlay.addEventListener('click', closeMenu);
		}

		// Drag to scroll for navigation
		const nav = document.querySelector('.kumparan-primary-nav');
		if (nav) {
			let isDown = false;
			let startX;
			let scrollLeft;

			nav.addEventListener('mousedown', (e) => {
				isDown = true;
				nav.classList.add('dragging');
				startX = e.pageX - nav.offsetLeft;
				scrollLeft = nav.scrollLeft;
			});
			nav.addEventListener('mouseleave', () => {
				isDown = false;
				nav.classList.remove('dragging');
			});
			nav.addEventListener('mouseup', () => {
				isDown = false;
				nav.classList.remove('dragging');
			});
			nav.addEventListener('mousemove', (e) => {
				if(!isDown) return;
				e.preventDefault();
				const x = e.pageX - nav.offsetLeft;
				const walk = (x - startX) * 2; //scroll-fast
				nav.scrollLeft = scrollLeft - walk;
			});
		}
	});
	</script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'haliyora' ); ?></a>

	<!-- Top Header Bar -->
	<div class="top-header-bar">
		<div class="shadcn-container">
			<div class="top-header-content">
				<div class="top-header-left">
					<div class="header-date">
						<i class="far fa-calendar-alt" style="margin-right: 5px; color: #d32f2f;"></i>
						<?php 
						echo wp_date('l, j F Y, \p\u\k\u\l : H:i \W\I\B'); 
						?>
					</div>
					<div class="header-weather" id="header-weather">
						<i class="fas fa-map-marker-alt" style="color: #00a9b8; margin-right: 3px;"></i>
						<div class="weather-city-select">
							<span class="weather-city" id="current-weather-city">Surabaya <i class="fas fa-chevron-down" style="font-size: 10px;"></i></span>
							<div class="weather-dropdown" id="weather-city-dropdown">
								<!-- Cities will be populated by JS -->
							</div>
						</div>
						<span class="weather-temp" style="margin-left: 5px;">--°C</span>
						<span class="weather-icon" id="weather-icon"></span>
					</div>
				</div>
				<div class="top-header-right">
					<div class="top-header-auth">
						<?php if ( is_user_logged_in() ) : ?>
							<?php 
							$current_user = wp_get_current_user();
							echo 'Halo, <strong>' . esc_html( $current_user->display_name ) . '</strong>';
							?>
							<span class="auth-separator">|</span>
							<a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
						<?php else : ?>
							<a href="javascript:void(0);" onclick="openAuthPopup('login')">Login</a>
							<span class="auth-separator">|</span>
							<a href="javascript:void(0);" onclick="openAuthPopup('register')">Register</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Main Header - Kumparan Style -->
	<header id="masthead" class="site-header kumparan-header">
		<div class="shadcn-container">
			<!-- Top Bar -->
			<div class="kumparan-header-top">
				<div class="header-logo">
					<?php
					if ( has_custom_logo() ) {
						the_custom_logo();
					} else {
						?>
						<h1 class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
						</h1>
						<?php
					}
					?>
				</div>
				
				<!-- Search Bar Desktop -->
				<div class="header-search-wrapper">
					<form role="search" method="get" class="header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<i class="fas fa-search search-icon"></i>
						<input type="search" 
						       class="shadcn-input header-search-input" 
						       placeholder="Cari di sini..." 
						       value="<?php echo get_search_query(); ?>" 
						       name="s">
					</form>
				</div>
							
				<div class="header-actions">
					<!-- Social Media Icons -->
					<a href="#" class="social-icon" aria-label="Facebook" target="_blank">
						<i class="fab fa-facebook-f"></i>
					</a>
					<a href="#" class="social-icon" aria-label="Twitter/X" target="_blank">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
							<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
						</svg>
					</a>
					<a href="#" class="social-icon" aria-label="Instagram" target="_blank">
						<i class="fab fa-instagram"></i>
					</a>
					<a href="#" class="social-icon" aria-label="YouTube" target="_blank">
						<i class="fab fa-youtube"></i>
					</a>
								
					<!-- Mobile Menu Toggle -->
					<button class="shadcn-btn shadcn-btn-ghost mobile-menu-toggle" aria-label="Menu" aria-expanded="false">
						<span class="material-icons">menu</span>
					</button>
					
					<!-- Admin Menu -->
					<?php
					if (function_exists('haliyora_add_admin_menu_to_header')) {
						haliyora_add_admin_menu_to_header();
					}
					?>
				</div>
			</div>
			
			<!-- Primary Navigation - Main Categories -->
			<nav class="kumparan-primary-nav">
				<div class="kumparan-nav-scroll">
					<?php
					// Icon mapping with colors
					$category_icons = array(
						'news' => array('icon' => 'newspaper', 'color' => '#f44336'),
						'berita' => array('icon' => 'newspaper', 'color' => '#f44336'),
						'entertainment' => array('icon' => 'movie', 'color' => '#e91e63'),
						'hiburan' => array('icon' => 'movie', 'color' => '#e91e63'),
						'tekno' => array('icon' => 'computer', 'color' => '#2196f3'),
						'technology' => array('icon' => 'computer', 'color' => '#2196f3'),
						'bisnis' => array('icon' => 'business_center', 'color' => '#ff9800'),
						'business' => array('icon' => 'business_center', 'color' => '#ff9800'),
						'woman' => array('icon' => 'face_3', 'color' => '#9c27b0'),
						'wanita' => array('icon' => 'face_3', 'color' => '#9c27b0'),
						'otomotif' => array('icon' => 'directions_car', 'color' => '#607d8b'),
						'olahraga' => array('icon' => 'sports_soccer', 'color' => '#4caf50'),
						'bola' => array('icon' => 'sports_soccer', 'color' => '#4caf50'),
						'sports' => array('icon' => 'sports_soccer', 'color' => '#4caf50'),
						'food' => array('icon' => 'restaurant', 'color' => '#ffc107'),
						'kuliner' => array('icon' => 'restaurant', 'color' => '#ffc107'),
						'travel' => array('icon' => 'flight', 'color' => '#03a9f4'),
						'wisata' => array('icon' => 'flight', 'color' => '#03a9f4'),
						'mom' => array('icon' => 'family_restroom', 'color' => '#ff4081'),
						'bolanita' => array('icon' => 'celebration', 'color' => '#7c4dff'),
						'politik' => array('icon' => 'account_balance', 'color' => '#3f51b5'),
						'kesehatan' => array('icon' => 'health_and_safety', 'color' => '#009688'),
						'pendidikan' => array('icon' => 'school', 'color' => '#795548'),
						'kriminal' => array('icon' => 'gavel', 'color' => '#212121'),
						'home' => array('icon' => 'home', 'color' => '#00a9b8'),
						'untukmu' => array('icon' => 'home', 'color' => '#00a9b8'),
						'nasional' => array('icon' => 'public', 'color' => '#f44336'),
						'internasional' => array('icon' => 'language', 'color' => '#2196f3'),
						'ekonomi' => array('icon' => 'trending_up', 'color' => '#4caf50'),
						'lifestyle' => array('icon' => 'style', 'color' => '#e91e63'),
						'viral' => array('icon' => 'trending_up', 'color' => '#ff5722'),
						'analisis' => array('icon' => 'analytics', 'color' => '#673ab7'),
						'opini' => array('icon' => 'comment', 'color' => '#00bcd4')
					);
					
					// Get menu items langsung tanpa Walker
					if ( has_nav_menu( 'menu-1' ) ) {
						$menu_name = 'menu-1';
						$locations = get_nav_menu_locations();
						$menu = wp_get_nav_menu_object( $locations[$menu_name] );
						$menu_items = wp_get_nav_menu_items( $menu->term_id );
						
						// Organize by parent
						$menu_tree = array();
						foreach ( $menu_items as $item ) {
							if ( $item->menu_item_parent == 0 ) {
								$menu_tree[$item->ID] = array(
									'item' => $item,
									'children' => array()
								);
							}
						}
						
						foreach ( $menu_items as $item ) {
							if ( $item->menu_item_parent != 0 && isset( $menu_tree[$item->menu_item_parent] ) ) {
								$menu_tree[$item->menu_item_parent]['children'][] = $item;
							}
						}
						
						// Display
						foreach ( $menu_tree as $menu_id => $menu_data ) {
							$item = $menu_data['item'];
							$has_children = !empty( $menu_data['children'] );
							
							$title_lower = strtolower( $item->title );
							$icon = 'folder';
							$icon_color = '#757575';
							foreach ( $category_icons as $key => $data ) {
								if ( strpos( $title_lower, $key ) !== false ) {
									$icon = $data['icon'];
									$icon_color = $data['color'];
									break;
								}
							}
							
							if ( $has_children ) {
								echo '<div class="kumparan-nav-item-wrapper">';
							}
							?>
							<a href="<?php echo esc_url( $item->url ); ?>" class="kumparan-nav-item<?php echo $has_children ? ' has-dropdown' : ''; ?>">
								<span class="material-icons nav-icon" style="color: <?php echo $icon_color; ?>;"><?php echo $icon; ?></span>
								<?php echo esc_html( $item->title ); ?>
								<?php if ( $has_children ) : ?>
									<span class="material-icons dropdown-arrow">keyboard_arrow_down</span>
								<?php endif; ?>
							</a>
							<?php
							
							if ( $has_children ) {
								echo '<div class="kumparan-dropdown"><div class="kumparan-dropdown-content">';
								foreach ( $menu_data['children'] as $child ) {
									?>
									<a href="<?php echo esc_url( $child->url ); ?>" class="kumparan-dropdown-item">
										<?php echo esc_html( $child->title ); ?>
									</a>
									<?php
								}
								echo '</div></div></div>';
							}
						}
					} else {
						?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="kumparan-nav-item">
							<span class="material-icons nav-icon" style="color: #00a9b8;">home</span>
							Home
						</a>
						<?php
						$primary_categories = get_categories( array( 
							'orderby' => 'name', 
							'order' => 'ASC', 
							'hide_empty' => false,
							'number' => 10
						) );
						
						if ( ! empty( $primary_categories ) ) {
							foreach ( $primary_categories as $category ) {
								$cat_slug = strtolower( $category->slug );
								$icon = 'folder';
								$icon_color = '#757575';
								
								foreach ( $category_icons as $key => $data ) {
									if ( strpos( $cat_slug, $key ) !== false ) {
										$icon = $data['icon'];
										$icon_color = $data['color'];
										break;
									}
								}
								?>
								<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="kumparan-nav-item">
									<span class="material-icons nav-icon" style="color: <?php echo $icon_color; ?>;"><?php echo $icon; ?></span>
									<?php echo esc_html( $category->name ); ?>
								</a>
								<?php
							}
						}
					}
					?>
				</div>
			</nav>
				
			<!-- Breaking News Bar -->
			<div class="breaking-news-bar">
				<div class="breaking-news-label">
					<span class="breaking-icon">⚡</span>
					<strong>Breaking News</strong>
				</div>
				<div class="breaking-news-scroll">
					<?php
					$cached_breaking = get_transient('haliyora_breaking_news_html');
					if (false === $cached_breaking) {
						$breaking_query = new WP_Query(array(
							'post_type'           => array( 'post', 'berita_foto' ),
							'posts_per_page'      => 5,
							'post_status'         => 'publish',
							'orderby'             => 'date',
							'order'               => 'DESC',
							'ignore_sticky_posts' => true,
							'no_found_rows'       => true,
						));
						
						ob_start();
						if ($breaking_query->have_posts()) :
							while ($breaking_query->have_posts()) : $breaking_query->the_post();
								?>
								<a href="<?php the_permalink(); ?>" class="breaking-news-item">
									<?php the_title(); ?>
								</a>
								<span class="breaking-separator">•</span>
								<?php
							endwhile;
							wp_reset_postdata();
						endif;
						$cached_breaking = ob_get_clean();
						// Cache for 10 minutes
						set_transient('haliyora_breaking_news_html', $cached_breaking, 10 * MINUTE_IN_SECONDS);
					}
					echo $cached_breaking;
					?>
				</div>
			</div>
				
		</div>
		
		<!-- Mobile Menu Slide - Original Style -->
		<div class="mobile-menu-slide">
			<div class="mobile-menu-overlay"></div>
			<div class="mobile-menu-content">
				<!-- Mobile Search -->
				<div class="mobile-search-form-wrapper">
					<form role="search" method="get" class="mobile-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="search" 
						       class="mobile-search-input" 
						       placeholder="Cari berita..." 
						       value="<?php echo get_search_query(); ?>" 
						       name="s">
						<button type="submit" class="mobile-search-submit" aria-label="Search">
							<span class="material-icons">search</span>
						</button>
					</form>
				</div>
				
				<!-- Mobile Category Menu -->
				<div class="mobile-category-menu">
					<ul class="mobile-menu-list">
						<?php
						// Icon mapping with colors for mobile
						$mobile_icons = array(
							'news' => array('icon' => 'newspaper', 'color' => '#f44336'),
							'berita' => array('icon' => 'newspaper', 'color' => '#f44336'),
							'entertainment' => array('icon' => 'movie', 'color' => '#e91e63'),
							'hiburan' => array('icon' => 'movie', 'color' => '#e91e63'),
							'tekno' => array('icon' => 'computer', 'color' => '#2196f3'),
							'technology' => array('icon' => 'computer', 'color' => '#2196f3'),
							'bisnis' => array('icon' => 'business_center', 'color' => '#ff9800'),
							'business' => array('icon' => 'business_center', 'color' => '#ff9800'),
							'woman' => array('icon' => 'face_3', 'color' => '#9c27b0'),
							'wanita' => array('icon' => 'face_3', 'color' => '#9c27b0'),
							'otomotif' => array('icon' => 'directions_car', 'color' => '#607d8b'),
							'olahraga' => array('icon' => 'sports_soccer', 'color' => '#4caf50'),
							'bola' => array('icon' => 'sports_soccer', 'color' => '#4caf50'),
							'sports' => array('icon' => 'sports_soccer', 'color' => '#4caf50'),
							'food' => array('icon' => 'restaurant', 'color' => '#ffc107'),
							'kuliner' => array('icon' => 'restaurant', 'color' => '#ffc107'),
							'travel' => array('icon' => 'flight', 'color' => '#03a9f4'),
							'wisata' => array('icon' => 'flight', 'color' => '#03a9f4'),
							'mom' => array('icon' => 'family_restroom', 'color' => '#ff4081'),
							'bolanita' => array('icon' => 'celebration', 'color' => '#7c4dff'),
							'politik' => array('icon' => 'account_balance', 'color' => '#3f51b5'),
							'kesehatan' => array('icon' => 'health_and_safety', 'color' => '#009688'),
							'pendidikan' => array('icon' => 'school', 'color' => '#795548'),
							'kriminal' => array('icon' => 'gavel', 'color' => '#212121'),
							'home' => array('icon' => 'home', 'color' => '#00a9b8'),
							'untukmu' => array('icon' => 'home', 'color' => '#00a9b8'),
							'nasional' => array('icon' => 'public', 'color' => '#f44336'),
							'internasional' => array('icon' => 'language', 'color' => '#2196f3'),
							'ekonomi' => array('icon' => 'trending_up', 'color' => '#4caf50'),
							'lifestyle' => array('icon' => 'style', 'color' => '#e91e63'),
							'viral' => array('icon' => 'trending_up', 'color' => '#ff5722'),
							'analisis' => array('icon' => 'analytics', 'color' => '#673ab7'),
							'opini' => array('icon' => 'comment', 'color' => '#00bcd4')
						);
						
						// Get menu untuk mobile
						if ( has_nav_menu( 'menu-1' ) ) {
							$menu_name = 'menu-1';
							$locations = get_nav_menu_locations();
							$menu = wp_get_nav_menu_object( $locations[$menu_name] );
							$menu_items = wp_get_nav_menu_items( $menu->term_id );
							
							// Organize by parent (only top level for mobile)
							foreach ( $menu_items as $item ) {
								if ( $item->menu_item_parent == 0 ) {
									$title_lower = strtolower( $item->title );
									$icon = 'folder';
									$icon_color = '#757575';
									foreach ( $mobile_icons as $key => $data ) {
										if ( strpos( $title_lower, $key ) !== false ) {
											$icon = $data['icon'];
											$icon_color = $data['color'];
											break;
										}
									}
									?>
									<li>
										<a href="<?php echo esc_url( $item->url ); ?>" class="mobile-category-menu-item">
											<span class="material-icons menu-icon" style="color: <?php echo $icon_color; ?>;"><?php echo $icon; ?></span>
											<?php echo esc_html( $item->title ); ?>
										</a>
									</li>
									<?php
								}
							}
						} else {
							?>
							<li>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-category-menu-item <?php echo is_home() ? 'active' : ''; ?>">
									<span class="material-icons menu-icon" style="color: #00a9b8;">home</span>
									Home
								</a>
							</li>
							<?php
							$mobile_categories = get_categories( array( 
								'orderby' => 'name', 
								'order' => 'ASC',
								'hide_empty' => false,
								'number' => 15
							) );
							
							if ( ! empty( $mobile_categories ) ) {
								foreach ( $mobile_categories as $category ) {
									$is_active = is_category( $category->term_id );
									$cat_slug = strtolower( $category->slug );
									$icon = 'folder';
									$icon_color = '#757575';
									
									foreach ( $mobile_icons as $key => $data ) {
										if ( strpos( $cat_slug, $key ) !== false ) {
											$icon = $data['icon'];
											$icon_color = $data['color'];
											break;
										}
									}
									?>
									<li>
										<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="mobile-category-menu-item <?php echo $is_active ? 'active' : ''; ?>">
											<span class="material-icons menu-icon" style="color: <?php echo $icon_color; ?>;"><?php echo $icon; ?></span>
											<?php echo esc_html( $category->name ); ?>
										</a>
									</li>
									<?php
								}
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</header>
	
