<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Follower;

class FollowerSearch extends Component
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
            $searchResults = Follower::leftjoin('contact_infos', 'followers.id', '=', 'contact_infos.followerId')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('followers.name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('followers.nic', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('followers.nameWithInitials', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('contact_infos.mobile1', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('contact_infos.mobile2', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->select('followers.*')
            ->paginate(10);

        }
        return view('livewire.follower-search', ['searchResults' => $searchResults]);
    }
    
}
