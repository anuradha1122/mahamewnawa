<?php

namespace App\Livewire;

use Livewire\Component;

class FollowerProfile extends Component
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

    public function render()
    {
        return view('livewire.follower-profile');
    }
}
