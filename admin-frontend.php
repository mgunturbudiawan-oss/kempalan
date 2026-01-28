<?php
/**
 * Frontend Admin Page Handler
 * Handle admin functionality when accessed via URL parameter
 */

// Get the query variables
$admin_frontend_page = get_query_var('admin_frontend_page');
$action = get_query_var('f_action') ? get_query_var('f_action') : 'list';
$post_id = get_query_var('f_post_id') ? intval(get_query_var('f_post_id')) : 0;
$paged = max(1, get_query_var('paged', 1));

// For POST requests, check if this is a form submission for admin frontend
$is_form_submission = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_post');

// Cek apakah ini permintaan untuk halaman admin frontend
if ((!$admin_frontend_page || $admin_frontend_page != '1') && !$is_form_submission) {
    // Ini bukan halaman admin frontend, keluar
    return;
}

// Handle delete action
if ($action === 'delete' && $post_id > 0) {
    if (current_user_can('delete_post', $post_id)) {
        wp_delete_post($post_id);
        wp_redirect(home_url('/?admin_frontend_page=1'));
        exit;
    } else {
        wp_die('Anda tidak memiliki izin untuk menghapus berita ini.');
    }
}

// Periksa izin akses
if (!is_user_logged_in() || !current_user_can('edit_others_posts')) {
    if (!is_user_logged_in()) {
        wp_redirect(wp_login_url(home_url('/?admin_frontend_page=1')));
        exit;
    } else {
        wp_die('Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}

// Enqueue WordPress Media Library
if ($action === 'edit') {
    wp_enqueue_media();
}

// Tangani penyimpanan berita jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_post') {
    // Debug logging
    error_log('Form submission detected');
    error_log('POST data: ' . print_r($_POST, true));
    error_log('Current user ID: ' . get_current_user_id());
    error_log('User can edit others posts: ' . (current_user_can('edit_others_posts') ? 'Yes' : 'No'));
    
    if (!wp_verify_nonce($_POST['_wpnonce'], 'save_post_' . intval($_POST['post_id']))) {
        error_log('Nonce verification failed');
        wp_die('Security check failed');
    }
    
    if (!current_user_can('edit_others_posts')) {
        error_log('User cannot edit others posts');
        wp_die('Anda tidak memiliki izin untuk melakukan tindakan ini.');
    }
    
    $post_id = intval($_POST['post_id']);
    $post_title = sanitize_text_field($_POST['post_title']);
    $post_content = wp_kses_post($_POST['post_content']);
    $post_status = sanitize_key($_POST['post_status']);
    $post_date = sanitize_text_field($_POST['post_date']);
    $post_category = isset($_POST['post_category']) ? array_map('intval', $_POST['post_category']) : array();
    $post_tags = sanitize_text_field($_POST['post_tags']);
    $featured_image_id = isset($_POST['featured_image_id']) ? intval($_POST['featured_image_id']) : 0;
    
    $post_data = array(
        'post_title' => $post_title,
        'post_content' => $post_content,
        'post_status' => $post_status,
        'post_date' => $post_date,
        'post_type' => 'post'
    );
    
    if ($post_id > 0) {
        $post_data['ID'] = $post_id;
        $result = wp_update_post($post_data);
    } else {
        $result = wp_insert_post($post_data);
    }
    
    if (!is_wp_error($result)) {
        // Set featured image if uploaded
        if ($featured_image_id && !is_wp_error($featured_image_id)) {
            set_post_thumbnail($result, $featured_image_id);
        }
        
        // Update kategori
        if (!empty($post_category)) {
            wp_set_post_categories($result, $post_category);
        }
        
        // Update tag
        if (!empty($post_tags)) {
            $tags = explode(',', $post_tags);
            $tags = array_map('trim', $tags);
            wp_set_post_tags($result, $tags);
        }
        
        // Redirect kembali ke halaman list
        wp_redirect(home_url('/?admin_frontend_page=1'));
        exit;
    }
}

// Mulai output buffer untuk menangkap konten admin
ob_start();

// Jika action edit atau view dan post_id tidak valid (kecuali untuk new post)
if (($action === 'edit' || $action === 'view') && $post_id > 0 && !get_post($post_id)) {
    $action = 'list';
}

// For new post creation, ensure action is 'edit' when post_id is 0
if ($action === 'edit' && $post_id === 0) {
    // This is valid for new post creation
}

?>

<style>
.admin-page-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
    font-family: var(--font-sans);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { transform: translateX(-20px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

.admin-page-container {
    animation: fadeIn 0.3s ease-out;
}

.post-list-item {
    animation: slideIn 0.2s ease-out;
    animation-fill-mode: backwards;
}

.post-list-item:nth-child(1) { animation-delay: 0.1s; }
.post-list-item:nth-child(2) { animation-delay: 0.2s; }
.post-list-item:nth-child(3) { animation-delay: 0.3s; }
.post-list-item:nth-child(4) { animation-delay: 0.4s; }
.post-list-item:nth-child(5) { animation-delay: 0.5s; }

/* Ensure admin page integrates with site styling */
.admin-page-container {
    background: hsl(var(--card));
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    border: 1px solid hsl(var(--border));
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 20px;
    border-bottom: 1px solid hsl(var(--border));
    background: hsl(var(--muted));
    border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    margin: -20px -20px 30px -20px;
}

.admin-title {
    font-size: var(--font-size-2xl);
    font-weight: 700;
    color: hsl(var(--foreground));
    margin: 0;
}

.admin-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.shadcn-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-md);
    font-size: var(--font-size-sm);
    font-weight: 500;
    transition: all 0.2s;
    cursor: pointer;
    border: 1px solid transparent;
    padding: 8px 16px;
    text-decoration: none;
}

.shadcn-btn-primary {
    background-color: hsl(var(--primary));
    color: hsl(var(--primary-foreground));
    border-color: hsl(var(--primary));
}

.shadcn-btn-primary:hover {
    background-color: hsl(var(--primary) / 0.9);
}

.shadcn-btn-outline {
    background-color: transparent;
    color: hsl(var(--foreground));
    border-color: hsl(var(--border));
}

.shadcn-btn-outline:hover {
    background-color: hsl(var(--accent));
    color: hsl(var(--accent-foreground));
}

.shadcn-btn-danger {
    background-color: transparent;
    color: #ef4444;
    border-color: #fecaca;
}

.shadcn-btn-danger:hover {
    background-color: #fef2f2;
    border-color: #ef4444;
}

.admin-info-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding: 0 5px;
}

.total-articles {
    font-size: var(--font-size-sm);
    color: hsl(var(--muted-foreground));
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 30px;
    padding: 20px 0;
}

.pagination-item {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 8px;
    border-radius: var(--radius-md);
    border: 1px solid hsl(var(--border));
    background: hsl(var(--background));
    color: hsl(var(--foreground));
    text-decoration: none;
    font-size: var(--font-size-sm);
    transition: all 0.2s;
}

.pagination-item:hover {
    background: hsl(var(--accent));
    border-color: hsl(var(--accent-foreground));
}

.pagination-item.active {
    background: hsl(var(--primary));
    color: hsl(var(--primary-foreground));
    border-color: hsl(var(--primary));
}

.pagination-item.disabled {
    opacity: 0.5;
    pointer-events: none;
}

.featured-image-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.media-preview-box {
    width: 200px;
    height: 150px;
    border: 2px dashed hsl(var(--border));
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: hsl(var(--muted) / 0.3);
}

.media-preview-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.media-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    color: hsl(var(--muted-foreground));
}

