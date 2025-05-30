# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-12-19

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