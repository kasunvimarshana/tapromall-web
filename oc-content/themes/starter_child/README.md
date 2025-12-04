# Starter Child Theme

A clean, blank child theme for the Starter Osclass theme that strictly follows Osclass best practices and clean code principles.

## Overview

This child theme provides a lightweight, update-safe foundation for customizing the Starter Osclass theme. It is built with SOLID, DRY, and KISS principles in mind, ensuring scalability, readability, and long-term maintainability.

## Features

- ✅ **Update-Safe**: Never modifies parent theme or core files
- ✅ **Hook-Based**: Uses Osclass hook system for all customizations
- ✅ **Modular Architecture**: Clear separation of concerns
- ✅ **Clean Code**: Follows Osclass programming standards
- ✅ **Well-Documented**: Comprehensive inline documentation
- ✅ **Translation Ready**: Full i18n support
- ✅ **Responsive**: Mobile-first design approach
- ✅ **Accessible**: WCAG 2.1 compliant
- ✅ **Performance Optimized**: Lazy loading, minification support
- ✅ **Admin Panel**: User-friendly settings interface

## Requirements

- Osclass 8.2.0 or higher
- Starter Osclass Theme (parent theme)
- PHP 7.4 or higher
- Modern web browser with JavaScript enabled

## Installation

1. Download or clone this repository
2. Upload the `starter_child` folder to `oc-content/themes/`
3. Go to your Osclass admin panel
4. Navigate to Appearance > Themes
5. Activate "Starter Child Theme"

## File Structure

```
starter_child/
├── admin/                      # Admin panel files
│   ├── functions.php          # Admin-specific functions
│   └── settings.php           # Settings page
├── css/                       # Stylesheets
│   └── style.css              # Main stylesheet
├── js/                        # JavaScript files
│   └── main.js                # Main JavaScript
├── images/                    # Image assets
├── fonts/                     # Custom fonts
├── languages/                 # Translation files
├── functions.php              # Theme functions and hooks
├── index.php                  # Theme metadata
├── screenshot.png             # Theme screenshot
└── README.md                  # This file
```

## Customization

### Using Hooks

The child theme uses hooks for all customizations. Example:

```php
// Add custom content to header
function my_custom_header_content() {
    echo '<div class="custom-banner">Custom content</div>';
}
osc_add_hook('header', 'my_custom_header_content', 15);
```

### Overriding Templates

To override a parent template file:

1. Copy the file from the parent theme to your child theme
2. Maintain the same file structure
3. Edit the file in the child theme

Example: To override `item.php`, copy it from `oc-content/themes/starter/item.php` to `oc-content/themes/starter_child/item.php`.

### Custom CSS

Add custom CSS in the admin panel at **Appearance > Starter Child Settings** or edit `css/style.css` directly.

All CSS classes are scoped with `starter-child-` prefix to avoid conflicts:

```css
.starter-child-custom-class {
    color: #007bff;
}
```

### Custom JavaScript

Add custom JavaScript in the admin panel or edit `js/main.js` directly.

The theme JavaScript is wrapped in an IIFE with jQuery:

```javascript
(function($) {
    // Your code here
})(jQuery);
```

## Configuration

Access theme settings at **Appearance > Starter Child Settings** in the admin panel.

Available options:
- Enable/disable custom styles
- Enable/disable custom scripts
- Add custom CSS
- Add custom JavaScript
- Enable debug mode

## Best Practices

### Code Standards

This theme follows Osclass programming standards:

- **Function naming**: `snake_case` with `osc_` or `starter_child_` prefix
- **Variable naming**: `snake_case`
- **Constants**: `UPPERCASE_WITH_UNDERSCORES`
- **Classes**: `PascalCase`
- **Indentation**: 4 spaces (no tabs)

### Security

Always use proper escaping:

```php
// For HTML output
echo osc_esc_html($variable);

// For HTML attributes
echo esc_attr($variable);

// For JavaScript
echo osc_esc_js($variable);
```

