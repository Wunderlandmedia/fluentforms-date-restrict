# Changelog

All notable changes to this project will be documented in this file.

## [2.0.1] - 2024-12-19

### Added
- Automatic date blocking functionality for submitted bookings
- Integration with Fluent Forms `fluentform/submission_inserted` action hook
- Real-time availability system that blocks booked dates immediately after form submission
- Date range calculation between check-in and check-out dates
- Automatic merging of new blocked dates with existing disabled dates
- Error handling and logging for date processing issues
- Enhanced debugging capabilities for submission processing

### Technical Details
- New `automatically_disable_booked_dates()` method in `GDB_Frontend` class
- Hooks into Fluent Forms submission process with priority 20
- Processes date ranges from check-in to check-out (excluding check-out day)
- Validates form data and restriction configurations before processing
- Updates `_gdb_disabled_dates` meta field automatically

## [2.0.0] - 2024-05-30

### Major Update - Multi-Configuration System

Complete architectural redesign introducing Custom Post Type system for unlimited calendar restrictions.

### Added
- Custom Post Type (`gdb_restriction`) for managing multiple calendar restrictions
- Multi-configuration support - create unlimited restrictions targeting different forms
- WordPress native admin interface with meta boxes
- Flatpickr calendar integration in admin
- Multi-form page support with independent operation
- Performance optimizations - scripts load only when needed
- Enhanced debug capabilities
- Form-specific clear buttons with unique IDs

### Changed
- **BREAKING**: Moved from global settings to Custom Post Type system
- **BREAKING**: Data storage changed from `wp_options` to `post_meta`
- **BREAKING**: Admin interface now uses CPT management instead of settings page
- Frontend JavaScript completely refactored for multi-configuration support
- Each restriction independently targets specific forms
- Per-restriction disabled dates instead of global dates

### Removed
- **BREAKING**: Old global settings system
- Settings page under "Settings > Global Date Blocker"
- Single configuration limitation

### Migration Notes
- No automatic migration - manual setup required
- Old data preserved but not used
- Create new Calendar Restrictions through CPT interface after updating

## [1.0.0] - 2024-05-28

### Added
- Initial release
- Global date management for Fluent Forms
- Admin calendar interface with Flatpickr
- Dynamic check-in/check-out functionality
- Configurable form targeting
- BricksExtras compatibility
- Clear date buttons
- MIT License 