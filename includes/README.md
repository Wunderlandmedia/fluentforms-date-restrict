# Global Date Blocker - Includes Structure

This directory contains the organized code structure for the Global Date Blocker plugin, following WordPress best practices for plugin development.

## Directory Structure

```
includes/
├── core/                               # Core functionality classes
│   ├── class-gdb-activator.php         # Plugin activation handler
│   ├── class-gdb-deactivator.php       # Plugin deactivation handler
│   ├── class-gdb-loader.php            # Hook loader and manager
│   └── class-gdb-i18n.php              # Internationalization handler
├── admin/                              # Admin-specific functionality
│   ├── class-gdb-admin.php             # Admin coordinator class
│   ├── class-gdb-cpt-manager.php       # Custom Post Type manager
│   ├── class-gdb-meta-boxes.php        # Meta boxes manager
│   └── partials/                       # Admin template files
│       ├── metabox-restriction-settings.php  # Restriction settings form
│       └── metabox-disabled-dates.php         # Disabled dates calendar
├── frontend/                           # Public-facing functionality
│   └── class-gdb-frontend.php          # Frontend class
└── class-global-date-blocker.php       # Main plugin orchestrator class
```

## Class Descriptions

### Core Classes

- **GDB_Activator**: Handles plugin activation tasks like setting default options and database setup
- **GDB_Deactivator**: Handles plugin deactivation cleanup
- **GDB_Loader**: Manages all WordPress hooks and filters in an organized way
- **GDB_i18n**: Handles text domain loading for internationalization

### Admin Classes

- **GDB_Admin**: Main admin coordinator that:
  - Manages admin component initialization
  - Handles script and style enqueuing for admin pages
  - Coordinates between CPT Manager and Meta Boxes Manager
  - Provides access to admin components

- **GDB_CPT_Manager**: Dedicated Custom Post Type manager that:
  - Registers the "Calendar Restriction" Custom Post Type
  - Defines CPT labels, capabilities, and settings
  - Handles CPT-specific configurations

- **GDB_Meta_Boxes**: Meta boxes manager that:
  - Registers meta boxes for Calendar Restriction CPT
  - Renders restriction settings and disabled dates forms
  - Handles meta data saving and validation
  - Manages nonce verification and data sanitization

### Frontend Classes

- **GDB_Frontend**: Manages all public-facing functionality including:
  - Frontend script and style enqueuing
  - Fluent Forms integration
  - Date blocker functionality for multiple form configurations

### Main Class

- **Global_Date_Blocker**: The main orchestrator class that:
  - Initializes all other classes
  - Defines hooks through the loader
  - Manages plugin lifecycle

## Admin Partials

### Meta Box Templates

- **metabox-restriction-settings.php**: Form template for:
  - Target Fluent Form ID input
  - Check-in field name configuration
  - Check-out field name configuration

- **metabox-disabled-dates.php**: Calendar template for:
  - Flatpickr calendar interface
  - Disabled dates selection
  - JSON data handling for date storage

## Benefits of This Structure

1. **Separation of Concerns**: Each class has a specific responsibility
2. **Maintainability**: Code is organized and easy to find
3. **Scalability**: Easy to add new features without cluttering existing classes
4. **WordPress Standards**: Follows WordPress plugin development best practices
5. **Testability**: Classes can be unit tested independently
6. **Security**: Proper nonce handling and data sanitization
7. **Performance**: Conditional loading based on context (admin vs frontend)
8. **Modularity**: Admin functionality is split into logical components
9. **Template Separation**: HTML markup is separated from PHP logic

## CPT-Based Architecture

The plugin now uses a Custom Post Type approach for managing multiple calendar restrictions:

- Each "Calendar Restriction" is a separate CPT post
- Multiple forms can have different restriction configurations
- Meta boxes provide user-friendly interfaces for configuration
- Frontend queries all published restrictions and applies them dynamically

## Usage

The main plugin file (`booking-restrict.php`) includes all necessary files and initializes the plugin through the `Global_Date_Blocker` class. The loader pattern ensures all hooks are registered properly and the plugin functions as expected.

## Adding New Features

To add new admin features:

1. **New Meta Box**: Add to `GDB_Meta_Boxes` class and create corresponding partial
2. **New CPT Settings**: Modify `GDB_CPT_Manager` class
3. **New Admin Functionality**: Extend `GDB_Admin` or create new specialized classes
4. **New Templates**: Add partial files in the `partials/` directory
5. Follow the established naming conventions and documentation standards

## Admin Component Flow

1. `GDB_Admin` acts as the main coordinator
2. Loads and initializes `GDB_CPT_Manager` and `GDB_Meta_Boxes`
3. `GDB_CPT_Manager` registers the Custom Post Type
4. `GDB_Meta_Boxes` handles all meta box functionality
5. Partial templates separate presentation from logic 