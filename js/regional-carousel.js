/**
 * Regional Carousel Functionality
 */
(function() {
	'use strict';
	
	const carousel = document.querySelector('.regional-carousel');
	if ( ! carousel ) {
		return;
	}
	
	const slides = carousel.querySelector('.regional-slides');
	const items = carousel.querySelectorAll('.regional-item');
	const prevBtn = carousel.querySelector('.regional-prev');
	const nextBtn = carousel.querySelector('.regional-next');
	
	if ( items.length === 0 ) {
		return;
	}
	
	// Scroll amount (3 items at a time)
	const scrollAmount = 3;
	
	// Function to scroll carousel
	function scrollCarousel(direction) {
		const itemWidth = items[0].offsetWidth + 15; // width + gap
		const scrollDistance = itemWidth * scrollAmount;
		
		if (direction === 'next') {
			slides.scrollBy({
				left: scrollDistance,
				behavior: 'smooth'
			});
		} else {
			slides.scrollBy({
				left: -scrollDistance,
				behavior: 'smooth'
			});
		}
	}
	
	// Next slide
	function nextSlide() {
		scrollCarousel('next');
	}
	
	// Previous slide
	function prevSlide() {
		scrollCarousel('prev');
	}
	
	// Event listeners
	if ( nextBtn ) {
		nextBtn.addEventListener( 'click', nextSlide );
	}
	
	if ( prevBtn ) {
		prevBtn.addEventListener( 'click', prevSlide );
	}
	
	// Hide/show navigation buttons based on scroll position
	function updateNavButtons() {
		const scrollLeft = slides.scrollLeft;
		const maxScroll = slides.scrollWidth - slides.clientWidth;
		
		if (prevBtn) {
			prevBtn.style.opacity = scrollLeft <= 0 ? '0.3' : '1';
			prevBtn.style.pointerEvents = scrollLeft <= 0 ? 'none' : 'auto';
		}
		
		if (nextBtn) {
			nextBtn.style.opacity = scrollLeft >= maxScroll - 5 ? '0.3' : '1';
			nextBtn.style.pointerEvents = scrollLeft >= maxScroll - 5 ? 'none' : 'auto';
		}
	}
	
	// Listen to scroll events
	slides.addEventListener('scroll', updateNavButtons);
	
	// Initialize
	updateNavButtons();
	
})();
