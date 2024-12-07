# A simple FilamentPHP plugin that allows to save forms as drafts.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ronssij/filament-simple-draft.svg?style=flat-square)](https://packagist.org/packages/ronssij/filament-simple-draft)
[![Total Downloads](https://img.shields.io/packagist/dt/ronssij/filament-simple-draft)](https://packagist.org/packages/ronssij/filament-simple-draft/stats)
[![Licence](https://img.shields.io/github/license/ronssij/filament-simple-draft)](LICENSE.md)

This package is a simple plugin to allow required fields on forms to be draftable. Filament field components already could do it on demand using:
```php
->nullable(true|false)
```

<img src="https://raw.githubusercontent.com/ronssij/filament-simple-draft/1.x/screens/sample-draft.gif">

## Installation

You can install the package via composer:

```bash
composer require ronssij/filament-simple-draft
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-simple-draft-config"
```

This is the contents of the published config file:

```php
// config/filament-simple-draft.php
return [
    'publishable_column' => 'published_at',
];
```

## Usage

On your model, these classes should be used. Make sure all of you draftable fields are nullable columns on your model.
```php
use Ronssij\FilamentSimpleDraft\Contracts\CanBePublished;
use Ronssij\FilamentSimpleDraft\Publishable;

class User extends Authenticatable implements CanBePublished
{
    // Optionally, you can set you published column identifier
    // Or you can set it via configuration (config/filament-simple-draft.php).
    protected ?string $publishColumn = 'published_date';

    use Publishable;
}
```

On your Resources for CreateRecord and EditRecord:
```php
use Filament\Resources\Pages\EditRecord;
use Ronssij\FilamentSimpleDraft\Pages\Traits\Edit\Draftable;

class EditUser extends EditRecord
{
    use Draftable;
}
```

```php
use Filament\Resources\Pages\CreateRecord;
use Ronssij\FilamentSimpleDraft\Pages\Traits\Create\Draftable;

class CreateUser extends CreateRecord
{
    use Draftable;
}
```

<!-- ## Testing
```bash
composer test
``` -->

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.