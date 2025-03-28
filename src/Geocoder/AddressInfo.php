<?php

declare(strict_types=1);

namespace Peniti\FilamentMapbox\Geocoder;

use Illuminate\Contracts\Support\Arrayable;
use Stringable;

/**
 * @phpstan-type AddressInfoArray array{placeName: string, coords: list<int>, ...<string, string|null>}
 *
 * @implements Arrayable<string, string|list<int>>
 */
final readonly class AddressInfo implements Arrayable, Stringable
{
    /** @param list<int>|null $coords */
    public function __construct(
        public string $placeName = '',
        public ?string $address = null,
        public ?string $houseNumber = null,
        public ?string $street = null,
        public ?string $postcode = null,
        public ?string $place = null,
        public ?string $region = null,
        public ?string $country = null,
        public ?array $coords = null,
    ) {}

    public function __toString(): string
    {
        return $this->placeName;
    }

    public function eq(self $addressInfo): bool
    {
        return (string) $addressInfo === (string) $this;
    }

    public function isEmpty(): bool
    {
        return empty((string) $this);
    }

    public function toArray(): array
    {
        return array_filter([
            'placeName' => $this->placeName,
            'address' => $this->address,
            'houseNumber' => $this->houseNumber,
            'street' => $this->street,
            'postcode' => $this->postcode,
            'place' => $this->place,
            'region' => $this->region,
            'country' => $this->country,
            'coords' => $this->coords,
        ]);
    }
}
