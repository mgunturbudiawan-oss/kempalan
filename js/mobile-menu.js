/**
 * Mobile Menu Toggle
 * Handles the mobile menu slide functionality
 */
(function() {
	'use strict';
	
	var mobileMenuToggle, mobileMenuSlide, mobileMenuOverlay, body;
	var isMenuOpen = false;
	var isInitialized = false;

	// Initialize mobile menu
	function initMobileMenu() {
		// Prevent double initialization
		if (isInitialized) {
			return;
		}
		
		mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
		mobileMenuSlide = document.querySelector('.mobile-menu-slide');
		mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
		body = document.body;

		// Check if elements exist
		if (!mobileMenuToggle || !mobileMenuSlide) {
			return;
		}

		// Remove any existing event listeners by cloning and replacing
		var newToggle = mobileMenuToggle.cloneNode(true);
		mobileMenuToggle.parentNode.replaceChild(newToggle, mobileMenuToggle);
		mobileMenuToggle = newToggle;

		// Toggle menu when burger button is clicked
		mobileMenuToggle.addEventListener('click', handleToggleClick, false);
		
		// Close menu when overlay is clicked
		if (mobileMenuOverlay) {
			mobileMenuOverlay.addEventListener('click', handleOverlayClick, false);
		}

		// Close menu when clicking on a menu item (use event delegation)
		if (mobileMenuSlide) {
			mobileMenuSlide.addEventListener('click', handleMenuItemClick, false);
		}

		// Close menu on escape key
		document.addEventListener('keydown', handleEscapeKey, false);

		isInitialized = true;
	}

	// Handle toggle button click
	function handleToggleClick(e) {
		e.preventDefault();
		e.stopPropagation();
		e.stopImmediatePropagation();
		
		// Toggle immediately without checking state
		if (mobileMenuSlide.classList.contains('active')) {
			closeMenu();
		} else {
			openMenu();
		}
	}

	// Handle overlay click
	function handleOverlayClick(e) {
		e.preventDefault();
		e.stopPropagation();
		closeMenu();
	}

	// Handle menu item click (event delegation)
	function handleMenuItemClick(e) {
		var target = e.target;
		// Check if clicked element is a menu item or inside a menu item
		while (target && target !== mobileMenuSlide) {
			if (target.classList.contains('mobile-category-menu-item') || 
			    target.closest('.mobile-category-menu-item') ||
			    target.classList.contains('mobile-menu-list') ||
			    target.closest('.mobile-menu-list a')) {
				setTimeout(function() {
					closeMenu();
				}, 300);
				break;
			}
			target = target.parentNode;
		}
	}

	// Handle escape key
	function handleEscapeKey(e) {
		if (e.key === 'Escape' && isMenuOpen) {
			closeMenu();
		}
	}

	// Open menu function
	function openMenu() {
		if (!mobileMenuSlide || !mobileMenuToggle) return;
		
		// Force immediate display
		mobileMenuSlide.style.display = 'block';
		mobileMenuSlide.style.visibility = 'visible';
		mobileMenuSlide.style.opacity = '1';
		
		// Use requestAnimationFrame to ensure DOM update
		requestAnimationFrame(function() {
			mobileMenuSlide.classList.add('active');
			mobileMenuToggle.classList.add('active');
			mobileMenuToggle.setAttribute('aria-expanded', 'true');
			
			if (body) {
				body.classList.add('menu-open');
				body.style.overflow = 'hidden';
			}
			
			isMenuOpen = true;
		});
	}

	// Close menu function
	function closeMenu() {
		if (!mobileMenuSlide || !mobileMenuToggle) return;
		
		mobileMenuSlide.classList.remove('active');
		mobileMenuToggle.classList.remove('active');
		mobileMenuToggle.setAttribute('aria-expanded', 'false');
		
		if (body) {
			body.classList.remove('menu-open');
			body.style.overflow = '';
		}
		
		// Reset inline styles after transition
		setTimeout(function() {
			if (!mobileMenuSlide.classList.contains('active')) {
				mobileMenuSlide.style.display = '';
				mobileMenuSlide.style.visibility = '';
				mobileMenuSlide.style.opacity = '';
			}
		}, 300);
		
		isMenuOpen = false;
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initMobileMenu);
	} else {
		// DOM already loaded
		setTimeout(initMobileMenu, 0);
	}
})();
