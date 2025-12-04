# Starter Child Theme

A clean, minimal child theme for the Starter Osclass Theme that follows clean architecture principles and Osclass best practices.

## Overview

This child theme extends the Starter Osclass Theme without modifying any parent or core files. It provides a lightweight, update-safe foundation for customizations, following SOLID, DRY, KISS, and clean code principles.

## Features

- ✅ **Update-Safe**: Never modifies parent theme files
- ✅ **Modular Architecture**: Organized into clear, single-responsibility modules
- ✅ **Hook-Based Extensions**: Uses Osclass hooks instead of file overrides
- ✅ **Clean Code**: Follows SOLID, DRY, and KISS principles
- ✅ **Well-Documented**: Comprehensive inline documentation
- ✅ **Scalable Structure**: Easy to extend and maintain
- ✅ **Asset Management**: Properly scoped CSS and JavaScript
- ✅ **Translation Ready**: Prepared for multilingual support

## Directory Structure

```
starter-child/
├── index.php                 # Theme metadata and parent reference
├── functions.php             # Core theme initialization
├── assets/                   # All theme assets
│   ├── css/
│   │   ├── style.css        # Main stylesheet
│   │   └── custom.css       # Custom additions
│   ├── js/
│   │   └── custom.js        # Custom JavaScript
│   └── images/              # Theme images
├── includes/                 # Modular functionality
│   ├── hooks.php            # Custom hooks and filters
│   ├── helpers.php          # Utility functions
│   └── widgets.php          # Custom widgets
├── templates/               # Template overrides
├── languages/               # Translation files
└── admin/                   # Admin panel customizations
```

## Installation

1. **Download** the theme folder
2. **Upload** to `/oc-content/themes/` directory
3. **Activate** the theme from Osclass admin panel (Appearance > Themes)

## Requirements

- Osclass 3.7+
- Parent Theme: Starter Osclass Theme v1.5.1+
- PHP 5.6+ (PHP 7.4+ recommended)

## Usage

### Adding Custom Styles

Edit `/assets/css/custom.css`:

```css
/* Your custom styles */
.custom-class {
    color: #333;
}
```

### Adding Custom JavaScript

Edit `/assets/js/custom.js`:

```javascript
// Your custom JavaScript
StarterChild.init();
```

### Using Hooks

Edit `/includes/hooks.php` to add custom hooks:

```php
function starter_child_custom_header_content() {
    // Your custom code
}
osc_add_hook('header', 'starter_child_custom_header_content');
```

### Template Overrides

To override a parent template:

1. Copy the template file from parent theme
2. Place it in `/templates/` directory
3. Modify as needed

Example: Override `item.php`
```php
// Copy /themes/starter/item.php to /themes/starter-child/templates/item.php
```

### Helper Functions

Use built-in helper functions:

```php
// Get asset URL
$image_url = starter_child_asset('images/logo.png');

// Include template
starter_child_include_template('custom-section.php', array('data' => $data));

// Get theme option
$option = starter_child_get_option('custom_setting', 'default');
```

## Customization Guidelines

### Following Clean Code Principles

1. **Single Responsibility**: Each file/function has one clear purpose
2. **DRY (Don't Repeat Yourself)**: Use helper functions for repeated code
3. **KISS (Keep It Simple)**: Prefer simple solutions over complex ones
4. **Separation of Concerns**: Keep logic, presentation, and styling separate

### Adding New Features

1. **Create new module** in `/includes/` for new functionality
2. **Use hooks** instead of modifying existing code
3. **Follow naming conventions** from Osclass Programming Standards
4. **Document your code** with clear comments
5. **Test thoroughly** before deploying

### CSS Guidelines

- Use CSS variables for theme consistency
- Follow BEM naming convention
- Scope all styles to avoid conflicts
- Use responsive design patterns
- Optimize for performance

### JavaScript Guidelines

- Use jQuery when available
- Scope all code to avoid global pollution
- Use event delegation
- Add error handling
- Optimize for performance

## Hooks Reference

Common Osclass hooks you can use:

- `header` - Add content to header
- `footer` - Add content to footer
- `item_detail` - Customize item detail pages
- `search_results` - Customize search results
- `user_dashboard` - Customize user dashboard

See `/includes/hooks.php` for examples.

## Best Practices

1. **Never modify parent theme files** - Always use child theme
2. **Use hooks over template overrides** - More update-safe
3. **Keep code organized** - Follow the directory structure
4. **Document changes** - Add comments for complex code
5. **Test updates** - Check compatibility after parent theme updates
6. **Follow standards** - Use Osclass coding standards
7. **Optimize assets** - Minify CSS/JS for production
8. **Security first** - Sanitize inputs, escape outputs

## Translation

The theme is translation-ready. To add translations:

1. Create a `.po` file in `/languages/`
2. Follow naming: `starter-child-{locale}.po`
3. Use standard Osclass translation functions

## Support

- **Documentation**: See inline code comments
- **Osclass Docs**: https://docs.osclass-classifieds.com/
- **Clean Code**: https://blog.cleancoder.com/
- **Repository**: https://github.com/kasunvimarshana/tapromall-web

## Contributing

When contributing to this theme:

1. Follow the established code style
2. Add appropriate documentation
3. Test all changes thoroughly
4. Follow SOLID principles
5. Keep commits focused and atomic

## Version History

See [CHANGELOG.md](CHANGELOG.md) for version history.

## License

This child theme inherits the license from the parent Starter theme.

## Credits

- **Parent Theme**: Starter Osclass Theme by MB Themes
- **Child Theme**: TaproMall Development Team
- **Architecture**: Based on Clean Architecture principles by Robert C. Martin

## Notes

- This is a blank child theme starter
- No modifications to parent theme are included
- Designed for developers to extend
- Follow Osclass best practices
- Update-safe and future-proof

---

**Made with ❤️ following Clean Code principles**
