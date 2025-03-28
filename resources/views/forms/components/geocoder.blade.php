@php  use Filament\Support\Facades\FilamentAsset; @endphp

<x-dynamic-component
  :component="$getFieldWrapperView()"
  :field="$field"
>
  <x-filament::input.wrapper
    :disabled="$isDisabled()"
    :inline-prefix="$isPrefixInline()"
    :inline-suffix="$isSuffixInline()"
    :prefix="$getPrefixLabel()"
    :prefix-actions="$getPrefixActions()"
    :prefix-icon="$getPrefixIcon()"
    :prefix-icon-color="$getPrefixIconColor()"
    :suffix="$getSuffixLabel()"
    :suffix-actions="$getSuffixActions()"
    :suffix-icon="$getSuffixIcon()"
    :suffix-icon-color="$getSuffixIconColor()"
    :valid="! $errors->has($statePath)"
    :attributes="
      \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
          ->class(['fi-fo-geocoder-input'])
    "
  >
    <!--suppress RequiredAttributes -->
    <div
      ax-load
      ax-load-src="{{ FilamentAsset::getAlpineComponentSrc('geocoder', 'speniti/filament-mapbox') }}"
      x-data="geocoder($wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }}, {
        accessToken: @Js($getAccessToken()),
        clearAndBlurOnEsc: @js($getClearAndBlurOnEsc()),
        countries: @Js($getCountries()),
        fuzzyMatch: @Js($getFuzzyMatch()),
        limit: @Js($getLimit()),
        minLength: @Js($getMinLength()),
        placeholder: @Js($getPlaceholder()),
        types: @Js($getTypes()),
    }, @js($isDisabled()))"
      x-ignore
      wire:ignore
    ></div>
  </x-filament::input.wrapper>
</x-dynamic-component>
