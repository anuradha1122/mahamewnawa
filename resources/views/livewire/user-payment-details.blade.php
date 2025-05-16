<div>
    <div class="grid grid-cols-1 gap-y-1 sm:grid-cols-3">
        <div class="sm:col-span-1 px-1">
            <x-form-input-label for="projectId" value="Project" />
            <x-form-list-input-field name="projectId" id="projectId" :options="$projects" wire:model.live="projectId" required/>
        </div>
        <div class="sm:col-span-1 px-1">
            <x-form-input-label for="start_date" value="Start Date" />
            <x-form-date-input-field name="start_date" id="start_date" wire:model.live="start_date" required/>
        </div>
        <div class="sm:col-span-1 px-1">
            <x-form-input-label for="end_date" value="End Date" />
            <x-form-date-input-field name="end_date" id="end_date" wire:model.live="end_date" required/>
        </div>
    </div>
    
    <div class="flex flex-col bg-white my-5">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">#</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name With Initials</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NIC</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Payment Method</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Amount</th>   
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Slip</th>   
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Receipt</th>   
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if ($payment_report->isNotEmpty())
                            @foreach ($payment_report as $index => $payment)
                            @php
                                if($payment->payment_method == 1){
                                    $paymentMethod = 'Bank';
                                }
                                else{
                                    $paymentMethod = 'Cash';
                                }
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $payment_report->firstItem() + $index }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $payment->nameWithInitials }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $payment->nic }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $paymentMethod }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $payment->amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><a href="/attachments/payments/{{ $payment->reciptImage }}" class="text-blue-500" target="_blank">{{ $payment->reciptNo }}</a></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><a href="{{ route('dambadiwa.payment_slip_pdf', ['projectId'=>$payment->project_id,'crewId'=>$payment->crewId,'payment_id'=>$payment->id,'categoryId'=>$payment->categoryId]) }}" class="bg-blue-500 hover:bg-blue-600 text-white rounded-md px-2 py-1" target="_blank">Download</a></td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center p-3">No Results Found!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="mt-4 text-start">
            @if ($payment_report->isNotEmpty())
                {{ $payment_report->links() }}
            @endif
        </div>
    </div>
</div>

