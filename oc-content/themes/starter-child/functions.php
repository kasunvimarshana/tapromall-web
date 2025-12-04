<?php
/**
 * Child Theme Functions
 * 
 * This file contains the core initialization and configuration for the child theme.
 * It follows clean architecture principles with clear separation of concerns.
 * 
 * @package     Starter_Child_Theme
 * @version     1.0.0
 * @author      TaproMall Development Team
 * @link        https://github.com/kasunvimarshana/tapromall-web
 */

// Prevent direct access
if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}

/**
 * Child theme version constant
 * Update this when making changes to maintain cache busting
 */
define('STARTER_CHILD_THEME_VERSION', '1.0.0');

/**
 * Child theme path constants for easy reference
 */
define('STARTER_CHILD_THEME_PATH', osc_base_path() . 'oc-content/themes/starter-child/');
define('STARTER_CHILD_THEME_URL', osc_base_url() . 'oc-content/themes/starter-child/');

/**
 * Theme Information
 * 
 * Provides metadata about the child theme
 * 
 * @return array Theme information
 */
function starter_child_theme_info() {
    return array(
        'name'        => 'Starter Child Theme',
        'version'     => STARTER_CHILD_THEME_VERSION,
        'description' => 'Clean child theme for Starter Osclass Theme',
        'author_name' => 'TaproMall Development Team',
        'author_url'  => 'https://github.com/kasunvimarshana/tapromall-web',
        'parent'      => 'starter',
        'locations'   => array('header', 'footer')
    );
}

/**
 * Initialize Child Theme
 * 
 * Sets up all theme functionality using hooks and filters
 * Follows the Single Responsibility Principle
 */
function starter_child_init() {
    // Enqueue parent theme styles
    starter_child_enqueue_parent_styles();
    
    // Enqueue child theme styles
    starter_child_enqueue_styles();
    
    // Enqueue child theme scripts
    starter_child_enqueue_scripts();
    
    // Initialize custom hooks
    starter_child_init_hooks();
}

/**
 * Enqueue Parent Theme Styles
 * 
 * Properly loads parent theme stylesheets
 * This is the recommended way to include parent styles in a child theme
 */
function starter_child_enqueue_parent_styles() {
    // Get parent theme path
    $parent_theme_path = osc_base_url() . 'oc-content/themes/starter/';
    
    // Enqueue parent theme main stylesheet
    osc_enqueue_style('parent-style', $parent_theme_path . 'css/style.css');
    
    // Enqueue parent responsive styles
    osc_enqueue_style('parent-responsive', $parent_theme_path . 'css/responsive.css');
}

/**
 * Enqueue Child Theme Styles
 * 
 * Loads child theme stylesheets with proper dependencies
 */
function starter_child_enqueue_styles() {
    // Main child theme stylesheet
    osc_enqueue_style(
        'child-style',
        STARTER_CHILD_THEME_URL . 'assets/css/style.css',
        array('parent-style'),
        STARTER_CHILD_THEME_VERSION
    );
    
    // Child theme custom styles
    osc_enqueue_style(
        'child-custom',
        STARTER_CHILD_THEME_URL . 'assets/css/custom.css',
        array('child-style'),
        STARTER_CHILD_THEME_VERSION
    );
}

/**
 * Enqueue Child Theme Scripts
 * 
 * Loads child theme JavaScript files with proper dependencies
 */
function starter_child_enqueue_scripts() {
    // Child theme custom JavaScript
    osc_enqueue_script(
        'child-custom-js',
        STARTER_CHILD_THEME_URL . 'assets/js/custom.js',
        array('jquery'),
        STARTER_CHILD_THEME_VERSION,
        true // Load in footer
    );
}

/**
 * Initialize Custom Hooks
 * 
 * Register all custom hooks and filters for the child theme
 * This is where you add hook-based customizations
 */
function starter_child_init_hooks() {
    // Example: Add custom header content
    // osc_add_hook('header', 'starter_child_custom_header');
    
    // Example: Modify footer content
    // osc_add_filter('footer_content', 'starter_child_custom_footer');
    
    // Add your custom hooks here
    // This keeps the main functions.php clean and organized
}

/**
 * Example Custom Header Function
 * 
 * This is a placeholder for custom header modifications
 * Uncomment and modify as needed
 */
// function starter_child_custom_header() {
//     // Custom header code here
// }

/**
 * Example Custom Footer Function
 * 
 * This is a placeholder for custom footer modifications
 * Uncomment and modify as needed
 */
// function starter_child_custom_footer($content) {
//     // Modify footer content
//     return $content;
// }

/**
 * Load Additional Modules
 * 
 * Include additional functionality modules
 * This follows the Single Responsibility Principle by separating concerns
 */
function starter_child_load_modules() {
    // Load configuration first
    if (file_exists(STARTER_CHILD_THEME_PATH . 'includes/config.php')) {
        require_once STARTER_CHILD_THEME_PATH . 'includes/config.php';
    }
    
    // Load custom helpers
    if (file_exists(STARTER_CHILD_THEME_PATH . 'includes/helpers.php')) {
        require_once STARTER_CHILD_THEME_PATH . 'includes/helpers.php';
    }
    
    // Load custom widgets
    if (file_exists(STARTER_CHILD_THEME_PATH . 'includes/widgets.php')) {
        require_once STARTER_CHILD_THEME_PATH . 'includes/widgets.php';
    }
    
    // Load custom hooks
    if (file_exists(STARTER_CHILD_THEME_PATH . 'includes/hooks.php')) {
        require_once STARTER_CHILD_THEME_PATH . 'includes/hooks.php';
    }
}

// Initialize child theme
add_action('init', 'starter_child_init');

// Load additional modules
starter_child_load_modules();
