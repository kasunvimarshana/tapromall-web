<?php
/**
 * Starter Child Theme - Asset Management
 *
 * Handles loading of child theme CSS and JavaScript files.
 * Properly enqueues styles/scripts after parent theme assets.
 *
 * @package StarterChild
 * @subpackage Includes
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABS_PATH')) {
    exit('Direct access not allowed.');
}

/*
|--------------------------------------------------------------------------
| ENQUEUE CHILD THEME STYLES
|--------------------------------------------------------------------------
| Load child theme stylesheets after parent theme styles.
*/
if (!function_exists('starter_child_enqueue_styles')) {
    /**
     * Enqueue child theme stylesheets.
     * Uses the 'header' hook to ensure styles load in the proper order.
     *
     * @return void
     */
    function starter_child_enqueue_styles() {
        // Only load if custom CSS is enabled (default to enabled)
        $css_enabled = osc_get_preference('custom_css_enabled', 'starter_child_theme');
        if ($css_enabled === null || $css_enabled === '' || $css_enabled === '1') {
            // Register and enqueue child theme main stylesheet
            $css_file = STARTER_CHILD_PATH . 'css/child-style.css';
            if (file_exists($css_file)) {
                osc_enqueue_style(
                    'starter-child-style',
                    osc_current_web_theme_url('css/child-style.css?v=' . STARTER_CHILD_VERSION)
                );
            }

            // Register and enqueue responsive styles
            $responsive_file = STARTER_CHILD_PATH . 'css/child-responsive.css';
            if (file_exists($responsive_file)) {
                osc_enqueue_style(
                    'starter-child-responsive',
                    osc_current_web_theme_url('css/child-responsive.css?v=' . STARTER_CHILD_VERSION)
                );
            }
        }
    }
    osc_add_hook('header', 'starter_child_enqueue_styles');
}

/*
|--------------------------------------------------------------------------
| ENQUEUE CHILD THEME SCRIPTS
|--------------------------------------------------------------------------
| Load child theme JavaScript files after parent theme scripts.
*/
if (!function_exists('starter_child_enqueue_scripts')) {
    /**
     * Enqueue child theme JavaScript files.
     * Uses the 'footer' hook to ensure scripts load after main content.
     *
     * @return void
     */
    function starter_child_enqueue_scripts() {
        // Only load if custom JS is enabled (default to enabled)
        $js_enabled = osc_get_preference('custom_js_enabled', 'starter_child_theme');
        if ($js_enabled === null || $js_enabled === '' || $js_enabled === '1') {
            // Register and enqueue child theme main script
            $js_file = STARTER_CHILD_PATH . 'js/child-scripts.js';
            if (file_exists($js_file)) {
                osc_register_script(
                    'starter-child-scripts',
                    osc_current_web_theme_url('js/child-scripts.js?v=' . STARTER_CHILD_VERSION),
                    array('jquery')
                );
                osc_enqueue_script('starter-child-scripts');
            }
        }
    }
    osc_add_hook('header', 'starter_child_enqueue_scripts');
}

/*
|--------------------------------------------------------------------------
| CONDITIONAL ASSET LOADING
|--------------------------------------------------------------------------
| Functions to load assets conditionally based on page type.
*/
if (!function_exists('starter_child_conditional_assets')) {
    /**
     * Load conditional assets based on current page.
     *
     * @return void
     */
    function starter_child_conditional_assets() {
        // Example: Load specific CSS for search page
        if (osc_is_search_page()) {
            $search_css = STARTER_CHILD_PATH . 'css/pages/child-search.css';
            if (file_exists($search_css)) {
                osc_enqueue_style(
                    'starter-child-search',
                    osc_current_web_theme_url('css/pages/child-search.css?v=' . STARTER_CHILD_VERSION)
                );
            }
        }

        // Example: Load specific CSS for item detail page
        if (osc_is_ad_page()) {
            $item_css = STARTER_CHILD_PATH . 'css/pages/child-item.css';
            if (file_exists($item_css)) {
                osc_enqueue_style(
                    'starter-child-item',
                    osc_current_web_theme_url('css/pages/child-item.css?v=' . STARTER_CHILD_VERSION)
                );
            }
        }

        // Example: Load specific CSS for publish page
        if (osc_is_publish_page() || osc_is_edit_page()) {
            $publish_css = STARTER_CHILD_PATH . 'css/pages/child-publish.css';
            if (file_exists($publish_css)) {
                osc_enqueue_style(
                    'starter-child-publish',
                    osc_current_web_theme_url('css/pages/child-publish.css?v=' . STARTER_CHILD_VERSION)
                );
            }
        }
    }
    osc_add_hook('header', 'starter_child_conditional_assets');
}

/*
|--------------------------------------------------------------------------
| INLINE STYLES & SCRIPTS
|--------------------------------------------------------------------------
| Add inline CSS or JS when needed (e.g., dynamic styles from settings).
*/
if (!function_exists('starter_child_inline_styles')) {
    /**
     * Output inline styles in the header.
     * Use for dynamic CSS that depends on theme settings.
     *
     * @return void
     */
    function starter_child_inline_styles() {
        // Example: Add custom inline CSS
        // $primary_color = osc_get_preference('primary_color', 'starter_child_theme');
        // if ($primary_color) {
        //     echo '<style>:root { --child-primary-color: ' . esc_attr($primary_color) . '; }</style>';
        // }
    }
    osc_add_hook('header', 'starter_child_inline_styles', 100);
}
