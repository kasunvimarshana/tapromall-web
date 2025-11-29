# TaproMall Developer Guide

This guide provides comprehensive documentation for developers working with TaproMall, a multi-classified, multi-tenant, multi-vendor marketplace application built on the Osclass framework.

## Table of Contents

1. [Helper Functions](#helper-functions)
2. [Programming Standards](#programming-standards)
3. [Theme Customization](#theme-customization)
4. [Hooks and Filters](#hooks-and-filters)
5. [Plugin System](#plugin-system)
6. [Query Items](#query-items)
7. [Child Themes](#child-themes)
8. [Advanced Configuration](#advanced-configuration)

---

## Helper Functions

TaproMall includes a comprehensive set of helper functions located in `oc-includes/osclass/helpers/`. These functions simplify common development tasks.

### Item Helpers (`hItems.php`)

```php
// Get item data by ID
$item = osc_get_item_row($item_id);

// Get current item in loop
$item = osc_item();

// Get item URL by ID
$url = osc_item_url_by_id($item_id);

// Get item title
$title = osc_item_title();

// Get item description
$description = osc_item_description();

// Get item price
$price = osc_item_price();

// Get item category
$category = osc_item_category();

// Get item location
$country = osc_item_country();
$region = osc_item_region();
$city = osc_item_city();
```

### User Helpers (`hUsers.php`)

```php
// Check if user is logged in
if (osc_is_web_user_logged_in()) {
    // User is logged in
}

// Get logged user ID
$user_id = osc_logged_user_id();

// Get logged user email
$email = osc_logged_user_email();

// Get logged user name
$name = osc_logged_user_name();

// Get user data by ID
$user = osc_get_user_row($user_id);

// Check if user is online
$is_online = osc_user_is_online($user_id);
```

### Category Helpers (`hCategories.php`)

```php
// Get category data by ID
$category = osc_get_category_row($category_id);

// Get all categories
$categories = osc_get_categories();

// Get category name
$name = osc_category_name();

// Get category description
$description = osc_category_description();

// Get category URL
$url = osc_category_url();
```

### Location Helpers (`hLocation.php`)

```php
// Get country data
$country = osc_get_country_row($country_code);

// Get region data
$region = osc_get_region_row($region_id);

// Get city data
$city = osc_get_city_row($city_id);

// Get all countries
$countries = Country::newInstance()->listAll();

// Get regions by country
$regions = Region::newInstance()->findByCountry($country_code);
```

### Utility Helpers (`hUtils.php`)

```php
// Get current URL
$url = osc_get_current_url();

// Get base URL
$base_url = osc_base_url();

// Get admin base URL
$admin_url = osc_admin_base_url();

// Redirect to URL
osc_redirect_to($url);

// Get IP address
$ip = osc_get_ip();

// Format price
$formatted = osc_format_price($price);
```

### Security Helpers (`hSecurity.php`)

```php
// Generate CSRF token
$token = osc_csrf_token_url();

// Check CSRF token
osc_csrf_check();

// Escape HTML
$safe = osc_esc_html($string);

// Escape JavaScript
$safe = osc_esc_js($string);
```

---

## Programming Standards

Follow these PHP coding standards when developing for TaproMall.

### Naming Conventions

- **Functions**: Use lowercase with underscores, prefixed with `osc_`
  ```php
  function osc_get_item_title() { }
  ```

- **Classes**: Use PascalCase
  ```php
  class ItemActions { }
  ```

- **Variables**: Use camelCase
  ```php
  $itemTitle = 'My Item';
  ```

- **Constants**: Use uppercase with underscores
  ```php
  define('WEB_PATH', '/var/www/html');
  ```

### File Organization

```
oc-includes/
├── osclass/
│   ├── classes/        # Core classes
│   ├── controller/     # Controllers
│   ├── core/           # Core framework
│   ├── frm/            # Form classes
│   ├── helpers/        # Helper functions
│   ├── model/          # Database models
│   └── gui/            # Default templates
```

### Code Documentation

Use PHPDoc blocks for all functions and classes:

```php
/**
 * Gets the item title
 *
 * @param string $locale Optional locale code
 * @return string The item title
 */
function osc_item_title($locale = '') {
    // Implementation
}
```

### Error Handling

```php
// Use try-catch for database operations
try {
    $result = Item::newInstance()->insert($data);
} catch (Exception $e) {
    osc_add_flash_error_message($e->getMessage());
}

// Use flash messages for user feedback
osc_add_flash_ok_message(__('Item saved successfully'));
osc_add_flash_error_message(__('Error saving item'));
osc_add_flash_warning_message(__('Please check your input'));
```

---

## Theme Customization

### Theme Structure

```
oc-content/themes/your-theme/
├── index.php           # Theme information
├── functions.php       # Theme functions
├── header.php          # Header template
├── footer.php          # Footer template
├── main.php            # Homepage template
├── item.php            # Item detail page
├── item-post.php       # Item publish form
├── item-edit.php       # Item edit form
├── search.php          # Search results page
├── search-list.php     # Search list view
├── search-gallery.php  # Search gallery view
├── user-dashboard.php  # User dashboard
├── user-profile.php    # User profile
├── page.php            # Static pages
├── contact.php         # Contact form
├── login.php           # Login page
├── css/                # Stylesheets
├── js/                 # JavaScript files
└── images/             # Theme images
```

### Theme Information File (`index.php`)

```php
<?php
/*
  Theme Name: Your Theme Name
  Theme URI: https://your-website.com
  Description: A beautiful theme for TaproMall
  Version: 1.0.0
  Author: Your Name
  Author URI: https://your-website.com
  Widgets: header, footer, sidebar
*/
```

### Adding Custom CSS

In your theme's `functions.php`:

```php
// Register custom stylesheet
osc_register_style('custom-style', osc_current_web_theme_url('css/custom.css'));

// Enqueue the stylesheet
osc_enqueue_style('custom-style');
```

### Adding Custom JavaScript

```php
// Register custom script
osc_register_script('custom-script', osc_current_web_theme_url('js/custom.js'), array('jquery'));

// Enqueue the script
osc_enqueue_script('custom-script');
```

### Template Tags

```php
<!-- Header and Footer -->
<?php osc_current_web_theme_path('header.php'); ?>
<?php osc_current_web_theme_path('footer.php'); ?>

<!-- Theme URLs -->
<?php echo osc_current_web_theme_url(); ?>
<?php echo osc_current_web_theme_url('images/logo.png'); ?>

<!-- Page Information -->
<?php echo osc_page_title(); ?>
<?php echo osc_page_description(); ?>
```

---

## Hooks and Filters

### Understanding Hooks

Hooks allow you to execute custom code at specific points during TaproMall execution.

### Adding a Hook

```php
// Add a function to a hook
osc_add_hook('hook_name', 'your_function_name');

// Example: Add custom content after item description
osc_add_hook('item_detail', 'add_custom_item_content');
function add_custom_item_content() {
    echo '<div class="custom-content">Additional Information</div>';
}
```

### Removing a Hook

```php
osc_remove_hook('hook_name', 'function_to_remove');
```

### Common Hooks

#### Front-end Hooks

| Hook Name | Description |
|-----------|-------------|
| `header` | After opening `<head>` tag |
| `footer` | Before closing `</body>` tag |
| `item_detail` | After item detail |
| `item_form` | In item publish/edit form |
| `item_form_post` | After item form submission |
| `search_form` | In search form |
| `user_form` | In user registration form |
| `user_register_completed` | After user registration |
| `user_login` | After user login |
| `contact_form` | In contact form |

#### Admin Hooks

| Hook Name | Description |
|-----------|-------------|
| `admin_header` | Admin panel header |
| `admin_footer` | Admin panel footer |
| `admin_menu_init` | When initializing admin menu |
| `admin_item_edit` | In admin item edit form |
| `admin_user_form` | In admin user form |

### Using Filters

Filters modify content before it's displayed.

```php
// Add a filter
osc_add_filter('filter_name', 'your_filter_function');

// Example: Modify item title
osc_add_filter('item_title', 'custom_item_title');
function custom_item_title($title) {
    return strtoupper($title);
}

// Apply a filter
$filtered_content = osc_apply_filter('filter_name', $content);
```

### Common Filters

| Filter Name | Description |
|-------------|-------------|
| `item_title` | Modify item title |
| `item_description` | Modify item description |
| `item_price` | Modify item price display |
| `meta_title` | Modify page meta title |
| `meta_description` | Modify page meta description |
| `search_pattern` | Modify search query |
| `pre_item_add_error` | Validate before item add |

---

## Plugin System

### Plugin Structure

```
oc-content/plugins/your-plugin/
├── index.php           # Plugin information and main file
├── functions.php       # Plugin functions (optional)
├── admin/              # Admin interface files
│   └── configure.php   # Plugin configuration page
├── views/              # Plugin views
├── languages/          # Translation files
└── assets/             # CSS/JS/images
```

### Plugin Information File (`index.php`)

```php
<?php
/*
  Plugin Name: Your Plugin Name
  Plugin URI: https://your-website.com
  Description: A useful plugin for TaproMall
  Version: 1.0.0
  Author: Your Name
  Author URI: https://your-website.com
  Short Name: your-plugin
  Plugin update URI: https://your-website.com/updates
*/

// Plugin installation
function your_plugin_install() {
    // Create database tables, set default options, etc.
}

// Plugin uninstallation
function your_plugin_uninstall() {
    // Remove database tables, clean up, etc.
}

// Register plugin
osc_register_plugin(osc_plugin_path(__FILE__), 'your_plugin_install');
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'your_plugin_uninstall');

// Add hooks
osc_add_hook('header', 'your_plugin_header_function');
```

### Plugin Helper Functions

```php
// Get plugin info
$info = osc_plugin_get_info('your-plugin/index.php');

// Check if plugin is installed
if (osc_plugin_is_installed('your-plugin/index.php')) {
    // Plugin is installed
}

// Check if plugin is enabled
if (osc_plugin_is_enabled('your-plugin/index.php')) {
    // Plugin is enabled
}

// Get plugin resource URL
$url = osc_plugin_resource('your-plugin/assets/style.css');

// Get plugin configuration URL
$config_url = osc_plugin_configure_url('your-plugin/index.php');
```

### Adding Admin Menu Item

```php
osc_add_hook('admin_menu_init', 'your_plugin_admin_menu');
function your_plugin_admin_menu() {
    osc_add_admin_submenu_page(
        'plugins',                              // Parent menu
        __('Your Plugin', 'your-plugin'),       // Menu title
        osc_admin_render_plugin_url('your-plugin/admin/configure.php'),  // URL
        'your-plugin-configure',                // Menu ID
        'moderator'                             // Required permission
    );
}
```

### Saving Plugin Settings

```php
// Save a preference
osc_set_preference('setting_name', 'setting_value', 'your-plugin');

// Get a preference
$value = osc_get_preference('setting_name', 'your-plugin');

// Delete a preference
osc_delete_preference('setting_name', 'your-plugin');
```

---

## Query Items

The `osc_query_item()` function is a powerful way to retrieve and display items.

### Basic Usage

```php
// Get latest items
osc_query_item(array(
    'num_items' => 10
));

// Loop through items
while (osc_has_items()) {
    echo osc_item_title();
    echo osc_item_description();
    echo osc_item_price();
}
```

### Query Parameters

```php
osc_query_item(array(
    // Number of items
    'num_items' => 10,
    
    // Category filter
    'category' => $category_id,
    'category_slug' => 'category-slug',
    
    // Location filters
    'country' => 'US',
    'region' => $region_id,
    'city' => $city_id,
    
    // User filter
    'user' => $user_id,
    
    // Price range
    'price_min' => 100,
    'price_max' => 1000,
    
    // Sorting
    'order_by' => 'dt_pub_date',    // dt_pub_date, i_price, s_title
    'order' => 'DESC',               // ASC, DESC
    
    // Premium items only
    'premium' => true,
    
    // With pictures only
    'pictures_only' => true,
    
    // Pagination
    'page' => 1,
    
    // Search pattern
    'pattern' => 'search keywords'
));
```

### Getting Specific Items

```php
// Get premium items
osc_get_premiums(5);  // Get 5 premium items

while (osc_has_premiums()) {
    echo osc_premium_title();
    echo osc_premium_url();
}

// Get latest items
osc_get_latest_items(10);

while (osc_has_latest_items()) {
    echo osc_latest_item_title();
}
```

### Custom Queries

```php
// Using the Search class directly
$search = new Search();
$search->addCategory($category_id);
$search->addRegion($region_id);
$search->priceRange($min, $max);
$search->limit(0, 10);
$items = $search->doSearch();
```

---

## Child Themes

Child themes allow you to customize a parent theme without modifying its core files.

### Creating a Child Theme

1. Create a new folder in `oc-content/themes/`:
   ```
   oc-content/themes/your-child-theme/
   ```

2. Create the `index.php` file:
   ```php
   <?php
   /*
     Theme Name: Your Child Theme
     Theme URI: https://your-website.com
     Description: Child theme of Sigma
     Version: 1.0.0
     Author: Your Name
     Author URI: https://your-website.com
     Parent Theme: sigma
   */
   ```

3. Create `functions_child.php` for custom functions:
   ```php
   <?php
   // Custom functions for child theme
   
   function child_theme_custom_function() {
       // Your custom code
   }
   osc_add_hook('header', 'child_theme_custom_function');
   ```

### Overriding Template Files

Copy any file from the parent theme to your child theme folder to override it:

```
oc-content/themes/your-child-theme/
├── index.php           # Required
├── functions_child.php # Optional, extends parent functions.php
├── header.php          # Overrides parent header.php
├── footer.php          # Overrides parent footer.php
└── css/
    └── custom.css      # Additional styles
```

### Child Theme Best Practices

1. **Only override necessary files** - Copy only the files you need to modify
2. **Use `functions_child.php`** - For adding custom functions without modifying parent
3. **Enqueue styles properly** - Use hooks to add custom stylesheets
4. **Keep parent theme updated** - Child themes allow safe parent theme updates

---

## Advanced Configuration

### Configuration File (`config.php`)

Create `config.php` from `config-sample.php` and customize:

```php
<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'username');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'database_name');
define('DB_TABLE_PREFIX', 'oc_');

// URLs
define('REL_WEB_URL', '/');
define('WEB_PATH', 'https://your-domain.com');

// Debug options (disable in production)
define('OSC_DEBUG', false);
define('OSC_DEBUG_DB', false);
define('OSC_DEBUG_LOG', false);

// Cache configuration
define('OSC_CACHE', 'memcached');  // memcache, memcached, redis, apc, apcu
define('OSC_CACHE_TTL', 60);

// Admin folder (rename for security)
define('OC_ADMIN_FOLDER', 'oc-admin');

// Memory limit
define('OSC_MEMORY_LIMIT', '256M');
```

### Database Models

TaproMall uses the DAO (Data Access Object) pattern:

```php
// Get an item
$item = Item::newInstance()->findByPrimaryKey($id);

// Insert a new item
$item_id = Item::newInstance()->insert(array(
    'fk_i_user_id' => $user_id,
    'fk_i_category_id' => $category_id,
    's_contact_name' => $name,
    's_contact_email' => $email
));

// Update an item
Item::newInstance()->update(
    array('s_contact_name' => $new_name),
    array('pk_i_id' => $item_id)
);

// Delete an item
Item::newInstance()->delete(array('pk_i_id' => $item_id));

// Custom query
$items = Item::newInstance()->listWhere('fk_i_category_id = %d', $category_id);
```

### Cron Jobs

TaproMall supports automated tasks through cron:

```bash
# Run all cron types
* * * * * php /path/to/index.php -p cron -t minutely
0 * * * * php /path/to/index.php -p cron -t hourly
0 0 * * * php /path/to/index.php -p cron -t daily
0 0 * * 0 php /path/to/index.php -p cron -t weekly
0 0 1 * * php /path/to/index.php -p cron -t monthly
0 0 1 1 * php /path/to/index.php -p cron -t yearly
```

Or via URL (for auto-cron):
```
https://your-domain.com/index.php?page=cron&type=daily
```

### Email Configuration

Configure SMTP in the admin panel or via config:

```php
// In your plugin or functions.php
osc_add_hook('pre_send_email', 'custom_email_settings');
function custom_email_settings() {
    // Custom email handling
}
```

---

## Additional Resources

- **Osclass Documentation**: https://docs.osclass-classifieds.com/
- **Osclass Forums**: https://forums.osclass-classifieds.com/
- **GitHub Repository**: https://github.com/mindstellar/Osclass

---

## Support

For TaproMall specific questions, please refer to the project's issue tracker or documentation.
