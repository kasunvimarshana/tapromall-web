# Starter Child Theme

A clean, modular child theme for Osclass that extends the Starter theme following best practices.

## Overview

This child theme provides an update-safe foundation for customizing the Starter theme. It supports:

- Template overrides
- Style overrides via CSS
- Hook-based modifications
- Plugin/widget placeholders
- Full internationalization (i18n) support

## Installation

1. Upload the `starter-child` folder to `oc-content/themes/`
2. Ensure the parent theme `starter` is also installed
3. Go to **oc-admin > Appearance > Themes**
4. Activate "Starter Child Theme"

## Directory Structure

```
starter-child/
├── index.php              # Theme metadata and parent reference
├── functions.php          # Main functions file
├── css/
│   ├── child-style.css       # Main child theme styles
│   └── child-responsive.css  # Responsive styles
├── js/
│   └── child-scripts.js      # Custom JavaScript
├── includes/
│   ├── assets.php            # Asset management (CSS/JS loading)
│   ├── hooks.php             # Custom hooks and filters
│   ├── helpers.php           # Helper functions
│   └── widgets.php           # Widget placeholders
├── templates/             # Template overrides (copy files here)
├── images/                # Child theme images
├── languages/             # Translation files
│   └── starter-child.pot     # POT template for translations
├── admin/
│   └── configure.php         # Admin settings page
└── README.md              # This file
```

## Customization Guide

### Adding Custom Styles

Edit `css/child-style.css` to add your custom styles. The file uses CSS custom properties (variables) for easy theming:

```css
:root {
    --child-primary-color: #2563eb;
    --child-secondary-color: #64748b;
}
```

### Adding Custom JavaScript

Edit `js/child-scripts.js` to add custom functionality. The file provides a `StarterChild` namespace with utility functions:

```javascript
// Access utilities
StarterChild.utils.debounce(function, delay);
StarterChild.utils.throttle(function, limit);
```

### Using Hooks Instead of File Overrides

The preferred method for modifications is using hooks in `includes/hooks.php`:

```php
// Add content to header
function my_custom_header() {
    echo '<div class="my-banner">Welcome!</div>';
}
osc_add_hook('header_top', 'my_custom_header');
```

### Template Overrides

To override a parent theme template:

1. Copy the file from `starter/` to `starter-child/templates/`
2. Modify the copied file as needed
3. The child theme will automatically use your version

**Note:** Only override templates when hooks cannot achieve your goal.

### Helper Functions

Use provided helper functions for common tasks:

```php
// Get child theme option
$value = starter_child_get_option('my_option', 'default');

// Set child theme option
starter_child_set_option('my_option', 'value');

// Get template from templates folder
starter_child_get_template('my-template', ['var' => $value]);

// Get asset URL
$url = starter_child_asset_url('images/logo.png');
```

### Widget Areas

Register widgets via hooks:

```php
osc_add_hook('starter_child_widget_sidebar', 'my_sidebar_widget');
function my_sidebar_widget() {
    echo '<div class="widget">My Widget Content</div>';
}
```

## Design Principles

This child theme follows:

- **SOLID**: Single Responsibility - each file has one purpose
- **DRY**: Don't Repeat Yourself - use helpers and hooks
- **KISS**: Keep It Simple - minimal complexity
- **Clean Code**: Readable, documented, maintainable

## Parent Theme Compatibility

- Parent Theme: Starter Theme
- Minimum Starter Version: 1.5.0
- Osclass Compatibility: 4.x, 5.x

## Updating

When the parent Starter theme is updated:

1. The child theme remains unchanged
2. Your customizations are preserved
3. Parent improvements are automatically inherited

## Admin Settings

Access child theme settings via:
**oc-admin > Theme Setting > Child Theme Settings** (if enabled)

Available options:
- Enable/disable custom CSS
- Enable/disable custom JavaScript
- Debug mode toggle

## Internationalization

To add translations:

1. Copy `languages/starter-child.pot` to `languages/starter-child-{locale}.po`
2. Translate the strings
3. Generate `.mo` file from `.po`

## Support

For issues and feature requests:
- GitHub: https://github.com/kasunvimarshana/tapromall-web/issues

## License

MIT License

## Changelog

### 1.0.0
- Initial release
- Modular file structure
- Hook-based customization
- CSS custom properties
- JavaScript namespace
- Widget placeholders
- Admin settings panel
- Full i18n support
