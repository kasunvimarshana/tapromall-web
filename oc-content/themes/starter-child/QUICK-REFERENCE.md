# Quick Reference Guide

Quick reference for common operations and code snippets in the Starter Child Theme.

## Table of Contents

- [File Structure](#file-structure)
- [Common Functions](#common-functions)
- [Code Snippets](#code-snippets)
- [Hooks Reference](#hooks-reference)
- [Configuration](#configuration)
- [Troubleshooting](#troubleshooting)

## File Structure

```
starter-child/
├── index.php              # Theme metadata
├── functions.php          # Core initialization
├── custom.php            # Custom entry point
├── assets/
│   ├── css/
│   │   ├── style.css     # Main styles
│   │   └── custom.css    # Custom styles
│   ├── js/
│   │   └── custom.js     # Custom JavaScript
│   └── images/           # Theme images
├── includes/
│   ├── config.php        # Configuration
│   ├── helpers.php       # Utility functions
│   ├── hooks.php         # Custom hooks
│   └── widgets.php       # Custom widgets
├── templates/            # Template overrides
├── languages/            # Translations
└── admin/               # Admin customizations
```

## Common Functions

### Asset Management

```php
// Get asset URL
$url = starter_child_asset('images/logo.png');
// Returns: http://site.com/themes/starter-child/assets/images/logo.png

// Get asset with subfolder
$css_url = starter_child_asset('css/custom.css');
```

### Template Management

```php
// Include template
starter_child_include_template('header.php', array(
    'title' => 'Page Title',
    'subtitle' => 'Subtitle'
));

// Get template path
$path = starter_child_template_path('footer.php');

// Check if template exists
if (file_exists($path)) {
    include $path;
}
```

### Configuration

```php
// Get config value
$primary_color = starter_child_config('colors.primary');
$feature = starter_child_config('features.responsive', true);

// Check if feature enabled
if (starter_child_has_feature('custom_widgets')) {
    // Feature is enabled
}

// Check dev mode
if (Starter_Child_Config::is_dev_mode()) {
    // Development mode
}
```

### Theme Options

```php
// Get theme option
$value = starter_child_get_option('custom_setting', 'default');

// Set theme option
starter_child_set_option('custom_setting', 'new_value');

// Get multiple options
$facebook = starter_child_get_option('social_facebook', '');
$twitter = starter_child_get_option('social_twitter', '');
```

### Logging & Debug

```php
// Log message
starter_child_log('Debug message', 'info');
starter_child_log('Warning message', 'warning');
starter_child_log($array_data, 'debug');

// Check debug mode
if (starter_child_is_debug()) {
    // Debug code
}
```

### Data Handling

```php
// Sanitize output
$safe_output = starter_child_sanitize($user_input);

// Format price
$formatted = starter_child_format_price(99.99);

// Render icon
starter_child_render_icon('heart', 'custom-class');

// Responsive image
echo starter_child_responsive_image($src, $alt, array(
    '1x' => $url_1x,
    '2x' => $url_2x
));
```

## Code Snippets

### Adding Custom CSS

```css
/* assets/css/custom.css */

/* Use CSS variables */
.custom-element {
    color: var(--child-primary-color);
    padding: var(--child-spacing-md);
    border-radius: var(--child-border-radius);
}

/* Override parent styles */
.parent-class {
    /* Your overrides */
}
```

### Adding Custom JavaScript

```javascript
// assets/js/custom.js

(function($) {
    'use strict';
    
    // Add your custom code to StarterChild object
    StarterChild.customFunction = function() {
        console.log('Custom function');
    };
    
    // Initialize on document ready
    $(document).ready(function() {
        StarterChild.customFunction();
    });
    
})(jQuery);
```

### Adding a Hook

```php
// includes/hooks.php

// Add content to header
function starter_child_custom_header() {
    echo '<div class="custom-header-content">Custom Header</div>';
}
osc_add_hook('header', 'starter_child_custom_header');

// Filter page title
function starter_child_custom_title($title) {
    return $title . ' | Site Name';
}
osc_add_filter('page_title', 'starter_child_custom_title');
```

### Creating a Helper Function

```php
// includes/helpers.php

/**
 * Get user avatar
 */
function starter_child_get_avatar($user_id, $size = 50) {
    $user = osc_user_info($user_id);
    $name = $user['s_name'];
    
    // Return Gravatar or default
    return 'https://www.gravatar.com/avatar/' . 
           md5(strtolower($user['s_email'])) . 
           '?s=' . $size;
}
```

### Creating a Widget

```php
// includes/widgets.php

function starter_child_social_widget() {
    $facebook = starter_child_get_option('social_facebook');
    
    if (!empty($facebook)) {
        ?>
        <div class="child-social-widget">
            <h3><?php _e('Follow Us', 'starter-child'); ?></h3>
            <a href="<?php echo esc_url($facebook); ?>">
                <i class="fa fa-facebook"></i>
            </a>
        </div>
        <?php
    }
}

// Register widget
osc_register_widget('social_widget', 'starter_child_social_widget');
```

### Overriding a Template

```php
// templates/custom-header.php

<?php
/**
 * Custom Header Template
 */
?>
<header class="child-custom-header">
    <div class="container">
        <h1><?php echo starter_child_sanitize($title); ?></h1>
    </div>
</header>
```

### Adding Configuration

```php
// includes/config.php

// Add to $settings array in init() method
'custom_section' => array(
    'option1' => 'value1',
    'option2' => 'value2',
),

// Use in code
$value = starter_child_config('custom_section.option1');
```

## Hooks Reference

### Common Osclass Hooks

```php
// Header hooks
osc_add_hook('header');                    // After opening <head>
osc_add_hook('before_html');              // Before <html>
osc_add_hook('after_html');               // After </html>

// Body hooks
osc_add_hook('before_body');              // After <body>
osc_add_hook('after_body');               // Before </body>

// Content hooks
osc_add_hook('item_detail');              // Item detail page
osc_add_hook('search_results');           // Search results
osc_add_hook('user_dashboard');           // User dashboard

// Footer hooks
osc_add_hook('footer');                   // In footer
osc_add_hook('before_footer');            // Before footer
osc_add_hook('after_footer');             // After footer
```

### Common Osclass Filters

```php
// Title filters
osc_add_filter('page_title', $callback);
osc_add_filter('meta_title', $callback);

// Content filters
osc_add_filter('item_description', $callback);
osc_add_filter('search_pattern', $callback);

// URL filters
osc_add_filter('item_url', $callback);
osc_add_filter('user_url', $callback);
```

### Custom Child Theme Hooks

```php
// Add custom hooks in your code
do_action('starter_child_before_content');
do_action('starter_child_after_content');

// Then implement elsewhere
osc_add_hook('starter_child_before_content', 'my_function');
```

## Configuration

### CSS Variables

Available in `assets/css/style.css`:

```css
:root {
    --child-primary-color: #3498db;
    --child-secondary-color: #2ecc71;
    --child-accent-color: #e74c3c;
    --child-text-color: #333333;
    --child-background-color: #ffffff;
    
    --child-spacing-xs: 0.25rem;
    --child-spacing-sm: 0.5rem;
    --child-spacing-md: 1rem;
    --child-spacing-lg: 1.5rem;
    --child-spacing-xl: 2rem;
    
    --child-border-radius: 4px;
    --child-transition: all 0.3s ease;
}
```

### PHP Constants

Available throughout theme:

```php
STARTER_CHILD_THEME_VERSION    // Theme version
STARTER_CHILD_THEME_PATH       // Absolute file path
STARTER_CHILD_THEME_URL        // Theme URL
```

### Configuration Options

In `includes/config.php`:

```php
// Theme info
starter_child_config('theme_name')
starter_child_config('theme_version')

// Features
starter_child_config('features.responsive')
starter_child_config('features.rtl_support')

// Colors
starter_child_config('colors.primary')
starter_child_config('colors.secondary')

// Layout
starter_child_config('layout.container_width')
starter_child_config('layout.sidebar_width')
```

## Troubleshooting

### Theme Not Loading

**Problem**: Child theme doesn't appear in admin

**Solution**:
- Check `index.php` exists and has theme metadata
- Verify parent theme is installed
- Check file permissions

### Styles Not Loading

**Problem**: CSS changes not appearing

**Solution**:
```php
// Clear cache
// Check browser cache (Ctrl+F5)
// Verify file path in functions.php

osc_enqueue_style(
    'child-style',
    STARTER_CHILD_THEME_URL . 'assets/css/style.css',
    array('parent-style'),
    time() // Force reload for testing
);
```

### JavaScript Errors

**Problem**: JavaScript not working

**Solution**:
```javascript
// Check browser console for errors
// Verify jQuery is loaded
// Check scope (use jQuery not $)

(function($) {
    // Your code
})(jQuery);
```

### Hooks Not Firing

**Problem**: Custom hook not executing

**Solution**:
```php
// Verify hook name is correct
// Check if function is defined
// Ensure priority is appropriate

osc_add_hook('hook_name', 'function_name', 10);

// Debug
function test_hook() {
    error_log('Hook fired!');
}
osc_add_hook('hook_name', 'test_hook');
```

### Template Not Overriding

**Problem**: Template override not working

**Solution**:
- Verify file is in correct location
- Check file naming matches parent
- Clear Osclass cache
- Check template path resolution

### Configuration Not Loading

**Problem**: Config values not accessible

**Solution**:
```php
// Verify config.php is loaded
// Check if included in functions.php
// Use correct method

// NOT this
$value = STARTER_CHILD_CONFIG['key'];

// Use this
$value = starter_child_config('key');
```

### Performance Issues

**Problem**: Site is slow

**Solution**:
- Minify CSS/JS for production
- Optimize images
- Enable caching
- Limit database queries
- Use CDN for assets

## Development Tips

### Enable Debug Mode

```php
// In functions.php or wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('SCRIPT_DEBUG', true);
```

### Quick Testing

```php
// Add to functions.php temporarily
function test_function() {
    echo '<pre>';
    print_r(starter_child_config('all'));
    echo '</pre>';
}
osc_add_hook('header', 'test_function');
```

### Version Control

```bash
# Track only source files
git add assets/css/*.css
git add assets/js/*.js
git add includes/*.php

# Ignore compiled/generated files
# See .gitignore
```

## Additional Resources

- [Full Documentation](README.md)
- [Development Guide](DEVELOPMENT.md)
- [Architecture Details](ARCHITECTURE.md)
- [Changelog](CHANGELOG.md)
- [Osclass Docs](https://docs.osclass-classifieds.com/)

---

**Need Help?**
- Check inline code comments
- Review example implementations
- Consult Osclass documentation
- Check parent theme documentation