### Performance

- Use caching when possible
- Lazy load images
- Minimize HTTP requests
- Optimize assets (CSS/JS)

### Accessibility

- Use semantic HTML
- Provide alt text for images
- Ensure keyboard navigation
- Maintain proper heading hierarchy
- Use ARIA labels where appropriate

## Available Hooks

The theme provides several custom hooks for extensibility:

### Action Hooks

- `starter_child_init` - Runs during theme initialization
- `starter_child_header_custom` - Custom header content
- `starter_child_footer_custom` - Custom footer content

### Filter Hooks

- `starter_child_filter_item_title` - Modify item titles
- `starter_child_filter_meta_title` - Modify meta titles

## Translation

The theme is translation-ready. To add a translation:

1. Create a `.po` file for your language in the `languages/` directory
2. Use a tool like Poedit to translate strings
3. Generate the `.mo` file
4. Place both files in `languages/`

Text domain: `starter_child`

Example translation string:
```php
<?php _e('Hello World', 'starter_child'); ?>
```

## Development

### Debug Mode

Enable debug mode in the theme settings to see console logs and error messages during development.

### Version Control

The `.gitignore` should exclude:
- `languages/*.mo` (generated files)
- Any temporary or cache files
- Local configuration files

### Testing

Before deploying:
1. Test on multiple browsers (Chrome, Firefox, Safari, Edge)
2. Test responsive design on various devices
3. Validate HTML and CSS
4. Check for JavaScript errors
5. Test with parent theme updates

## Troubleshooting

### Theme not working properly

1. Ensure the parent theme (Starter) is installed
2. Check for PHP errors in error logs
3. Clear browser cache
4. Deactivate other plugins temporarily

### Styles not loading

1. Check that "Enable Custom Styles" is enabled in settings
2. Verify the CSS file path is correct
3. Clear cache and hard refresh (Ctrl+F5)

### JavaScript errors

1. Check browser console for errors
2. Ensure jQuery is loaded
3. Verify no conflicts with other scripts

## Resources

### Osclass Documentation

- [Developer Guide](https://docs.osclass-classifieds.com/developer-guide)
- [Programming Standards](https://docs.osclass-classifieds.com/programming-standards-i75)
- [Child Theme Guidelines](https://docs.osclass-classifieds.com/child-themes-i79)
- [Hooks Reference](https://docs.osclass-classifieds.com/hooks-i118)
- [Filters Reference](https://docs.osclass-classifieds.com/filters-i119)

### Clean Code Resources

- [Clean Coder Blog](https://blog.cleancoder.com)
- [Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)

### Starter Theme

- [Starter Theme Documentation](https://osclasspoint.com/osclass-themes/general/starter-osclass-theme_i86)

## Support

For issues, questions, or contributions:

- GitHub: [kasunvimarshana/tapromall-web](https://github.com/kasunvimarshana/tapromall-web)
- Osclass Forum: [https://osclass-classifieds.com/forums](https://osclass-classifieds.com/forums)

## Changelog

### Version 1.0.0 (2024)

- Initial release
- Clean, minimal child theme structure
- Hook-based customization system
- Admin settings panel
- Scoped CSS and JavaScript
- Translation support
- Accessibility features
- Performance optimizations
- Comprehensive documentation

## License

This theme inherits the license of the parent Starter theme and Osclass platform.

## Credits

- **Theme Author**: TaproMall Team
- **Parent Theme**: Starter Osclass Theme by MB Themes
- **Platform**: Osclass by OsclassPoint

## Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch
3. Follow the coding standards
4. Test thoroughly
5. Submit a pull request with detailed description

---

**Note**: This is a child theme. The parent Starter theme must be installed and available for this theme to work properly.

For the latest updates and documentation, visit: [https://github.com/kasunvimarshana/tapromall-web](https://github.com/kasunvimarshana/tapromall-web)
