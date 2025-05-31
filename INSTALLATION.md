# Installation Guide - Global Date Blocker

Quick installation and setup guide for the Global Date Blocker plugin for Fluent Forms.

## Prerequisites

- WordPress 5.0+
- PHP 7.4+ (8.0+ recommended)
- Fluent Forms plugin (latest version)

## Installation

### Method 1: WordPress Admin Upload

1. Download the plugin `.zip` file
2. Go to `Plugins` > `Add New` > `Upload Plugin`
3. Upload the `.zip` file and click `Install Now`
4. Activate the plugin

### Method 2: FTP Upload

1. Extract the plugin files
2. Upload the `booking-restrict` folder to `/wp-content/plugins/`
3. Activate the plugin in WordPress admin

### Method 3: Git Clone (Developers)

```bash
cd /path/to/wordpress/wp-content/plugins/
git clone https://github.com/wunderlandmedia/global-date-blocker.git booking-restrict
```

## Configuration

### 1. Create a Calendar Restriction

1. Navigate to `Calendar Restrictions` in WordPress admin
2. Click `Add New`
3. Configure the settings:
   - **Title**: Descriptive name for the restriction
   - **Target Fluent Form ID**: The form ID number
   - **Check-in Field Name**: Name attribute of the check-in date field
   - **Check-out Field Name**: Name attribute of the check-out date field
4. Set disabled dates by clicking on the calendar
5. Publish the restriction

### 2. Configure Your Fluent Form

1. Edit your target form in Fluent Forms
2. Add two Date/Time fields for check-in and check-out
3. Set the **Name Attribute** for each field to match your restriction settings
4. Recommended: Use `Y-m-d` date format for consistency
5. Save the form

### Finding Your Form ID

- Go to `Fluent Forms` > `All Forms`
- Note the ID number in the first column
- Or check the form edit URL for the ID parameter

## Examples

### Hotel Room Booking
```
Title: "Hotel Room A"
Form ID: 3
Check-in Field: "room_checkin"
Check-out Field: "room_checkout"
```

### Event Venue
```
Title: "Conference Hall"
Form ID: 5
Check-in Field: "event_start" 
Check-out Field: "event_end"
```

### Equipment Rental
```
Title: "Camera Equipment"
Form ID: 7
Check-in Field: "rental_start"
Check-out Field: "rental_end"
```

## Multiple Restrictions

You can create unlimited calendar restrictions for different forms or purposes. Each restriction operates independently.

## Troubleshooting

- Ensure Fluent Forms is active and properly configured
- Verify form field names match exactly (case-sensitive)
- Check browser console for JavaScript errors
- Confirm the form ID is correct

For additional support, check the plugin documentation or contact support. 