<?php

namespace App\Livewire;

use Livewire\Component;

class UserProfile extends Component
{
    public $name;
    public $nameWithInitials;
    public $email;
    public $nic;
    public $race;
    public $religion;
    public $civilStatus;
    public $birthDay;
    public $gender;
    public $addressLine1;
    public $addressLine2;
    public $addressLine3;
    public $mobile1;
    public $mobile2;
    public $appointment;
    public $position;

    public $nameIsEdit = false;
    public $emailIsEdit;
    public $nicIsEdit;
    public $raceIsEdit;
    public $religionIsEdit;
    public $civilStatusIsEdit;
    public $birthDayIsEdit;
    public $genderIsEdit;
    public $addressIsEdit;
    public $mobileIsEdit;
    public $appointmentIsEdit;
    public $positionIsEdit;

    public function render()
    {
        return view('livewire.user-profile');
    }
}
