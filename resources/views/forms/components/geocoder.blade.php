@php  use Filament\Support\Facades\FilamentAsset; @endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        ax-load
        ax-load-src="{{ FilamentAsset::getAlpineComponentSrc('mapbox', 'speniti/filament-mapbox') }}"
        x-data="geocoder($wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }}, {
            accessToken: @Js($getAccessToken()),
            placeholder: @Js($getPlaceholder()),
            countries: @Js($getCountries()),
        })"
        x-ignore
        wire:ignore
    ></div>
</x-dynamic-component>

