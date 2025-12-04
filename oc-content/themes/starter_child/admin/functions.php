<?php
/**
 * Starter Child Theme Admin Functions
 * 
 * This file contains admin-specific functionality for the child theme.
 * Functions here are only loaded in the admin panel.
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
 * Enqueue admin styles
 * 
 * Loads custom CSS for the admin panel settings page.
 * 
 * @return void
 */
function starter_child_admin_styles() {
    // Only load on our settings page
    if (Params::getParam('page') === 'appearance' && 
        Params::getParam('file') === 'admin/settings.php') {
        
        osc_enqueue_style(
            'starter-child-admin',
            osc_current_web_theme_url('admin/css/admin.css'),
            array(),
            STARTER_CHILD_VERSION
        );
    }
}
osc_add_hook('admin_header', 'starter_child_admin_styles', 10);

/**
 * Enqueue admin scripts
 * 
 * Loads custom JavaScript for the admin panel.
 * 
 * @return void
 */
function starter_child_admin_scripts() {
    // Only load on our settings page
    if (Params::getParam('page') === 'appearance' && 
        Params::getParam('file') === 'admin/settings.php') {
        
        osc_enqueue_script(
            'starter-child-admin',
            osc_current_web_theme_url('admin/js/admin.js'),
            array('jquery'),
            STARTER_CHILD_VERSION
        );
    }
}
osc_add_hook('admin_header', 'starter_child_admin_scripts', 10);

/**
 * Add theme configuration link to appearance menu
 * 
 * This function is already handled in functions.php via starter_child_admin_menu(),
 * but additional admin menu items can be added here if needed.
 * 
 * @return void
 */
function starter_child_additional_admin_menus() {
    // Add additional menu items here if needed
}
osc_add_hook('admin_menu', 'starter_child_additional_admin_menus', 20);

/**
 * Display admin notices
 * 
 * Shows important notices to administrators in the admin panel.
 * 
 * @return void
 */
function starter_child_admin_notices() {
    // Check if parent theme exists
    if (!starter_child_check_parent_theme()) {
        ?>
        <div class="flashmessage flashmessage-error">
            <p>
                <strong><?php _e('Warning:', 'starter_child'); ?></strong>
                <?php _e('The Starter parent theme is required for this child theme to work properly. Please install and activate the Starter theme first.', 'starter_child'); ?>
            </p>
        </div>
        <?php
    }
    
    // Check for outdated version
    $current_version = starter_child_get_option('theme_version', '0.0.0');
    if (version_compare($current_version, STARTER_CHILD_VERSION, '<')) {
        ?>
        <div class="flashmessage flashmessage-info">
            <p>
                <strong><?php _e('Notice:', 'starter_child'); ?></strong>
                <?php _e('Theme has been updated. Please check the documentation for any changes.', 'starter_child'); ?>
            </p>
        </div>
        <?php
        
        // Update version number
        starter_child_set_option('theme_version', STARTER_CHILD_VERSION, 'STRING');
    }
}
osc_add_hook('admin_page_header', 'starter_child_admin_notices', 10);

/**
 * Add custom CSS to admin head
 * 
 * Injects custom CSS from settings into the admin head section.
 * Note: CSS is sanitized to prevent malicious code injection.
 * 
 * @return void
 */
function starter_child_inject_custom_css() {
    $custom_css = starter_child_get_option('custom_css', '');
    $enable_custom_styles = starter_child_get_option('enable_custom_styles', '1');
    
    if ($enable_custom_styles === '1' && !empty($custom_css)) {
        // Sanitize CSS to prevent XSS attacks
        // Remove any <script> tags or javascript: protocols
        $custom_css = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $custom_css);
        $custom_css = str_replace('javascript:', '', $custom_css);
        $custom_css = str_replace('expression(', '', $custom_css); // IE specific
        
        echo '<style type="text/css">' . "\n";
        echo '/* Starter Child Custom CSS */' . "\n";
        echo wp_strip_all_tags($custom_css, true) . "\n";
        echo '</style>' . "\n";
    }
}
osc_add_hook('header', 'starter_child_inject_custom_css', 100);

/**
 * Add custom JavaScript to footer
 * 
 * Injects custom JavaScript from settings into the page footer.
 * IMPORTANT: This is a potential security risk. Consider limiting access
 * to this feature to trusted administrators only.
 * 
 * @return void
 */
