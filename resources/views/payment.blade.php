<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />
  <div>
    <div class="mx-auto sm:px-6 lg:px-8">
          
      <div class="isolate bg-white px-6 py-4 lg:px-8">
        <h3 class="text-center text-2xl font-bold">Payment</h3>
        <x-form-success message="{{ session('success') }}" />
        <x-form-error message="{{ session('error') }}" />
          <form method="POST" action="{{ route('payment_create') }}" class="mx-auto mt-8 max-w-xl sm:mt-8 border p-5 rounded-md" enctype="multipart/form-data">
              @csrf
              <div class="grid grid-cols-1 gap-x-8 gap-y-2 sm:grid-cols-2">
                
                <x-form-text-input-section size="sm:col-span-2" name="nic" id="nic" label="NIC" value="{{ old('nic') }}"/>
                <x-form-list-input-section size="sm:col-span-2" name="project" id="project" label="Project" :options="$projects" value="{{ old('project') }}"/>
                <x-form-list-input-section size="sm:col-span-2" name="payment_method" id="payment_method" label="Payment Method" :options="$paymentMethod" value="{{ old('payment_method') }}"/>
                <x-form-number-input-section size="sm:col-span-2" name="amount" id="amount" label="Amount"  value="{{ old('amount') }}"/>
                <x-form-text-input-section size="sm:col-span-2" name="reciptNo" id="reciptNo" label="Slip No" value="{{ old('reciptNo') }}"/>
                <x-form-file-input-section size="sm:col-span-2" name="reciptImage" id="reciptImage" label="Slip Image" value="{{ old('reciptImage') }}"/>
                <x-form-date-input-section size="sm:col-span-2" name="addedDate" id="addedDate" label="Date" value="{{ old('addedDate') }}"/>
              </div>
              <div class="mt-2">
                  <x-form-button-success size="" text="Submit" modelBinding=""/>
              </div>
          </form>
      </div>

    </div>
  </div>
</x-guest-layout>