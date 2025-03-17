<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-profile-heading heading="{{ $crew->nameWithInitials }}" subHeading="{{ $crew->nic }}" />
                <div class="border-t border-gray-200">
                    {{-- @livewire('follower-profile',
                    [
                        'id' => $follower->id,
                        'name' => $follower->followerName,
                        'nameWithInitials' => $follower->nameWithInitials,
                        'nic' => $follower->nic,
                        'email' => $follower->email,
                        'race' => $follower->race,
                        'religion' => $follower->religion,
                        'civilStatus' => $follower->civilStatus,
                        'birthDay' => $follower->birthDay,
                        'gender' => $follower->gender,
                        'addressLine1' => $follower->addressLine1,
                        'addressLine2' => $follower->addressLine2,
                        'addressLine3' => $follower->addressLine3,
                        'mobile1' => $follower->mobile1,
                        'mobile2' => $follower->mobile2,
                    ]) --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>