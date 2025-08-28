<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */

declare(strict_types=1);

namespace App\Filament\Pages;

use Exception;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Peniti\FilamentMapbox\Forms\Fields\Geocoder;
use Peniti\FilamentMapbox\Geocoder\AddressInfo;

final class GeocoderTest extends Page
{
    public string $address = '';

    public AddressInfo $addressInfo;

    /** @var array<mixed> */
    public array $addressInfoArray = [];

    /** @var array<mixed> */
    public array $data = [];

    protected static bool $shouldRegisterNavigation = false;

    /** @noinspection LaravelUnknownViewInspection */
    protected string $view = 'filament.pages.mapbox-test';

    /** @throws Exception */
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Geocoder::make('address'),
            Geocoder::make('addressInfo'),
            Geocoder::make('addressInfoArray'),
        ])->statePath('');
    }

    public function mount(): void
    {
        $this->addressInfo = new AddressInfo();
    }

    public function save(): void
    {
        $this->data = $this->form->getState();
    }
}
