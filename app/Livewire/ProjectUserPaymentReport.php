<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ProjectUserPaymentReport extends Component
{
    use WithPagination;
    
    public $project;
    public $search_user;

    public function render()
    {
        $projects = DB::table('dambadiwa_projects')->where('active','1')->get();

        $payment_report = DB::table('dambadiwa_crew_payments')
        ->leftJoin('users', function ($join) {
            $join->on('dambadiwa_crew_payments.crewId', '=', 'users.id')
                ->where('dambadiwa_crew_payments.categoryId', 1);
        })
        ->leftJoin('followers', function ($join) {
            $join->on('dambadiwa_crew_payments.crewId', '=', 'followers.id')
                ->where('dambadiwa_crew_payments.categoryId', 2);
        })
        ->select(
            'dambadiwa_crew_payments.crewId',
            'dambadiwa_crew_payments.categoryId',
            DB::raw("CASE 
                        WHEN dambadiwa_crew_payments.categoryId = 1 THEN users.nameWithInitials 
                        WHEN dambadiwa_crew_payments.categoryId = 2 THEN followers.nameWithInitials 
                        ELSE NULL 
                    END AS nameWithInitials"),
            DB::raw("CASE 
                        WHEN dambadiwa_crew_payments.categoryId = 1 THEN users.nic 
                        WHEN dambadiwa_crew_payments.categoryId = 2 THEN followers.nic 
                        ELSE NULL 
                    END AS nic"),
            DB::raw("SUM(dambadiwa_crew_payments.amount) AS total_amount")
        )
        ->when($this->project, function($query) {
            return $query->where('dambadiwa_crew_payments.project_id', $this->project);
        })
        ->when($this->search_user, function($query) {
            return $query->where(function($query) {
                $query->orWhere('users.nameWithInitials', 'LIKE', '%'.$this->search_user.'%')
                    ->orWhere('users.nic', 'LIKE', '%'.$this->search_user.'%')
                    ->orWhere('followers.nic', 'LIKE', '%'.$this->search_user.'%')
                    ->orWhere('followers.nameWithInitials', 'LIKE', '%'.$this->search_user.'%');
            });
        })
        ->where('dambadiwa_crew_payments.active', 1)
        ->where('dambadiwa_crew_payments.confirm_decline', '>', 0)
        ->groupBy('dambadiwa_crew_payments.crewId', 'dambadiwa_crew_payments.categoryId', 'nameWithInitials', 'nic')
        ->paginate(50);
        
        return view('livewire.project-user-payment-report', compact('projects','payment_report'));
    }
}
