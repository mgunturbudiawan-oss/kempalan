/**
 * Haliyora Theme System Check
 * Verifies React and Material Design implementation
 */

(function() {
    'use strict';

    // Wait for everything to load
    window.addEventListener('load', function() {
        setTimeout(runSystemCheck, 2000);
    });

    function runSystemCheck() {
        console.log('%c🔍 Haliyora Theme System Check', 'font-size: 16px; font-weight: bold; color: #d32f2f;');
        console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #999;');

        let allPassed = true;

        // 1. Check React
        console.log('\n%c1. React JS Check', 'font-weight: bold; color: #1976d2;');
        const reactLoaded = typeof window.React !== 'undefined';
        const reactDOMLoaded = typeof window.ReactDOM !== 'undefined';
        
        if (reactLoaded && reactDOMLoaded) {
            console.log('%c   ✓ React loaded', 'color: #4caf50;', 'Version:', React.version);
            console.log('%c   ✓ ReactDOM loaded', 'color: #4caf50;');
        } else {
            console.log('%c   ✗ React not loaded', 'color: #f44336;');
            allPassed = false;
        }

        // 2. Check Material Design
        console.log('\n%c2. Material Design Check', 'font-weight: bold; color: #1976d2;');
        
        // Check Material Icons
        const materialIcons = document.querySelectorAll('.material-icons');
        if (materialIcons.length > 0) {
            const testIcon = materialIcons[0];
            const fontFamily = window.getComputedStyle(testIcon).fontFamily;
            if (fontFamily.includes('Material Icons')) {
                console.log('%c   ✓ Material Icons loaded', 'color: #4caf50;', `(${materialIcons.length} instances)`);
            } else {
                console.log('%c   ⚠ Material Icons font issue', 'color: #ff9800;');
            }
        } else {
            console.log('%c   ℹ No Material Icons found on page', 'color: #2196f3;');
        }

        // Check Roboto font
        const bodyFont = window.getComputedStyle(document.body).fontFamily;
        if (bodyFont.includes('Roboto')) {
            console.log('%c   ✓ Roboto font loaded', 'color: #4caf50;');
        } else {
            console.log('%c   ⚠ Roboto font not detected', 'color: #ff9800;');
        }

        // Check Material Design utilities
        if (typeof window.HaliyoraMaterialDesign !== 'undefined') {
            console.log('%c   ✓ Material Design utilities available', 'color: #4caf50;');
        } else {
            console.log('%c   ✗ Material Design utilities missing', 'color: #f44336;');
            allPassed = false;
        }

        // 3. Check React Components
        console.log('\n%c3. React Components Check', 'font-weight: bold; color: #1976d2;');
        const reactContainers = document.querySelectorAll('[data-react-component]');
        
        if (reactContainers.length > 0) {
            console.log('%c   ✓ Found React containers', 'color: #4caf50;', `(${reactContainers.length} total)`);
            
            reactContainers.forEach((container, index) => {
                const componentName = container.getAttribute('data-react-component');
                console.log(`     ${index + 1}. ${componentName}`);
            });
        } else {
            console.log('%c   ℹ No React components on this page', 'color: #2196f3;');
        }

        // Check React utilities
        if (typeof window.HaliyoraReactUtils !== 'undefined') {
            console.log('%c   ✓ React utilities available', 'color: #4caf50;');
        } else {
            console.log('%c   ✗ React utilities missing', 'color: #f44336;');
            allPassed = false;
        }

        // 4. Check Scripts
        console.log('\n%c4. Scripts Check', 'font-weight: bold; color: #1976d2;');
        const requiredScripts = [
            'react',
            'react-dom',
            'haliyora-material-design-init',
            'haliyora-react-init',
            'haliyora-react',
            'haliyora-react-integration'
        ];

        const loadedScripts = Array.from(document.scripts).map(script => {
            const src = script.src || script.id;
            return src;
        });

        requiredScripts.forEach(scriptName => {
            const found = loadedScripts.some(src => src.includes(scriptName));
            if (found) {
                console.log(`%c   ✓ ${scriptName}`, 'color: #4caf50;');
            } else {
                console.log(`%c   ✗ ${scriptName}`, 'color: #f44336;');
                allPassed = false;
            }
        });

        // 5. Check Styles
        console.log('\n%c5. Styles Check', 'font-weight: bold; color: #1976d2;');
        const requiredStyles = [
            'Material Icons',
            'Roboto',
            'Font Awesome'
        ];

        const loadedStyles = Array.from(document.styleSheets).map(sheet => {
            try {
                return sheet.href || 'inline';
            } catch (e) {
                return 'cors-blocked';
            }
        });

        requiredStyles.forEach(styleName => {
            const found = loadedStyles.some(href => 
                href && href.toLowerCase().includes(styleName.toLowerCase().replace(/\s+/g, ''))
            );
            if (found) {
                console.log(`%c   ✓ ${styleName}`, 'color: #4caf50;');
            } else {
                console.log(`%c   ⚠ ${styleName} (may be loaded)`, 'color: #ff9800;');
            }
        });

        // 6. Check Layout Integrity
        console.log('\n%c6. Layout Integrity Check', 'font-weight: bold; color: #1976d2;');
        const mainElements = [
            { selector: '.site-header', name: 'Header' },
            { selector: '.main-navigation', name: 'Navigation' },
            { selector: '.site-main', name: 'Main Content' },
            { selector: '.site-footer', name: 'Footer' }
        ];

        let layoutOK = true;
        mainElements.forEach(({ selector, name }) => {
            const element = document.querySelector(selector);
            if (element) {
                console.log(`%c   ✓ ${name} present`, 'color: #4caf50;');
            } else {
                console.log(`%c   ⚠ ${name} not found (may not be on this page type)`, 'color: #ff9800;');
            }
        });

        // Final Summary
        console.log('\n%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━', 'color: #999;');
        if (allPassed) {
            console.log('%c✓ All critical systems operational', 'font-size: 14px; font-weight: bold; color: #4caf50;');
        } else {
            console.log('%c⚠ Some issues detected (see above)', 'font-size: 14px; font-weight: bold; color: #ff9800;');
        }
        
        console.log('\n%cℹ️  Debug Commands:', 'font-weight: bold; color: #2196f3;');
        console.log('   window.HaliyoraReactUtils.checkStatus()  - Check React status');
        console.log('   window.HaliyoraMaterialDesign.init()     - Reinit Material Design');
        console.log('   window.HaliyoraReactUtils.init()         - Reinit React components');
        console.log('%c━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n', 'color: #999;');
    }

    // Expose manual check
    window.runHaliyoraSystemCheck = runSystemCheck;

})();
