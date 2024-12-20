<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Race;
use App\Models\Religion;
use App\Models\CivilStatus;
use App\Models\Gender;
use App\Models\Monastery;
use App\Models\UserCategory;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserReport extends Component
{
    public $race;
    public $religion;
    public $civilStatus;
    public $gender;
    public $monastery;
    public $userCategory;
    public $position;
    public $birthDayStart;
    public $birthDayEnd;

    public $raceList;
    public $religionList;
    public $civilStatusList;
    public $genderList;
    public $monasteryList;
    public $userCategoryList;
    public $positionList;

    //public $results =[];

    public function generateReports(){
        //dd($this->library);
        return $results = DB::table('users')
        ->join('user_personal_infos', 'users.id', '=', 'user_personal_infos.userId')
        ->join('user_appointments', 'users.id', '=', 'user_appointments.userId')
        ->join('monasteries', 'user_appointments.monasteryId', '=', 'monasteries.id')
        ->leftJoin('civil_statuses', 'user_personal_infos.civilStatusId', '=', 'civil_statuses.id')
        ->leftJoin('religions', 'user_personal_infos.religionId', '=', 'religions.id')
        ->leftJoin('races', 'user_personal_infos.raceId', '=', 'races.id')
        ->leftJoin('genders', 'user_personal_infos.genderId', '=', 'genders.id')
        ->when($this->race != null && $this->race != 0, function ($query) {
            return $query->where('user_personal_infos.raceId', $this->race);
        })
        ->when($this->religion != null && $this->religion != 0, function ($query) {
            return $query->where('user_personal_infos.religionId', $this->religion);
        })
        ->when($this->civilStatus != null && $this->civilStatus != 0, function ($query) {
            return $query->where('user_personal_infos.civilStatusId', $this->civilStatus);
        })
        ->when($this->gender != null && $this->gender != 0, function ($query) {
            return $query->where('user_personal_infos.genderId', $this->gender);
        })
        ->when($this->monastery != null && $this->monastery != 0, function ($query) {
            return $query->where('user_appointments.monasteryId', $this->monastery);
        })
        ->when($this->position != null && $this->position != 0, function ($query) {
            return $query->where('appointment_positions.positionId', $this->position);
        })
        ->when(true, function ($query) {
            $startDate = $this->birthDayStart ?? '1900-01-01';
            $endDate = $this->birthDayEnd ?? Carbon::now()->toDateString();
            return $query->whereBetween('user_personal_infos.birthDay', [$startDate, $endDate]);
        })
        ->select(
            'users.name AS userName',
            'users.nameWithInitials',
            'users.nic',
            'users.email',
            'races.name AS race',
            'religions.name AS religion',
            'civil_statuses.name AS civilStatus',
            'genders.name AS gender',
            'monasteries.name AS monastery',
            'user_personal_infos.birthDay'
        )
        ->orderBy('user_personal_infos.birthDay', 'DESC')
        ->orderBy('users.name', 'DESC')
        ->paginate(10);
    
        
    }

    public function render()
    {
        $this->raceList = Race::where('active', 1)->get();
        $this->religionList = Religion::where('active', 1)->get();
        $this->civilStatusList = CivilStatus::where('active', 1)->get();
        $this->genderList = Gender::where('active', 1)->get();
        $this->monasteryList = Monastery::where('active', 1)->get();
        $this->userCategoryList = userCategory::where('active', 1)->get();
        $this->positionList = Position::where('active', 1)->get();

        $results = $this->generateReports();

        return view('livewire.user-report', ['results' => $results]);
    }
}
