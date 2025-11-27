# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

A minimal PHP MVC skeleton with PSR-4 autoloading and lightweight routing. This is a starting point for PHP applications with a clean, extensible folder structure.

## Development Commands

### Starting the Application
```bash
php -S localhost:8000 -t .
```

The application will be accessible at `http://localhost:8000`.

### Running Tests
```bash
vendor/bin/phpunit
```

PHPUnit 11.x is configured as a dev dependency.

### Installing Dependencies
```bash
composer install
```

## Architecture

### Request Flow
1. All requests hit `index.php` (front controller)
2. `index.php` requires the Composer autoloader and instantiates the `Router`
3. Routes are registered using `$router->get()` or `$router->post()` methods
4. `Router::run()` matches the current request method and URI to registered routes
5. If matched, the router auto-instantiates the controller class and calls the specified method
6. Controller methods fetch data from models and load views

### Directory Structure

```
app/
├── Controller/     # Controller classes (namespace: App\Controllers)
├── Model/          # Model classes (namespace: App\Models)
├── View/           # View templates (plain PHP files)
├── core/
│   └── Router/     # Router implementation
└── tests/          # Test files (empty by default)
```

### Router Implementation
- Located at `app/core/Router/router.php`
- NOT namespaced (loaded via `require_once` in index.php)
- Supports GET and POST routes via `get()` and `post()` methods
- Route handlers can be either:
  - Callable functions/closures
  - Array format: `[ControllerClass::class, 'methodName']`
- Auto-instantiates controllers when using array format
- Returns 404 response for unmatched routes
- Special handling: Ignores URIs starting with `/coverage/` (for PHPUnit coverage reports)

### Controllers
- Located in `app/Controller/`
- Namespace: `App\Controllers`
- Responsible for handling requests and coordinating models/views
- Load views using `require` with relative paths: `require __DIR__ . '/../views/viewname.php'`
- Pass data to views by defining variables before requiring the view file

### Models
- Located in `app/Model/`
- Namespace: `App\Models`
- No database abstraction layer by default (pure PHP)
- Example `User` model returns hardcoded array data
- Should be extended to connect to actual database

### Views
- Located in `app/View/`
- Plain PHP files with HTML
- Access variables passed from controllers
- Use short echo syntax: `<?= $variable ?>`

### Key Files
- `index.php` - Front controller at root, not in app directory
- `app/core/Router/router.php` - Routing logic (no namespace)
- `composer.json` - Missing PSR-4 autoload configuration for App namespace

## Important Notes

### Missing Autoload Configuration
The `composer.json` file is missing PSR-4 autoload configuration. Controllers and Models use namespaces but autoloading isn't properly configured. To fix, add to `composer.json`:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/"
    }
}
```

Then run `composer dump-autoload`.

### Router Not Namespaced
The `Router` class at `app/core/Router/router.php` is not namespaced and is loaded via `require_once` in `index.php`. This is inconsistent with the PSR-4 autoloading pattern used for Controllers and Models.

### View Path Convention
Controllers load views using relative paths from the Controller directory:
```php
require __DIR__ . '/../views/home.php';
```

Note the lowercase `views` in the path, but the actual directory is `View` (capitalized).