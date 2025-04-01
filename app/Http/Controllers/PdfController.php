<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function crewlistreportpdf(Request $request){
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
        ->select(
            'dambadiwa_crews.id AS id',
            'dambadiwa_crews.crewId',
            'dambadiwa_crews.categoryId',
            'dambadiwa_crews.payment',
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
                END AS otherIllness'),
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

        $pdf = Pdf::loadView('pdf.crew-list-pdf', compact('results'))->setPaper('A3', 'landscape');
        return $pdf->stream('Crew List Report.pdf');
    }

    public function crewreportpdf(Request $request){
        $projectId = $request->query('project_id');
        $crew_id = $request->query('crew_id');
        $category_id = $request->query('category_id');

        if($category_id == 1){
            $crew = DB::table('dambadiwa_crews')
            ->join('users','dambadiwa_crews.crewId','users.id')
            ->leftjoin('user_personal_infos', 'users.id', '=', 'user_personal_infos.userId')
            ->leftjoin('user_contact_infos', 'users.id', '=', 'user_contact_infos.userId')
            ->leftjoin('races', 'user_personal_infos.raceId', '=', 'races.id')
            ->leftjoin('religions', 'user_personal_infos.religionId', '=', 'religions.id')
            ->leftjoin('civil_statuses', 'user_personal_infos.civilStatusId', '=', 'civil_statuses.id')
            ->where('dambadiwa_crews.crewId', $crew_id)
            ->where('dambadiwa_crews.categoryId', $category_id)
            ->where('dambadiwa_crews.active','1')
            ->select(
                'users.id AS crewId','users.name','users.nic','users.email','users.nameWithInitials',
                'user_personal_infos.birthDay','user_personal_infos.genderId',
                DB::raw("CASE 
                    WHEN user_personal_infos.genderId = 1 THEN 'Male' 
                    WHEN user_personal_infos.genderId = 2 THEN 'Female' 
                    ELSE '' 
                END AS gender"),
                'races.name AS race',
                'religions.name AS religion',
                'civil_statuses.name AS civilStatus',
                'user_contact_infos.addressLine1',
                'user_contact_infos.addressLine2',
                'user_contact_infos.addressLine3',
                'user_contact_infos.mobile1',
                'user_contact_infos.mobile2',
                'user_personal_infos.raceId',
                'user_personal_infos.religionId',
                'user_personal_infos.civilStatusId',
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
                'dambadiwa_crews.previousAbroad',
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
                'dambadiwa_crews.passport',
                'dambadiwa_crews.passportNo',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.policeReport = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.policeReport = 2 THEN 'No' 
                    ELSE '' 
                END AS policeReportValue"),
                'dambadiwa_crews.policeReport',
                'dambadiwa_crews.payment',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.diabetes = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.diabetes = 2 THEN 'No' 
                    ELSE '' 
                END AS diabetesValue"),
                'dambadiwa_crews.diabetes',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.highBloodPressure = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.highBloodPressure = 2 THEN 'No' 
                    ELSE '' 
                END AS highBloodPressureValue"),
                'dambadiwa_crews.highBloodPressure',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.asthma = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.asthma = 2 THEN 'No' 
                    ELSE '' 
                END AS asthmaValue"),
                'dambadiwa_crews.asthma',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.apoplexy = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.apoplexy = 2 THEN 'No' 
                    ELSE '' 
                END AS apoplexyValue"),
                'dambadiwa_crews.apoplexy',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.heartDisease = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.heartDisease = 2 THEN 'No' 
                    ELSE '' 
                END AS heartDiseaseValue"),
                'dambadiwa_crews.heartDisease',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.otherIllness = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.otherIllness = 2 THEN 'No' 
                    ELSE '' 
                END AS otherIllnessValue"),
                'dambadiwa_crews.otherIllness',
                'dambadiwa_crews.otherIllnessDescription',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.heartOtherOperation = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.heartOtherOperation = 2 THEN 'No' 
                    ELSE '' 
                END AS heartOtherOperationValue"),
                'dambadiwa_crews.heartOtherOperation',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.artificialHandLeg = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.artificialHandLeg = 2 THEN 'No' 
                    ELSE '' 
                END AS artificialHandLegValue"),
                'dambadiwa_crews.artificialHandLeg',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.mentalIllness = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.mentalIllness = 2 THEN 'No' 
                    ELSE '' 
                END AS mentalIllnessValue"),
                'dambadiwa_crews.mentalIllness',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.forces = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.forces = 2 THEN 'No' 
                    ELSE '' 
                END AS forcesValue"),
                'dambadiwa_crews.forces',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.forcesRemoval = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.forcesRemoval = 2 THEN 'No' 
                    ELSE '' 
                END AS forcesRemovalValue"),
                'dambadiwa_crews.forcesRemoval',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.courtOrder = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.courtOrder = 2 THEN 'No' 
                    ELSE '' 
                END AS courtOrderValue"),
                'dambadiwa_crews.courtOrder',
            )
            ->first();
        }
        else{
            $crew = DB::table('dambadiwa_crews')
            ->leftjoin('followers','dambadiwa_crews.crewId','dambadiwa_crews.crewId')
            ->leftjoin('personal_infos', 'followers.id', '=', 'personal_infos.followerId')
            ->leftjoin('contact_infos', 'followers.id', '=', 'contact_infos.followerId')
            ->leftjoin('races', 'personal_infos.raceId', '=', 'races.id')
            ->leftjoin('religions', 'personal_infos.religionId', '=', 'religions.id')
            ->leftjoin('civil_statuses', 'personal_infos.civilStatusId', '=', 'civil_statuses.id')
            ->leftjoin('districts', 'contact_infos.districtId', '=', 'districts.id')
            ->leftjoin('monasteries', 'contact_infos.monasteryId', '=', 'monasteries.id')
            ->where('dambadiwa_crews.crewId', $crew_id)
            ->where('dambadiwa_crews.categoryId', $category_id)
            ->where('dambadiwa_crews.active','1')
            ->select(
                'followers.id AS crewId','followers.name','followers.nic','followers.email','followers.nameWithInitials',
                'personal_infos.birthDay','personal_infos.genderId',
                DB::raw("CASE 
                    WHEN personal_infos.genderId = 1 THEN 'Male' 
                    WHEN personal_infos.genderId = 2 THEN 'Female' 
                    ELSE '' 
                END AS gender"),
                'races.name AS race',
                'religions.name AS religion',
                'civil_statuses.name AS civilStatus',
                'contact_infos.addressLine1',
                'contact_infos.addressLine2',
                'contact_infos.addressLine3',
                'contact_infos.mobile1',
                'contact_infos.mobile2',
                'contact_infos.districtId',
                'contact_infos.monasteryId',
                'districts.name AS district',
                'personal_infos.raceId',
                'personal_infos.religionId',
                'personal_infos.civilStatusId',
                'monasteries.name AS monastary',
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
                'dambadiwa_crews.previousAbroad',
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
                'dambadiwa_crews.passport',
                'dambadiwa_crews.passportNo',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.policeReport = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.policeReport = 2 THEN 'No' 
                    ELSE '' 
                END AS policeReportValue"),
                'dambadiwa_crews.policeReport',
                'dambadiwa_crews.payment',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.diabetes = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.diabetes = 2 THEN 'No' 
                    ELSE '' 
                END AS diabetesValue"),
                'dambadiwa_crews.diabetes',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.highBloodPressure = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.highBloodPressure = 2 THEN 'No' 
                    ELSE '' 
                END AS highBloodPressureValue"),
                'dambadiwa_crews.highBloodPressure',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.asthma = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.asthma = 2 THEN 'No' 
                    ELSE '' 
                END AS asthmaValue"),
                'dambadiwa_crews.asthma',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.apoplexy = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.apoplexy = 2 THEN 'No' 
                    ELSE '' 
                END AS apoplexyValue"),
                'dambadiwa_crews.apoplexy',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.heartDisease = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.heartDisease = 2 THEN 'No' 
                    ELSE '' 
                END AS heartDiseaseValue"),
                'dambadiwa_crews.heartDisease',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.otherIllness = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.otherIllness = 2 THEN 'No' 
                    ELSE '' 
                END AS otherIllnessValue"),
                'dambadiwa_crews.otherIllness',
                'dambadiwa_crews.otherIllnessDescription',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.heartOtherOperation = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.heartOtherOperation = 2 THEN 'No' 
                    ELSE '' 
                END AS heartOtherOperationValue"),
                'dambadiwa_crews.heartOtherOperation',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.artificialHandLeg = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.artificialHandLeg = 2 THEN 'No' 
                    ELSE '' 
                END AS artificialHandLegValue"),
                'dambadiwa_crews.artificialHandLeg',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.mentalIllness = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.mentalIllness = 2 THEN 'No' 
                    ELSE '' 
                END AS mentalIllnessValue"),
                'dambadiwa_crews.mentalIllness',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.forces = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.forces = 2 THEN 'No' 
                    ELSE '' 
                END AS forcesValue"),
                'dambadiwa_crews.forces',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.forcesRemoval = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.forcesRemoval = 2 THEN 'No' 
                    ELSE '' 
                END AS forcesRemovalValue"),
                'dambadiwa_crews.forcesRemoval',
                DB::raw("CASE 
                    WHEN dambadiwa_crews.courtOrder = 1 THEN 'Yes' 
                    WHEN dambadiwa_crews.courtOrder = 2 THEN 'No' 
                    ELSE '' 
                END AS courtOrderValue"),
                'dambadiwa_crews.courtOrder',
            )
            ->first();
        }

        $pdf = Pdf::loadView('pdf.crew-pdf', compact('projectId','crew_id','category_id','crew'))->setPaper('A4', 'portrait');
        return $pdf->stream('Crew Report.pdf');
    }

    public function payment_slip_pdf(Request $request){
        $projectId = $request->query('projectId');
        $crewId = $request->query('crewId');
        $payment_id = $request->query('payment_id');
        $categoryId = $request->query('categoryId');

        if($categoryId == 1){
            $project_payments = DB::table('dambadiwa_crew_payments')
            ->join('users','dambadiwa_crew_payments.crewId','users.id')
            ->join('user_contact_infos','users.id','user_contact_infos.userId')
            ->join('dambadiwa_projects','dambadiwa_crew_payments.project_id','dambadiwa_projects.id')
            ->join('dambadiwa_crews','dambadiwa_crew_payments.project_id','dambadiwa_crews.projectId')
            ->where('dambadiwa_crew_payments.active','=',1)
            ->where('users.active','=',1)
            ->where('dambadiwa_crew_payments.id','=',$payment_id)
            ->where('dambadiwa_crews.projectId','=',$projectId)
            ->where('dambadiwa_crews.crewId','=',$crewId)
            ->where('dambadiwa_crews.categoryId','=',$categoryId)
            ->select('dambadiwa_crew_payments.*','users.*','user_contact_infos.*','dambadiwa_projects.startDate','dambadiwa_crews.id AS regId')
            ->first();
        }
        else if($categoryId == 2){
            $project_payments = DB::table('dambadiwa_crew_payments')
            ->join('followers','dambadiwa_crew_payments.crewId','followers.id')
            ->join('contact_infos','followers.id','contact_infos.followerId')
            ->join('dambadiwa_projects','dambadiwa_crew_payments.project_id','dambadiwa_projects.id')
            ->join('dambadiwa_crews','dambadiwa_crew_payments.project_id','dambadiwa_crews.projectId')
            ->where('dambadiwa_crew_payments.active','=',1)
            ->where('followers.active','=',1)
            ->where('dambadiwa_crew_payments.id','=',$payment_id)
            ->where('dambadiwa_crews.projectId','=',$projectId)
            ->where('dambadiwa_crews.crewId','=',$crewId)
            ->where('dambadiwa_crews.categoryId','=',$categoryId)
            ->select('dambadiwa_crew_payments.*','followers.*','contact_infos.*','dambadiwa_projects.startDate','dambadiwa_crews.id AS regId')
            ->first();
        }
        
        $pdf = Pdf::loadView('pdf.payment-slip', compact('payment_id','project_payments'))->setPaper('A5', 'landscape');
        return $pdf->stream('Project Payment Receipt.pdf');
    }

    public function project_payment_pdf(Request $request){
        $project = $request->query('project');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
    
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
            ->when($project, function($query) use ($project) {
                return $query->where('dambadiwa_crew_payments.project_id', $project);
            })
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('dambadiwa_crew_payments.addedDate', [$start_date, $end_date]);
            })
            ->where('dambadiwa_crew_payments.active', 1)
            ->where('dambadiwa_crew_payments.confirm_decline', '>', 0)
            ->get();
    
        $pdf = Pdf::loadView('pdf.project-payment-pdf', compact('payment_report'))->setPaper('A4', 'portrait');
        return $pdf->stream('Project Payment Report.pdf');
    }

    public function project_user_payment_pdf(Request $request){
        $project = $request->query('project');
        $search_user = $request->query('search_user');
    
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
            DB::raw("
                CASE 
                    WHEN dambadiwa_crew_payments.categoryId = 1 THEN users.nic 
                    WHEN dambadiwa_crew_payments.categoryId = 2 THEN followers.nic 
                    ELSE NULL 
                END AS nic
            "),
            DB::raw("SUM(dambadiwa_crew_payments.amount) AS total_amount")
        )
        ->when($project, function($query) use ($project) {
            return $query->where('dambadiwa_crew_payments.project_id', $project);
        })
        ->when($search_user, function($query) use ($search_user) {
            return $query->orWhere('users.nameWithInitials', 'LIKE', '%'.$search_user.'%')
            ->orWhere('users.nic', 'LIKE', '%'.$search_user.'%')
            ->orWhere('followers.nic', 'LIKE', '%'.$search_user.'%')
            ->orWhere('followers.nameWithInitials', 'LIKE', '%'.$search_user.'%');
        })
        ->where('dambadiwa_crew_payments.active', 1)
        ->where('dambadiwa_crew_payments.confirm_decline', '>', 0)
        ->groupBy('nameWithInitials', 'nic')
        ->get();
    
        $pdf = Pdf::loadView('pdf.project-user-payment-pdf', compact('payment_report'))->setPaper('A4', 'portrait');
        return $pdf->stream('Project User Payment Report.pdf');
    }
    
}
