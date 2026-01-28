# React SPA Implementation Guide
## Home, Category, dan Single Page dengan React JS

---

## 🎯 **Overview**

Template Haliyora sekarang memiliki **React SPA (Single Page Application)** mode yang memungkinkan home, category, dan single page dijalankan sepenuhnya dengan React JS tanpa mengubah layout template existing.

---

## 📦 **File Structure**

### **JavaScript**
- `js/react-spa-core.js` - Core React SPA application (420 baris)
  - Router system
  - API utilities  
  - State management
  - Components (HomePage, CategoryPage, SinglePage)

### **PHP Templates**
- `page-react-spa-home.php` - React SPA home page template
- `category-react.php` - React SPA category template  
- `single-react.php` - React SPA single post template

### **Functions**
- `functions.php` - Added React SPA detection dan body class

---

## 🚀 **Cara Mengaktifkan React SPA**

### **1. Untuk Home Page**

**Buat Page baru:**
1. Login ke WordPress Admin
2. Pages → Add New
3. Judul: "Home React SPA" (atau apapun)
4. **Template:** Pilih "React SPA Home"
5. Publish

**Set as Homepage:**
1. Settings → Reading
2. "Your homepage displays" → pilih "A static page"
3. Homepage: Pilih page yang baru dibuat
4. Save Changes

### **2. Untuk Category Page**

Category akan otomatis menggunakan React SPA jika file `category-react.php` ada.

**Cara mengaktifkan:**
- File `category-react.php` sudah dibuat
- Semua category pages akan otomatis menggunakan React SPA

**Untuk disable pada category tertentu:**
- Rename `category-react.php` menjadi `category-react.php.disabled`

### **3. Untuk Single Post**

Single posts akan otomatis menggunakan React SPA jika file `single-react.php` ada.

**Cara mengaktifkan:**
- File `single-react.php` sudah dibuat
- Semua single posts akan otomatis menggunakan React SPA

**Untuk disable:**
- Rename `single-react.php` menjadi `single-react.php.disabled`

---

## 🔧 **Arsitektur React SPA**

### **Router System**

Router otomatis mendeteksi page type dari URL:

```javascript
// Home page
window.location.pathname = '/' 
→ { page: 'home', params: {} }

// Category
window.location.pathname = '/category/teknologi'
→ { page: 'category', params: { slug: 'teknologi' } }

// Single post
window.location.pathname = '/2024/01/15/judul-post'
→ { page: 'single', params: { path: '/2024/01/15/judul-post' } }
```

### **API Utilities**

React SPA menggunakan WordPress REST API:

```javascript
// Fetch posts
API.fetchPosts({ per_page: 10 })

// Fetch single post
API.fetchPost(postId)

// Fetch categories
API.fetchCategories()

// Fetch category posts
API.fetchCategoryPosts(categoryId, { per_page: 10 })
```

### **Components**

**HomePage Component:**
```javascript
- Fetches latest posts
- Displays in berita-terbaru layout
- Uses existing CSS classes
```

**CategoryPage Component:**
```javascript
- Fetches category info
- Fetches posts by category
- Displays category title & description
- Uses existing CSS classes
```

**SinglePage Component:**
```javascript
- Fetches single post data
- Displays full post content
- Featured image
- Post meta (date, category)
- Uses existing CSS classes
```

---

## 🎨 **Styling & Layout**

✅ **Layout TIDAK berubah** - React SPA menggunakan CSS classes yang sama dengan template existing:

```html
<!-- React generates same HTML structure -->
<article class="berita-terbaru-item">
  <div class="berita-terbaru-thumbnail">
    <img class="berita-terbaru-image">
  </div>
  <div class="berita-terbaru-content">
    <h3 class="berita-terbaru-title"></h3>
    <div class="berita-terbaru-date"></div>
  </div>
</article>
```

Semua styling dari `style.css` tetap bekerja karena class names sama persis.

---

## 🔍 **Debugging**

### **Check if React SPA is Active**

```javascript
// Di Browser Console
console.log(document.body.classList.contains('react-spa-mode')); 
// true = React SPA aktif

console.log(window.haliyoraPageType);
// Output: 'home', 'category', atau 'single'

console.log(window.HaliyoraReactSPA);
// Object with Router, API, methods
```

### **Router Status**

```javascript
window.HaliyoraReactSPA.Router.currentRoute
// Output: { page: 'home', params: {} }
```

### **Manual Re-init**

```javascript
window.HaliyoraReactSPA.initReactSPA();
```

---

## 📊 **Performance**

### **Loading Flow:**

