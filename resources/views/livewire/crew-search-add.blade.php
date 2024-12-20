<div class="{{ $size }}">
    <div class="mt-2.5 px-4">
        <x-form-text-input-field wire:model.live="search" id="search" name="search" autofocus/>
    </div>
    @if(session('error'))
    <div class="alert alert-danger px-4">
        {{ session('error') }}
    </div>
@endif
    @if (!empty($searchResults))
    <ul role="list" class="divide-y divide-gray-100 px-4">
        @foreach ($searchResults as $crew)
            <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                    <p class="text-sm font-semibold leading-6">{{ $crew->name }}</p>
                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $crew->nic }}</p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    @if ($crew->added == 1)
                        <x-form-button-danger size="" text="Remove" modelBinding="click" name="removeCrew" :parameters="[$crew->crewId, $crew->categoryId]" />
                    @else
                        <x-form-button-success size="" text="Add" modelBinding="click" name="addCrew" :parameters="[$crew->crewId, $crew->categoryId]" />
                    @endif
                    
                </div>
            </li>
        @endforeach
    </ul>
    @endif
</div>
