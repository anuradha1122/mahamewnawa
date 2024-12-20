<nav aria-label="breadcrumb" class="block w-full">
    <ol class="flex flex-wrap items-center w-full px-4 py-2 rounded-md bg-blue-gray-50 bg-opacity-60">
        @foreach ($list as $key => $item)
            @php
                $link = is_callable($item) ? $item() : route($item);
            @endphp
            <x-breadcrumb-item link="{{ $link }}" name="{{ $key }}" />
        @endforeach
    </ol>
</nav>