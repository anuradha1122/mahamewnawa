<div>
    <form wire:submit.prevent="generateReports" class="w-full grid grid-cols-1 gap-y-1 sm:grid-cols-4" enctype="multipart/form-data">
        @csrf
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="category" value="Category" />
            <x-form-list-input-field name="category" id="category" :options="$categoryList" wire:model.live="category" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="diabetes" value="Diabetes" />
            <x-form-list-input-field name="diabetes" id="diabetes" :options="$optionList" wire:model.live="diabetes" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="highBloodPressure" value="High Blood Pressure" />
            <x-form-list-input-field name="highBloodPressure" id="highBloodPressure" :options="$optionList" wire:model.live="highBloodPressure" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="asthma" value="Asthma" />
            <x-form-list-input-field name="asthma" id="asthma" :options="$optionList" wire:model.live="asthma" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="apoplexy" value="Apoplexy" />
            <x-form-list-input-field name="apoplexy" id="apoplexy" :options="$optionList" wire:model.live="apoplexy" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="heartDisease" value="Heart Disease" />
            <x-form-list-input-field name="heartDisease" id="heartDisease" :options="$optionList" wire:model.live="heartDisease" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="otherIllness" value="Other Illnesses" />
            <x-form-list-input-field name="otherIllness" id="otherIllness" :options="$optionList" wire:model.live="otherIllness" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="heartOtherOperation" value="Heart or Other Operations" />
            <x-form-list-input-field name="heartOtherOperation" id="heartOtherOperation" :options="$optionList" wire:model.live="heartOtherOperation" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="artificialHandLeg" value="Artificial Hand or Leg" />
            <x-form-list-input-field name="artificialHandLeg" id="artificialHandLeg" :options="$optionList" wire:model.live="artificialHandLeg" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="mentalIllness" value="Mental Illness" />
            <x-form-list-input-field name="mentalIllness" id="mentalIllness" :options="$optionList" wire:model.live="mentalIllness" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="forces" value="Forces" />
            <x-form-list-input-field name="forces" id="forces" :options="$optionList" wire:model.live="forces" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="forcesRemoval" value="Forces Removal" />
            <x-form-list-input-field name="forcesRemoval" id="forcesRemoval" :options="$optionList" wire:model.live="forcesRemoval" required/>
        </div>
        <div class="sm:col-span-1 px-1 py-1">
            <x-form-input-label for="courtOrder" value="Court Order" />
            <x-form-list-input-field name="courtOrder" id="courtOrder" :options="$optionList" wire:model.live="courtOrder" required/>
        </div>
    </form>
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr>
                        @if (!empty($results))
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">#</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name With Initials</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">NIC</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Diabetes</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">High Blood Pressure</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Asthma</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Apoplexy</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Heart Disease</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Other Illnesess</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Heart or Other Operations</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Artificial Hand or Leg</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Mental Illness</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Forces</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Forces Removal</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Court Order</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">#</th>
                        @endif      
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    
                        @foreach ($results as $index => $result)
                        <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $results->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->userName }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->nameWithInitials }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->nic }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->category }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->diabetes }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->highBloodPressure }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->asthma }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->apoplexy }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->heartDisease }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->otherIllness }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->heartOtherOperation }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->artificialHandLeg }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->mentalIllness }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->forces }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->forcesRemoval }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $result->courtOrder }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            <a href="{{ route('dambadiwa.crewprofile', [$result->id, $result->categoryId, $projectSlug]) }}" class="text-blue" >
                            <x-form-button-danger size="" text="Edit" modelBinding="" name="editCrew" /></td>
                            </a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="mt-4 text-start">
            @if (!empty($results))
            {{ $results->links() }}
            @endif   
        </div>
    </div>
</div>