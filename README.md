# Proxy method and property interactions in PHP.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ryangjchandler/proxy.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/proxy)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/proxy/run-tests?label=tests)](https://github.com/ryangjchandler/proxy/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/proxy/Check%20&%20fix%20styling?label=code%20style)](https://github.com/ryangjchandler/proxy/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ryangjchandler/proxy.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/proxy)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support development

If you would like to support the on going maintenance and development of this package, please consider [sponsoring me on GitHub](https://github.com/sponsors/ryangjchandler).

## Installation

You can install the package via Composer:

```bash
composer require ryangjchandler/proxy
```
## Usage

This package provides a `Proxy` class that you can use to wrap any object. It allows you to intercept property access and assignments, as well as method calls.

Here's an example:

```php
class Target
{
    public $firstName = 'Ryan';

    public $lastName = 'Chandler';
}

$proxy = new Proxy(new Target, [
    'get' => function (Target $target, string $property) {
        if ($property === 'fullName') {
            return $target->firstName . ' ' . $target->lastName;
        }

        return $target->{$property};
    },
]);

$proxy->fullName; // 'Ryan Chandler'
```

If you would like to handle "setting" a property's value, you can add a `set` key and callback function to the handlers array.

```php
$proxy = new Proxy(new Target, [
    'set' => function (Target $target, string $property, mixed $value) {
        if ($property === 'fullName') {
            $parts = explode(' ', $value);

            $target->firstName = $parts[0];
            $target->lastName = $parts[1];
        } else {
            $target->{$property} = $value;
        }
    },
]);
```

To intercept method calls, add a `call` key to the array.

```php
class Target
{
    public int $number = 10;
}

$proxy = new Proxy(new Target, [
    'call' => function (Target $target, string $method, array $arguments) {
        if ($method === 'toInt') {
            return $target->number;
        }

        return $target->{$method}(...$arguments);
    },
]);

$proxy->toInt(); // 10
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ryan Chandler](https://github.com/ryangjchandler)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
