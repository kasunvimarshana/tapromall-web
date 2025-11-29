<?php
/**
 * Starter Child Theme - Helper Functions
 *
 * Contains utility functions used throughout the child theme.
 * All functions are prefixed with 'starter_child_' to avoid conflicts.
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
| ASSET HELPERS
|--------------------------------------------------------------------------
| Functions to help with asset management.
*/
if (!function_exists('starter_child_asset_url')) {
    /**
     * Get URL for a child theme asset.
     *
     * @param string $path Relative path to asset from theme root.
     * @return string Full URL to the asset.
     */
    function starter_child_asset_url($path = '') {
        return STARTER_CHILD_URL . ltrim($path, '/');
    }
}

if (!function_exists('starter_child_asset_path')) {
    /**
     * Get filesystem path for a child theme asset.
     *
     * @param string $path Relative path to asset from theme root.
     * @return string Full filesystem path to the asset.
     */
    function starter_child_asset_path($path = '') {
        return STARTER_CHILD_PATH . ltrim($path, '/');
    }
}

/*
|--------------------------------------------------------------------------
| TEMPLATE HELPERS
|--------------------------------------------------------------------------
| Functions to help with template management.
*/
if (!function_exists('starter_child_get_template')) {
    /**
     * Include a template part from the child theme.
     * Falls back to parent theme if not found.
     *
     * @param string $template Template file name (without .php).
     * @param array  $args     Variables to pass to the template (sanitized keys only).
     * @return void
     */
    function starter_child_get_template($template, $args = array()) {
        // Make variables available to template using explicit assignment
        // instead of extract() to prevent variable pollution
        if (!empty($args) && is_array($args)) {
            foreach ($args as $key => $value) {
                // Only allow alphanumeric keys to prevent injection
                if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
                    $$key = $value;
                }
            }
        }

        // First check child theme templates folder
        $child_template = STARTER_CHILD_PATH . 'templates/' . $template . '.php';
        if (file_exists($child_template)) {
            require $child_template;
            return;
        }

        // Fall back to parent theme
        $parent_template = osc_themes_path() . 'starter/' . $template . '.php';
        if (file_exists($parent_template)) {
            require $parent_template;
        }
    }
}

if (!function_exists('starter_child_template_exists')) {
    /**
     * Check if a template exists in child theme.
     *
     * @param string $template Template file name (without .php).
     * @return bool True if template exists.
     */
    function starter_child_template_exists($template) {
        return file_exists(STARTER_CHILD_PATH . 'templates/' . $template . '.php');
    }
}

/*
|--------------------------------------------------------------------------
| PREFERENCE HELPERS
|--------------------------------------------------------------------------
| Functions to easily get/set child theme preferences.
*/
if (!function_exists('starter_child_get_option')) {
    /**
     * Get a child theme preference.
     *
     * @param string $key     Preference key.
     * @param mixed  $default Default value if preference not found.
     * @return mixed Preference value or default.
     */
    function starter_child_get_option($key, $default = '') {
        $value = osc_get_preference($key, 'starter_child_theme');
        return ($value !== null && $value !== '') ? $value : $default;
    }
}

if (!function_exists('starter_child_set_option')) {
    /**
     * Set a child theme preference.
     *
     * @param string $key   Preference key.
     * @param mixed  $value Preference value.
     * @return void
     */
    function starter_child_set_option($key, $value) {
        osc_set_preference($key, $value, 'starter_child_theme');
    }
}

/*
|--------------------------------------------------------------------------
| CONDITIONAL HELPERS
|--------------------------------------------------------------------------
| Functions to check various conditions.
*/
if (!function_exists('starter_child_is_parent_active')) {
    /**
     * Check if the parent theme (starter) is available.
     *
     * @return bool True if parent theme is available.
     */
    function starter_child_is_parent_active() {
        return file_exists(osc_themes_path() . 'starter/functions.php');
    }
}

