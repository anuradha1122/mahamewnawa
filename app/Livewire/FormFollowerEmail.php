<?php

namespace App\Livewire;

use Livewire\Component;

class FormFollowerEmail extends Component
{
    public $email;
    public $gender;
    public $genderValue;

    public function rules()
    {
        return [
            'email' => [
                'nullable',
                'unique:followers,email',
                'email', 
            ],
        ];
    }

    public function updatedEmail()
    {
        $this->validate();
    }


    public function render()
    {
        return view('livewire.form-follower-email',[
            'email' => $this->email,
        ]);
    }
}
