# Provides an interfaces to the Azure Graph

[![Latest Version on Packagist](https://img.shields.io/packagist/v/chrisreedio/laravel-azure-graph.svg?style=flat-square)](https://packagist.org/packages/chrisreedio/laravel-azure-graph)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/chrisreedio/laravel-azure-graph/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/chrisreedio/laravel-azure-graph/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/chrisreedio/laravel-azure-graph/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/chrisreedio/laravel-azure-graph/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/chrisreedio/laravel-azure-graph.svg?style=flat-square)](https://packagist.org/packages/chrisreedio/laravel-azure-graph)

Provides an interface to the Azure Graph API.

## Installation

You can install the package via composer:

```bash
composer require chrisreedio/laravel-azure-graph
```

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

## Usage

TODO - This is a work in progress.

```php
$azureGraph = new ChrisReedIO\AzureGraph();
echo $azureGraph->echoPhrase('Hello, ChrisReedIO!');
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