if (!function_exists('starter_child_is_mobile')) {
    /**
     * Simple mobile device detection.
     *
     * @return bool True if user is on a mobile device.
     */
    function starter_child_is_mobile() {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $mobile_agents = array(
                'iPhone', 'iPad', 'Android', 'webOS', 'BlackBerry',
                'Windows Phone', 'Opera Mini', 'IEMobile', 'Mobile'
            );
            foreach ($mobile_agents as $agent) {
                if (strpos($_SERVER['HTTP_USER_AGENT'], $agent) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
}

/*
|--------------------------------------------------------------------------
| STRING HELPERS
|--------------------------------------------------------------------------
| Functions to manipulate strings.
*/
if (!function_exists('starter_child_truncate')) {
    /**
     * Truncate a string to a specified length.
     *
     * @param string $string String to truncate.
     * @param int    $length Maximum length.
     * @param string $suffix Suffix to append if truncated.
     * @return string Truncated string.
     */
    function starter_child_truncate($string, $length = 100, $suffix = '...') {
        if (strlen($string) <= $length) {
            return $string;
        }
        return substr($string, 0, $length) . $suffix;
    }
}

if (!function_exists('starter_child_sanitize_class')) {
    /**
     * Sanitize a string to be used as a CSS class.
     *
     * @param string $class Class name to sanitize.
     * @return string Sanitized class name.
     */
    function starter_child_sanitize_class($class) {
        return preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower($class));
    }
}

/*
|--------------------------------------------------------------------------
| TRANSLATION HELPERS
|--------------------------------------------------------------------------
| Functions to help with internationalization.
*/
if (!function_exists('starter_child_e')) {
    /**
     * Echo a translated string (shorthand for translation).
     *
     * @param string $text Text to translate.
     * @return void
     */
    function starter_child_e($text) {
        _e($text, 'starter-child');
    }
}

if (!function_exists('starter_child__')) {
    /**
     * Return a translated string (shorthand for translation).
     *
     * @param string $text Text to translate.
     * @return string Translated text.
     */
    function starter_child__($text) {
        return __($text, 'starter-child');
    }
}

/*
|--------------------------------------------------------------------------
| DEBUG HELPERS
|--------------------------------------------------------------------------
| Functions to help with debugging (disable in production).
*/
if (!function_exists('starter_child_debug')) {
    /**
     * Output debug information if debug mode is enabled.
     *
     * @param mixed $data Data to debug.
     * @return void
     */
    function starter_child_debug($data) {
        if (defined('OSC_DEBUG') && OSC_DEBUG) {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
    }
}

/*
|--------------------------------------------------------------------------
| URL HELPERS
|--------------------------------------------------------------------------
| Functions to generate URLs.
*/
if (!function_exists('starter_child_current_url')) {
    /**
     * Get the current page URL.
     *
     * @return string Current URL.
     */
    function starter_child_current_url() {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
}

if (!function_exists('starter_child_add_query_arg')) {
    /**
     * Add a query argument to a URL.
     *
     * @param string|array $key   Key or array of key/value pairs.
     * @param string       $value Value (if key is string).
     * @param string       $url   URL to modify (defaults to current).
     * @return string Modified URL.
     */
    function starter_child_add_query_arg($key, $value = '', $url = '') {
        if (empty($url)) {
            $url = starter_child_current_url();
        }

        $url_parts = parse_url($url);
        $query = array();
        
        if (isset($url_parts['query'])) {
            parse_str($url_parts['query'], $query);
        }

        if (is_array($key)) {
            $query = array_merge($query, $key);
        } else {
            $query[$key] = $value;
        }

        $url_parts['query'] = http_build_query($query);

        $scheme = isset($url_parts['scheme']) ? $url_parts['scheme'] . '://' : '';
        $host = isset($url_parts['host']) ? $url_parts['host'] : '';
        $port = isset($url_parts['port']) ? ':' . $url_parts['port'] : '';
        $path = isset($url_parts['path']) ? $url_parts['path'] : '';
        $query_str = isset($url_parts['query']) ? '?' . $url_parts['query'] : '';
        $fragment = isset($url_parts['fragment']) ? '#' . $url_parts['fragment'] : '';

        return $scheme . $host . $port . $path . $query_str . $fragment;
    }
}
