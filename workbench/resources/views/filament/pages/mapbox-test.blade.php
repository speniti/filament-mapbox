<x-filament-panels::page>
  <form wire:submit.prevent="save" style="width: 100%; max-width: 28rem; margin-inline: auto;">
    {{ $this->form }}

    <x-filament::button style="width: 100%; margin-top: 1.5rem;" type="submit">
      Save
    </x-filament::button>
  </form>
</x-filament-panels::page>
