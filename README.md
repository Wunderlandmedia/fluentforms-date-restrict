# Global Date Blocker for Fluent Forms

Global Date Blocker enhances your Fluent Forms by allowing administrators to create multiple calendar restriction configurations, each targeting different forms with specific disabled dates and dynamic date range selection functionality.

## Background & Motivation

This plugin was born from a real client need: **managing multiple booking restrictions across different forms**. Initially designed for single global restrictions, version 2.0 introduces a powerful Custom Post Type (CPT) system that allows you to create unlimited calendar restriction configurations.

The client needed a way to easily manage:
- Different room/property booking restrictions
- Separate event calendar restrictions  
- Multiple form configurations with unique disabled dates
- Scalable management without modifying each form individually

Rather than using a single global configuration, this plugin now provides a flexible multi-configuration solution that works seamlessly with Fluent Forms.

## Overview

Managing availability for multiple booking forms, appointments, or any date-sensitive forms can be complex. This plugin simplifies the process by providing:

1. **Multiple Calendar Restrictions**: Create unlimited calendar restriction configurations using WordPress Custom Post Types
2. **Per-Form Configuration**: Each restriction targets a specific Fluent Form with its own settings
3. **Individual Disabled Dates**: Each configuration has its own set of disabled dates (holidays, booked-out days, maintenance days)
4. **Dynamic Date Range Logic**: Intelligent check-in/check-out functionality where selecting dates in one field automatically restricts the other
5. **Scalable Architecture**: Add as many restriction sets as needed for different purposes (rooms, equipment, events, etc.)

This plugin is designed to work seamlessly with Fluent Forms. It specifically looks for Fluent Forms wrapped by BricksExtras (`fluentform_wrapper_{form_id}`) first, and then falls back to the standard Fluent Forms selector (`fluentform_{form_id}`) if the wrapper isn't found.

## Key Features

*   **Custom Post Type Management**: Create and manage multiple "Calendar Restriction" configurations through a user-friendly WordPress interface
*   **Visual Admin Calendar**: Each restriction has its own Flatpickr calendar for selecting disabled dates
*   **Flexible Form Targeting**: Each restriction can target any Fluent Form by ID with custom field name configuration
*   **Dynamic Check-in/Check-out Logic**:
    *   Check-out date automatically restricted to be after the selected Check-in date
    *   Check-in date automatically restricted to be before the selected Check-out date
    *   The selectable range for the Check-out date is dynamically limited by the next disabled date after the Check-in date
*   **Multi-Form Support**: Multiple forms on the same page work independently with their own restrictions
*   **BricksExtras Compatibility**: Prioritizes selectors for Fluent Forms integrated via BricksExtras
*   **Clear Date Buttons**: Adds "X" buttons to date fields for easy clearing of selected dates
*   **Performance Optimized**: Frontend JavaScript only loads when valid configurations exist
*   **Developer-Friendly**: Built with WordPress best practices, clean code, and structured approach
*   **Scalable**: Perfect for hotels, rental companies, event venues, or any business with multiple booking forms
*   **Open Source**: MIT Licensed, ready for you to fork and customize!

## Screenshots

1.  **Calendar Restrictions Management**: WordPress admin showing the list of calendar restrictions.
    
    ![Calendar Restrictions List](assets/images/admin-cpt-list.jpg)

2.  **Creating a New Restriction**: Add new calendar restriction with form targeting and disabled dates.
    
    ![New Calendar Restriction](assets/images/admin-cpt-edit.jpg)

3.  **Frontend Multi-Form Support**: Multiple Fluent Forms with different restrictions working independently.
    
    ![Frontend Multi-Form](assets/images/frontend-multi-form.jpg)

## Requirements

*   WordPress 5.0 or higher
*   PHP 7.4 or higher (PHP 8.0 recommended)
*   Fluent Forms (Pro version recommended for full compatibility, tested with 6.0.3+)
*   jQuery (comes with WordPress)

## Installation

