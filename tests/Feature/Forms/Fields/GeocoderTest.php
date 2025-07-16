<?php

/** @noinspection PhpIllegalPsrClassPathInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

namespace Tests\Feature\Forms\Fields;

use App\Filament\Pages\GeocoderTest;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Peniti\FilamentMapbox\Forms\Fields\Geocoder;
use Peniti\FilamentMapbox\Geocoder\AddressInfo;
use Peniti\FilamentMapbox\Geocoder\FeatureType;

use function Pest\Livewire\livewire;

describe(Geocoder::class, static function () {
    it('is visible', function () {
        livewire(GeocoderTest::class)
            ->assertFormFieldExists('address');
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

            return $addressInfo->eq($value['addressInfo']);
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
            ->assertSee('clearAndBlurOnEsc: true,');
    });

    it('limits results to a specified country or countries', function () {
        livewire(GeocoderCountries::class)
            ->assertSee("countries: 'IT, US',", escape: false);
    });

    it('attempts approximate, as well as exact, matching', function () {
        livewire(GeocoderFuzzyMatch::class)
            ->assertSee('fuzzyMatch: true,');
    });

    it('limits the number of results returned', function () {
        livewire(GeocoderLimit::class)
            ->assertSee('limit: 10,');
    });

    it('set the minimum number of characters required to trigger a search', function () {
        livewire(GeocoderMinLength::class)
            ->assertSee('minLength: 3,');
    });

    it('filters results to match specified types', function () {
        livewire(GeocoderTypes::class)
            ->assertSee("types: 'country, region',", escape: false);
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
    protected static string $view = 'filament.pages.mapbox-test';

    public function form(Form $form): Form
    {
        return $form->schema([
            Geocoder::make('address')->clearAndBlurOnEsc(),
        ]);
    }
}

final class GeocoderCountries extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected static string $view = 'filament.pages.mapbox-test';

    public function form(Form $form): Form
    {
        return $form->schema([
            Geocoder::make('address')->countries('IT, US'),
        ]);
    }
}

final class GeocoderFuzzyMatch extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected static string $view = 'filament.pages.mapbox-test';

    public function form(Form $form): Form
    {
        return $form->schema([
            Geocoder::make('address')->fuzzyMatch(),
        ]);
    }
}

final class GeocoderLimit extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected static string $view = 'filament.pages.mapbox-test';

    public function form(Form $form): Form
    {
        return $form->schema([
            Geocoder::make('address')->limit(10),
        ]);
    }
}

final class GeocoderMinLength extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected static string $view = 'filament.pages.mapbox-test';

    public function form(Form $form): Form
    {
        return $form->schema([
            Geocoder::make('address')->minLength(3),
        ]);
    }
}

final class GeocoderTypes extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected static string $view = 'filament.pages.mapbox-test';

    public function form(Form $form): Form
    {
        return $form->schema([
            Geocoder::make('address')->types([FeatureType::Country, FeatureType::Region]),
        ]);
    }
}

/** @property Form $form */
final class GeocoderRequired extends Page
{
    public string $address = '';

    /** @noinspection LaravelUnknownViewInspection */
    protected static string $view = 'filament.pages.mapbox-test';

    public function form(Form $form): Form
    {
        return $form->schema([
            Geocoder::make('address')->required(),
        ]);
    }

    public function save(): void
    {
        $this->form->getState();
    }
}
