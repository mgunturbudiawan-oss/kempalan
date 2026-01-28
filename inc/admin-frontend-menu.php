<?php
/**
 * Admin Frontend Menu
 * Fungsi untuk menambahkan menu admin frontend ke header
 */

/**
 * Add admin frontend menu to header
 */
function haliyora_add_admin_menu_to_header() {
    if (is_user_logged_in() && current_user_can('edit_others_posts')) {
        echo '<div class="admin-frontend-menu" style="margin-left: auto;">';
        echo '<a href="' . home_url('/?admin_frontend_page=1') . '" class="shadcn-btn shadcn-btn-outline" style="display: inline-flex; align-items: center; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px;">';
        echo '<i class="fas fa-pen" style="margin-right: 8px;"></i> Admin Berita';
        echo '</a>';
        echo '</div>';
    }
}