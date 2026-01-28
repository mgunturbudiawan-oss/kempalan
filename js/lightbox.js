/**
 * Simple Lightbox for Featured Images
 */
(function() {
	'use strict';
	
	const lightboxModal = document.getElementById('image-lightbox');
	const lightboxImage = lightboxModal.querySelector('.lightbox-image');
	const lightboxCaption = lightboxModal.querySelector('.lightbox-caption');
	const lightboxClose = lightboxModal.querySelector('.lightbox-close');
	const featuredImageLinks = document.querySelectorAll('.featured-image-lightbox');
	
	if ( ! lightboxModal || featuredImageLinks.length === 0 ) {
		return;
	}
	
	// Open lightbox
	featuredImageLinks.forEach(function(link) {
		link.addEventListener('click', function(e) {
			e.preventDefault();
			const imageUrl = this.getAttribute('href');
			const caption = this.getAttribute('data-caption') || '';
			
			lightboxImage.src = imageUrl;
			lightboxCaption.textContent = caption;
			lightboxModal.style.display = 'flex';
			document.body.style.overflow = 'hidden';
		});
	});
	
	// Close lightbox
	function closeLightbox() {
		lightboxModal.style.display = 'none';
		document.body.style.overflow = '';
	}
	
	lightboxClose.addEventListener('click', closeLightbox);
	
	lightboxModal.addEventListener('click', function(e) {
		if ( e.target === lightboxModal ) {
			closeLightbox();
		}
	});
	
	// Close on ESC key
	document.addEventListener('keydown', function(e) {
		if ( e.key === 'Escape' && lightboxModal.style.display === 'flex' ) {
			closeLightbox();
		}
	});
	
})();
