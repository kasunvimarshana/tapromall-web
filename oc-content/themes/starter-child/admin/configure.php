<?php
/**
 * Starter Child Theme - Admin Configuration Page
 *
 * Admin interface for child theme settings.
 * Accessible from: oc-admin > Theme Setting > Child Theme Settings
 *
 * @package StarterChild
 * @subpackage Admin
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('OC_ADMIN')) {
    exit('Direct access not allowed.');
}

// Process form submission
if (Params::getParam('starter_child_settings') === 'done') {
    // Save settings
    osc_set_preference(
        'custom_css_enabled',
        Params::getParam('custom_css_enabled') ? '1' : '0',
        'starter_child_theme'
    );
    osc_set_preference(
        'custom_js_enabled',
        Params::getParam('custom_js_enabled') ? '1' : '0',
        'starter_child_theme'
    );
    osc_set_preference(
        'debug_mode',
        Params::getParam('debug_mode') ? '1' : '0',
        'starter_child_theme'
    );
    
    osc_reset_preferences();
    osc_add_flash_ok_message(__('Child theme settings saved successfully', 'starter-child'), 'admin');
    
    header('Location: ' . osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/configure.php'));
    exit;
}

// Get current settings
$custom_css_enabled = osc_get_preference('custom_css_enabled', 'starter_child_theme');
$custom_js_enabled = osc_get_preference('custom_js_enabled', 'starter_child_theme');
$debug_mode = osc_get_preference('debug_mode', 'starter_child_theme');

/**
 * Helper function to output checked attribute for checkboxes
 *
 * @param string $value The preference value
 * @return string The checked attribute or empty string
 */
function starter_child_checked($value) {
    return ($value === '1') ? 'checked="checked"' : '';
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .child-settings-wrap {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .child-settings-header {
            background: #fff;
            border: 1px solid #ccd0d4;
            padding: 20px;
            margin-bottom: 20px;
        }
        .child-settings-header h2 {
            margin: 0 0 10px 0;
            padding: 0;
        }
        .child-settings-section {
            background: #fff;
            border: 1px solid #ccd0d4;
            margin-bottom: 20px;
        }
        .child-settings-section h3 {
            margin: 0;
            padding: 15px 20px;
            border-bottom: 1px solid #ccd0d4;
            background: #f9f9f9;
        }
        .child-settings-form {
            padding: 20px;
        }
        .child-form-row {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        .child-form-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .child-form-row label {
            display: flex;
            align-items: flex-start;
            cursor: pointer;
        }
        .child-form-row input[type="checkbox"] {
            margin-right: 10px;
            margin-top: 3px;
        }
        .child-form-row .label-content strong {
            display: block;
            margin-bottom: 5px;
        }
        .child-form-row .label-content span {
            color: #666;
            font-size: 13px;
        }
        .child-info-box {
            background: #e7f3fe;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin-bottom: 20px;
        }
        .child-info-box h4 {
            margin: 0 0 10px 0;
            color: #1976d2;
        }
        .child-info-box p {
            margin: 0;
            font-size: 13px;
        }
        .child-info-box code {
            background: #fff;
            padding: 2px 6px;
            border-radius: 3px;
        }
        .child-submit-row {
            padding: 15px 20px;
            background: #f9f9f9;
            border-top: 1px solid #ccd0d4;
        }
        .child-version {
            float: right;
            color: #999;
            font-size: 12px;
            line-height: 30px;
        }
    </style>
</head>
<body>

<div class="child-settings-wrap">
    
    <div class="child-settings-header">
        <h2><?php _e('Starter Child Theme Settings', 'starter-child'); ?></h2>
        <p><?php _e('Configure your child theme options. These settings allow you to customize the behavior of the child theme without modifying code.', 'starter-child'); ?></p>
    </div>

    <div class="child-info-box">
        <h4><?php _e('Child Theme Information', 'starter-child'); ?></h4>
        <p>
            <?php _e('This child theme extends the Starter theme. Template overrides can be placed in:', 'starter-child'); ?>
            <code>oc-content/themes/starter-child/templates/</code>
        </p>
    </div>

    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/configure.php'); ?>" method="post">
        <input type="hidden" name="starter_child_settings" value="done" />
        
        <div class="child-settings-section">
            <h3><?php _e('Asset Settings', 'starter-child'); ?></h3>
            <div class="child-settings-form">
                
                <div class="child-form-row">
                    <label>
                        <input type="checkbox" name="custom_css_enabled" value="1" <?php echo starter_child_checked($custom_css_enabled); ?> />
                        <div class="label-content">
                            <strong><?php _e('Enable Custom CSS', 'starter-child'); ?></strong>
                            <span><?php _e('Load the child theme stylesheet (child-style.css). Disable to use only parent theme styles.', 'starter-child'); ?></span>
                        </div>
                    </label>
                </div>
                
                <div class="child-form-row">
                    <label>
                        <input type="checkbox" name="custom_js_enabled" value="1" <?php echo starter_child_checked($custom_js_enabled); ?> />
                        <div class="label-content">
                            <strong><?php _e('Enable Custom JavaScript', 'starter-child'); ?></strong>
                            <span><?php _e('Load the child theme JavaScript (child-scripts.js). Disable to use only parent theme scripts.', 'starter-child'); ?></span>
                        </div>
                    </label>
                </div>
                
            </div>
        </div>

        <div class="child-settings-section">
            <h3><?php _e('Developer Settings', 'starter-child'); ?></h3>
            <div class="child-settings-form">
                
                <div class="child-form-row">
                    <label>
                        <input type="checkbox" name="debug_mode" value="1" <?php echo starter_child_checked($debug_mode); ?> />
                        <div class="label-content">
                            <strong><?php _e('Debug Mode', 'starter-child'); ?></strong>
                            <span><?php _e('Enable debug logging in the browser console. For development use only.', 'starter-child'); ?></span>
                        </div>
                    </label>
                </div>
                
            </div>
        </div>

        <div class="child-submit-row">
            <button type="submit" class="btn btn-submit"><?php _e('Save Changes', 'starter-child'); ?></button>
            <span class="child-version"><?php _e('Version', 'starter-child'); ?>: <?php echo STARTER_CHILD_VERSION; ?></span>
        </div>
        
    </form>

</div>

</body>
</html>
