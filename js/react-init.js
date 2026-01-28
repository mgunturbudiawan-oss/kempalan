/**
 * React JS Initialization
 * Ensures React is properly loaded and components are mounted
 */

(function() {
    'use strict';

    let reactCheckAttempts = 0;
    const MAX_ATTEMPTS = 50; // 5 seconds max wait

    // Check if React is loaded
    function isReactLoaded() {
        return typeof window.React !== 'undefined' && 
               typeof window.ReactDOM !== 'undefined';
    }

    // Wait for React to load
    function waitForReact(callback) {
        if (isReactLoaded()) {
            callback();
        } else if (reactCheckAttempts < MAX_ATTEMPTS) {
            reactCheckAttempts++;
            setTimeout(() => waitForReact(callback), 100);
        } else {
            console.error('React failed to load after 5 seconds');
        }
    }

    // Initialize React components
    function initReactComponents() {
        if (!isReactLoaded()) {
            console.warn('React or ReactDOM not loaded yet');
            return;
        }

        console.log('✓ React loaded successfully');
        console.log('React version:', React.version);

        // Mount React components to data-react-component elements
        const reactContainers = document.querySelectorAll('[data-react-component]');
        
        if (reactContainers.length > 0) {
            console.log(`Found ${reactContainers.length} React component(s) to mount`);
            
            // Trigger component rendering if integration script exists
            if (window.HaliyoraReact && window.HaliyoraReact.renderAll) {
                window.HaliyoraReact.renderAll();
            } else if (window.renderReactComponents) {
                window.renderReactComponents();
            }
        } else {
            console.log('No React components found on this page');
        }

        // Store React reference globally for debugging
        window.HaliyoraReactInstance = {
            React: window.React,
            ReactDOM: window.ReactDOM,
            isLoaded: true,
            version: React.version
        };
    }

    // Check React loading status
    function checkReactStatus() {
        const status = {
            loaded: isReactLoaded(),
            React: typeof window.React !== 'undefined',
            ReactDOM: typeof window.ReactDOM !== 'undefined',
            components: document.querySelectorAll('[data-react-component]').length
        };

        console.log('React Status:', status);
        return status;
    }

    // Initialize when DOM is ready
    function init() {
        console.log('Initializing React...');
        
        waitForReact(() => {
            initReactComponents();
            
            // Re-initialize on dynamic content updates
            document.addEventListener('contentUpdated', initReactComponents);
            
            console.log('✓ React initialization complete');
        });
    }

    // Run initialization
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose utilities globally
    window.HaliyoraReactUtils = {
        isLoaded: isReactLoaded,
        checkStatus: checkReactStatus,
        init: initReactComponents,
        waitForReact: waitForReact
    };

})();
