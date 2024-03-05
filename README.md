# intercom-saloon

A PHP SDK for the Intercom REST API implemented using Saloon

## Important - Library in Active Development

This library is in active development and mainly used for internal projects. If you are using it, please consider starring the repo, or opening an issue/PR so we know you are using it. 

## Why Saloon?

I forked the original PHP library from Intercom (https://github.com/intercom/intercom-php) in ~2018 and since then there have been some major improvements in Intercom's REST API,
PHP and libraries such as Saloon. With that in mind, I wanted to make the library more robust, strongly typed and easier
to maintain. In addition, Saloon has inbuilt support for pagination and rate limiting, lowering technical overhead when
dealing with high traffic integration scenarios.

## Installation

* This library requires PHP 8.0 and later
* The recommended way to install is using Composer

```sh
composer require mckltech/intercom-saloon
```

## Data Transfer Objects (DTOs)

The library makes extensive use of DTOs for entities such a Contacts, Notes, Tags etc. Most endpoints
return a DTO or a collection of DTOs. The DTOs are strongly typed and will throw exceptions if required fields are not
present, in addition to the request failing if no DTO can be created.

## Client - API Key & OAuth

Initialize your client using your access token:

```php
$client = new IntercomService(
  "YYYYjVlXXXXXNDUyNV84OWIzXzYxYWFXXXXX="
);
```

## Support, Issues & Bugs

This library is unofficial and is not endorsed or supported by Intercom.

For bugs and issues, open an issue in this repo and feel free to submit a PR. Any issues that do not contain full logs
or explanations will be closed. We need you to help us help you!

## Example Operations

```php
use WooNinja\IntercomSaloon\Services\IntercomService;

$client = new IntercomService(
  "YYYYjVlXXXXXNDUyNV84OWIzXzYxYWFXXXXX="
);

/* Add a Note to a Contact */
$contact = $client->contacts->note(
  "XXXXXXd2061f134f0247f",
  "Hello World"
);

/* Fetch all Users */
$contacts = $client->contacts->contacts();

/* Paginate through all contact */
foreach ($contacts->items() as $contact) {
  /* Fetch a single contact */ 
  $my_contact = $client->contacts->get($contact->id);

}

```

## Supported Endpoints

All endpoints follow a similar mechanism to the examples show above. Again, please ensure you read the Thinkific API
documentation prior to use as there are numerous required fields for most POST/PUT operations.

- Contacts (CRUD & Search by Email)
- Tags (List and Add/Remove to Contact)
- Data Events (Submit Event)
- Notes (Add Note to Contact)

## Exceptions

Exceptions are handled by Saloon. Most end points for retrieving data will either return a DTO (or collection of DTOs)
or fail. Further docs here: https://docs.saloon.dev/the-basics/handling-failures

## Credit

The layout and methodology used in this library was inspired by Ash Allen from https://battle-ready-laravel.com/