1.  **Download**: Download the plugin `.zip` file from the [GitHub repository releases page](https://github.com/wunderlandmedia/global-date-blocker/releases) or clone the repository.
2.  **Upload**:
    *   Via WordPress Admin: Go to `Plugins` > `Add New` > `Upload Plugin`. Choose the downloaded `.zip` file and click `Install Now`.
    *   Via FTP: Extract the `.zip` file and upload the `booking-restrict` folder to your WordPress `wp-content/plugins/` directory.
3.  **Activate**: Go to `Plugins` in your WordPress admin and activate "Global Date Blocker".
4.  **Configure**: Navigate to `Calendar Restrictions` in your WordPress admin to create your first restriction.

## Configuration

The new CPT-based system allows you to create multiple calendar restriction configurations, each targeting different Fluent Forms.

### 1. Creating Calendar Restrictions

Navigate to **WordPress Admin > Calendar Restrictions**.

#### Adding a New Restriction:
1. Click **"Add New"** to create a new calendar restriction
2. **Title**: Give your restriction a descriptive name (e.g., "Room A Bookings", "Event Hall Restrictions", "Equipment Rentals")
3. **Configure Restriction Settings**:
   - **Target Fluent Form ID**: Enter the numerical ID of the Fluent Form this restriction should affect
   - **Check-in Field Name**: Enter the `name` attribute of your check-in date field (e.g., `checkin`, `start_date`)
   - **Check-out Field Name**: Enter the `name` attribute of your check-out date field (e.g., `checkout`, `end_date`)
4. **Select Disabled Dates**: Use the inline calendar to click on dates you want to disable. Click again to deselect.
5. **Publish**: Click "Publish" to activate the restriction

### 2. Fluent Forms Field Setup

For each Fluent Form you want to target:

1.  Go to **Fluent Forms Pro** and edit the target form
2.  Ensure you have two "Date / Time" input fields:
    *   One for the check-in date
    *   One for the check-out date
3.  For each date field:
    *   Open the field's "Input Customization" settings
    *   Set the **Name Attribute** to exactly match what you entered in the Calendar Restriction settings
4.  Save your Fluent Form

### 3. Multiple Restrictions Example

You can create multiple calendar restrictions for different purposes:

- **"Hotel Room A"** → Targets Fluent Form ID `3`, fields `room_a_checkin`/`room_a_checkout`
- **"Conference Hall"** → Targets Fluent Form ID `5`, fields `event_start`/`event_end`  
- **"Equipment Rental"** → Targets Fluent Form ID `7`, fields `rental_start`/`rental_end`

Each restriction operates independently with its own disabled dates and logic.

## How It Works

### Admin Side (CPT System)

*   Administrators create "Calendar Restriction" Custom Post Types through the WordPress admin
*   Each restriction contains:
    *   Target Fluent Form ID
    *   Check-in and check-out field names  
    *   Array of disabled dates (stored as post meta)
*   Admin interface uses Flatpickr for intuitive date selection
*   All data is stored using WordPress post meta fields for optimal performance

### Frontend Side (Multi-Configuration)

The core logic resides in `assets/js/gdb-frontend.js`:

1.  **Configuration Loading**: The plugin queries all published `gdb_restriction` posts and builds an array of configurations
2.  **Conditional Loading**: Frontend scripts only load if Fluent Forms is active and valid configurations exist
3.  **Multi-Form Detection**: The script processes each configuration and looks for its target form on the current page
4.  **Form Identification**:
    *   Attempts to find forms using BricksExtras selector: `.fluentform_wrapper_{formId}`
    *   Falls back to standard selector: `.fluentform_{formId}`
5.  **Independent Initialization**: Each form gets its own scoped Flatpickr instances and restriction logic
6.  **Date Picker Logic** (per form):
    *   Disables dates specified in that form's configuration
    *   Disables dates before "today"
    *   Implements check-in/check-out interdependency
    *   Manages clear buttons with unique IDs per form
7.  **Dynamic Restrictions**: 
    *   Check-in selection restricts check-out options
    *   Check-out selection restricts check-in options
    *   Range limitation based on disabled dates between check-in/check-out
8.  **Event Handling**: Responds to Fluent Forms events for dynamic form loading

### Multi-Form Page Support

Multiple forms on the same page work independently:
- Each form maintains its own picker instances
- Clear buttons are uniquely identified per form
- No conflicts between different restriction configurations
- Debug mode provides detailed logging for troubleshooting

## Migration from Version 1.x

**Automatic Migration**: Version 2.0 is a complete architectural change. The old global settings system has been replaced with the CPT system.

**What You Need to Do**:
1. After updating, go to **Calendar Restrictions** in WordPress admin
2. Create a new Calendar Restriction with your previous settings
3. The old global options will continue to exist but won't be used
4. Test your forms to ensure they work with the new restriction

## Future Development Ideas

**Current Capabilities**: This plugin now supports unlimited calendar restrictions, each targeting different Fluent Forms - perfect for complex booking scenarios.

**Potential Enhancements**:

*   **Advanced Scheduling**: Time-based restrictions and availability windows
*   **Recurring Date Rules**: Automated rules for weekends, holidays, maintenance schedules
*   **Integration APIs**: Connect with external booking systems
*   **Reporting Dashboard**: Analytics on booking patterns and restrictions
*   **User Role Restrictions**: Different availability based on user permissions
*   **Seasonal Pricing**: Variable restrictions based on seasons or demand
*   **Multi-Language Support**: Localized date formats and terminology

Since this is MIT licensed, you're free to fork and extend the functionality to meet your specific needs!

## Contributing

This is an open-source project under the MIT License. Contributions are welcome!

1.  **Fork** the repository on GitHub
2.  **Create a new branch** for your feature or bug fix
3.  **Make your changes** and commit them with clear, descriptive messages
4.  **Push** your changes to your fork
5.  **Submit a Pull Request** to the main repository

Please ensure your code adheres to WordPress coding standards.

Since this project uses the MIT License, you're also free to fork it and create your own version without contributing back - though contributions are always appreciated!

## License

This plugin is licensed under the **MIT License**.
See the [LICENSE](LICENSE) file for more details.

## Support

If you encounter any issues or have questions, please use the [GitHub Issues tracker](https://github.com/wunderlandmedia/global-date-blocker/issues).

For detailed installation instructions, see [INSTALLATION.md](INSTALLATION.md).