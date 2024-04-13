<?php

namespace MagisSolutions\FilamentTreeSelect;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTreeSelectServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-tree-select';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasViews();
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            [
                AlpineComponent::make('filament-tree-select', __DIR__ . '/../resources/dist/filament-tree-select.js'),
            ],
            'magissolutions/filament-tree-select'
        );
    }
}
