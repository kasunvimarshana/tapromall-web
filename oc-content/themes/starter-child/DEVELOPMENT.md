# Development Guide

This guide provides comprehensive instructions for developing with the Starter Child Theme.

## Table of Contents

1. [Getting Started](#getting-started)
2. [Architecture Overview](#architecture-overview)
3. [Coding Standards](#coding-standards)
4. [Best Practices](#best-practices)
5. [Common Tasks](#common-tasks)
6. [Testing](#testing)
7. [Deployment](#deployment)

## Getting Started

### Prerequisites

- Osclass 3.7 or higher
- Parent theme: Starter Osclass Theme v1.5.1+
- PHP 5.6+ (PHP 7.4+ recommended)
- Basic knowledge of PHP, HTML, CSS, JavaScript
- Understanding of Osclass hooks and filters

### Development Environment

1. Install Osclass locally
2. Install and activate Starter theme (parent)
3. Install Starter Child theme
4. Enable debug mode in Osclass config

### Directory Structure

```
starter-child/
├── index.php              # Theme metadata (required)
├── functions.php          # Core initialization (required)
├── custom.php            # Custom code entry point
├── LICENSE               # License information
├── README.md             # Documentation
├── CHANGELOG.md          # Version history
├── .gitignore           # Git ignore rules
│
├── assets/              # All static assets
│   ├── css/
│   │   ├── style.css    # Main styles
│   │   └── custom.css   # Custom additions
│   ├── js/
│   │   └── custom.js    # Custom JavaScript
│   └── images/          # Theme images
│
├── includes/            # PHP modules
│   ├── hooks.php        # Custom hooks/filters
│   ├── helpers.php      # Utility functions
│   └── widgets.php      # Custom widgets
│
├── templates/           # Template overrides
├── languages/           # Translation files
└── admin/              # Admin customizations
```

## Architecture Overview

### SOLID Principles

#### Single Responsibility Principle (SRP)
- Each file has one clear purpose
- Functions do one thing well
- Modules are focused and cohesive

#### Open/Closed Principle (OCP)
- Open for extension via hooks
- Closed for modification (don't edit parent)
- Use child theme for all changes

#### Liskov Substitution Principle (LSP)
- Child theme can replace parent theme
- Functions maintain expected behavior
- No breaking changes to parent functionality

#### Interface Segregation Principle (ISP)
- Small, focused interfaces
- Functions accept minimal parameters
- Clear, specific function signatures

#### Dependency Inversion Principle (DIP)
- Depend on abstractions (hooks)
- Not on concrete implementations
- Use dependency injection where possible

### Clean Code Principles

#### DRY (Don't Repeat Yourself)
- Use helper functions
- Create reusable components
- Abstract common patterns

#### KISS (Keep It Simple, Stupid)
- Prefer simple solutions
- Avoid over-engineering
- Write readable code

#### YAGNI (You Aren't Gonna Need It)
- Don't add unused features
- Implement when needed
- Keep codebase lean

## Coding Standards

### PHP Standards

Follow Osclass Programming Standards and PSR-12:

```php
<?php
/**
 * Function description
 * 
 * @param string $param Parameter description
 * @return bool Return value description
 */
function starter_child_function_name($param) {
    // Function body
    if ($condition) {
        // Code
    }
    
    return true;
}
```

#### Naming Conventions

- **Functions**: `starter_child_function_name()`
- **Variables**: `$snake_case`
- **Constants**: `STARTER_CHILD_CONSTANT`
- **Classes**: `Starter_Child_Class_Name`

#### File Headers

```php
<?php
/**
 * File Purpose
 * 
 * Detailed description of what this file does
 * 
 * @package     Starter_Child_Theme
 * @version     1.0.0
 * @author      TaproMall Development Team
 */

// Prevent direct access
if (!defined('ABS_PATH')) {
    exit('Direct access is not allowed.');
}
```

### CSS Standards

Follow BEM methodology:

```css
/* Block */
.child-component {
    /* Styles */
}

/* Element */
.child-component__element {
    /* Styles */
}

/* Modifier */
.child-component--modifier {
    /* Styles */
}
```

#### Organization

```css
/* ==========================================================================
   Section Name
   ========================================================================== */

/* Subsection */
.selector {
    /* Properties in alphabetical order */
    background: #fff;
    color: #333;
    display: block;
}
```

### JavaScript Standards

Use modern JavaScript with proper scoping:

```javascript
(function($) {
    'use strict';
    
    /**
     * Function description
     */
    function functionName() {
        // Implementation
    }
    
    // Initialize
    $(document).ready(function() {
        functionName();
    });
    
})(jQuery);
```

## Best Practices

### Security

1. **Sanitize Input**
```php
$input = sanitize_text_field($_POST['field']);
```

2. **Escape Output**
```php
echo esc_html($output);
echo esc_url($url);
echo esc_attr($attribute);
```

3. **Validate Data**
```php
if (is_numeric($value) && $value > 0) {
    // Process
}
```

4. **Use Nonces**
```php
wp_verify_nonce($_POST['nonce'], 'action_name');
```

### Performance

1. **Minimize HTTP Requests**
   - Combine CSS/JS files
   - Use CSS sprites
   - Lazy load images

2. **Optimize Assets**
   - Minify CSS/JS
   - Compress images
   - Use CDN when possible

3. **Cache Wisely**
   - Cache database queries
   - Use transients
   - Implement browser caching

### Accessibility

1. **Semantic HTML**
```html
<header>
<nav>
<main>
<article>
<footer>
```

2. **ARIA Labels**
```html
<button aria-label="Close">×</button>
```

3. **Keyboard Navigation**
   - Ensure all interactive elements are keyboard accessible
   - Provide visible focus indicators
   - Use proper tab order

## Common Tasks

### Adding Custom Styles

1. Open `assets/css/custom.css`
2. Add your styles:
```css
.custom-element {
    color: var(--child-primary-color);
}
```

### Adding Custom JavaScript

1. Open `assets/js/custom.js`
2. Add your code within the StarterChild namespace:
```javascript
StarterChild.customFunction = function() {
    // Your code
};
```

### Adding a Hook

1. Open `includes/hooks.php`
2. Create your function:
```php
function starter_child_custom_hook() {
    // Your code
}
osc_add_hook('hook_name', 'starter_child_custom_hook');
```

### Creating a Helper Function

1. Open `includes/helpers.php`
2. Add your function:
```php
function starter_child_helper_name($param) {
    // Implementation
    return $result;
}
```

### Overriding a Template

1. Copy template from parent theme
2. Place in `templates/` directory
3. Modify as needed
4. Document why you're overriding

### Adding a Widget

1. Open `includes/widgets.php`
2. Create widget function:
```php
function starter_child_custom_widget() {
    ?>
    <div class="child-widget">
        <!-- Widget content -->
    </div>
    <?php
}
```
3. Register widget:
```php
osc_register_widget('custom_widget', 'starter_child_custom_widget');
```

## Testing

### Manual Testing

1. **Theme Activation**
   - Activate theme
   - Check for errors
   - Verify parent styles load

2. **Visual Testing**
   - Test all pages
   - Check responsive design
   - Verify in multiple browsers

3. **Functionality Testing**
   - Test custom features
   - Verify hooks work
   - Check JavaScript functions

### Browser Testing

Test in:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

### Debugging

Enable debug mode in Osclass:

```php
define('OSC_DEBUG', true);
define('OSC_DEBUG_LOG', true);
```

Use helper functions:
```php
starter_child_log($message, 'debug');
```

## Deployment

### Pre-Deployment Checklist

- [ ] Test all functionality
- [ ] Verify responsive design
- [ ] Check browser compatibility
- [ ] Validate HTML/CSS
- [ ] Optimize images
- [ ] Minify CSS/JS
- [ ] Test with parent theme updates
- [ ] Backup existing theme
- [ ] Update version numbers
- [ ] Update CHANGELOG.md

### Deployment Steps

1. **Backup**
   - Backup current theme
   - Backup database

2. **Upload**
   - Upload child theme folder
   - Verify file permissions

3. **Activate**
   - Activate child theme
   - Check for errors

4. **Verify**
   - Test all pages
   - Check functionality
   - Monitor error logs

### Rollback Plan

If issues occur:
1. Deactivate child theme
2. Activate parent theme
3. Check error logs
4. Fix issues locally
5. Re-deploy

## Additional Resources

### Official Documentation
- [Osclass Developer Guide](https://docs.osclass-classifieds.com/developer-guide)
- [Osclass Programming Standards](https://docs.osclass-classifieds.com/programming-standards-i75)
- [Child Theme Guidelines](https://docs.osclass-classifieds.com/child-themes-i79)

### Clean Code Resources
- [Clean Coder Blog](https://blog.cleancoder.com)
- [Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)

### Tools
- PHPCodeSniffer - Code standards
- ESLint - JavaScript linting
- Stylelint - CSS linting
- Browser DevTools - Debugging

## Getting Help

- Review inline code documentation
- Check README.md
- Consult Osclass documentation
- Search Osclass forums
- Review parent theme documentation

---

**Remember**: Write code as if the next person to maintain it is a violent psychopath who knows where you live. 😊
