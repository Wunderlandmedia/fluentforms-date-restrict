# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2024-05-30

### 🚀 MAJOR UPDATE - Complete Architectural Redesign

Version 2.0.0 introduces a complete rewrite from single global settings to a flexible Custom Post Type (CPT) system, enabling unlimited calendar restriction configurations.

### Added
- **Custom Post Type System**: New `gdb_restriction` CPT for managing multiple calendar restrictions
- **Multi-Configuration Support**: Create unlimited calendar restrictions, each targeting different Fluent Forms
- **Enhanced Admin Interface**: 
  - WordPress native CPT management interface
  - Meta boxes for restriction settings and disabled dates
  - Flatpickr calendar integration in meta boxes
  - Form targeting configuration per restriction
- **Multi-Form Page Support**: Multiple forms on the same page work independently without conflicts
- **Performance Optimizations**: 
  - Scripts only load when valid configurations exist
  - Efficient CPT queries with meta query filtering
  - Form-specific loading prevents unnecessary processing
- **Enhanced Debug Capabilities**:
  - Detailed console logging when WP_DEBUG is enabled
  - Configuration loading status and form detection results
  - Debug object with utilities for troubleshooting
- **Unique Form Instance Management**: Each form gets its own scoped variables and picker instances
- **Independent Clear Buttons**: Form-specific clear buttons with unique IDs to prevent conflicts
- **Advanced Form Detection**: Improved selectors for BricksExtras and standard Fluent Forms integration

### Changed
- **BREAKING**: Complete architectural change from global settings to Custom Post Type system
- **Data Storage**: Moved from `wp_options` to `post_meta` storage for better scalability
- **Admin Interface**: Replaced Settings page with CPT management interface
- **Frontend JavaScript**: Complete refactor to handle multiple configurations simultaneously
- **Form Targeting**: Each restriction now independently targets specific forms
- **Date Management**: Per-restriction disabled dates instead of global disabled dates
- **Configuration Loading**: Dynamic query-based configuration loading instead of static options
- **Field Scoping**: Form-specific variable scoping prevents cross-form interference

### Removed
- **BREAKING**: Old global settings system completely deprecated
- **Settings Page**: Removed "Settings > Global Date Blocker" admin page
- **Global Options**: No longer uses `gdb_form_id`, `gdb_checkin_field`, `gdb_checkout_field`, `gdb_disabled_dates` options
- **Single Configuration Limitation**: No longer limited to one form configuration

### Improved
- **Scalability**: Support for unlimited calendar restrictions vs single global configuration
- **User Experience**: More intuitive WordPress-native admin interface
- **Performance**: More efficient resource loading and form detection
- **Maintainability**: Cleaner code structure following WordPress best practices
- **Security**: Enhanced nonce verification and capability checks for CPT operations
- **Error Handling**: Better validation and error reporting throughout the system

### Technical Details
- **Post Type**: `gdb_restriction` with proper labels, capabilities, and menu integration
- **Meta Fields**:
  - `_gdb_form_id`: Target Fluent Form ID (integer)
  - `_gdb_checkin_field_name`: Check-in field name (string)
  - `_gdb_checkout_field_name`: Check-out field name (string)
  - `_gdb_disabled_dates`: Array of disabled dates (YYYY-MM-DD format)
- **Frontend Configuration**: Dynamic array passed via `wp_localize_script` as `gdbFrontendConfigs`
- **Form Instance Management**: Scoped variables per form ID to prevent conflicts
- **Event Handling**: Enhanced Fluent Forms event integration for dynamic form loading

### Migration Notes
- **No Automatic Migration**: Version 2.0 is a complete rewrite requiring manual setup
- **Old Data Preserved**: Previous options remain in database but are not used
- **Setup Required**: After updating, create new Calendar Restrictions through the CPT interface
- **Testing Recommended**: Verify all forms work correctly after migration

### Developer Notes
- **WordPress Standards**: Full compliance with WordPress coding standards and best practices
- **Hook Changes**: Removed old admin hooks, added CPT-specific hooks
- **JavaScript Architecture**: Modular approach with form-specific function scoping
- **Debugging**: Enhanced debugging with detailed logging and utility functions
- **Extensibility**: CPT system provides foundation for future enhancements

## [1.0.0] - 2024-05-28

### Added
- Initial release of Global Date Blocker plugin
- Global date management system for Fluent Forms
- Admin interface with Flatpickr calendar integration
- Dynamic date range selection (check-in/check-out) functionality
- Configurable form targeting (form ID and field names)
- BricksExtras compatibility with fallback to standard Fluent Forms
- Clear date buttons for easy date field clearing
- WordPress coding standards compliance
- MIT License
- Comprehensive documentation (README.md, INSTALLATION.md)
- Internationalization support (text domain: global-date-blocker)
- Debug mode for WP_DEBUG environments

### Features
- **Visual Admin Calendar**: Easily select and manage globally disabled dates using an intuitive Flatpickr calendar
- **Configurable Form Targeting**: Specify which Fluent Form (by ID) and which date fields (by their `name` attribute) the plugin should interact with
- **Dynamic Check-in/Check-out Logic**: 
  - Check-out date automatically restricted to be after the selected Check-in date
  - Check-in date automatically restricted to be before the selected Check-out date
  - The selectable range for the Check-out date is dynamically limited by the next globally disabled date after the Check-in date
- **BricksExtras Compatibility**: Prioritizes selectors for Fluent Forms integrated via BricksExtras, with a fallback for direct Fluent Forms implementations
- **Clear Date Buttons**: Adds "X" buttons to date fields for easy clearing of selected dates
- **Lightweight and Efficient**: Frontend JavaScript is optimized for performance
- **Developer-Friendly**: Built with WordPress best practices, clean code, and a structured approach

### Technical Details
- **Minimum Requirements**:
  - WordPress 5.0+
  - PHP 8.0+
  - Fluent Forms Pro 6.0.3+
  - jQuery (included with WordPress)
- **Browser Support**: Chrome, Firefox, Safari, Edge (latest versions)
- **Hooks and Filters**: Provides developer hooks for customization

### Security
- Prevents direct file access
- Proper data sanitization and validation
- WordPress nonce verification for admin actions
- Escapes output for XSS prevention 