<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserSearch extends Component
{
    public $search = '';
    public $size;

    public function mount($size)
    {
        $this->size = $size;
    }

    public function render()
    {
        $searchResults = '';
        if(strlen($this->search)>0){
            $searchResults = User::leftjoin('user_contact_infos', 'users.id', '=', 'user_contact_infos.userId')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('users.name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('users.nic', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('users.nameWithInitials', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('user_contact_infos.mobile1', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('user_contact_infos.mobile2', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->select('users.*')
            ->paginate(10);

        }
        return view('livewire.user-search', ['searchResults' => $searchResults]);
    }

}