.media-placeholder i {
    font-size: 24px;
}

/* Editor custom styles */
.rich-text-content .wp-pagebreak {
    display: block;
    margin: 20px 0;
    padding: 10px;
    background: #f0f9ff;
    border: 1px dashed #0ea5e9;
    color: #0ea5e9;
    text-align: center;
    font-size: 12px;
    font-weight: bold;
    user-select: none;
    pointer-events: none;
}

.rich-text-content .wp-pagebreak::before {
    content: "--- HALAMAN BARU (PAGE BREAK) ---";
}

.rich-text-content img {
    max-width: 100%;
    height: auto;
    border-radius: var(--radius-md);
    margin: 10px 0;
}

.rich-text-content .youtube-embed-placeholder {
    display: block;
    background: #fef2f2;
    border: 1px dashed #ef4444;
    color: #ef4444;
    padding: 20px;
    text-align: center;
    margin: 10px 0;
}

.rich-text-content .youtube-embed-placeholder i {
    font-size: 24px;
    margin-bottom: 5px;
}

.shadcn-btn i {
    margin-right: 8px;
}

.post-list {
    background: hsl(var(--background));
    border: 1px solid hsl(var(--border));
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

.post-list-header {
    display: grid;
    grid-template-columns: 60px 2fr 100px 150px 120px;
    padding: 16px 20px;
    background: hsl(var(--muted));
    font-weight: 600;
    border-bottom: 2px solid hsl(var(--border));
    color: hsl(var(--foreground));
    font-size: var(--font-size-sm);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.post-list-item {
    display: grid;
    grid-template-columns: 60px 2fr 100px 150px 120px;
    padding: 16px 20px;
    border-bottom: 1px solid hsl(var(--border) / 0.5);
    align-items: center;
    transition: all 0.2s;
}

.post-list-item:hover {
    background-color: hsl(var(--muted) / 0.7);
    transform: translateY(-1px);
    box-shadow: 0 2px 4px hsl(var(--shadow) / 0.1);
}

.post-list-item:last-child {
    border-bottom: none;
}

.post-status {
    display: inline-flex;
    align-items: center;
    padding: 4px 8px;
    border-radius: 9999px;
    font-size: var(--font-size-xs);
    font-weight: 500;
}

.status-draft {
    background: hsl(45, 100%, 90%);
    color: hsl(45, 85%, 40%);
}

.status-published {
    background: hsl(142, 76%, 88%);
    color: hsl(142, 76%, 20%);
}

.post-actions {
    display: flex;
    gap: 8px;
}

.editor-form {
    background: hsl(var(--background));
    border: 1px solid hsl(var(--border));
    border-radius: var(--radius);
    padding: 25px;
    box-shadow: var(--shadow);
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: hsl(var(--foreground));
    font-size: var(--font-size-base);
}

.form-input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid hsl(var(--border));
    background: hsl(var(--input));
    border-radius: var(--radius);
    font-size: var(--font-size-base);
    transition: border-color 0.2s;
    color: hsl(var(--foreground));
}

.form-input:focus {
    outline: none;
    border-color: hsl(var(--ring));
    box-shadow: 0 0 0 1px hsl(var(--ring));
}

.form-textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid hsl(var(--border));
    background: hsl(var(--input));
    border-radius: var(--radius);
    font-size: var(--font-size-base);
    min-height: 200px;
    transition: border-color 0.2s;
    font-family: inherit;
    color: hsl(var(--foreground));
}

