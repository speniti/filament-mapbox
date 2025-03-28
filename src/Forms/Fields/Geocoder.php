<?php

/** @noinspection ClassMethodNameMatchesFieldNameInspection */

declare(strict_types=1);

namespace Peniti\FilamentMapbox\Forms\Fields;

use Closure;
use Filament\Forms\Components\Concerns\CanBeDisabled;
use Filament\Forms\Components\Concerns\HasAffixes;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Field;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use League\ISO3166\Exception\DomainException;
use League\ISO3166\ISO3166;
use Peniti\FilamentMapbox\Geocoder\FeatureType;

final class Geocoder extends Field
{
    use CanBeDisabled;
    use HasAffixes;
    use HasPlaceholder;

    private bool|Closure|null $clearAndBlurOnEsc = null;

    private string|Closure|null $countries = null;

    private bool|Closure|null $fuzzyMatch = null;

    private int|Closure|null $limit = null;

    private int|Closure|null $minLength = null;

    private string|Closure $types = FeatureType::Address->value;

    protected function setUp(): void
    {
        parent::setUp();

        $this->view('filament-mapbox::forms.components.geocoder');
    }

    /** @param bool|Closure(mixed...):bool $clearAndBlurOnEsc */
    public function clearAndBlurOnEsc(bool|Closure $clearAndBlurOnEsc = true): self
    {
        $this->clearAndBlurOnEsc = $clearAndBlurOnEsc;

        return $this;
    }

    /** @param  string|list<string>|Closure(mixed...):string  $countries */
    public function countries(string|array|Closure $countries): self
    {
        if ($countries instanceof Closure) {
            $this->countries = $countries;

            return $this;
        }

        if (is_string($countries)) {
            $countries = explode(', ', $countries);
        }

        /** @var Collection<int, string> $collection */
        $collection = collect($countries);

        $this->countries = $collection
            ->map($this->normalizeCountry(...))
            ->join(', ');

        return $this;
    }

    /** @param string|Closure(mixed...):string $country */
    public function country(string|Closure $country): self
    {
        return $this->countries($country);
    }

    /** @param bool|Closure(mixed...):bool $fuzzyMatch */
    public function fuzzyMatch(bool|Closure $fuzzyMatch = true): self
    {
        $this->fuzzyMatch = $fuzzyMatch;

        return $this;
    }

    public function getAccessToken(): string
    {
        $token = config('filament-mapbox.mapbox.access_token', '');

        assert(is_string($token) || is_null($token));

        return $token ?? '';
    }

    public function getClearAndBlurOnEsc(): ?bool
    {
        $clearAndBlurOnEsc = $this->evaluate($this->clearAndBlurOnEsc);

        assert(is_bool($clearAndBlurOnEsc) || is_null($clearAndBlurOnEsc));

        return $clearAndBlurOnEsc;
    }

    public function getCountries(): ?string
    {
        $countries = $this->evaluate($this->countries);

        assert(is_string($countries) || is_null($countries));

        return $countries;
    }

    public function getFuzzyMatch(): ?bool
    {
        $fuzzyMatch = $this->evaluate($this->fuzzyMatch);

        assert(is_bool($fuzzyMatch) || is_null($fuzzyMatch));

        return $fuzzyMatch;
    }

    public function getLimit(): ?int
    {
        $limit = $this->evaluate($this->limit);

        assert(is_int($limit) || is_null($limit));

        return $limit;
    }

    public function getMinLength(): ?int
    {
        $minLength = $this->evaluate($this->minLength);

        assert(is_int($minLength) || is_null($minLength));

        return $minLength;
    }

    public function getTypes(): string
    {
        $types = $this->evaluate($this->types);

        assert(is_string($types));

        return $types;
    }

    /** @param int|Closure(mixed...):int $limit */
    public function limit(int|Closure $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /** @param int|Closure(mixed...):int $minLength */
    public function minLength(int|Closure $minLength): self
    {
        $this->minLength = $minLength;

        return $this;
    }

    /** @param  FeatureType|list<FeatureType>|Closure(mixed...):string  $types */
    public function types(FeatureType|array|Closure $types): self
    {
        if ($types instanceof Closure) {
            $this->types = $types;

            return $this;
        }

        /** @var Collection<int, FeatureType> $collection */
        $collection = collect(Arr::wrap($types));

        $this->types = $collection
            ->map($this->normalizeType(...))
            ->join(', ');

        return $this;
    }

    /** @throws DomainException if input does not look like an ISO3166 alpha2 key */
    private function normalizeCountry(string $country): string
    {
        return new ISO3166()->alpha2($country)[ISO3166::KEY_ALPHA2];
    }

    private function normalizeType(FeatureType $type): string
    {
        return $type->value;
    }
}
