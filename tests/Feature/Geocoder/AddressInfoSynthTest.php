<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

use App\Filament\Pages\MapboxTest;
use Livewire\LivewireManager;
use Peniti\FilamentMapbox\Geocoder\AddressInfo;
use Peniti\FilamentMapbox\Geocoder\AddressInfoSynth;

use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

describe(AddressInfoSynth::class, static function () {
    it('hydrates and dehydrates values', function () {
        $addressInfo = new AddressInfo(fake()->address());
        $testable = livewire(MapboxTest::class);

        $testable->updateProperty('addressInfo', $addressInfo->toArray());
        $testable->assertSetStrict('addressInfo', fn (AddressInfo $value) => $addressInfo->eq($value));

        /** @var LivewireManager $livewire */
        $livewire = app('livewire');

        /** @var array<mixed> $snapshot */
        $snapshot = $livewire->snapshot($testable->instance());

        /** @var array<mixed> $data */
        $data = data_get($snapshot, 'data.addressInfo');

        assertContains($addressInfo->toArray(), $data);
    });

    it('set nested properties', function () {
        $testable = livewire(MapboxTest::class);
        $testable->updateProperty('addressInfo', new AddressInfo()->toArray());

        $testable->set('addressInfo.placeName', $address = fake()->address());
        $testable->set('addressInfo.houseNumber', '123');
        $testable->set('addressInfo.coords', [fake()->longitude(), fake()->latitude()]);

        assertEquals($address, $testable->get('addressInfo.placeName'));
    });

    it('unset nested properties', function () {
        $testable = livewire(MapboxTest::class);
        $testable->updateProperty(
            'addressInfo',
            new AddressInfo(fake()->address(), houseNumber: '123')
                ->toArray()
        );

        $testable->set('addressInfo.houseNumber', '__rm__');

        assertNull($testable->get('addressInfo.houseNumber'));
    });
});
