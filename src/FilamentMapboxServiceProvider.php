<?php

declare(strict_types=1);

namespace Peniti\FilamentMapbox;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Livewire\Livewire;
use Peniti\FilamentMapbox\Geocoder\AddressInfoSynth;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class FilamentMapboxServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-mapbox')
            ->hasConfigFile()
            ->hasViews();
    }

    public function packageBooted(): void
    {
        Livewire::propertySynthesizer(AddressInfoSynth::class);

        FilamentAsset::register([
            AlpineComponent::make('geocoder', $this->package->basePath('/../dist/components/geocoder.js')),
            Css::make('geocoder', $this->package->basePath('/../dist/components/geocoder.css')),

            Css::make(
                'filament-mapbox',
                $this->package->basePath('/../dist/filament-mapbox.css')
            ),
        ], 'speniti/filament-mapbox');
    }
}
