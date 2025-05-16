<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class UserPaymentDetails extends Component
{
    use WithPagination;
    
    public $projectId;
    public $start_date;
    public $end_date;
    public $crewId;
    public $categoryId;

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
            DB::raw("CASE 
                    WHEN dambadiwa_crew_payments.categoryId = 1 THEN users.nic 
                    WHEN dambadiwa_crew_payments.categoryId = 2 THEN followers.nic 
                    ELSE NULL 
                END AS nic"),
            'dambadiwa_crew_payments.amount',
            'dambadiwa_crew_payments.addedDate',
            'dambadiwa_crew_payments.reciptImage',
            'dambadiwa_crew_payments.reciptNo',
            'dambadiwa_crew_payments.payment_method',
            'dambadiwa_crew_payments.id',
            'dambadiwa_crew_payments.categoryId',
            'dambadiwa_crew_payments.crewId',
            'dambadiwa_crew_payments.project_id',
        )
        ->when($this->projectId, function($query) {
            return $query->where('dambadiwa_crew_payments.project_id', $this->projectId);
        })
        ->when($this->start_date && $this->end_date, function ($query) {
            return $query->whereBetween('dambadiwa_crew_payments.addedDate', [$this->start_date, $this->end_date]);
        })
        ->where('dambadiwa_crew_payments.active', 1)
        ->where('dambadiwa_crew_payments.confirm_decline', '>', 0)
        ->where('dambadiwa_crew_payments.crewId', $this->crewId)
        ->where('dambadiwa_crew_payments.categoryId', $this->categoryId)
        ->paginate(50);

        return view('livewire.user-payment-details', compact('projects','payment_report'));
    }
}
