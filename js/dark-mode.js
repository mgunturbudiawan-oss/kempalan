/**
 * Perfect Dark Mode Toggle
 * Material Design Dark Theme Implementation
 */

(function() {
    'use strict';

    const DarkMode = {
        storageKey: 'haliyora-dark-mode',
        
        init() {
            this.createToggle();
            this.loadPreference();
            this.attachEvents();
            console.log('🌙 Dark Mode initialized');
        },

        createToggle() {
            const toggle = document.createElement('button');
            toggle.id = 'dark-mode-toggle';
            toggle.className = 'dark-mode-toggle material-button';
            toggle.setAttribute('aria-label', 'Toggle Dark Mode');
            toggle.innerHTML = `
                <span class="material-icons light-icon">dark_mode</span>
                <span class="material-icons dark-icon">light_mode</span>
            `;
            
            // Insert after social icons in header
            const socialIcons = document.querySelector('.header-social');
            if (socialIcons) {
                socialIcons.insertAdjacentElement('afterend', toggle);
            } else {
                // Fallback: insert before mobile menu toggle
                const mobileToggle = document.querySelector('.mobile-menu-toggle');
                if (mobileToggle) {
                    mobileToggle.insertAdjacentElement('beforebegin', toggle);
                }
            }
        },

        loadPreference() {
            const isDark = localStorage.getItem(this.storageKey) === 'true';
            if (isDark) {
                this.enableDarkMode(false);
            }
        },

        attachEvents() {
            const toggle = document.getElementById('dark-mode-toggle');
            if (toggle) {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.toggle();
                });
            }
        },

        toggle() {
            const isDark = document.body.classList.contains('dark-mode');
            if (isDark) {
                this.disableDarkMode();
            } else {
                this.enableDarkMode(true);
            }
        },

        enableDarkMode(animate = true) {
            document.body.classList.add('dark-mode');
            if (animate) {
                document.body.classList.add('dark-mode-transition');
                setTimeout(() => {
                    document.body.classList.remove('dark-mode-transition');
                }, 300);
            }
            localStorage.setItem(this.storageKey, 'true');
            this.updateToggleState();
            console.log('🌙 Dark mode enabled');
        },

        disableDarkMode() {
            document.body.classList.add('dark-mode-transition');
            document.body.classList.remove('dark-mode');
            setTimeout(() => {
                document.body.classList.remove('dark-mode-transition');
            }, 300);
            localStorage.setItem(this.storageKey, 'false');
            this.updateToggleState();
            console.log('☀️ Light mode enabled');
        },

        updateToggleState() {
            const toggle = document.getElementById('dark-mode-toggle');
            if (toggle) {
                const isDark = document.body.classList.contains('dark-mode');
                toggle.setAttribute('aria-pressed', isDark);
                toggle.classList.toggle('active', isDark);
            }
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => DarkMode.init());
    } else {
        DarkMode.init();
    }

    // Expose to window for debugging
    window.HaliyoraDarkMode = DarkMode;

})();
