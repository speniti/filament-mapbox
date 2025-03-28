<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Peniti\FilamentMapbox\Forms\Fields\Geocoder;
use Peniti\FilamentMapbox\Geocoder\AddressInfo;

/** @property Form $form */
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
    protected static string $view = 'filament.pages.mapbox-test';

    public function form(Form $form): Form
    {
        return $form->schema([
            Geocoder::make('address'),
            Geocoder::make('addressInfo'),
            Geocoder::make('addressInfoArray'),
        ]);
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
