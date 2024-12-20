<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-heading heading="FOLLOWER REGISTRATION" subheading="Follower Registration Form" />
                <x-form-success message="{{ session('success') }}" />
                <form method="POST" action="{{ route('follower.register') }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                        
                        <x-form-text-input-section size="sm:col-span-2" name="name" id="name" label="Full Name" />
                        <x-form-text-input-section size="sm:col-span-2" name="addressLine1" id="addressLine1" label="Address Line 1" />
                        <x-form-text-input-section size="sm:col-span-2" name="addressLine2" id="addressLine2" label="Address Line 2" />
                        <x-form-text-input-section size="sm:col-span-2" name="addressLine3" id="addressLine3" label="Address Line 3" />
                        <x-form-list-input-section size="sm:col-span-1" name="district" id="district" :options="$districts" label="District" />
                        <x-form-text-input-section size="sm:col-span-1" name="mobile1" id="mobile1" label="Mobile" />
                        <x-form-text-input-section size="sm:col-span-1" name="mobile2" id="mobile2" label="Whatapp" />
                        <x-form-list-input-section size="sm:col-span-1" name="race" id="race" :options="$races" label="Race" />
                        <x-form-list-input-section size="sm:col-span-1" name="religion" id="religion" :options="$religions" label="Birth Religion" />
                        <x-form-list-input-section size="sm:col-span-1" name="civilStatus" id="civilStatus" :options="$civilStatuses" label="Civil Status" />
                        <x-form-list-input-section size="sm:col-span-1" name="monastery" id="monastery" :options="$monasteries" label="Nearest Mahamewnawa Monastery" />
                        @livewire('formFollowerNic')
                        @livewire('formFollowerEmail')
                        
                        <x-form-date-input-section size="sm:col-span-1" name="birthDay" id="birthDay" label="Birth Day" />
                    </div>
                    <div class="mt-10">
                        <x-form-button-primary size="" text="Register" modelBinding=""/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>