/**
 * Headline Slider Functionality
 */
(function() {
	'use strict';
	
	const sliders = document.querySelectorAll('.headline-slider');
	if ( sliders.length === 0 ) {
		return;
	}

	sliders.forEach( slider => {
		const slides = slider.querySelectorAll('.headline-slide');
		const dots = slider.querySelectorAll('.headline-dot');
		const prevBtn = slider.querySelector('.headline-nav-prev');
		const nextBtn = slider.querySelector('.headline-nav-next');
		
		if ( slides.length === 0 ) {
			return;
		}
		
		let currentSlide = 0;
		let autoplayInterval;
		
		// Function to show slide
		function showSlide( index ) {
			// Remove active class from all slides and dots
			slides.forEach( slide => slide.classList.remove( 'active' ) );
			dots.forEach( dot => dot.classList.remove( 'active' ) );
			
			// Add active class to current slide and dot
			if ( slides[index] ) {
				slides[index].classList.add( 'active' );
			}
			if ( dots[index] ) {
				dots[index].classList.add( 'active' );
			}
			
			currentSlide = index;
		}
		
		// Next slide
		function nextSlide() {
			const next = ( currentSlide + 1 ) % slides.length;
			showSlide( next );
		}
		
		// Previous slide
		function prevSlide() {
			const prev = ( currentSlide - 1 + slides.length ) % slides.length;
			showSlide( prev );
		}
		
		// Auto play
		function startAutoplay() {
			// Only autoplay if it's the main headline slider or has many slides
			if ( slider.closest('.headline-section') ) {
				autoplayInterval = setInterval( nextSlide, 5000 );
			}
		}
		
		function stopAutoplay() {
			if ( autoplayInterval ) {
				clearInterval( autoplayInterval );
			}
		}
		
		// Event listeners
		if ( nextBtn ) {
			nextBtn.addEventListener( 'click', () => {
				nextSlide();
				stopAutoplay();
				startAutoplay();
			} );
		}
		
		if ( prevBtn ) {
			prevBtn.addEventListener( 'click', () => {
				prevSlide();
				stopAutoplay();
				startAutoplay();
			} );
		}
		
		// Dot navigation
		dots.forEach( ( dot, index ) => {
			dot.addEventListener( 'click', () => {
				showSlide( index );
				stopAutoplay();
				startAutoplay();
			} );
		} );
		
		// Pause on hover
		slider.addEventListener( 'mouseenter', stopAutoplay );
		slider.addEventListener( 'mouseleave', startAutoplay );
		
		// Start autoplay
		startAutoplay();
	});
	
})();
