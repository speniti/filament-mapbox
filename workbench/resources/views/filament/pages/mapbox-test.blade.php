<x-filament-panels::page>
  <form wire:submit.prevent="save" class="w-full max-w-md mx-auto">
    {{ $this->form }}

    <x-filament::button class="mt-6 w-full" type="submit">
      Save
    </x-filament::button>
  </form>
</x-filament-panels::page>
