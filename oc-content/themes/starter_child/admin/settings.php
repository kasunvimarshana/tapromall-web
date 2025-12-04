<?php
/**
 * Starter Child Theme Admin Settings Page
 * 
 * This file provides the admin interface for configuring the child theme.
 * Settings are stored using the Osclass preferences API.
 * 
 * @package   StarterChild
 * @author    TaproMall Team
 * @version   1.0.0
 */

// Prevent direct access to this file
if (!defined('OC_ADMIN')) {
    exit('Direct access is not allowed.');
}

/**
 * Process form submission
 */
if (Params::getParam('action_specific') === 'starter_child_save_settings') {
    // Verify CSRF token
    osc_csrf_check();
    
    // Get and sanitize form data
    $enable_custom_styles = Params::getParam('enable_custom_styles') === '1' ? '1' : '0';
    $enable_custom_scripts = Params::getParam('enable_custom_scripts') === '1' ? '1' : '0';
    $custom_css = Params::getParam('custom_css', false, false);
    $custom_js = Params::getParam('custom_js', false, false);
    $debug_mode = Params::getParam('debug_mode') === '1' ? '1' : '0';
    
    // Save settings using helper function
    starter_child_set_option('enable_custom_styles', $enable_custom_styles, 'BOOLEAN');
    starter_child_set_option('enable_custom_scripts', $enable_custom_scripts, 'BOOLEAN');
    starter_child_set_option('custom_css', $custom_css, 'STRING');
    starter_child_set_option('custom_js', $custom_js, 'STRING');
    starter_child_set_option('debug_mode', $debug_mode, 'BOOLEAN');
    
    // Show success message
    osc_add_flash_ok_message(
        __('Settings saved successfully!', 'starter_child'),
        'admin'
    );
    
    // Redirect to prevent form resubmission
    osc_redirect_to(osc_admin_render_theme_url('admin/settings.php'));
}

// Get current settings
$enable_custom_styles = starter_child_get_option('enable_custom_styles', '1');
$enable_custom_scripts = starter_child_get_option('enable_custom_scripts', '1');
$custom_css = starter_child_get_option('custom_css', '');
$custom_js = starter_child_get_option('custom_js', '');
$debug_mode = starter_child_get_option('debug_mode', '0');
$theme_version = starter_child_get_option('theme_version', STARTER_CHILD_VERSION);

// Include admin header
osc_current_admin_theme_path('parts/header.php');
?>

