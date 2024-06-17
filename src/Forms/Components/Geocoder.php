<?php

namespace Peniti\FilamentMapbox\Forms\Components;

use Closure;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Field;
use Illuminate\Support\Arr;

class Geocoder extends Field
{
    use HasPlaceholder;

    protected string $view = 'filament-mapbox::forms.components.geocoder';

    protected string|Closure|null $countries = null;

    public function getAccessToken(): string
    {
        return config('filament-mapbox.mapbox.access_token');
    }

    public function country(string|Closure $country): static
    {
        return $this->countries($country);
    }

    /**  @param  string|array<string>|Closure  $countries */
    public function countries(string|array|Closure $countries): static
    {
        $this->countries = implode(', ', Arr::wrap($countries));

        return $this;
    }

    public function getCountries(): ?string
    {
        return $this->evaluate($this->countries);
    }
}
