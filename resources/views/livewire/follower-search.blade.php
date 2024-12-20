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
        @foreach ($searchResults as $follower)
            <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                    <p class="text-sm font-semibold leading-6 @if ($follower->active == 0)text-red-500 @else text-gray-900 @endif">{{ $follower->name }}</p>
                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $follower->nic }}</p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    <a href="{{ route('follower.profile', ['id' => $follower->id ]) }}" class="mt-1 text-xs leading-5 text-gray-500">profile view</a>
                </div>
            </li>
        @endforeach
    </ul>
    @endif
</div>