![Repository Banner](https://banners.beyondco.de/Observer%20for%20validating%20Eloquent%20Model.png?theme=light&packageManager=composer+require&packageName=spoorsny%2Flaravel-model-validating-observer&pattern=circuitBoard&style=style_1&description=An+observer+that+validates+an+Eloquent+model+instance+before+it+is+persisted+to+the+database.&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spoorsny/laravel-model-validating-observer.svg?style=flat-square)](https://packagist.org/packages/spoorsny/laravel-model-validating-observer)
[![Total Downloads](https://img.shields.io/packagist/dt/spoorsny/laravel-model-validating-observer.svg?style=flat-square)](https://packagist.org/packages/spoorsny/laravel-model-validating-observer)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/spoorsny/laravel-model-validating-observer/continuous-integration.yml?branch=master&label=tests&style=flat-square)](https://github.com/spoorsny/laravel-model-validating-observer/actions?query=workflow%3Acontinuous-integration+branch%3Amaster)
[![PHPUnit Code Coverage](https://github.com/spoorsny/laravel-model-validating-observer/blob/image-data/coverage.svg)](https://github.com/spoorsny/laravel-model-validating-observer/actions?query=workflow%3Acontinuous-integration+branch%3Amaster)

# Observer for validating Eloquent Model

An observer that validates an Eloquent model instance before it is persisted to
the database, by raising a `ValidationException`.

## Install

Use [Composer](https://getcomposer.org) to install the package.

```shell
composer require spoorsny/laravel-model-validating-observer
```

## Usage

Add the `ObservedBy` attribute to your model, with
`ModelValidatingObserver::class` as its argument.

Add a public, static method to your model, named `validationRules()` that
returns an associative array with the validation rules and custom messages for
your model's attributes.

```php
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

use Spoorsny\Laravel\Observers\ModelValidatingObserver;

#[ObservedBy(ModelValidatingObserver::class)]
class Car extends Model
{
    public static function validationRules(): array
    {
        return [
            'rules' => [
                'make' => 'required|string',
                'model' => 'required|string',
            ],
            'messages' => [
                'make.required' => 'We need to know the make of the car.',
            ],
        ];
    }
}
```

The observer will check each instance of your model against the validation
rules during the `saving` event triggered by Eloquent. If validation fails, a
`\Illuminate\Validation\ValidationException` will be thrown, preventing the
persistence of the invalid model instance.

## Contributing

To contribute to the package, see the [Contributing Guide](CONTRIBUTING.md).

## License

Copyright &copy; 2024 Geoffrey Bernardo van Wyk [https://geoffreyvanwyk.dev](https://geoffreyvanwyk.dev)

This file is part of package spoorsny/laravel-model-validating-observer.

Package spoorsny/laravel-model-validating-observer is free software: you can redistribute it
and/or modify it under the terms of the GNU General Public License as
published by the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Package spoorsny/laravel-model-validating-observer is distributed in the hope that it will be
useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.

You should have received a copy of the GNU General Public License along with
package spoorsny/laravel-model-validating-observer. If not, see <https://www.gnu.org/licenses/>.

For a copy of the license, see the [LICENSE](LICENSE) file in this repository.
