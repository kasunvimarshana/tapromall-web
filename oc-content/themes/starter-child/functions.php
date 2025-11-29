<?php
/**
 * Starter Child Theme - Functions File
 *
 * This file contains all custom functions, hooks, and filters for the child theme.
 * Following Osclass best practices: use hooks over file overrides for better maintainability.
 *
 * @package StarterChild
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABS_PATH')) {
    exit('Direct access not allowed.');
}

/*
|--------------------------------------------------------------------------
| THEME CONSTANTS
|--------------------------------------------------------------------------
| Define child theme version and constants for easy reference throughout the theme.
*/
define('STARTER_CHILD_VERSION', '1.0.0');
define('STARTER_CHILD_PATH', dirname(__FILE__) . '/');
define('STARTER_CHILD_URL', osc_current_web_theme_url());

/*
|--------------------------------------------------------------------------
| THEME INFO
|--------------------------------------------------------------------------
| Return child theme information array for Osclass admin panel.
*/
if (!function_exists('starter_child_theme_info')) {
    /**
     * Returns child theme information.
     *
     * @return array Theme information array.
     */
    function starter_child_theme_info() {
        return array(
            'name'        => 'Starter Child Theme',
            'version'     => STARTER_CHILD_VERSION,
            'description' => 'A clean, modular child theme extending Starter with SOLID/DRY/KISS principles.',
            'author_name' => 'TaproMall Team',
            'author_url'  => 'https://github.com/kasunvimarshana/tapromall-web',
            'support_uri' => 'https://github.com/kasunvimarshana/tapromall-web/issues',
            'locations'   => array('header', 'footer', 'sidebar')
        );
    }
}

/*
|--------------------------------------------------------------------------
| LOAD MODULAR INCLUDES
|--------------------------------------------------------------------------
| Include modular functionality files for better code organization.
| Each file handles a single responsibility (SOLID - Single Responsibility).
*/
$child_includes = array(
    'includes/assets.php',      // Asset management (CSS/JS)
    'includes/hooks.php',       // Custom hooks and filters
    'includes/helpers.php',     // Helper functions
    'includes/widgets.php',     // Widget placeholders
);

foreach ($child_includes as $include) {
    $file = STARTER_CHILD_PATH . $include;
    if (file_exists($file)) {
        require_once $file;
    }
}

/*
|--------------------------------------------------------------------------
| THEME SETUP
|--------------------------------------------------------------------------
| Initialize the child theme after Osclass and parent theme are loaded.
*/
if (!function_exists('starter_child_setup')) {
    /**
     * Initialize child theme setup.
     * Runs after parent theme is fully loaded via the 'init' hook.
     *
     * @return void
     */
    function starter_child_setup() {
        // Child theme is ready - add any initialization code here
    }
    osc_add_hook('init', 'starter_child_setup');
}

/*
|--------------------------------------------------------------------------
| ADMIN MENU (Optional)
|--------------------------------------------------------------------------
| Add child theme settings menu in admin panel if needed.
*/
if (!function_exists('starter_child_admin_menu')) {
    /**
     * Register child theme admin menu.
     *
     * @return void
     */
    function starter_child_admin_menu() {
        $admin_config_url = osc_admin_render_theme_url(
            'oc-content/themes/' . osc_current_web_theme() . '/admin/configure.php'
        );
        
        // Uncomment below lines to add admin settings page
        // AdminMenu::newInstance()->add_submenu(
        //     'starter_menu',
        //     __('Child Theme Settings', 'starter-child'),
        //     $admin_config_url,
        //     'starter_child_settings'
        // );
    }
    osc_add_hook('init_admin', 'starter_child_admin_menu');
}

/*
|--------------------------------------------------------------------------
| THEME INSTALLATION
|--------------------------------------------------------------------------
| Handle child theme installation and preference setup.
*/
if (!function_exists('starter_child_install')) {
    /**
     * Install child theme preferences.
     *
     * @return void
     */
    function starter_child_install() {
        // Set default preferences
        osc_set_preference('child_version', STARTER_CHILD_VERSION, 'starter_child_theme');
        osc_set_preference('custom_css_enabled', '1', 'starter_child_theme');
        osc_set_preference('custom_js_enabled', '1', 'starter_child_theme');
        osc_reset_preferences();
    }
}

if (!function_exists('starter_child_check_install')) {
    /**
     * Check if child theme needs installation.
     *
     * @return void
     */
    function starter_child_check_install() {
        $installed_version = osc_get_preference('child_version', 'starter_child_theme');
        if (!$installed_version) {
            starter_child_install();
        }
    }
}

// Run installation check
starter_child_check_install();
