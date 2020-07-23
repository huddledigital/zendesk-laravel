# Laravel Zendesk

This package provides integration with the Zendesk API. It supports creating tickets, retrieving and updating tickets, deleting tickets, etc.

The package simply provides a `Zendesk` facade that acts as a wrapper to the [zendesk/zendesk_api_client_php](https://github.com/zendesk/zendesk_api_client_php) package.

**NB:** Currently only supports token-based authentication.

## Installation

You can install this package via Composer using:

```bash
composer require huddledigital/zendesk-laravel
```

You must also install the service provider.

> Laravel 5.5+ users: this step may be skipped, as the package supports auto discovery.

```php
// config/app.php
'providers' => [
    ...
    Huddle\Zendesk\Providers\ZendeskServiceProvider::class,
    ...
];
```

If you want to make use of the facade you must install it as well.

```php
// config/app.php
'aliases' => [
    ..
    'Zendesk' => Huddle\Zendesk\Facades\Zendesk::class,
];
```

## Configuration


To publish the config file to `app/config/zendesk-laravel.php` run:

```bash
php artisan vendor:publish --provider="Huddle\Zendesk\Providers\ZendeskServiceProvider"
```


Set your configuration using **environment variables**, either in your `.env` file or on your server's control panel:

- `ZENDESK_SUBDOMAIN`

The subdomain part of your Zendesk organisation URL.

e.g. http://huddledigital.zendesk.com use **huddledigital**

- `ZENDESK_USERNAME`

The username for the authenticating account.

- `ZENDESK_TOKEN`

The API access token. You can create one at: `https://SUBDOMAIN.zendesk.com/agent/admin/api/settings`

- `ZENDESK_DRIVER` _(Optional)_

Set this to `null` or `log` to prevent calling the Zendesk API directly from your environment.

## Usage

### Facade

The `Zendesk` facade acts as a wrapper for an instance of the `Zendesk\API\Client` class. Any methods available on this class ([documentation here](https://github.com/zendesk/zendesk_api_client_php#usage)) are available through the facade. for example:

```php
// Get all tickets
Zendesk::tickets()->findAll();

// Create a new ticket
Zendesk::tickets()->create([
  'subject' => 'Subject',
  'comment' => [
      'body' => 'Ticket content.'
  ],
  'priority' => 'normal'
]);

// Update multiple tickets
Zendesk::ticket([123, 456])->update([
  'status' => 'urgent'
]);

// Delete a ticket
Zendesk::ticket(123)->delete();
```

### Dependency injection

If you'd prefer not to use the facade, you can skip adding the alias to `config/app.php` and instead inject `Huddle\Zendesk\Services\ZendeskService` into your class. You can then use all of the same methods on this object as you would on the facade.

```php
<?php

use Huddle\Zendesk\Services\ZendeskService;

class MyClass {

    public function __construct(ZendeskService $zendesk_service) {
        $this->zendesk_service = $zendesk_service;
    }

    public function addTicket() {
        $this->zendesk_service->tickets()->create([
              'subject' => 'Subject',
              'comment' => [
                    'body' => 'Ticket content.'
              ],
              'priority' => 'normal'
        ]);
    }

}
```

This package is available under the [MIT license](http://opensource.org/licenses/MIT).
