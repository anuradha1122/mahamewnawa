<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-heading heading="USER REGISTRATION" subheading="User Registration Form" />
                <x-form-success message="{{ session('success') }}" />
                <form method="POST" action="{{ route('user.register') }}" class="mx-auto mt-8 max-w-7xl sm:mt-8" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                        
                        <x-form-text-input-section size="sm:col-span-2" name="name" id="name" label="Full Name" value="{{ old('name') }}"/>
                        <x-form-text-input-section size="sm:col-span-2" name="addressLine1" id="addressLine1" label="Address Line 1" value="{{ old('addressLine1') }}"/>
                        <x-form-text-input-section size="sm:col-span-2" name="addressLine2" id="addressLine2" label="Address Line 2" value="{{ old('addressLine2') }}"/>
                        <x-form-text-input-section size="sm:col-span-2" name="addressLine3" id="addressLine3" label="Address Line 3" value="{{ old('addressLine3') }}"/>
                        <x-form-text-input-section size="sm:col-span-1" name="mobile1" id="mobile1" label="Mobile" value="{{ old('mobile1') }}"/>
                        <x-form-text-input-section size="sm:col-span-1" name="mobile2" id="mobile2" label="Whatapp" value="{{ old('mobile2') }}"/>
                        <x-form-list-input-section size="sm:col-span-1" name="race" id="race" :options="$races" label="Race" value="{{ old('race') }}"/>
                        <x-form-list-input-section size="sm:col-span-1" name="religion" id="religion" :options="$religions" label="Birth Religion" value="{{ old('religion') }}"/>
                        <x-form-list-input-section size="sm:col-span-1" name="civilStatus" id="civilStatus" :options="$civilStatuses" label="Civil Status" value="{{ old('civilStatus') }}"/>
                        <x-form-list-input-section size="sm:col-span-1" name="monastery" id="monastery" :options="$monasteries" label="Current Monastery" value="{{ old('monastery') }}"/>
                        <x-form-list-input-section size="sm:col-span-1" name="position" id="position" :options="$positions" label="Current Position" value="{{ old('position') }}"/>
                        <x-form-date-input-section size="sm:col-span-1" name="startDate" id="startDate" label="Start Date" value="{{ old('startDate') }}"/>
                        <x-form-list-input-section size="sm:col-span-1" name="category" id="category" :options="$userCategories" label="User Category" value="{{ old('category') }}"/>
                        @livewire('formUserNic')
                        @livewire('formUserEmail')
                        
                        <x-form-date-input-section size="sm:col-span-1" name="birthDay" id="birthDay" label="Birth Day" value="{{ old('birthDay') }}"/>
                    </div>
                    <div class="mt-10">
                        <x-form-button-primary size="" text="Register" modelBinding=""/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>