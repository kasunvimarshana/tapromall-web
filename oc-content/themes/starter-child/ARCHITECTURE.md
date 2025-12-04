# Architecture & Design Principles

This document outlines the architectural decisions and design principles applied in the Starter Child Theme.

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [SOLID Principles](#solid-principles)
3. [Clean Code Principles](#clean-code-principles)
4. [Design Patterns](#design-patterns)
5. [Module Breakdown](#module-breakdown)
6. [Security Architecture](#security-architecture)
7. [Performance Considerations](#performance-considerations)

## Architecture Overview

The Starter Child Theme follows **Clean Architecture** principles as defined by Robert C. Martin (Uncle Bob). The architecture emphasizes:

- **Separation of Concerns**: Each module has a distinct responsibility
- **Dependency Rule**: Dependencies point inward toward high-level policy
- **Independence**: Business logic is independent of frameworks and UI
- **Testability**: All components can be tested independently

### Architectural Layers

```
┌─────────────────────────────────────────┐
│         Presentation Layer              │
│    (Templates, CSS, JavaScript)         │
├─────────────────────────────────────────┤
│         Application Layer               │
│      (Functions, Hooks, Widgets)        │
├─────────────────────────────────────────┤
│         Domain Layer                    │
│      (Helpers, Configuration)           │
├─────────────────────────────────────────┤
│         Infrastructure Layer            │
│    (Osclass Core, Parent Theme)         │
└─────────────────────────────────────────┘
```

## SOLID Principles

### Single Responsibility Principle (SRP)

**Definition**: A class/module should have only one reason to change.

**Implementation**:
- `index.php` - Only contains theme metadata
- `functions.php` - Only handles initialization
- `hooks.php` - Only manages hooks and filters
- `helpers.php` - Only provides utility functions
- `widgets.php` - Only defines widgets
- `config.php` - Only manages configuration

**Example**:
```php
// BAD: Multiple responsibilities
function do_everything() {
    // Handle database
    // Render HTML
    // Send email
    // Log errors
}

// GOOD: Single responsibility
function get_items_from_database() { }
function render_items_html($items) { }
function send_notification_email($data) { }
function log_error($message) { }
```

### Open/Closed Principle (OCP)

**Definition**: Software entities should be open for extension but closed for modification.

**Implementation**:
- Use hooks for extensions instead of modifying parent theme
- Child theme extends parent without changing it
- Configuration-driven behavior
- Plugin architecture for features

**Example**:
```php
// Extension through hooks (OPEN for extension)
osc_add_hook('header', 'starter_child_custom_header');

// Parent theme remains unchanged (CLOSED for modification)
// Never edit parent theme files
```

### Liskov Substitution Principle (LSP)

**Definition**: Objects should be replaceable with instances of their subtypes.

**Implementation**:
- Child theme can substitute parent theme
- Helper functions maintain consistent signatures
- No breaking changes to parent functionality

**Example**:
```php
// Parent function
function format_price($price) {
    return '$' . number_format($price, 2);
}

// Child enhancement maintains same signature
function starter_child_format_price($price) {
    // Can add features but maintains contract
    return osc_format_price($price);
}
```

### Interface Segregation Principle (ISP)

**Definition**: No client should be forced to depend on methods it doesn't use.

**Implementation**:
- Focused, minimal function parameters
- Optional parameters with sensible defaults
- Specific helper functions vs. monolithic ones

**Example**:
```php
// BAD: Forces clients to know too much
function render_widget($type, $data, $style, $position, $cache, $options) { }

// GOOD: Focused, minimal interface
function render_widget($type, $data = array()) {
    $style = starter_child_get_option('widget_style', 'default');
    // Handle internally
}
```

### Dependency Inversion Principle (DIP)

**Definition**: Depend on abstractions, not concretions.

**Implementation**:
- Depend on Osclass hooks (abstractions) not specific implementations
- Use configuration for behavior
- Inject dependencies where possible

**Example**:
```php
// BAD: Direct dependency on concrete implementation
function get_data() {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM items");
}

// GOOD: Depend on Osclass abstraction
function get_data() {
    return osc_search_items(); // Abstraction
}
```

## Clean Code Principles

### DRY (Don't Repeat Yourself)

**Implementation**:
- Helper functions for repeated operations
- Configuration for repeated values
- Reusable components and widgets

**Examples**:
```php
// BAD: Repetition
echo '<a href="' . esc_url($url1) . '">' . esc_html($text1) . '</a>';
echo '<a href="' . esc_url($url2) . '">' . esc_html($text2) . '</a>';
echo '<a href="' . esc_url($url3) . '">' . esc_html($text3) . '</a>';

// GOOD: Abstracted
function render_link($url, $text) {
    return '<a href="' . esc_url($url) . '">' . esc_html($text) . '</a>';
}
```

### KISS (Keep It Simple, Stupid)

**Implementation**:
- Simple, readable code over clever tricks
- Clear naming conventions
- Straightforward logic flow
- Avoid premature optimization

**Examples**:
```php
// BAD: Too clever
$r = array_reduce($a, fn($c, $i) => $c + ($i['p'] > 100 ? 1 : 0), 0);

// GOOD: Clear and simple
$expensive_items_count = 0;
foreach ($items as $item) {
    if ($item['price'] > 100) {
        $expensive_items_count++;
    }
}
```

### YAGNI (You Aren't Gonna Need It)

**Implementation**:
- No unused features or code
- Implement only what's needed now
- Comments show where to add future features
- Lean codebase

**Example**:
```php
// BAD: Feature we don't need yet
function advanced_caching_system_we_might_need() { }
function complex_api_integration_for_future() { }

// GOOD: Only what's needed
// Placeholder for future caching
// function starter_child_cache_data() { }
```

## Design Patterns

### Module Pattern

**Purpose**: Encapsulate functionality in self-contained modules

**Implementation**:
```php
// Each includes/ file is a module
includes/
├── config.php      # Configuration module
├── helpers.php     # Utility module
├── hooks.php       # Hooks module
└── widgets.php     # Widget module
```

### Strategy Pattern

**Purpose**: Define family of algorithms, encapsulate each one

**Implementation**:
```php
// Different rendering strategies via hooks
osc_add_hook('item_display', 'render_list_view');
osc_add_hook('item_display', 'render_grid_view');
osc_add_hook('item_display', 'render_masonry_view');
```

### Observer Pattern

**Purpose**: Define one-to-many dependency between objects

**Implementation**:
```php
// Osclass hooks implement Observer pattern
osc_add_hook('header', 'observer_function_1');
osc_add_hook('header', 'observer_function_2');
// When 'header' fires, all observers are notified
```

### Facade Pattern

**Purpose**: Provide simplified interface to complex subsystem

**Implementation**:
```php
// Helper functions provide facade to complex operations
function starter_child_include_template($template, $data) {
    // Simplifies: path resolution, existence check, data extraction
    $path = starter_child_template_path($template);
    if (file_exists($path)) {
        extract($data);
        include $path;
    }
}
```

## Module Breakdown

### Core Modules

#### index.php
- **Purpose**: Theme metadata
- **Responsibility**: Define theme information
- **Dependencies**: None
- **Lines of Code**: ~20

#### functions.php
- **Purpose**: Theme initialization
- **Responsibility**: Bootstrap theme, load modules
- **Dependencies**: All modules
- **Lines of Code**: ~200

### Asset Modules

#### assets/css/style.css
- **Purpose**: Main styles
- **Responsibility**: Override parent styles
- **Dependencies**: Parent theme CSS
- **Approach**: CSS variables for consistency

#### assets/css/custom.css
- **Purpose**: Custom styles
- **Responsibility**: Project-specific styles
- **Dependencies**: style.css
- **Approach**: Separation of concerns

#### assets/js/custom.js
- **Purpose**: Custom JavaScript
- **Responsibility**: Interactive features
- **Dependencies**: jQuery
- **Approach**: Namespaced, scoped

### Functionality Modules

#### includes/config.php
- **Purpose**: Configuration management
- **Responsibility**: Centralized settings
- **Pattern**: Singleton-like static class
- **Benefits**: Single source of truth

#### includes/helpers.php
- **Purpose**: Utility functions
- **Responsibility**: Reusable operations
- **Pattern**: Pure functions
- **Benefits**: DRY, testable

#### includes/hooks.php
- **Purpose**: Hook implementations
- **Responsibility**: Extend via hooks
- **Pattern**: Observer
- **Benefits**: Update-safe

#### includes/widgets.php
- **Purpose**: Widget definitions
- **Responsibility**: Reusable components
- **Pattern**: Component
- **Benefits**: Modular, reusable

## Security Architecture

### Defense in Depth

Multiple layers of security:

1. **Input Validation**: Validate all inputs
2. **Sanitization**: Clean data before use
3. **Escaping**: Escape data before output
4. **Authentication**: Verify user identity
5. **Authorization**: Check permissions

### Security Principles

#### Sanitize Input
```php
$input = sanitize_text_field($_POST['field']);
$email = sanitize_email($_POST['email']);
$url = esc_url_raw($_POST['url']);
```

#### Escape Output
```php
echo esc_html($text);        // Plain text
echo esc_url($url);          // URLs
echo esc_attr($attribute);   // HTML attributes
echo esc_js($javascript);    // JavaScript
```

#### Validate Data
```php
if (!is_numeric($value)) {
    return new WP_Error('invalid', 'Must be numeric');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return new WP_Error('invalid', 'Invalid email');
}
```

#### Principle of Least Privilege
- Only request necessary permissions
- Minimal database queries
- Limited scope of functions

## Performance Considerations

### Asset Optimization

1. **Minimize HTTP Requests**
   - Combine CSS files
   - Combine JavaScript files
   - Use CSS sprites

2. **Optimize File Size**
   - Minify CSS/JS in production
   - Compress images
   - Use appropriate formats

3. **Lazy Loading**
   - Load images on demand
   - Defer non-critical scripts
   - Async load when possible

### Code Optimization

1. **Efficient Queries**
   - Cache database queries
   - Use pagination
   - Limit result sets

2. **Conditional Loading**
   - Load resources only when needed
   - Page-specific scripts
   - Conditional widget loading

3. **Caching Strategy**
   - Use transients for expensive operations
   - Browser caching for static assets
   - Object caching for repeated data

### Example
```php
// Cache expensive operation
function starter_child_get_popular_items() {
    $cache_key = 'popular_items_v1';
    $items = get_transient($cache_key);
    
    if (false === $items) {
        $items = osc_search_items(array(
            'order_by' => 'i_num_views',
            'order_direction' => 'DESC',
            'results_per_page' => 10
        ));
        
        set_transient($cache_key, $items, HOUR_IN_SECONDS);
    }
    
    return $items;
}
```

## Conclusion

This architecture ensures:

✅ **Maintainability**: Clear structure, easy to understand
✅ **Scalability**: Easy to extend and grow
✅ **Testability**: Components can be tested independently
✅ **Security**: Multiple layers of protection
✅ **Performance**: Optimized for speed
✅ **Update-Safety**: No parent theme modifications
✅ **Code Quality**: Following industry best practices

The architecture adheres to:
- Clean Architecture principles by Robert C. Martin
- SOLID object-oriented design principles
- Clean Code best practices
- Osclass development standards
- Security best practices

---

**References**:
- [Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)
- [Osclass Documentation](https://docs.osclass-classifieds.com/)