.form-textarea:focus {
    outline: none;
    border-color: hsl(var(--ring));
    box-shadow: 0 0 0 1px hsl(var(--ring));
}

.categories-tags {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.publish-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.rich-text-editor {
    border: 1px solid hsl(var(--border));
    border-radius: var(--radius);
    overflow: hidden;
}

.rich-text-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 2px;
    padding: 8px 12px;
    background: hsl(var(--muted));
    border-bottom: 1px solid hsl(var(--border));
}

.rich-text-button {
    padding: 4px 8px;
    border: none;
    background: transparent;
    cursor: pointer;
    border-radius: 4px;
    font-size: var(--font-size-sm);
    transition: background-color 0.2s;
}

.rich-text-button:hover {
    background: hsl(var(--accent));
}

.rich-text-content {
    min-height: 400px;
    padding: 20px;
    background: hsl(var(--background));
    outline: none;
    font-family: inherit;
    font-size: var(--font-size-base);
    color: hsl(var(--foreground));
    line-height: 1.6;
    overflow-y: auto;
}

.rich-text-content p {
    margin-bottom: 1em;
}

.rich-text-content:empty:before {
    content: attr(placeholder);
    color: hsl(var(--muted-foreground));
    font-style: italic;
}

.shadcn-separator {
    display: inline-block;
    width: 1px;
    height: 20px;
    background: hsl(var(--border));
    margin: 0 4px;
    vertical-align: middle;
}

