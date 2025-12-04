# Translation Files

This directory contains translation files for the child theme.

## Creating Translations

1. Create a `.po` file for your language
2. Name it: `starter-child-{locale}.po` (e.g., `starter-child-es_ES.po`)
3. Compile to `.mo` file
4. Place both files in this directory

## Text Domain

Use the text domain `starter-child` for all translations:

```php
__('Text to translate', 'starter-child');
_e('Text to echo and translate', 'starter-child');
```

## Tools

- POEdit: https://poedit.net/
- Loco Translate: WordPress plugin for Osclass
- GNU Gettext: Command-line tools

## Translation Functions

- `__()` - Return translated string
- `_e()` - Echo translated string
- `_n()` - Translate with plural forms
- `_x()` - Translate with context

## Example

```php
<h1><?php _e('Welcome', 'starter-child'); ?></h1>
$message = __('Hello World', 'starter-child');
```

For more information, see Osclass documentation on internationalization.
