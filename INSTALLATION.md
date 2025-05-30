# Installation Guide - Global Date Blocker

This guide will walk you through installing and configuring the Global Date Blocker plugin for Fluent Forms version 2.0.

## Prerequisites

Before installing the plugin, ensure your environment meets these requirements:

- **WordPress**: 5.0 or higher
- **PHP**: 7.4 or higher (8.0+ recommended)
- **Fluent Forms**: Latest version (Pro recommended for full compatibility)
- **jQuery**: Included with WordPress (no action needed)

## Installation Methods

### Method 1: WordPress Admin Upload (Recommended)

1. **Download the Plugin**
   - Download the latest `.zip` file from the [GitHub Releases page](https://github.com/wunderlandmedia/global-date-blocker/releases)
   - Or download directly from your WordPress.org account if purchased

2. **Upload via WordPress Admin**
   - Log into your WordPress admin dashboard
   - Navigate to `Plugins` > `Add New`
   - Click `Upload Plugin`
   - Choose the downloaded `.zip` file
   - Click `Install Now`

3. **Activate the Plugin**
   - After installation completes, click `Activate Plugin`
   - The plugin is now active and ready to configure

### Method 2: FTP Upload

1. **Extract Plugin Files**
   - Extract the downloaded `.zip` file to your computer
   - You should see a folder named `booking-restrict`

2. **Upload via FTP**
   - Connect to your website via FTP client
   - Navigate to `/wp-content/plugins/`
   - Upload the entire `booking-restrict` folder

3. **Activate in WordPress**
   - Log into your WordPress admin
   - Go to `Plugins` > `Installed Plugins`
   - Find "Global Date Blocker" and click `Activate`

### Method 3: Git Clone (Developers)

```bash
cd /path/to/wordpress/wp-content/plugins/
git clone https://github.com/wunderlandmedia/global-date-blocker.git booking-restrict
```

Then activate the plugin through WordPress admin.

## Post-Installation Setup

### Step 1: Verify Installation

After activation, you should see:
- A new menu item **"Calendar Restrictions"** in your WordPress admin sidebar
- The menu item has a calendar icon (📅)

If you don't see this, try:
1. Refreshing your browser
2. Checking that Fluent Forms is installed and active
3. Verifying no PHP errors in your error logs

### Step 2: Create Your First Calendar Restriction

1. **Navigate to Calendar Restrictions**
   - In WordPress admin, click `Calendar Restrictions`
   - You'll see an empty list (this is normal for first-time setup)

2. **Add New Restriction**
   - Click `Add New` at the top of the page
   - You'll be taken to the restriction editor

3. **Configure Basic Settings**
   - **Title**: Enter a descriptive name (e.g., "Hotel Room A Bookings")
   - **Restriction Settings Meta Box**:
     - **Target Fluent Form ID**: Enter the numerical ID of your Fluent Form
     - **Check-in Field Name**: Enter the `name` attribute of your check-in date field
     - **Check-out Field Name**: Enter the `name` attribute of your check-out date field

4. **Set Disabled Dates**
   - In the **Disabled Dates** meta box, click on calendar dates to disable them
   - Click again to re-enable dates
   - Selected dates will be highlighted

5. **Publish the Restriction**
   - Click `Publish` to activate the restriction
   - Your calendar restriction is now live!

## Configuration Examples

### Example 1: Hotel Room Booking

**Scenario**: Hotel with room booking form

```
Title: "Hotel Room A - Standard"
Form ID: 3
Check-in Field: "room_checkin"
Check-out Field: "room_checkout"
Disabled Dates: [Maintenance days, fully booked dates]
```

### Example 2: Event Venue Booking

**Scenario**: Conference hall with event booking

```
Title: "Main Conference Hall"
Form ID: 5  
Check-in Field: "event_start"
Check-out Field: "event_end"
Disabled Dates: [Holidays, scheduled events]
```

### Example 3: Equipment Rental

**Scenario**: Equipment rental company

```
Title: "Camera Equipment Rentals"
Form ID: 7
Check-in Field: "rental_start" 
Check-out Field: "rental_end"
Disabled Dates: [Equipment maintenance, existing rentals]
```

## Fluent Forms Setup

### Finding Your Form ID

1. Go to `Fluent Forms` > `All Forms` in WordPress admin
2. Find your target form in the list
3. Note the ID number in the first column
4. Alternatively, edit the form and check the URL - the ID is in the address

### Setting Up Date Fields

For each Fluent Form you want to target:

1. **Edit Your Form**
   - Go to `Fluent Forms` > `All Forms`
   - Click `Edit` on your target form

2. **Add Date Fields** (if not already present)
   - Add two "Date/Time" fields from the form builder
   - Position them where you want check-in and check-out dates

3. **Configure Field Names**
   - Click on the first date field
   - Go to `Input Customization` tab
   - Set the **Name Attribute** to match your restriction settings (e.g., `checkin`)
   - Repeat for the second field with the check-out name (e.g., `checkout`)

4. **Field Settings Recommendations**
   - **Date Format**: Use `Y-m-d` for consistency
   - **Enable Time**: Only if you need time selection
   - **Required**: Set as required for booking forms

5. **Save Your Form**
   - Click `Save Form` to apply changes

## Multi-Form Setup

### Managing Multiple Restrictions

You can create unlimited calendar restrictions for different purposes:

1. **Different Room Types**
   ```
   "Room A Bookings" → Form ID 3, fields: room_a_checkin/room_a_checkout
   "Room B Bookings" → Form ID 4, fields: room_b_checkin/room_b_checkout
   "Suite Bookings"  → Form ID 5, fields: suite_checkin/suite_checkout
   ```

2. **Different Services**
   ```
   "Equipment Rental"  → Form ID 6, fields: rental_start/rental_end
   "Event Booking"     → Form ID 7, fields: event_start/event_end
   "Consultation"      → Form ID 8, fields: consult_start/consult_end
   ```

3. **Seasonal Configurations**
   ```
   "Summer Bookings"   → Form ID 9, different disabled dates
   "Winter Bookings"   → Form ID 10, different disabled dates
   ```

### Multiple Forms on Same Page

The plugin automatically handles multiple forms on the same page:
- Each form operates independently
- No conflicts between different restrictions
- Clear buttons are form-specific
- Debug logging helps troubleshoot issues

## Troubleshooting

### Common Issues

**Calendar Restrictions menu not visible**
- Verify Fluent Forms is installed and activated
- Check for PHP errors in your error logs
- Deactivate and reactivate the plugin

**Frontend restrictions not working**
- Enable `WP_DEBUG` in `wp-config.php` for detailed logging
- Check browser console for JavaScript errors
- Verify Form ID and field names match exactly
- Ensure the restriction is published (not draft)

**Date picker not appearing**
- Check that Fluent Forms is properly loaded on the page
- Verify field names match between restriction and form
- Check for JavaScript conflicts with other plugins

**Multiple forms interfering**
- Each restriction should have unique Form IDs
- Field names can be the same across different forms
- Check console logs for configuration details

### Debug Mode

Enable debug mode for detailed logging:

1. **Enable WordPress Debug**
   ```php
   // Add to wp-config.php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   ```

2. **Check Browser Console**
   - Open browser Developer Tools (F12)
   - Check Console tab for GDB messages
   - Look for configuration and error details

3. **Debug Information Available**
   - Number of configurations loaded
   - Form detection results
   - Field matching results
   - Restriction application status

### Performance Considerations

**Optimizations Built-in**
- Scripts only load when configurations exist
- Efficient CPT queries with meta query filtering
- Form-specific loading prevents unnecessary processing
- Minimal DOM manipulation

**Best Practices**
- Limit disabled dates to necessary dates only
- Use descriptive restriction titles for easy management
- Regularly review and clean up unused restrictions
- Test changes on staging environment first

## Migration from Version 1.x

### What Changed in Version 2.0

- **Architecture**: Complete rewrite from global settings to Custom Post Types
- **Capability**: Support for unlimited restrictions vs. single global setting
- **Storage**: Moved from `wp_options` to `post_meta` storage
- **Admin Interface**: New CPT interface instead of settings page

### Migration Steps

1. **Note Your Current Settings** (before updating)
   - Form ID
   - Check-in field name
   - Check-out field name  
   - List of disabled dates

2. **Update the Plugin**
   - Follow normal update procedures
   - Old settings remain in database but aren't used

3. **Create New Restriction**
   - Go to `Calendar Restrictions` > `Add New`
   - Enter your previous settings
   - Select your previous disabled dates
   - Publish the restriction

4. **Test Functionality**
   - Verify your form works as expected
   - Check that all disabled dates are properly applied
   - Test check-in/check-out logic

5. **Clean Up** (optional)
   - Old options remain in database
   - No automatic cleanup to ensure data safety
   - Contact support if you need assistance removing old data

## Support

If you encounter issues during installation or setup:

1. **Check Documentation**
   - Review this installation guide
   - Check the main [README.md](README.md) file
   - Review the [CHANGELOG.md](CHANGELOG.md) for recent changes

2. **Enable Debug Mode**
   - Enable WordPress debug logging
   - Check browser console for detailed error messages

3. **Contact Support**
   - Create an issue on [GitHub Issues](https://github.com/wunderlandmedia/global-date-blocker/issues)
   - Include your WordPress version, PHP version, and any error messages
   - Describe your setup and what you've tried

4. **Community Support**
   - Check existing GitHub issues for similar problems
   - WordPress.org support forums
   - Developer community discussions

## Next Steps

After successful installation:

1. **Test Your Setup**
   - Create a test restriction
   - Verify frontend functionality
   - Test with multiple forms if applicable

2. **Plan Your Restrictions**
   - Identify all forms that need restrictions
   - Plan your disabled date strategy
   - Consider seasonal or recurring restrictions

3. **Monitor Performance**
   - Check page load times
   - Monitor for JavaScript errors
   - Verify mobile compatibility

4. **Regular Maintenance**
   - Update disabled dates as needed
   - Review and optimize restrictions periodically
   - Keep the plugin updated

Congratulations! Your Global Date Blocker plugin is now installed and ready to enhance your Fluent Forms with powerful date restriction capabilities.

## File Structure

```
booking-restrict/
├── booking-restrict.php      # Main plugin file
├── readme.txt               # WordPress plugin readme
├── INSTALLATION.md          # This file
├── assets/
│   ├── js/
│   │   ├── gdb-admin.js     # Admin interface JavaScript
│   │   └── gdb-frontend.js  # Frontend functionality
│   └── css/
│       └── gdb-frontend.css # Frontend styling
``` 