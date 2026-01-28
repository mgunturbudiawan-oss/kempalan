<?php
/**
 * React Helpers for Haliyora Theme
 * Provides functions to easily integrate React components in WordPress templates
 */

/**
 * Helper function to render React components in WordPress templates
 * Usage: haliyora_react_component('ComponentName', $props_array, $additional_attrs_array)
 */
function haliyora_react_component($component_name, $props = array(), $attrs = array()) {
    $props_json = json_encode($props);
    $attrs_str = '';
    
    foreach ($attrs as $key => $value) {
        $attrs_str .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
    }
    
    $component_id = uniqid('react-comp-');
    
    return '<div id="' . $component_id . '" data-react-component="' . esc_attr($component_name) . '" data-props=\'' . $props_json . '\'' . $attrs_str . '></div>';
}

/**
 * Enqueue React component data for specific pages
 */
function haliyora_enqueue_react_data($data) {
    wp_add_inline_script('haliyora-react-integration', 'window.haliyoraReactData = ' . json_encode($data) . ';');
}

/**
 * Get WordPress REST API base URL for React components
 */
function haliyora_get_rest_api_base() {
    return rest_url();
}

/**
 * Get current user data for React components
 */
function haliyora_get_current_user_data() {
    $current_user = wp_get_current_user();
    
    if ($current_user->exists()) {
        return array(
            'id' => $current_user->ID,
            'name' => $current_user->display_name,
            'email' => $current_user->user_email,
            'can_comment' => current_user_can('comment')
        );
    }
    
    return null;
}

/**
 * Get site info for React components
 */
function haliyora_get_site_info() {
    $site_info = get_transient('haliyora_site_info');
    if (false === $site_info) {
        $site_info = array(
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => home_url(),
            'template_directory' => get_template_directory_uri(),
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_rest')
        );
        set_transient('haliyora_site_info', $site_info, DAY_IN_SECONDS);
    }
    return $site_info;
}