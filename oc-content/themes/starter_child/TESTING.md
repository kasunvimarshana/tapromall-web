# Starter Child Theme - Verification & Testing Guide

## Installation Verification

### Step 1: Check File Structure

Verify all required files are present:

```
starter_child/
├── index.php ✓                    (Theme metadata)
├── functions.php ✓                 (Core functions)
├── README.md ✓                     (Documentation)
├── CHANGELOG.md ✓                  (Version history)
├── .gitignore ✓                    (Git configuration)
├── admin/
│   ├── functions.php ✓             (Admin functions)
│   └── settings.php ✓              (Settings page)
├── css/
│   └── style.css ✓                 (Main stylesheet)
├── js/
│   └── main.js ✓                   (Main JavaScript)
├── images/ ✓                       (Image assets)
├── fonts/ ✓                        (Custom fonts)
└── languages/
    └── starter_child.pot ✓         (Translation template)
```

### Step 2: Verify Parent Theme

1. Navigate to `oc-content/themes/`
2. Confirm `starter` directory exists
3. Verify `starter/index.php` contains theme metadata

### Step 3: Activate the Theme

1. Log in to Osclass admin panel
2. Go to **Appearance > Themes**
3. Find "Starter Child Theme"
4. Click "Use this theme"
5. Verify activation message appears

## Functional Testing

### Test 1: Theme Loads Successfully

**Expected Result:**
- Website loads without errors
- No PHP warnings or notices
- Parent theme structure is intact

**How to Test:**
1. Visit the homepage
2. Check browser console (F12) for JavaScript errors
3. Verify page renders correctly

**Status:** [ ] Pass [ ] Fail

---

### Test 2: Custom CSS Loads

**Expected Result:**
- Child theme CSS file is loaded
- Scoped classes work (starter-child-* prefix)

**How to Test:**
1. View page source (Ctrl+U)
2. Search for "starter-child-style"
3. Verify link to `css/style.css` exists
4. Check that CSS variables are defined

**Status:** [ ] Pass [ ] Fail

---

### Test 3: Custom JavaScript Loads

**Expected Result:**
- Child theme JS file is loaded in footer
- StarterChild object is available globally

**How to Test:**
1. Open browser console (F12)
2. Type: `typeof StarterChild`
3. Should return "object"
4. Type: `StarterChild.config.version`
5. Should return "1.0.0"

**Status:** [ ] Pass [ ] Fail

---

### Test 4: Admin Settings Page

**Expected Result:**
- Settings page loads without errors
- All form fields are present
- Save functionality works

**How to Test:**
1. Go to **Appearance > Starter Child Settings**
2. Verify all sections load:
   - Theme Information
   - General Settings
   - Custom CSS
   - Custom JavaScript
   - Documentation
3. Enable "Debug Mode"
4. Click "Save Settings"
5. Verify success message appears
6. Reload page and confirm setting is saved

**Status:** [ ] Pass [ ] Fail

---

### Test 5: Custom CSS Injection

**Expected Result:**
- Custom CSS from admin panel is injected into head

**How to Test:**
1. Go to **Appearance > Starter Child Settings**
2. In "Additional CSS" field, add:
   ```css
   .test-custom-css { color: red; }
   ```
3. Save settings
4. View page source
5. Search for "test-custom-css"
6. Verify it's in a `<style>` tag in the head

**Status:** [ ] Pass [ ] Fail

---

### Test 6: Custom JavaScript Injection

**Expected Result:**
- Custom JS from admin panel is injected into footer

**How to Test:**
1. Go to **Appearance > Starter Child Settings**
2. In "Additional JavaScript" field, add:
   ```javascript
   console.log('Custom JS loaded');
   ```
3. Save settings
4. Reload any page
5. Open browser console
6. Verify "Custom JS loaded" message appears

**Status:** [ ] Pass [ ] Fail

---

### Test 7: Hook System

**Expected Result:**
- Hooks are properly registered and execute

**How to Test:**
1. Edit `functions.php`
2. Add test hook:
   ```php
   function test_hook_execution() {
       echo '<!-- Test Hook Executed -->';
   }
   osc_add_hook('header', 'test_hook_execution', 10);
   ```
3. View page source
4. Search for "Test Hook Executed"
5. Remove test code after verification

**Status:** [ ] Pass [ ] Fail

---

### Test 8: Translation Support

**Expected Result:**
- Translation functions work correctly

**How to Test:**
1. Check that text domain is loaded
2. Verify POT file exists in `languages/`
3. Strings use proper translation functions:
   - `__('string', 'starter_child')`
   - `_e('string', 'starter_child')`

**Status:** [ ] Pass [ ] Fail

---

### Test 9: Responsive Design

**Expected Result:**
- Theme is responsive on all devices

**How to Test:**
1. Use browser's responsive design mode (F12 > Device icon)
2. Test common breakpoints:
   - Mobile (320px, 375px, 414px)
   - Tablet (768px, 1024px)
   - Desktop (1280px, 1920px)
3. Verify layout adjusts properly
4. Check navigation menu on mobile

**Status:** [ ] Pass [ ] Fail

---

### Test 10: Accessibility

**Expected Result:**
- Theme meets WCAG 2.1 AA standards

**How to Test:**
1. Test keyboard navigation (Tab key)
2. Verify focus states are visible
3. Check skip link functionality
4. Use screen reader (if available)
5. Run accessibility audit in Chrome DevTools:
   - F12 > Lighthouse > Accessibility

**Status:** [ ] Pass [ ] Fail

---

### Test 11: Performance

**Expected Result:**
- No performance regressions
- Assets load efficiently

**How to Test:**
1. Run Lighthouse performance test:
   - F12 > Lighthouse > Performance
