# tapromall-web

TaproMall is a multi-classified, multi-tenant, multi-vendor marketplace application built for global users. Developed with SOLID, DRY, and clean-code principles, it delivers intelligent search, personalized recommendations, real-time updates, secure transactions, and seamless management of products, services, vehicles, real estate, and jobs.

Observe (https://docs.osclass-classifieds.com)(https://docs.osclass-classifieds.com/developer-guide) (https://docs.osclass-classifieds.com/programming-standards-i75) Programming Standards Osclass PHP Coding Standards & Best Practices Following proper coding standards ensures better maintainability, security, and performance in Osclass development. Below is an improved guide based on best practices observed in the latest Osclass coding style. General Coding Conventions Function Naming Function names in Osclass follow the snake*case convention with an osc* prefix to maintain consistency. Example: function osc*get_currency_row($code, $cache = true) { ... } Data Validation Data should be validated before processing. Example: $code = strtoupper(trim((string)$code)); if ($code == '' || strlen($code) != 3) { return false; } This ensures that the currency code is always uppercase and exactly three characters long. Using Caching to Improve Performance Osclass caching system reduces redundant database queries. It checks if the data exists in the cache before querying the database: if ($cache === true && View::newInstance()->\_exists('currency*' . $code)) { return View::newInstance()->_get('currency_' . $code); } To store new data in the cache: View::newInstance()->_exportVariableToView('currency_' . $code, $currency); Efficient Database Queries Instead of retrieving the entire database, use indexed queries for performance: $currency = Currency::newInstance()->findByPrimaryKey($code); Fetching all records efficiently: function osc*get_currencies_all($by_pk = false) { $key = 'currencies*' . (string)$by_pk; if (!View::newInstance()->_exists($key)) { $currencies = Currency::newInstance()->listAllRaw(); $output = []; if (!empty($currencies)) { foreach ($currencies as $cur_row) { $output[$by*pk ? $cur_row['pk_c_code'] : []] = $cur_row; } } View::newInstance()->_exportVariableToView($key, $output); return $output; } return View::newInstance()->_get($key); } Recommended Improvements Use of Strict Typing Adding strict typing improves readability and prevents unexpected errors. Example: function osc_get_currency_row(string $code, bool $cache = true): array|false { ... } Error Handling & Logging Ensure errors are logged properly instead of silently failing: if (!$currency) { error_log('Currency not found: ' . $code); } Using empty() Instead of count() Instead of checking both is_array() and count() > 0, simplify: if (!empty($currencies)) { ... } Conclusion By following these coding standards, you ensure that Osclass applications remain optimized, maintainable, and secure. Implement proper validation, caching, and efficient queries to enhance performance. (https://docs.osclass-classifieds.com/query-items-custom-listings-select-i86) Query Items (custom listings select) Displaying Specific Listings Using osc_query_item() Osclass provides a powerful function osc_query_item($params) that allows developers to filter and display listings dynamically based on various criteria. This function supports **multiple filtering options** and can be used to fine-tune the selection of listings displayed on a page. Filtering listings can be useful for custom sections like: Showing listings from a specific country, region or city Displaying premium listings only Filtering listings based on category or author Showing only listings with images Applying price-based filters Sorting and limiting results per page How to Use osc_query_item() The function accepts a string or an array of parameters to filter the listings based on specific criteria. The returned listings can then be displayed using Osclass template functions. Filtering by a Single Parameter To retrieve all listings from a specific region (e.g., Madrid), use: <?php osc_query_item("region_name=Madrid"); ?> Filtering by Multiple Parameters To retrieve listings based on **multiple** conditions, pass an array of filters: <?php osc_query_item(array( "category_name" => "cars,houses", "city_name" => "Madrid", "premium" => "1" )); ?> In the above example, the function will return listings from Madrid, limited to cars and houses, and only those marked as premium. Available Filtering Parameters Osclass allows filtering listings using the following parameters: Parameter Description author Filters listings by user ID author_email Filters listings by user email country / country_name Filters by country ID or name region / region_name Filters by region ID or name city / city_name Filters by city ID or name city_area / city_area_name Filters by city area ID or name category / category_name Filters by category ID or name premium Shows only premium listings (1 = Yes, 0 = No) with_picture Shows only listings with images (1 = Yes, 0 = No) max_price Filters listings with price below a certain value min_price Filters listings with price above a certain value zip Filters listings by ZIP code condition Filters listings by item condition item_condition Filters listings based on predefined item condition values locale Filters listings by user locale results_per_page Defines the number of results per page page Specifies the pagination page number offset Skips a specified number of results order Defines sorting order, e.g., order=price,DESC Displaying Filtered Listings Once the function has retrieved the listings, you can display them using Osclass template functions. <?php if (osc_count_custom_items() == 0) { ?> <p class="empty"><?php _e('No Listings', 'modern'); ?></p> <?php } else { ?> <table border="0" cellspacing="0"> <tbody> <?php while (osc_has_custom_items()) { ?> <tr class="<?php echo (osc_item_is_premium() ? ' premium' : ''); ?>"> <td class="photo"> <a href="<?php echo osc_item_url(); ?>"> <img src="<?php echo osc_resource_thumbnail_url(); ?>" width="75" height="56" alt="<?php echo osc_item_title(); ?>" /> </a> </td> <td class="text"> <h3><a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a></h3> <p><?php echo osc_item_formated_price(); ?> - <?php echo osc_item_city(); ?> (<?php echo osc_item_region(); ?>) - <?php echo osc_format_date(osc_item_pub_date()); ?></p> <p><?php echo osc_highlight(strip_tags(osc_item_description())); ?></p> </td> </tr> <?php } ?> </tbody> </table> <?php } ?> Conclusion The osc_query_item() function is a highly flexible method for retrieving Osclass listings dynamically. It supports multiple filtering parameters, sorting options, and pagination, making it an essential tool for customizing how listings are displayed on your site. (https://docs.osclass-classifieds.com/hooks-i118) Hooks A hook is a small piece of code that allows you to insert more code (plugin) in the middle of certain Osclass’ actions. Usage of hooks To use a hook add the following code to your plugin file : osc_add_hook('hook_name', 'function_name', 'priority'); Substitute ‘hook_name’ by the name of the hook you want to attach ‘function_name’, and ‘function_name’ with the name of your function. ‘priority’ is number 1-10 that identifies priority/order to include/run function in hook. If you want to run function at the end, use priority 10. If you want to run function at start, use priority 1. Special hooks There exists some special hooks This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel); osc_add_hook(**FILE** . "\_configure", 'function_name'); This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel); osc_add_hook(**FILE** . "\_uninstall", 'function_name'); Init hooks init : inits on the front end useful for enqueueing scripts and styles init_admin : inits on the admin end useful for enqueueing scripts and styles Ajax hooks ajax_my_hook : Run when AJAX request sent from frontend. Example if you execute function abc_my_func via ajax, then hook name will be “ajax_abc_my_func”. ajax_admin_my_hook : Run when AJAX request sent from admin. ajax_custom: Run as ajax action “custom_ajax” Item hooks pre_item_post : Run before an item is posted. pre_item_add : Run before an item is posted. $aItem, $flash_error are passed as argument. show_item : Run at the beginning of item’s detail page. $item is passed as argument. NOTE: This will be execute BEFORE the header item_detail : Run at the middle of item’s detail page. $item is passed as argument. USE THIS is you want to make an attributes plugins renew_item : Run when an item is renewed. $id is passed as argument activate_item : Run when an item is activated. $id is passed as argument deactivate_item : Run when an item is deactivated. $id is passed as argument enable_item : Run when an item is enable. $id is passed as argument disable_item : Run when an item is disable. $id is passed as argument posted_item : Run when an item is posted. $item is passed as argument edited_item : Run when an item is edited. $item is passed as argument new_item : Run at the form for publishing new items add_comment : When some user add a comment to an item. $item is passed as argument location : Run at item’s detail page. Just after item_detail hook item_form : Run at publish new item form. USE this if you want to make an attributes plugin. $catId is passed as argument post_item : Run before a publish new item page is loaded before_item_edit : Run before a edit item page is loaded item_edit : Run at editing item form. Same as item_form/item_detail. $cat_id and $item_id are passed as arguments item_edit_post : Run after submitting the information when editing an item DEPRECATED removed in v3.2 use edited_item instead item_form_post : Run after submitting the information when publishing an item. $catId, and $id are passed as argument DEPRECATED removed in v3.2 use posted_item instead after_item_post : Run after ‘item_form_post’ and some other actions (send emails,…) DEPRECATED removed in v3.2 use posted_item instead delete_item : When an item is deleted. $id is passed as argument before_delete_item: Before item is being removed. $item is passed as argument (from Osclass 8.1.2) item_premium_on : When an item is marked as premium item_premium_off : When an item is unmarked as premium item_spam_on : When an item is marked as spam (since 2.4) item_spam_off : When an item is unmarked as spam (since 2.4) item_contact_form : Run at the contact item publisher form, so you could add your own filters and options (since 3.1) hook_email_item_inquiry : Run when an inquiry email is sent. $item is passed as argument. hook_email_item_validation : Run when an inquiry email is validated. $item is passed as argument. hook_email_item_validation_non_register_user : $item is passed as an argument. hook_email_new_item_non_register_user : $item is passed as an argument. Resource hooks regenerate_image : Run before an image is regenerated. $resource is passed as an argument. regenerated_image : Run after an image is regenerated. $resource is passed as an argument. delete_resource : Run after a resource is deleted. $resource is passed as an argument. uploaded_file : Run after a file is uploaded. $resource is passed as an argument. Comment hooks edit_comment : Run when editing of comment is complete. $id is passed as argument edit_comment_reply: Run when editing of comment that is reply to other comment is complete. $id of parent comment is passed as argument (from Osclass 8.0.3). Executed after edit_comment is executed. enable_comment : $id is passed as argument disable_comment : $id is passed as argument activate_comment : $id is passed as argument deactivate_comment : $id is passed as argument delete_comment : $id is passed as argument add_comment : $id is passed as argument hook_email_new_comment_user : Run when email sent to user after a new comment is posted. $item is passed as argument. hook_email_new_comment_admin : Run when email sent to after a new comment is posted. $item is passed as argument. hook_email_comment_validated : $comment is passed as argument. User hooks before_user_register : Run before the user registration form is processed. register_user : Run when an user complete the registration process. $user is passed as argument validate_user : Run when an user gets validated (if they didn’t do it automatically) before_login : Run before user login is created. after_login : Run when user is successfully loged in. $user and $url_redirect are passed as params. logout : Run when an user logout on your site. user_register_form : Run after the form for users registration. Useful if you want to add special requirements to your users user_register_completed : Run after registration of an user is completed. user_profile_form : Run before update button of user’s profile user_forgot_password_form : Run inside user forgot password form (Osclass 8.3 or later) user_recover_form : Run inside user recover password form (Osclass 8.3 or later) user_form : Run after the form of user’s profile delete_user : Run before user is removed. In time of running hook, user record is still available in user table. $id is passed as argument activate_user: Run after user has been activated. $id is passed as argument dectivate_user: Run after user has been deactivated. $id is passed as argument enable_user: Run after user has been enabled. $id is passed as argument disable_user: Run after user has been disabled. $id is passed as argument register_email_taken : Run when email used at register is already exist (*3.1*) pre_user_post : Run before an user complete the registration, or edit his account (*3.1*) user_register_completed : $userId is passed as an argument. user_edit_completed : $userId is passed as an argument. hook_email_admin_new_user : Run when admin emailed after user account activated. hook_email_user_registration : Run when a user registration email is created, just before the “validate_user” hook. hook_email_user_validation : Run when a non-admin user is validated, or when activation is resent. $user, $input are sent as arguments. hook_email_send_friend : Run when a friend email is sent. $item is passed as argument. hook_email_user_forgot_password : Run when user requests new password. $user, $password_url are sent as arguments. hook_email_contact_user : Run when contact email sent to user. $id, $yourEmail, $yourName, $phoneNumber, $message are sent as arguments. Search hooks before_search : Run before a search request. search : Run at search page. Object $search is passed as argument search_form : Run at the search’s form, so you could add your own filters and options. $catId is passed as argument search_conditions : Run when the search is submitted, useful to add new conditions to search custom_query : Run when a custom query is processed. $key and $value are passed as arguments. highlight_class : Run in item loop (loop-single.php) and used to add specific class to listing. RSS feed hooks rss_before : Runs at start of RSS feed (after description is added) rss_after : Runs at end of RSS feed (before closing channel) rss_item : Runs in items loop. Item ID is passed as argument. Feed related feed : Run at feed page. $feed is passed as argument feed_XYZ : Run at XYZ’s feed page (see extra feeds plugin). $items is passed as argument HTML hook before_error_page : Run before generating an error page after_error_page : Run after generating an error page header : Run at header footer : Run at footer admin_menu : Run in the middle of the admin’s menu. Useful to add your custom options to Osclass/Plugins admin_header : Run at the header in the admin panel admin_footer : Run at the footer in the admin panel admin_users_table : Run ad addTableHeader function in datatables user_menu : Run in the middle of the user’s account menu. Useful to add custom options to user’s account menu user_menu_before, user_menu_top, user_menu_bottom, user_menu_after : Additional user menu hooks, available from Osclass v8.3.0 before_html : Before the html is displayed on the browser after_html : After the html is ‘displayed’. Note: This run is on the server, it’s run after the HTML code is sent to the browser, since some resources are loaded externally (JS, CSS, images,…) it’s run before the HTML complete its load process. Cron hooks cron : Run at manual cron system cron_hourly : Run at manual cron system hourly cron_daily : Run at manual cron system daily cron_weekly : Run at manual cron system weekly Sitemap related before_sitemap : Run before generating the sitemap after_sitemap : Run after generating the sitemap Others hooks user_locale_changed: Run when locale has been changed. $locale_code is passed as argument delete_locale : When a locale is deleted. $locale is passed as argument delete_category : Run at category deletion before_rewrite_rules : Run before the rewrite rules are generated, a pointer to the rewrite object is passed after_rewrite_rules : Run after the rewrite rules are generated, a pointer to the rewrite object is passed admin_register_form : Run after the form for contact site administrator. Useful if you want to add special requirements to your contacts. contact_form : Run at the contact admin form, so you could add your own filters and options (contact.php) (since 3.1) init : Run after frontend has finished loading. init_admin : Run after admin has finished loading. theme_activate : Run when a theme is activated. $theme is passed as an argument. before_show_pagination_admin : Run before pagination on admin pages. after_show_pagination_admin : Run after pagination on admin pages. alert_created : Run when alert is created via ajax (does not mean successfully created!) hook_email_alert_validation : Run when alert email validated. $alert, $email, $secret are passed as arguments. hook_email_new_email : Run when user email is changed. $new_email, $validation_url are passed as arguments. hook_alert_email_instant : Run when an instant alert is sent. $user, $ads, $s_search are passed as arguments. hook_alert_email_hourly : Run when an hourly alert is sent. $user, $ads, $s_search are passed as arguments. hook_alert_email_daily : Run when a daily alert is sent. $user, $ads, $s_search are passed as arguments. hook_alert_email_weekly : Run when a weekly alert is sent. $user, $ads, $s_search are passed as arguments. structured_data_header: Run at header structured data block. structured_data_footer: Run at footer structured data block. before_auto_upgrade: Run before auto-upgrade starts osclass upgrade. after_auto_upgrade: Run after auto-upgrade starts osclass upgrade. $result is passed as argument. after_upgrade: Run after osclass upgrade has finished. $error is passed as argument. admin_items_header, admin_items_actions, admin_items_form_left_top, admin_items_form_left_middle, admin_items_form_right_top: Run in item edit page in backoffice. osc_item() is available in hook. (Osclass 8.0.2). admin_dashboard_top, admin_dashboard_bottom: Run in backoffice dashboard page (Osclass 8.0.3). admin_dashboard_col1_top, admin_dashboard_col1_bot, admin_dashboard_col2_top, admin_dashboard_col2* bot , admin*dashboard_col3_top, admin_dashboard_col3* bot : Run in admin dashboard (home) page (Osclass 8.2.0) admin*dashboard_setting_top, admin_dashboard_setting_col1, admin_dashboard_setting_col2, admin_dashboard_setting_col3: Run at admin dashboard settings page (Osclass 8.2.0) admin_translations_list_top, admin_translations_list_bottom: Run in backoffice translations list page (Osclass 8.0.3). admin_translations_edit_top, admin_translations_edit_bottom, admin_translations_edit_buttons_top, admin_translations_edit_buttons_middle, admin_translations_edit_buttons_bottom, admin_translations_edit_catalog, admin_translations_edit_stats, admin_translations_edit_options, admin_translations_edit_form, admin_translations_edit_actions: Run in backoffice translations edit page (Osclass 8.0.3). pre_send_email: Run at start of send mail function. $params are passed as arguments. (Osclass 8.0.2). before_send_email: Run right before mail is being sent in send mail function. $params, $mail are passed as arguments. (Osclass 8.0.2). after_send_email: Run when email was sent successfully in send mail function. $params, $mail are passed as arguments. (Osclass 8.0.2). Admin panel hooks add_admin_toolbar_menus : Run at the end of AdminToolbar::add_menus(), you can add more actions to toolbar before render it. New design theme hooks In Osclass 8.2.0, many new theme hooks has been introduced for better customization options and plugins integration. Header header_top header_links header_bottom header_after Footer footer_pre footer_top footer_links footer_after Home page home_search_pre home_search_top home_search_bottom home_search_after home_top home_latest home_premium home_bottom Item page item_top item_title item_images item_meta item_description item_contact item_comment item_comment_form item_bottom item_sidebar_top item_sidebar_bottom Search page search_items_top search_items_filter search_items_bottom search_sidebar_pre search_sidebar_top search_sidebar_bottom search_sidebar_after Item loop item_loop_top item_loop_title_after item_loop_description_after item_loop_bottom User dashboard page user_dashboard_top user_dashboard_bottom user_dashboard_links User items page user_items_top user_items_bottom user_items_body user_items_action user_items_search_form_top (Osclass 8.3) user_items_search_form_bottom (Osclass 8.3) Public profile page user_profile_top user_profile_sidebar user_public_profile_items_top user_public_profile_sidebar_top user_public_profile_sidebar_bottom user_public_profile_search_form_top (Osclass 8.3) user_public_profile_search_form_bottom (Osclass 8.3) Publish & edit page item_publish_top item_publish_category item_publish_description item_publish_price item_publish_location item_publish_seller item_publish_images item_publish_hook item_publish_buttons item_publish_bottom (for recaptcha, right before buttons) item_publish_after Themes those support these new hooks must have constant THEME_COMPATIBLE_WITH_OSCLASS_HOOKS defined and set to value 820 or higher. For publish & edit page, there are item_post and item_edit hooks automatically generated with variants and linked to these hooks. Hooks are being executed with ajax calls just when any functions are hooked to them. Publish post hooks item_form (original) item_form_top item_form_category item_form_description item_form_price item_form_location item_form_seller item_form_images item_form_hook item_form_buttons item_form_bottom item_form_after Edit post hooks item_edit (original) item_edit_top item_edit_category item_edit_description item_edit_price item_edit_location item_edit_seller item_edit_images item_edit_hook item_edit_buttons item_edit_bottom item_edit_after (https://docs.osclass-classifieds.com/filters-i119) Filters A filter is functionality that allows to modify content of particular functions (price format, item title etc.). Function added to filter have 1 input parameter – content that can be modified. Function returns output as modified content. osc_add_filter('filter_name', 'function_name'); Example for filters might be need to capitalize items title: osc_add_filter('item_title', function($title) { return ucwords($title); }); List of filters Keep in mind that not all filters are listed here, we will try to make this list as accurate as possible. List is written in form: {name of filter} / {file where filter is used} / {short description}. item_title / item.php – affects the title of the item item_description / item.php – affects the description of the item item_price_null, item_price_zero, item_price – item price filters item_contact_name, item_contact_phone, item_contact_other, item_contact_email / hItem.php – item contact information (Osclass 8.0.2) item_post_data, item_edit_data – run right before item data are entered into database (Osclass 8.0.3) item_post_location_data, item_post_image_data, item_post_email_data, item_post_meta_data – run before each of the data is entered into Database (Osclass 8.2.0) item_edit_location_data, item_edit_image_data, item_edit_meta_data – run right before each of data is entered into database (Osclass 8.2.0) before_send_friend – run before send friend is executed (Osclass 8.2.0) before_validate_contact, before_contact – run before item contact (Osclass 8.2.0) user_insert_data, user_edit_data, user_update_description – run right before user data (or user description data) are inserted into database (Osclass 8.0.3) comment_insert_data – run right before comment is entered into database. slug / model / Category.php – could change the slug of the categories (usefull for especial characters as ä, ü, …) resource_path / media_processing.php(oc-admin) – affects the resource path structured_data_title_filter / structured-data.php – affects the title in structured data structured_data_description_filter / structured-data.php – affects the description in structured data structured_data_image_filter / structured-data.php – affects the image in structured data structured_data_url_filter / structured-data.php – affects the current URL in structured data actions_manage_items / items_processing.php – could add more actions on actions list at manage listing. An array of ‘actions’ is passed and an array with the item information. more_actions_manage_items / items_processing.php – could add more actions on ‘more actions’ list at manage listing. An array of ‘actions’ is passed and an array with the item information. actions_manage_users / items_processing.php – could add more actions on actions list at manage users. An array of ‘actions’ is passed and an array with the user information. more_actions_manage_users / items_processing.php – could add more actions on ‘more actions’ list at manage users. An array of ‘actions’ is passed and an array with the user information. datatable_user_class / user/index.php – backoffice user list row class <tr class="<?php echo implode(' ', osc_apply_filter('datatable_user_class', array(), $aRawRows[$key], $row)); ?>"> datatable_listing_class / item/index.php – backoffice listing list row class <tr class="<?php echo implode(' ', osc_apply_filter('datatable_listing_class', array(), $aRawRows[$key], $row)); ?>"> datatable_alert_class / user/alert.php – backoffice alert list row class <tr class="<?php echo implode(' ', osc_apply_filter('datatable_alert_class', array(), $aRawRows[$key], $row)); ?>"> meta_generator / oc-load.php – Osclass generator meta tag limit_alert_items / controller / user.php – change number of listings returned with each alert. By default, 12 listings is returned (added in Osclass 8.0.2) user_public_profile_items_per_page / controller / user-non-secure.php – change number of per page listings returned on public profile page. (added in Osclass 8.0.2 as public_items_per_page, changed in Osclass 8.3 into user_public_profile_items_per_page) user_items_per_page / controller / user.php – change number of per page listings returned on user items page. (added in Osclass 8.3) search_list_orders / helpers / hSearch.php – change predefined list (array) of order types/options (added in Osclass 8.0.2). Default options are: Newly listed, Lower price first, Higher price first. search_list_columns / model / Search.php – list of allowed columns for sorting (added in Osclass 8.0.2). Default values are i_price, dt_pub_date, dt_expiration. search_list_types / model / Search.php – list of allowed sorting types (added in Osclass 8.0.2). Default values are asc, desc. ipdata_service_map / osclass / functions.php – array with mapping for geo service (IP data) to retrieve country code and related data for subdomains. rtl_lang_codes / helpers / hDefines.php – array of rtl language codes (5-letter long) used to identify if language is on RTL list. Only used when b_rtl is not defined for language. subdomain_top_url / helpers / hDefines.php – URL used to navigate to top-level domain. Used when subdomains are activated. Example: https://domain.com/index.php?nored=1 rewrite_rules_array_init / oc-includes / osclass / classes / Rewrite.php – List of rewrite rules read from DB on initialize. Can be modified, altered or added new rules. Array has structure $key => $value, where $key represent regex and $value represent redirect. See “List of default Osclass rewrite rules” section at bottom of this page. rewrite_rules_array_save / oc-includes / osclass / classes / Rewrite.php – List of rewrite rules right before they are saved into database. rss_add_item / oc-includes / osclass / classes / RSSFeed.php – Single item added into RSS items. (added in Osclass 8.2.0) rss_items / oc-includes / osclass / classes / RSSFeed.php – All RSS items before loop starts. (added in Osclass 8.2.0) canonical_url_public_profile / oc-includes / osclass / controller / user-non-secure.php – canonical URL before stored into view canonical_url_search / oc-includes / osclass / controller / search.php – canonical URL before stored into view canonical_url_osc / oc-includes / osclass / helpers / hSearch.php – get canonical URL from view canonical_url / oc-includes / osclass / functions.php – default canonical url if “generate canonical url always” is enabled in Settings > General, before url is stored into view widget_content / oc-includes / osclass / helpers / hUtils.php – applied on widget content if not empty widget_content_wrap / oc-includes / osclass / functions.php – applied on widget content after wrapped into div pre_send_mail_filter / oc-includes / osclass / utils.php – if this filter returns array(‘stop’ => true), no email will be sent. Use $params and $type as parameters (Osclass 8.3). structured_data_rating_value, structured_data_rating_best, structured_data_rating_worst, structured_data_rating_count / oc-includes / osclass / structured-data.php – support customization of structured data ratings (Osclass 8.3) item_stats_increase / oc-includes / osclass / model / ItemStats.php – before stats is increased (decreased), final value can be modified via this hook (Osclass 8.3) page_visibility_custom_check / oc-includes / osclass /controller / page.php – run custom functions to validate custom static page visibility rule osc_static_page_visibility_options / oc-includes / osclass / helpers/ hPage.php – encrich static page visibility options user_items_custom_conditions_and, user_items_custom_conditions_or / oc-includes / osclass / controller / user.php – custom conditions for user items query user_public_profile_custom_conditions_and, user_public_profile_custom_conditions_or/ oc-includes / osclass / controller / user-non-secure.php – custom conditions for public profile items query TinyMCE image uploader related filters (oc-admin/themes/omega/): tinymce_accepted_origins tinymce_allowed_extensions tinymce_image_folder_path tinymce_image_folder_url tinymce_file_name Extract of all known filters from code (Osclass 3.9) login_admin_title login_admin_url login_admin_image page_templates admin_favicons admin_item_title admin_page_title admin_item_description admin_page_description actions_manage_alerts more_actions_manage_rules rules_processing_row comments_processing_row actions_manage_items items_processing_row items_processing_reported_row resource_path media_processing_row pages_processing_row more_actions_manage_users actions_manage_users users_processing_row email_legend_words watermark_font_path watermark_text_value watermark_font_size theme_url style_url contact_params pre_show_item pre_show_items item_title correct_login_url_redirect email_description save_latest_searches_pattern moderator_access theme mo_core_path mo_theme_path mo_plugin_path mo_theme_messages_path mo_core_messages_path email_alert_validation_title email_alert_validation_description email_alert_validation_title_after email_alert_validation_description_after alert_email_hourly_title alert_email_hourly_description alert_email_hourly_title_after alert_email_hourly_description_after alert_email_daily_title alert_email_daily_description alert_email_daily_title_after alert_email_daily_description_after alert_email_weekly_title alert_email_weekly_description alert_email_weekly_title_after alert_email_weekly_description_after alert_email_instant_title alert_email_instant_description alert_email_instant_title_after alert_email_instant_description_after email_comment_validated_title email_comment_validated_title_after email_comment_validated_description email_comment_validated_description_after email_new_item_non_register_user_title email_new_item_non_register_user_title_after email_new_item_non_register_user_description email_new_item_non_register_user_description_after email_user_forgot_pass_word_title email_user_forgot_pass_word_title_after email_user_forgot_password_description email_user_forgot_password_description_after email_user_registration_title email_user_registration_title_after email_user_registration_description email_user_registration_description_after email_title email_new_email_title email_new_email_title_after email_new_email_description email_new_email_description_after email_user_validation_title email_user_validation_title_after email_send_friend_title email_send_friend_title_after email_send_friend_description email_send_friend_description_after email_item_inquiry_title email_item_inquiry_title_after email_item_inquiry_description email_item_inquiry_description_after email_new_comment_admin_title email_new_comment_admin_title_after email_item_validation_title email_item_validation_title_after email_item_validation_description email_item_validation_description_after email_admin_new_item_title email_admin_new_item_title_after email_admin_new_item_description email_admin_new_item_description_after email_item_validation_non_register_user_title email_item_validation_non_register_user_title_after email_item_validation_non_register_user_description email_item_validation_non_register_user_description_after email_admin_user_registration_title email_admin_user_registration_title_after email_admin_user_regsitration_description email_admin_user_regsitration_description_after email_item_inquiry_title email_item_inquiry_title_after email_item_inquiry_description email_item_inquiry_description_after email_new_comment_user_title email_new_comment_user_title_after email_new_comment_user_description email_new_comment_user_description_after email_new_admin_title email_new_admin_title_after email_new_admin_description email_new_admin_description_after email_warn_expiration_title email_warn_expiration_title_after email_warn_expiration_description email_warn_expiration_description_after email_after_auto_upgrade_title email_after_auto_upgrade_title_after email_after_auto_upgrade_description email_after_auto_upgrade_description_after osc_item_edit_meta_textarea_value_filter meta_title_filter meta_description_filter meta_description_filter current_admin_menu* base*url admin_base_url item_price flash_message_text osc_show_flash_message osc_add_flash_message_value gettext ngettext user_menu_filter item_add_prepare_data pre_item_add_error item_edit_prepare_data pre_item_edit_error item_prepare_data upload_image_extension upload_image_mime slug search_cond_pattern (Osclass 8.2.0) sql_search_conditions sql_search_fields sql_search_item_conditions user_add_flash_error init_send_mail mail_from mail_from_name pre_send_mail shutdown_functions List of default Osclass rewrite rules [^contact/?$] => index.php?page=contact [^feed/?$] => index.php?page=search&sFeed=rss [^feed/(.+)/?$] => index.php?page=search&sFeed=$1 [^language/(.*?)/?$] => index.php?page=language&locale=$1 [^search$] => index.php?page=search [^search/(.*)$] => index.php?page=search&sParams=$1 [^item/mark/(.*?)/([0-9]+)/?$] => index.php?page=item&action=mark&as=$1&id=$2 [^item/send-friend/([0-9]+)/?$] => index.php?page=item&action=send_friend&id=$1 [^item/contact/([0-9]+)/?$] => index.php?page=item&action=contact&id=$1 [^item/new/?$] => index.php?page=item&action=item_add [^item/new/([0-9]+)/?$] => index.php?page=item&action=item_add&catId=$1 [^item/activate/([0-9]+)/(.*?)/?$] => index.php?page=item&action=activate&id=$1&secret=$2 [^item/deactivate/([0-9]+)/(.*?)/?$] => index.php?page=item&action=deactivate&id=$1&secret=$2 [^item/renew/([0-9]+)/(.*?)/?$] => index.php?page=item&action=renew&id=$1&secret=$2 [^item/edit/([0-9]+)/(.*?)/?$] => index.php?page=item&action=item_edit&id=$1&secret=$2 [^item/delete/([0-9]+)/(.*?)/?$] => index.php?page=item&action=item_delete&id=$1&secret=$2 [^resource/delete/([0-9]+)/([0-9]+)/([0-9A-Za-z]+)/?(.*?)/?$] => index.php?page=item&action=deleteResource&id=$1&item=$2&code=$3&secret=$4 [^([a-z]{2})*([A-Z]{2})/._/.__i([0-9]+)\?comments-page=([0-9al]\*)$] => index.php?page=item&id=$3&lang=$1_$2&comments-page=$4 [^.*/.*_i([0-9]+)\?comments-page=([0-9al]*)$] => index.php?page=item&id=$1&comments-page=$2 [^([a-z]{2})_([A-Z]{2})/.*/.*_i([0-9]+)$] => index.php?page=item&id=$3&lang=$1_$2 [^.*/.*_i([0-9]+)$] => index.php?page=item&id=$1 [^user/login/?$] => index.php?page=login [^user/dashboard/?$] => index.php?page=user&action=dashboard [^user/logout/?$] => index.php?page=main&action=logout [^user/register/?$] => index.php?page=register&action=register [^user/activate/([0-9]+)/(._?)/?$] => index.php?page=register&action=validate&id=$1&code=$2 [^alert/confirm/([0-9]+)/([a-zA-Z0-9]+)/(.+)$] => index.php?page=user&action=activate_alert&id=$1&email=$3&secret=$2 [^user/profile/?$] => index.php?page=user&action=profile [^user/profile/([0-9]+)/?$] => index.php?page=user&action=pub_profile&id=$1 [^user/profile/(.+)/?$] => index.php?page=user&action=pub_profile&username=$1 [^user/items/?$] => index.php?page=user&action=items [^user/alerts/?$] => index.php?page=user&action=alerts [^user/recover/?$] => index.php?page=login&action=recover [^user/forgot/([0-9]+)/(._)/?$] => index.php?page=login&action=forgot&userId=$1&code=$2 [^password/change/?$] => index.php?page=user&action=change*password [^email/change/?$] => index.php?page=user&action=change_email [^username/change/?$] => index.php?page=user&action=change_username [^email/confirm/([0-9]+)/(.\*?)/?$] => index.php?page=user&action=change_email_confirm&userId=$1&code=$2 [^([\p{L}\p{N}*\-,]+)-p([0-9]+)/?$] => index.php?page=page&id=$2&slug=$1 [^([a-z]{2})_([A-Z]{2})/([\p{L}\p{N}_\-,]+)-p([0-9]+)/?$] => index.php?page=page&lang=$1_$2&id=$4&slug=$3 [^([a-z]{2})-([A-Z]{2})/([\p{L}\p{N}_\-,]+)-p([0-9]+)/?$] => index.php?page=page&lang=$1_$2&id=$4&slug=$3 [^([a-z]{2})/([\p{L}\p{N}_\-,]+)-p([0-9]+)/?$] => index.php?page=page&lang=$1&id=$3&slug=$2 [^(.+?)\.php(.*)$] => $1.php$2 [^(.+)/([0-9]+)$] => index.php?page=search&iPage=$2 [^(.+)/?$] => index.php?page=search&sCategory=$1 [^(.+)$] => index.php?page=search (https://docs.osclass-classifieds.com/child-themes-i79) Child Themes Creating a Child Theme in Osclass A child theme in Osclass allows customization of a theme without modifying the original (parent) theme. This approach ensures that updates to the parent theme do not overwrite custom modifications. Child themes contain only the files that need modification, reducing redundancy and improving maintainability. Why Use a Child Theme? Child themes are beneficial for: Preserving custom modifications while allowing updates to the parent theme. Keeping customization separate, making it easier to manage and troubleshoot. Allowing selective modification of specific files without affecting the entire theme. Creating a Blank Child Theme Step 1: Create the Child Theme Folder Navigate to oc-content/themes/ and create a new folder for the child theme. The recommended naming format is yourtheme*child. For example, if the parent theme is gamma, the child theme folder should be gamma_child. Step 2: Add Essential Files Inside the newly created folder, add the following files: index.php – Required to define the theme and set the parent theme. screenshot.png – A preview image displayed in the backoffice. Step 3: Define the Child Theme Open index.php and add the following metadata: <?php /* Theme Name: Gamma CHILD Osclass Theme Theme URI: https://osclasspoint.com/ Description: Child theme for Gamma Osclass Theme Version: 1.0.0 Author: Your Name Author URI: https://osclasspoint.com Widgets: header,footer Theme update URI: gamma-osclass-theme Product Key: XYZ123 Parent Theme: gamma */ ?> This defines the child theme and its relationship with the parent theme. Working with a Child Theme Understanding File Inheritance Osclass loads theme files from the child theme first. If a file does not exist in the child theme, Osclass loads it from the parent theme. This allows selective customization without duplicating all files. Replacing Theme Files There are two types of file replacements: Osclass-Initiated Files: Directly loaded by Osclass, such as main.php, search.php, item.php, and user-register.php. Theme-Initiated Files: Loaded dynamically, such as header.php, head.php, loop-single.php, and search_gallery.php. Adding Custom CSS Step 1: Create a Custom Stylesheet To add a custom stylesheet without modifying the parent theme’s head.php, use a function to enqueue the new stylesheet. Create a functions.php file in the child theme folder and add the following function: <?php function gam_child_custom_css() { osc_enqueue_style('style-child', osc_current_web_theme_url('css/style-child.css')); } osc_add_hook('header', 'gam_child_custom_css'); ?> Next, create a css/ folder inside the child theme directory and add a style-child.css file. The website will now load this custom stylesheet. Modifying the Footer Step 1: Copy the Main Template File To change the footer only on the homepage: Copy main.php from the parent theme to the child theme. Edit the copied main.php and replace this line: <?php osc_current_web_theme_path('footer.php'); ?> with: <?php include osc_base_path() . 'oc-content/themes/gamma_child/footer.php'; ?> Then, create a new footer.php file in the child theme and add custom content: <footer>Hello world footer!</footer> Adding Content to the Homepage To insert custom content on the homepage: Copy main.php to the child theme. Open main.php and add the desired text. Best Practices for Child Themes Handling Translations Translations for the child theme should be placed in oc-content/languages. Ensure the language files match the child theme name. Tracking Parent Theme Updates Since parent theme updates may introduce changes, use a version control system or compare files to keep track of modifications. Recommended Use It is best to use child themes for adding CSS, JavaScript, and functions via hooks rather than modifying core files. Extensive modifications may require frequent updates when the parent theme changes. Conclusion Using a child theme in Osclass ensures easy customization while maintaining compatibility with future updates. It provides a structured way to apply changes without affecting the parent theme. Always test modifications on a staging environment before applying them to a live site. (https://docs.osclass-classifieds.com/user-image-uploader-avatar-i84) User Image Uploader (avatar) Integrating the User Image Uploader (Avatar) into the User Profile Osclass now includes a built-in profile (avatar) image uploader, removing the need for third-party plugins. However, many themes do not utilize this feature because they were developed before it was available. This guide will show you how to integrate the built-in image uploader into your theme. We will use your_theme as a placeholder. Replace this with the actual folder name of your theme, such as alpha, beta, gamma, delta, epsilon, veronika, stela, etc. Two Integration Methods For Osclass 8.2.0 and higher (simplified method) For Osclass 8.1.2 and lower (manual method with Cropper.js integration) Method 1: Osclass 8.2.0 and Higher Step 1: Modify the user profile file Open the file oc-content/themes/your_theme/user-profile.php Find the opening <form> tag and locate the last hidden input field Insert the following code right after the last hidden input field: <?php if(osc_profile_img_users_enabled()) { ?> <div class="control-group"> <label class="control-label" for="name"><?php _e('Picture', 'your_theme'); ?></label> <div class="controls"> <div class="user-img"> <div class="img-preview"> <img src="<?php echo osc_user_profile_img_url(osc_logged_user_id()); ?>" alt="<?php echo osc_esc_html(osc_logged_user_name()); ?>"/> </div> </div> <div class="user-img-button"> <?php UserForm::upload_profile_img(); ?> </div> </div> </div> <?php } ?> That’s it. The uploader should now appear in the user profile page. You may want to adjust CSS styling in your theme for buttons. Method 2: Osclass 8.1.2 and Lower For Osclass 8.1.2 and earlier, the integration requires additional JavaScript and CSS (Cropper.js). Step 1: Enqueue Cropper.js Open the file oc-content/themes/your_theme/user-profile.php At the top of the file, right after the opening <?php tag, insert the following code: if(osc_profile_img_users_enabled() == '1') { osc_enqueue_script('cropper'); osc_enqueue_style('cropper', osc_assets_url('js/cropper/cropper.min.css')); } Step 2: Modify the User Profile Form Now, find the <form> tag inside user-profile.php and locate the last hidden input field. Insert the following right after it: <?php if(osc_profile_img_users_enabled()) { ?> <div class="control-group"> <label class="control-label" for="name"><?php _e('Picture', 'your_theme'); ?></label> <div class="controls"> <div class="user-img"> <div class="img-preview"> <img src="<?php echo osc_user_profile_img_url(osc_logged_user_id()); ?>" alt="<?php echo osc_esc_html(osc_logged_user_name()); ?>"/> </div> </div> <div class="user-img-button"> <?php UserForm::upload_profile_img(); ?> </div> </div> </div> <?php } ?> Step 3: Remove Old Plugin Code Since you are now using Osclass’s built-in image uploader, remove any legacy profile picture plugin code from user-profile.php. Final Code for Osclass 8.1.2 and Lower After completing the above steps, your user-profile.php file should look like this: <?php /* * Copyright 2014 Osclass * Copyright 2021 Osclass by OsclassPoint.com * * Osclass maintained & developed by OsclassPoint.com */ if(osc_profile_img_users_enabled() == '1') { osc_enqueue_script('cropper'); osc_enqueue_style('cropper', osc_assets_url('js/cropper/cropper.min.css')); } // meta tag robots osc_add_hook('header','sigma_nofollow_construct'); sigma_add_body_class('user user-profile'); osc_add_hook('before-main','sidebar'); function sidebar(){ osc_current_web_theme_path('user-sidebar.php'); } osc_add_filter('meta_title_filter','custom_meta_title'); function custom_meta_title($data){ return __('Update account', 'sigma'); } osc_current_web_theme_path('header.php') ; $osc_user = osc_user(); ?> <h1><?php _e('Update account', 'sigma'); ?></h1> <?php UserForm::location_javascript(); ?> <div class="form-container form-horizontal"> <div class="resp-wrapper"> <ul id="error_list"></ul> <form action="<?php echo osc_base_url(true); ?>" method="post"> <input type="hidden" name="page" value="user" /> <input type="hidden" name="action" value="profile_post" /> <?php if(osc_profile_img_users_enabled()) { ?> <div class="control-group"> <label class="control-label" for="name"><?php _e('Picture', 'sigma'); ?></label> <div class="controls"> <div class="user-img"> <div class="img-preview"> <img src="<?php echo osc_user_profile_img_url(osc_logged_user_id()); ?>" alt="<?php echo osc_esc_html(osc_logged_user_name()); ?>"/> </div> </div> <div class="user-img-button"> <?php UserForm::upload_profile_img(); ?> </div> </div> </div> <?php } ?> (https://docs.osclass-classifieds.com/emoji-in-texts-i109) Emoji in Texts Osclass 8.3 supports Emoji in textual fields, however for existing installation there may be action required on site owners. As it's not possible to automatically convert some tables charset to utf8mb4 due to foreign keys, it's manual process left to site owners. Procedure to convert tables 1. List of tables oc_t_locale oc_t_user_description oc_t_pages_description oc_t_category_description oc_t_keywords (optional) oc_t_preferece (optional) 2. Drop indexes In first step, drop indexes on fk_c_locale_code column that would block conversion. It's ideal to store index definition so you can recreate it after. 3. Change tables charset to utf8mb4 Now it's time to update tables so they support emoji. ALTER TABLE oc_t_locale CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; ALTER TABLE oc_t_pages_description CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; ALTER TABLE oc_t_category_description CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; ALTER TABLE oc_t_user_description CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; ALTER TABLE oc_t_keywords CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; ALTER TABLE oc_t_preference CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; 4. Create indexes to locale table All is completed, now just add back indexes. Sample index definition: ALTER TABLE oc_t_pages_description ADD INDEX fk_c_locale_code (fk_c_locale_code) USING BTREE; Summary You have now converted tables into utf8mb4 charset that supports emoji. Note that when you will convert locale table, you might get more tables/indexes complaining. You will need to drop all of them and then recreate. Also note there should be no serious harm not to create indexes back. (https://docs.osclass-classifieds.com/use-optimized-functions-i111) Use Optimized Functions Osclass 8.3 brings a lot of new functions including optimized data loader functions those avoid excessive and repetitive database queries and store them into session for possible repetitive use, sort or filter. Optimized Functions How it works? Let's analyze it: Problem: get list of available countries from Osclass and then US country. Function: $data = Country::newInstance()->listAll(); $row = Country::newInstance()->findByCode('US'); In above scenario, if we repeat using these functions 50 times, we get 100 database queries/calls all together. That's quite a lot! This was pretty fast, but what if we need that on 50 different files? And what if we need just one country? Or we have 20 queries getting country-level data - country by country? ... this leads to many repetitive database calls. Some can be optimized by using database cache like memcached, but some of them not. What can we do about it? Use optimized way to access data: Solution: Store data into session and for specific row-level queries reuse these data. Function: $data = osc_get_countries(); $row = osc_get_country_row('US'); In this case, if we use just 1 database call. Why one? because at first, all country data are loaded from database and stored into session. When we try to get US data next, we first check if this value was already received from DB and stored into session. If it's there - use it! Support and limitations We have such functions for most of data - country, region, city, category, user, ... In many cases, it's not possible to load everything into session as it's too much data and it would be slow. For categories, there is also available constant OPTIMIZE_CATEGORIES (true/false) and OPTIMIZE_CATEGORIES_LIMIT (int) to enable/disable preloads into session. Default value is between 1000-2000 categories. If you use more, it's not going to preload everything. Anyway, for objects like user, item... these are still going to be stored under their IDs, as when we received data for one item or user from DB, why not to store it for possible reuse? Especially for premium items or logged user record it's going to save a lot of queries. Summary Use optimized functions anywhere it's possible to reduce database queries, review helper files for list of supported functions in your current Osclass installation. (https://docs.osclass-classifieds.com/alert-frequency-buttons-integration-into-theme-i116) Alert frequency buttons integration into theme Osclass 8.3 brings possibility to select alerts (subscriptions) frequency. Available values are: Instant (using minutely cron) Hourly Daily Weekly To support this feature, place following code into your alert section: <?php echo osc_alert_change_frequency(osc_alert()); ?> Note that in some themes, osc_alert() might not return valida values, as alerts might be printed with loop. Identify what object stores current alert object and replace osc_alert() with for example $alert. In such case, integration code would look like: <?php echo osc_alert_change_frequency(osc_alert()); ?> Update your style.css to show it nicely: /* ALERTS FREQUENCY */ .alert-frequency {display:flex;float: left; align-items: center; flex-wrap: nowrap;margin:2px 0 10px 0;} .alert-frequency > a {padding:5px 10px;font-size:14px;line-height:16px;margin:0 -1px 0 0;border:1px solid #ccc;background:#fff;} .alert-frequency > a:first-child {border-radius:4px 0 0 4px;} .alert-frequency > a:last-child {border-radius:0 4px 4px 0;} .alert-frequency > a.active {background:#f0f0f0;font-weight:600;} .alert-frequency > a:hover {text-decoration:none;background:#f0f0f0;} Alert name Osclass 8.3 also generates alert names and store these values into database. Up to now, alert names might be generated dynamically that was pretty expensive task and could also be inaccurate. To use alert name, just replace current name with: <?php echo osc_alert_name(); ?> As in previous integration, even here might happen that osc_alert() is not available and alert object is stored in variable. Let's say it's again variable $alert. In such case update your integration to: <?php echo $alert['s_name']; ?> Note that existing alerts will not be given name, it's valid just for newly created alerts, so it could be helpful to check if name is defined, if not use old method. Example is here: <?php if(function_exists('osc_alert_name') && isset($a['s_name']) && $a['s_name'] != '') { echo $a['s_name']; } else { echo __('Alert', 'alpha') . ' #' . $c; } ?> Hope this article helps you to implement new Osclass features! (https://docs.osclass-classifieds.com/user-items-filter-and-public-profile-filter-implementation-i117) User Items Filter and Public Profile Filter Implementation In this guide we will implement new Osclass 8.3 features - filters of listings in User Items page and Public Profile page. These filters allow users to quickly refine items in case there is many of them. User Items Filter Go to your theme folder, open user-items.php and place there (ideally above items) following code: <form name="user-items-search" action="<?php echo osc_base_url(true); ?>" method="get" class="user-items-search-form nocsrf"> <input type="hidden" name="page" value="user"/> <input type="hidden" name="action" value="items"/> <?php osc_run_hook('user_items_search_form_top'); ?> <div class="control-group"> <label class="control-label" for="sItemType"><?php _e('Item type', 'alpha'); ?></label> <div class="controls"> <?php UserForm::search_item_type_select(); ?> </div> </div> <div class="control-group"> <label class="control-label" for="sPattern"><?php _e('Keyword', 'alpha'); ?></label> <div class="controls"> <?php UserForm::search_pattern_text(); ?> </div> </div> <div class="control-group"> <label class="control-label" for="sCategory"><?php _e('Category', 'alpha'); ?></label> <div class="controls"> <?php UserForm::search_category_select(); ?> </div> </div> <?php osc_run_hook('user_items_search_form_bottom'); ?> <div class="actions"> <button type="submit" class="btn btn-primary"><?php _e('Apply', 'alpha'); ?></button> </div> </form> Stylesheet update (style.css): /* USER ITEMS SEARCH */ form[name="user-items-search"] {display:flex;flex-direction: row; align-items: flex-end;margin:2px 0 14px 0;width:100%;padding-right:15px;} form[name="user-items-search"] .control-group {width:fit-content;padding:0 12px 6px 0;} form[name="user-items-search"] .control-group label {float:left;width:100%;text-align:left;margin:0 0 2px 0;} form[name="user-items-search"] .control-group .controls {float:left;width:100%;margin:0;} form[name="user-items-search"] .control-group .controls input, form[name="user-items-search"] .control-group .controls select {float:left;width:100%;margin:0;max-width:100%;min-width:unset;} form[name="user-items-search"] .actions {width:fit-content;padding:0 0 6px 0;} form[name="user-items-search"] .actions button {white-space:nowrap;font-weight:600;} @media screen and (max-width: 540px) { form[name="user-items-search"] {flex-wrap: wrap;} form[name="user-items-search"] .control-group {width:50%;} } Public Profile Filter Go to your theme folder, open user-public-profile.php and place there (ideally above items) following code: <form name="user-public-profile-search" action="<?php echo osc_base_url(true); ?>" method="get" class="user-public-profile-search-form nocsrf"> <input type="hidden" name="page" value="user"/> <input type="hidden" name="action" value="pub_profile"/> <input type="hidden" name="id" value="<?php echo osc_esc_html($user['pk_i_id']); ?>"/> <?php osc_run_hook('user_public_profile_search_form_top'); ?> <div class="control-group"> <label class="control-label" for="sPattern"><?php _e('Keyword', 'alpha'); ?></label> <div class="controls"> <?php UserForm::search_pattern_text(); ?> </div> </div> <div class="control-group"> <label class="control-label" for="sCategory"><?php _e('Category', 'alpha'); ?></label> <div class="controls"> <?php UserForm::search_category_select(); ?> </div> </div> <div class="control-group"> <label class="control-label" for="sCity"><?php _e('City', 'alpha'); ?></label> <div class="controls"> <?php UserForm::search_city_select(); ?> </div> </div> <?php osc_run_hook('user_public_profile_search_form_bottom'); ?> <div class="actions"> <button type="submit" class="btn btn-primary"><?php _e('Apply', 'alpha'); ?></button> </div> </form> Stylesheet update (style.css): /* USER PUBLIC PROFILE SEARCH */ form[name="user-public-profile-search"] {display:flex;flex-direction: row; align-items: flex-end;margin:15px 0 0px 0;width:100%;padding:0 15px;} form[name="user-public-profile-search"] .control-group {width:fit-content;padding:0 12px 6px 0;} form[name="user-public-profile-search"] .control-group label {float:left;width:100%;text-align:left;margin:0 0 2px 0;} form[name="user-public-profile-search"] .control-group .controls {float:left;width:100%;margin:0;} form[name="user-public-profile-search"] .control-group .controls input, form[name="user-public-profile-search"] .control-group .controls select {float:left;width:100%;margin:0;max-width:100%;min-width:unset;} form[name="user-public-profile-search"] .actions {width:fit-content;padding:0 0 6px 0;} form[name="user-public-profile-search"] .actions button {white-space:nowrap;font-weight:600;} @media screen and (max-width: 540px) { form[name="user-public-profile-search"] {flex-wrap: wrap;} form[name="user-public-profile-search"] .control-group {width:50%;} } /code> Available Filter Options to Customize There are more filters then included by default. Feel free to customize based on your preference and business need: search_pattern_text search_category_select search_country_select search_region_select search_city_select search_item_type_select In future, there might be even more available. Please review the Clean Coder resources (https://blog.cleancoder.com ), the Clean Architecture article (https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html ), and the official Osclass documentation, including the Developer Guide (https://docs.osclass-classifieds.com/developer-guide ), Programming Standards (https://docs.osclass-classifieds.com/programming-standards-i75 ), Child Theme Guidelines (https://docs.osclass-classifieds.com/child-themes-i79 ) (https://osclasspoint.com/blog/osclass-create-child-theme-b21), and the Customization Guide for Hooks, Themes, and Plugins (https://osclass-classifieds.com/article/developer-guide-customizing-osclass-hooks-themes-plugins ). The Ultimate Developer's Guide to Customizing Osclass: Hooks, Themes, and PluginsOsclass stands apart in the world of classifieds software due to its deliberate simplicity and raw power. As a standalone application built with pure, framework-free PHP, it offers developers an unparalleled level of control and performance, unburdened by the overhead of a multi-purpose CMS. This direct access, however, is governed by a single, unbreakable rule: Never, ever hack the core.This in-depth technical guide is for PHP developers ready to master the Osclass platform the right way. We will dissect the three pillars of professional Osclass development: leveraging the powerful Hooks system for seamless interaction, building Child Themes for complete visual control, and engineering robust Plugins to introduce new functionality. By mastering these concepts, you can build any type of marketplace imaginable while ensuring your platform remains secure, stable, and easily upgradeable.The Golden Rule: Why Hacking the Core is a Dead End Before you write a single line of code, this principle must be understood. Modifying Osclass core files (any file within the oc-admin or oc-includes directories) is a critical error that leads to three disastrous outcomes: Updates Will Destroy Your Work: The moment you update to a new version of Osclass to get security patches or new features, all your custom modifications will be permanently overwritten. You Create Security Vulnerabilities: Modifying core files can inadvertently introduce security holes and makes your site incompatible with official security patches. Debugging Becomes Impossible: When issues arise, you won't be able to determine if the problem is a bug in the Osclass core or in your own custom code, making support from the community impossible. The entire Osclass architecture is designed to be extended safely and efficiently through its APIs, primarily using the powerful system of **Hooks**.Part 1: Mastering Osclass Hooks (The Core Interaction API) The Hooks system is the central nervous system of Osclass development. It allows your custom code to interact with the Osclass core at hundreds of specific points without ever modifying a core file. It's directly inspired by the WordPress Hooks system and consists of two distinct types: **Actions** and **Filters**.A. Actions: Executing Your Code at Specific Events Actions are specific events that occur during the Osclass execution lifecycle (e.g., header, posted_item, user_register_completed). When Osclass reaches one of these points, it triggers the hook, checks if any functions are "registered" to it, and executes them in order of priority.You use the function osc_add_hook() to attach your custom function to an action.osc_add_hook(string $hook_name, callable $function_name, int $priority = 10); Action Example 1: Adding a Tracking Script to the Footer This is a classic "Hello World" for hooks. Instead of editing footer.php, you hook into the footer action.// In your plugin's main file or your theme's functions.php function my_custom_tracking_script() { echo '<!-- Custom Google Tag Manager Code -->' . PHP_EOL; echo "<script>console.log('Page loaded, tracking initialized.');</script>" . PHP_EOL; } osc_add_hook('footer', 'my_custom_tracking_script'); Action Example 2: Performing an Action After a Listing is Published Let's create a more advanced function that logs the title of every new listing to a text file. We'll use the posted_item hook, which conveniently passes the complete item data array to our function.function log_new_listing_title($item) { // The $item array contains all data for the newly posted item. // Let's get the title and the ID. $itemTitle = $item['s_title']; $itemId = $item['pk_i_id']; $logMessage = date('Y-m-d H:i:s') . " - New Listing Published (ID: " . $itemId . "): " . $itemTitle . PHP_EOL; // Define the path to our log file in a writable directory $logFile = osc_content_path() . 'logs/new_listings.log'; // Use file_put_contents with the FILE_APPEND flag to add to the log @file_put_contents($logFile, $logMessage, FILE_APPEND); } osc_add_hook('posted_item', 'log_new_listing_title'); Comprehensive Action Hook Reference While there are hundreds of hooks, here are some of the most critical for developers: System Hooks: init (runs early), before_html (before any HTML output), after_html (after all HTML output). Header & Footer Hooks: header (in <head>), admin_header, footer (before </body>), admin_footer. Item (Listing) Hooks: pre_item_add (before adding to DB), posted_item (after adding), pre_item_edit (before editing), edited_item (after editing), delete_item (passes $itemId), item_form (to add fields to the publish form), item_detail (to add content to the listing page). User Hooks: before_user_register (before registration), user_register_completed (after registration, passes $userId), delete_user (passes $userId), profile_form (to add fields to the user profile). Search Hooks: search_form (to add fields to the search form). B. Filters: Intercepting and Modifying Data Filters are even more powerful than actions. They give you the ability to intercept data, modify it, and then return it before it's used by Osclass (either for display or for saving to the database). The most important rule of filters is that your hooked function must always return a value.You use osc_add_filter() to attach your function to a filter.osc_add_filter(string $filter_name, callable $function_name, int $priority = 10); Filter Example 1: Appending Text to Every Listing Title A simple example to illustrate the concept. We intercept the title, add our text, and return it.function append_text_to_title($title) { // IMPORTANT: Always return the modified (or original) variable return $title . ' - For Sale'; } osc_add_filter('item_title', 'append_text_to_title'); Filter Example 2: Enforcing a Minimum Price The correct way to validate or modify input before it's saved to the database is to use an early action hook like pre_item_add or pre_item_edit to check the submitted parameters.function validate_minimum_price() { $price = Params::getParam('price'); $min_price = 5000000; // Price is stored in millionths ($5.00) // Check if a price was submitted and if it's below the minimum if ($price !== '' && $price < $min_price) { // Add a flash message to inform the user osc_add_flash_error_message('The minimum price is $5. Please enter a higher value.'); // Redirect back to the form. For the publish form: osc_redirect_to(osc_item_post_url()); } } osc_add_hook('pre_item_add', 'validate_minimum_price'); osc_add_hook('pre_item_edit', 'validate_minimum_price'); Filter Example 3 (Advanced): Excluding a Category from Search The search_conditions filter is extremely powerful. It lets you modify the array of WHERE conditions for the item search SQL query. Let's exclude category ID 99 (e.g., "Archived Items") from all public searches.function exclude_category_from_search($conditions) { // Add our custom WHERE clause to the array of conditions $conditions[] = DB_TABLE_PREFIX . 't_item.fk_i_category_id <> 99'; return $conditions; } osc_add_filter('search_conditions', 'exclude_category_from_search'); Comprehensive Filter Hook Reference Meta Data Filters: meta_title, meta_description, canonical_url. Item Data Filters: item_title, item_description, item_price. Form & Input Filters: item_edit_prepare (modify item data before it populates the edit form). Search Filters: search_conditions (modify WHERE clause), search_order (modify ORDER BY), search_sql (modify the entire SQL query). Email Filters: email_user_registration_subject, email_user_registration_description (and many others for every email template). Part 2: Theme Development (The Presentation Layer) The theme controls 100% of the HTML output of your Osclass site. A deep understanding of its structure is key to creating a unique user experience.A. The Child Theme: The Professional Standard As with the core, you should never directly edit a theme you didn't create. Always create a Child Theme. This allows you to update the parent theme (to get bug fixes and new features) without losing your customizations.To create a child theme for the default "Bender" theme: Create a new folder: oc-content/themes/bender-child/. Inside it, create index.php with this header: <?php /* Theme Name: Bender Child Template: bender */ ?> The Template: bender line is the magic that links it to the parent. Create a functions.php file in your child theme folder. This is where you can add your custom hooks and functions. Activate your "Bender Child" theme in the admin panel. To modify a template file (e.g., item.php), simply copy it from the parent (bender/item.php) to your child theme (bender-child/item.php) and edit it there. Osclass will automatically use your child theme's version.B. Understanding The Osclass Loop The "Loop" is the standard mechanism Osclass uses to display a list of items on a search page. Understanding it is fundamental to theme development.<?php if (osc_has_items()) { ?> <div class="listings"> <?php while (osc_has_items()) { ?> <div class="listing-item"> <h3><a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a></h3> <p class="price"><?php echo osc_item_formatted_price(); ?></p> <p class="location"><?php echo osc_item_city(); ?>, <?php echo osc_item_region(); ?></p> <?php if(osc_count_item_resources() > 0) { ?> <a href="<?php echo osc_item_url(); ?>"> <img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" loading="lazy"> </a> <?php } ?> </div> <?php } ?> </div> <?php if (osc_search_total_pages() > 1) { ?> <div class="pagination"> <?php echo osc_search_pagination(); ?> </div> <?php } ?> <?php } else { ?> <p class="empty-search">No listings found.</p> <?php } ?> Part 3: Building a Plugin (The Functionality Layer) When you need to add new, self-contained functionality that is independent of the visual theme, a plugin is the correct tool.A. Plugin Activation, Deactivation, and Uninstallation A professional plugin cleans up after itself. Osclass provides hooks to manage the plugin's lifecycle.// This code runs when the user activates the plugin function my_plugin_activate() { // Example: Create a new database table $conn = DBConnectionClass::newInstance(); $conn->dao->query('CREATE TABLE IF NOT EXISTS ' . DB_TABLE_PREFIX . 't_my_plugin_log (...)'); // Example: Set a default preference osc_set_preference('my_plugin_version', '1.0.0', 'my_plugin_settings', 'STRING'); } osc_register_plugin(osc_plugin_path(**FILE**), 'my_plugin_activate'); // This code runs when the user deactivates the plugin function my_plugin_deactivate() { // Example: Delete the preference osc_delete_preference('my_plugin_version', 'my_plugin_settings'); } osc_add_hook(osc_plugin_path(**FILE**) . '\_disable', 'my_plugin_deactivate'); // This code runs when the user uninstalls the plugin function my_plugin_uninstall() { // Example: Drop the custom database table $conn = DBConnectionClass::newInstance(); $conn->dao->query('DROP TABLE IF EXISTS ' . DB_TABLE_PREFIX . 't_my_plugin_log'); } osc_add_hook(osc_plugin_path(**FILE**) . '\_uninstall', 'my_plugin_uninstall'); B. Creating an Admin Settings Page A plugin with options needs a settings page in the admin panel.// In your plugin's main file, hooked to 'admin_menu_init' function my_plugin_admin_menu() { osc_add_admin_menu_page( 'My Plugin Settings', // Page Title osc_admin_render_plugin_url(osc_plugin_folder(**FILE**) . 'admin.php'), // URL to your settings file 'my_plugin_settings', // Unique ID 'plugins' // Parent Menu (plugins, settings, etc.) ); } osc_add_hook('admin_menu_init', 'my_plugin_admin_menu'); // Then, create admin.php in your plugin folder to render the HTML form. // In that file, you would use osc_set_preference() to save form data. Part 4: Interacting with the Osclass Core & Data Beyond hooks and presentation, a powerful plugin or theme often needs to directly interact with the Osclass database, retrieve specific information, handle user input, and communicate back to the user. This section covers the essential APIs and helper functions you'll use every day to build dynamic and interactive features.A. Database Interaction: The Data Access Object (DAO) Osclass provides a database abstraction layer to ensure that all database queries are handled securely and consistently. You should **never** use raw mysqli*_ or PDO functions. Instead, you must use the Osclass Data Access Object (DAO). This provides a simple way to build queries and automatically handles prepared statements to prevent SQL injection.To get started, you first need to get an instance of the connection object.$conn = DBConnectionClass::newInstance(); $dao = $conn->getDao(); SELECT Queries: Fetching Data The DAO provides several methods to retrieve data. The most common is query() for custom selects, and findByPrimaryKey() for getting a single record by its ID.Example: Get the details of the 5 most recent listings.// Get the DAO instance $dao = new DAO(); // Use the Item DAO to get the specific model for items // This provides useful constants and table names $itemDao = Item::newInstance(); // Build and execute the query $dao->select('i._, d._'); $dao->from($itemDao->getTableName() . ' as i'); $dao->join($itemDao->getTableDescription() . ' as d', 'i.pk*i_id = d.fk_i_item_id'); $dao->where('d.fk_c_locale_code', osc_current_user_locale()); $dao->where('i.b_enabled', 1); $dao->where('i.b_active', 1); $dao->orderBy('i.dt_pub_date', 'DESC'); $dao->limit(5); $result = $dao->get(); // The result is an object. To get an array of items: $items = $result->result(); if (!empty($items)) { echo '<ul>'; foreach ($items as $item) { // The item array contains all database fields for that listing echo '<li>(' . $item['pk_i_id'] . ') ' . $item['s_title'] . '</li>'; } echo '</ul>'; } INSERT Queries: Adding New Data When your plugin needs its own database table, you'll use the insert() method. It takes the table name and an array of key-value pairs ('column_name' => 'value').Example: Log a search query to a custom plugin table.// Assume you created a table named 't_my_plugin_searches' during plugin activation $searchLogTable = DB_TABLE_PREFIX . 't_my_plugin_searches'; $dataToInsert = array( 's_query' => Params::getParam('sPattern'), // Get search query safely 'dt_date' => date('Y-m-d H:i:s'), 'fk_i_user_id' => osc_logged_user_id() // Returns user ID or null ); // Get the DAO and perform the insert $dao = new DAO(); $success = $dao->insert($searchLogTable, $dataToInsert); if ($success) { // The query was successful } else { // There was an error } UPDATE Queries: Modifying Existing Data The update() method is used to modify existing records. It requires the table name, an array of data to update, and an array specifying the WHERE clause.Example: Add a "view count" to your custom search log table.$searchLogTable = DB_TABLE_PREFIX . 't_my_plugin_searches'; $logIdToUpdate = 123; // The primary key of the record to update // We need to increment the existing view count $dao = new DAO(); $dao->update($searchLogTable, array('i_views = i_views + 1'), array('pk_i_id' => $logIdToUpdate)); DELETE Queries: Removing Data The delete() method removes records. It takes the table name and a WHERE clause array.Example: Delete old log entries from your custom table.$searchLogTable = DB_TABLE_PREFIX . 't_my_plugin_searches'; // Delete all logs older than 30 days $dao = new DAO(); $success = $dao->delete($searchLogTable, "dt_date < DATE_SUB(NOW(), INTERVAL 30 DAY)");B. Using Osclass Global Helpers & The View API Osclass provides hundreds of global "helper" functions that handle the logic of retrieving and formatting data for display. You should **always** use these helpers in your themes and plugins instead of querying the database directly and formatting the data yourself. This ensures your code remains compatible with future Osclass updates.These functions are only available within the "View" context. This means they work automatically in theme files. If you need to use them inside a function in a plugin, you must first get the View object.$view = View::newInstance(); Item Helpers (Inside the Loop) These functions work when you are inside the Osclass Loop (while (osc_has_items()) { ... }) on a search page, or on an item page. They automatically refer to the current listing being displayed. osc_item_id(): Returns the integer ID of the item. osc_item_title(): Returns the sanitized title of the item. osc_item_description(): Returns the sanitized description. osc_item_formatted_price(): Returns the price, correctly formatted with currency symbol and decimal places. osc_item_pub_date(): Returns the publication date, formatted according to your site's settings. osc_item_city(), osc_item_region(), osc_item_country(): Returns location details. osc_item_url(): Returns the full, SEO-friendly URL to the listing. osc_count_item_resources(): Returns the number of images/media attached to the listing. User Helpers These functions help you retrieve information about the currently logged-in user or the user who posted a listing. osc_is_web_user_logged_in(): Returns true or false. Essential for conditional logic. osc_logged_user_id(): Returns the integer ID of the logged-in user. osc_logged_user_name(): Returns the name of the logged-in user. osc_logged_user_email(): Returns the email of the logged-in user. osc_user_id(): Inside the loop or on an item page, returns the ID of the item's author. osc_user_name(): Inside the loop or on an item page, returns the name of the item's author. URL Helpers Never hardcode URLs in your themes or plugins. Always use URL helpers to generate them dynamically. This ensures your links will work even if you change your site's URL structure. osc_base_url(): Returns the base URL of your site. osc_contact_url(): Returns the URL of the contact page. osc_user_dashboard_url(): Returns the URL to the logged-in user's dashboard. osc_user_login_url(): Returns the URL of the login page. osc_user_register_url(): Returns the URL of the registration page. C. Handling Forms & Secure User Input When creating a settings page for a plugin or a custom form for users, you must handle the input securely. Osclass provides tools to help with this.Step 1: Creating the Form with CSRF Protection Cross-Site Request Forgery (CSRF) is a common vulnerability. Osclass has a built-in system to prevent it. You must include a CSRF token in all your forms.<form action="<?php echo osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin.php'); ?>" method="post"> <!-- IMPORTANT: This hidden input is for security --> <input type="hidden" name="action_specific" value="save_my_settings" /> <?php AdminForm::generate_csrf_token(); ?> <h2>My Plugin Settings</h2> <label for="apiKey">API Key</label> <input type="text" name="apiKey" id="apiKey" value="<?php echo osc_esc_html(osc_get_preference('api_key', 'my_plugin_settings')); ?>" /> <button type="submit">Save Settings</button> </form> Step 2: Processing the Form Data Safely In your processing file (my_plugin/admin.php in this case), you must verify the CSRF token and use the Params class to retrieve the submitted data. **Never use $\_POST or $\_GET directly.** The Params class automatically runs sanitization routines on the input.<?php // First, check if the form was submitted with our specific action if (Params::getParam('action_specific') == 'save_my_settings') { // SECOND, verify the CSRF token to prevent unauthorized submissions AdminForm::is_csrf_token_valid(); // THIRD, get the submitted data using the Params class $apiKey = Params::getParam('apiKey', false, false); // Params::getParam(key, xss_check, quotes_check) // FOURTH, save the data using the Preferences API osc_set_preference('api_key', $apiKey, 'my_plugin_settings', 'STRING'); // FIFTH, provide feedback to the user and redirect osc_add_flash_ok_message('Your settings have been saved successfully.', 'admin'); osc_redirect_to(osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin.php')); } ?> D. Communicating with the User via Flash Messages Flash messages are temporary notifications displayed to the user after they perform an action (e.g., "Your listing has been published," "Settings saved," "Invalid email address").Setting a Flash Message You can set flash messages from anywhere in your plugin or theme's functions. They are stored in the session and displayed on the next page load. osc_add_flash_ok_message('Success! Your profile was updated.') - For success (green). osc_add_flash_info_message('Your subscription is expiring in 7 days.') - For information (blue). osc_add_flash_warning_message('Please review your listing before publishing.') - For warnings (yellow). osc_add_flash_error_message('The password you entered was incorrect.') - For errors (red). Displaying Flash Messages in a Theme To actually show the messages to the user, you need to include the generic message template in your theme files (e.g., in header.php or main.php).<?php osc_show_flash_message(); ?>This single function will render any pending flash messages with the correct styling and then clear them from the session so they don't appear again.Part 5: Advanced Plugin & Theme Development Techniques With the fundamentals of hooks, themes, and database interaction covered, we can now explore more advanced techniques that are essential for building a modern, dynamic, and professional Osclass platform. This section will cover implementing AJAX, making your extensions translatable (Internationalization), working with custom fields, and creating unique URL routes.A. Implementing AJAX in Osclass for Dynamic Content Asynchronous JavaScript and XML (AJAX) allows you to update parts of a webpage without needing to reload the entire page. This is crucial for features like live search, contact forms, or adding an item to a "favorites" list. Osclass has a built-in AJAX handler that makes this process secure and standardized.The process involves three key steps: the JavaScript request, hooking into the Osclass AJAX API, and the PHP handler function.Step 1: The JavaScript Request (Client-Side) First, you need to write the JavaScript that sends the request. We'll use jQuery, which is included with Osclass. The critical part is passing a security token to verify the request is legitimate.Example: A "Favorite this Item" button in item.php.<!-- In your theme's item.php file --> <button class="add-to-favorites" data-item-id="<?php echo osc_item_id(); ?>">Add to Favorites</button> // In your theme's main javascript file $(document).ready(function(){ $('.add-to-favorites').on('click', function(e){ e.preventDefault(); var button = $(this); var itemId = button.data('item-id'); // The AJAX URL needs a custom action name var ajaxUrl = '<?php echo osc_ajax_hook_url('my_plugin_favorite_item'); ?>'; $.ajax({ url: ajaxUrl, type: 'POST', data: { itemId: itemId }, dataType: 'json', success: function(response) { if(response.success) { button.text('Favorited!').prop('disabled', true); alert(response.message); } else { alert('Error: ' + response.message); } }, error: function() { alert('An unexpected error occurred. Please try again.'); } }); }); }); Step 2: Hooking into the Osclass AJAX API (Server-Side) Osclass listens for AJAX calls using a specific action hook format: osc_ajax*{your_action_name}. The your_action_name must match what you used to generate the AJAX URL in your JavaScript.// In your plugin's main file or your theme's functions.php osc_add_hook('osc_ajax_my_plugin_favorite_item', 'my_plugin_handle_favorite_request'); Step 3: The PHP Handler Function (Server-Side) This is the PHP function that will process the request. It must perform its logic and then echo a JSON-encoded response before terminating the script.function my_plugin_handle_favorite_request() { // Get the data from the request $itemId = Params::getParam('itemId'); $userId = osc_logged_user_id(); // Perform your business logic if (!$userId) { echo json_encode(['success' => false, 'message' => 'You must be logged in to favorite items.']); die(); } if ($itemId > 0) { // Here, you would add your database logic to save the favorite. // For example: Favorites::newInstance()->add($userId, $itemId); $response = [ 'success' => true, 'message' => 'Item successfully added to your favorites!' ]; } else { $response = [ 'success' => false, 'message' => 'Invalid Item ID provided.' ]; } // Echo the response and terminate the script header('Content-Type: application/json'); echo json_encode($response); die(); } B. Internationalization (i18n): Making Your Extensions Translatable If you plan to share your plugin or theme, it is essential to make it translatable. This process, called Internationalization (i18n), involves wrapping all human-readable strings in your code with special Gettext functions. This allows other users to create language files (.po and .mo) to translate your extension into their own language.The Core Gettext Functions Osclass provides several helper functions that are wrappers for the standard PHP Gettext extension. **(): Use this when you need to **return** a translatable string (e.g., assign it to a variable). \_e(): Use this when you need to **echo** a translatable string directly to the browser. Example: Making a simple string translatable.<?php // --- INCORRECT (Hardcoded string) --- $my_variable = 'Hello World'; echo '<h2>My Plugin Settings</h2>'; // --- CORRECT (Translatable strings) --- // Use **() to return the string to a variable $my_variable = **('Hello World', 'my_plugin_domain'); // Use \_e() to echo the string directly echo '<h2>'; \_e('My Plugin Settings', 'my_plugin_domain'); echo '</h2>'; ?> The second argument, 'my_plugin_domain', is the "text domain." It's a unique identifier for your plugin or theme that tells Osclass which language file to load the translation from.Creating the Language FilesOnce your code is prepared with Gettext functions, you can use a program like Poedit to scan your plugin's folder. It will find all the translatable strings and generate a .pot (Portable Object Template) file. You can then translate this file into other languages, creating .po and .mo files for each one, which should be placed in your plugin's languages subfolder.C. Working with Custom Fields (Item Meta) Custom fields are one of Osclass's most powerful features for creating a niche marketplace. Once you've created a custom field in the admin panel (e.g., a "Mileage" field for cars), you need to know how to display its value in your theme.Displaying Custom Field Values on the Item Page Osclass provides a simple loop to iterate through all the custom fields associated with a listing. This should be used within your theme's item.php file.<?php if (osc_has_custom_fields()) { ?> <div class="item-custom-fields"> <h3>Additional Details</h3> <ul> <?php while (osc_has_custom_fields()) { ?> <?php if (osc_field_value() != '') { ?> <li> <strong><?php echo osc_field_name(); ?>:</strong> <?php echo osc_field_value(); ?> </li> <?php } ?> <?php } ?> </ul> </div> <?php } ?> D. Creating Custom URL Routes Sometimes a plugin needs its own custom, user-facing URL that doesn't follow the standard Osclass structure (e.g., your-site.com/my-plugin/dashboard/). Osclass has a routing system that lets you define custom URL rules and map them to a specific PHP file in your plugin.Registering a New Route You register a new route using osc_add_route(). This is typically done from your plugin's main file.function my_plugin_register_routes() { osc_add_route( 'my_plugin_dashboard', // Unique Route Name 'my-plugin/dashboard/?', // The URL Regex Rule 'my-plugin/dashboard/', // The "pretty" URL to rewrite to osc_plugin_folder(**FILE**) . 'views/user_dashboard.php' // The plugin file to load ); } // You can hook this into 'init' osc_add_hook('init', 'my_plugin_register_routes'); Now, when a user visits https://your-site.com/my-plugin/dashboard/, Osclass will load the content from the user_dashboard.php file located in your plugin's views folder. This allows you to create complex, multi-page plugins with clean, SEO-friendly URLs.Part 6: Deeper Integration & Advanced Administration A truly professional Osclass plugin or theme doesn't just add front-end features; it integrates seamlessly into the Osclass administration panel. This provides a polished user experience for the site owner and elevates your extension from a simple script to a complete solution. This section covers advanced techniques for creating admin dashboard widgets, extending the core "Manage Items" table, leveraging Osclass's data storage APIs, and creating custom email notifications.A. Creating Admin Dashboard Widgets The Osclass admin dashboard is widget-based, allowing users to customize the information they see at a glance. Your plugin can register its own widgets to display important statistics, recent activity, or quick action links. This is achieved by creating a widget class and registering it with Osclass.Step 1: Registering the Widget You must tell Osclass about your new widget. This is done by hooking into the widgets_init action and calling osc_register_widget() from your plugin's main file.// In your plugin's main file function my_plugin_register_widgets() { require_once osc_plugin_path(**FILE**) . 'widgets/LatestUnapprovedWidget.php'; osc_register_widget('LatestUnapprovedWidget'); } osc_add_hook('widgets_init', 'my_plugin_register_widgets'); Step 2: Building the Widget Class Now, create the actual widget file (widgets/LatestUnapprovedWidget.php). The class must extend the AdminWidget base class and implement a render() method. This method contains the logic to fetch and display the widget's content.<?php class LatestUnapprovedWidget extends AdminWidget { public function **construct() { parent::**construct( 'latest_unapproved_widget', // Unique widget ID **('Latest Unapproved Items', 'my_plugin_domain'), // Widget Name \_\_('Displays a list of the 5 most recent listings awaiting approval.', 'my_plugin_domain') // Widget Description ); } /\*\* _ The main function that renders the widget's HTML content. _/ public function render() { // Use the Item DAO to find items that are not active and not enabled $items = Item::newInstance()->find( array( 'b_active' => false, 'b_enabled' => false ), 0, // Start from the first record 5, // Limit to 5 results 'dt_pub_date', // Order by 'DESC' // Order direction ); echo '<div class="widget-latest-unapproved">'; if (count($items) > 0) { echo '<ul>'; foreach ($items as $item) { $url = osc_admin_base_url(true) . '?page=items&action=item_edit&id=' . $item['pk_i_id']; echo '<li>'; echo '<a href="' . $url . '" target="_blank">' . osc_esc_html($item['s_title']) . '</a>'; echo ' <span style="color:#999;">(' . osc_format_date($item['dt_pub_date']) . ')</span>'; echo '</li>'; } echo '</ul>'; } else { echo '<p>' . __('No items are currently awaiting approval.', 'my_plugin_domain') . '</p>'; } echo '</div>'; } } ?> Once this is done, the site administrator can go to the dashboard, click "Add Widget," and find "Latest Unapproved Items" in the list of available widgets.B. Extending the Admin "Manage Items" Table One of the most powerful ways to improve an admin's workflow is to add custom, relevant information directly to the main listings table at Tools > Items. You can add new columns with custom data and even add new bulk actions.Adding a Custom Column This is a two-step process: first, you add the column header, and second, you populate the column's content for each row.// In your plugin's main file // Step 1: Add the column header function my_plugin_add_item_table_header($columns) { // Add our new column at the 3rd position (index 2) array_splice($columns, 2, 0, array('my_custom_column' => __('My Custom Data', 'my_plugin_domain'))); return $columns; } osc_add_filter('manage_items_columns', 'my_plugin_add_item_table_header'); // Step 2: Populate the column for each item row function my_plugin_add_item_table_content($item) { // The $item array contains all data for the current row // Check if we are in our custom column if (osc_current_admin_column() === 'my_custom_column') { // Example: Get a custom meta field value for this item $my_data = osc_get_item_meta('my_plugin_custom_field'); echo ($my_data != '') ? osc_esc_html($my_data) : 'N/A'; } } osc_add_hook('items_processing_row', 'my_plugin_add_item_table_content'); Adding a New Bulk Action This allows an admin to select multiple listings and apply a custom action to all of them at once.// In your plugin's main file // Step 1: Add the option to the dropdown menu function my_plugin_add_bulk_action($actions) { $actions['my_custom_action'] = __('Mark as Special', 'my_plugin_domain'); return $actions; } osc_add_filter('item_bulk_actions', 'my_plugin_add_bulk_action'); // Step 2: Process the action when the form is submitted function my_plugin_handle_bulk_action($action, $itemIds) { if ($action === 'my_custom_action') { $count = 0; foreach ($itemIds as $id) { // Your logic here: update a custom field, send an API call, etc. // For example, let's update a meta field for each item Item::newInstance()->update(array('b_special' => 1), array('pk_i_id' => $id)); $count++; } osc_add_flash_ok_message($count . ' ' . **('items have been marked as special.', 'my_plugin_domain'), 'admin'); } } // Note: This hook receives the action name and an array of selected item IDs osc_add_hook('item_bulk_action', 'my_plugin_handle_bulk_action', 10, 2); C. The Session and Preferences APIs: Storing Data Correctly Osclass provides two primary mechanisms for storing data: the **Session** for temporary, user-specific data, and **Preferences** for permanent, site-wide settings.Working with the Session API The Session is for data that should only persist for a single user's visit. It's perfect for multi-step forms or storing temporary user choices. Always use the Session class wrapper.// Get the Session instance $session = Session::newInstance(); // Store a value in the session $session->_set('my_plugin_user_choice', 'blue'); // Retrieve a value from the session $userColor = $session->_get('my_plugin_user_choice'); // Returns 'blue' // Check if a session variable exists if ($session->\_is_set('my_plugin_user_choice')) { // ... } // Remove a value from the session $session->_drop('my_plugin_user_choice'); Working with the Preferences API Preferences are stored permanently in the t_preference database table. This is the correct way to store your plugin's settings. The API handles serialization and caching automatically.// To save a preference // osc_set_preference(key, value, section, type) // 'section' should be a unique name for your plugin to avoid conflicts osc_set_preference('api_key', 'xyz123abc', 'my_plugin_settings', 'STRING'); osc_set_preference('enable_feature', true, 'my_plugin_settings', 'BOOLEAN'); osc_set_preference('item_limit', 50, 'my_plugin_settings', 'INTEGER'); // To retrieve a preference $apiKey = osc_get_preference('api_key', 'my_plugin_settings'); $isFeatureEnabled = (bool) osc_get_preference('enable_feature', 'my_plugin_settings'); // To delete a preference osc_delete_preference('api_key', 'my_plugin_settings'); D. Creating and Sending Custom Email Notifications A professional plugin often needs to send its own unique email notifications. Osclass has a robust, template-based email system that you should always use instead of calling PHP's mail() function directly. This ensures emails are themed correctly and can be translated by the user.Step 1: Register Your Email Template (on Plugin Activation) First, you need to add your email's content to the database so the admin can edit it.function my_plugin_activate() { $email_data = array( 's_name' => 'My Plugin Notification', 's_internal_name' => 'my_plugin_custom_email', // Unique internal name 's_title' => 'Hello, {CONTACT_NAME}! A special event has occurred.', 's_text' => '<p>Dear {CONTACT_NAME},</p><p>We are writing to inform you that the listing "{ITEM_TITLE}" has been flagged for review.</p><p>Thank you,<br>{SITE_TITLE}</p>' ); // Use the EmailTemplates model to insert it EmailTemplates::newInstance()->insert($email_data); } osc_register_plugin(osc_plugin_path(**FILE**), 'my_plugin_activate'); Step 2: Triggering the Email Send To send the email, you gather your data, prepare your placeholders (like {CONTACT_NAME}), and then use osc_send_mail().function send_my_custom_notification($itemId) { // Get the item and user data $item = Item::newInstance()->findByPrimaryKey($itemId); $user = User::newInstance()->findByPrimaryKey($item['fk_i_user_id']); // Get the email template from the database $email_template = EmailTemplates::newInstance()->findByInternalName('my_plugin_custom_email'); // Prepare the placeholders to be replaced $placeholders = array( '{CONTACT_NAME}' => $user['s_name'], '{ITEM_TITLE}' => $item['s_title'], '{SITE_TITLE}' => osc_page_title(), '{SITE_URL}' => osc_base_url() ); // Replace placeholders in the subject and body $subject = osc_apply_placeholders($email_template['s_title'], $placeholders); $body = osc_apply_placeholders($email_template['s_text'], $placeholders); // Create the email parameters array $email_params = array( 'to' => $user['s_email'], 'to_name' => $user['s_name'], 'subject' => $subject, 'body' => $body ); // Send the email using the Osclass mailer osc_send_mail($email_params); } Part 7: Advanced Development Patterns & Best Practices Mastering the APIs is the first step; becoming a professional Osclass developer requires adopting patterns that ensure your extensions are robust, secure, and seamlessly integrated. This final section moves beyond individual functions to explore higher-level concepts: leveraging the Osclass Model layer for elegant data manipulation, implementing advanced security practices, automating tasks with the Command Line Interface (CLI), and creating front-end widgets that empower site administrators.A. Leveraging the Osclass Model Layer for Cleaner Code While the Data Access Object (DAO) is excellent for custom SQL queries, Osclass is built on a Model-View-Controller (MVC) architecture. The **Models** (e.g., Item, User, Category) are the heart of this pattern. They contain the business logic and pre-built methods for common data operations. Using Models instead of the DAO for standard tasks leads to cleaner, more readable, and more maintainable code.DAO vs. Model: A Practical ComparisonImagine you need to fetch all active listings for a specific user (ID 123).The DAO approach (more verbose):$dao = new DAO(); $dao->select(); $dao->from(DB_TABLE_PREFIX . 't_item'); $dao->where('fk_i_user_id', 123); $dao->where('b_active', 1); $dao->where('b_enabled', 1); $result = $dao->get(); $items = $result->result(); The Model approach (cleaner and more abstract):// The Item model has a built-in method for this exact task $items = Item::newInstance()->findByUserID(123); The Model approach is not only shorter but also less prone to error, as the complex query logic is handled internally by the Osclass core. You should always check the relevant Model file in oc-includes/osclass/model/ to see if a method already exists for your needs before writing a custom DAO query.Powerful Model Methods You Should Use: Item::newInstance()->findLatest($count): Gets the $count most recently published items. Item::newInstance()->findPopular($count): Gets the $count most viewed items. User::newInstance()->findByEmail($email): Finds a user by their email address. Category::newInstance()->findSubcategories($categoryId): Gets all direct subcategories of a given category ID. Alerts::newInstance()->findSubscribers($itemId): Finds all users who have an active search alert that matches a newly published item. B. Advanced Security Practices: A Developer's Responsibility Writing secure code is non-negotiable. While the Osclass core provides a secure foundation, a poorly written plugin can expose a website to significant risk. Go beyond the basics of CSRF nonces with these critical practices.1. Input Validation vs. Sanitization These two concepts are often confused. Sanitization (like using Params::getParam()) cleans data. Validation confirms data is what you expect it to be. You must do both.Example: Validating a user-submitted age field.// Get the sanitized input $age = Params::getParam('user_age'); // Now, VALIDATE it if (!is_numeric($age) || $age < 18 || $age > 120) { // The data is not a valid age, even if it's sanitized. // Return an error and do not process it. osc_add_flash_error_message('Please enter a valid age between 18 and 120.'); // Redirect back to the form... } else { // Validation passed, proceed to save the integer value. User::newInstance()->update(array('i_age' => (int)$age), array('pk_i_id' => osc_logged_user_id())); } 2. Output Escaping: Preventing Cross-Site Scripting (XSS) Never trust data, even data from your own database. It could have been compromised or entered maliciously. You must "escape" all data just before you echo it to the browser to prevent malicious scripts from running. osc_esc_html($string): Use this for echoing content inside a standard HTML element (e.g., <div>, <p>, <strong>). This is the most common escaping function. osc_esc_js($string): Use this when echoing a string inside a JavaScript block (e.g., in an alert() or when defining a variable). esc_attr($string): A WordPress-compatible function for echoing content inside an HTML attribute (e.g., title="..." or placeholder="..."). <?php $listingTitle = osc_item_title(); // Gets the raw title ?> <!-- CORRECT: Escaped for HTML context --> <h2 title="<?php echo esc_attr($listingTitle); ?>"><?php echo osc_esc_html($listingTitle); ?></h2> <script> // CORRECT: Escaped for JavaScript context var itemTitle = '<?php echo osc_esc_js($listingTitle); ?>'; console.log('The title of this item is: ' + itemTitle); </script> 3. Checking User Permissions and Capabilities Never assume a user has the right to perform an action. Always check their permissions, especially for admin-side functionality. osc_is_admin_user_logged_in(): Returns true if the current user is a logged-in administrator. osc_is_web_user_logged_in(): Returns true if the current user is a logged-in front-end user. osc_item_user_id(): Returns the ID of the user who published the current item. You can compare this to osc_logged_user_id() to see if the current user is the owner of the listing. C. Automating Tasks with the Osclass CLI (cron.php) Many marketplaces require automated, recurring tasks, such as deactivating expired listings, sending out daily email digests, or cleaning up temporary files. Osclass includes a Command Line Interface (CLI) entry point, cron.php, which can be triggered by a server cron job to run these tasks.Step 1: Create Your Custom Cron Function You can create a function that performs your desired task and hook it into one of Osclass's built-in schedules: cron_hourly, cron_daily, or cron_weekly.// In your plugin's main file // This function will contain the logic for our automated task function my_plugin_deactivate_old_listings() { $conn = DBConnectionClass::newInstance(); $dao = $conn->getDao(); // Deactivate all items older than 90 days that have not been renewed $dao->update( Item::newInstance()->getTableName(), array('b_active' => 0), "dt_pub_date < DATE_SUB(NOW(), INTERVAL 90 DAY)" ); // You could also log that the cron ran successfully error_log('My Plugin: Daily deactivation cron ran successfully.'); } // Attach our function to the built-in daily cron hook osc_add_hook('cron_daily', 'my_plugin_deactivate_old_listings'); Step 2: Setting up the Server Cron Job To run all daily cron hooks, you would set up a cron job on your server (via cPanel or the command line) to execute the following command once per day:php /path/to/your/osclass/cron.php --cron-type=dailyThis command will trigger the cron_daily hook in Osclass, which in turn will execute your my_plugin_deactivate_old_listings function and any other functions attached to that hook.D. Creating Front-end Widgets for Your Theme Plugins can provide their own front-end widgets that can be placed in a theme's sidebar or footer. This allows your plugin's functionality to be visually integrated into any theme.Step 1: Register the Widget File You must include your widget file and then register it using osc_register_widget().// In your plugin's main file function my_plugin_register_frontend_widgets() { require_once osc_plugin_path(**FILE**) . 'widgets/TopViewedWidget.php'; osc_register_widget('TopViewedWidget'); } // A good place to call this is in the main plugin file or hooked into 'init'. osc_add_hook('init', 'my_plugin_register_frontend_widgets'); Step 2: Create the Widget Class The front-end widget class must extend the Widget base class and contain a widget() function. This function is responsible for rendering the widget's HTML.<?php class TopViewedWidget extends Widget { public function **construct() { $this->setAsciiName('top_viewed_widget'); $this->setName(**('Top 5 Most Viewed Items', 'my_plugin_domain')); $this->setDescription(**('Displays a list of the 5 most popular listings on the site.', 'my_plugin_domain')); } /\*\* _ The main function that renders the widget's HTML content. _ @param array $params Contains any options set by the user in the admin panel. _/ public function widget($params = array()) { // Use the Item model to get the 5 most popular items $popularItems = Item::newInstance()->findPopular(5); echo '<div class="widget widget-top-viewed">'; echo '<h3>' . $this->getName() . '</h3>'; if (count($popularItems) > 0) { echo '<ul>'; foreach ($popularItems as $item) { // To use item helpers here, we need to manually set the view context View::newInstance()->\_exportVariableToView('item', $item); echo '<li>'; echo '<a href="' . osc_item_url() . '">' . osc_item_title() . '</a>'; echo ' <span>(' . osc_item_views() . ' views)</span>'; echo '</li>'; } echo '</ul>'; } else { echo '<p>' . \_\_('No listings have been viewed yet.', 'my_plugin_domain') . '</p>'; } echo '</div>'; } } ?> Once registered, administrators can go to Appearance > Widgets, drag the "Top 5 Most Viewed Items" widget into a sidebar, and it will appear on the front end of their site. Please review the Osclass Developer Guide ([https://docs.osclass-classifieds.com/developer-guide](https://docs.osclass-classifieds.com/developer-guide)), Programming Standards ([https://docs.osclass-classifieds.com/programming-standards-i75](https://docs.osclass-classifieds.com/programming-standards-i75)), Child Theme Guidelines ([https://docs.osclass-classifieds.com/child-themes-i79](https://docs.osclass-classifieds.com/child-themes-i79)), and the Hooks, Themes, and Plugins customization guide ([https://osclass-classifieds.com/article/developer-guide-customizing-osclass-hooks-themes-plugins](https://osclass-classifieds.com/article/developer-guide-customizing-osclass-hooks-themes-plugins)), and apply the standard naming conventions and coding styles from the Programming Standards document to all files, classes, functions, variables, and assets to ensure consistency, readability, and maintainability throughout the project.

Observe (https://docs.osclass-classifieds.com)(https://docs.osclass-classifieds.com/developer-guide)
(https://docs.osclass-classifieds.com/programming-standards-i75)
Programming Standards
Osclass PHP Coding Standards & Best Practices Following proper coding standards ensures better maintainability, security, and performance in Osclass development. Below is an improved guide based on best practices observed in the latest Osclass coding style. General Coding Conventions Function Naming Function names in Osclass follow the snake*case convention with an osc* prefix to maintain consistency. Example:
function osc_get_currency_row($code, $cache = true) {
  ...
}
 Data Validation Data should be validated before processing. Example: 
$code = strtoupper(trim((string)$code));

if ($code == '' || strlen($code) != 3) {
return false;
}
This ensures that the currency code is always uppercase and exactly three characters long. Using Caching to Improve Performance Osclass caching system reduces redundant database queries. It checks if the data exists in the cache before querying the database:
if ($cache === true && View::newInstance()->_exists('currency_' . $code)) {
  return View::newInstance()->_get('currency_' . $code);
}
 To store new data in the cache: 
View::newInstance()->_exportVariableToView('currency_' . $code, $currency);
 Efficient Database Queries Instead of retrieving the entire database, use indexed queries for performance: 
$currency = Currency::newInstance()->findByPrimaryKey($code);
 Fetching all records efficiently: 
function osc_get_currencies_all($by*pk = false) {
$key = 'currencies*' . (string)$by_pk;

if (!View::newInstance()->\_exists($key)) {
$currencies = Currency::newInstance()->listAllRaw();
$output = [];

    if (!empty($currencies)) {
      foreach ($currencies as $cur_row) {
        $output[$by_pk ? $cur_row['pk_c_code'] : []] = $cur_row;
      }
    }

    View::newInstance()->_exportVariableToView($key, $output);
    return $output;

}

return View::newInstance()->\_get($key);
}
 Recommended Improvements Use of Strict Typing Adding strict typing improves readability and prevents unexpected errors. Example: 
function osc_get_currency_row(string $code, bool $cache = true): array|false {
  ...
}
 Error Handling & Logging Ensure errors are logged properly instead of silently failing: 
if (!$currency) {
error_log('Currency not found: ' . $code);
}
 Using empty() Instead of count() Instead of checking both is_array() and count() > 0, simplify: 
if (!empty($currencies)) { ... }
Conclusion By following these coding standards, you ensure that Osclass applications remain optimized, maintainable, and secure. Implement proper validation, caching, and efficient queries to enhance performance.

(https://docs.osclass-classifieds.com/query-items-custom-listings-select-i86)
Query Items (custom listings select)
Displaying Specific Listings Using osc_query_item() Osclass provides a powerful function osc_query_item($params) that allows developers to filter and display listings dynamically based on various criteria. This function supports **multiple filtering options** and can be used to fine-tune the selection of listings displayed on a page. Filtering listings can be useful for custom sections like:
Showing listings from a specific country, region or city
Displaying premium listings only
Filtering listings based on category or author
Showing only listings with images
Applying price-based filters
Sorting and limiting results per page
How to Use osc_query_item() The function accepts a string or an array of parameters to filter the listings based on specific criteria. The returned listings can then be displayed using Osclass template functions. Filtering by a Single Parameter To retrieve all listings from a specific region (e.g., Madrid), use:

<?php osc_query_item("region_name=Madrid"); ?>

Filtering by Multiple Parameters To retrieve listings based on **multiple** conditions, pass an array of filters:

<?php
osc_query_item(array(
    "category_name" => "cars,houses",
    "city_name" => "Madrid",
    "premium" => "1"
));
?>

In the above example, the function will return listings from Madrid, limited to cars and houses, and only those marked as premium. Available Filtering Parameters Osclass allows filtering listings using the following parameters:
Parameter Description
author Filters listings by user ID
author_email Filters listings by user email
country / country_name Filters by country ID or name
region / region_name Filters by region ID or name
city / city_name Filters by city ID or name
city_area / city_area_name Filters by city area ID or name
category / category_name Filters by category ID or name
premium Shows only premium listings (1 = Yes, 0 = No)
with_picture Shows only listings with images (1 = Yes, 0 = No)
max_price Filters listings with price below a certain value
min_price Filters listings with price above a certain value
zip Filters listings by ZIP code
condition Filters listings by item condition
item_condition Filters listings based on predefined item condition values
locale Filters listings by user locale
results_per_page Defines the number of results per page
page Specifies the pagination page number
offset Skips a specified number of results
order Defines sorting order, e.g., order=price,DESC
Displaying Filtered Listings Once the function has retrieved the listings, you can display them using Osclass template functions.

<?php if (osc_count_custom_items() == 0) { ?>

    <p class="empty"><?php _e('No Listings', 'modern'); ?></p>

<?php } else { ?>

    <table border="0" cellspacing="0">
        <tbody>
            <?php while (osc_has_custom_items()) { ?>
                <tr class="<?php echo (osc_item_is_premium() ? ' premium' : ''); ?>">
                    <td class="photo">
                        <a href="<?php echo osc_item_url(); ?>">
                            <img src="<?php echo osc_resource_thumbnail_url(); ?>" width="75" height="56" alt="<?php echo osc_item_title(); ?>" />
                        </a>
                    </td>
                    <td class="text">
                        <h3><a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a></h3>
                        <p><?php echo osc_item_formated_price(); ?> - <?php echo osc_item_city(); ?> (<?php echo osc_item_region(); ?>) - <?php echo osc_format_date(osc_item_pub_date()); ?></p>
                        <p><?php echo osc_highlight(strip_tags(osc_item_description())); ?></p>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php } ?>

Conclusion The osc_query_item() function is a highly flexible method for retrieving Osclass listings dynamically. It supports multiple filtering parameters, sorting options, and pagination, making it an essential tool for customizing how listings are displayed on your site.

(https://docs.osclass-classifieds.com/hooks-i118)
Hooks
A hook is a small piece of code that allows you to insert more code (plugin) in the middle of certain Osclass’ actions. Usage of hooks To use a hook add the following code to your plugin file :
osc*add_hook('hook_name', 'function_name', 'priority');
Substitute ‘hook_name’ by the name of the hook you want to attach ‘function_name’, and ‘function_name’ with the name of your function. ‘priority’ is number 1-10 that identifies priority/order to include/run function in hook. If you want to run function at the end, use priority 10. If you want to run function at start, use priority 1. Special hooks There exists some special hooks This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel);
osc_add_hook(**FILE** . "\_configure", 'function_name');
This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel);
osc_add_hook(**FILE** . "\_uninstall", 'function_name');
Init hooks init : inits on the front end useful for enqueueing scripts and styles init_admin : inits on the admin end useful for enqueueing scripts and styles Ajax hooks ajax_my_hook : Run when AJAX request sent from frontend. Example if you execute function abc_my_func via ajax, then hook name will be “ajax_abc_my_func”. ajax_admin_my_hook : Run when AJAX request sent from admin. ajax_custom: Run as ajax action “custom_ajax” Item hooks pre_item_post : Run before an item is posted. pre_item_add : Run before an item is posted. $aItem, $flash_error are passed as argument. show_item : Run at the beginning of item’s detail page. $item is passed as argument. NOTE: This will be execute BEFORE the header item_detail : Run at the middle of item’s detail page. $item is passed as argument. USE THIS is you want to make an attributes plugins renew_item : Run when an item is renewed. $id is passed as argument activate_item : Run when an item is activated. $id is passed as argument deactivate_item : Run when an item is deactivated. $id is passed as argument enable_item : Run when an item is enable. $id is passed as argument disable_item : Run when an item is disable. $id is passed as argument posted_item : Run when an item is posted. $item is passed as argument edited_item : Run when an item is edited. $item is passed as argument new_item : Run at the form for publishing new items add_comment : When some user add a comment to an item. $item is passed as argument location : Run at item’s detail page. Just after item_detail hook item_form : Run at publish new item form. USE this if you want to make an attributes plugin. $catId is passed as argument post_item : Run before a publish new item page is loaded before_item_edit : Run before a edit item page is loaded item_edit : Run at editing item form. Same as item_form/item_detail. $cat_id and $item_id are passed as arguments item_edit_post : Run after submitting the information when editing an item DEPRECATED removed in v3.2 use edited_item instead item_form_post : Run after submitting the information when publishing an item. $catId, and $id are passed as argument DEPRECATED removed in v3.2 use posted_item instead after_item_post : Run after ‘item_form_post’ and some other actions (send emails,…) DEPRECATED removed in v3.2 use posted_item instead delete_item : When an item is deleted. $id is passed as argument before_delete_item: Before item is being removed. $item is passed as argument (from Osclass 8.1.2) item_premium_on : When an item is marked as premium item_premium_off : When an item is unmarked as premium item_spam_on : When an item is marked as spam (since 2.4) item_spam_off : When an item is unmarked as spam (since 2.4) item_contact_form : Run at the contact item publisher form, so you could add your own filters and options (since 3.1) hook_email_item_inquiry : Run when an inquiry email is sent. $item is passed as argument. hook_email_item_validation : Run when an inquiry email is validated. $item is passed as argument. hook_email_item_validation_non_register_user : $item is passed as an argument. hook_email_new_item_non_register_user : $item is passed as an argument. Resource hooks regenerate_image : Run before an image is regenerated. $resource is passed as an argument. regenerated_image : Run after an image is regenerated. $resource is passed as an argument. delete_resource : Run after a resource is deleted. $resource is passed as an argument. uploaded_file : Run after a file is uploaded. $resource is passed as an argument. Comment hooks edit_comment : Run when editing of comment is complete. $id is passed as argument edit_comment_reply: Run when editing of comment that is reply to other comment is complete. $id of parent comment is passed as argument (from Osclass 8.0.3). Executed after edit_comment is executed. enable_comment : $id is passed as argument disable_comment : $id is passed as argument activate_comment : $id is passed as argument deactivate_comment : $id is passed as argument delete_comment : $id is passed as argument add_comment : $id is passed as argument hook_email_new_comment_user : Run when email sent to user after a new comment is posted. $item is passed as argument. hook_email_new_comment_admin : Run when email sent to after a new comment is posted. $item is passed as argument. hook_email_comment_validated : $comment is passed as argument. User hooks before_user_register : Run before the user registration form is processed. register_user : Run when an user complete the registration process. $user is passed as argument validate_user : Run when an user gets validated (if they didn’t do it automatically) before_login : Run before user login is created. after_login : Run when user is successfully loged in. $user and $url_redirect are passed as params. logout : Run when an user logout on your site. user_register_form : Run after the form for users registration. Useful if you want to add special requirements to your users user_register_completed : Run after registration of an user is completed. user_profile_form : Run before update button of user’s profile user_forgot_password_form : Run inside user forgot password form (Osclass 8.3 or later) user_recover_form : Run inside user recover password form (Osclass 8.3 or later) user_form : Run after the form of user’s profile delete_user : Run before user is removed. In time of running hook, user record is still available in user table. $id is passed as argument activate_user: Run after user has been activated. $id is passed as argument dectivate_user: Run after user has been deactivated. $id is passed as argument enable_user: Run after user has been enabled. $id is passed as argument disable_user: Run after user has been disabled. $id is passed as argument register_email_taken : Run when email used at register is already exist (*3.1*) pre_user_post : Run before an user complete the registration, or edit his account (*3.1*) user_register_completed : $userId is passed as an argument. user_edit_completed : $userId is passed as an argument. hook_email_admin_new_user : Run when admin emailed after user account activated. hook_email_user_registration : Run when a user registration email is created, just before the “validate_user” hook. hook_email_user_validation : Run when a non-admin user is validated, or when activation is resent. $user, $input are sent as arguments. hook_email_send_friend : Run when a friend email is sent. $item is passed as argument. hook_email_user_forgot_password : Run when user requests new password. $user, $password_url are sent as arguments. hook_email_contact_user : Run when contact email sent to user. $id, $yourEmail, $yourName, $phoneNumber, $message are sent as arguments. Search hooks before_search : Run before a search request. search : Run at search page. Object $search is passed as argument search_form : Run at the search’s form, so you could add your own filters and options. $catId is passed as argument search_conditions : Run when the search is submitted, useful to add new conditions to search custom_query : Run when a custom query is processed. $key and $value are passed as arguments. highlight_class : Run in item loop (loop-single.php) and used to add specific class to listing. RSS feed hooks rss_before : Runs at start of RSS feed (after description is added) rss_after : Runs at end of RSS feed (before closing channel) rss_item : Runs in items loop. Item ID is passed as argument. Feed related feed : Run at feed page. $feed is passed as argument feed_XYZ : Run at XYZ’s feed page (see extra feeds plugin). $items is passed as argument HTML hook before_error_page : Run before generating an error page after_error_page : Run after generating an error page header : Run at header footer : Run at footer admin_menu : Run in the middle of the admin’s menu. Useful to add your custom options to Osclass/Plugins admin_header : Run at the header in the admin panel admin_footer : Run at the footer in the admin panel admin_users_table : Run ad addTableHeader function in datatables user_menu : Run in the middle of the user’s account menu. Useful to add custom options to user’s account menu user_menu_before, user_menu_top, user_menu_bottom, user_menu_after : Additional user menu hooks, available from Osclass v8.3.0 before_html : Before the html is displayed on the browser after_html : After the html is ‘displayed’. Note: This run is on the server, it’s run after the HTML code is sent to the browser, since some resources are loaded externally (JS, CSS, images,…) it’s run before the HTML complete its load process. Cron hooks cron : Run at manual cron system cron_hourly : Run at manual cron system hourly cron_daily : Run at manual cron system daily cron_weekly : Run at manual cron system weekly Sitemap related before_sitemap : Run before generating the sitemap after_sitemap : Run after generating the sitemap Others hooks user_locale_changed: Run when locale has been changed. $locale_code is passed as argument delete_locale : When a locale is deleted. $locale is passed as argument delete_category : Run at category deletion before_rewrite_rules : Run before the rewrite rules are generated, a pointer to the rewrite object is passed after_rewrite_rules : Run after the rewrite rules are generated, a pointer to the rewrite object is passed admin_register_form : Run after the form for contact site administrator. Useful if you want to add special requirements to your contacts. contact_form : Run at the contact admin form, so you could add your own filters and options (contact.php) (since 3.1) init : Run after frontend has finished loading. init_admin : Run after admin has finished loading. theme_activate : Run when a theme is activated. $theme is passed as an argument. before_show_pagination_admin : Run before pagination on admin pages. after_show_pagination_admin : Run after pagination on admin pages. alert_created : Run when alert is created via ajax (does not mean successfully created!) hook_email_alert_validation : Run when alert email validated. $alert, $email, $secret are passed as arguments. hook_email_new_email : Run when user email is changed. $new_email, $validation_url are passed as arguments. hook_alert_email_instant : Run when an instant alert is sent. $user, $ads, $s_search are passed as arguments. hook_alert_email_hourly : Run when an hourly alert is sent. $user, $ads, $s_search are passed as arguments. hook_alert_email_daily : Run when a daily alert is sent. $user, $ads, $s_search are passed as arguments. hook_alert_email_weekly : Run when a weekly alert is sent. $user, $ads, $s_search are passed as arguments. structured_data_header: Run at header structured data block. structured_data_footer: Run at footer structured data block. before_auto_upgrade: Run before auto-upgrade starts osclass upgrade. after_auto_upgrade: Run after auto-upgrade starts osclass upgrade. $result is passed as argument. after_upgrade: Run after osclass upgrade has finished. $error is passed as argument. admin_items_header, admin_items_actions, admin_items_form_left_top, admin_items_form_left_middle, admin_items_form_right_top: Run in item edit page in backoffice. osc_item() is available in hook. (Osclass 8.0.2). admin_dashboard_top, admin_dashboard_bottom: Run in backoffice dashboard page (Osclass 8.0.3). admin_dashboard_col1_top, admin_dashboard_col1_bot, admin_dashboard_col2_top, admin_dashboard_col2* bot , admin*dashboard_col3_top, admin_dashboard_col3* bot : Run in admin dashboard (home) page (Osclass 8.2.0) admin_dashboard_setting_top, admin_dashboard_setting_col1, admin_dashboard_setting_col2, admin_dashboard_setting_col3: Run at admin dashboard settings page (Osclass 8.2.0) admin_translations_list_top, admin_translations_list_bottom: Run in backoffice translations list page (Osclass 8.0.3). admin_translations_edit_top, admin_translations_edit_bottom, admin_translations_edit_buttons_top, admin_translations_edit_buttons_middle, admin_translations_edit_buttons_bottom, admin_translations_edit_catalog, admin_translations_edit_stats, admin_translations_edit_options, admin_translations_edit_form, admin_translations_edit_actions: Run in backoffice translations edit page (Osclass 8.0.3). pre_send_email: Run at start of send mail function. $params are passed as arguments. (Osclass 8.0.2). before_send_email: Run right before mail is being sent in send mail function. $params, $mail are passed as arguments. (Osclass 8.0.2). after_send_email: Run when email was sent successfully in send mail function. $params, $mail are passed as arguments. (Osclass 8.0.2). Admin panel hooks add_admin_toolbar_menus : Run at the end of AdminToolbar::add_menus(), you can add more actions to toolbar before render it. New design theme hooks In Osclass 8.2.0, many new theme hooks has been introduced for better customization options and plugins integration. Header
header_top
header_links
header_bottom
header_after
Footer
footer_pre
footer_top
footer_links
footer_after
Home page
home_search_pre
home_search_top
home_search_bottom
home_search_after
home_top
home_latest
home_premium
home_bottom
Item page
item_top
item_title
item_images
item_meta
item_description
item_contact
item_comment
item_comment_form
item_bottom
item_sidebar_top
item_sidebar_bottom
Search page
search_items_top
search_items_filter
search_items_bottom
search_sidebar_pre
search_sidebar_top
search_sidebar_bottom
search_sidebar_after
Item loop
item_loop_top
item_loop_title_after
item_loop_description_after
item_loop_bottom
User dashboard page
user_dashboard_top
user_dashboard_bottom
user_dashboard_links
User items page
user_items_top
user_items_bottom
user_items_body
user_items_action
user_items_search_form_top (Osclass 8.3)
user_items_search_form_bottom (Osclass 8.3)
Public profile page
user_profile_top
user_profile_sidebar
user_public_profile_items_top
user_public_profile_sidebar_top
user_public_profile_sidebar_bottom
user_public_profile_search_form_top (Osclass 8.3)
user_public_profile_search_form_bottom (Osclass 8.3)
Publish & edit page
item_publish_top
item_publish_category
item_publish_description
item_publish_price
item_publish_location
item_publish_seller
item_publish_images
item_publish_hook
item_publish_buttons
item_publish_bottom (for recaptcha, right before buttons)
item_publish_after
Themes those support these new hooks must have constant THEME_COMPATIBLE_WITH_OSCLASS_HOOKS defined and set to value 820 or higher. For publish & edit page, there are item_post and item_edit hooks automatically generated with variants and linked to these hooks. Hooks are being executed with ajax calls just when any functions are hooked to them. Publish post hooks
item_form (original)
item_form_top
item_form_category
item_form_description
item_form_price
item_form_location
item_form_seller
item_form_images
item_form_hook
item_form_buttons
item_form_bottom
item_form_after
Edit post hooks
item_edit (original)
item_edit_top
item_edit_category
item_edit_description
item_edit_price
item_edit_location
item_edit_seller
item_edit_images
item_edit_hook
item_edit_buttons
item_edit_bottom
item_edit_after

(https://docs.osclass-classifieds.com/filters-i119)
Filters
A filter is functionality that allows to modify content of particular functions (price format, item title etc.). Function added to filter have 1 input parameter – content that can be modified. Function returns output as modified content.
osc_add_filter('filter_name', 'function_name');
Example for filters might be need to capitalize items title:
osc_add_filter('item_title', function($title) { return ucwords($title); });
List of filters Keep in mind that not all filters are listed here, we will try to make this list as accurate as possible. List is written in form: {name of filter} / {file where filter is used} / {short description}.
item_title / item.php – affects the title of the item
item_description / item.php – affects the description of the item
item_price_null, item_price_zero, item_price – item price filters
item_contact_name, item_contact_phone, item_contact_other, item_contact_email / hItem.php – item contact information (Osclass 8.0.2)
item_post_data, item_edit_data – run right before item data are entered into database (Osclass 8.0.3)
item_post_location_data, item_post_image_data, item_post_email_data, item_post_meta_data – run before each of the data is entered into Database (Osclass 8.2.0)
item_edit_location_data, item_edit_image_data, item_edit_meta_data – run right before each of data is entered into database (Osclass 8.2.0)
before_send_friend – run before send friend is executed (Osclass 8.2.0)
before_validate_contact, before_contact – run before item contact (Osclass 8.2.0)
user_insert_data, user_edit_data, user_update_description – run right before user data (or user description data) are inserted into database (Osclass 8.0.3)
comment_insert_data – run right before comment is entered into database.
slug / model / Category.php – could change the slug of the categories (usefull for especial characters as ä, ü, …)
resource_path / media_processing.php(oc-admin) – affects the resource path
structured_data_title_filter / structured-data.php – affects the title in structured data
structured_data_description_filter / structured-data.php – affects the description in structured data
structured_data_image_filter / structured-data.php – affects the image in structured data
structured_data_url_filter / structured-data.php – affects the current URL in structured data
actions_manage_items / items_processing.php – could add more actions on actions list at manage listing. An array of ‘actions’ is passed and an array with the item information.
more_actions_manage_items / items_processing.php – could add more actions on ‘more actions’ list at manage listing. An array of ‘actions’ is passed and an array with the item information.
actions_manage_users / items_processing.php – could add more actions on actions list at manage users. An array of ‘actions’ is passed and an array with the user information.
more_actions_manage_users / items_processing.php – could add more actions on ‘more actions’ list at manage users. An array of ‘actions’ is passed and an array with the user information.
datatable_user_class / user/index.php – backoffice user list row class

<tr class="<?php echo implode(' ', osc_apply_filter('datatable_user_class', array(), $aRawRows[$key], $row)); ?>">
datatable_listing_class / item/index.php – backoffice listing list row class
<tr class="<?php echo implode(' ', osc_apply_filter('datatable_listing_class', array(), $aRawRows[$key], $row)); ?>">
datatable_alert_class / user/alert.php – backoffice alert list row class
<tr class="<?php echo implode(' ', osc_apply_filter('datatable_alert_class', array(), $aRawRows[$key], $row)); ?>">
meta_generator / oc-load.php – Osclass generator meta tag
limit_alert_items / controller / user.php – change number of listings returned with each alert. By default, 12 listings is returned (added in Osclass 8.0.2)
user_public_profile_items_per_page / controller / user-non-secure.php – change number of per page listings returned on public profile page. (added in Osclass 8.0.2 as public_items_per_page, changed in Osclass 8.3 into user_public_profile_items_per_page)
user_items_per_page / controller / user.php – change number of per page listings returned on user items page. (added in Osclass 8.3)
search_list_orders / helpers / hSearch.php – change predefined list (array) of order types/options (added in Osclass 8.0.2). Default options are: Newly listed, Lower price first, Higher price first.
search_list_columns / model / Search.php – list of allowed columns for sorting (added in Osclass 8.0.2). Default values are i_price, dt_pub_date, dt_expiration.
search_list_types / model / Search.php – list of allowed sorting types (added in Osclass 8.0.2). Default values are asc, desc.
ipdata_service_map / osclass / functions.php – array with mapping for geo service (IP data) to retrieve country code and related data for subdomains.
rtl_lang_codes / helpers / hDefines.php – array of rtl language codes (5-letter long) used to identify if language is on RTL list. Only used when b_rtl is not defined for language.
subdomain_top_url / helpers / hDefines.php – URL used to navigate to top-level domain. Used when subdomains are activated. Example: https://domain.com/index.php?nored=1
rewrite_rules_array_init / oc-includes / osclass / classes / Rewrite.php – List of rewrite rules read from DB on initialize. Can be modified, altered or added new rules. Array has structure $key => $value, where $key represent regex and $value represent redirect. See “List of default Osclass rewrite rules” section at bottom of this page.
rewrite_rules_array_save / oc-includes / osclass / classes / Rewrite.php – List of rewrite rules right before they are saved into database.
rss_add_item / oc-includes / osclass / classes / RSSFeed.php – Single item added into RSS items. (added in Osclass 8.2.0)
rss_items / oc-includes / osclass / classes / RSSFeed.php – All RSS items before loop starts. (added in Osclass 8.2.0)
canonical_url_public_profile / oc-includes / osclass / controller / user-non-secure.php – canonical URL before stored into view
canonical_url_search / oc-includes / osclass / controller / search.php – canonical URL before stored into view
canonical_url_osc / oc-includes / osclass / helpers / hSearch.php – get canonical URL from view
canonical_url / oc-includes / osclass / functions.php – default canonical url if “generate canonical url always” is enabled in Settings > General, before url is stored into view
widget_content / oc-includes / osclass / helpers / hUtils.php – applied on widget content if not empty
widget_content_wrap / oc-includes / osclass / functions.php – applied on widget content after wrapped into div
pre_send_mail_filter / oc-includes / osclass / utils.php – if this filter returns array(‘stop’ => true), no email will be sent. Use $params and $type as parameters (Osclass 8.3).
structured_data_rating_value, structured_data_rating_best, structured_data_rating_worst, structured_data_rating_count / oc-includes / osclass / structured-data.php – support customization of structured data ratings (Osclass 8.3)
item_stats_increase / oc-includes / osclass / model / ItemStats.php – before stats is increased (decreased), final value can be modified via this hook (Osclass 8.3)
page_visibility_custom_check / oc-includes / osclass /controller / page.php – run custom functions to validate custom static page visibility rule
osc_static_page_visibility_options / oc-includes / osclass / helpers/ hPage.php – encrich static page visibility options
user_items_custom_conditions_and, user_items_custom_conditions_or / oc-includes / osclass / controller / user.php – custom conditions for user items query
user_public_profile_custom_conditions_and, user_public_profile_custom_conditions_or/ oc-includes / osclass / controller / user-non-secure.php – custom conditions for public profile items query
TinyMCE image uploader related filters (oc-admin/themes/omega/):
tinymce_accepted_origins
tinymce_allowed_extensions
tinymce_image_folder_path
tinymce_image_folder_url
tinymce_file_name
Extract of all known filters from code (Osclass 3.9)
login_admin_title
login_admin_url
login_admin_image
page_templates
admin_favicons
admin_item_title
admin_page_title
admin_item_description
admin_page_description
actions_manage_alerts
more_actions_manage_rules
rules_processing_row
comments_processing_row
actions_manage_items
items_processing_row
items_processing_reported_row
resource_path
media_processing_row
pages_processing_row
more_actions_manage_users
actions_manage_users
users_processing_row
email_legend_words
watermark_font_path
watermark_text_value
watermark_font_size
theme_url
style_url
contact_params
pre_show_item
pre_show_items
item_title
correct_login_url_redirect
email_description
save_latest_searches_pattern
moderator_access
theme
mo_core_path
mo_theme_path
mo_plugin_path
mo_theme_messages_path
mo_core_messages_path
email_alert_validation_title
email_alert_validation_description
email_alert_validation_title_after
email_alert_validation_description_after
alert_email_hourly_title
alert_email_hourly_description
alert_email_hourly_title_after
alert_email_hourly_description_after
alert_email_daily_title
alert_email_daily_description
alert_email_daily_title_after
alert_email_daily_description_after
alert_email_weekly_title
alert_email_weekly_description
alert_email_weekly_title_after
alert_email_weekly_description_after
alert_email_instant_title
alert_email_instant_description
alert_email_instant_title_after
alert_email_instant_description_after
email_comment_validated_title
email_comment_validated_title_after
email_comment_validated_description
email_comment_validated_description_after
email_new_item_non_register_user_title
email_new_item_non_register_user_title_after
email_new_item_non_register_user_description
email_new_item_non_register_user_description_after
email_user_forgot_pass_word_title
email_user_forgot_pass_word_title_after
email_user_forgot_password_description
email_user_forgot_password_description_after
email_user_registration_title
email_user_registration_title_after
email_user_registration_description
email_user_registration_description_after
email_title
email_new_email_title
email_new_email_title_after
email_new_email_description
email_new_email_description_after
email_user_validation_title
email_user_validation_title_after
email_send_friend_title
email_send_friend_title_after
email_send_friend_description
email_send_friend_description_after
email_item_inquiry_title
email_item_inquiry_title_after
email_item_inquiry_description
email_item_inquiry_description_after
email_new_comment_admin_title
email_new_comment_admin_title_after
email_item_validation_title
email_item_validation_title_after
email_item_validation_description
email_item_validation_description_after
email_admin_new_item_title
email_admin_new_item_title_after
email_admin_new_item_description
email_admin_new_item_description_after
email_item_validation_non_register_user_title
email_item_validation_non_register_user_title_after
email_item_validation_non_register_user_description
email_item_validation_non_register_user_description_after
email_admin_user_registration_title
email_admin_user_registration_title_after
email_admin_user_regsitration_description
email_admin_user_regsitration_description_after
email_item_inquiry_title
email_item_inquiry_title_after
email_item_inquiry_description
email_item_inquiry_description_after
email_new_comment_user_title
email_new_comment_user_title_after
email_new_comment_user_description
email_new_comment_user_description_after
email_new_admin_title
email_new_admin_title_after
email_new_admin_description
email_new_admin_description_after
email_warn_expiration_title
email_warn_expiration_title_after
email_warn_expiration_description
email_warn_expiration_description_after
email_after_auto_upgrade_title
email_after_auto_upgrade_title_after
email_after_auto_upgrade_description
email_after_auto_upgrade_description_after
osc_item_edit_meta_textarea_value_filter
meta_title_filter
meta_description_filter
meta_description_filter
current_admin_menu_
base_url
admin_base_url
item_price
flash_message_text
osc_show_flash_message
osc_add_flash_message_value
gettext
ngettext
user_menu_filter
item_add_prepare_data
pre_item_add_error
item_edit_prepare_data
pre_item_edit_error
item_prepare_data
upload_image_extension
upload_image_mime
slug
search_cond_pattern (Osclass 8.2.0)
sql_search_conditions
sql_search_fields
sql_search_item_conditions
user_add_flash_error
init_send_mail
mail_from
mail_from_name
pre_send_mail
shutdown_functions
List of default Osclass rewrite rules 
[^contact/?$] => index.php?page=contact
[^feed/?$] => index.php?page=search&sFeed=rss
[^feed/(.+)/?$] => index.php?page=search&sFeed=$1
[^language/(.*?)/?$] => index.php?page=language&locale=$1
[^search$] => index.php?page=search
[^search/(.*)$] => index.php?page=search&sParams=$1
[^item/mark/(.*?)/([0-9]+)/?$] => index.php?page=item&action=mark&as=$1&id=$2
[^item/send-friend/([0-9]+)/?$] => index.php?page=item&action=send_friend&id=$1
[^item/contact/([0-9]+)/?$] => index.php?page=item&action=contact&id=$1
[^item/new/?$] => index.php?page=item&action=item_add
[^item/new/([0-9]+)/?$] => index.php?page=item&action=item_add&catId=$1
[^item/activate/([0-9]+)/(.*?)/?$] => index.php?page=item&action=activate&id=$1&secret=$2
[^item/deactivate/([0-9]+)/(.*?)/?$] => index.php?page=item&action=deactivate&id=$1&secret=$2
[^item/renew/([0-9]+)/(.*?)/?$] => index.php?page=item&action=renew&id=$1&secret=$2
[^item/edit/([0-9]+)/(.*?)/?$] => index.php?page=item&action=item_edit&id=$1&secret=$2
[^item/delete/([0-9]+)/(.*?)/?$] => index.php?page=item&action=item_delete&id=$1&secret=$2
[^resource/delete/([0-9]+)/([0-9]+)/([0-9A-Za-z]+)/?(.*?)/?$] => index.php?page=item&action=deleteResource&id=$1&item=$2&code=$3&secret=$4
[^([a-z]{2})_([A-Z]{2})/.*/.*_i([0-9]+)\?comments-page=([0-9al]*)$] => index.php?page=item&id=$3&lang=$1_$2&comments-page=$4
[^.*/.*_i([0-9]+)\?comments-page=([0-9al]*)$] => index.php?page=item&id=$1&comments-page=$2
[^([a-z]{2})_([A-Z]{2})/.*/.*_i([0-9]+)$] => index.php?page=item&id=$3&lang=$1_$2
[^.*/.*_i([0-9]+)$] => index.php?page=item&id=$1
[^user/login/?$] => index.php?page=login
[^user/dashboard/?$] => index.php?page=user&action=dashboard
[^user/logout/?$] => index.php?page=main&action=logout
[^user/register/?$] => index.php?page=register&action=register
[^user/activate/([0-9]+)/(.*?)/?$] => index.php?page=register&action=validate&id=$1&code=$2
[^alert/confirm/([0-9]+)/([a-zA-Z0-9]+)/(.+)$] => index.php?page=user&action=activate_alert&id=$1&email=$3&secret=$2
[^user/profile/?$] => index.php?page=user&action=profile
[^user/profile/([0-9]+)/?$] => index.php?page=user&action=pub_profile&id=$1
[^user/profile/(.+)/?$] => index.php?page=user&action=pub_profile&username=$1
[^user/items/?$] => index.php?page=user&action=items
[^user/alerts/?$] => index.php?page=user&action=alerts
[^user/recover/?$] => index.php?page=login&action=recover
[^user/forgot/([0-9]+)/(.*)/?$] => index.php?page=login&action=forgot&userId=$1&code=$2
[^password/change/?$] => index.php?page=user&action=change_password
[^email/change/?$] => index.php?page=user&action=change_email
[^username/change/?$] => index.php?page=user&action=change_username
[^email/confirm/([0-9]+)/(.*?)/?$] => index.php?page=user&action=change_email_confirm&userId=$1&code=$2
[^([\p{L}\p{N}_\-,]+)-p([0-9]+)/?$] => index.php?page=page&id=$2&slug=$1
[^([a-z]{2})_([A-Z]{2})/([\p{L}\p{N}_\-,]+)-p([0-9]+)/?$] => index.php?page=page&lang=$1_$2&id=$4&slug=$3
[^([a-z]{2})-([A-Z]{2})/([\p{L}\p{N}_\-,]+)-p([0-9]+)/?$] => index.php?page=page&lang=$1_$2&id=$4&slug=$3
[^([a-z]{2})/([\p{L}\p{N}_\-,]+)-p([0-9]+)/?$] => index.php?page=page&lang=$1&id=$3&slug=$2
[^(.+?)\.php(.*)$] => $1.php$2
[^(.+)/([0-9]+)$] => index.php?page=search&iPage=$2
[^(.+)/?$] => index.php?page=search&sCategory=$1
[^(.+)$] => index.php?page=search

(https://docs.osclass-classifieds.com/child-themes-i79)
Child Themes
Creating a Child Theme in Osclass A child theme in Osclass allows customization of a theme without modifying the original (parent) theme. This approach ensures that updates to the parent theme do not overwrite custom modifications. Child themes contain only the files that need modification, reducing redundancy and improving maintainability. Why Use a Child Theme? Child themes are beneficial for:
Preserving custom modifications while allowing updates to the parent theme.
Keeping customization separate, making it easier to manage and troubleshoot.
Allowing selective modification of specific files without affecting the entire theme.
Creating a Blank Child Theme Step 1: Create the Child Theme Folder Navigate to oc-content/themes/ and create a new folder for the child theme. The recommended naming format is yourtheme_child. For example, if the parent theme is gamma, the child theme folder should be gamma_child. Step 2: Add Essential Files Inside the newly created folder, add the following files:
index.php – Required to define the theme and set the parent theme.
screenshot.png – A preview image displayed in the backoffice.
Step 3: Define the Child Theme Open index.php and add the following metadata:

<?php
/*
Theme Name: Gamma CHILD Osclass Theme
Theme URI: https://osclasspoint.com/
Description: Child theme for Gamma Osclass Theme
Version: 1.0.0
Author: Your Name
Author URI: https://osclasspoint.com
Widgets: header,footer
Theme update URI: gamma-osclass-theme
Product Key: XYZ123
Parent Theme: gamma
*/
?>

This defines the child theme and its relationship with the parent theme. Working with a Child Theme Understanding File Inheritance Osclass loads theme files from the child theme first. If a file does not exist in the child theme, Osclass loads it from the parent theme. This allows selective customization without duplicating all files. Replacing Theme Files There are two types of file replacements:
Osclass-Initiated Files: Directly loaded by Osclass, such as main.php, search.php, item.php, and user-register.php.
Theme-Initiated Files: Loaded dynamically, such as header.php, head.php, loop-single.php, and search_gallery.php.
Adding Custom CSS Step 1: Create a Custom Stylesheet To add a custom stylesheet without modifying the parent theme’s head.php, use a function to enqueue the new stylesheet. Create a functions.php file in the child theme folder and add the following function:

<?php
function gam_child_custom_css() {
    osc_enqueue_style('style-child', osc_current_web_theme_url('css/style-child.css'));
}
osc_add_hook('header', 'gam_child_custom_css');
?>

Next, create a css/ folder inside the child theme directory and add a style-child.css file. The website will now load this custom stylesheet. Modifying the Footer Step 1: Copy the Main Template File To change the footer only on the homepage:
Copy main.php from the parent theme to the child theme.
Edit the copied main.php and replace this line:

<?php osc_current_web_theme_path('footer.php'); ?>

with:

<?php include osc_base_path() . 'oc-content/themes/gamma_child/footer.php'; ?>

Then, create a new footer.php file in the child theme and add custom content:

<footer>Hello world footer!</footer>
 Adding Content to the Homepage To insert custom content on the homepage:
Copy main.php to the child theme.
Open main.php and add the desired text.
Best Practices for Child Themes Handling Translations Translations for the child theme should be placed in oc-content/languages. Ensure the language files match the child theme name. Tracking Parent Theme Updates Since parent theme updates may introduce changes, use a version control system or compare files to keep track of modifications. Recommended Use It is best to use child themes for adding CSS, JavaScript, and functions via hooks rather than modifying core files. Extensive modifications may require frequent updates when the parent theme changes. Conclusion Using a child theme in Osclass ensures easy customization while maintaining compatibility with future updates. It provides a structured way to apply changes without affecting the parent theme. Always test modifications on a staging environment before applying them to a live site.

(https://docs.osclass-classifieds.com/user-image-uploader-avatar-i84)
User Image Uploader (avatar)
Integrating the User Image Uploader (Avatar) into the User Profile Osclass now includes a built-in profile (avatar) image uploader, removing the need for third-party plugins. However, many themes do not utilize this feature because they were developed before it was available. This guide will show you how to integrate the built-in image uploader into your theme. We will use your_theme as a placeholder. Replace this with the actual folder name of your theme, such as alpha, beta, gamma, delta, epsilon, veronika, stela, etc. Two Integration Methods
For Osclass 8.2.0 and higher (simplified method)
For Osclass 8.1.2 and lower (manual method with Cropper.js integration)
Method 1: Osclass 8.2.0 and Higher Step 1: Modify the user profile file
Open the file oc-content/themes/your_theme/user-profile.php
Find the opening <form> tag and locate the last hidden input field
Insert the following code right after the last hidden input field:

<?php if(osc_profile_img_users_enabled()) { ?>
  <div class="control-group">
    <label class="control-label" for="name"><?php _e('Picture', 'your_theme'); ?></label>
    <div class="controls">
      <div class="user-img">
        <div class="img-preview">
          <img src="<?php echo osc_user_profile_img_url(osc_logged_user_id()); ?>" 
               alt="<?php echo osc_esc_html(osc_logged_user_name()); ?>"/>
        </div> 
      </div>

      <div class="user-img-button">
        <?php UserForm::upload_profile_img(); ?>
      </div>
    </div>

  </div>
<?php } ?>
 That’s it. The uploader should now appear in the user profile page. You may want to adjust CSS styling in your theme for buttons. Method 2: Osclass 8.1.2 and Lower For Osclass 8.1.2 and earlier, the integration requires additional JavaScript and CSS (Cropper.js). Step 1: Enqueue Cropper.js
Open the file oc-content/themes/your_theme/user-profile.php
At the top of the file, right after the opening <?php tag, insert the following code:
if(osc_profile_img_users_enabled() == '1') {
  osc_enqueue_script('cropper');
  osc_enqueue_style('cropper', osc_assets_url('js/cropper/cropper.min.css'));
}
 Step 2: Modify the User Profile Form Now, find the <form> tag inside user-profile.php and locate the last hidden input field. Insert the following right after it: 
<?php if(osc_profile_img_users_enabled()) { ?>
  <div class="control-group">
    <label class="control-label" for="name"><?php _e('Picture', 'your_theme'); ?></label>
    <div class="controls">
      <div class="user-img">
        <div class="img-preview">
          <img src="<?php echo osc_user_profile_img_url(osc_logged_user_id()); ?>" 
               alt="<?php echo osc_esc_html(osc_logged_user_name()); ?>"/>
        </div> 
      </div>

      <div class="user-img-button">
        <?php UserForm::upload_profile_img(); ?>
      </div>
    </div>

  </div>
<?php } ?>
 Step 3: Remove Old Plugin Code Since you are now using Osclass’s built-in image uploader, remove any legacy profile picture plugin code from user-profile.php. Final Code for Osclass 8.1.2 and Lower After completing the above steps, your user-profile.php file should look like this: 
<?php
/*
 * Copyright 2014 Osclass
 * Copyright 2021 Osclass by OsclassPoint.com
 *
 * Osclass maintained & developed by OsclassPoint.com
 */


if(osc_profile_img_users_enabled() == '1') {
osc_enqueue_script('cropper');
osc_enqueue_style('cropper', osc_assets_url('js/cropper/cropper.min.css'));
}

// meta tag robots
osc_add_hook('header','sigma_nofollow_construct');

sigma_add_body_class('user user-profile');
osc_add_hook('before-main','sidebar');
function sidebar(){
osc_current_web_theme_path('user-sidebar.php');
}
osc_add_filter('meta_title_filter','custom_meta_title');
function custom_meta_title($data){
  return __('Update account', 'sigma');
}
osc_current_web_theme_path('header.php') ;
$osc_user = osc_user();
?>

<h1><?php _e('Update account', 'sigma'); ?></h1>
<?php UserForm::location_javascript(); ?>
<div class="form-container form-horizontal">
  <div class="resp-wrapper">
    <ul id="error_list"></ul>
    <form action="<?php echo osc_base_url(true); ?>" method="post">
      <input type="hidden" name="page" value="user" />
      <input type="hidden" name="action" value="profile_post" />

      <?php if(osc_profile_img_users_enabled()) { ?>
        <div class="control-group">
          <label class="control-label" for="name"><?php _e('Picture', 'sigma'); ?></label>
          <div class="controls">
            <div class="user-img">
              <div class="img-preview">
                <img src="<?php echo osc_user_profile_img_url(osc_logged_user_id()); ?>"
                     alt="<?php echo osc_esc_html(osc_logged_user_name()); ?>"/>
              </div>
            </div>

            <div class="user-img-button">
              <?php UserForm::upload_profile_img(); ?>
            </div>
          </div>
        </div>
      <?php } ?>

(https://docs.osclass-classifieds.com/emoji-in-texts-i109)
Emoji in Texts
Osclass 8.3 supports Emoji in textual fields, however for existing installation there may be action required on site owners. As it's not possible to automatically convert some tables charset to utf8mb4 due to foreign keys, it's manual process left to site owners. Procedure to convert tables 1. List of tables
oc_t_locale
oc_t_user_description
oc_t_pages_description
oc_t_category_description
oc_t_keywords (optional)
oc_t_preferece (optional) 2. Drop indexes In first step, drop indexes on fk_c_locale_code column that would block conversion. It's ideal to store index definition so you can recreate it after. 3. Change tables charset to utf8mb4 Now it's time to update tables so they support emoji.
ALTER TABLE oc_t_locale CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE oc_t_pages_description CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE oc_t_category_description CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE oc_t_user_description CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE oc_t_keywords CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE oc_t_preference CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; 4. Create indexes to locale table All is completed, now just add back indexes. Sample index definition:
ALTER TABLE oc_t_pages_description ADD INDEX fk_c_locale_code (fk_c_locale_code) USING BTREE;
Summary You have now converted tables into utf8mb4 charset that supports emoji. Note that when you will convert locale table, you might get more tables/indexes complaining. You will need to drop all of them and then recreate. Also note there should be no serious harm not to create indexes back.

(https://docs.osclass-classifieds.com/use-optimized-functions-i111)
Use Optimized Functions
Osclass 8.3 brings a lot of new functions including optimized data loader functions those avoid excessive and repetitive database queries and store them into session for possible repetitive use, sort or filter. Optimized Functions How it works? Let's analyze it:
Problem: get list of available countries from Osclass and then US country.
Function: $data = Country::newInstance()->listAll(); $row = Country::newInstance()->findByCode('US');
In above scenario, if we repeat using these functions 50 times, we get 100 database queries/calls all together. That's quite a lot!
This was pretty fast, but what if we need that on 50 different files? And what if we need just one country? Or we have 20 queries getting country-level data - country by country? ... this leads to many repetitive database calls. Some can be optimized by using database cache like memcached, but some of them not. What can we do about it? Use optimized way to access data:
Solution: Store data into session and for specific row-level queries reuse these data.
Function: $data = osc_get_countries(); $row = osc_get_country_row('US');
In this case, if we use just 1 database call. Why one? because at first, all country data are loaded from database and stored into session. When we try to get US data next, we first check if this value was already received from DB and stored into session. If it's there - use it!
Support and limitations We have such functions for most of data - country, region, city, category, user, ... In many cases, it's not possible to load everything into session as it's too much data and it would be slow. For categories, there is also available constant OPTIMIZE_CATEGORIES (true/false) and OPTIMIZE_CATEGORIES_LIMIT (int) to enable/disable preloads into session. Default value is between 1000-2000 categories. If you use more, it's not going to preload everything. Anyway, for objects like user, item... these are still going to be stored under their IDs, as when we received data for one item or user from DB, why not to store it for possible reuse? Especially for premium items or logged user record it's going to save a lot of queries. Summary Use optimized functions anywhere it's possible to reduce database queries, review helper files for list of supported functions in your current Osclass installation.

(https://docs.osclass-classifieds.com/alert-frequency-buttons-integration-into-theme-i116)
Alert frequency buttons integration into theme
Osclass 8.3 brings possibility to select alerts (subscriptions) frequency. Available values are:
Instant (using minutely cron)
Hourly
Daily
Weekly
To support this feature, place following code into your alert section:

<?php echo osc_alert_change_frequency(osc_alert()); ?>

Note that in some themes, osc_alert() might not return valida values, as alerts might be printed with loop. Identify what object stores current alert object and replace osc_alert() with for example $alert. In such case, integration code would look like: <?php echo osc_alert_change_frequency(osc_alert()); ?> Update your style.css to show it nicely:
/_ ALERTS FREQUENCY _/
.alert-frequency {display:flex;float: left; align-items: center; flex-wrap: nowrap;margin:2px 0 10px 0;}
.alert-frequency > a {padding:5px 10px;font-size:14px;line-height:16px;margin:0 -1px 0 0;border:1px solid #ccc;background:#fff;}
.alert-frequency > a:first-child {border-radius:4px 0 0 4px;}
.alert-frequency > a:last-child {border-radius:0 4px 4px 0;}
.alert-frequency > a.active {background:#f0f0f0;font-weight:600;}
.alert-frequency > a:hover {text-decoration:none;background:#f0f0f0;}
Alert name Osclass 8.3 also generates alert names and store these values into database. Up to now, alert names might be generated dynamically that was pretty expensive task and could also be inaccurate. To use alert name, just replace current name with:

<?php echo osc_alert_name(); ?>

As in previous integration, even here might happen that osc_alert() is not available and alert object is stored in variable. Let's say it's again variable $alert. In such case update your integration to:

<?php echo $alert['s_name']; ?>

Note that existing alerts will not be given name, it's valid just for newly created alerts, so it could be helpful to check if name is defined, if not use old method. Example is here:

<?php
  if(function_exists('osc_alert_name') && isset($a['s_name']) && $a['s_name'] != '') {
    echo $a['s_name'];
  } else {
    echo __('Alert', 'alpha') . ' #' . $c;
  }
?>

Hope this article helps you to implement new Osclass features!

(https://docs.osclass-classifieds.com/user-items-filter-and-public-profile-filter-implementation-i117)
User Items Filter and Public Profile Filter Implementation
In this guide we will implement new Osclass 8.3 features - filters of listings in User Items page and Public Profile page. These filters allow users to quickly refine items in case there is many of them. User Items Filter Go to your theme folder, open user-items.php and place there (ideally above items) following code:

<form name="user-items-search" action="<?php echo osc_base_url(true); ?>" method="get" class="user-items-search-form nocsrf">
  <input type="hidden" name="page" value="user"/>
  <input type="hidden" name="action" value="items"/>

  <?php osc_run_hook('user_items_search_form_top'); ?>

  <div class="control-group">
    <label class="control-label" for="sItemType"><?php _e('Item type', 'alpha'); ?></label>
    
    <div class="controls">
      <?php UserForm::search_item_type_select(); ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="sPattern"><?php _e('Keyword', 'alpha'); ?></label>
    
    <div class="controls">
      <?php UserForm::search_pattern_text(); ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="sCategory"><?php _e('Category', 'alpha'); ?></label>
    
    <div class="controls">
      <?php UserForm::search_category_select(); ?>
    </div>
  </div>

  <?php osc_run_hook('user_items_search_form_bottom'); ?>

  <div class="actions">
    <button type="submit" class="btn btn-primary"><?php _e('Apply', 'alpha'); ?></button>
  </div>
</form>
   Stylesheet update (style.css): 
/* USER ITEMS SEARCH */
form[name="user-items-search"] {display:flex;flex-direction: row; align-items: flex-end;margin:2px 0 14px 0;width:100%;padding-right:15px;}
form[name="user-items-search"] .control-group {width:fit-content;padding:0 12px 6px 0;}
form[name="user-items-search"] .control-group label {float:left;width:100%;text-align:left;margin:0 0 2px 0;}
form[name="user-items-search"] .control-group .controls {float:left;width:100%;margin:0;}
form[name="user-items-search"] .control-group .controls input, form[name="user-items-search"] .control-group .controls select {float:left;width:100%;margin:0;max-width:100%;min-width:unset;}
form[name="user-items-search"] .actions {width:fit-content;padding:0 0 6px 0;}
form[name="user-items-search"] .actions button {white-space:nowrap;font-weight:600;}

@media screen and (max-width: 540px) {
form[name="user-items-search"] {flex-wrap: wrap;}
form[name="user-items-search"] .control-group {width:50%;}
}
Public Profile Filter Go to your theme folder, open user-public-profile.php and place there (ideally above items) following code:

<form name="user-public-profile-search" action="<?php echo osc_base_url(true); ?>" method="get" class="user-public-profile-search-form nocsrf">
  <input type="hidden" name="page" value="user"/>
  <input type="hidden" name="action" value="pub_profile"/>
  <input type="hidden" name="id" value="<?php echo osc_esc_html($user['pk_i_id']); ?>"/>

  <?php osc_run_hook('user_public_profile_search_form_top'); ?>

  <div class="control-group">
    <label class="control-label" for="sPattern"><?php _e('Keyword', 'alpha'); ?></label>
    
    <div class="controls">
      <?php UserForm::search_pattern_text(); ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="sCategory"><?php _e('Category', 'alpha'); ?></label>
    
    <div class="controls">
      <?php UserForm::search_category_select(); ?>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="sCity"><?php _e('City', 'alpha'); ?></label>
    
    <div class="controls">
      <?php UserForm::search_city_select(); ?>
    </div>
  </div>
  
  <?php osc_run_hook('user_public_profile_search_form_bottom'); ?>
  
  <div class="actions">
    <button type="submit" class="btn btn-primary"><?php _e('Apply', 'alpha'); ?></button>
  </div>
</form>
 Stylesheet update (style.css): 
/* USER PUBLIC PROFILE SEARCH */
form[name="user-public-profile-search"] {display:flex;flex-direction: row; align-items: flex-end;margin:15px 0 0px 0;width:100%;padding:0 15px;}
form[name="user-public-profile-search"] .control-group {width:fit-content;padding:0 12px 6px 0;}
form[name="user-public-profile-search"] .control-group label {float:left;width:100%;text-align:left;margin:0 0 2px 0;}
form[name="user-public-profile-search"] .control-group .controls {float:left;width:100%;margin:0;}
form[name="user-public-profile-search"] .control-group .controls input, form[name="user-public-profile-search"] .control-group .controls select {float:left;width:100%;margin:0;max-width:100%;min-width:unset;}
form[name="user-public-profile-search"] .actions {width:fit-content;padding:0 0 6px 0;}
form[name="user-public-profile-search"] .actions button {white-space:nowrap;font-weight:600;}

@media screen and (max-width: 540px) {
form[name="user-public-profile-search"] {flex-wrap: wrap;}
form[name="user-public-profile-search"] .control-group {width:50%;}
}
/code>
Available Filter Options to Customize There are more filters then included by default. Feel free to customize based on your preference and business need:
search_pattern_text
search_category_select
search_country_select
search_region_select
search_city_select
search_item_type_select
In future, there might be even more available.

Please review the Clean Coder resources (https://blog.cleancoder.com ), the Clean Architecture article (https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html ), and the official Osclass documentation, including the Developer Guide (https://docs.osclass-classifieds.com/developer-guide ), Programming Standards (https://docs.osclass-classifieds.com/programming-standards-i75 ), Child Theme Guidelines (https://docs.osclass-classifieds.com/child-themes-i79 ) (https://osclasspoint.com/blog/osclass-create-child-theme-b21), and the Customization Guide for Hooks, Themes, and Plugins (https://osclass-classifieds.com/article/developer-guide-customizing-osclass-hooks-themes-plugins ).

The Ultimate Developer's Guide to Customizing Osclass: Hooks, Themes, and PluginsOsclass stands apart in the world of classifieds software due to its deliberate simplicity and raw power. As a standalone application built with pure, framework-free PHP, it offers developers an unparalleled level of control and performance, unburdened by the overhead of a multi-purpose CMS. This direct access, however, is governed by a single, unbreakable rule: Never, ever hack the core.This in-depth technical guide is for PHP developers ready to master the Osclass platform the right way. We will dissect the three pillars of professional Osclass development: leveraging the powerful Hooks system for seamless interaction, building Child Themes for complete visual control, and engineering robust Plugins to introduce new functionality. By mastering these concepts, you can build any type of marketplace imaginable while ensuring your platform remains secure, stable, and easily upgradeable.The Golden Rule: Why Hacking the Core is a Dead End Before you write a single line of code, this principle must be understood. Modifying Osclass core files (any file within the oc-admin or oc-includes directories) is a critical error that leads to three disastrous outcomes:
Updates Will Destroy Your Work: The moment you update to a new version of Osclass to get security patches or new features, all your custom modifications will be permanently overwritten.
You Create Security Vulnerabilities: Modifying core files can inadvertently introduce security holes and makes your site incompatible with official security patches.
Debugging Becomes Impossible: When issues arise, you won't be able to determine if the problem is a bug in the Osclass core or in your own custom code, making support from the community impossible.
The entire Osclass architecture is designed to be extended safely and efficiently through its APIs, primarily using the powerful system of **Hooks**.Part 1: Mastering Osclass Hooks (The Core Interaction API) The Hooks system is the central nervous system of Osclass development. It allows your custom code to interact with the Osclass core at hundreds of specific points without ever modifying a core file. It's directly inspired by the WordPress Hooks system and consists of two distinct types: **Actions** and **Filters**.A. Actions: Executing Your Code at Specific Events Actions are specific events that occur during the Osclass execution lifecycle (e.g., header, posted_item, user_register_completed). When Osclass reaches one of these points, it triggers the hook, checks if any functions are "registered" to it, and executes them in order of priority.You use the function osc_add_hook() to attach your custom function to an action.osc_add_hook(string $hook_name, callable $function_name, int $priority = 10); Action Example 1: Adding a Tracking Script to the Footer This is a classic "Hello World" for hooks. Instead of editing footer.php, you hook into the footer action.// In your plugin's main file or your theme's functions.php
function my_custom_tracking_script() {
    echo '<!-- Custom Google Tag Manager Code -->' . PHP_EOL;
    echo "<script>console.log('Page loaded, tracking initialized.');</script>" . PHP_EOL;
}
osc_add_hook('footer', 'my_custom_tracking_script'); Action Example 2: Performing an Action After a Listing is Published Let's create a more advanced function that logs the title of every new listing to a text file. We'll use the posted_item hook, which conveniently passes the complete item data array to our function.function log_new_listing_title($item) {
// The $item array contains all data for the newly posted item.
// Let's get the title and the ID.
$itemTitle = $item['s_title'];
$itemId = $item['pk_i_id'];
$logMessage = date('Y-m-d H:i:s') . " - New Listing Published (ID: " . $itemId . "): " . $itemTitle . PHP_EOL;

    // Define the path to our log file in a writable directory
    $logFile = osc_content_path() . 'logs/new_listings.log';

    // Use file_put_contents with the FILE_APPEND flag to add to the log
    @file_put_contents($logFile, $logMessage, FILE_APPEND);

}
osc_add_hook('posted_item', 'log_new_listing_title'); Comprehensive Action Hook Reference While there are hundreds of hooks, here are some of the most critical for developers:
System Hooks: init (runs early), before_html (before any HTML output), after_html (after all HTML output).
Header & Footer Hooks: header (in <head>), admin_header, footer (before </body>), admin_footer.
Item (Listing) Hooks: pre_item_add (before adding to DB), posted_item (after adding), pre_item_edit (before editing), edited_item (after editing), delete_item (passes $itemId), item_form (to add fields to the publish form), item_detail (to add content to the listing page).
User Hooks: before_user_register (before registration), user_register_completed (after registration, passes $userId), delete_user (passes $userId), profile_form (to add fields to the user profile).
Search Hooks: search_form (to add fields to the search form).
 B. Filters: Intercepting and Modifying Data Filters are even more powerful than actions. They give you the ability to intercept data, modify it, and then return it before it's used by Osclass (either for display or for saving to the database). The most important rule of filters is that your hooked function must always return a value.You use osc_add_filter() to attach your function to a filter.osc_add_filter(string $filter_name, callable $function_name, int $priority = 10); Filter Example 1: Appending Text to Every Listing Title A simple example to illustrate the concept. We intercept the title, add our text, and return it.function append_text_to_title($title) {
// IMPORTANT: Always return the modified (or original) variable
return $title . ' - For Sale';
}
osc_add_filter('item_title', 'append_text_to_title'); Filter Example 2: Enforcing a Minimum Price The correct way to validate or modify input before it's saved to the database is to use an early action hook like pre_item_add or pre_item_edit to check the submitted parameters.function validate_minimum_price() {
$price = Params::getParam('price');
$min_price = 5000000; // Price is stored in millionths ($5.00)

    // Check if a price was submitted and if it's below the minimum
    if ($price !== '' && $price < $min_price) {
        // Add a flash message to inform the user
        osc_add_flash_error_message('The minimum price is $5. Please enter a higher value.');

        // Redirect back to the form. For the publish form:
        osc_redirect_to(osc_item_post_url());
    }

}
osc_add_hook('pre_item_add', 'validate_minimum_price');
osc_add_hook('pre_item_edit', 'validate_minimum_price'); Filter Example 3 (Advanced): Excluding a Category from Search The search_conditions filter is extremely powerful. It lets you modify the array of WHERE conditions for the item search SQL query. Let's exclude category ID 99 (e.g., "Archived Items") from all public searches.function exclude_category_from_search($conditions) {
// Add our custom WHERE clause to the array of conditions
$conditions[] = DB_TABLE_PREFIX . 't_item.fk_i_category_id <> 99';

    return $conditions;

}
osc_add_filter('search_conditions', 'exclude_category_from_search'); Comprehensive Filter Hook Reference
Meta Data Filters: meta_title, meta_description, canonical_url.
Item Data Filters: item_title, item_description, item_price.
Form & Input Filters: item_edit_prepare (modify item data before it populates the edit form).
Search Filters: search_conditions (modify WHERE clause), search_order (modify ORDER BY), search_sql (modify the entire SQL query).
Email Filters: email_user_registration_subject, email_user_registration_description (and many others for every email template).
Part 2: Theme Development (The Presentation Layer) The theme controls 100% of the HTML output of your Osclass site. A deep understanding of its structure is key to creating a unique user experience.A. The Child Theme: The Professional Standard As with the core, you should never directly edit a theme you didn't create. Always create a Child Theme. This allows you to update the parent theme (to get bug fixes and new features) without losing your customizations.To create a child theme for the default "Bender" theme:
Create a new folder: oc-content/themes/bender-child/.
Inside it, create index.php with this header: <?php
/_
Theme Name: Bender Child
Template: bender
_/
?>
The Template: bender line is the magic that links it to the parent.
Create a functions.php file in your child theme folder. This is where you can add your custom hooks and functions.
Activate your "Bender Child" theme in the admin panel.
To modify a template file (e.g., item.php), simply copy it from the parent (bender/item.php) to your child theme (bender-child/item.php) and edit it there. Osclass will automatically use your child theme's version.B. Understanding The Osclass Loop The "Loop" is the standard mechanism Osclass uses to display a list of items on a search page. Understanding it is fundamental to theme development.<?php if (osc_has_items()) { ?>
<div class="listings">
<?php while (osc_has_items()) { ?>
<div class="listing-item">
<h3><a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a></h3>
<p class="price"><?php echo osc_item_formatted_price(); ?></p>
<p class="location"><?php echo osc_item_city(); ?>, <?php echo osc_item_region(); ?></p>
<?php if(osc_count_item_resources() > 0) { ?>
<a href="<?php echo osc_item_url(); ?>">
<img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" loading="lazy">
</a>
<?php } ?>
</div>
<?php } ?>
</div>
<?php if (osc_search_total_pages() > 1) { ?>
<div class="pagination">
<?php echo osc_search_pagination(); ?>
</div>
<?php } ?>

<?php } else { ?>

    <p class="empty-search">No listings found.</p>

<?php } ?>

Part 3: Building a Plugin (The Functionality Layer) When you need to add new, self-contained functionality that is independent of the visual theme, a plugin is the correct tool.A. Plugin Activation, Deactivation, and Uninstallation A professional plugin cleans up after itself. Osclass provides hooks to manage the plugin's lifecycle.// This code runs when the user activates the plugin
function my_plugin_activate() {
// Example: Create a new database table
$conn = DBConnectionClass::newInstance();
$conn->dao->query('CREATE TABLE IF NOT EXISTS ' . DB_TABLE_PREFIX . 't_my_plugin_log (...)');

    // Example: Set a default preference
    osc_set_preference('my_plugin_version', '1.0.0', 'my_plugin_settings', 'STRING');

}
osc_register_plugin(osc_plugin_path(**FILE**), 'my_plugin_activate');

// This code runs when the user deactivates the plugin
function my_plugin_deactivate() {
// Example: Delete the preference
osc_delete_preference('my_plugin_version', 'my_plugin_settings');
}
osc_add_hook(osc_plugin_path(**FILE**) . '\_disable', 'my_plugin_deactivate');

// This code runs when the user uninstalls the plugin
function my_plugin_uninstall() {
// Example: Drop the custom database table
$conn = DBConnectionClass::newInstance();
$conn->dao->query('DROP TABLE IF EXISTS ' . DB_TABLE_PREFIX . 't_my_plugin_log');
}
osc_add_hook(osc_plugin_path(**FILE**) . '\_uninstall', 'my_plugin_uninstall');
B. Creating an Admin Settings Page A plugin with options needs a settings page in the admin panel.// In your plugin's main file, hooked to 'admin_menu_init'
function my_plugin_admin_menu() {
osc_add_admin_menu_page(
'My Plugin Settings', // Page Title
osc_admin_render_plugin_url(osc_plugin_folder(**FILE**) . 'admin.php'), // URL to your settings file
'my_plugin_settings', // Unique ID
'plugins' // Parent Menu (plugins, settings, etc.)
);
}
osc_add_hook('admin_menu_init', 'my_plugin_admin_menu');

// Then, create admin.php in your plugin folder to render the HTML form.
// In that file, you would use osc*set_preference() to save form data.
Part 4: Interacting with the Osclass Core & Data Beyond hooks and presentation, a powerful plugin or theme often needs to directly interact with the Osclass database, retrieve specific information, handle user input, and communicate back to the user. This section covers the essential APIs and helper functions you'll use every day to build dynamic and interactive features.A. Database Interaction: The Data Access Object (DAO) Osclass provides a database abstraction layer to ensure that all database queries are handled securely and consistently. You should **never** use raw mysqli*\* or PDO functions. Instead, you must use the Osclass Data Access Object (DAO). This provides a simple way to build queries and automatically handles prepared statements to prevent SQL injection.To get started, you first need to get an instance of the connection object.$conn = DBConnectionClass::newInstance();
$dao = $conn->getDao(); SELECT Queries: Fetching Data The DAO provides several methods to retrieve data. The most common is query() for custom selects, and findByPrimaryKey() for getting a single record by its ID.Example: Get the details of the 5 most recent listings.// Get the DAO instance
$dao = new DAO();

// Use the Item DAO to get the specific model for items
// This provides useful constants and table names
$itemDao = Item::newInstance();

// Build and execute the query
$dao->select('i.*, d.*');
$dao->from($itemDao->getTableName() . ' as i');
$dao->join($itemDao->getTableDescription() . ' as d', 'i.pk_i_id = d.fk_i_item_id');
$dao->where('d.fk_c_locale_code', osc_current_user_locale());
$dao->where('i.b_enabled', 1);
$dao->where('i.b_active', 1);
$dao->orderBy('i.dt_pub_date', 'DESC');
$dao->limit(5);
$result = $dao->get();

// The result is an object. To get an array of items:
$items = $result->result();

if (!empty($items)) {
    echo '<ul>';
    foreach ($items as $item) {
        // The item array contains all database fields for that listing
        echo '<li>(' . $item['pk_i_id'] . ') ' . $item['s_title'] . '</li>';
    }
    echo '</ul>';
} INSERT Queries: Adding New Data When your plugin needs its own database table, you'll use the insert() method. It takes the table name and an array of key-value pairs ('column_name' => 'value').Example: Log a search query to a custom plugin table.// Assume you created a table named 't_my_plugin_searches' during plugin activation
$searchLogTable = DB_TABLE_PREFIX . 't_my_plugin_searches';

$dataToInsert = array(
's_query' => Params::getParam('sPattern'), // Get search query safely
'dt_date' => date('Y-m-d H:i:s'),
'fk_i_user_id' => osc_logged_user_id() // Returns user ID or null
);

// Get the DAO and perform the insert
$dao = new DAO();
$success = $dao->insert($searchLogTable, $dataToInsert);

if ($success) {
    // The query was successful
} else {
    // There was an error
} UPDATE Queries: Modifying Existing Data The update() method is used to modify existing records. It requires the table name, an array of data to update, and an array specifying the WHERE clause.Example: Add a "view count" to your custom search log table.$searchLogTable = DB_TABLE_PREFIX . 't_my_plugin_searches';
$logIdToUpdate = 123; // The primary key of the record to update

// We need to increment the existing view count
$dao = new DAO();
$dao->update($searchLogTable, array('i_views = i_views + 1'), array('pk_i_id' => $logIdToUpdate)); DELETE Queries: Removing Data The delete() method removes records. It takes the table name and a WHERE clause array.Example: Delete old log entries from your custom table.$searchLogTable = DB_TABLE_PREFIX . 't_my_plugin_searches';

// Delete all logs older than 30 days
$dao = new DAO();
$success = $dao->delete($searchLogTable, "dt_date < DATE_SUB(NOW(), INTERVAL 30 DAY)");B. Using Osclass Global Helpers & The View API Osclass provides hundreds of global "helper" functions that handle the logic of retrieving and formatting data for display. You should **always** use these helpers in your themes and plugins instead of querying the database directly and formatting the data yourself. This ensures your code remains compatible with future Osclass updates.These functions are only available within the "View" context. This means they work automatically in theme files. If you need to use them inside a function in a plugin, you must first get the View object.$view = View::newInstance(); Item Helpers (Inside the Loop) These functions work when you are inside the Osclass Loop (while (osc_has_items()) { ... }) on a search page, or on an item page. They automatically refer to the current listing being displayed.
osc_item_id(): Returns the integer ID of the item.
osc_item_title(): Returns the sanitized title of the item.
osc_item_description(): Returns the sanitized description.
osc_item_formatted_price(): Returns the price, correctly formatted with currency symbol and decimal places.
osc_item_pub_date(): Returns the publication date, formatted according to your site's settings.
osc_item_city(), osc_item_region(), osc_item_country(): Returns location details.
osc_item_url(): Returns the full, SEO-friendly URL to the listing.
osc_count_item_resources(): Returns the number of images/media attached to the listing.
User Helpers These functions help you retrieve information about the currently logged-in user or the user who posted a listing.
osc_is_web_user_logged_in(): Returns true or false. Essential for conditional logic.
osc_logged_user_id(): Returns the integer ID of the logged-in user.
osc_logged_user_name(): Returns the name of the logged-in user.
osc_logged_user_email(): Returns the email of the logged-in user.
osc_user_id(): Inside the loop or on an item page, returns the ID of the item's author.
osc_user_name(): Inside the loop or on an item page, returns the name of the item's author.
URL Helpers Never hardcode URLs in your themes or plugins. Always use URL helpers to generate them dynamically. This ensures your links will work even if you change your site's URL structure.
osc_base_url(): Returns the base URL of your site.
osc_contact_url(): Returns the URL of the contact page.
osc_user_dashboard_url(): Returns the URL to the logged-in user's dashboard.
osc_user_login_url(): Returns the URL of the login page.
osc_user_register_url(): Returns the URL of the registration page.
C. Handling Forms & Secure User Input When creating a settings page for a plugin or a custom form for users, you must handle the input securely. Osclass provides tools to help with this.Step 1: Creating the Form with CSRF Protection Cross-Site Request Forgery (CSRF) is a common vulnerability. Osclass has a built-in system to prevent it. You must include a CSRF token in all your forms.<form action="<?php echo osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin.php'); ?>" method="post">
<!-- IMPORTANT: This hidden input is for security -->
<input type="hidden" name="action_specific" value="save_my_settings" />
<?php AdminForm::generate_csrf_token(); ?>

    <h2>My Plugin Settings</h2>
    <label for="apiKey">API Key</label>
    <input type="text" name="apiKey" id="apiKey" value="<?php echo osc_esc_html(osc_get_preference('api_key', 'my_plugin_settings')); ?>" />

    <button type="submit">Save Settings</button>

</form> Step 2: Processing the Form Data Safely In your processing file (my_plugin/admin.php in this case), you must verify the CSRF token and use the Params class to retrieve the submitted data. **Never use $_POST or $_GET directly.** The Params class automatically runs sanitization routines on the input.<?php
// First, check if the form was submitted with our specific action
if (Params::getParam('action_specific') == 'save_my_settings') {
    
    // SECOND, verify the CSRF token to prevent unauthorized submissions
    AdminForm::is_csrf_token_valid();

    // THIRD, get the submitted data using the Params class
    $apiKey = Params::getParam('apiKey', false, false); // Params::getParam(key, xss_check, quotes_check)

    // FOURTH, save the data using the Preferences API
    osc_set_preference('api_key', $apiKey, 'my_plugin_settings', 'STRING');

    // FIFTH, provide feedback to the user and redirect
    osc_add_flash_ok_message('Your settings have been saved successfully.', 'admin');
    osc_redirect_to(osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin.php'));

}
?>
D. Communicating with the User via Flash Messages Flash messages are temporary notifications displayed to the user after they perform an action (e.g., "Your listing has been published," "Settings saved," "Invalid email address").Setting a Flash Message You can set flash messages from anywhere in your plugin or theme's functions. They are stored in the session and displayed on the next page load.
osc_add_flash_ok_message('Success! Your profile was updated.') - For success (green).
osc_add_flash_info_message('Your subscription is expiring in 7 days.') - For information (blue).
osc_add_flash_warning_message('Please review your listing before publishing.') - For warnings (yellow).
osc_add_flash_error_message('The password you entered was incorrect.') - For errors (red).
Displaying Flash Messages in a Theme To actually show the messages to the user, you need to include the generic message template in your theme files (e.g., in header.php or main.php).<?php osc_show_flash_message(); ?>This single function will render any pending flash messages with the correct styling and then clear them from the session so they don't appear again.Part 5: Advanced Plugin & Theme Development Techniques With the fundamentals of hooks, themes, and database interaction covered, we can now explore more advanced techniques that are essential for building a modern, dynamic, and professional Osclass platform. This section will cover implementing AJAX, making your extensions translatable (Internationalization), working with custom fields, and creating unique URL routes.A. Implementing AJAX in Osclass for Dynamic Content Asynchronous JavaScript and XML (AJAX) allows you to update parts of a webpage without needing to reload the entire page. This is crucial for features like live search, contact forms, or adding an item to a "favorites" list. Osclass has a built-in AJAX handler that makes this process secure and standardized.The process involves three key steps: the JavaScript request, hooking into the Osclass AJAX API, and the PHP handler function.Step 1: The JavaScript Request (Client-Side) First, you need to write the JavaScript that sends the request. We'll use jQuery, which is included with Osclass. The critical part is passing a security token to verify the request is legitimate.Example: A "Favorite this Item" button in item.php.<!-- In your theme's item.php file -->
<button class="add-to-favorites" data-item-id="<?php echo osc_item_id(); ?>">Add to Favorites</button>
// In your theme's main javascript file
$(document).ready(function(){
$('.add-to-favorites').on('click', function(e){
e.preventDefault();

        var button = $(this);
        var itemId = button.data('item-id');

        // The AJAX URL needs a custom action name
        var ajaxUrl = '<?php echo osc_ajax_hook_url('my_plugin_favorite_item'); ?>';

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                itemId: itemId
            },
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    button.text('Favorited!').prop('disabled', true);
                    alert(response.message);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('An unexpected error occurred. Please try again.');
            }
        });
    });

});
Step 2: Hooking into the Osclass AJAX API (Server-Side) Osclass listens for AJAX calls using a specific action hook format: osc*ajax*{your_action_name}. The your_action_name must match what you used to generate the AJAX URL in your JavaScript.// In your plugin's main file or your theme's functions.php
osc_add_hook('osc_ajax_my_plugin_favorite_item', 'my_plugin_handle_favorite_request'); Step 3: The PHP Handler Function (Server-Side) This is the PHP function that will process the request. It must perform its logic and then echo a JSON-encoded response before terminating the script.function my_plugin_handle_favorite_request() {
// Get the data from the request
$itemId = Params::getParam('itemId');
$userId = osc_logged_user_id();

    // Perform your business logic
    if (!$userId) {
        echo json_encode(['success' => false, 'message' => 'You must be logged in to favorite items.']);
        die();
    }

    if ($itemId > 0) {
        // Here, you would add your database logic to save the favorite.
        // For example: Favorites::newInstance()->add($userId, $itemId);

        $response = [
            'success' => true,
            'message' => 'Item successfully added to your favorites!'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Invalid Item ID provided.'
        ];
    }

    // Echo the response and terminate the script
    header('Content-Type: application/json');
    echo json_encode($response);
    die();

}
B. Internationalization (i18n): Making Your Extensions Translatable If you plan to share your plugin or theme, it is essential to make it translatable. This process, called Internationalization (i18n), involves wrapping all human-readable strings in your code with special Gettext functions. This allows other users to create language files (.po and .mo) to translate your extension into their own language.The Core Gettext Functions Osclass provides several helper functions that are wrappers for the standard PHP Gettext extension.
\_\_(): Use this when you need to **return** a translatable string (e.g., assign it to a variable).
\_e(): Use this when you need to **echo** a translatable string directly to the browser.
Example: Making a simple string translatable.<?php
// --- INCORRECT (Hardcoded string) ---
$my_variable = 'Hello World';
echo '<h2>My Plugin Settings</h2>';

// --- CORRECT (Translatable strings) ---
// Use **() to return the string to a variable
$my_variable = **('Hello World', 'my_plugin_domain');

// Use \_e() to echo the string directly
echo '<h2>';
\_e('My Plugin Settings', 'my_plugin_domain');
echo '</h2>';
?>
The second argument, 'my_plugin_domain', is the "text domain." It's a unique identifier for your plugin or theme that tells Osclass which language file to load the translation from.Creating the Language FilesOnce your code is prepared with Gettext functions, you can use a program like Poedit to scan your plugin's folder. It will find all the translatable strings and generate a .pot (Portable Object Template) file. You can then translate this file into other languages, creating .po and .mo files for each one, which should be placed in your plugin's languages subfolder.C. Working with Custom Fields (Item Meta) Custom fields are one of Osclass's most powerful features for creating a niche marketplace. Once you've created a custom field in the admin panel (e.g., a "Mileage" field for cars), you need to know how to display its value in your theme.Displaying Custom Field Values on the Item Page Osclass provides a simple loop to iterate through all the custom fields associated with a listing. This should be used within your theme's item.php file.<?php if (osc_has_custom_fields()) { ?>
<div class="item-custom-fields">
<h3>Additional Details</h3>
<ul>
<?php while (osc_has_custom_fields()) { ?>
<?php if (osc_field_value() != '') { ?>
<li>
<strong><?php echo osc_field_name(); ?>:</strong>
<?php echo osc_field_value(); ?>
</li>
<?php } ?>
<?php } ?>
</ul>
</div>

<?php } ?>

D. Creating Custom URL Routes Sometimes a plugin needs its own custom, user-facing URL that doesn't follow the standard Osclass structure (e.g., your-site.com/my-plugin/dashboard/). Osclass has a routing system that lets you define custom URL rules and map them to a specific PHP file in your plugin.Registering a New Route You register a new route using osc_add_route(). This is typically done from your plugin's main file.function my_plugin_register_routes() {
osc_add_route(
'my_plugin_dashboard', // Unique Route Name
'my-plugin/dashboard/?', // The URL Regex Rule
'my-plugin/dashboard/', // The "pretty" URL to rewrite to
osc_plugin_folder(**FILE**) . 'views/user_dashboard.php' // The plugin file to load
);
}
// You can hook this into 'init'
osc_add_hook('init', 'my_plugin_register_routes');
Now, when a user visits https://your-site.com/my-plugin/dashboard/, Osclass will load the content from the user_dashboard.php file located in your plugin's views folder. This allows you to create complex, multi-page plugins with clean, SEO-friendly URLs.Part 6: Deeper Integration & Advanced Administration A truly professional Osclass plugin or theme doesn't just add front-end features; it integrates seamlessly into the Osclass administration panel. This provides a polished user experience for the site owner and elevates your extension from a simple script to a complete solution. This section covers advanced techniques for creating admin dashboard widgets, extending the core "Manage Items" table, leveraging Osclass's data storage APIs, and creating custom email notifications.A. Creating Admin Dashboard Widgets The Osclass admin dashboard is widget-based, allowing users to customize the information they see at a glance. Your plugin can register its own widgets to display important statistics, recent activity, or quick action links. This is achieved by creating a widget class and registering it with Osclass.Step 1: Registering the Widget You must tell Osclass about your new widget. This is done by hooking into the widgets_init action and calling osc_register_widget() from your plugin's main file.// In your plugin's main file
function my_plugin_register_widgets() {
require_once osc_plugin_path(**FILE**) . 'widgets/LatestUnapprovedWidget.php';
osc_register_widget('LatestUnapprovedWidget');
}
osc_add_hook('widgets_init', 'my_plugin_register_widgets');
Step 2: Building the Widget Class Now, create the actual widget file (widgets/LatestUnapprovedWidget.php). The class must extend the AdminWidget base class and implement a render() method. This method contains the logic to fetch and display the widget's content.<?php
class LatestUnapprovedWidget extends AdminWidget {

    public function __construct() {
        parent::__construct(
            'latest_unapproved_widget', // Unique widget ID
            __('Latest Unapproved Items', 'my_plugin_domain'), // Widget Name
            __('Displays a list of the 5 most recent listings awaiting approval.', 'my_plugin_domain') // Widget Description
        );
    }

    /**
     * The main function that renders the widget's HTML content.
     */
    public function render() {
        // Use the Item DAO to find items that are not active and not enabled
        $items = Item::newInstance()->find(
            array(
                'b_active'  => false,
                'b_enabled' => false
            ),
            0, // Start from the first record
            5, // Limit to 5 results
            'dt_pub_date', // Order by
            'DESC' // Order direction
        );

        echo '<div class="widget-latest-unapproved">';
        if (count($items) > 0) {
            echo '<ul>';
            foreach ($items as $item) {
                $url = osc_admin_base_url(true) . '?page=items&action=item_edit&id=' . $item['pk_i_id'];
                echo '<li>';
                echo '<a href="' . $url . '" target="_blank">' . osc_esc_html($item['s_title']) . '</a>';
                echo ' <span style="color:#999;">(' . osc_format_date($item['dt_pub_date']) . ')</span>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>' . __('No items are currently awaiting approval.', 'my_plugin_domain') . '</p>';
        }
        echo '</div>';
    }

}
?>
Once this is done, the site administrator can go to the dashboard, click "Add Widget," and find "Latest Unapproved Items" in the list of available widgets.B. Extending the Admin "Manage Items" Table One of the most powerful ways to improve an admin's workflow is to add custom, relevant information directly to the main listings table at Tools > Items. You can add new columns with custom data and even add new bulk actions.Adding a Custom Column This is a two-step process: first, you add the column header, and second, you populate the column's content for each row.// In your plugin's main file

// Step 1: Add the column header
function my_plugin_add_item_table_header($columns) {
    // Add our new column at the 3rd position (index 2)
    array_splice($columns, 2, 0, array('my_custom_column' => \_\_('My Custom Data', 'my_plugin_domain')));
return $columns;
}
osc_add_filter('manage_items_columns', 'my_plugin_add_item_table_header');

// Step 2: Populate the column for each item row
function my_plugin_add_item_table_content($item) {
    // The $item array contains all data for the current row
    // Check if we are in our custom column
    if (osc_current_admin_column() === 'my_custom_column') {
        // Example: Get a custom meta field value for this item
        $my_data = osc_get_item_meta('my_plugin_custom_field');
        echo ($my_data != '') ? osc_esc_html($my_data) : 'N/A';
}
}
osc_add_hook('items_processing_row', 'my_plugin_add_item_table_content');
Adding a New Bulk Action This allows an admin to select multiple listings and apply a custom action to all of them at once.// In your plugin's main file

// Step 1: Add the option to the dropdown menu
function my_plugin_add_bulk_action($actions) {
$actions['my_custom_action'] = \_\_('Mark as Special', 'my_plugin_domain');
return $actions;
}
osc_add_filter('item_bulk_actions', 'my_plugin_add_bulk_action');

// Step 2: Process the action when the form is submitted
function my_plugin_handle_bulk_action($action, $itemIds) {
    if ($action === 'my_custom_action') {
$count = 0;
        foreach ($itemIds as $id) {
            // Your logic here: update a custom field, send an API call, etc.
            // For example, let's update a meta field for each item
            Item::newInstance()->update(array('b_special' => 1), array('pk_i_id' => $id));
            $count++;
        }
        osc_add_flash_ok_message($count . ' ' . \_\_('items have been marked as special.', 'my_plugin_domain'), 'admin');
}
}
// Note: This hook receives the action name and an array of selected item IDs
osc_add_hook('item_bulk_action', 'my_plugin_handle_bulk_action', 10, 2);
C. The Session and Preferences APIs: Storing Data Correctly Osclass provides two primary mechanisms for storing data: the **Session** for temporary, user-specific data, and **Preferences** for permanent, site-wide settings.Working with the Session API The Session is for data that should only persist for a single user's visit. It's perfect for multi-step forms or storing temporary user choices. Always use the Session class wrapper.// Get the Session instance
$session = Session::newInstance();

// Store a value in the session
$session->\_set('my_plugin_user_choice', 'blue');

// Retrieve a value from the session
$userColor = $session->\_get('my_plugin_user_choice'); // Returns 'blue'

// Check if a session variable exists
if ($session->\_is_set('my_plugin_user_choice')) {
// ...
}

// Remove a value from the session
$session->\_drop('my_plugin_user_choice');
Working with the Preferences API Preferences are stored permanently in the t_preference database table. This is the correct way to store your plugin's settings. The API handles serialization and caching automatically.// To save a preference
// osc_set_preference(key, value, section, type)
// 'section' should be a unique name for your plugin to avoid conflicts
osc_set_preference('api_key', 'xyz123abc', 'my_plugin_settings', 'STRING');
osc_set_preference('enable_feature', true, 'my_plugin_settings', 'BOOLEAN');
osc_set_preference('item_limit', 50, 'my_plugin_settings', 'INTEGER');

// To retrieve a preference
$apiKey = osc_get_preference('api_key', 'my_plugin_settings');
$isFeatureEnabled = (bool) osc_get_preference('enable_feature', 'my_plugin_settings');

// To delete a preference
osc_delete_preference('api_key', 'my_plugin_settings');
D. Creating and Sending Custom Email Notifications A professional plugin often needs to send its own unique email notifications. Osclass has a robust, template-based email system that you should always use instead of calling PHP's mail() function directly. This ensures emails are themed correctly and can be translated by the user.Step 1: Register Your Email Template (on Plugin Activation) First, you need to add your email's content to the database so the admin can edit it.function my_plugin_activate() {
$email_data = array(
's_name' => 'My Plugin Notification',
's_internal_name' => 'my_plugin_custom_email', // Unique internal name
's_title' => 'Hello, {CONTACT_NAME}! A special event has occurred.',
's_text' => '<p>Dear {CONTACT_NAME},</p><p>We are writing to inform you that the listing "{ITEM_TITLE}" has been flagged for review.</p><p>Thank you,<br>{SITE_TITLE}</p>'
);

    // Use the EmailTemplates model to insert it
    EmailTemplates::newInstance()->insert($email_data);

}
osc_register_plugin(osc_plugin_path(**FILE**), 'my_plugin_activate');
Step 2: Triggering the Email Send To send the email, you gather your data, prepare your placeholders (like {CONTACT_NAME}), and then use osc_send_mail().function send_my_custom_notification($itemId) {
    // Get the item and user data
    $item = Item::newInstance()->findByPrimaryKey($itemId);
$user = User::newInstance()->findByPrimaryKey($item['fk_i_user_id']);

    // Get the email template from the database
    $email_template = EmailTemplates::newInstance()->findByInternalName('my_plugin_custom_email');

    // Prepare the placeholders to be replaced
    $placeholders = array(
        '{CONTACT_NAME}' => $user['s_name'],
        '{ITEM_TITLE}'   => $item['s_title'],
        '{SITE_TITLE}'   => osc_page_title(),
        '{SITE_URL}'     => osc_base_url()
    );

    // Replace placeholders in the subject and body
    $subject = osc_apply_placeholders($email_template['s_title'], $placeholders);
    $body = osc_apply_placeholders($email_template['s_text'], $placeholders);

    // Create the email parameters array
    $email_params = array(
        'to'       => $user['s_email'],
        'to_name'  => $user['s_name'],
        'subject'  => $subject,
        'body'     => $body
    );

    // Send the email using the Osclass mailer
    osc_send_mail($email_params);

}
Part 7: Advanced Development Patterns & Best Practices Mastering the APIs is the first step; becoming a professional Osclass developer requires adopting patterns that ensure your extensions are robust, secure, and seamlessly integrated. This final section moves beyond individual functions to explore higher-level concepts: leveraging the Osclass Model layer for elegant data manipulation, implementing advanced security practices, automating tasks with the Command Line Interface (CLI), and creating front-end widgets that empower site administrators.A. Leveraging the Osclass Model Layer for Cleaner Code While the Data Access Object (DAO) is excellent for custom SQL queries, Osclass is built on a Model-View-Controller (MVC) architecture. The **Models** (e.g., Item, User, Category) are the heart of this pattern. They contain the business logic and pre-built methods for common data operations. Using Models instead of the DAO for standard tasks leads to cleaner, more readable, and more maintainable code.DAO vs. Model: A Practical ComparisonImagine you need to fetch all active listings for a specific user (ID 123).The DAO approach (more verbose):$dao = new DAO();
$dao->select();
$dao->from(DB_TABLE_PREFIX . 't_item');
$dao->where('fk_i_user_id', 123);
$dao->where('b_active', 1);
$dao->where('b_enabled', 1);
$result = $dao->get();
$items = $result->result();
 The Model approach (cleaner and more abstract):// The Item model has a built-in method for this exact task
$items = Item::newInstance()->findByUserID(123);
The Model approach is not only shorter but also less prone to error, as the complex query logic is handled internally by the Osclass core. You should always check the relevant Model file in oc-includes/osclass/model/ to see if a method already exists for your needs before writing a custom DAO query.Powerful Model Methods You Should Use:
Item::newInstance()->findLatest($count): Gets the $count most recently published items.
Item::newInstance()->findPopular($count): Gets the $count most viewed items.
User::newInstance()->findByEmail($email): Finds a user by their email address.
Category::newInstance()->findSubcategories($categoryId): Gets all direct subcategories of a given category ID.
Alerts::newInstance()->findSubscribers($itemId): Finds all users who have an active search alert that matches a newly published item.
B. Advanced Security Practices: A Developer's Responsibility Writing secure code is non-negotiable. While the Osclass core provides a secure foundation, a poorly written plugin can expose a website to significant risk. Go beyond the basics of CSRF nonces with these critical practices.1. Input Validation vs. Sanitization These two concepts are often confused. Sanitization (like using Params::getParam()) cleans data. Validation confirms data is what you expect it to be. You must do both.Example: Validating a user-submitted age field.// Get the sanitized input
$age = Params::getParam('user_age');

// Now, VALIDATE it
if (!is_numeric($age) || $age < 18 || $age > 120) {
    // The data is not a valid age, even if it's sanitized.
    // Return an error and do not process it.
    osc_add_flash_error_message('Please enter a valid age between 18 and 120.');
    // Redirect back to the form...
} else {
    // Validation passed, proceed to save the integer value.
    User::newInstance()->update(array('i_age' => (int)$age), array('pk_i_id' => osc_logged_user_id()));
} 2. Output Escaping: Preventing Cross-Site Scripting (XSS) Never trust data, even data from your own database. It could have been compromised or entered maliciously. You must "escape" all data just before you echo it to the browser to prevent malicious scripts from running.
osc_esc_html($string): Use this for echoing content inside a standard HTML element (e.g., <div>, <p>, <strong>). This is the most common escaping function.
osc_esc_js($string): Use this when echoing a string inside a JavaScript block (e.g., in an alert() or when defining a variable).
esc_attr($string): A WordPress-compatible function for echoing content inside an HTML attribute (e.g., title="..." or placeholder="...").

 <?php $listingTitle = osc_item_title(); // Gets the raw title ?>

<!-- CORRECT: Escaped for HTML context -->
<h2 title="<?php echo esc_attr($listingTitle); ?>"><?php echo osc_esc_html($listingTitle); ?></h2>

<script>
    // CORRECT: Escaped for JavaScript context
    var itemTitle = '<?php echo osc_esc_js($listingTitle); ?>';
    console.log('The title of this item is: ' + itemTitle);
</script>

3.  Checking User Permissions and Capabilities Never assume a user has the right to perform an action. Always check their permissions, especially for admin-side functionality.
    osc_is_admin_user_logged_in(): Returns true if the current user is a logged-in administrator.
    osc_is_web_user_logged_in(): Returns true if the current user is a logged-in front-end user.
    osc_item_user_id(): Returns the ID of the user who published the current item. You can compare this to osc_logged_user_id() to see if the current user is the owner of the listing.
    C. Automating Tasks with the Osclass CLI (cron.php) Many marketplaces require automated, recurring tasks, such as deactivating expired listings, sending out daily email digests, or cleaning up temporary files. Osclass includes a Command Line Interface (CLI) entry point, cron.php, which can be triggered by a server cron job to run these tasks.Step 1: Create Your Custom Cron Function You can create a function that performs your desired task and hook it into one of Osclass's built-in schedules: cron_hourly, cron_daily, or cron_weekly.// In your plugin's main file

// This function will contain the logic for our automated task
function my_plugin_deactivate_old_listings() {
$conn = DBConnectionClass::newInstance();
$dao = $conn->getDao();

    // Deactivate all items older than 90 days that have not been renewed
    $dao->update(
        Item::newInstance()->getTableName(),
        array('b_active' => 0),
        "dt_pub_date < DATE_SUB(NOW(), INTERVAL 90 DAY)"
    );

    // You could also log that the cron ran successfully
    error_log('My Plugin: Daily deactivation cron ran successfully.');

}

// Attach our function to the built-in daily cron hook
osc_add_hook('cron_daily', 'my_plugin_deactivate_old_listings');
Step 2: Setting up the Server Cron Job To run all daily cron hooks, you would set up a cron job on your server (via cPanel or the command line) to execute the following command once per day:php /path/to/your/osclass/cron.php --cron-type=dailyThis command will trigger the cron_daily hook in Osclass, which in turn will execute your my_plugin_deactivate_old_listings function and any other functions attached to that hook.D. Creating Front-end Widgets for Your Theme Plugins can provide their own front-end widgets that can be placed in a theme's sidebar or footer. This allows your plugin's functionality to be visually integrated into any theme.Step 1: Register the Widget File You must include your widget file and then register it using osc_register_widget().// In your plugin's main file
function my_plugin_register_frontend_widgets() {
require_once osc_plugin_path(**FILE**) . 'widgets/TopViewedWidget.php';
osc_register_widget('TopViewedWidget');
}
// A good place to call this is in the main plugin file or hooked into 'init'.
osc_add_hook('init', 'my_plugin_register_frontend_widgets');
Step 2: Create the Widget Class The front-end widget class must extend the Widget base class and contain a widget() function. This function is responsible for rendering the widget's HTML.<?php
class TopViewedWidget extends Widget {

    public function __construct() {
        $this->setAsciiName('top_viewed_widget');
        $this->setName(__('Top 5 Most Viewed Items', 'my_plugin_domain'));
        $this->setDescription(__('Displays a list of the 5 most popular listings on the site.', 'my_plugin_domain'));
    }

    /**
     * The main function that renders the widget's HTML content.
     * @param array $params Contains any options set by the user in the admin panel.
     */
    public function widget($params = array()) {
        // Use the Item model to get the 5 most popular items
        $popularItems = Item::newInstance()->findPopular(5);

        echo '<div class="widget widget-top-viewed">';
        echo '<h3>' . $this->getName() . '</h3>';

        if (count($popularItems) > 0) {
            echo '<ul>';
            foreach ($popularItems as $item) {
                // To use item helpers here, we need to manually set the view context
                View::newInstance()->_exportVariableToView('item', $item);

                echo '<li>';
                echo '<a href="' . osc_item_url() . '">' . osc_item_title() . '</a>';
                echo ' <span>(' . osc_item_views() . ' views)</span>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>' . __('No listings have been viewed yet.', 'my_plugin_domain') . '</p>';
        }

        echo '</div>';
    }

}
?>
Once registered, administrators can go to Appearance > Widgets, drag the "Top 5 Most Viewed Items" widget into a sidebar, and it will appear on the front end of their site.

Please review the Osclass Developer Guide ([https://docs.osclass-classifieds.com/developer-guide](https://docs.osclass-classifieds.com/developer-guide)), Programming Standards ([https://docs.osclass-classifieds.com/programming-standards-i75](https://docs.osclass-classifieds.com/programming-standards-i75)), Child Theme Guidelines ([https://docs.osclass-classifieds.com/child-themes-i79](https://docs.osclass-classifieds.com/child-themes-i79)), and the Hooks, Themes, and Plugins customization guide ([https://osclass-classifieds.com/article/developer-guide-customizing-osclass-hooks-themes-plugins](https://osclass-classifieds.com/article/developer-guide-customizing-osclass-hooks-themes-plugins)), and apply the standard naming conventions and coding styles from the Programming Standards document to all files, classes, functions, variables, and assets to ensure consistency, readability, and maintainability throughout the project.

Please review the Clean Coder resources ([https://blog.cleancoder.com](https://blog.cleancoder.com)), the Clean Architecture article ([https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)), and the official Osclass documentation, including the Developer Guide ([https://docs.osclass-classifieds.com/developer-guide](https://docs.osclass-classifieds.com/developer-guide)), Programming Standards ([https://docs.osclass-classifieds.com/programming-standards-i75](https://docs.osclass-classifieds.com/programming-standards-i75)), Child Theme Guidelines ([https://docs.osclass-classifieds.com/child-themes-i79](https://docs.osclass-classifieds.com/child-themes-i79), [https://osclasspoint.com/blog/osclass-create-child-theme-b21](https://osclasspoint.com/blog/osclass-create-child-theme-b21)), and the customization guide for Hooks, Themes, and Plugins ([https://osclass-classifieds.com/article/developer-guide-customizing-osclass-hooks-themes-plugins](https://osclass-classifieds.com/article/developer-guide-customizing-osclass-hooks-themes-plugins)). Using these references, create a clean, blank child theme for the Starter Osclass theme ([https://osclasspoint.com/osclass-themes/general/starter-osclass-theme_i86](https://osclasspoint.com/osclass-themes/general/starter-osclass-theme_i86)) that strictly follows Osclass best practices. The child theme must include only the minimum required structure to safely extend the parent Starter theme, without modifying any parent or core files. It should remain fully update-safe and provide a lightweight foundation that supports template and style overrides, hook-based extensions, and placeholders for future plugin or widget integrations. The project should be organized into clear, single-responsibility modules aligned with SOLID, DRY, KISS, and clean-code principles to ensure scalability, readability, and long-term maintainability. Maintain a consistent folder hierarchy for templates, assets, translations, and custom logic; ensure that all CSS and JavaScript are fully scoped to the child theme; and prioritize hooks instead of full-file overrides to minimize redundancy and optimize separation of concerns. The final deliverable must be a streamlined, modular, developer-friendly child theme that serves as an extensible foundation for future enhancements, using the standard naming conventions and coding styles defined in the Programming Standards document to guarantee consistency, clarity, and maintainability across all files, classes, functions, variables, and assets.
