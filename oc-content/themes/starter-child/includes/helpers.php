<?php
/**
 * Helper Functions
 * 
 * This file contains utility and helper functions for the child theme.
 * These functions provide reusable code to keep templates clean and DRY.
 * 
 * @package     Starter_Child_Theme
 * @version     1.0.0
 * @author      TaproMall Development Team
 */

// Prevent direct access
if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

/**
 * Get Child Theme Asset URL
 * 
 * Returns the full URL to an asset file
 * 
 * @param string $path Relative path to asset
 * @return string Full URL to asset
 */
function starter_child_asset($path) {
    return STARTER_CHILD_THEME_URL . 'assets/' . ltrim($path, '/');
}

/**
 * Get Child Theme Template Path
 * 
 * Returns the full path to a template file
 * 
 * @param string $template Template filename
 * @return string Full path to template
 */
function starter_child_template_path($template) {
    return STARTER_CHILD_THEME_PATH . 'templates/' . ltrim($template, '/');
}

/**
 * Include Child Theme Template
 * 
 * Safely includes a template file if it exists
 * 
 * @param string $template Template filename
 * @param array $data Data to pass to template
 * @return bool True if template exists and was included
 */
function starter_child_include_template($template, $data = array()) {
    $template_path = starter_child_template_path($template);
    
    if (file_exists($template_path)) {
        // Extract data array to variables
        if (!empty($data) && is_array($data)) {
            extract($data);
        }
        
        include $template_path;
        return true;
    }
    
    return false;
}

/**
 * Get Child Theme Version
 * 
 * Returns the current child theme version
 * 
 * @return string Theme version
 */
function starter_child_version() {
    return STARTER_CHILD_THEME_VERSION;
}

/**
 * Is Child Theme Debug Mode
 * 
 * Checks if debug mode is enabled
 * 
 * @return bool True if debug mode is enabled
 */
function starter_child_is_debug() {
    return defined('OSC_DEBUG') && OSC_DEBUG;
}

/**
 * Child Theme Debug Log
 * 
 * Logs debug information if debug mode is enabled
 * 
 * @param mixed $message Message to log
 * @param string $level Log level (info, warning, error)
 */
function starter_child_log($message, $level = 'info') {
    if (starter_child_is_debug()) {
        $timestamp = date('Y-m-d H:i:s');
        $log_message = sprintf('[%s] [%s] %s', $timestamp, strtoupper($level), print_r($message, true));
        error_log($log_message);
    }
}

/**
 * Sanitize Output
 * 
 * Sanitizes output for safe display
 * 
 * @param string $output Output to sanitize
 * @return string Sanitized output
 */
function starter_child_sanitize($output) {
    return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
}

/**
 * Format Price
 * 
 * Formats a price with currency symbol
 * 
 * @param float $price Price to format
 * @return string Formatted price
 */
function starter_child_format_price($price) {
    return osc_format_price($price);
}

/**
 * Get Theme Option
 * 
 * Gets a theme option value with fallback
 * 
 * @param string $option Option key
 * @param mixed $default Default value if option doesn't exist
 * @return mixed Option value or default
 */
function starter_child_get_option($option, $default = null) {
    $value = osc_get_preference($option, 'starter-child-theme');
    return ($value !== null) ? $value : $default;
}

/**
 * Set Theme Option
 * 
 * Sets a theme option value
 * 
 * @param string $option Option key
 * @param mixed $value Option value
 * @return bool True on success
 */
function starter_child_set_option($option, $value) {
    return osc_set_preference($option, $value, 'starter-child-theme');
}

/**
 * Render SVG Icon
 * 
 * Outputs an SVG icon
 * 
 * @param string $icon Icon name
 * @param string $class Additional CSS classes
 */
function starter_child_render_icon($icon, $class = '') {
    $svg_path = STARTER_CHILD_THEME_PATH . 'assets/images/icons/' . $icon . '.svg';
    
    if (file_exists($svg_path)) {
        $classes = 'child-icon child-icon-' . $icon;
        if (!empty($class)) {
            $classes .= ' ' . $class;
        }
        
        echo '<span class="' . esc_attr($classes) . '">';
        include $svg_path;
        echo '</span>';
    }
}

/**
 * Get Responsive Image
 * 
 * Returns responsive image HTML with srcset
 * 
 * @param string $src Image source URL
 * @param string $alt Alt text
 * @param array $sizes Image sizes
 * @return string Image HTML
 */
function starter_child_responsive_image($src, $alt = '', $sizes = array()) {
    $html = '<img src="' . esc_url($src) . '" alt="' . esc_attr($alt) . '"';
    
    if (!empty($sizes)) {
        $srcset = array();
        foreach ($sizes as $size => $url) {
            $srcset[] = esc_url($url) . ' ' . $size;
        }
        $html .= ' srcset="' . implode(', ', $srcset) . '"';
    }
    
    $html .= ' />';
    return $html;
}
