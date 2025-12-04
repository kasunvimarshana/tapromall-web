<?php
/**
 * Starter Child Theme Functions
 * 
 * This file contains all theme customizations using hooks and filters.
 * Following Osclass best practices, we avoid modifying parent theme files
 * and use the hook system for all customizations.
 * 
 * @package   StarterChild
 * @author    TaproMall Team
 * @version   1.0.0
 */

// Prevent direct access to this file
if (!defined('OC_ADMIN')) {
    exit('Direct access is not allowed.');
}

/**
 * Theme Constants
 * 
 * Define constants for theme paths and URLs to ensure consistency
 * and maintainability across the theme.
 */
define('STARTER_CHILD_THEME_PATH', osc_current_web_theme_path());
define('STARTER_CHILD_THEME_URL', osc_current_web_theme_url());
define('STARTER_CHILD_VERSION', '1.0.0');

// ============================================================================
// ASSET ENQUEUING
// ============================================================================

/**
 * Enqueue child theme stylesheets
 * 
 * Loads the child theme's custom CSS file after the parent theme styles.
 * Uses versioning for cache busting during development.
 * 
 * @return void
 */
function starter_child_enqueue_styles() {
    // Enqueue child theme main stylesheet
    osc_enqueue_style(
        'starter-child-style',
        osc_current_web_theme_url('css/style.css'),
        array(),
        STARTER_CHILD_VERSION
    );
}
osc_add_hook('header', 'starter_child_enqueue_styles', 10);

/**
 * Enqueue child theme scripts
 * 
 * Loads the child theme's custom JavaScript file.
 * Scripts are loaded in the footer for better page performance.
 * 
 * @return void
 */
function starter_child_enqueue_scripts() {
    // Enqueue child theme main script
    osc_enqueue_script(
        'starter-child-script',
        osc_current_web_theme_url('js/main.js'),
        array('jquery'),
        STARTER_CHILD_VERSION,
        true // Load in footer
    );
}
osc_add_hook('footer', 'starter_child_enqueue_scripts', 10);

// ============================================================================
// THEME SETUP
// ============================================================================

/**
 * Initialize child theme
 * 
 * Performs any necessary setup tasks when the theme is initialized.
 * This hook runs after the Osclass core has loaded.
 * 
 * @return void
 */
function starter_child_init() {
    // Add any initialization code here
    // Example: Register custom post types, taxonomies, etc.
}
osc_add_hook('init', 'starter_child_init', 10);

// ============================================================================
// CUSTOMIZATION HOOKS
// ============================================================================

/**
 * Customize header
 * 
 * Add custom content or functionality to the theme header.
 * This is a placeholder for future header customizations.
 * 
 * @return void
 */
function starter_child_header_custom() {
    // Add custom header content here
    // Example: Analytics code, custom meta tags, etc.
}
osc_add_hook('header', 'starter_child_header_custom', 20);

/**
 * Customize footer
 * 
 * Add custom content or functionality to the theme footer.
 * This is a placeholder for future footer customizations.
 * 
 * @return void
 */
function starter_child_footer_custom() {
    // Add custom footer content here
    // Example: Custom footer scripts, widgets, etc.
}
osc_add_hook('footer', 'starter_child_footer_custom', 20);

// ============================================================================
// FILTER HOOKS (DATA MODIFICATION)
// ============================================================================

/**
 * Modify item title
 * 
 * Example filter to modify the item title before display.
 * Currently returns the title unchanged.
 * 
 * @param string $title The original item title
 * @return string Modified item title
 */
function starter_child_filter_item_title($title) {
    // Modify title as needed
    // Example: return strtoupper($title);
    return $title;
}
// Uncomment to activate this filter:
// osc_add_filter('item_title', 'starter_child_filter_item_title', 10);

/**
 * Modify meta title
 * 
 * Example filter to modify the page meta title for SEO.
 * Currently returns the title unchanged.
 * 
 * @param string $title The original meta title
 * @return string Modified meta title
 */
function starter_child_filter_meta_title($title) {
    // Modify meta title as needed
    return $title;
}
// Uncomment to activate this filter:
// osc_add_filter('meta_title_filter', 'starter_child_filter_meta_title', 10);

// ============================================================================
// CUSTOM FUNCTIONS
// ============================================================================

/**
 * Get child theme option
 * 
 * Helper function to retrieve theme options from the database.
 * Uses Osclass preferences API for data storage.
 * 
 * @param string $option_name The name of the option to retrieve
 * @param mixed  $default     Default value if option doesn't exist
 * @return mixed The option value or default
 */
function starter_child_get_option($option_name, $default = false) {
    $value = osc_get_preference($option_name, 'starter_child_settings');
    return ($value !== null && $value !== '') ? $value : $default;
}

/**
 * Set child theme option
 * 
 * Helper function to save theme options to the database.
 * Uses Osclass preferences API for data storage.
 * 
 * @param string $option_name  The name of the option to save
 * @param mixed  $option_value The value to save
 * @param string $type         Data type (STRING, INTEGER, BOOLEAN)
 * @return bool Whether the option was successfully saved
 */
