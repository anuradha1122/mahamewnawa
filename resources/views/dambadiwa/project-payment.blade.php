<x-app-layout>
  <div class="py-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          
      <div class="isolate bg-white px-6 py-4 lg:px-8">
        <x-breadcrumb :list="$option" />
        <x-form-heading heading="DAMBADIWA PROJECT PAYMENT" subheading="{{ $project->name }}" />
        <x-form-success message="{{ session('success') }}" />
          <form method="POST" action="{{ route('dambadiwa.project_payment', ['projectId'=>$projectId,'crewId'=>$crew_id,'categoryId'=>$categoryId,'nic'=>$nic]) }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
              @csrf
              <div class="grid grid-cols-1 gap-x-8 gap-y-2 sm:grid-cols-2">
                  
                <x-form-number-input-section size="sm:col-span-2" name="amount" id="amount" label="Amount"  value="{{ old('amount') }}"/>
                <x-form-list-input-section size="sm:col-span-2" name="payment_method" id="payment_method" label="Payment Method" :options="$paymentMethod" value="{{ old('payment_method') }}"/>
                <x-form-text-input-section size="sm:col-span-2" name="reciptNo" id="reciptNo" label="Receipt No" value="{{ old('reciptNo') }}"/>
                <x-form-file-input-section size="sm:col-span-2" name="reciptImage" id="reciptImage" label="Receipt Image" value="{{ old('reciptImage') }}"/>
                <x-form-date-input-section size="sm:col-span-2" name="addedDate" id="addedDate" label="Date" value="{{ old('addedDate') }}"/>
              </div>
              <div class="mt-2">
                  <x-form-button-success size="" text="Submit" modelBinding=""/>
              </div>
          </form>

          <div class=my-5>
            <table class="min-w-full divide-y divide-gray-200 border">
              <thead>
                <tr>
                  <th class="border">Payment Method</th>
                  <th class="border">Amount</th>
                  <th class="border">Slip No</th>
                  <th class="border">Receipt</th>
                  <th class="border">Date</th>
                  <th class="border">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($project_payments as $key => $project_payment)
                  @php
                    if($project_payment->payment_method == 1){
                      $paymentMethod = 'Bank';
                    }
                    else{
                      $paymentMethod = 'Cash';
                    }
                  @endphp
                  <tr>
                    <td class="px-6 py-2 border">{{ $paymentMethod }}</td>
                    <td class="px-6 py-2 border">{{ $project_payment->amount }}</td>
                    <td class="px-6 py-2 border text-center"><a href="/attachments/payments/{{ $project_payment->reciptImage }}" class="text-blue-500" target="_blank">{{ $project_payment->reciptNo }}</a></td>
                    <td class="px-6 py-2 border text-center">
                      @if($project_payment->confirm_decline == 1)
                      <a href="{{ route('dambadiwa.payment_slip_pdf', ['projectId'=>$projectId,'crewId'=>$project_payment->crewId,'payment_id'=>$project_payment->id,'categoryId'=>$project_payment->categoryId]) }}" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-2 py-1" target="_blank">Download</a>
                      @else
                        <span class="text-red-500">Not Confirmed</span>
                      @endif
                    </td>
                    <td class="px-6 py-2 border">{{ $project_payment->addedDate }}</td>
                    <td class="px-6 py-2 border text-center">
                      @if($project_payment->confirm_decline == 0)
                      <a href="{{ route('dambadiwa.payment_confirm', ['payment_id'=>$project_payment->id]) }}" class="font-medium p-2 rounded-md bg-green-500 text-white hover:bg-green-900" onclick="return window.confirm('Are you sure you want to Confirm?');">Confirm</a>
                      <a href="{{ route('dambadiwa.payment_decline', ['payment_id'=>$project_payment->id]) }}" class="font-medium p-2 rounded-md bg-red-500 text-white hover:bg-red-900" onclick="return window.confirm('Are you sure you want to Confirm?');">Decline</a>
                      @elseif($project_payment->confirm_decline == 1)
                        <span class="text-green-500">Confirmed</span>
                      @else
                        <span class="text-red-500">Decline</span>
                      @endif
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
      </div>

    </div>
  </div>
</x-app-layout>