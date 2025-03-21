<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller
{
    public function crewlistreportexcel(Request $request){
        $projectId = $request->query('project_id');
        $crew_type = $request->query('crew_type');
        $category = $request->query('category');
        $diabetes = $request->query('diabetes');
        $highBloodPressure = $request->query('highBloodPressure');
        $asthma = $request->query('asthma');
        $apoplexy = $request->query('apoplexy');
        $heartDisease = $request->query('heartDisease');
        $otherIllness = $request->query('otherIllness');
        $heartOtherOperation = $request->query('heartOtherOperation');
        $artificialHandLeg = $request->query('artificialHandLeg');
        $mentalIllness = $request->query('mentalIllness');
        $forces = $request->query('forces');
        $forcesRemoval = $request->query('forcesRemoval');
        $courtOrder = $request->query('courtOrder');

        $results = DB::table('dambadiwa_crews')
        ->leftJoin('users', function ($join) use ($category) {
            $join->on('dambadiwa_crews.crewId', '=', 'users.id')
                 ->where('dambadiwa_crews.categoryId', 1);
        })
        ->leftJoin('followers', function ($join) use ($category) {
            $join->on('dambadiwa_crews.crewId', '=', 'followers.id')
                 ->where('dambadiwa_crews.categoryId', 2);
        })
        ->leftjoin('user_contact_infos', 'users.id', '=', 'user_contact_infos.userId')
        ->leftjoin('contact_infos', 'followers.id', '=', 'contact_infos.followerId')
        ->leftjoin('districts AS user_district', 'user_contact_infos.districtId', '=', 'user_district.id')
        ->leftjoin('districts AS follower_district', 'contact_infos.districtId', '=', 'follower_district.id')
        ->leftJoin('user_personal_infos', 'users.id', '=', 'user_personal_infos.userId')
        ->leftJoin('personal_infos', 'followers.id', '=', 'personal_infos.followerId')
        ->leftjoin('races AS user_race', 'user_personal_infos.raceId', '=', 'user_race.id')
        ->leftjoin('races AS follower_race', 'personal_infos.raceId', '=', 'follower_race.id')
        ->leftjoin('religions AS user_religions', 'user_personal_infos.religionId', '=', 'user_religions.id')
        ->leftjoin('religions AS followers_religions', 'personal_infos.religionId', '=', 'followers_religions.id')
        ->leftjoin('civil_statuses AS user_civil_status', 'user_personal_infos.civilStatusId', '=', 'user_civil_status.id')
        ->leftjoin('civil_statuses AS follower_civil_status', 'personal_infos.civilStatusId', '=', 'follower_civil_status.id')
        ->leftjoin('monasteries AS user_monastary', 'user_contact_infos.monasteryId', '=', 'user_monastary.id')
        ->leftjoin('monasteries AS follower_monastary', 'contact_infos.monasteryId', '=', 'follower_monastary.id')
        ->select(
            'dambadiwa_crews.id AS id',
            'dambadiwa_crews.crewId',
            'dambadiwa_crews.categoryId',
            'dambadiwa_crews.payment',
            DB::raw('COALESCE(users.name, followers.name) AS userName'),
            DB::raw('COALESCE(users.nameWithInitials, followers.nameWithInitials) AS nameWithInitials'),
            DB::raw('COALESCE(users.nic, followers.nic) AS nic'),
            DB::raw('COALESCE(users.email, followers.email) AS email'),
            DB::raw('COALESCE(user_contact_infos.addressLine1, contact_infos.addressLine1) AS addressLine1'),
            DB::raw('COALESCE(user_contact_infos.addressLine2, contact_infos.addressLine2) AS addressLine2'),
            DB::raw('COALESCE(user_contact_infos.addressLine3, contact_infos.addressLine3) AS addressLine3'),
            DB::raw('COALESCE(user_contact_infos.mobile1, contact_infos.mobile1) AS mobile1'),
            DB::raw('COALESCE(user_contact_infos.mobile2, contact_infos.mobile2) AS mobile2'),
            DB::raw('COALESCE(user_race.name, follower_race.name) AS race'),
            DB::raw('COALESCE(user_religions.name, followers_religions.name) AS religion'),
            DB::raw('COALESCE(user_civil_status.name, follower_civil_status.name) AS civilStatus'),
            DB::raw('COALESCE(user_monastary.name, follower_monastary.name) AS monastary'),
            DB::raw('COALESCE(user_district.name, follower_district.name) AS district'),
            DB::raw('COALESCE(personal_infos.birthDay, user_personal_infos.birthDay) AS birthDay'),
            DB::raw('COALESCE(user_personal_infos.genderId, personal_infos.genderId) AS genderId'),
            'dambadiwa_crews.guardian',
            'dambadiwa_crews.guardianPhone',
            'dambadiwa_crews.guardianEmail',
            'dambadiwa_crews.birthPlace',
            'dambadiwa_crews.occupation',
            DB::raw("CASE 
                WHEN dambadiwa_crews.previousAbroad = 1 THEN 'Yes' 
                WHEN dambadiwa_crews.previousAbroad = 2 THEN 'No' 
                ELSE '' 
                END AS previousAbroadName"),
            'dambadiwa_crews.spouse',
            'dambadiwa_crews.spousebirthPlace',
            'dambadiwa_crews.spouseOccupation',
            'dambadiwa_crews.mother',
            'dambadiwa_crews.motherBirthPlace',
            'dambadiwa_crews.motherOccupation',
            'dambadiwa_crews.father',
            'dambadiwa_crews.fatherBirthPlace',
            'dambadiwa_crews.fatherOccupation',
            DB::raw("CASE 
                WHEN dambadiwa_crews.passport = 1 THEN 'Yes' 
                WHEN dambadiwa_crews.passport = 2 THEN 'No' 
                ELSE '' 
                END AS passportValue"),
            'dambadiwa_crews.passportNo',
            DB::raw("CASE 
                WHEN dambadiwa_crews.policeReport = 1 THEN 'Yes' 
                WHEN dambadiwa_crews.policeReport = 2 THEN 'No' 
                ELSE '' 
                END AS policeReportValue"),
            'dambadiwa_crews.payment',
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
                END AS otherIllness'),
            'dambadiwa_crews.otherIllnessDescription',
            DB::raw('CASE 
                WHEN dambadiwa_crews.heartOtherOperation = 1 THEN "yes" 
                WHEN dambadiwa_crews.heartOtherOperation = 2 THEN "no" 
                ELSE "" 
                END AS heartOtherOperation'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.artificialHandLeg = 1 THEN "yes" 
                WHEN dambadiwa_crews.artificialHandLeg = 2 THEN "no" 
                ELSE "" 
                END AS artificialHandLeg'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.mentalIllness = 1 THEN "yes" 
                WHEN dambadiwa_crews.mentalIllness = 2 THEN "no" 
                ELSE "" 
                END AS mentalIllness'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.forces = 1 THEN "yes" 
                WHEN dambadiwa_crews.forces = 2 THEN "no" 
                ELSE "" 
                END AS forces'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.forcesRemoval = 1 THEN "yes" 
                WHEN dambadiwa_crews.forcesRemoval = 2 THEN "no" 
                ELSE "" 
                END AS forcesRemoval'),
            DB::raw('CASE 
                WHEN dambadiwa_crews.courtOrder = 1 THEN "yes" 
                WHEN dambadiwa_crews.courtOrder = 2 THEN "no" 
                ELSE "" 
                END AS courtOrder')
        )
        ->where('dambadiwa_crews.projectId', $projectId)
        ->where('dambadiwa_crews.active', 1)
        ->when(!empty($crew_type), function ($query) use ($crew_type) {
            return $query->where('dambadiwa_crews.categoryId', $crew_type);
        })
        ->when(!empty($category), function ($query) use ($category) {
            return $query->where('dambadiwa_crews.categoryId', $category);
        })
        ->when(!empty($diabetes), function ($query) use ($diabetes) {
            return $query->where('dambadiwa_crews.diabetes', $diabetes);
        })
        ->when(!empty($highBloodPressure), function ($query) use ($highBloodPressure) {
            return $query->where('dambadiwa_crews.highBloodPressure', $highBloodPressure);
        })
        ->when(!empty($asthma), function ($query) use ($asthma) {
            return $query->where('dambadiwa_crews.asthma', $asthma);
        })
        ->when(!empty($apoplexy), function ($query) use ($apoplexy) {
            return $query->where('dambadiwa_crews.apoplexy', $apoplexy);
        })
        ->when(!empty($heartDisease), function ($query) use ($heartDisease) {
            return $query->where('dambadiwa_crews.heartDisease', $heartDisease);
        })
        ->when(!empty($otherIllness), function ($query) use ($otherIllness) {
            return $query->where('dambadiwa_crews.otherIllness', $otherIllness);
        })
        ->when(!empty($heartOtherOperation), function ($query) use ($heartOtherOperation) {
            return $query->where('dambadiwa_crews.heartOtherOperation', $heartOtherOperation);
        })
        ->when(!empty($artificialHandLeg), function ($query) use ($artificialHandLeg) {
            return $query->where('dambadiwa_crews.artificialHandLeg', $artificialHandLeg);
        })
        ->when(!empty($mentalIllness), function ($query) use ($mentalIllness) {
            return $query->where('dambadiwa_crews.mentalIllness', $mentalIllness);
        })
        ->when(!empty($forces), function ($query) use ($forces) {
            return $query->where('dambadiwa_crews.forces', $forces);
        })
        ->when(!empty($forcesRemoval), function ($query) use ($forcesRemoval) {
            return $query->where('dambadiwa_crews.forcesRemoval', $forcesRemoval);
        })
        ->when(!empty($courtOrder), function ($query) use ($courtOrder) {
            return $query->where('dambadiwa_crews.courtOrder', $courtOrder);
        })
        ->orderBy('userName', 'DESC')
        ->get();

        return view('/excel/crew-list-report-excel',compact('results'));
    }
}
