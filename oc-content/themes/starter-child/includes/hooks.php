<?php
/**
 * Starter Child Theme - Custom Hooks
 *
 * Contains custom hooks and filters to extend/modify parent theme functionality.
 * Prioritizes hooks over file overrides for better maintainability.
 *
 * @package StarterChild
 * @subpackage Includes
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABS_PATH')) {
    exit('Direct access not allowed.');
}

/*
|--------------------------------------------------------------------------
| HEADER HOOKS
|--------------------------------------------------------------------------
| Modify header content using hooks instead of overriding header.php.
*/
if (!function_exists('starter_child_header_top_content')) {
    /**
     * Add content to header top area.
     * Uses 'header_top' hook from parent theme.
     *
     * @return void
     */
    function starter_child_header_top_content() {
        // Example: Add custom content before header navigation
        // echo '<div class="child-announcement-bar">' . __('Welcome to our site!', 'starter-child') . '</div>';
    }
    osc_add_hook('header_top', 'starter_child_header_top_content');
}

if (!function_exists('starter_child_header_bottom_content')) {
    /**
     * Add content to header bottom area.
     * Uses 'header_bottom' hook from parent theme.
     *
     * @return void
     */
    function starter_child_header_bottom_content() {
        // Example: Add custom content after header navigation
    }
    osc_add_hook('header_bottom', 'starter_child_header_bottom_content');
}

if (!function_exists('starter_child_after_header')) {
    /**
     * Add content after header.
     * Uses 'header_after' hook from parent theme.
     *
     * @return void
     */
    function starter_child_after_header() {
        // Example: Add breadcrumbs or secondary navigation
    }
    osc_add_hook('header_after', 'starter_child_after_header');
}

/*
|--------------------------------------------------------------------------
| FOOTER HOOKS
|--------------------------------------------------------------------------
| Modify footer content using hooks instead of overriding footer.php.
*/
if (!function_exists('starter_child_footer_top_content')) {
    /**
     * Add content to footer top area.
     * Uses 'footer_top' hook from parent theme.
     *
     * @return void
     */
    function starter_child_footer_top_content() {
        // Example: Add newsletter signup form
    }
    osc_add_hook('footer_top', 'starter_child_footer_top_content');
}

if (!function_exists('starter_child_footer_links')) {
    /**
     * Add custom footer links.
     * Uses 'footer_links' hook from parent theme.
     *
     * @return void
     */
    function starter_child_footer_links() {
        // Example: Add custom footer links
        // echo '<a href="' . osc_base_url() . 'privacy">' . __('Privacy Policy', 'starter-child') . '</a>';
    }
    osc_add_hook('footer_links', 'starter_child_footer_links');
}

if (!function_exists('starter_child_footer_after')) {
    /**
     * Add content after footer.
     * Uses 'footer_after' hook from parent theme.
     *
     * @return void
     */
    function starter_child_footer_after() {
        // Example: Add back-to-top button, analytics, etc.
    }
    osc_add_hook('footer_after', 'starter_child_footer_after');
}

/*
|--------------------------------------------------------------------------
| ITEM HOOKS
|--------------------------------------------------------------------------
| Modify item display and forms using hooks.
*/
if (!function_exists('starter_child_item_detail')) {
    /**
     * Add content to item detail page.
     * Uses 'item_detail' hook from Osclass core.
     *
     * @return void
     */
    function starter_child_item_detail() {
        // Example: Add custom fields, social sharing, etc.
    }
    osc_add_hook('item_detail', 'starter_child_item_detail');
}

if (!function_exists('starter_child_item_form')) {
    /**
     * Add custom fields to item publish/edit form.
     * Uses 'item_form' hook from Osclass core.
     *
     * @param int|null $catId Category ID.
     * @param int|null $itemId Item ID.
     * @return void
     */
    function starter_child_item_form($catId = null, $itemId = null) {
        // Example: Add custom form fields
    }
    osc_add_hook('item_form', 'starter_child_item_form');
    osc_add_hook('item_edit', 'starter_child_item_form');
}

