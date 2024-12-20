<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Race;
use App\Models\Religion;
use App\Models\CivilStatus;
use App\Models\Gender;
use App\Models\Monastery;
use App\Models\District;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FollowerReport extends Component
{

    public $race;
    public $religion;
    public $civilStatus;
    public $gender;
    public $monastery;
    public $district;
    public $birthDayStart;
    public $birthDayEnd;

    public $raceList;
    public $religionList;
    public $civilStatusList;
    public $genderList;
    public $monasteryList;
    public $districtList;


    public function generateReports(){
        //dd($this->library);
        return $results = DB::table('followers')
        ->join('personal_infos', 'followers.id', '=', 'personal_infos.followerId')
        ->join('contact_infos', 'followers.id', '=', 'contact_infos.followerId')
        ->join('monasteries', 'contact_infos.monasteryId', '=', 'monasteries.id')
        ->leftJoin('civil_statuses', 'personal_infos.civilStatusId', '=', 'civil_statuses.id')
        ->leftJoin('religions', 'personal_infos.religionId', '=', 'religions.id')
        ->leftJoin('races', 'personal_infos.raceId', '=', 'races.id')
        ->leftJoin('genders', 'personal_infos.genderId', '=', 'genders.id')
        ->when($this->race != null && $this->race != 0, function ($query) {
            return $query->where('personal_infos.raceId', $this->race);
        })
        ->when($this->religion != null && $this->religion != 0, function ($query) {
            return $query->where('personal_infos.religionId', $this->religion);
        })
        ->when($this->civilStatus != null && $this->civilStatus != 0, function ($query) {
            return $query->where('personal_infos.civilStatusId', $this->civilStatus);
        })
        ->when($this->gender != null && $this->gender != 0, function ($query) {
            return $query->where('personal_infos.genderId', $this->gender);
        })
        ->when($this->monastery != null && $this->monastery != 0, function ($query) {
            return $query->where('contact_infos.monasteryId', $this->monastery);
        })
        ->when($this->district != null && $this->district != 0, function ($query) {
            return $query->where('contact_infos.districtId', $this->district);
        })
        ->when(true, function ($query) {
            $startDate = $this->birthDayStart ?? '1900-01-01';
            $endDate = $this->birthDayEnd ?? Carbon::now()->toDateString();
            return $query->whereBetween('personal_infos.birthDay', [$startDate, $endDate]);
        })
        ->select(
            'followers.name AS followerName',
            'followers.nameWithInitials',
            'followers.nic',
            'followers.email',
            'races.name AS race',
            'religions.name AS religion',
            'civil_statuses.name AS civilStatus',
            'genders.name AS gender',
            'monasteries.name AS monastery',
            'personal_infos.birthDay'
        )
        ->orderBy('personal_infos.birthDay', 'DESC')
        ->orderBy('followers.name', 'DESC')
        ->paginate(10);
    
        
    }

    public function render()
    {
        $this->raceList = Race::where('active', 1)->get();
        $this->religionList = Religion::where('active', 1)->get();
        $this->civilStatusList = CivilStatus::where('active', 1)->get();
        $this->genderList = Gender::where('active', 1)->get();
        $this->monasteryList = Monastery::where('active', 1)->get();
        $this->districtList = District::where('active', 1)->get();


        $results = $this->generateReports();

        return view('livewire.follower-report', ['results' => $results]);
    }

}
