<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-heading heading="DAMBADIWA PROJECT REGISTRATION" subheading="Dambadiwa Registration Form" />
                <x-form-success message="{{ session('success') }}" />
                <form method="POST" action="{{ route('dambadiwa.register') }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                        
                        <x-form-text-input-section size="sm:col-span-2" name="name" id="name" label="Projects Name" />
                        <x-form-date-input-section size="sm:col-span-1" name="startDate" id="startDate" label="Start Date" />
                        <x-form-date-input-section size="sm:col-span-1" name="endDate" id="endDate" label="End Date" />
                    </div>
                    <div class="mt-10">
                        <x-form-button-primary size="" text="Register" modelBinding=""/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>