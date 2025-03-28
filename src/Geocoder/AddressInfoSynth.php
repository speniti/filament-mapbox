<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */

declare(strict_types=1);

namespace Peniti\FilamentMapbox\Geocoder;

use Illuminate\Support\Arr;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

/** @phpstan-import-type AddressInfoArray from AddressInfo */
final class AddressInfoSynth extends Synth
{
    public static string $key = 'addressInfo';

    /** @param mixed $target */
    public static function match($target): bool
    {
        return $target instanceof AddressInfo;
    }

    /** @return array{0: array<mixed>, 1: array{}} */
    public function dehydrate(AddressInfo $target): array
    {
        return [$target->toArray(), []];
    }

    /** @param array<string, mixed> $value */
    public function hydrate(array $value): AddressInfo
    {
        /** @var AddressInfoArray $value */
        $value = Arr::only($value, [
            'placeName', 'address', 'houseNumber', 'street',
            'postcode', 'place', 'region', 'country', 'coords',
        ]);

        return new AddressInfo(...$value);
    }

    /** @param  string|list<int>|null  $value */
    public function set(AddressInfo &$target, string $key, array|string|null $value): void
    {
        match ($key) {
            'placeName' => assert(is_string($value)),
            'coords' => assert(is_array($value) || is_null($value)),
            default => assert(is_string($value) || is_null($value)),
        };

        /** @var AddressInfoArray $info */
        $info = [...$target->toArray(), ...[$key => $value]];

        $target = new AddressInfo(...$info);
    }

    public function unset(AddressInfo &$target, string $key): void
    {
        /** @var AddressInfoArray $info */
        $info = [...$target->toArray(), ...[$key => null]];

        $target = new AddressInfo(...$info);
    }
}
