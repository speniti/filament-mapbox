<?php

/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

use Peniti\FilamentMapbox\Geocoder\AddressInfo;

describe(AddressInfo::class, static function () {
    it('can be converted to array', function (array $expected) {
        expect(new AddressInfo(...$expected)->toArray())->toBe($expected);
    })->with([
        'empty' => [[]],
        'required' => [['placeName' => fake()->address()]],
        'complete' => [[
            'placeName' => fake()->address(),
            'address' => fake()->streetAddress(),
            'houseNumber' => fake()->buildingNumber(),
            'street' => fake()->streetName(),
            'postcode' => fake()->postcode(),
            'place' => fake()->city(),
            'region' => fake()->word(),
            'country' => fake()->country(),
            'coords' => [fake()->latitude(), fake()->longitude()],
        ]],
    ]);

    it('can be casted to string', function (array $input, string $expected) {
        expect((string) new AddressInfo(...$input))->toBe($expected);
    })->with([
        'empty' => [[], ''],
        'required' => [['placeName' => $place = fake()->address()], $place],
        'complete' => [[
            'placeName' => $place = fake()->address(),
            'address' => fake()->streetAddress(),
            'houseNumber' => fake()->buildingNumber(),
            'street' => fake()->streetName(),
            'postcode' => fake()->postcode(),
            'place' => fake()->city(),
            'region' => fake()->word(),
            'country' => fake()->country(),
            'coords' => [fake()->latitude(), fake()->longitude()],
        ], $place],
    ]);
});