function starter_child_inject_custom_js() {
    $custom_js = starter_child_get_option('custom_js', '');
    $enable_custom_scripts = starter_child_get_option('enable_custom_scripts', '1');
    $debug_mode = starter_child_get_option('debug_mode', '0');
    
    // Only allow for admin users to prevent XSS attacks
    if (!osc_is_admin_user_logged_in()) {
        return;
    }
    
    if ($enable_custom_scripts === '1' && !empty($custom_js)) {
        // Sanitize JavaScript - remove any HTML tags
        $custom_js = wp_strip_all_tags($custom_js);
        
        // Additional safety: Escape the JavaScript content
        $custom_js = osc_esc_js($custom_js);
        
        echo '<script type="text/javascript">' . "\n";
        echo '/* Starter Child Custom JavaScript */' . "\n";
        
        if ($debug_mode === '1') {
            echo 'console.log("Starter Child: Loading custom JavaScript");' . "\n";
        }
        
        // Output within a try-catch to prevent breaking the page
        echo 'try {' . "\n";
        echo $custom_js . "\n";
        echo '} catch(e) {' . "\n";
        echo '    console.error("Starter Child: Error in custom JavaScript:", e);' . "\n";
        echo '}' . "\n";
        echo '</script>' . "\n";
    }
}
osc_add_hook('footer', 'starter_child_inject_custom_js', 100);

/**
 * Customize admin dashboard
 * 
 * Add custom widgets or information to the admin dashboard.
 * 
 * @return void
 */
function starter_child_dashboard_widget() {
    // Add custom dashboard widget here if needed
}
osc_add_hook('admin_dashboard_top', 'starter_child_dashboard_widget', 10);

/**
 * Export theme settings
 * 
 * Creates a JSON export of all theme settings.
 * 
 * @return array Theme settings as an array
 */
function starter_child_export_settings() {
    return array(
        'version' => STARTER_CHILD_VERSION,
        'enable_custom_styles' => starter_child_get_option('enable_custom_styles', '1'),
        'enable_custom_scripts' => starter_child_get_option('enable_custom_scripts', '1'),
        'custom_css' => starter_child_get_option('custom_css', ''),
        'custom_js' => starter_child_get_option('custom_js', ''),
        'debug_mode' => starter_child_get_option('debug_mode', '0'),
        'theme_version' => starter_child_get_option('theme_version', STARTER_CHILD_VERSION),
        'first_activation' => starter_child_get_option('first_activation', '')
    );
}

/**
 * Import theme settings
 * 
 * Imports theme settings from a JSON array.
 * 
 * @param array $settings Settings array to import
 * @return bool Whether the import was successful
 */
function starter_child_import_settings($settings) {
    if (!is_array($settings)) {
        return false;
    }
    
    $success = true;
    
    foreach ($settings as $key => $value) {
        if ($key !== 'version' && $key !== 'first_activation') {
            $type = is_bool($value) ? 'BOOLEAN' : 'STRING';
            if (!starter_child_set_option($key, $value, $type)) {
                $success = false;
            }
        }
    }
    
    return $success;
}

/**
 * Reset theme settings to defaults
 * 
 * Resets all theme settings to their default values.
 * 
 * @return bool Whether the reset was successful
 */
function starter_child_reset_settings() {
    $defaults = array(
        'enable_custom_styles' => '1',
        'enable_custom_scripts' => '1',
        'custom_css' => '',
        'custom_js' => '',
        'debug_mode' => '0'
    );
    
    return starter_child_import_settings($defaults);
}

/**
 * Get theme statistics
 * 
 * Returns various statistics about the theme usage.
 * 
 * @return array Theme statistics
 */
function starter_child_get_statistics() {
    return array(
        'version' => STARTER_CHILD_VERSION,
        'installed_since' => starter_child_get_option('first_activation', 'Unknown'),
        'parent_theme_exists' => starter_child_check_parent_theme(),
        'custom_css_length' => strlen(starter_child_get_option('custom_css', '')),
        'custom_js_length' => strlen(starter_child_get_option('custom_js', '')),
        'debug_enabled' => starter_child_get_option('debug_mode', '0') === '1'
    );
}

// ============================================================================
// END OF ADMIN FUNCTIONS
// ============================================================================
