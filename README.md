# Global Date Blocker for Fluent Forms

A WordPress plugin that allows administrators to create multiple calendar restrictions for Fluent Forms with disabled dates and dynamic date range selection.

## Overview

Global Date Blocker enables you to create unlimited calendar restriction configurations for different Fluent Forms. Each restriction can have its own disabled dates and field targeting, making it perfect for booking systems, event management, and appointment scheduling.

![Admin View](/assets/images/admin-view.jpg)

## Key Features

- **Multiple Calendar Restrictions**: Create unlimited configurations using WordPress Custom Post Types
- **Per-Form Configuration**: Target specific Fluent Forms with individual settings
- **Visual Date Selection**: Admin calendar interface for selecting disabled dates
- **Dynamic Date Logic**: Intelligent check-in/check-out restrictions
- **Multi-Form Support**: Independent operation for multiple forms on the same page
- **Clear Date Buttons**: User-friendly date clearing functionality
- **Performance Optimized**: Scripts load only when needed

## Requirements

- WordPress 5.0+
- PHP 7.4+ (8.0+ recommended)
- Fluent Forms plugin

## Installation

1. Download the plugin `.zip` file
2. Upload via `Plugins` > `Add New` > `Upload Plugin`
3. Activate the plugin
4. Navigate to `Calendar Restrictions` to create your first restriction

## Quick Setup

### 1. Create a Calendar Restriction

1. Go to `Calendar Restrictions` > `Add New`
2. Set a descriptive title
3. Configure:
   - **Target Fluent Form ID**: The form ID number
   - **Check-in Field Name**: Name attribute of check-in field
   - **Check-out Field Name**: Name attribute of check-out field
4. Select disabled dates on the calendar
5. Publish the restriction

### 2. Configure Your Fluent Form

1. Edit your target form in Fluent Forms
2. Add two Date/Time fields for check-in and check-out
3. Set the **Name Attribute** for each field to match your restriction settings
4. Save the form

![Backend and Frontend Comparison](/assets/images/backend-frontend.jpg)

## Example Configurations

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

## How It Works

The plugin uses WordPress Custom Post Types to store calendar restrictions. Each restriction contains:
- Target form configuration
- Field name mappings
- Array of disabled dates

Frontend JavaScript applies restrictions dynamically:
- Disables specified dates
- Implements check-in/check-out logic
- Manages date interdependencies
- Handles multiple forms independently

## Migration from Version 1.x

Version 2.0 replaces the global settings system with Custom Post Types:

1. Create new Calendar Restrictions with your previous settings
2. Test functionality
3. Old settings remain in database but aren't used

## Contributing

This project is open source under the MIT License. Contributions welcome!

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a Pull Request

## License

MIT License - see LICENSE file for details.

## Support

For issues and questions:
- GitHub Issues: [Report bugs and feature requests](https://github.com/wunderlandmedia/global-date-blocker/issues)
- Documentation: Check INSTALLATION.md for detailed setup instructions