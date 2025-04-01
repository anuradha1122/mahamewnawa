<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ProjectPaymentReport extends Component
{
    use WithPagination;
    
    public $project;
    public $start_date;
    public $end_date;

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
            DB::raw("
                CASE 
                    WHEN dambadiwa_crew_payments.categoryId = 1 THEN users.nameWithInitials 
                    WHEN dambadiwa_crew_payments.categoryId = 2 THEN followers.nameWithInitials 
                    ELSE NULL 
                END AS nameWithInitials
            "),
            'dambadiwa_crew_payments.amount',
            'dambadiwa_crew_payments.addedDate',
        )
        ->when($this->project, function($query) {
            return $query->where(function($query) {
                $query->orWhere('dambadiwa_crew_payments.project_id', $this->project);
            });
        })
        ->when($this->start_date && $this->end_date, function ($query) {
            return $query->whereBetween('dambadiwa_crew_payments.addedDate', [$this->start_date, $this->end_date]);
        })
        ->where('dambadiwa_crew_payments.active', 1)
        ->where('dambadiwa_crew_payments.confirm_decline', '>', 0)
        ->paginate(50);


        return view('livewire.project-payment-report', compact('projects','payment_report'));
    }
}