<div class="starter-child-admin">
    <h2 class="render-title">
        <?php _e('Starter Child Theme Settings', 'starter_child'); ?>
        <span class="version-badge">v<?php echo osc_esc_html($theme_version); ?></span>
    </h2>
    
    <!-- Theme Information Card -->
    <div class="card">
        <div class="card-header">
            <h3><?php _e('Theme Information', 'starter_child'); ?></h3>
        </div>
        <div class="card-body">
            <table class="table-info">
                <tr>
                    <td><strong><?php _e('Theme Name:', 'starter_child'); ?></strong></td>
                    <td>Starter Child Theme</td>
                </tr>
                <tr>
                    <td><strong><?php _e('Version:', 'starter_child'); ?></strong></td>
                    <td><?php echo osc_esc_html($theme_version); ?></td>
                </tr>
                <tr>
                    <td><strong><?php _e('Parent Theme:', 'starter_child'); ?></strong></td>
                    <td>Starter Osclass Theme</td>
                </tr>
                <tr>
                    <td><strong><?php _e('Description:', 'starter_child'); ?></strong></td>
                    <td><?php _e('Clean, blank child theme following Osclass best practices', 'starter_child'); ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- Settings Form -->
    <div class="card">
        <div class="card-header">
            <h3><?php _e('Theme Configuration', 'starter_child'); ?></h3>
        </div>
        <div class="card-body">
            <form action="<?php echo osc_admin_render_theme_url('admin/settings.php'); ?>" method="post" class="nocsrf">
                <input type="hidden" name="action_specific" value="starter_child_save_settings" />
                <?php osc_csrf_token_form(); ?>
                
                <!-- General Settings -->
                <fieldset>
                    <legend><?php _e('General Settings', 'starter_child'); ?></legend>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" 
                                   name="enable_custom_styles" 
                                   value="1" 
                                   <?php echo ($enable_custom_styles === '1') ? 'checked' : ''; ?> />
                            <?php _e('Enable Custom Styles', 'starter_child'); ?>
                        </label>
                        <p class="help-text">
                            <?php _e('Load the child theme CSS file (style.css)', 'starter_child'); ?>
                        </p>
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" 
                                   name="enable_custom_scripts" 
                                   value="1" 
                                   <?php echo ($enable_custom_scripts === '1') ? 'checked' : ''; ?> />
                            <?php _e('Enable Custom Scripts', 'starter_child'); ?>
                        </label>
                        <p class="help-text">
                            <?php _e('Load the child theme JavaScript file (main.js)', 'starter_child'); ?>
                        </p>
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" 
                                   name="debug_mode" 
                                   value="1" 
                                   <?php echo ($debug_mode === '1') ? 'checked' : ''; ?> />
                            <?php _e('Enable Debug Mode', 'starter_child'); ?>
                        </label>
                        <p class="help-text">
                            <?php _e('Enable debugging output in browser console (development only)', 'starter_child'); ?>
                        </p>
                    </div>
                </fieldset>
                
                <!-- Custom CSS -->
                <fieldset>
                    <legend><?php _e('Custom CSS', 'starter_child'); ?></legend>
                    
                    <div class="form-group">
                        <label for="custom_css">
                            <?php _e('Additional CSS', 'starter_child'); ?>
                        </label>
                        <textarea 
                            id="custom_css" 
                            name="custom_css" 
                            rows="10" 
                            class="code-editor"
                            placeholder="/* Add your custom CSS here */"><?php echo osc_esc_html($custom_css); ?></textarea>
                        <p class="help-text">
                            <?php _e('Add custom CSS code that will be injected into the page head. This is useful for quick styling adjustments without editing theme files.', 'starter_child'); ?>
                        </p>
                    </div>
                </fieldset>
                
                <!-- Custom JavaScript -->
                <fieldset>
                    <legend><?php _e('Custom JavaScript', 'starter_child'); ?></legend>
                    
                    <div class="form-group">
                        <label for="custom_js">
                            <?php _e('Additional JavaScript', 'starter_child'); ?>
                        </label>
                        <textarea 
                            id="custom_js" 
                            name="custom_js" 
                            rows="10" 
                            class="code-editor"
                            placeholder="// Add your custom JavaScript here (without <script> tags)"><?php echo osc_esc_html($custom_js); ?></textarea>
                        <p class="help-text">
                            <?php _e('Add custom JavaScript code that will be injected into the page footer. Do not include &lt;script&gt; tags.', 'starter_child'); ?>
                        </p>
                    </div>
                </fieldset>
                
                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-submit">
                        <?php _e('Save Settings', 'starter_child'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Documentation -->
    <div class="card">
        <div class="card-header">
            <h3><?php _e('Documentation & Support', 'starter_child'); ?></h3>
        </div>
        <div class="card-body">
            <div class="documentation">
                <h4><?php _e('Getting Started', 'starter_child'); ?></h4>
                <p><?php _e('This child theme provides a clean foundation for customizing the Starter theme while maintaining update safety.', 'starter_child'); ?></p>
                
                <h4><?php _e('File Structure', 'starter_child'); ?></h4>
                <ul>
                    <li><code>functions.php</code> - <?php _e('Theme functions and hooks', 'starter_child'); ?></li>
                    <li><code>css/style.css</code> - <?php _e('Custom styles', 'starter_child'); ?></li>
                    <li><code>js/main.js</code> - <?php _e('Custom JavaScript', 'starter_child'); ?></li>
                    <li><code>languages/</code> - <?php _e('Translation files', 'starter_child'); ?></li>
                </ul>
                
                <h4><?php _e('Best Practices', 'starter_child'); ?></h4>
                <ul>
                    <li><?php _e('Use hooks instead of full file overrides whenever possible', 'starter_child'); ?></li>
                    <li><?php _e('Keep all custom code in the child theme, never modify parent theme files', 'starter_child'); ?></li>
                    <li><?php _e('Use proper escaping functions (osc_esc_html, osc_esc_js) for security', 'starter_child'); ?></li>
                    <li><?php _e('Follow Osclass naming conventions (snake_case with osc_ prefix)', 'starter_child'); ?></li>
                    <li><?php _e('Test thoroughly after parent theme updates', 'starter_child'); ?></li>
                </ul>
                
                <h4><?php _e('Resources', 'starter_child'); ?></h4>
                <ul>
                    <li><a href="https://docs.osclass-classifieds.com/developer-guide" target="_blank" rel="noopener">
                        <?php _e('Osclass Developer Guide', 'starter_child'); ?>
                    </a></li>
                    <li><a href="https://docs.osclass-classifieds.com/programming-standards-i75" target="_blank" rel="noopener">
                        <?php _e('Programming Standards', 'starter_child'); ?>
                    </a></li>
                    <li><a href="https://docs.osclass-classifieds.com/child-themes-i79" target="_blank" rel="noopener">
                        <?php _e('Child Theme Guidelines', 'starter_child'); ?>
                    </a></li>
                    <li><a href="https://docs.osclass-classifieds.com/hooks-i118" target="_blank" rel="noopener">
                        <?php _e('Hooks Reference', 'starter_child'); ?>
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
/* Admin page specific styles */
.starter-child-admin .version-badge {
    background: #007bff;
    color: white;
    padding: 4px 8px;
    border-radius: 3px;
    font-size: 12px;
    margin-left: 10px;
}

.starter-child-admin .card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.starter-child-admin .card-header {
    background: #f5f5f5;
    border-bottom: 1px solid #ddd;
    padding: 15px 20px;
}

.starter-child-admin .card-header h3 {
    margin: 0;
    font-size: 16px;
}

.starter-child-admin .card-body {
    padding: 20px;
}

.starter-child-admin .table-info {
    width: 100%;
    border-collapse: collapse;
}

.starter-child-admin .table-info td {
    padding: 10px;
    border-bottom: 1px solid #f0f0f0;
}

.starter-child-admin fieldset {
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    padding: 20px;
    margin-bottom: 20px;
}

.starter-child-admin legend {
    font-weight: bold;
    padding: 0 10px;
    color: #333;
}

.starter-child-admin .form-group {
    margin-bottom: 20px;
}

.starter-child-admin .checkbox-label {
    display: inline-flex;
    align-items: center;
    font-weight: normal;
    cursor: pointer;
}

.starter-child-admin .checkbox-label input[type="checkbox"] {
    margin-right: 8px;
}

.starter-child-admin .help-text {
    color: #666;
    font-size: 13px;
    margin: 5px 0 0 0;
}

.starter-child-admin .code-editor {
    width: 100%;
    font-family: 'Courier New', monospace;
    font-size: 13px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: #f9f9f9;
}

.starter-child-admin .form-actions {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
}

.starter-child-admin .documentation h4 {
    margin-top: 20px;
    margin-bottom: 10px;
    color: #333;
}

.starter-child-admin .documentation ul {
    list-style: disc;
    padding-left: 25px;
}

.starter-child-admin .documentation code {
    background: #f5f5f5;
    padding: 2px 6px;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
    font-size: 13px;
}
</style>

<?php
// Include admin footer
osc_current_admin_theme_path('parts/footer.php');
?>
