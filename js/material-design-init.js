/**
 * Material Design Initialization
 * Ensures Material Design components work properly
 */

(function() {
    'use strict';

    // Material Design Ripple Effect
    function initMaterialRipple() {
        const rippleElements = document.querySelectorAll('.material-button, .btn, button:not([data-no-ripple])');
        
        rippleElements.forEach(element => {
            if (element.classList.contains('ripple-initialized')) return;
            
            element.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
            
            element.classList.add('ripple-initialized');
        });
    }

    // Material Design Elevation on Hover
    function initMaterialElevation() {
        const elevationElements = document.querySelectorAll('.material-card, .widget, .berita-terbaru-item');
        
        elevationElements.forEach(element => {
            if (element.classList.contains('elevation-initialized')) return;
            
            const originalBoxShadow = window.getComputedStyle(element).boxShadow;
            
            element.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 8px 16px rgba(0,0,0,0.15)';
                this.style.transform = 'translateY(-2px)';
                this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            });
            
            element.addEventListener('mouseleave', function() {
                this.style.boxShadow = originalBoxShadow;
                this.style.transform = 'translateY(0)';
            });
            
            element.classList.add('elevation-initialized');
        });
    }

    // Material Icons Fallback Check
    function checkMaterialIcons() {
        const icons = document.querySelectorAll('.material-icons');
        if (icons.length === 0) return;
        
        const testIcon = icons[0];
        const computedFont = window.getComputedStyle(testIcon).fontFamily;
        
        if (!computedFont.includes('Material Icons')) {
            console.warn('Material Icons font not loaded properly');
            
            // Ensure font is loaded
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://fonts.googleapis.com/icon?family=Material+Icons';
            document.head.appendChild(link);
        }
    }

    // Material Design Input Focus Effects
    function initMaterialInputs() {
        const inputs = document.querySelectorAll('input:not([type="submit"]):not([type="button"]), textarea');
        
        inputs.forEach(input => {
            if (input.classList.contains('material-initialized')) return;
            
            // Add focus effect
            input.addEventListener('focus', function() {
                this.style.outline = 'none';
                this.style.borderColor = '#d32f2f';
                this.style.transition = 'border-color 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            });
            
            input.addEventListener('blur', function() {
                this.style.borderColor = '';
            });
            
            input.classList.add('material-initialized');
        });
    }

    // Material Design Typography
    function initMaterialTypography() {
        // Ensure Roboto font is applied
        const body = document.body;
        const currentFont = window.getComputedStyle(body).fontFamily;
        
        if (!currentFont.includes('Roboto')) {
            console.warn('Roboto font not loaded, ensuring it loads');
            
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap';
            document.head.appendChild(link);
        }
    }

    // Initialize all Material Design features
    function initMaterialDesign() {
        checkMaterialIcons();
        initMaterialTypography();
        initMaterialRipple();
        initMaterialElevation();
        initMaterialInputs();
        
        console.log('✓ Material Design initialized');
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMaterialDesign);
    } else {
        initMaterialDesign();
    }

    // Re-initialize on dynamic content load
    document.addEventListener('contentUpdated', initMaterialDesign);
    
    // Expose for manual re-initialization if needed
    window.HaliyoraMaterialDesign = {
        init: initMaterialDesign,
        initRipple: initMaterialRipple,
        initElevation: initMaterialElevation,
        initInputs: initMaterialInputs
    };

})();
