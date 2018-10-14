# Laravel Custom DB Migrate

Laravel custom db migrate using indifidual file name

## Installation

You can start it from composer. Go to your terminal and run this command from your project root directory.

```shell
composer require sayeed/sslwireless
```

Wait for a while, its download.

## Configurations

After complete installation then you have to configure it. First copy these line paste it in `config/app.php` where `providers` array are exists.

```php
Sayeed\Sslwireless\SslwirelessServiceProvider::class,
```

Run your application and goto below url for create config

```url
{your_domain}/sayeed/sslwareless
```

Its done.

## How does it work?

At first change your configuration in `Config/sayeed.php` with api_url, store_id, store_passwd, currency, success_url, fail_url, cancel_url
```php
return [
    'sslwireless' => [
        'connection' => [
            'api_url'       => 'https://sandbox.sslcommerz.com/gwprocess/v3/api.php', #required
            'store_id'      => '123456789', #required
            'store_passwd'  => '123456789@ssl', #required
            'currency'      => 'BDT', #required
            'success_url'   => 'http://localhost/success', #required
            'fail_url'      => 'http://localhost/fail', #required
            'cancel_url'    => 'http://localhost/cancel', #required
        ]
    ]
];
```

## Usages

```php
$ssl_payment = new Sslwireless('connection');

$products[0]['product'] = 'Product Name 1';
$products[0]['amount'] = 150;

$products[1]['product'] = 'Product Name 2';
$products[1]['amount'] = 100;

$products[2]['product'] = 'Product Name 3';
$products[2]['amount'] = 250;

$ssl_payment->payment_by_sslwireless($products, $unique_transaction_id = false);
```


If you have any kind of query, please feel free to share with me

Thank you

 

