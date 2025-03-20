<x-app-layout>
    <div class="py-3">
        <div class="mx-auto sm:px-2">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-success message="{{ session('success') }}" />
                <x-profile-heading heading="{{ $crew->nameWithInitials }}" subHeading="{{ $crew->nic }}" />
                    <form method="POST" action="{{ route('dambadiwa.edit_crew_profile', ['project_id' => $projectId, 'crew_id' => $crew_id,'category_id' => $category_id]) }}" class="mx-auto" enctype="multipart/form-data">
                        @csrf
                        <div class="border-t border-gray-200 grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-3">
                            <x-form-text-input-section size="sm:col-span-3" name="name" id="name" label="Full Name" value="{{ $crew->name }}"/>
                            <x-form-text-input-section size="" name="nameWithInitials" id="nameWithInitials" label="Name With Initials" value="{{ $crew->nameWithInitials }}"/>
                            <x-form-text-input-section size="" name="nic" id="nic" label="NIC" value="{{ $crew->nic }}"/>
                            <x-form-text-input-section size="" name="email" id="email" label="Email" value="{{ $crew->email }}"/>
                            <x-form-text-input-section size="" name="addressLine1" id="addressLine1" label="Address Line 1" value="{{ $crew->addressLine1 }}"/>
                            <x-form-text-input-section size="" name="addressLine2" id="addressLine2" label="Address Line 2" value="{{ $crew->addressLine2 }}"/>
                            <x-form-text-input-section size="" name="addressLine3" id="addressLine3" label="Address Line 3" value="{{ $crew->addressLine3 }}"/>
                            @if($category_id == 2){
                                <x-form-list-input-section-edit size="" name="district" id="district" :options="$districts" label="District" value="{{ $crew->districtId }}" :valuename="$crew->district" />
                            }
                            @endif
                            <x-form-text-input-section size="" name="mobile1" id="mobile1" label="Mobile" value="{{ $crew->mobile1 }}"/>
                            <x-form-text-input-section size="" name="mobile2" id="mobile2" label="Whatapp" value="{{ $crew->mobile2 }}"/>
                            <x-form-list-input-section-edit size="" name="race" id="race" :options="$races" label="Race" value="{{ $crew->raceId }}" :valuename="$crew->race"/>
                            <x-form-list-input-section-edit size="" name="religion" id="religion" :options="$religions" label="Birth Religion" value="{{ $crew->religionId }}" :valuename="$crew->religion"/>
                            <x-form-list-input-section-edit size="" name="civilStatus" id="civilStatus" :options="$civilStatuses" label="Civil Status" value="{{ $crew->civilStatusId }}" :valuename="$crew->civilStatus"/>
                            @if($category_id == 2){
                                <x-form-list-input-section-edit size="" name="monastery" id="monastery" :options="$monasteries" label="Nearest Mahamewnawa Monastery" value="{{ $crew->monasteryId }}" :valuename="$crew->monastary"/>
                            }
                            @endif
                            <x-form-date-input-section-edit size="" name="birthDay" id="birthDay" label="Birth Day" value="{{ $crew->birthDay }}"/>
                            <x-form-list-input-section-edit size="" name="gender" id="gender" :options="$genders" label="Gender" value="{{ $crew->genderId }}" :valuename="$crew->gender"/>

                            <x-form-text-input-section size="" name="guardian" id="guardian" label="Guardian" value="{{ $crew->guardian }}"/>
                            <x-form-text-input-section size="" name="guardianPhone" id="guardianPhone" label="Guardian Phone" value="{{ $crew->guardianPhone }}"/>
                            <x-form-text-input-section size="" name="guardianEmail" id="guardianEmail" label="Guardian Email" value="{{ $crew->guardianEmail }}"/>
                            <x-form-text-input-section size="" name="birthPlace" id="birthPlace" label="Birth Place" value="{{ $crew->birthPlace }}"/>
                            <x-form-text-input-section size="" name="occupation" id="occupation" label="Occupation" value="{{ $crew->occupation }}"/>
                            <x-form-list-input-section-edit size="" name="previousAbroad" id="previousAbroad" :options="$yesNo" label="Previous Abroad" value="{{ $crew->previousAbroad }}" :valuename="$crew->previousAbroadName"/>
                            <x-form-text-input-section size="" name="spouse" id="spouse" label="Spouse" value="{{ $crew->spouse }}"/>
                            <x-form-text-input-section size="" name="spousebirthPlace" id="spousebirthPlace" label="Spouse BirthPlace" value="{{ $crew->spousebirthPlace }}"/>
                            <x-form-text-input-section size="" name="spouseOccupation" id="spouseOccupation" label="Spouse Occupation" value="{{ $crew->spouseOccupation }}"/>
                            <x-form-text-input-section size="" name="mother" id="mother" label="Mother" value="{{ $crew->mother }}"/>
                            <x-form-text-input-section size="" name="motherBirthPlace" id="motherBirthPlace" label="Mother Birth Place" value="{{ $crew->motherBirthPlace }}"/>
                            <x-form-text-input-section size="" name="motherOccupation" id="motherOccupation" label="Mother Occupation" value="{{ $crew->motherOccupation }}"/>
                            <x-form-text-input-section size="" name="father" id="father" label="Father" value="{{ $crew->father }}"/>
                            <x-form-text-input-section size="" name="fatherBirthPlace" id="fatherBirthPlace" label="Father Birth Place" value="{{ $crew->fatherBirthPlace }}"/>
                            <x-form-text-input-section size="" name="fatherOccupation" id="fatherOccupation" label="Father Occupation" value="{{ $crew->fatherOccupation }}"/>
                            <x-form-list-input-section-edit size="" name="passport" id="passport" label="Passport" :options="$yesNo" value="{{ $crew->passport }}" :valuename="$crew->passportValue"/>
                            <x-form-text-input-section size="" name="passportNo" id="passportNo" label="Passport No" value="{{ $crew->passportNo }}"/>
                            <x-form-file-input-section size="" name="passportImage" id="passportImage" label="Passport Image" value=""/>
                            <x-form-file-input-section size="" name="passportBookImage" id="passportBookImage" label="Passport Book Image" value=""/>
                            <x-form-file-input-section size="" name="visaDocument" id="visaDocument" label="Visa Document" value=""/>
                            <x-form-list-input-section-edit size="" name="policeReport" id="policeReport" label="Police Report" :options="$yesNo" value="{{ $crew->policeReport }}" :valuename="$crew->policeReportValue"/>
                            <x-form-file-input-section size="" name="policeReportDocument" id="policeReportDocument" label="Police Report Document" value=""/>
                            <x-form-file-input-section size="" name="birthCertificate" id="birthCertificate" label="Birth Certificate" value=""/>
                            <x-form-text-input-section size="" name="payment" id="payment" label="Payment" value="{{ $crew->payment }}"/>
                            <x-form-list-input-section-edit size="" name="diabetes" id="diabetes" label="Diabetes" :options="$yesNo" value="{{ $crew->diabetes }}" :valuename="$crew->diabetesValue"/>
                            <x-form-list-input-section-edit size="" name="highBloodPressure" id="highBloodPressure" label="High Blood Pressure" :options="$yesNo" value="{{ $crew->highBloodPressure }}" :valuename="$crew->highBloodPressureValue"/>
                            <x-form-list-input-section-edit size="" name="asthma" id="asthma" label="Asthma" :options="$yesNo" value="{{ $crew->asthma }}" :valuename="$crew->asthmaValue"/>
                            <x-form-list-input-section-edit size="" name="apoplexy" id="apoplexy" label="Apoplexy" :options="$yesNo" value="{{ $crew->apoplexy }}" :valuename="$crew->apoplexyValue"/>
                            <x-form-list-input-section-edit size="" name="heartDisease" id="heartDisease" label="Heart Disease" :options="$yesNo" value="{{ $crew->heartDisease }}" :valuename="$crew->heartDiseaseValue"/>
                            <x-form-list-input-section-edit size="" name="otherIllness" id="otherIllness" label="Other Illness" :options="$yesNo" value="{{ $crew->otherIllness }}" :valuename="$crew->otherIllnessValue"/>
                            <x-form-text-input-section size="" name="otherIllnessDescription" id="otherIllnessDescription" label="Other Illness Description" value="{{ $crew->otherIllnessDescription }}"/>
                            <x-form-list-input-section-edit size="" name="heartOtherOperation" id="heartOtherOperation" label="Heart or Other Operation" :options="$yesNo" value="{{ $crew->heartOtherOperation }}" :valuename="$crew->heartOtherOperationValue"/>
                            <x-form-list-input-section-edit size="" name="artificialHandLeg" id="artificialHandLeg" label="Artificial Hand/Leg" :options="$yesNo" value="{{ $crew->artificialHandLeg }}" :valuename="$crew->artificialHandLegValue"/>
                            <x-form-list-input-section-edit size="" name="mentalIllness" id="mentalIllness" label="Mental Illness" :options="$yesNo" value="{{ $crew->mentalIllness }}" :valuename="$crew->mentalIllnessValue"/>
                            <x-form-file-input-section size="" name="medicalDocument" id="medicalDocument" label="Medical Document" value=""/>
                            <x-form-list-input-section-edit size="" name="forces" id="forces" label="Forces" :options="$yesNo" value="{{ $crew->forces }}" :valuename="$crew->forcesValue"/>
                            <x-form-list-input-section-edit size="" name="forcesRemoval" id="forcesRemoval" label="Forces Removal" :options="$yesNo" value="{{ $crew->forcesRemoval }}" :valuename="$crew->forcesRemovalValue"/>
                            <x-form-list-input-section-edit size="" name="courtOrder" id="courtOrder" label="Court Order" :options="$yesNo" value="{{ $crew->courtOrder }}" :valuename="$crew->courtOrderValue"/>
                        </div>

                        <div class="mt-10">
                            <x-form-button-primary size="" text="Update" modelBinding=""/>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</x-app-layout>