function starter_child_set_option($option_name, $option_value, $type = 'STRING') {
    return osc_set_preference($option_name, $option_value, 'starter_child_settings', $type);
}

// ============================================================================
// WIDGET SUPPORT
// ============================================================================

/**
 * Register custom widgets
 * 
 * Placeholder function for registering custom front-end widgets.
 * Widgets can be added to theme areas like header and footer.
 * 
 * @return void
 */
function starter_child_register_widgets() {
    // Register custom widgets here
    // Example:
    // require_once STARTER_CHILD_THEME_PATH . 'widgets/custom-widget.php';
    // osc_register_widget('CustomWidget');
}
osc_add_hook('init', 'starter_child_register_widgets', 15);

// ============================================================================
// ADMIN CUSTOMIZATION
// ============================================================================

/**
 * Add admin menu items
 * 
 * Adds custom menu items to the Osclass admin panel for theme settings.
 * 
 * @return void
 */
function starter_child_admin_menu() {
    // Add theme settings page
    osc_add_admin_submenu_page(
        'appearance',
        __('Starter Child Settings', 'starter_child'),
        osc_admin_render_theme_url('admin/settings.php'),
        'starter_child_settings'
    );
}
osc_add_hook('admin_menu', 'starter_child_admin_menu', 10);

// ============================================================================
// TRANSLATION SUPPORT
// ============================================================================

/**
 * Load theme text domain
 * 
 * Loads translation files for internationalization support.
 * Translation files should be placed in the languages directory.
 * 
 * @return void
 */
function starter_child_load_textdomain() {
    $locale = osc_current_user_locale();
    $mo_file = STARTER_CHILD_THEME_PATH . 'languages/' . $locale . '.mo';
    
    if (file_exists($mo_file)) {
        load_textdomain('starter_child', $mo_file);
    }
}
osc_add_hook('init', 'starter_child_load_textdomain', 5);

// ============================================================================
// HELPER UTILITIES
// ============================================================================

/**
 * Log debug information
 * 
 * Helper function for debugging during development.
 * Only logs when debug mode is enabled.
 * 
 * @param mixed  $data    Data to log
 * @param string $label   Optional label for the log entry
 * @return void
 */
function starter_child_debug_log($data, $label = '') {
    if (defined('OSC_DEBUG') && OSC_DEBUG === true) {
        $log_message = '[Starter Child] ';
        if ($label) {
            $log_message .= $label . ': ';
        }
        $log_message .= print_r($data, true);
        error_log($log_message);
    }
}

/**
 * Check if parent theme is active
 * 
 * Verifies that the required parent theme (Starter) is available.
 * 
 * @return bool True if parent theme is active
 */
function starter_child_check_parent_theme() {
    $current_theme = osc_current_web_theme();
    $parent_theme = 'starter';
    
    // If we're using the child theme, the parent must exist
    if ($current_theme === 'starter_child') {
        $parent_path = osc_themes_path() . $parent_theme . '/';
        return file_exists($parent_path . 'index.php');
    }
    
    return true;
}

// ============================================================================
// THEME ACTIVATION/DEACTIVATION
// ============================================================================

/**
 * Theme activation hook
 * 
 * Runs when the child theme is activated.
 * Sets up default options and performs any necessary initialization.
 * 
 * @return void
 */
function starter_child_activate() {
    // Set default theme options
    starter_child_set_option('theme_version', STARTER_CHILD_VERSION, 'STRING');
    starter_child_set_option('first_activation', date('Y-m-d H:i:s'), 'STRING');
    
    // Check if parent theme exists
    if (!starter_child_check_parent_theme()) {
        osc_add_flash_warning_message(
            __('Warning: The Starter parent theme is required for this child theme to work properly.', 'starter_child')
        );
    }
}
osc_add_hook('theme_activate', 'starter_child_activate', 10);

// ============================================================================
// CLEANUP AND OPTIMIZATION
// ============================================================================

/**
 * Clean up head section
 * 
 * Remove unnecessary elements from the HTML head for cleaner output.
 * This is a placeholder for head cleanup operations.
 * 
 * @return void
 */
function starter_child_cleanup_head() {
    // Add head cleanup code here if needed
}
osc_add_hook('header', 'starter_child_cleanup_head', 5);

/**
 * Optimize performance
 * 
 * Placeholder for performance optimization hooks.
 * Example: Lazy loading, asset minification, etc.
 * 
 * @return void
 */
function starter_child_optimize_performance() {
    // Add performance optimization code here
}
osc_add_hook('init', 'starter_child_optimize_performance', 20);

// ============================================================================
// END OF FUNCTIONS
// ============================================================================

// Include additional function files if needed
// Example:
// if (file_exists(STARTER_CHILD_THEME_PATH . 'includes/custom-functions.php')) {
//     require_once STARTER_CHILD_THEME_PATH . 'includes/custom-functions.php';
// }
