# Provides an interfaces to the Azure Graph

[![Latest Version on Packagist](https://img.shields.io/packagist/v/chrisreedio/laravel-azure-graph.svg?style=flat-square)](https://packagist.org/packages/chrisreedio/laravel-azure-graph)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/chrisreedio/laravel-azure-graph/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/chrisreedio/laravel-azure-graph/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/chrisreedio/laravel-azure-graph/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/chrisreedio/laravel-azure-graph/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/chrisreedio/laravel-azure-graph.svg?style=flat-square)](https://packagist.org/packages/chrisreedio/laravel-azure-graph)

Provides an interface to the Azure Graph API.

> [!WARNING]  
> This package is still in development and is not ready for production use.
> 
> It currently only supports delegated authentication via a user supplied token.
> 
> The only call supported is to fetch a user's groups via the `memberOf` endpoint.

## Installation

You can install the package via composer:

```bash
composer require chrisreedio/laravel-azure-graph
```
## Usage

This sample shows how to get all of a user's groups via a delegated call to the `memberOf` endpoint.

```php
$graph = new GraphConnector('user-token');
$paginator = $graph->paginate(new MemberOfRequest());
$adGroups = $paginator->collect();

// Dump the user's groups
dd($adGroups->pluck('displayName')->all());
```

## Config

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-azure-graph-config"
```

This is the contents of the published config file:

```php
return [
    'pagination' => [
        'limit' => 100,
    ],
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Chris Reed](https://github.com/chrisreedio)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
