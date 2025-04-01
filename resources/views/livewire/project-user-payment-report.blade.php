<div>
    <div class="grid grid-cols-1 gap-y-1 sm:grid-cols-3">
        <div class="sm:col-span-1 px-1">
            <x-form-input-label for="project" value="Project" />
            <x-form-list-input-field name="project" id="project" :options="$projects" wire:model.live="project" required/>
        </div>
        <div class="sm:col-span-1 px-1">
            <x-form-input-label for="search_user" value="User" />
            <x-form-text-input-field name="search_user" id="search_user" wire:model.live="search_user" required/>
        </div>
    </div>

    <div class="my-3">
        <a href="{{ route('dambadiwa.project_user_payment_pdf', ['project'=>$project,'search_user'=>$search_user]) }}" class="mt-1 text-xs leading-5 bg-red-500 hover:bg-red-700 p-2 rounded-md text-white mx-2 mb-3 text-center" target="_blank">PDF</a>
        <a href="{{ route('dambadiwa.project_user_payment_excel', ['project'=>$project,'search_user'=>$search_user]) }}" class="mt-1 text-xs leading-5 bg-green-500 hover:bg-green-700 p-2 rounded-md text-white mb-3 text-center" target="_blank">Excel</a>
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
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Amount</th>   
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if ($payment_report->isNotEmpty())
                            @foreach ($payment_report as $index => $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $payment_report->firstItem() + $index }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $payment->nameWithInitials }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $payment->nic }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $payment->total_amount }}</td>
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