1. **Initial Load** (Server-side)
   - PHP renders template dengan `<div id="react-spa-root">`
   - Loading placeholder ditampilkan

2. **React Initialization** (Client-side)
   - React SPA core loads
   - Router detects page type
   - API fetches data

3. **Render** (React)
   - Component mounts
   - Content rendered
   - Fade-in animation

**Total Time:** ~500ms - 1s (tergantung koneksi & data size)

### **Caching:**

React SPA menggunakan browser cache untuk:
- React library (from CDN)
- WordPress REST API responses (browser HTTP cache)

---

## 🎯 **Fitur React SPA**

### ✅ **Yang Bekerja:**

- ✅ Fetch posts dari WordPress REST API
- ✅ Display posts dengan layout existing
- ✅ Category filtering
- ✅ Single post display dengan full content
- ✅ Featured images
- ✅ Post meta (date, category)
- ✅ Loading states
- ✅ Error handling
- ✅ Fade animations
- ✅ Material Design integration
- ✅ Responsive (mengikuti CSS existing)

### 🔄 **Belum Implementasi (Bisa Ditambahkan):**

- Pagination (infinite scroll)
- Comments section
- Related posts
- Search functionality  
- Client-side routing (SPA navigation tanpa reload)
- State persistence (localStorage)

---

## 🛠️ **Customization**

### **Menambah Component Baru**

Edit `js/react-spa-core.js`:

```javascript
// Add new component
const MyCustomComponent = ({ data }) => {
    return h('div', { className: 'my-component' }, [
        h('h2', {}, 'Custom Component'),
        // ... your content
    ]);
};

// Use in App component
const App = () => {
    // ... 
    case 'custom':
        return h(MyCustomComponent, { data });
};
```

### **Modify API Endpoints**

```javascript
const API = {
    baseUrl: window.location.origin + '/wp-json/wp/v2',
    
    // Add custom endpoint
    async fetchCustomData() {
        const response = await fetch(`${this.baseUrl}/custom-endpoint`);
        return await response.json();
    }
};
```

### **Custom Styling**

React SPA menggunakan inline styles + existing CSS classes.

**Tambah CSS custom:**

```css
/* In style.css or template */
.react-spa-mode .custom-class {
    /* Your styles */
}

.react-home-page {
    /* Home page specific styles */
}

.react-category-page {
    /* Category page specific styles */
}

.react-single-page {
    /* Single page specific styles */
}
```

---

## 🐛 **Troubleshooting**

### **React SPA tidak load**

1. Check console untuk errors
2. Pastikan `#react-spa-root` element ada di template
3. Verify React loaded: `typeof React !== 'undefined'`
4. Check network tab untuk API calls

### **Data tidak muncul**

1. Test REST API directly: `/wp-json/wp/v2/posts`
2. Check API.fetchPosts() di console
3. Verify permissions (posts harus published)

### **Layout broken**

1. Pastikan CSS classes sama dengan template existing
2. Check browser compatibility
3. Clear browser cache

### **Page tidak detected sebagai React SPA**

1. Check body class: `document.body.classList.contains('react-spa-mode')`
2. Verify template file names correct
3. Clear WordPress cache

---

## 📝 **Console Messages**

Saat React SPA aktif, console akan show:

```
🚀 Initializing React SPA...
Page Type: home (React SPA Mode)
React SPA Route: {page: "home", params: {…}}
✓ React SPA initialized
```

---

## 🔐 **Security**

React SPA menggunakan WordPress REST API yang sudah built-in security:

- ✅ CORS protection
- ✅ Nonce verification (untuk authenticated requests)
- ✅ Sanitized output
- ✅ XSS protection (React escape by default)

---

## 🌐 **Browser Support**

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

Requires:
- ES6+ support
- Fetch API
- Promise

---

## 📚 **Resources**

### **Files to Reference:**

1. `js/react-spa-core.js` - Main SPA logic
2. `page-react-spa-home.php` - Home template
3. `category-react.php` - Category template
4. `single-react.php` - Single template
5. `functions.php` - PHP helpers

### **WordPress REST API Docs:**

- Posts: `/wp-json/wp/v2/posts`
- Categories: `/wp-json/wp/v2/categories`
- Single: `/wp-json/wp/v2/posts/{id}`

---

## ✅ **Kesimpulan**

React SPA mode sudah **siap digunakan** untuk home, category, dan single pages dengan:

✅ Layout template tidak berubah
✅ CSS existing tetap bekerja
✅ Material Design terintegrasi
✅ WordPress REST API
✅ Error handling
✅ Loading states
✅ Responsive design

**Tinggal aktifkan template yang diinginkan!**
