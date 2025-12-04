<?php
/**
 * Custom Widgets
 * 
 * This file contains custom widget definitions for the child theme.
 * Widgets provide modular, reusable components for sidebars and widget areas.
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
 * Register Custom Widgets
 * 
 * Registers all custom widgets for the child theme
 */
function starter_child_register_widgets() {
    // Register custom widget areas
    // Example: osc_register_widget('starter_child_custom_widget', 'starter_child_display_custom_widget');
}

/**
 * Example Custom Widget Display Function
 * 
 * This is a placeholder for a custom widget
 * Uncomment and modify as needed
 */
/*
function starter_child_display_custom_widget() {
    ?>
    <div class="child-widget child-custom-widget">
        <h3><?php _e('Custom Widget', 'starter-child'); ?></h3>
        <div class="widget-content">
            <!-- Widget content here -->
        </div>
    </div>
    <?php
}
*/

/**
 * Example: Social Media Widget
 * 
 * Displays social media links
 */
/*
function starter_child_social_widget() {
    $facebook = starter_child_get_option('social_facebook', '');
    $twitter = starter_child_get_option('social_twitter', '');
    $instagram = starter_child_get_option('social_instagram', '');
    
    if (!empty($facebook) || !empty($twitter) || !empty($instagram)) {
        ?>
        <div class="child-widget child-social-widget">
            <h3><?php _e('Follow Us', 'starter-child'); ?></h3>
            <ul class="social-links">
                <?php if (!empty($facebook)): ?>
                    <li>
                        <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (!empty($twitter)): ?>
                    <li>
                        <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (!empty($instagram)): ?>
                    <li>
                        <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener">
                            <i class="fa fa-instagram"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php
    }
}
*/

/**
 * Example: Recent Items Widget
 * 
 * Displays recent items
 */
/*
function starter_child_recent_items_widget($limit = 5) {
    $items = osc_search_items(array(
        'results_per_page' => $limit,
        'order_by' => 'dt_pub_date',
        'order_direction' => 'DESC'
    ));
    
    if (!empty($items)) {
        ?>
        <div class="child-widget child-recent-items-widget">
            <h3><?php _e('Recent Items', 'starter-child'); ?></h3>
            <ul class="recent-items-list">
                <?php foreach ($items as $item): ?>
                    <li>
                        <a href="<?php echo osc_item_url(); ?>">
                            <?php echo osc_item_title(); ?>
                        </a>
                        <span class="item-price"><?php echo starter_child_format_price(osc_item_price()); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}
*/

// Register widgets
starter_child_register_widgets();
