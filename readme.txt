=== Global Date Blocker ===
Contributors: wunderlandmedia
Donate link: https://wunderlandmedia.com/
Tags: fluent forms, date picker, booking, calendar, restrictions, availability, custom post type
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 8.0
Stable tag: 2.0.0
License: MIT
License URI: https://opensource.org/licenses/MIT

Create multiple calendar restriction configurations for Fluent Forms. Each restriction can target different forms with unique disabled dates and intelligent date range logic.

== Description ==

Global Date Blocker enhances your Fluent Forms by allowing administrators to create unlimited calendar restriction configurations using WordPress Custom Post Types. Perfect for hotels, rental companies, event venues, or any business managing multiple booking forms.

**Key Features:**

* **Multiple Calendar Restrictions** - Create unlimited restriction configurations using WordPress Custom Post Types
* **Per-Form Configuration** - Each restriction targets a specific Fluent Form with its own settings  
* **Visual Date Management** - Intuitive Flatpickr calendar interface for selecting disabled dates
* **Dynamic Date Logic** - Intelligent check-in/check-out functionality with automatic restrictions
* **Multi-Form Support** - Multiple forms on the same page work independently
* **Performance Optimized** - Scripts only load when valid configurations exist
* **BricksExtras Compatible** - Works seamlessly with BricksExtras Fluent Forms integration
* **Developer Friendly** - Built with WordPress best practices and clean code

**Perfect For:**

* Hotels and accommodations with multiple room types
* Event venues with different booking forms
* Equipment rental companies  
* Service providers with various booking categories
* Any business requiring multiple form-specific date restrictions

**How It Works:**

1. Create "Calendar Restriction" posts in WordPress admin
2. Configure each restriction with target form ID and field names
3. Select disabled dates using the visual calendar interface
4. Publish restrictions to activate them on your forms
5. Each form gets its own independent date restrictions

**Version 2.0 Major Update:**

This version introduces a complete architectural redesign from single global settings to a flexible Custom Post Type system. Create as many calendar restrictions as needed, each targeting different Fluent Forms with unique configurations.

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/booking-restrict/` directory, or install directly through WordPress admin
2. Activate the plugin through the 'Plugins' screen in WordPress admin
3. Navigate to 'Calendar Restrictions' in WordPress admin to create your first restriction
4. Configure your Fluent Forms with the appropriate field names
5. Test your forms to ensure restrictions are working correctly

== Frequently Asked Questions ==

= How many calendar restrictions can I create? =

Unlimited! The new CPT system allows you to create as many calendar restriction configurations as needed.

= Can I target multiple forms with different restrictions? =

Yes! Each calendar restriction can target a different Fluent Form with its own unique disabled dates and field configurations.

= Can multiple forms on the same page have different restrictions? =

Absolutely! The plugin is designed to handle multiple forms independently, each with their own restrictions.

= How do I find my Fluent Form ID? =

In your WordPress admin, go to Fluent Forms → All Forms. The ID is shown in the list, or you can find it in the form's edit URL.

= What field names should I use? =

Use the 'name' attribute of your date fields in Fluent Forms. You can set this in the field's "Input Customization" settings.

= Does this work with BricksExtras? =

Yes! The plugin automatically detects BricksExtras form wrappers and falls back to standard Fluent Forms selectors as needed.

= Is this compatible with Fluent Forms Pro? =

Yes, this plugin is designed to work with both free and Pro versions of Fluent Forms, though Pro is recommended for full functionality.

= Can I migrate from version 1.x? =

Version 2.0 is a complete rewrite. After updating, create new Calendar Restrictions with your previous settings. The old system is no longer used.

= How do I debug issues? =

Enable WP_DEBUG in your wp-config.php file. The plugin provides detailed console logging when debug mode is active.

== Screenshots ==

1. Calendar Restrictions management - WordPress admin showing list of restrictions
2. Creating a new restriction - Add new calendar restriction with configuration options  
3. Meta box interface - Restriction settings and disabled dates calendar
4. Frontend multi-form - Multiple forms working independently with different restrictions

== Changelog ==

= 2.0.0 =
* **MAJOR UPDATE:** Complete architectural redesign from global settings to Custom Post Type system
* NEW: Create unlimited calendar restriction configurations  
* NEW: Each restriction targets specific Fluent Forms independently
* NEW: Custom Post Type management interface with meta boxes
* NEW: Multi-form support on same page without conflicts
* NEW: Performance optimizations - scripts only load when needed
* NEW: Enhanced debugging capabilities
* CHANGED: Moved from wp_options to post_meta data storage
* CHANGED: Frontend JavaScript completely refactored for multi-configuration support
* CHANGED: Admin interface now uses WordPress CPT instead of settings page
* REMOVED: Old global settings system deprecated
* IMPROVED: Better error handling and validation
* IMPROVED: Code structure follows WordPress best practices

= 1.0.0 =
* Initial release with global date blocking functionality
* Single form configuration support
* Basic Flatpickr integration
* Check-in/check-out date logic

== Upgrade Notice ==

= 2.0.0 =
Major update! Complete rewrite from global settings to Custom Post Type system. After updating, you'll need to create new Calendar Restrictions to replace your old global settings. This version supports unlimited restrictions and multi-form configurations. 