2. Verify scores:
   - Performance: > 90
   - Accessibility: > 90
   - Best Practices: > 90
   - SEO: > 90
3. Check Network tab for asset loading

**Status:** [ ] Pass [ ] Fail

---

### Test 12: Security

**Expected Result:**
- Proper escaping and sanitization

**How to Test:**
1. Review code for:
   - `osc_esc_html()` usage
   - `osc_esc_js()` usage
   - `esc_attr()` usage
2. Verify CSRF tokens in forms:
   - `osc_csrf_token_form()`
3. Check for SQL injection prevention:
   - Using `Params::getParam()`

**Status:** [ ] Pass [ ] Fail

---

## Compatibility Testing

### Test 13: Parent Theme Update

**Expected Result:**
- Child theme continues to work after parent update

**How to Test:**
1. Note current parent theme version
2. If update available, perform update
3. Clear cache
4. Verify child theme still works
5. Check for any console errors

**Status:** [ ] Pass [ ] Fail

---

### Test 14: Browser Compatibility

**Expected Result:**
- Works on all major browsers

**Browsers to Test:**
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile Safari (iOS)
- [ ] Chrome Mobile (Android)

**Status:** [ ] Pass [ ] Fail

---

### Test 15: Plugin Compatibility

**Expected Result:**
- No conflicts with common plugins

**How to Test:**
1. Install common Osclass plugins
2. Verify theme continues to work
3. Check for JavaScript conflicts
4. Test form submissions

**Status:** [ ] Pass [ ] Fail

---

## Code Quality Checks

### Test 16: PHP Syntax

**Expected Result:**
- All PHP files are syntactically correct

**How to Test:**
```bash
php -l functions.php
php -l admin/settings.php
php -l admin/functions.php
```

**Result:** ✓ All files passed syntax check

**Status:** [✓] Pass [ ] Fail

---

### Test 17: Code Standards

**Expected Result:**
- Code follows Osclass standards

**Checklist:**
- [ ] Function names use snake_case
- [ ] Functions have osc_ or starter_child_ prefix
- [ ] Variables use snake_case
- [ ] Constants use UPPERCASE
- [ ] Proper indentation (4 spaces)
- [ ] PHPDoc blocks for all functions
- [ ] No trailing whitespace

**Status:** [ ] Pass [ ] Fail

---

### Test 18: Documentation

**Expected Result:**
- All code is properly documented

**Checklist:**
- [ ] README.md is comprehensive
- [ ] CHANGELOG.md is up to date
- [ ] Inline comments explain complex logic
- [ ] All functions have PHPDoc blocks
- [ ] Admin settings page has help text

**Status:** [ ] Pass [ ] Fail

---

## Post-Deployment Checklist

After deploying to production:

1. [ ] Backup current theme
2. [ ] Upload child theme files
3. [ ] Activate child theme
4. [ ] Test all critical functionality
5. [ ] Verify no console errors
6. [ ] Check responsive design
7. [ ] Test form submissions
8. [ ] Verify analytics still work
9. [ ] Check SEO meta tags
10. [ ] Monitor for 24 hours

## Troubleshooting

### Issue: Theme not appearing in admin panel

**Solution:**
1. Verify `index.php` exists with proper metadata
2. Check file permissions (755 for directories, 644 for files)
3. Clear Osclass cache

### Issue: CSS not loading

**Solution:**
1. Check "Enable Custom Styles" is enabled in settings
2. Verify file path: `oc-content/themes/starter_child/css/style.css`
3. Clear browser cache (Ctrl+F5)

### Issue: JavaScript errors

**Solution:**
1. Check browser console for specific errors
2. Verify jQuery is loaded before child theme scripts
3. Check for conflicts with other scripts

### Issue: Parent theme not found

**Solution:**
1. Verify parent theme (starter) is installed
2. Check spelling in `index.php`: `Parent Theme: starter`
3. Ensure parent theme directory name matches exactly

## Performance Benchmarks

### Expected Metrics

| Metric | Target | Actual |
|--------|--------|--------|
| Page Load Time | < 2s | ___ |
| Time to Interactive | < 3s | ___ |
| First Contentful Paint | < 1.5s | ___ |
| Total Page Size | < 1MB | ___ |
| HTTP Requests | < 50 | ___ |
| Lighthouse Performance | > 90 | ___ |

## Security Audit

### Checklist

- [ ] No direct file access possible
- [ ] All user input is sanitized
- [ ] All output is escaped
- [ ] CSRF tokens used in all forms
- [ ] No sensitive data in public files
- [ ] Secure file permissions
- [ ] No SQL injection vulnerabilities
- [ ] XSS protection in place

## Final Sign-Off

**Theme Version:** 1.0.0  
**Test Date:** ___________  
**Tested By:** ___________  
**Environment:** [ ] Development [ ] Staging [ ] Production  

**Overall Status:** [ ] Pass [ ] Fail

**Notes:**
_______________________________________________________________
_______________________________________________________________
_______________________________________________________________

**Approved for Production:** [ ] Yes [ ] No

**Signature:** ___________  
**Date:** ___________

---

## Continuous Monitoring

After deployment, monitor:

1. **Error Logs** - Check for PHP warnings/errors
2. **Console Errors** - Monitor browser console
3. **Performance** - Track page load times
4. **User Feedback** - Note any reported issues
5. **Analytics** - Verify tracking works
6. **Uptime** - Monitor site availability

## Maintenance Schedule

- **Weekly:** Check for parent theme updates
- **Monthly:** Review and optimize performance
- **Quarterly:** Update documentation
- **Annually:** Major version review

---

**Last Updated:** 2024-12-04  
**Document Version:** 1.0