@media (max-width: 768px) {
    .admin-page-container {
        padding: 12px;
        margin: 0;
        border-radius: 0;
        border: none;
        box-shadow: none;
    }
    
    .admin-header {
        margin: -12px -12px 20px -12px;
        padding: 20px 15px;
        border-radius: 0;
    }

    .admin-title {
        font-size: 20px;
    }
    
    .post-list {
        border: none;
        box-shadow: none;
        background: transparent;
    }

    .post-list-item {
        grid-template-columns: 1fr !important;
        grid-template-areas: 
            "title"
            "meta"
            "actions";
        gap: 12px;
        padding: 16px;
        margin-bottom: 12px;
        background: hsl(var(--background));
        border: 1px solid hsl(var(--border));
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .post-list-item > div:nth-child(2) { /* Title */
        grid-area: title;
        font-size: 15px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .post-id-col, .post-status-col, .post-date-col {
        display: none !important;
    }

    /* Add a meta info container for mobile */
    .post-list-item::after {
        content: attr(data-status) " • " attr(data-date);
        grid-area: meta;
        font-size: 12px;
        color: hsl(var(--muted-foreground));
    }

    .post-list-item .post-actions {
        grid-area: actions;
        justify-content: flex-end;
        border-top: 1px solid hsl(var(--border) / 0.5);
        padding-top: 12px;
        margin-top: 4px;
        width: 100%;
    }

    .post-list-item .shadcn-btn {
        padding: 8px 16px;
        flex: 1;
    }

    .mobile-only-label {
        display: inline !important;
        margin-left: 8px;
    }
    
    .categories-tags, .publish-options {
        grid-template-columns: 1fr;
        gap: 0;
    }
    
    .rich-text-toolbar {
        position: sticky;
        top: 0;
        z-index: 10;
        overflow-x: auto;
        white-space: nowrap;
        justify-content: flex-start;
        padding: 10px;
        -webkit-overflow-scrolling: touch;
        background: hsl(var(--muted));
        border-radius: 8px 8px 0 0;
    }

    .rich-text-toolbar::-webkit-scrollbar {
        display: none;
    }
    
    .rich-text-button {
        padding: 8px 12px;
        flex: 0 0 auto;
    }
    
    .form-input, .form-textarea {
        font-size: 16px; /* Prevent zoom on iOS */
        padding: 12px;
    }

    .media-preview-box {
        width: 100%;
        height: 200px;
    }

    .pagination {
        flex-wrap: wrap;
        gap: 6px;
    }

    .pagination-item {
        min-width: 40px;
        height: 40px;
    }
}
</style>

<script>
// Sync contenteditable div with hidden input
function syncEditorContent() {
    const editorDiv = document.getElementById('post_content_editor');
    const hiddenInput = document.getElementById('post_content_hidden');
    
    if (editorDiv && hiddenInput) {
        // Update hidden input when content changes
        editorDiv.addEventListener('input', function() {
            preSaveCleanup();
        });
        
        // Before form submit, ensure the hidden input has the latest content
        const form = editorDiv.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                preSaveCleanup();
            });
        }
    }
}

// Initialize the editor sync
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        syncEditorContent();
        
        // Add form submit handler
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                handleFormSubmit(this);
            });
        });
    });
} else {
    syncEditorContent();
    
    // Add form submit handler
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            handleFormSubmit(this);
        });
    });
}

// Rich text editor functions
function execCommand(command) {
    document.execCommand(command, false, null);
    return false;
}

// Form submission handling
function handleFormSubmit(form) {
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    submitBtn.disabled = true;
    
    // Re-enable button after 5 seconds as fallback
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
    
    return true;
}

