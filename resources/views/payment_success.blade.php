<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />
  <div>
    <div class="mx-auto sm:px-6 lg:px-8">
          
      <div class="isolate bg-white px-6 py-4 lg:px-8 border rounded-md ">
        <h3 class="text-center text-2xl text-green-500 font-bold py-3">Payment Success</h3>

        <table class="min-w-full">
          <tbody>
            <tr>
              <td class="px-6 py-2">Name</td>
              <td class="px-6 py-2">{{ $project_payments->nameWithInitials }}</td>
            </tr>
            <tr>
              <td class="px-6 py-2">NIC</td>
              <td class="px-6 py-2">{{ $project_payments->nic }}</td>
            </tr>
            <tr>
              <td class="px-6 py-2">Payment Method</td>
              <td class="px-6 py-2">Bank</td>
            </tr>
            <tr>
              <td class="px-6 py-2">Amount</td>
              <td class="px-6 py-2">Rs. {{ $project_payments->amount }}</td>
            </tr>
            <tr>
              <td class="px-6 py-2">Slip No</td>
              <td class="px-6 py-2">{{ $project_payments->reciptNo }}</td>
            </tr>
            <tr>
              <td class="px-6 py-2">Slip</td>
              <td class="px-6 py-2"><img src="/attachments/payments/{{ $project_payments->reciptImage }}" alt="" class="w-full"></td>
            </tr>
          </tbody>
        </table>
          
      </div>

    </div>
  </div>
</x-guest-layout>