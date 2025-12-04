<?php
/**
 * Theme Configuration
 * 
 * Central configuration file for child theme settings.
 * Define theme constants and configuration here.
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
 * Theme Configuration Class
 * 
 * Manages theme configuration and settings
 */
class Starter_Child_Config {
    
    /**
     * Theme Settings
     * 
     * @var array
     */
    private static $settings = array();
    
    /**
     * Initialize Configuration
     */
    public static function init() {
        self::$settings = array(
            // General Settings
            'theme_name'        => 'Starter Child Theme',
            'theme_slug'        => 'starter-child',
            'theme_version'     => STARTER_CHILD_THEME_VERSION,
            'text_domain'       => 'starter-child',
            
            // Parent Theme
            'parent_theme'      => 'starter',
            'parent_version'    => '1.5.1',
            
            // Features
            'features' => array(
                'responsive'        => true,
                'rtl_support'       => true,
                'custom_widgets'    => true,
                'custom_hooks'      => true,
                'translation_ready' => true,
            ),
            
            // Asset Settings
            'assets' => array(
                'css_minified'  => false, // Set to true for production
                'js_minified'   => false, // Set to true for production
                'version_hash'  => true,  // Append version to assets
            ),
            
            // Development Settings
            'development' => array(
                'debug_mode'    => false, // Enable debug output
                'log_errors'    => true,  // Log errors to file
                'show_queries'  => false, // Show database queries
            ),
            
            // Layout Settings
            'layout' => array(
                'container_width' => '1200px',
                'sidebar_width'   => '300px',
                'gutter'          => '20px',
            ),
            
            // Color Scheme
            'colors' => array(
                'primary'   => '#3498db',
                'secondary' => '#2ecc71',
                'accent'    => '#e74c3c',
                'text'      => '#333333',
                'background'=> '#ffffff',
            ),
            
            // Typography
            'typography' => array(
                'font_family'     => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                'heading_font'    => 'inherit',
                'base_font_size'  => '16px',
                'line_height'     => '1.6',
            ),
            
            // Widget Areas
            'widget_areas' => array(
                'header',
                'footer',
                // Add more widget areas as needed
            ),
            
            // Custom Post Types (if needed)
            'custom_post_types' => array(
                // Define custom post types here
            ),
            
            // Social Media
            'social_media' => array(
                'facebook'  => '',
                'twitter'   => '',
                'instagram' => '',
                'linkedin'  => '',
                // Add more platforms as needed
            ),
        );
    }
    
    /**
     * Get Setting
     * 
     * Retrieves a configuration setting
     * 
     * @param string $key Setting key (supports dot notation)
     * @param mixed $default Default value if setting doesn't exist
     * @return mixed Setting value or default
     */
    public static function get($key, $default = null) {
        if (empty(self::$settings)) {
            self::init();
        }
        
        // Support dot notation (e.g., 'colors.primary')
        $keys = explode('.', $key);
        $value = self::$settings;
        
        foreach ($keys as $k) {
            if (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }
        
        return $value;
    }
    
    /**
     * Set Setting
     * 
     * Sets a configuration setting
     * 
     * @param string $key Setting key
     * @param mixed $value Setting value
     */
    public static function set($key, $value) {
        if (empty(self::$settings)) {
            self::init();
        }
        
        self::$settings[$key] = $value;
    }
    
    /**
     * Get All Settings
     * 
     * Returns all configuration settings
     * 
     * @return array All settings
     */
    public static function all() {
        if (empty(self::$settings)) {
            self::init();
        }
        
        return self::$settings;
    }
    
    /**
     * Is Feature Enabled
     * 
     * Checks if a feature is enabled
     * 
     * @param string $feature Feature name
     * @return bool True if enabled
     */
    public static function is_feature_enabled($feature) {
        return self::get('features.' . $feature, false) === true;
    }
    
    /**
     * Is Development Mode
     * 
     * Checks if development mode is enabled
     * 
     * @return bool True if in development mode
     */
    public static function is_dev_mode() {
        return self::get('development.debug_mode', false) === true;
    }
    
    /**
     * Get Asset Version
     * 
     * Returns version string for asset versioning
     * 
     * @return string Version string
     */
    public static function get_asset_version() {
        if (self::get('assets.version_hash', true)) {
            return self::get('theme_version') . '-' . time();
        }
        
        return self::get('theme_version');
    }
}

// Initialize configuration
Starter_Child_Config::init();

/**
 * Helper function to get config value
 * 
 * @param string $key Config key
 * @param mixed $default Default value
 * @return mixed Config value
 */
function starter_child_config($key, $default = null) {
    return Starter_Child_Config::get($key, $default);
}

/**
 * Helper function to check if feature is enabled
 * 
 * @param string $feature Feature name
 * @return bool True if enabled
 */
function starter_child_has_feature($feature) {
    return Starter_Child_Config::is_feature_enabled($feature);
}
