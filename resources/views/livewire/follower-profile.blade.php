<dl>
    <x-profile-data-name heading="Name" fullName="{{ $name }}" nameWithInitials="{{ $nameWithInitials }}" name="name" id="name" :edit="$nameIsEdit" function="nameEdit" formFunction="updateName" inputWire="formName" options="" />
    <x-profile-data-nic heading="NIC" nic="{{ $nic }}" name="nic" id="nic" :edit="$nicIsEdit" function="nicEdit" formFunction="updateNic" inputWire="formNic" options="" />
    <x-profile-data-email heading="E-mail" email="{{ $email }}" name="email" id="email" :edit="$emailIsEdit" function="emailEdit" formFunction="updateEmail" inputWire="formEmail" options="" />
    <x-profile-data-race heading="Race" race="{{ $race }}" name="race" id="race" :edit="$raceIsEdit" function="raceEdit" formFunction="updateRace" inputWire="formRace" options="" />
    <x-profile-data-religion heading="Religion" religion="{{ $religion }}" name="religion" id="religion" :edit="$religionIsEdit" function="religionEdit" formFunction="updateReligion" inputWire="formReligion" options="" />
    <x-profile-data-civil-status heading="Civil Status" civilStatus="{{ $civilStatus }}" name="civilStatus" id="civilStatus" :edit="$civilStatusIsEdit" function="civilStatusEdit" formFunction="updateCivilStatus" inputWire="formCivilStatus" options="" />
    <x-profile-data-birthday heading="Birth day" birthDay="{{ $birthDay }}" name="birthDay" id="birthDay" :edit="$birthDayIsEdit" function="birthDayEdit" formFunction="updateBirthDay" inputWire="formBirthDay" options="" />
    <x-profile-data-gender heading="Gender" gender="{{ $gender }}" name="gender" id="gender" :edit="$genderIsEdit" function="genderEdit" formFunction="updateGender" inputWire="formGender" options="" />
    <x-profile-data-address heading="Address" addressLine1="{{ $addressLine1 }}" addressLine2="{{ $addressLine2 }}" addressLine3="{{ $addressLine3 }}" name="address" id="address" :edit="$addressIsEdit" function="permAddressEdit" formFunction="updatePermAddress" inputWire="formPermAddress" options="" />
    <x-profile-data-mobile heading="Mobile No" mobile1="{{ $mobile1 }}" mobile2="{{ $mobile2 }}" name="mobile" id="mobile" :edit="$mobileIsEdit" function="mobileEdit" formFunction="updateMobile" inputWire="formMobile" options="" />
</dl>
