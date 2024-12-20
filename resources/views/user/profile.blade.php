<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-profile-heading heading="{{ $user->nameWithInitials }}" subHeading="{{ $user->nic }}" />
                <div class="border-t border-gray-200">
                    @livewire('user-profile',
                    [
                        'id' => $user->id,
                        'name' => $user->userName,
                        'nameWithInitials' => $user->nameWithInitials,
                        'nic' => $user->nic,
                        'email' => $user->email,
                        'race' => $user->race,
                        'religion' => $user->religion,
                        'civilStatus' => $user->civilStatus,
                        'birthDay' => $user->birthDay,
                        'gender' => $user->gender,
                        'addressLine1' => $user->addressLine1,
                        'addressLine2' => $user->addressLine2,
                        'addressLine3' => $user->addressLine3,
                        'mobile1' => $user->mobile1,
                        'mobile2' => $user->mobile2,
                        'appointment' => $appointment,
                        'position' => $position,
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>