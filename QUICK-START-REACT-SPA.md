# React SPA - Quick Start Guide
## Aktivasi dalam 5 Menit

---

## 🎯 **Langkah 1: Aktifkan Home Page React SPA**

### **Via WordPress Admin:**

1. Login ke WordPress Admin
2. **Pages → Add New**
3. **Title:** "Home"
4. **Template:** Scroll down, pilih **"React SPA Home"**
5. **Publish**
6. Copy Page ID (akan terlihat di URL: `post.php?post=123`)

7. **Settings → Reading**
8. **"Your homepage displays"** → Select **"A static page"**
9. **Homepage:** Pilih page "Home" yang baru dibuat
10. **Save Changes**

### **Test:**
- Buka homepage website
- **Buka Browser Console (F12)**
- Harus muncul:
```
🚀 Initializing React SPA...
Page Type: home (React SPA Mode)
✓ React SPA initialized
```

---

## 🎯 **Langkah 2: Aktifkan Category React SPA**

### **Otomatis Aktif!**

File `category-react.php` sudah dibuat, jadi:
- **Semua category pages** otomatis menggunakan React SPA
- Tidak perlu konfigurasi tambahan

### **Test:**
1. Buka category apapun: `/category/teknologi`
2. **Buka Browser Console (F12)**
3. Harus muncul:
```
Page Type: category (React SPA Mode)
React SPA Route: {page: "category", params: {slug: "teknologi"}}
```

### **Disable (Opsional):**
Jika ingin disable, rename file:
```
category-react.php → category-react.php.disabled
```

---

## 🎯 **Langkah 3: Aktifkan Single Post React SPA**

### **Otomatis Aktif!**

File `single-react.php` sudah dibuat, jadi:
- **Semua single posts** otomatis menggunakan React SPA
- Tidak perlu konfigurasi tambahan

### **Test:**
1. Buka post apapun
2. **Buka Browser Console (F12)**
3. Harus muncul:
```
Page Type: single (React SPA Mode)
React SPA Route: {page: "single", params: {id: "123"}}
```

### **Disable (Opsional):**
Jika ingin disable, rename file:
```
single-react.php → single-react.php.disabled
```

---

## ✅ **Verifikasi Semua Aktif**

### **Check via Body Class:**

Buka browser console di page manapun (home/category/single):

```javascript
// Check if React SPA mode active
document.body.classList.contains('react-spa-mode');
// Output: true ✅
```

### **Check Page Type:**

```javascript
window.haliyoraPageType
// Output: 'home' atau 'category' atau 'single'
```

### **Check Router:**

```javascript
window.HaliyoraReactSPA.Router.currentRoute
// Output: {page: "home", params: {}}
```

---

## 🎨 **Tampilan**

React SPA menggunakan **layout dan styling yang sama** dengan template existing:

- ✅ Material Design
- ✅ Responsive
- ✅ Animations
- ✅ Typography
- ✅ Colors & spacing

**Tidak ada perubahan visual!** Hanya backend yang menggunakan React.

---

## 🔧 **Troubleshooting**

### **Problem: React SPA tidak load**

**Solution:**
1. Clear browser cache (Ctrl+Shift+Del)
2. Hard refresh (Ctrl+F5)
3. Check console untuk errors

### **Problem: Data tidak muncul**

**Solution:**
1. Test REST API: Buka `/wp-json/wp/v2/posts` di browser
2. Pastikan ada posts yang published
3. Check permissions

### **Problem: Layout broken**

**Solution:**
1. Pastikan file CSS loaded (check Network tab)
2. Verify Material Design initialized
3. Clear cache

---

## 📊 **Performance Check**

### **Loading Time:**

Ideal loading time dengan React SPA:
- **Home:** 500ms - 1s
- **Category:** 500ms - 1s  
- **Single:** 300ms - 800ms

### **Check Loading Performance:**

```javascript
// Di console, reload page dan check
performance.getEntriesByType('navigation')[0].loadEventEnd
// Output: ~1000 (milliseconds)
```

---

## 🎯 **Advanced: Custom Configuration**

### **Modify Posts Per Page:**

Edit `js/react-spa-core.js`, cari:

```javascript
API.fetchPosts({ per_page: 10 })
```

Ganti `10` dengan jumlah yang diinginkan.

### **Add Loading Text Custom:**

Edit template PHP (e.g., `page-react-spa-home.php`):

```html
<div style="text-align: center; padding: 60px 20px;">
    <span class="material-icons">refresh</span>
    <p>Loading berita terbaru...</p> <!-- Custom text -->
</div>
```

### **Custom Error Message:**

Edit `js/react-spa-core.js`, cari `ErrorDisplay` component:

```javascript
const ErrorDisplay = ({ error }) => {
    return h('div', { className: 'react-error' }, [
        h('h3', {}, 'Oops!'), // Custom message
        h('p', {}, error || 'Terjadi kesalahan, silakan refresh.')
    ]);
};
```

---

## 🚀 **Production Checklist**

Sebelum launch ke production:

- [ ] Test home page React SPA
- [ ] Test category pages React SPA
- [ ] Test single posts React SPA
- [ ] Check browser console untuk errors
- [ ] Test di mobile device
- [ ] Test di different browsers (Chrome, Firefox, Safari)
- [ ] Verify layout tidak broken
- [ ] Check loading performance
- [ ] Test REST API accessibility
- [ ] Clear all caches

---

## 📞 **Support**

### **Debug Commands:**

```javascript
// Check React loaded
typeof React !== 'undefined'

// Check SPA mode
document.body.classList.contains('react-spa-mode')

// Check router
window.HaliyoraReactSPA.Router.currentRoute

// Manual reinit
window.HaliyoraReactSPA.initReactSPA()

// Check API
window.HaliyoraReactSPA.API.fetchPosts().then(console.log)
```

### **Console Logs:**

React SPA provides detailed logs:
- 🚀 Initialization
- ✓ Success messages
- ⚠️ Warnings
- ❌ Errors

---

## ✅ **Summary**

**React SPA Mode Sudah Aktif Untuk:**

✅ **Home Page** - Set via Settings → Reading
✅ **Category Pages** - Otomatis aktif (file `category-react.php`)
✅ **Single Posts** - Otomatis aktif (file `single-react.php`)

**Tidak perlu coding tambahan!** Semuanya sudah siap pakai.

**Cara cepat verifikasi:**
1. Buka page manapun (home/category/single)
2. Buka Browser Console (F12)
3. Cari log: `🚀 Initializing React SPA...`
4. Jika ada = **SUKSES!** ✅

---

**Selamat! Template Haliyora sekarang menggunakan React SPA untuk home, category, dan single pages.** 🎉
