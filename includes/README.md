# Global Date Blocker - Includes Structure

This directory contains the organized code structure for the Global Date Blocker plugin, following WordPress best practices for plugin development.

## Directory Structure

```
includes/
├── core/                           # Core functionality classes
│   ├── class-gdb-activator.php     # Plugin activation handler
│   ├── class-gdb-deactivator.php   # Plugin deactivation handler
│   ├── class-gdb-loader.php        # Hook loader and manager
│   └── class-gdb-i18n.php          # Internationalization handler
├── admin/                          # Admin-specific functionality
│   ├── class-gdb-admin.php         # Admin class
│   └── partials/                   # Admin template files
│       └── gdb-admin-display.php   # Admin page template
├── frontend/                       # Public-facing functionality
│   └── class-gdb-frontend.php      # Frontend class
└── class-global-date-blocker.php   # Main plugin orchestrator class
```

## Class Descriptions

### Core Classes

- **GDB_Activator**: Handles plugin activation tasks like setting default options and database setup
- **GDB_Deactivator**: Handles plugin deactivation cleanup
- **GDB_Loader**: Manages all WordPress hooks and filters in an organized way
- **GDB_i18n**: Handles text domain loading for internationalization

### Admin Classes

- **GDB_Admin**: Manages all admin-specific functionality including:
  - Admin menu creation
  - Script and style enqueuing for admin pages
  - Form processing and data validation
  - Admin page rendering

### Frontend Classes

- **GDB_Frontend**: Manages all public-facing functionality including:
  - Frontend script and style enqueuing
  - Fluent Forms integration
  - Date blocker functionality

### Main Class

- **Global_Date_Blocker**: The main orchestrator class that:
  - Initializes all other classes
  - Defines hooks through the loader
  - Manages plugin lifecycle

## Benefits of This Structure

1. **Separation of Concerns**: Each class has a specific responsibility
2. **Maintainability**: Code is organized and easy to find
3. **Scalability**: Easy to add new features without cluttering the main file
4. **WordPress Standards**: Follows WordPress plugin development best practices
5. **Testability**: Classes can be unit tested independently
6. **Security**: Proper nonce handling and data sanitization
7. **Performance**: Conditional loading based on context (admin vs frontend)

## Usage

The main plugin file (`booking-restrict.php`) includes all necessary files and initializes the plugin through the `Global_Date_Blocker` class. The loader pattern ensures all hooks are registered properly and the plugin functions as expected.

## Adding New Features

To add new features:

1. Create appropriate classes in the relevant directories
2. Include them in the main plugin file
3. Register hooks through the loader in the main class
4. Follow the established naming conventions and documentation standards 