# PHP MVC Skeleton

A minimal **PHP MVC skeleton** with PSR-4 autoloading and a lightweight routing system. Designed as a starting point for building PHP applications from scratch with a clean and extensible folder structure.

## Features

-   Simple **MVC architecture** (Controllers, Models, Views)
-   **PSR-4 autoloading** via Composer
-   Lightweight **router** for GET requests
-   Minimal dependencies, pure PHP
-   Ready to extend with additional controllers, models, and views

## Project Structure

app/
├── Controllers/ # Application controllers
│ └── HomeController.php
├── Core/ # Core classes like Router
│ └── Router.php
├── Models/ # Application models
│ └── User.php
└── Views/ # Templates
└── home.php

index.php # Front controller
composer.json # PSR-4 autoload configuration
.gitignore

bash
Copier le code

## Getting Started

1. Clone the repository:

```bash
git clone https://github.com/yourname/php-mvc-skeleton.git
cd php-mvc-skeleton
Install dependencies and autoload:

bash
Copier le code
composer install
composer dump-autoload
Start the PHP built-in server:

bash
Copier le code
php -S localhost:8000
Open your browser at http://localhost:8000

Example Usage
The default route (/) is handled by HomeController:

php
Copier le code
namespace App\Controllers;

use App\Models\User;

class HomeController
{
    public function index(): void
    {
        $users = (new User())->all();
        require __DIR__ . '/../Views/home.php';
    }
}
The example User model:

php
Copier le code
namespace App\Models;

class User
{
    public function all(): array
    {
        return [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob']
        ];
    }
}
Contributing
Contributions are welcome! Feel free to:

Add new routes, controllers, models, or views

Improve the router or add middleware

Suggest better project structure or organization

```
