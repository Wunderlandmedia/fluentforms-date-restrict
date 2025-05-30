=== Global Date Blocker ===
Contributors: wunderlandmedia
Tags: fluent-forms, date-picker, booking, restrictions, calendar
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 8.0
Stable tag: 1.0.0
License: MIT
License URI: https://opensource.org/licenses/MIT

A WordPress plugin to manage globally disabled dates for Fluent Forms date pickers and enable date range selection functionality.

== Description ==

Global Date Blocker is a powerful WordPress plugin designed to enhance Fluent Forms with advanced date picker functionality. It provides two main features:

1. **Global Date Management**: Easily manage a list of dates that should be disabled across your Fluent Forms date pickers through an intuitive admin interface.

2. **Date Range Selection**: Enable check-in/check-out date range functionality where the check-out date must be after the check-in date, with automatic validation and date restrictions.

= Key Features =

* **Easy Admin Interface**: Use a visual calendar to select multiple dates that should be globally disabled
* **Configurable Form Targeting**: Set target form ID and field names through the admin interface
* **Automatic Integration**: Works seamlessly with Fluent Forms Pro without requiring code modifications
* **Date Range Logic**: Intelligent check-in/check-out date validation
* **Flexible Configuration**: Target any form and customize field names to match your setup
* **WordPress Standards**: Built following WordPress coding standards and best practices

= Perfect For =

* Hotel booking forms
* Event registration with blackout dates
* Appointment scheduling
* Rental booking systems
* Any form requiring date restrictions

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/booking-restrict` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to Settings > Global Date Blocker to configure your form targeting and disabled dates.
4. Set up your Fluent Form with date fields matching the names you configured.

== Configuration ==

= Initial Setup =

1. Go to Settings > Global Date Blocker in your WordPress admin
2. Configure your form targeting:
   - **Target Form ID**: Enter the ID of your Fluent Form
   - **Check-in Field Name**: Enter the name attribute of your check-in date field
   - **Check-out Field Name**: Enter the name attribute of your check-out date field
3. Use the calendar interface to select dates that should be disabled
4. Click "Save Settings"

= Setting Up Your Fluent Form =

1. Create or edit your Fluent Form
2. Add two Date/Time fields:
   - Set the first field's name attribute to match your configured check-in field name
   - Set the second field's name attribute to match your configured check-out field name
3. Save your form

= Managing Disabled Dates =

1. Go to Settings > Global Date Blocker in your WordPress admin
2. Use the calendar interface to select dates that should be disabled
3. Click "Save Settings"
4. The selected dates will automatically be disabled in your form's date pickers

== Frequently Asked Questions ==

= Does this work with Fluent Forms Lite? =

This plugin is designed for Fluent Forms Pro. Some features may not work with the Lite version.

= Can I target multiple forms? =

Currently, the plugin targets one form at a time. You can change the target form ID through the admin settings at any time.

= What field names can I use? =

You can use any field names for your check-in and check-out date fields. Just make sure they match what you configure in the admin settings.

= What date format is used? =

The plugin uses the YYYY-MM-DD format for date storage and processing.

= Can I disable weekends or recurring dates? =

Currently, the plugin supports selecting specific individual dates. Recurring date patterns may be added in future versions.

== Screenshots ==

1. Admin Settings Page - Configure target form, field names, and select globally disabled dates using the intuitive calendar interface
2. Frontend Form in Action - Fluent Form showing date pickers with disabled dates and intelligent date range logic

== Changelog ==

= 1.0.0 =
* Initial release
* Global date blocking functionality
* Check-in/check-out date range logic
* Admin interface with Flatpickr integration
* Fluent Forms Pro integration
* Configurable form targeting (form ID and field names)

== Upgrade Notice ==

= 1.0.0 =
Initial release of Global Date Blocker plugin.

== Technical Details ==

= Requirements =
* WordPress 5.0 or higher
* PHP 8.0 or higher
* Fluent Forms Pro 6.0.3 or higher
* jQuery (included with WordPress)

= Browser Support =
* Chrome (latest)
* Firefox (latest)
* Safari (latest)
* Edge (latest)

= Hooks and Filters =
The plugin provides several hooks for developers:
* `gdb_disabled_dates` - Filter the array of disabled dates
* `gdb_form_config` - Modify form targeting configuration

== Support ==

For support, please visit the plugin's support forum or contact the developer.

== Privacy ==

This plugin does not collect or store any personal data. It only manages date selections made by administrators and applies them to form date pickers. 