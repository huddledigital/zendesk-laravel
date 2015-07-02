# Laravel Zendesk

This package provides integration with the Zendesk API. It supports creating tickets, retrieving and updating tickets, deleting tickets, etc.

The package simply provides a ```Zendesk``` facade that acts as a wrapper to the [zendesk/zendesk_api_client_php](https://github.com/zendesk/zendesk_api_client_php) package.

**NB:** Currently only supports token-based authentication.

## Installation

Install via composer by adding the following to your composer.json:

```json
    ...
    "require": {
        "huddledigital/zendesk-laravel": "~1.0"
    }
    ...
```

Add service provider to ```config/app.php```:

```php
    ...
    'Huddle\Zendesk\Providers\ZendeskServiceProvider',
    ...
```

Add alias to ```config/app.php```:

```php
    ...
    'Zendesk' => 'Huddle\Zendesk\Facades\Zendesk',
    ...
```

## Configuration

Set your configuration using **environment variables**, either in your ```.env``` file or on your server's control panel:

- ```ZENDESK_SUBDOMAIN``` - the subdomain for your Zendesk organisation.
- ```ZENDESK_USERNAME``` - the username for the authenticating account.
- ```ZENDESK_TOKEN``` - the access token. To generate an access token within Zendesk, click on Settings, API, enable Token Access and click 'add new token'.

## Usage

### Facade

The ```Zendesk``` facade acts as a wrapper for an instance of the ```Zendesk\API\Client``` class. Any methods available on this class ([documentation here](https://github.com/zendesk/zendesk_api_client_php#usage)) are available through the facade. for example:

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

If you'd prefer not to use the facade, you can skip adding the alias to ```config/app.php``` and instead inject ```Huddle\Zendesk\Services\ZendeskService``` into your class. You can then use all of the same methods on this object as you would on the facade.

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
