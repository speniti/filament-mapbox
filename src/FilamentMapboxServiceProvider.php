<?php

namespace Peniti\FilamentMapbox;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentMapboxServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-mapbox')
            ->hasConfigFile()
            ->hasViews();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            AlpineComponent::make('mapbox', $this->package->basePath('/../dist/mapbox.js')),
            Css::make('mapbox', $this->package->basePath('/../dist/mapbox.css')),

            Css::make(
                'filament-mapbox',
                $this->package->basePath('/../dist/filament-mapbox.css')
            ),
        ], 'speniti/filament-mapbox');
    }
}