// WordPress Media Library Integration
function initMediaLibrary() {
    const selectBtn = document.getElementById('select_media_btn');
    const removeBtn = document.getElementById('remove_media_btn');
    const hiddenInput = document.getElementById('featured_image_id');
    const previewBox = document.getElementById('media_preview_box');
    const editorDiv = document.getElementById('post_content_editor');
    
    if (selectBtn && hiddenInput && previewBox) {
        let mediaUploader;
        
        selectBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: 'Pilih Featured Image',
                button: { text: 'Gunakan Gambar Ini' },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                hiddenInput.value = attachment.id;
                previewBox.innerHTML = `<img src="${attachment.url}" alt="Preview">`;
                if (removeBtn) removeBtn.style.display = 'inline-flex';
            });
            
            mediaUploader.open();
        });
        
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                hiddenInput.value = '0';
                previewBox.innerHTML = `
                    <div class="media-placeholder">
                        <i class="fas fa-image"></i>
                        <span>Belum ada gambar</span>
                    </div>`;
                this.style.display = 'none';
            });
        }
    }
}

// Editor Custom Functions
function insertPageBreak() {
    const editor = document.getElementById('post_content_editor');
    if (!editor) return;
    
    // Insert a div that will be converted to <!--nextpage--> on save
    const pageBreak = document.createElement('div');
    pageBreak.className = 'wp-pagebreak';
    pageBreak.contentEditable = false;
    
    insertAtCursor(pageBreak);
}

function insertImageToEditor() {
    const mediaUploader = wp.media({
        title: 'Sisipkan Gambar ke Konten',
        button: { text: 'Sisipkan ke Artikel' },
        multiple: true
    });
    
    mediaUploader.on('select', function() {
        const selections = mediaUploader.state().get('selection');
        selections.map(function(attachment) {
            attachment = attachment.toJSON();
            const img = document.createElement('img');
            img.src = attachment.url;
            img.alt = attachment.alt || '';
            img.className = 'article-image';
            insertAtCursor(img);
        });
    });
    
    mediaUploader.open();
}

function insertYoutube() {
    const url = prompt('Masukkan URL Video YouTube:');
    if (!url) return;
    
    // Simple regex to check if it's a youtube url
    if (!url.includes('youtube.com') && !url.includes('youtu.be')) {
        alert('URL YouTube tidak valid.');
        return;
    }
    
    const wrapper = document.createElement('div');
    wrapper.className = 'youtube-embed-placeholder';
    wrapper.contentEditable = false;
    wrapper.innerHTML = `
        <i class="fab fa-youtube"></i><br>
        <strong>Video YouTube:</strong><br>
        <span>${url}</span>
    `;
    
    insertAtCursor(wrapper);
    // Add a new line after
    const br = document.createElement('br');
    insertAtCursor(br);
}

function insertAtCursor(elem) {
    const selection = window.getSelection();
    if (!selection.rangeCount) return;
    
    const range = selection.getRangeAt(0);
    range.deleteContents();
    range.insertNode(elem);
    
    // Move cursor after the inserted element
    range.setStartAfter(elem);
    range.setEndAfter(elem);
    selection.removeAllRanges();
    selection.addRange(range);
    
    // Trigger input event to sync content
    document.getElementById('post_content_editor').dispatchEvent(new Event('input'));
}

// Pre-save cleaning: convert visual placeholders to WP tags
function preSaveCleanup() {
    const editor = document.getElementById('post_content_editor');
    const hiddenInput = document.getElementById('post_content_hidden');
    if (!editor || !hiddenInput) return;
    
    let html = editor.innerHTML;
    
    // Convert Visual Page Breaks to WP Tag
    html = html.replace(/<div class="wp-pagebreak" contenteditable="false"><\/div>/g, '<!--nextpage-->');
    html = html.replace(/<div class="wp-pagebreak"><\/div>/g, '<!--nextpage-->');
    
    // Convert Youtube Placeholders to plain URL (WP auto-embeds)
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = html;
    const youtubePlaceholders = tempDiv.querySelectorAll('.youtube-embed-placeholder');
    youtubePlaceholders.forEach(placeholder => {
        const urlSpan = placeholder.querySelector('span');
        if (urlSpan) {
            const url = urlSpan.innerText;
            const p = document.createElement('p');
            p.innerText = url;
            placeholder.parentNode.replaceChild(p, placeholder);
        }
    });
    
    hiddenInput.value = tempDiv.innerHTML;
}

