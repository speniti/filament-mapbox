<?php

/** @noinspection PhpIllegalPsrClassPathInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

namespace Tests\Feature\Forms\Fields;

use App\Filament\Pages\GeocoderTest;
use Exception;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Peniti\FilamentMapbox\Forms\Fields\Geocoder;
use Peniti\FilamentMapbox\Geocoder\AddressInfo;
use Peniti\FilamentMapbox\Geocoder\FeatureType;

use function Pest\Livewire\livewire;

describe(Geocoder::class, static function () {
    it('is visible', function () {
        livewire(GeocoderTest::class)
            ->assertFormFieldExists('address', 'form');
    });

    it('works with strings', function () {
        $testable = livewire(GeocoderTest::class);

        $testable->assertSetStrict('address', fn (string $value) => empty($value));
        $testable->fillForm(['address' => $address = fake()->address()]);
        $testable->assertSetStrict('address', fn (string $value) => $value === $address);

        $testable->assertSetStrict('data', fn (array $value) => empty($value));
        $testable->call('save');
        $testable->assertSetStrict('data', fn (array $value) => $value['address'] === $address);
    });

    it('works with AddressInfo', function () {
        $testable = livewire(GeocoderTest::class);

        $testable->assertSetStrict('addressInfo', fn (AddressInfo $value) => $value->isEmpty());
        $testable->fillForm(['addressInfo' => $addressInfo = new AddressInfo(fake()->address())]);
        $testable->assertSetStrict('addressInfo', fn (AddressInfo $value) => $value->eq($addressInfo));

        $testable->assertSetStrict('data', fn (array $value) => empty($value));
        $testable->call('save');

        $testable->assertSetStrict('data', function (array $value) use ($addressInfo) {
            assert($value['addressInfo'] instanceof AddressInfo);

            return $value['addressInfo']->eq($addressInfo);
        });

        $testable->assertSet('addressInfo', function (AddressInfo $value) use ($addressInfo) {
            assert($value instanceof AddressInfo);

            return $value->eq($addressInfo);
        });
    });

    it('works with arrays', function () {
        $testable = livewire(GeocoderTest::class);

        $testable->assertSetStrict('addressInfoArray', fn (array $value) => empty($value));
        $testable->fillForm(['addressInfoArray' => $addressInfoArray = ['placeName' => fake()->address()]]);
        $testable->assertSetStrict('addressInfoArray', fn (array $value) => empty(array_diff($value, $addressInfoArray)));

        $testable->assertSetStrict('data', fn (array $value) => empty($value));
        $testable->call('save');
        $testable->assertSetStrict('data', function (array $value) use ($addressInfoArray) {
            assert(is_array($value['addressInfoArray']));

            return empty(array_diff($value['addressInfoArray'], $addressInfoArray));
        });
    });

    it('clears when the esc key is pressed', function () {
        livewire(GeocoderClearAndBlurOnEsc::class)
            ->assertSee('\u0022clearAndBlurOnEsc\u0022:true,');
    });

    it('limits results to a specified country or countries', function () {
        livewire(GeocoderCountries::class)
            ->assertSee("\u0022countries\u0022:\u0022IT", escape: false);
    });

    it('attempts approximate, as well as exact, matching', function () {
        livewire(GeocoderFuzzyMatch::class)
            ->assertSee('\u0022fuzzyMatch\u0022:true');
    });

    it('limits the number of results returned', function () {
        livewire(GeocoderLimit::class)
            ->assertSee('\u0022limit\u0022:10');
    });

    it('set the minimum number of characters required to trigger a search', function () {
        livewire(GeocoderMinLength::class)
            ->assertSee('\u0022minLength\u0022:3');
    });

    it('filters results to match specified types', function () {
        livewire(GeocoderTypes::class)
            ->assertSee("\u0022types\u0022:\u0022country, region\u0022", escape: false);
    });

    it('can be required', function () {
        $testable = livewire(GeocoderRequired::class);

        $testable->assertSetStrict('address', fn (string $value) => empty($value));
        $testable->call('save');
        $testable->assertHasFormErrors(['address' => 'required']);
    });
});

final class GeocoderClearAndBlurOnEsc extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected string $view = 'filament.pages.mapbox-test';

    /** @throws Exception */
    public function form(Schema $form): Schema
    {
        return $form->components([
            Geocoder::make('address')->clearAndBlurOnEsc(),
        ]);
    }
}

final class GeocoderCountries extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected string $view = 'filament.pages.mapbox-test';

    /** @throws Exception */
    public function form(Schema $form): Schema
    {
        return $form->components([
            Geocoder::make('address')->countries('IT, US'),
        ]);
    }
}

final class GeocoderFuzzyMatch extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected string $view = 'filament.pages.mapbox-test';

    /** @throws Exception */
    public function form(Schema $form): Schema
    {
        return $form->components([
            Geocoder::make('address')->fuzzyMatch(),
        ]);
    }
}

final class GeocoderLimit extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected string $view = 'filament.pages.mapbox-test';

    /** @throws Exception */
    public function form(Schema $form): Schema
    {
        return $form->components([
            Geocoder::make('address')->limit(10),
        ]);
    }
}

final class GeocoderMinLength extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected string $view = 'filament.pages.mapbox-test';

    /** @throws Exception */
    public function form(Schema $form): Schema
    {
        return $form->components([
            Geocoder::make('address')->minLength(3),
        ]);
    }
}

final class GeocoderTypes extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected string $view = 'filament.pages.mapbox-test';

    /** @throws Exception */
    public function form(Schema $form): Schema
    {
        return $form->components([
            Geocoder::make('address')->types([FeatureType::Country, FeatureType::Region]),
        ]);
    }
}

/** @property Schema $form */
final class GeocoderRequired extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected string $view = 'filament.pages.mapbox-test';

    /** @throws Exception */
    public function form(Schema $form): Schema
    {
        return $form->components([
            Geocoder::make('address')->required(),
        ]);
    }

    public function save(): void
    {
        $this->form->getState();
    }
}
