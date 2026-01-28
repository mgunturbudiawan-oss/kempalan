/**
 * Floating Share Buttons - Show on scroll near end of article
 */
(function() {
	'use strict';
	
	// Wait for DOM to be ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initFloatingShare);
	} else {
		initFloatingShare();
	}
	
	function initFloatingShare() {
		const floatingShare = document.querySelector('.floating-share-mobile');
		
		if (!floatingShare) {
			return;
		}
		
		// Get article element
		const article = document.querySelector('.single-post-article');
		if (!article) {
			return;
		}
		
		// Initially hide the floating share
		floatingShare.style.display = 'none';
		floatingShare.classList.remove('show');
		
		// Function to check scroll position
		function checkScrollPosition() {
			// Only show on mobile (screen width <= 768px)
			if (window.innerWidth > 768) {
				floatingShare.style.display = 'none';
				floatingShare.classList.remove('show');
				return;
			}
			
			const windowHeight = window.innerHeight;
			const documentHeight = document.documentElement.scrollHeight;
			const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
			const scrollBottom = scrollTop + windowHeight;
			
			// Calculate when to show (when scrolled 70% of the article or near the end)
			const articleTop = article.offsetTop;
			const articleHeight = article.offsetHeight;
			
			// Show when user has scrolled past 70% of the article
			const showThreshold = articleTop + (articleHeight * 0.7);
			
			// Also check if near the end of the page (within 300px from bottom)
			const distanceFromBottom = documentHeight - scrollBottom;
			
			if (scrollTop >= showThreshold || distanceFromBottom <= 300) {
				floatingShare.style.display = 'block';
				// Use setTimeout to trigger transition
				setTimeout(function() {
					floatingShare.classList.add('show');
				}, 10);
			} else {
				floatingShare.classList.remove('show');
				// Hide after transition
				setTimeout(function() {
					if (!floatingShare.classList.contains('show')) {
						floatingShare.style.display = 'none';
					}
				}, 300);
			}
		}
		
		// Listen to scroll events
		let ticking = false;
		window.addEventListener('scroll', function() {
			if (!ticking) {
				window.requestAnimationFrame(function() {
					checkScrollPosition();
					ticking = false;
				});
				ticking = true;
			}
		});
		
		// Check on resize (to handle orientation change)
		window.addEventListener('resize', function() {
			checkScrollPosition();
		});
		
		// Initial check
		checkScrollPosition();
	}
})();
