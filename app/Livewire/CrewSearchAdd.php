<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Follower;
use App\Models\DambadiwaCrew;
use App\Models\DambadiwaProject;
use Illuminate\Support\Facades\DB;

class CrewSearchAdd extends Component
{
    public $search = '';
    public $size;
    public $projectSlug;
    public $projectId;

    public function mount($size)
    {
        $project = DambadiwaProject::where('id', $this->projectId)->first();
        $this->projectId = $project->id;
        $this->size = $size;
    }

    public function addCrew($parameters)
    {
        $crewId = $parameters[0];
        $categoryId = $parameters[1];
        $projectId = $this->projectId;
        //dd($crewId, $categoryId, $projectId);

        $crew = DambadiwaCrew::where('crewId', $crewId)
            ->where('categoryId', $categoryId)
            ->where('projectId', $projectId)
            ->first();
        
        // If the crew exists, update the 'active' field to 1
        if ($crew) {
            $crew->active = 1;
            $crew->save();
            //dd($crew);
        } else {
            // If no crew is found, create a new one
            DambadiwaCrew::create([
                'crewId' => $crewId,
                'categoryId' => $categoryId,
                'projectId' => $projectId,
                'active' => 1,  // Assuming new crews should be active
            ]);
        }
        
    }

    public function removeCrew($parameters)
    {
        $crewId = $parameters[0];
        $categoryId = $parameters[1];
        $projectId = $this->projectId;
        //dd($crewId, $categoryId, $projectId);
        $crew = DambadiwaCrew::where('crewId', $crewId)
            ->where('categoryId', $categoryId)
            ->where('projectId', $projectId)
            ->first();

        // If the crew exists, update the 'active' field to 1
        if ($crew) {
            $crew->active = 0;
            $crew->save();
        }
    }

    public function render()
    {
        //dd($this->projectId);
        $searchResults = '';
        if(strlen($this->search)>0){

            $searchResults = DB::table('users')
            ->select(
                'users.id as crewId',
                DB::raw('1 as categoryId'), // Assign categoryId = 1 for users
                'users.name',
                'users.nameWithInitials',
                'users.nic',
                'dambadiwa_crews.active as added' // Get 'active' status from dambadiwa_crews table
            )
            ->leftJoin('dambadiwa_crews', function ($join) {
                $join->on('users.id', '=', 'dambadiwa_crews.crewId') // Join user.id with crewId
                    ->where('dambadiwa_crews.categoryId', '=', 1) // Ensure categoryId is 1 for users
                    ->where('dambadiwa_crews.projectId', '=', $this->projectId); // Match the specific projectId
            })
            ->where('users.active', 1)
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('users.name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('users.nic', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('users.nameWithInitials', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->union(
                DB::table('followers')
                    ->select(
                        'followers.id as crewId',
                        DB::raw('2 as categoryId'), // Assign categoryId = 2 for followers
                        'followers.name',
                        'followers.nameWithInitials',
                        'followers.nic',
                        'dambadiwa_crews.active as added' // Get 'active' status from dambadiwa_crews table
                    )
                    ->leftJoin('dambadiwa_crews', function ($join) {
                        $join->on('followers.id', '=', 'dambadiwa_crews.crewId') // Join follower.id with crewId
                            ->where('dambadiwa_crews.categoryId', '=', 2) // Ensure categoryId is 2 for followers
                            ->where('dambadiwa_crews.projectId', '=', $this->projectId); // Match the specific projectId
                    })
                    ->where('followers.active', 1)
                    ->when($this->search, function ($query) {
                        $query->where(function ($subQuery) {
                            $subQuery->where('followers.name', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('followers.nic', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('followers.nameWithInitials', 'LIKE', '%' . $this->search . '%');
                        });
                    })
            )
            ->paginate(10);
            //dd($searchResults->all());
            // Apply pagination

        }
        return view('livewire.crew-search-add', ['searchResults' => $searchResults]);
    }
}
