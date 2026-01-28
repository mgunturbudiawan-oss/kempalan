/**
 * Rekomendasi Carousel Functionality
 */
(function() {
	'use strict';
	
	const carousels = document.querySelectorAll('.rekomendasi-carousel');
	if ( carousels.length === 0 ) {
		return;
	}

	carousels.forEach(carousel => {
		const slides = carousel.querySelector('.rekomendasi-slides');
		const items = carousel.querySelectorAll('.rekomendasi-item');
		
		if ( items.length === 0 || !slides ) {
			return;
		}
		
		// Initial cursor style
		slides.style.cursor = 'auto';
	});
	
})();
