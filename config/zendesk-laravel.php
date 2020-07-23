<?php
return [
    'driver' => env('ZENDESK_DRIVER', 'api'),
    'subdomain' => env('ZENDESK_SUBDOMAIN',null),
    'username' => env('ZENDESK_USERNAME',null),
    'token' => env('ZENDESK_TOKEN',null)
];