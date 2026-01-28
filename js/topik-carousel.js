/**
 * Topik Populer Carousel Functionality
 */
(function() {
	'use strict';
	
	const carousel = document.querySelector('.topik-carousel');
	if ( ! carousel ) {
		return;
	}
	
	const slides = carousel.querySelector('.topik-slides');
	const items = carousel.querySelectorAll('.topik-item');
	
	if ( items.length === 0 ) {
		return;
	}
	
})();
