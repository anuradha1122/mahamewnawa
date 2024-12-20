<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\DambadiwaProject;
use Carbon\Carbon;

class CrewReport extends Component
{
    public $categoryList;
    public $optionList;

    public $category;
    public $diabetes;
    public $highBloodPressure;
    public $asthma;
    public $apoplexy;
    public $heartDisease;
    public $otherIllness;
    public $otherIllnessDescription;
    public $heartOtherOperation;
    public $artificialHandLeg;
    public $mentalIllness;
    public $forces;
    public $forcesRemoval;
    public $courtOrder;

    public $projectSlug;
    public $projectId;

    public function generateReports(){

        $project = DambadiwaProject::where('slug', $this->projectSlug)->first();
        $this->projectId = $project->id;
        $category = $this->category;
        return $results = DB::table('dambadiwa_crews')
        ->leftJoin('users', function ($join) use ($category) {
            $join->on('dambadiwa_crews.crewId', '=', 'users.id')
                 ->where('dambadiwa_crews.categoryId', 1);
        })
        ->leftJoin('followers', function ($join) use ($category) {
            $join->on('dambadiwa_crews.crewId', '=', 'followers.id')
                 ->where('dambadiwa_crews.categoryId', 2);
        })
        ->select(
            DB::raw('COALESCE(users.name, followers.name) AS userName'),
            DB::raw('COALESCE(users.nameWithInitials, followers.nameWithInitials) AS nameWithInitials'),
            DB::raw('COALESCE(users.nic, followers.nic) AS nic'),
            DB::raw('COALESCE(users.email, followers.email) AS email'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.categoryId = 1 THEN "user" 
                WHEN dambadiwa_crews.categoryId = 2 THEN "follower" 
                END AS category'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.diabetes = 1 THEN "yes" 
                WHEN dambadiwa_crews.diabetes = 2 THEN "no" 
                ELSE "" 
                END AS diabetes'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.highBloodPressure = 1 THEN "yes" 
                WHEN dambadiwa_crews.highBloodPressure = 2 THEN "no" 
                ELSE "" 
                END AS highBloodPressure'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.asthma = 1 THEN "yes" 
                WHEN dambadiwa_crews.asthma = 2 THEN "no" 
                ELSE "" 
                END AS asthma'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.apoplexy = 1 THEN "yes" 
                WHEN dambadiwa_crews.apoplexy = 2 THEN "no" 
                ELSE "" 
                END AS apoplexy'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.heartDisease = 1 THEN "yes" 
                WHEN dambadiwa_crews.heartDisease = 2 THEN "no" 
                ELSE "" 
                END AS heartDisease'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.otherIllness = 1 THEN "yes" 
                WHEN dambadiwa_crews.otherIllness = 2 THEN "no" 
                ELSE "" 
                END AS otherIllness')
        )
        ->where('dambadiwa_crews.projectId', $this->projectId)
        ->when(!in_array($this->diabetes, [1, 2, 3]), function ($query) {
            // Show all values if diabetes is not 1, 2, or 3
            return $query;
        })
        ->when($this->diabetes == 3, function ($query) {
            // Show only records where diabetes is null
            return $query->whereNull('dambadiwa_crews.diabetes');
        })
        ->when(in_array($this->diabetes, [1, 2]), function ($query) {
            // Filter according to the value of diabetes
            return $query->where('dambadiwa_crews.diabetes', $this->diabetes);
        })
        ->when(!in_array($this->highBloodPressure, [1, 2, 3]), function ($query) {
            // Show all values if highBloodPressure is not 1, 2, or 3
            return $query;
        })
        ->when($this->highBloodPressure == 3, function ($query) {
            // Show only records where highBloodPressure is null
            return $query->whereNull('dambadiwa_crews.highBloodPressure');
        })
        ->when(in_array($this->highBloodPressure, [1, 2]), function ($query) {
            // Filter according to the value of highBloodPressure
            return $query->where('dambadiwa_crews.highBloodPressure', $this->highBloodPressure);
        })
        ->when(!in_array($this->asthma, [1, 2, 3]), function ($query) {
            // Show all values if asthma is not 1, 2, or 3
            return $query;
        })
        ->when($this->asthma == 3, function ($query) {
            // Show only records where asthma is null
            return $query->whereNull('dambadiwa_crews.asthma');
        })
        ->when(in_array($this->asthma, [1, 2]), function ($query) {
            // Filter according to the value of asthma
            return $query->where('dambadiwa_crews.asthma', $this->asthma);
        })
        ->when(!in_array($this->apoplexy, [1, 2, 3]), function ($query) {
            // Show all values if apoplexy is not 1, 2, or 3
            return $query;
        })
        ->when($this->apoplexy == 3, function ($query) {
            // Show only records where apoplexy is null
            return $query->whereNull('dambadiwa_crews.apoplexy');
        })
        ->when(in_array($this->apoplexy, [1, 2]), function ($query) {
            // Filter according to the value of apoplexy
            return $query->where('dambadiwa_crews.apoplexy', $this->apoplexy);
        })
        ->when(!in_array($this->heartDisease, [1, 2, 3]), function ($query) {
            // Show all values if heartDisease is not 1, 2, or 3
            return $query;
        })
        ->when($this->heartDisease == 3, function ($query) {
            // Show only records where heartDisease is null
            return $query->whereNull('dambadiwa_crews.heartDisease');
        })
        ->when(in_array($this->heartDisease, [1, 2]), function ($query) {
            // Filter according to the value of heartDisease
            return $query->where('dambadiwa_crews.heartDisease', $this->heartDisease);
        })
        ->when(!in_array($this->otherIllness, [1, 2, 3]), function ($query) {
            // Show all values if otherIllness is not 1, 2, or 3
            return $query;
        })
        ->when($this->otherIllness == 3, function ($query) {
            // Show only records where otherIllness is null
            return $query->whereNull('dambadiwa_crews.otherIllness');
        })
        ->when(in_array($this->otherIllness, [1, 2]), function ($query) {
            // Filter according to the value of otherIllness
            return $query->where('dambadiwa_crews.otherIllness', $this->otherIllness);
        })
        ->when(!in_array($this->heartOtherOperation, [1, 2, 3]), function ($query) {
            // Show all values if heartOtherOperation is not 1, 2, or 3
            return $query;
        })
        ->when($this->heartOtherOperation == 3, function ($query) {
            // Show only records where heartOtherOperation is null
            return $query->whereNull('dambadiwa_crews.heartOtherOperation');
        })
        ->when(in_array($this->heartOtherOperation, [1, 2]), function ($query) {
            // Filter according to the value of heartOtherOperation
            return $query->where('dambadiwa_crews.heartOtherOperation', $this->heartOtherOperation);
        })
        ->when(!in_array($this->artificialHandLeg, [1, 2, 3]), function ($query) {
            // Show all values if artificialHandLeg is not 1, 2, or 3
            return $query;
        })
        ->when($this->artificialHandLeg == 3, function ($query) {
            // Show only records where artificialHandLeg is null
            return $query->whereNull('dambadiwa_crews.artificialHandLeg');
        })
        ->when(in_array($this->artificialHandLeg, [1, 2]), function ($query) {
            // Filter according to the value of artificialHandLeg
            return $query->where('dambadiwa_crews.artificialHandLeg', $this->artificialHandLeg);
        })
        ->when(!in_array($this->mentalIllness, [1, 2, 3]), function ($query) {
            // Show all values if mentalIllness is not 1, 2, or 3
            return $query;
        })
        ->when($this->mentalIllness == 3, function ($query) {
            // Show only records where mentalIllness is null
            return $query->whereNull('dambadiwa_crews.mentalIllness');
        })
        ->when(in_array($this->mentalIllness, [1, 2]), function ($query) {
            // Filter according to the value of mentalIllness
            return $query->where('dambadiwa_crews.mentalIllness', $this->mentalIllness);
        })
        ->when(!in_array($this->forces, [1, 2, 3]), function ($query) {
            // Show all values if forces is not 1, 2, or 3
            return $query;
        })
        ->when($this->forces == 3, function ($query) {
            // Show only records where forces is null
            return $query->whereNull('dambadiwa_crews.forces');
        })
        ->when(in_array($this->forces, [1, 2]), function ($query) {
            // Filter according to the value of forces
            return $query->where('dambadiwa_crews.forces', $this->forces);
        })
        ->when(!in_array($this->forcesRemoval, [1, 2, 3]), function ($query) {
            // Show all values if forcesRemoval is not 1, 2, or 3
            return $query;
        })
        ->when($this->forcesRemoval == 3, function ($query) {
            // Show only records where forcesRemoval is null
            return $query->whereNull('dambadiwa_crews.forcesRemoval');
        })
        ->when(in_array($this->forcesRemoval, [1, 2]), function ($query) {
            // Filter according to the value of forcesRemoval
            return $query->where('dambadiwa_crews.forcesRemoval', $this->forcesRemoval);
        })
        ->when(!in_array($this->courtOrder, [1, 2, 3]), function ($query) {
            // Show all values if courtOrder is not 1, 2, or 3
            return $query;
        })
        ->when($this->courtOrder == 3, function ($query) {
            // Show only records where courtOrder is null
            return $query->whereNull('dambadiwa_crews.courtOrder');
        })
        ->when(in_array($this->courtOrder, [1, 2]), function ($query) {
            // Filter according to the value of courtOrder
            return $query->where('dambadiwa_crews.courtOrder', $this->courtOrder);
        })
        ->when($category == 1, function ($query) {
            return $query->where('dambadiwa_crews.categoryId', 1);
        })
        ->when($category == 2, function ($query) {
            return $query->where('dambadiwa_crews.categoryId', 2);
        })
        ->when($category == null, function ($query) {
            // No additional filtering needed for both
        })
        ->orderBy('userName', 'DESC')
        ->paginate(10);
        
    }

    public function render()
    {

        $this->categoryList = collect([
            (object) ['id' => 1, 'name' => 'User'],
            (object) ['id' => 2, 'name' => 'Follower'],
        ]);

        $this->optionList = collect([
            (object) ['id' => 3, 'name' => 'Not Entered'],
            (object) ['id' => 1, 'name' => 'Yes'],
            (object) ['id' => 2, 'name' => 'No'],
        ]);

        $results = $this->generateReports();

        return view('livewire.crew-report', ['results' => $results]);
    }
}
