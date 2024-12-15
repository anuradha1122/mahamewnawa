<?php

namespace App\Livewire;

use Livewire\Component;

class FormUserEmail extends Component
{
    public $email;
    public $gender;
    public $genderValue;

    public function rules()
    {
        return [
            'email' => [
                'required',
                'unique:users,email',
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
        return view('livewire.form-user-email',[
            'email' => $this->email,
        ]);
    }
    
}
