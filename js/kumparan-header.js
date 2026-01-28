/**
 * Kumparan Header Interactions
 * Search toggle and mobile menu
 */

(function() {
    'use strict';
    
    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initHeaderSearch();
        initMobileMenu();
    });
    
    /**
     * Initialize header search toggle
     */
    function initHeaderSearch() {
        const searchTrigger = document.querySelector('.header-search-trigger');
        const searchBar = document.querySelector('.kumparan-search-bar');
        const searchClose = document.querySelector('.kumparan-search-form .search-close');
        const searchInput = document.querySelector('.kumparan-search-input');
        
        if (!searchTrigger || !searchBar) return;
        
        // Toggle search bar
        searchTrigger.addEventListener('click', function() {
            const isVisible = searchBar.style.display === 'block';
            
            if (isVisible) {
                searchBar.style.display = 'none';
            } else {
                searchBar.style.display = 'block';
                if (searchInput) {
                    setTimeout(() => searchInput.focus(), 100);
                }
            }
        });
        
        // Close search bar
        if (searchClose) {
            searchClose.addEventListener('click', function() {
                searchBar.style.display = 'none';
                if (searchInput) {
                    searchInput.value = '';
                }
            });
        }
        
        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchBar.style.display === 'block') {
                searchBar.style.display = 'none';
                if (searchInput) {
                    searchInput.value = '';
                }
            }
        });
    }
    
    /**
     * Initialize mobile menu
     */
    function initMobileMenu() {
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu-slide');
        const mobileOverlay = document.querySelector('.mobile-menu-overlay');
        
        if (!mobileToggle || !mobileMenu) return;
        
        // Toggle mobile menu
        mobileToggle.addEventListener('click', function() {
            const isActive = mobileMenu.classList.contains('active');
            
            if (isActive) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
        
        // Close on overlay click
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function() {
                closeMobileMenu();
            });
        }
        
        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        });
        
        function openMobileMenu() {
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
            mobileToggle.setAttribute('aria-expanded', 'true');
        }
        
        function closeMobileMenu() {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
            mobileToggle.setAttribute('aria-expanded', 'false');
        }
    }
    
    /**
     * Smooth scroll for navigation
     */
    function initSmoothScroll() {
        const navScroll = document.querySelector('.kumparan-nav-scroll');
        
        if (!navScroll) return;
        
        // Add scroll buttons if needed
        const scrollLeft = navScroll.scrollLeft;
        const scrollWidth = navScroll.scrollWidth;
        const clientWidth = navScroll.clientWidth;
        
        if (scrollWidth > clientWidth) {
            // Can be enhanced with scroll buttons
        }
    }
    
})();
