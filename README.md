# Laravel Custom DB Migrate

Laravel custom db migrate. You can individual file migrate here.

## Installation

You can start it from composer. Go to your terminal and run this command from your project root directory.

```shell
composer require sayeed/custom-migrate
```

Wait for a while, its download.

## Configurations

After complete installation then you have to configure it. First copy these line paste it in `config/app.php` where `providers` array are exists.

```php
Sayeed\CustomMigrate\CustomMigrateServiceProvider::class,
```

Its done.

## How does it work?

Run below command for migrate only pending migrations which is not run yet

```php artisan migrate:custom```

##### Options
```--file``` for exact file name (filename must be without extension)

```--refresh``` for existing table

```--directory``` for subdirectory in migrations folder

###### All option has Shortcuts, like
`-f`  for file

`-r` for refresh

`-d` for directory

NB: For shortcut use, don't use equal(=) sign, just use space, like

```php artisan migrate:custom -f 2018_10_14_054732_create_tests_table```



If you have any kind of query, please feel free to share with me

Thank you

 

