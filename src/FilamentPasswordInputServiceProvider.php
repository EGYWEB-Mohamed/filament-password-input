<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class FilamentPasswordInputServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-password-input')
            ->hasViews()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register(
            assets: [
                Css::make('filament-password-input', __DIR__ . '/../resources/dist/app.css'),
            ],
            package: 'rawilk/filament-password-input',
        );
    }
}
