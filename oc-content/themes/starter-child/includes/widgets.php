<?php
/**
 * Starter Child Theme - Widget Placeholders
 *
 * Contains widget registration and placeholder functions for plugins.
 * Provides integration points for third-party widget implementations.
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
| WIDGET LOCATIONS
|--------------------------------------------------------------------------
| Define available widget locations for the child theme.
*/
if (!function_exists('starter_child_widget_locations')) {
    /**
     * Get available widget locations.
     *
     * @return array Array of widget location definitions.
     */
    function starter_child_widget_locations() {
        return array(
            'header'        => __('Header', 'starter-child'),
            'footer'        => __('Footer', 'starter-child'),
            'sidebar'       => __('Sidebar', 'starter-child'),
            'home_top'      => __('Home Page Top', 'starter-child'),
            'home_bottom'   => __('Home Page Bottom', 'starter-child'),
            'search_top'    => __('Search Page Top', 'starter-child'),
            'search_bottom' => __('Search Page Bottom', 'starter-child'),
            'item_sidebar'  => __('Item Page Sidebar', 'starter-child'),
            'item_bottom'   => __('Item Page Bottom', 'starter-child'),
        );
    }
}

/*
|--------------------------------------------------------------------------
| SIDEBAR WIDGET AREA
|--------------------------------------------------------------------------
| Render sidebar widget area with fallback content.
*/
if (!function_exists('starter_child_sidebar_widgets')) {
    /**
     * Render sidebar widget area.
     *
     * @param string $location Widget location identifier.
     * @return void
     */
    function starter_child_sidebar_widgets($location = 'sidebar') {
        // Hook for plugins to add widgets
        osc_run_hook('starter_child_widget_' . $location);
        
        // Show Osclass widgets if available
        osc_show_widgets($location);
    }
}

/*
|--------------------------------------------------------------------------
| HOME PAGE WIDGETS
|--------------------------------------------------------------------------
| Widget placeholders for home page customization.
*/
if (!function_exists('starter_child_home_top_widgets')) {
    /**
     * Render widgets at top of home page.
     *
     * @return void
     */
    function starter_child_home_top_widgets() {
        if (!osc_is_home_page()) {
            return;
        }
        // Allow plugins to add widgets via hook
        osc_run_hook('starter_child_widget_home_top');
    }
}

if (!function_exists('starter_child_home_bottom_widgets')) {
    /**
     * Render widgets at bottom of home page.
     *
     * @return void
     */
    function starter_child_home_bottom_widgets() {
        if (!osc_is_home_page()) {
            return;
        }
        // Allow plugins to add widgets via hook
        osc_run_hook('starter_child_widget_home_bottom');
    }
}

/*
|--------------------------------------------------------------------------
| SEARCH PAGE WIDGETS
|--------------------------------------------------------------------------
| Widget placeholders for search results page.
*/
if (!function_exists('starter_child_search_widgets')) {
    /**
     * Render search page sidebar widgets.
     *
     * @return void
     */
    function starter_child_search_widgets() {
        if (!osc_is_search_page()) {
            return;
        }
        // Allow plugins to add widgets via hook
        osc_run_hook('starter_child_widget_search_sidebar');
    }
}

/*
|--------------------------------------------------------------------------
| ITEM PAGE WIDGETS
|--------------------------------------------------------------------------
| Widget placeholders for item detail page.
*/
if (!function_exists('starter_child_item_widgets')) {
    /**
     * Render item page sidebar widgets.
     *
     * @return void
     */
    function starter_child_item_widgets() {
        if (!osc_is_ad_page()) {
            return;
        }
        // Allow plugins to add widgets via hook
        osc_run_hook('starter_child_widget_item_sidebar');
    }
}

if (!function_exists('starter_child_item_bottom_widgets')) {
    /**
     * Render widgets at bottom of item page.
     *
     * @return void
     */
    function starter_child_item_bottom_widgets() {
        if (!osc_is_ad_page()) {
            return;
        }
        // Allow plugins to add widgets via hook
        osc_run_hook('starter_child_widget_item_bottom');
    }
}

/*
|--------------------------------------------------------------------------
| WIDGET HELPER FUNCTIONS
|--------------------------------------------------------------------------
| Utility functions for widget management.
*/
if (!function_exists('starter_child_render_widget')) {
    /**
     * Render a single widget with wrapper.
     *
     * @param string   $id      Widget ID.
     * @param string   $title   Widget title.
     * @param callable $content Callback function to render widget content.
     * @return void
     */
    function starter_child_render_widget($id, $title, $content) {
        echo '<div class="widget widget-' . starter_child_sanitize_class($id) . '">';
        if (!empty($title)) {
            echo '<h3 class="widget-title">' . esc_html($title) . '</h3>';
        }
        echo '<div class="widget-content">';
        if (is_callable($content)) {
            call_user_func($content);
        }
        echo '</div>';
        echo '</div>';
    }
}

if (!function_exists('starter_child_widget_wrapper_start')) {
    /**
     * Output widget area wrapper start.
     *
     * @param string $location Widget location identifier.
     * @param string $class    Additional CSS classes.
     * @return void
     */
    function starter_child_widget_wrapper_start($location, $class = '') {
        $classes = 'widget-area widget-area-' . starter_child_sanitize_class($location);
        if (!empty($class)) {
            $classes .= ' ' . $class;
        }
        echo '<div class="' . $classes . '">';
    }
}

if (!function_exists('starter_child_widget_wrapper_end')) {
    /**
     * Output widget area wrapper end.
     *
     * @return void
     */
    function starter_child_widget_wrapper_end() {
        echo '</div>';
    }
}

/*
|--------------------------------------------------------------------------
| PLUGIN INTEGRATION PLACEHOLDERS
|--------------------------------------------------------------------------
| Placeholders for common plugin integrations.
*/
if (!function_exists('starter_child_social_sharing')) {
    /**
     * Placeholder for social sharing widget.
     * Plugins can hook into this to add sharing buttons.
     *
     * @return void
     */
    function starter_child_social_sharing() {
        osc_run_hook('starter_child_social_sharing');
    }
}

if (!function_exists('starter_child_related_items')) {
    /**
     * Placeholder for related items widget.
     * Plugins can hook into this to display related listings.
     *
     * @return void
     */
    function starter_child_related_items() {
        osc_run_hook('starter_child_related_items');
    }
}

if (!function_exists('starter_child_newsletter_form')) {
    /**
     * Placeholder for newsletter signup widget.
     * Plugins can hook into this to add newsletter forms.
     *
     * @return void
     */
    function starter_child_newsletter_form() {
        osc_run_hook('starter_child_newsletter_form');
    }
}

if (!function_exists('starter_child_ad_banner')) {
    /**
     * Placeholder for advertisement banners.
     *
     * @param string $location Banner location identifier.
     * @return void
     */
    function starter_child_ad_banner($location = 'default') {
        osc_run_hook('starter_child_ad_banner', $location);
        osc_run_hook('starter_child_ad_banner_' . $location);
    }
}
