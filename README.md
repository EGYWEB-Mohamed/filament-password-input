# filament-password-input

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rawilk/filament-password-input.svg?style=flat-square)](https://packagist.org/packages/rawilk/filament-password-input)
![Tests](https://github.com/rawilk/filament-password-input/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/rawilk/filament-password-input.svg?style=flat-square)](https://packagist.org/packages/rawilk/filament-password-input)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/rawilk/filament-password-input?style=flat-square)](https://packagist.org/packages/rawilk/filament-password-input)
[![License](https://img.shields.io/github/license/rawilk/filament-password-input?style=flat-square)](https://github.com/rawilk/filament-password-input/blob/main/LICENSE.md)

![social image](https://banners.beyondco.de/Filament%20Password%20Input.png?theme=light&packageManager=composer+require&packageName=rawilk%2Ffilament-password-input&pattern=architect&style=style_1&description=Enhanced+password+input+component+for+filament.&md=1&showWatermark=0&fontSize=100px&images=lock-closed)

`filament-password-input` is a package built for [Filament](https://filamentphp.com) that provides an enhanced password input form component that offers you the ability to add the following
features to your password inputs:

-   Reveal password toggle
-   Copy to clipboard
-   Generate new password button

## Installation

You can install the package via composer:

```bash
composer require rawilk/filament-password-input
```

That's it. There is no configuration file or migrations necessary for the package. Any customization is done directly on
the input itself, or [globally](#global-configuration) in a service provider, however there are a few language lines that can be overridden
if necessary in your application. You may publish the language files with:

```bash
php artisan vendor:publish --tag=filament-password-input-translations
```

If you want to override the views from the package, you may publish them with:

```bash
php artisan vendor:publish --tag=filament-password-input-views
```

## Usage

Inside a form schema, you can use the `Password` input like this:

```php
use Rawilk\FilamentPasswordInput\Password;
use Filament\Forms\Form;

public function form(Form $form): Form
{
    return $form
        ->schema([
            // ...
            Password::make('password')
                ->label('Password'),
        ]);
}
```

The code above will render a password input inside the form with a toggle button to show and hide the password.

![base input](docs/images/base-input.png)

If you want to render a normal password input without the toggle, you may also do that with this field. The following code
will render the password input without the toggle button inside it:

```php
use Rawilk\FilamentPasswordInput\Password;
use Filament\Forms\Form;

public function form(Form $form): Form
{
    return $form
        ->schema([
            // ...
            Password::make('password')
                ->label('Password')
                ->canRevealPassword(false),
        ]);
}
```

### Button Icons

If you want to use different icons for the on/off state of the password reveal toggle button, you can do so like this:

```php
Password::make('password')
    ->showPasswordIcon('heroicon-o-eye')
    ->hidePasswordIcon('heroicon-o-eye-off'),
```

Like many of the other methods available on this input, you may use a closure to dynamically set the icon instead of passing
in a string to either method.

### Tooltip Text

You can customize the text that shows up in the tooltip for this button by either overriding the `filament-password-input::password.actions.reveal.show`
and `filament-password-input::password.actions.reveal.hide` language keys, or by providing your own text to the `showPasswordText` and `hidePasswordText` methods:

```php
Password::make('password')
    ->showPasswordText('Show password')
    ->hidePasswordText('Hide password'),
```

## Copy to Clipboard

You can easily make any password input copyable by calling the `copyable()` method on the input. This will merge an action button in with any other `suffixActions`
you have defined on the input.

```php
Password::make('password')
    ->copyable(),
```

![copyable input](docs/images/input-with-copy.png)

> **Note:** This button will not show up if the input is disabled.

If you'd like the copy button to show up as an inline suffix instead, you can simply call the `inlineSuffix()` method on the input.

### Copy Icon

You can easily use a different icon for the copy button like this:

```php
Password::make('password')
    ->copyable()
    ->copyIcon('heroicon-o-clipboard'),
```

### Icon Color

You can customize the color of the icon by using the `copyIconColor` method:

```php
Password::make('password')
    ->copyable()
    ->copyIconColor('success'),
```

### Tooltip

When you hover over the copy button, a tooltip saying `Copy to clipboard` will show up. You can customize this text globally
by overriding the `filament-password-input::password.actions.copy.tooltip` language key, or individually by using the `copyTooltip` method:

```php
Password::make('password')
    ->copyable()
    ->copyTooltip('Copy password'),
```

### Confirmation Text

Once clicked, a tooltip will appear with the text `Copied`. You can customize this text globally by overriding the `filament::components/copyable.messages.copied`
language key, or individually by using the `copyMessage` method:

```php
Password::make('password')
    ->copyable()
    ->copyMessage('Copied'),
```

### Copy Message Duration

The confirmation text that appears after clicking the copy button will disappear after 1 second by default. You can customize this with
the `copyMessageDuration` method:

```php
Password::make('password')
    ->copyable()
    ->copyMessageDuration(3000), // 3 seconds
```

> **Note:** The duration should be in milliseconds, and as an integer value.

## Password Generation

Another feature offered by this component is password generation. By calling the `regeneratePassword()` method on the input, a button will be
merged in with any other `suffixActions` you have defined on the input.

```php
Password::make('password')
    ->label('Password')
    ->regeneratePassword(),
```

![regenerate password](docs/images/input-with-generate.png)

> **Note:** This button will not show up if the input is disabled or readonly.

As with the copy to clipboard action button, you can have this action rendered inline on the input as well by calling the `inlineSuffix()` method
on the input.

### Password Generation

By default, the password generation is handled with Laravel's `Str::password()` helper method. This will generate a random, strong password that is 32
characters long for you. If you have a `maxLength()` set on the input, that length will be used instead for the character length.

You may also use a completely custom generation method by providing a closure to the `generatePasswordUsing` method:

```php
Password::make('password')
    ->regeneratePassword()
    ->generatePasswordUsing(function ($state) {
        // State is the current value of the input
        return 'my-custom-password';
    }),
```

Now when the button is clicked, `my-custom-password` will be filled into the input instead.

### Button Icon

You can easily use a different icon for the generate password button using the `regeneratePasswordIcon` method:

```php
Password::make('password')
    ->regeneratePassword()
    ->regeneratePasswordIcon('heroicon-m-arrow-path'),
```

### Icon Color

You can customize the color of the icon by using the `regeneratePasswordIconColor` method:

```php
Password::make('password')
    ->regeneratePassword()
    ->regeneratePasswordIconColor('success'),
```

### Tooltip

When you hover the generate password action button, the text `Generate new password` will show up in a tooltip. You can customize this text globally
by overriding the `filament-password-input::password.actions.regenerate.tooltip` language key, or individually by using the `regeneratePasswordTooltip` method:

```php
Password::make('password')
    ->regeneratePassword()
    ->regeneratePasswordTooltip('Generate new password'),
```

### Confirmation Message

Once a new password is generated and returned to the UI, the component will make use of a filament `Notification` with the text `New password was generated!`.
You can customize this globally by overriding the `filament-password-input::password.actions.regenerate.success_message` language key, or individually by using the
`passwordRegeneratedMessage` method:

```php
Password::make('password')
    ->regeneratePassword()
    ->passwordRegeneratedMessage('New password was generated!'),
```

You may also disable this notification all-together by providing a `false` value to `notifyOnPasswordRegenerate`:

```php
Password::make('password')
    ->regeneratePassword()
    ->notifyOnPasswordRegenerate(false),
```

## Password Managers

If you have a password manager installed, like 1Password or LastPass, you'll know that they automatically inject a button into password inputs.
Normally, this is a good thing, but there can be times when this is not desired, such as in local development or on a form where you're
inputting something other than your own password.

To disable password managers from injecting themselves into your password inputs, you may use the `hidePasswordManagerIcons()` method:

```php
Password::make('password')
    ->hidePasswordManagerIcons(),
```

This will add `data-1p-ignore` and `data-lpignore="true"` attributes to the input to attempt to block password managers from injecting their buttons. This isn't always
100% effective, but it should work in most cases. If you know of a better way to handle this, PR's are always welcome.

## Kitchen Sink Example

Here is an example of an input with all the actions enabled:

```php
Password::make('password')
    ->label('Password')
    ->inlineSuffix()
    ->copyable()
    ->regeneratePassword()
    ->copyIconColor('warning')
    ->regeneratePasswordIconColor('primary'),
```

![kitchen sink](docs/images/kitchen-sink.png)

## Global Configuration

Like most things in filament, you can customize a lot of the default behavior of this input in a service provider
using `configureUsing`:

```php
use Rawilk\FilamentPasswordInput\Password;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Password::configureUsing(function (Password $password) {
            $password
                ->maxLength(24)
                ->copyable()
                ->copyIcon('heroicon-o-clipboard');
                // ->...
        });
    }
}
```

Any behavior defined here can still be overridden on individual inputs as needed.

## Scripts

### Setup

For convenience, you can run the setup bin script for easy installation for local development.

```bash
./bin/setup.sh
```

### Build

Any time changes are made to the blade file, the `./bin/build.sh` script should be run so our css can be recompiled.

### Formatting

Although formatting is done automatically via workflow, you can format php code locally before committing with a composer script:

```bash
composer format
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [my security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

-   [Randall Wilk](https://github.com/rawilk)
-   [All Contributors](../../contributors)

## Alternatives

-   [papalardo/filament-password-input](https://github.com/papalardo/filament-password-input)
-   [phpsa/filament-password-reveal](https://github.com/phpsa/filament-password-reveal)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