// Post-load initialization: convert WP tags to visual placeholders
function postLoadInit() {
    const editor = document.getElementById('post_content_editor');
    if (!editor) return;
    
    let html = editor.innerHTML;
    
    // Convert <!--nextpage--> to visual div
    html = html.replace(/<!--nextpage-->/g, '<div class="wp-pagebreak" contenteditable="false"></div>');
    
    // Note: YouTube URLs on their own lines are already just text, 
    // we don't necessarily need to convert them to placeholders on load 
    // unless we want a specific UI. For now, leaving them as is.
    
    editor.innerHTML = html;
}

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', function() {
    postLoadInit();
    syncEditorContent();
    initMediaLibrary();
    
    // Deletion confirmation
    const deleteButtons = document.querySelectorAll('.shadcn-btn-danger');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.')) {
                e.preventDefault();
            }
        });
    });
    
    // Form handlers
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            handleFormSubmit(this);
        });
    });
});
</script>

<div class="admin-page-container">
    <div class="admin-header">
        <h1 class="admin-title">Manajemen Berita</h1>
        <div class="admin-actions">
            <?php if ($action === 'list'): ?>
                <a href="?admin_frontend_page=1&f_action=edit" class="shadcn-btn shadcn-btn-primary">
                    <i class="fas fa-plus"></i> Tambah Berita
                </a>
            <?php else: ?>
                <a href="?admin_frontend_page=1" class="shadcn-btn shadcn-btn-outline">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            <?php endif; ?>
            <a href="<?php echo wp_logout_url(home_url('/')); ?>" class="shadcn-btn shadcn-btn-outline">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <?php if ($action === 'list'): ?>
        <?php
        $args = array(
            'post_type' => 'post',
            'post_status' => array('publish', 'draft'),
            'posts_per_page' => 20,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => true
        );
        $posts_query = new WP_Query($args);
        $total_posts = $posts_query->found_posts;
        ?>

        <div class="admin-info-bar">
            <div class="total-articles">
                <strong>Total:</strong> <?php echo $total_posts; ?> Artikel
            </div>
            <div class="current-page">
                Halaman <?php echo $paged; ?> dari <?php echo $posts_query->max_num_pages; ?>
            </div>
        </div>

        <!-- Daftar Berita -->
        <div class="post-list">
            <div class="post-list-header">
                <div>ID</div>
                <div>Judul</div>
                <div>Status</div>
                <div>Diterbitkan</div>
                <div>Aksi</div>
            </div>
            
            <?php
            if ($posts_query->have_posts()):
                while ($posts_query->have_posts()): $posts_query->the_post();
            ?>
                <div class="post-list-item" 
                     data-status="<?php echo ucfirst(get_post_status()); ?>" 
                     data-date="<?php echo get_the_date('d M Y'); ?>">
                    <div class="post-id-col"><?php echo get_the_ID(); ?></div>
                    <div class="post-title-col"><?php echo get_the_title() ? get_the_title() : '(Tanpa Judul)'; ?></div>
                    <div class="post-status-col">
                        <span class="post-status status-<?php echo get_post_status(); ?>">
                            <?php echo ucfirst(get_post_status()); ?>
                        </span>
                    </div>
                    <div class="post-date-col"><?php echo haliyora_format_date(); ?></div>
                    <div class="post-actions">
                        <a href="?admin_frontend_page=1&f_action=edit&f_post_id=<?php echo get_the_ID(); ?>" class="shadcn-btn shadcn-btn-outline" title="Edit">
                            <i class="fas fa-edit" style="margin: 0;"></i> <span class="mobile-only-label" style="display:none;">Edit</span>
                        </a>
                        <a href="?admin_frontend_page=1&f_action=delete&f_post_id=<?php echo get_the_ID(); ?>" class="shadcn-btn shadcn-btn-danger" title="Hapus">
                            <i class="fas fa-trash-alt" style="margin: 0;"></i> <span class="mobile-only-label" style="display:none;">Hapus</span>
                        </a>
                    </div>
                </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            else:
            ?>
                <div class="post-list-item" style="grid-template-columns: 1fr; text-align: center; padding: 40px;">
                    <div>Tidak ada berita ditemukan</div>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($posts_query->max_num_pages > 1): ?>
            <div class="pagination">
                <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(add_query_arg('paged', $big))),
                    'format' => '?paged=%#%',
                    'current' => $paged,
                    'total' => $posts_query->max_num_pages,
                    'prev_text' => '<i class="fas fa-chevron-left"></i>',
                    'next_text' => '<i class="fas fa-chevron-right"></i>',
                    'type' => 'plain',
                    'add_args' => array('admin_frontend_page' => 1),
                    'class' => 'pagination-item'
                ));
                ?>
            </div>
            
            <script>
                // Add pagination styling classes
                document.querySelectorAll('.page-numbers').forEach(el => {
                    el.classList.add('pagination-item');
                    if (el.classList.contains('current')) {
                        el.classList.add('active');
                    }
                });
            </script>
        <?php endif; ?>
        
    <?php elseif ($action === 'edit'): ?>
        <!-- Form Editor -->
        <form class="editor-form" method="post" action="" enctype="multipart/form-data">
            <?php wp_nonce_field('save_post_' . $post_id); ?>
            <input type="hidden" name="admin_frontend_submit" value="1">
            <input type="hidden" name="action" value="save_post">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            
            <div class="form-group">
                <label class="form-label">Judul Berita</label>
                <input type="text" name="post_title" class="form-input" value="<?php echo $post_id ? get_the_title($post_id) : ''; ?>" placeholder="Masukkan judul berita...">
            </div>
            
            <div class="form-group">
                <label class="form-label">Konten Berita</label>
                <div class="rich-text-editor">
                    <div class="rich-text-toolbar">
                        <button type="button" class="rich-text-button" onclick="execCommand('bold'); return false;" title="Bold"><strong>B</strong></button>
                        <button type="button" class="rich-text-button" onclick="execCommand('italic'); return false;" title="Italic"><em>I</em></button>
                        <button type="button" class="rich-text-button" onclick="execCommand('underline'); return false;" title="Underline"><u>U</u></button>
                        <span class="shadcn-separator"></span>
                        <button type="button" class="rich-text-button" onclick="execCommand('insertUnorderedList'); return false;" title="Bullet List">•</button>
                        <button type="button" class="rich-text-button" onclick="execCommand('insertOrderedList'); return false;" title="Numbered List">1.</button>
                        <span class="shadcn-separator"></span>
                        <button type="button" class="rich-text-button" onclick="execCommand('justifyLeft'); return false;" title="Align Left">L</button>
                        <button type="button" class="rich-text-button" onclick="execCommand('justifyCenter'); return false;" title="Align Center">C</button>
                        <button type="button" class="rich-text-button" onclick="execCommand('justifyRight'); return false;" title="Align Right">R</button>
                        <span class="shadcn-separator"></span>
                        <button type="button" class="rich-text-button" onclick="execCommand('createLink'); return false;" title="Insert Link"><i class="fas fa-link" style="margin:0;"></i></button>
                        <button type="button" class="rich-text-button" onclick="execCommand('unlink'); return false;" title="Remove Link"><i class="fas fa-unlink" style="margin:0;"></i></button>
                        <span class="shadcn-separator"></span>
                        <button type="button" class="rich-text-button" onclick="insertImageToEditor(); return false;" title="Tambah Foto"><i class="fas fa-camera" style="margin:0;"></i></button>
                        <button type="button" class="rich-text-button" onclick="insertYoutube(); return false;" title="Tambah YouTube"><i class="fab fa-youtube" style="margin:0;"></i></button>
                        <button type="button" class="rich-text-button" onclick="insertPageBreak(); return false;" title="Tambah Page Break (Halaman Baru)"><i class="fas fa-file-alt" style="margin:0;"></i></button>
                    </div>
                    <div class="rich-text-content" contenteditable="true" id="post_content_editor" name="post_content" placeholder="Tulis konten berita di sini..."><?php echo $post_id ? get_the_content('', false, $post_id) : ''; ?></div>
                    <input type="hidden" name="post_content" id="post_content_hidden" value="<?php echo htmlspecialchars($post_id ? get_the_content('', false, $post_id) : ''); ?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Featured Image</label>
                <div class="featured-image-container">
                    <div class="media-preview-box" id="media_preview_box">
                        <?php if ($post_id && has_post_thumbnail($post_id)): ?>
                            <img src="<?php echo get_the_post_thumbnail_url($post_id, 'medium'); ?>" alt="Preview">
                        <?php else: ?>
                            <div class="media-placeholder">
                                <i class="fas fa-image"></i>
                                <span>Belum ada gambar</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="media-actions" style="display: flex; gap: 10px;">
                        <button type="button" id="select_media_btn" class="shadcn-btn shadcn-btn-outline">
                            <i class="fas fa-upload"></i> <?php echo (has_post_thumbnail($post_id)) ? 'Ganti Gambar' : 'Pilih Gambar'; ?>
                        </button>
                        <button type="button" id="remove_media_btn" class="shadcn-btn shadcn-btn-danger" style="<?php echo (has_post_thumbnail($post_id)) ? 'display: inline-flex;' : 'display: none;'; ?>">
                            <i class="fas fa-times"></i> Hapus
                        </button>
                    </div>
                    
                    <input type="hidden" name="featured_image_id" id="featured_image_id" value="<?php echo get_post_thumbnail_id($post_id); ?>">
                </div>
            </div>
            
            <div class="categories-tags">
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <?php
                    $categories = get_categories(array('hide_empty' => false));
                    $post_categories = wp_get_post_categories($post_id);
                    ?>
                    <select name="post_category[]" class="form-input" multiple>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->term_id; ?>" <?php echo in_array($category->term_id, $post_categories) ? 'selected' : ''; ?>>
                                <?php echo $category->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tag (pisahkan dengan koma)</label>
                    <input type="text" name="post_tags" class="form-input" value="<?php echo $post_id ? implode(', ', wp_get_post_tags($post_id, array('fields' => 'names'))) : ''; ?>" placeholder="tag1, tag2, tag3">
                </div>
            </div>
            
            <div class="publish-options">
                <div class="form-group">
                    <label class="form-label">Tanggal Publikasi (Format 24 Jam - WIT)</label>
                    <input type="datetime-local" name="post_date" class="form-input" value="<?php echo $post_id ? get_the_date('Y-m-d\TH:i', $post_id) : wp_date('Y-m-d\TH:i'); ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="post_status" class="form-input">
                        <option value="draft" <?php echo ($post_id && get_post_status($post_id) === 'draft') ? 'selected' : ''; ?>>Draft</option>
                        <option value="publish" <?php echo ($post_id && get_post_status($post_id) === 'publish') ? 'selected' : ''; ?>>Diterbitkan</option>
                    </select>
                </div>
            </div>
            
            <div class="admin-actions" style="margin-top: 30px;">
                <button type="submit" class="shadcn-btn shadcn-btn-primary">
                    <i class="fas fa-save"></i> Simpan Berita
                </button>
                <?php if ($post_id): ?>
                    <a href="<?php echo get_permalink($post_id); ?>" target="_blank" class="shadcn-btn shadcn-btn-outline">
                        <i class="fas fa-external-link-alt"></i> Lihat Berita
                    </a>
                <?php endif; ?>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php
// Ambil konten admin
$content = ob_get_clean();

// Tampilkan header, konten, dan footer
get_header();
?>

<main class="site-main">
    <div class="container mx-auto px-4 py-8">
        <?php echo $content; ?>
    </div>
</main>

<?php
get_footer();
exit;
