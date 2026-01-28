# Haliyora Theme - Template Berita

Template WordPress untuk website berita dengan Material Design dan React JS.

## Fitur

### Layout
- **Lebar Website**: 1100px
- **Top Header**: Tanggal di kiri, menu "Tentang Kami" dan "Redaksi" di kanan
- **Header**: Logo di kiri, search form di kanan, navigation menu di bawah (bisa digeser)
- **Main Content**: 
  - Headline section (mirip detikcom) dengan featured image besar
  - Berita terbaru section (mirip kumparan) dengan grid layout
- **Sidebar**: Sticky di kanan dengan widget areas
- **Footer**: Logo dan informasi di kiri, sosial media di kanan

### Widget Areas
1. **Trend 7 Berita** - Untuk menampilkan 7 berita trending (gunakan widget Recent Posts)
2. **Berita Kategori Featured** - Untuk menampilkan berita berdasarkan kategori dengan featured image besar dan list
3. **Iklan Header** - Widget area untuk iklan di header
4. **Iklan Sidebar** - Widget area untuk iklan di sidebar

### Pengaturan di Customizer
1. **Top Header**
   - URL Tentang Kami
   - URL Redaksi

2. **SEO & Sitemap**
   - Google News ID
   - Enable/Disable Sitemap (akses di: `yoursite.com/sitemap.xml`)

3. **Footer**
   - Footer Information (teks tentang situs)
   - Facebook URL
   - Twitter URL
   - Instagram URL
   - YouTube URL

4. **Logo**
   - Upload logo melalui Appearance > Customize > Site Identity

### Teknologi
- **Material Design** - Google Material Design principles
- **React JS** - React 18 untuk komponen interaktif
- **Material Icons** - Icon set dari Google Material Icons

## Cara Menggunakan

### 1. Setup Widget
- Masuk ke **Appearance > Widgets**
- Drag widget **Recent Posts** ke area **Trend 7 Berita**
- Set jumlah posts menjadi 7
- Drag widget **Recent Posts** ke area **Berita Kategori Featured**
- Atur kategori dan jumlah posts sesuai kebutuhan

### 2. Setup Menu
- Masuk ke **Appearance > Menus**
- Buat menu baru atau edit menu yang ada
- Assign menu ke lokasi **Primary** (menu utama)

### 3. Setup Customizer
- Masuk ke **Appearance > Customize**
- Atur semua pengaturan sesuai kebutuhan:
  - Top Header URLs
  - SEO Google News ID
  - Enable Sitemap
  - Footer Information
  - Social Media URLs

### 4. Upload Logo
- Masuk ke **Appearance > Customize > Site Identity**
- Upload logo Anda
- Logo akan muncul di header dan footer

## Struktur File

```
haliyora/
├── header.php          # Header dengan top header, logo, search, nav
├── footer.php          # Footer dengan logo, info, sosial media
├── index.php           # Template utama dengan headline dan berita terbaru
├── sidebar.php         # Sidebar dengan widget areas
├── functions.php       # Functions dan enqueue scripts
├── style.css           # CSS dengan Material Design
├── inc/
│   └── customizer.php  # Customizer settings
└── js/
    ├── navigation.js   # Navigation menu script
    └── react-components.js  # React components
```

## Catatan

- Pastikan semua post memiliki **Featured Image** untuk tampilan yang optimal
- Widget **Recent Posts** dapat dikonfigurasi untuk menampilkan posts berdasarkan kategori
- Sitemap akan aktif setelah di-enable di Customizer dan perlu flush permalink (Settings > Permalinks > Save Changes)

## Support

Theme ini menggunakan:
- WordPress 5.4+
- PHP 5.6+
- React 18
- Material Design Icons
