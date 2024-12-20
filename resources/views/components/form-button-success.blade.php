<button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 {{ $size }}"
@if($modelBinding == 'click')
    wire:click="{{ $name }}({{ json_encode($parameters) }})"
@endif
>
    {{ $text }}
</button>