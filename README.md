# Laravel Custom DB Migrate

Laravel Custom DB Migrate allows fine grain control of migrations inside your Laravel or Lumen application. You can choose which migration files - or groups of files inside the directory - get migrated to the database.

- [Laravel Custom DB Migrate](#laravel-custom-db-migrate)
    - [Installation](#installation)
        - [Laravel 5.5 and above](#laravel-55-and-above)
        - [Laravel 5.4 and older](#laravel-54-and-older)
        - [Lumen](#lumen)
    - [Usage](#usage)
        - [Migrate specific file](#migrate-specific-file)
        - [Migrate specific directory](#migrate-specific-directory)
        - [Refreshing migrations](#refreshing-migrations)
    - [Credits](#credits)

## Installation

You can install the package via composer:

```shell
composer require sayeed/custom-migrate
```

### Laravel 5.5 and above

The package will automatically register itself, so you can start using it immediately.

### Laravel 5.4 and older

In Laravel version 5.4 and older, you have to add the service provider in `config/app.php` file manually:

```php
'providers' => [
    // ...
    Sayeed\CustomMigrate\CustomMigrateServiceProvider::class,
];
```
### Lumen

After installing the package, you will have to register it in `bootstrap/app.php` file manually:
```php
// Register Service Providers
    // ...
    $app->register(Sayeed\CustomMigrate\CustomMigrateServiceProvider::class);
];
```

## Usage

After installing the package, you will now see a new ```php artisan migrate:custom``` command.

### Migrate specific file

You can migrate a specific file inside your `database/migrations` folder using:

```php artisan migrate:custom -f 2018_10_14_054732_create_tests_table```

Alternatively, you can use the longform version:

```php artisan migrate:custom --file 2018_10_14_054732_create_tests_table```

### Migrate specific directory

You can migrate a specific directory inside your `database/migrations` folder using:

```php artisan migrate:custom -d subfolder/2018_10_14_054732_create_tests_table```

Alternatively, you can use the longform version:

```php artisan migrate:custom --directory subfolder/2018_10_14_054732_create_tests_table```

### Refreshing migrations

You can refresh migrations inside your project using:

```php artisan migrate:custom -r```

Alternatively, you can use the longform version:

```php artisan migrate:custom --refresh```

## Credits

- [Md. Hasan Sayeed](https://github.com/nilpahar)
- [Gal Jakic](https://github.com/morpheus7CS)

 For any questions, you can reach out to the author of this package, Md. Hasan Sayeed.

 Thank you for using it.