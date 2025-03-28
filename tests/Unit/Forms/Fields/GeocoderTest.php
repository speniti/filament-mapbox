<?php

/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

use Peniti\FilamentMapbox\Forms\Fields\Geocoder;
use Peniti\FilamentMapbox\Geocoder\FeatureType;

describe(Geocoder::class, static function () {
    it('clears when the esc key is pressed', function (bool|Closure $input, bool $expected) {
        $field = Geocoder::make('address')->clearAndBlurOnEsc($input);
        expect($field->getClearAndBlurOnEsc())->toBe($expected);
    })->with([
        'true' => [true, true],
        'false' => [false, false],
        'callable:true' => [fn () => fn () => true, true],
        'callable:false' => [fn () => fn () => false, false],
    ]);

    it('limits results to a specified country', function (string|Closure $input, string $expected) {
        $field = Geocoder::make('address')->country($input);
        expect($field->getCountries())->toBe($expected);
    })->with([
        'string' => ['US', 'US'],
        'callable' => [fn () => fn () => 'IT', 'IT'],
    ]);

    it('limits results to a specified countries', function (string|array|Closure $input, string $expected) {
        /** @var string|list<string>|Closure $input */
        $field = Geocoder::make('address')->countries($input);
        expect($field->getCountries())->toBe($expected);
    })->with([
        'string:single' => ['US', 'US'],
        'string:multiple' => ['it, US', 'IT, US'],
        'array' => [['IT', 'us'], 'IT, US'],
        'callable:single' => [fn () => fn () => 'IT', 'IT'],
        'callable:multiple' => [fn () => fn () => 'IT, US', 'IT, US'],
    ]);

    it('validates that countries are valid ISO3166 alpha2 key if string or array are provided', function (string|array $input) {
        /** @var string|list<string> $input */
        Geocoder::make('address')->countries($input);
    })->with([
        'string:single' => ['not-a-valid-ISO3166-alpha2-key'],
        'string:multiple' => ['not-a-valid-ISO3166-alpha2-key, not-a-valid-ISO3166-alpha2-key'],
        'array' => [['not-a-valid-ISO3166-alpha2-key', 'not-a-valid-ISO3166-alpha2-key']],
    ])->throws(DomainException::class, 'Not a valid alpha2 key: ');

    it('does not validate that countries are valid ISO3166 alpha2 key if a Closure is provided', function (Closure $input) {
        /** @var Closure(mixed...):string $input */
        Geocoder::make('address')->countries($input);
    })->with([
        'callable:single' => [fn () => fn () => 'not-a-valid-ISO3166-alpha2-key'],
        'callable:multiple' => [fn () => fn () => 'not-a-valid-ISO3166-alpha2-key, not-a-valid-ISO3166-alpha2-key'],
    ])->throwsNoExceptions();

    it('attempts approximate, as well as exact, matching', function (bool|Closure $input, bool $expected) {
        $field = Geocoder::make('address')->fuzzyMatch($input);
        expect($field->getFuzzyMatch())->toBe($expected);
    })->with([
        'true' => [true, true],
        'false' => [false, false],
        'callable:true' => [fn () => fn () => true, true],
        'callable:false' => [fn () => fn () => false, false],
    ]);

    it('limits the number of results returned', function (int|Closure $input, int $expected) {
        $field = Geocoder::make('address')->limit($input);
        expect($field->getLimit())->toBe($expected);
    })->with([
        'int' => [10, 10],
        'callable:int' => [fn () => fn () => 10, 10],
    ]);

    it('set the minimum number of characters required to trigger a search', function (int|Closure $input, int $expected) {
        $field = Geocoder::make('address')->minLength($input);
        expect($field->getMinLength())->toBe($expected);
    })->with([
        'int' => [3, 3],
        'callable:int' => [fn () => fn () => 3, 3],
    ]);

    it('filters results to match specified types', function (FeatureType|array|Closure $input, string $expected) {
        /** @var FeatureType|list<FeatureType>|Closure $input */
        $field = Geocoder::make('address')->types($input);
        expect($field->getTypes())->toBe($expected);
    })->with([
        'single' => [FeatureType::Country, FeatureType::Country->value],
        'multiple' => [[FeatureType::Country, FeatureType::Region], sprintf('%s, %s', FeatureType::Country->value, FeatureType::Region->value)],
        'callable' => [fn () => fn () => FeatureType::Country->value, FeatureType::Country->value],
    ]);
});
