# Global Date Blocker - Installation & Setup Guide

## Quick Start

### 1. Plugin Installation
1. Upload the `booking-restrict` folder to `/wp-content/plugins/`
2. Activate the plugin through the WordPress admin panel
3. Navigate to **Settings > Global Date Blocker**

### 2. Configuration
1. **Set Target Form:** Enter your Fluent Form ID in the "Target Form ID" field
2. **Configure Field Names:** 
   - Enter the name attribute of your check-in date field (e.g., "checkin", "arrival_date")
   - Enter the name attribute of your check-out date field (e.g., "checkout", "departure_date")
3. **Select Disabled Dates:** Click on dates in the calendar to disable them
4. Click **Save Settings**

### 3. Fluent Form Setup
1. Create or edit your Fluent Form
2. Add two Date/Time fields with the names you configured in step 2
3. Save your form

## Detailed Configuration

### Admin Settings Configuration

1. **Access Settings:**
   - Go to WordPress Admin → Settings → Global Date Blocker

2. **Configure Form Targeting:**
   - **Target Form ID:** Enter the ID of your Fluent Form
   - **Check-in Field Name:** Enter the name attribute of your check-in date field
   - **Check-out Field Name:** Enter the name attribute of your check-out date field

3. **Select Disabled Dates:**
   - Click on any date in the calendar to disable it
   - Click again to re-enable a disabled date
   - Multiple dates can be selected

4. **Save Changes:**
   - Click "Save Settings" to apply all changes
   - A success message will confirm the save

### Form Field Setup in Fluent Forms

1. **Edit your Fluent Form**
2. **Add Date/Time Fields:**
   - Drag a "Date/Time" field to your form
   - In the field settings, set the **Name** to match your configured check-in field name
   - Add another "Date/Time" field
   - Set its **Name** to match your configured check-out field name

3. **Field Settings (Optional):**
   - Set appropriate labels (e.g., "Check-in Date", "Check-out Date")
   - Configure any additional validation rules
   - Set placeholder text if desired

### Frontend Behavior

**Date Range Logic:**
- When a check-in date is selected, the check-out picker only allows dates after the check-in
- When a check-out date is selected, the check-in picker only allows dates before the check-out
- Invalid date combinations are automatically cleared

**Disabled Dates:**
- Globally disabled dates appear grayed out with a striped pattern
- These dates cannot be selected in either picker
- Disabled dates are applied in addition to the date range logic

## Troubleshooting

### Plugin Not Working?

1. **Check Requirements:**
   - WordPress 5.0+
   - PHP 7.4+
   - Fluent Forms Pro 6.0.3+

2. **Verify Configuration:**
   - Confirm form ID matches your actual form
   - Check field names match exactly (case-sensitive)
   - Ensure fields are Date/Time type in Fluent Forms

3. **Debug Mode:**
   - Open browser console (F12)
   - Look for "GDB:" prefixed messages
   - Check for JavaScript errors

4. **Common Issues:**
   - **Fields not found**: Check field names and form ID in settings
   - **Dates not disabled**: Verify dates are saved in admin
   - **No date range logic**: Ensure both fields exist and are properly named

### Browser Console Debugging

The plugin provides debug information in the browser console when WP_DEBUG is enabled:
```javascript
// Check plugin configuration
console.log(window.gdbDebug.config);

// Check disabled dates
console.log(window.gdbDebug.disabledDates);

// Reinitialize if needed
window.gdbDebug.reinitialize();
```

## Support

For additional support:
1. Check the browser console for error messages
2. Verify all requirements are met
3. Test with a simple form setup first
4. Contact the developer with specific error details

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