if (!function_exists('starter_child_posted_item')) {
    /**
     * Process custom fields after item is posted.
     * Uses 'posted_item' hook from Osclass core.
     *
     * @param array $item Item data array.
     * @return void
     */
    function starter_child_posted_item($item) {
        // Example: Save custom field values
    }
    osc_add_hook('posted_item', 'starter_child_posted_item');
}

/*
|--------------------------------------------------------------------------
| SEARCH HOOKS
|--------------------------------------------------------------------------
| Modify search functionality using hooks.
*/
if (!function_exists('starter_child_search_form')) {
    /**
     * Add custom fields to search form.
     * Uses 'search_form' hook from Osclass core.
     *
     * @return void
     */
    function starter_child_search_form() {
        // Example: Add custom search filters
    }
    osc_add_hook('search_form', 'starter_child_search_form');
}

if (!function_exists('starter_child_search_conditions')) {
    /**
     * Modify search query conditions.
     * Uses 'search_conditions' hook from Osclass core.
     *
     * @return void
     */
    function starter_child_search_conditions() {
        // Example: Add custom search conditions
        // Use Search::newInstance()->addConditions() for custom filters
    }
    osc_add_hook('search_conditions', 'starter_child_search_conditions');
}

/*
|--------------------------------------------------------------------------
| USER HOOKS
|--------------------------------------------------------------------------
| Modify user-related functionality using hooks.
*/
if (!function_exists('starter_child_user_form')) {
    /**
     * Add custom fields to user registration form.
     * Uses 'user_form' hook from Osclass core.
     *
     * @return void
     */
    function starter_child_user_form() {
        // Example: Add custom user profile fields
    }
    osc_add_hook('user_form', 'starter_child_user_form');
}

if (!function_exists('starter_child_user_menu')) {
    /**
     * Add items to user dashboard menu.
     * Uses 'user_menu' hook from parent theme.
     *
     * @return void
     */
    function starter_child_user_menu() {
        // Example: Add custom menu items
        // echo '<li class="opt_custom"><a href="#">' . __('Custom Page', 'starter-child') . '</a></li>';
    }
    osc_add_hook('user_menu', 'starter_child_user_menu');
}

/*
|--------------------------------------------------------------------------
| FILTER EXAMPLES
|--------------------------------------------------------------------------
| Modify data using filters instead of function overrides.
*/
if (!function_exists('starter_child_user_menu_filter')) {
    /**
     * Filter user menu options.
     * Uses 'user_menu_filter' filter from parent theme.
     *
     * @param array $options User menu options array.
     * @return array Modified options array.
     */
    function starter_child_user_menu_filter($options) {
        // Example: Modify user menu options
        // $options[] = array(
        //     'name' => __('Custom Page', 'starter-child'),
        //     'url' => osc_base_url() . 'custom-page',
        //     'class' => 'opt_custom',
        //     'icon' => 'fa-star',
        //     'section' => 2
        // );
        return $options;
    }
    osc_add_filter('user_menu_filter', 'starter_child_user_menu_filter');
}

/*
|--------------------------------------------------------------------------
| META FILTERS
|--------------------------------------------------------------------------
| Modify page meta information.
*/
if (!function_exists('starter_child_meta_title_filter')) {
    /**
     * Filter page meta title.
     *
     * @param string $title Current meta title.
     * @return string Modified meta title.
     */
    function starter_child_meta_title_filter($title) {
        // Example: Append site name to all titles
        // return $title . ' | ' . osc_page_title();
        return $title;
    }
    // Uncomment to enable: osc_add_filter('meta_title', 'starter_child_meta_title_filter');
}

/*
|--------------------------------------------------------------------------
| PLUGIN COMPATIBILITY HOOKS
|--------------------------------------------------------------------------
| Add hooks for plugin integration points.
*/
if (!function_exists('starter_child_plugin_integration')) {
    /**
     * Initialize plugin compatibility code.
     *
     * @return void
     */
    function starter_child_plugin_integration() {
        // Add compatibility code for specific plugins here
    }
    osc_add_hook('init', 'starter_child_plugin_integration');
}
