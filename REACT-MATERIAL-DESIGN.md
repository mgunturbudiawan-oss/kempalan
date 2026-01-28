# React JS dan Material Design Implementation

## Overview
Template Haliyora sudah dikonfigurasi dengan React JS 18 dan Material Design yang berfungsi penuh tanpa mengubah layout yang ada.

## Struktur File

### JavaScript Files
1. **js/material-design-init.js** - Inisialisasi Material Design
   - Ripple effect pada button
   - Elevation hover effect
   - Material Icons check
   - Input focus effects
   - Typography fallback

2. **js/react-init.js** - Inisialisasi React
   - Pengecekan loading React
   - Auto-mounting components
   - Status monitoring
   - Debug utilities

3. **js/react-components.js** - React components library
4. **js/react-integration.js** - React integration dengan WordPress

### CSS Enhancements
**style.css** sudah diperkaya dengan:
- Material Design Ripple Effect
- Material Design Elevation
- Material Design Typography classes
- Smooth transitions dengan cubic-bezier

## Fitur Material Design

### 1. Ripple Effect
Otomatis aktif pada semua button. Efek ripple muncul saat diklik.

```html
<!-- Otomatis terdeteksi -->
<button>Click Me</button>

<!-- Manual disable -->
<button data-no-ripple>No Ripple</button>
```

### 2. Elevation Effect
Cards dan widgets otomatis mendapat hover elevation effect.

```html
<div class="material-card">Card dengan elevation</div>
<div class="widget">Widget dengan elevation</div>
```

### 3. Typography Classes
```html
<h2 class="material-title">Judul Material</h2>
<p class="material-subtitle">Subjudul</p>
<p class="material-body">Body text</p>
<span class="material-caption">Caption text</span>
```

### 4. Input Focus Effects
Semua input otomatis mendapat Material Design focus effect (border merah).

## React Implementation

### Loading Order
1. React & ReactDOM dari CDN
2. material-design-init.js
3. react-init.js (checks React loaded)
4. react-components.js
5. react-integration.js

### Menggunakan React Components

#### Metode 1: Data Attributes
```html
<div data-react-component="MaterialCard" 
     data-props='{"title":"Judul Card"}'>
  <p>Content card</p>
</div>
```

#### Metode 2: JavaScript
```javascript
// Check React loaded
if (window.HaliyoraReactUtils.isLoaded()) {
  console.log('React ready!');
}

// Re-initialize components
window.HaliyoraReactUtils.init();
```

## Available React Components

### 1. MaterialCard
```html
<div data-react-component="MaterialCard" 
     data-props='{"title":"My Card","className":"custom-class"}'>
  Content here
</div>
```

### 2. MaterialButton
```html
<div data-react-component="MaterialButton" 
     data-props='{"variant":"contained"}'>
  Button Text
</div>
```

### 3. DynamicContentLoader
```html
<div data-react-component="DynamicContentLoader" 
     data-props='{"endpoint":"/wp-json/wp/v2/posts"}'>
</div>
```

## Debugging

### Check React Status
```javascript
// Di Browser Console
window.HaliyoraReactUtils.checkStatus();
```

Output:
```json
{
  "loaded": true,
  "React": true,
  "ReactDOM": true,
  "components": 3
}
```

### Check Material Design Status
```javascript
// Di Browser Console
window.HaliyoraMaterialDesign.init();
```

### Re-initialize After Dynamic Content
```javascript
// Setelah load content via AJAX
document.dispatchEvent(new Event('contentUpdated'));
```

## WordPress Integration

### functions.php
Script loading order sudah dikonfigurasi dengan dependencies:
```php
wp_enqueue_script('haliyora-material-design-init');
wp_enqueue_script('haliyora-react-init', ..., ['react', 'react-dom']);
wp_enqueue_script('haliyora-react', ..., ['haliyora-react-init']);
```

### Theme Support
- Material Icons: Google Fonts CDN
- Roboto Font: Google Fonts CDN
- Font Awesome 6.4.0: CDN

## Performance

### Optimizations Applied
1. React production build dari CDN
2. Scripts loaded in footer (tidak blocking)
3. Defer loading untuk non-critical scripts
4. CSS animations dengan GPU acceleration
5. Event delegation untuk dynamic content

### Best Practices
- React components lazy mounted
- Material Design effects dengan CSS transforms
- Minimal reflows/repaints
- Efficient event listeners dengan flag checks

## Browser Compatibility

### Supported Browsers
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

### Fallbacks
- Material Icons font check & reload
- Roboto font check & reload
- React loading timeout (5 seconds)

## Tidak Ada Perubahan Layout

✅ Template layout tidak berubah
✅ Semua styling existing tetap terjaga
✅ Component styling inherit dari parent
✅ React mounting non-invasive
✅ Material Design effects optional per element

## Troubleshooting

### React Tidak Load
```javascript
// Check console logs
// Akan muncul pesan error setelah 5 detik
"React failed to load after 5 seconds"

// Manual reload
window.location.reload();
```

### Material Icons Tidak Muncul
Font akan auto-reload jika tidak terdeteksi. Check console:
```
"Material Icons font not loaded properly"
```

### Component Tidak Render
```javascript
// Check apakah ada React containers
document.querySelectorAll('[data-react-component]').length;

// Manual render
window.HaliyoraReactUtils.init();
```

## Console Messages

Saat berhasil, console akan menampilkan:
```
Initializing React...
✓ React loaded successfully
React version: 18.2.0
Found X React component(s) to mount
✓ React initialization complete
✓ Material Design initialized
```

## Support

Semua fitur sudah terintegrasi dan siap digunakan tanpa konfigurasi tambahan.
Layout dan styling template existing dijaga 100%.
