<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDambadiwaProjectRequest;
use App\Http\Requests\UpdateDambadiwaProjectRequest;
use Illuminate\Http\Request;
use App\Models\DambadiwaProject;
use App\Models\Race;
use App\Models\Religion;
use App\Models\CivilStatus;
use App\Models\Gender;
use App\Models\Monastery;
use App\Models\ContactInfo;
use App\Models\User;
use App\Models\UserContactInfo;
use App\Models\PersonalInfo;
use App\Models\UserPersonalInfo;
use App\Models\District;
use App\Models\Follower;
use App\Models\DambadiwaCrew;
use App\Models\DambadiwaCrewPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DambadiwaProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = DB::table('dambadiwa_projects')
        ->leftJoin('dambadiwa_crews', function ($join) {
            $join->on('dambadiwa_projects.id', '=', 'dambadiwa_crews.projectId')
                ->where('dambadiwa_crews.active', '=', 1); // Only count active crews
        })
        ->select(
            'dambadiwa_projects.id',
            'dambadiwa_projects.name AS projectName',
            'dambadiwa_projects.startDate',
            'dambadiwa_projects.endDate',
            'dambadiwa_projects.slug',
            DB::raw('COUNT(dambadiwa_crews.id) as crewCount') // Count active crews
        )
        ->where('dambadiwa_projects.current', 1)
        ->where('dambadiwa_projects.active', 1)
        ->groupBy(
            'dambadiwa_projects.id',
            'dambadiwa_projects.name',
            'dambadiwa_projects.startDate',
            'dambadiwa_projects.endDate',
            'dambadiwa_projects.slug'
        )
        ->get();


        $chartData = [
            ['dambadiwa', 'Amount'],
            ["test 1", 44],
            ["test 2", 31],
            ["test 3", 12],
            ["test 4", 10],
            ['test 5', 3]
        ];
        $option = [
            'Dambadiwa' => '',
        ];

        $card_pack_1 = collect([]);

        if ($projects) {
            foreach ($projects as $key => $value) {
                $card_pack_1->push((object) [
                    'id' => $value->id,
                    'name' => $value->projectName,
                    'startDate' => $value->startDate,
                    'endDate' => $value->endDate,
                    'slug' => $value->slug,
                    'crewCount' => $value->crewCount,
                ]);
            }
        }
        //dd($card_pack_1);
        return view('dambadiwa/dashboard',compact('option','card_pack_1','chartData'));
    }

    public function crew(Request $request)
    {
        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Dambadiwa Crew' => ''
        ];

        if($request->has('id')){
            $project = DB::table('dambadiwa_projects')
            ->select(
                'dambadiwa_projects.id',
                'dambadiwa_projects.name AS projectName',
                'dambadiwa_projects.startDate',
                'dambadiwa_projects.endDate',
            )
            ->where('dambadiwa_projects.id', $request->id)
            ->where('dambadiwa_projects.active', 1)
            ->first();

            return view('dambadiwa/crew',compact('project','option'));
        }else{
            return redirect()->route('dambadiwa.dashboard');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Dambadiwa Project Registration' => ''
        ];
        return view('dambadiwa/register',compact('option'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDambadiwaProjectRequest $request)
    {
        $option = [
            'Dambadiwa Project Registration' => route('dambadiwa.register'),
        ];

        $dambadiwaProject = DambadiwaProject::create([
            'name' => ucwords(strtolower($request->name)),
            'fee' => $request->fee,
            'startDate' => $request->startDate,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'endDate' => $request->endDate,
        ]);

        session()->flash('success', 'Project has been successfully registered!');

        return view('dambadiwa/register',compact('option'));
    }

    public function project(Request $request)
    {
        $projectId = $request->query('id');

        $categoryCounts = DB::table('dambadiwa_crews')
        ->select(
            DB::raw('SUM(CASE WHEN categoryId = 1 THEN 1 ELSE 0 END) as userCount'),
            DB::raw('SUM(CASE WHEN categoryId = 2 THEN 1 ELSE 0 END) as followerCount')
        )
        ->where('projectId', $projectId)
        ->where('active', 1)
        ->first();

        $chartData = [
            ['dambadiwa', 'Amount'],
            ["test 1", 2],
            ["test 2", 31],
            ["test 3", 12],
            ["test 4", 10],
            ['test 5', 3]
        ];
        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Project' => '',
        ];

        $card_pack_1 = collect([
            (object) [
                'id' => 1,
                'name' => 'Users',
                'user_count' => $categoryCounts->userCount."/".$categoryCounts->userCount+$categoryCounts->followerCount,
            ],
            (object) [
                'id' => 2,
                'name' => 'Followers',
                'user_count' => $categoryCounts->followerCount."/".$categoryCounts->userCount+$categoryCounts->followerCount,
            ],
        ]);

        return view('dambadiwa/project',compact('option','card_pack_1','chartData','projectId'));
    }

    public function project_crew(Request $request){
        $projectId = $request->query('id');
        $crew_type = $request->query('crew_type');

        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Project' => route('dambadiwa.project', ['id' => $projectId]),
            'Crew List' => '',
        ];
        return view('dambadiwa/crewlist',compact('option', 'projectId', 'crew_type'));
    }

    public function crewcreate(Request $request)
    {

        $projectId = $request->query('id');

        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Project' => route('dambadiwa.project', ['id' => $projectId]),
            'Search Crew' => '',
        ];

        return view('dambadiwa/crewregister',compact('option', 'projectId'));
    }

    public function crewlist(Request $request)
    {
        $projectId = $request->query('id');
        $crew_type = $request->query('crew_type');

        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Project' => route('dambadiwa.project', ['id' => $projectId]),
        ];
        return view('dambadiwa/crewlist',compact('option', 'projectId','crew_type'));
    }


    public function crewprofile(Request $request)
    {
        $projectId = $request->query('project_id');
        $crew_id = $request->query('crew_id');
        $category_id = $request->query('category_id');

        $races = Race::where('active', 1)->get();
        $religions = Religion::where('active', 1)->get();
        $civilStatuses = CivilStatus::where('active', 1)->get();
        $genders = Gender::where('active', 1)->get();
        $monasteries = Monastery::where('active', 1)->get();
        $districts = District::where('active', 1)->get();
        $yesNo = collect([
            (object) [
                'id' => 1,
                'name' => 'Yes',
            ],
            (object) [
                'id' => 2,
                'name' => 'No',
            ],
        ]);

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

        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Project' => route('dambadiwa.project', ['id' => $projectId]),
            'Crew List' => route('dambadiwa.crewlist', ['id' => $projectId,'crew_type' => $category_id]),
            'Crew Profile' => '',
        ];
        return view('dambadiwa/crewprofile',compact('option','projectId','crew_id','category_id','crew','races','religions','civilStatuses','genders','monasteries','districts','yesNo'));
    }

    public function edit_crew_profile(Request $request){
        $projectId = $request->query('project_id');
        $crew_id = $request->query('crew_id');
        $category_id = $request->query('category_id');

        if($category_id == 1){
            $user = User::where('id',$crew_id)->update(
                [
                    'name'=>$request->name,
                    'nameWithInitials' => $request->nameWithInitials,
                    'nic' => $request->nic,
                    'email' => $request->email,
                ]
            );

            $UserContactInfo = UserContactInfo::where('userId',$crew_id)->update([
                'addressLine1' => ucwords(strtolower($request->addressLine1)),
                'addressLine2' => ucwords(strtolower($request->addressLine2)),
                'addressLine3' => ucwords(strtolower($request->addressLine3)),
                'mobile1' => $request->mobile1,
                'mobile2' => $request->mobile2,
            ]);

            $userpersonalInfo = UserPersonalInfo::where('userId',$crew_id)->update([
                'raceId' => $request->race,
                'religionId' => $request->religion,
                'civilStatusId' => $request->civilStatus,
                'genderId' => $request->gender,
                'birthDay' => $request->birthDay,
            ]);

            $dambadiwa_crew_existing = DambadiwaCrew::where('crewId',$crew_id)->where('categoryId',$category_id)
            ->where('active', 1)
            ->first();

            if ($request->hasFile('passportImage')) {
                $uploadPath = public_path('attachments/passport/');

                $existingPassportImage = $dambadiwa_crew_existing->passportImage;
                if ($existingPassportImage && file_exists($uploadPath . $existingPassportImage)) {
                    unlink($uploadPath . $existingPassportImage);
                }

                $passportImage = 'Passport-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('passportImage')->getClientOriginalExtension();
                $passportImageMove = $request->file('passportImage')->move(public_path('attachments/passport/'), $passportImage);
            }
            else{
                $passportImage = $dambadiwa_crew_existing->passportImage;
            }

            if ($request->hasFile('passportBookImage')) {
                $uploadPath = public_path('attachments/passport/');

                $existingpassportBookImage = $dambadiwa_crew_existing->passportBookImage;
                if ($existingpassportBookImage && file_exists($uploadPath . $existingpassportBookImage)) {
                    unlink($uploadPath . $existingpassportBookImage);
                }
                $passportBookImage = 'Passport-Book-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('passportBookImage')->getClientOriginalExtension();
                $passportBookImageMove = $request->file('passportBookImage')->move(public_path('attachments/passport/'), $passportBookImage);
            }else{
                $passportBookImage = $dambadiwa_crew_existing->passportBookImage;
            }

            if ($request->hasFile('visaDocument')) {
                $uploadPath = public_path('attachments/visa/');

                $existingvisaDocument = $dambadiwa_crew_existing->visaDocument;
                if ($existingvisaDocument && file_exists($uploadPath . $existingvisaDocument)) {
                    unlink($uploadPath . $existingvisaDocument);
                }
                $visaDocument = 'Visa-Document-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('visaDocument')->getClientOriginalExtension();
                $visaDocumentMove = $request->file('visaDocument')->move(public_path('attachments/visa/'), $visaDocument);
            }else{
                $visaDocument = $dambadiwa_crew_existing->visaDocument;
            }

            if ($request->hasFile('policeReportDocument')) {
                $uploadPath = public_path('attachments/policereport/');

                $existingpoliceReportDocument = $dambadiwa_crew_existing->policeReportDocument;
                if ($existingpoliceReportDocument && file_exists($uploadPath . $existingpoliceReportDocument)) {
                    unlink($uploadPath . $existingpoliceReportDocument);
                }
                $policeReportDocument = 'Police-Report-Document-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('policeReportDocument')->getClientOriginalExtension();
                $policeReportDocumentMove = $request->file('policeReportDocument')->move(public_path('attachments/policereport/'), $policeReportDocument);
            }else{
                $policeReportDocument = $dambadiwa_crew_existing->policeReportDocument;
            }

            if ($request->hasFile('birthCertificate')) {
                $uploadPath = public_path('attachments/birthCertificate/');

                $existingbirthCertificate = $dambadiwa_crew_existing->birthCertificate;
                if ($existingbirthCertificate && file_exists($uploadPath . $existingbirthCertificate)) {
                    unlink($uploadPath . $existingbirthCertificate);
                }
                $birthCertificate = 'Police-Report-Document-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('birthCertificate')->getClientOriginalExtension();
                $birthCertificateMove = $request->file('birthCertificate')->move(public_path('attachments/birthCertificate/'), $birthCertificate);
            }else{
                $birthCertificate = $dambadiwa_crew_existing->birthCertificate;
            }

            if ($request->hasFile('medicalDocument')) {
                $uploadPath = public_path('attachments/medicalDocument/');

                $existingmedicalDocument = $dambadiwa_crew_existing->medicalDocument;
                if ($existingmedicalDocument && file_exists($uploadPath . $existingmedicalDocument)) {
                    unlink($uploadPath . $existingmedicalDocument);
                }
                $medicalDocument = 'Police-Report-Document-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('medicalDocument')->getClientOriginalExtension();
                $medicalDocumentMove = $request->file('medicalDocument')->move(public_path('attachments/medicalDocument/'), $medicalDocument);
            }else{
                $medicalDocument = $dambadiwa_crew_existing->medicalDocument;
            }

            $dambadiwa_crew = DambadiwaCrew::where('crewId',$crew_id)->where('categoryId',$category_id)->where('active', 1)->update([
                'guardian' => $request->guardian,
                'guardianPhone' => $request->guardianPhone,
                'guardianEmail' => $request->guardianEmail,
                'birthPlace' => $request->birthPlace,
                'occupation' => $request->occupation,
                'previousAbroad' => $request->previousAbroad,
                'spouse' => $request->spouse,
                'spousebirthPlace' => $request->spousebirthPlace,
                'spouseOccupation' => $request->spouseOccupation,
                'mother' => $request->mother,
                'motherBirthPlace' => $request->motherBirthPlace,
                'motherOccupation' => $request->motherOccupation,
                'father' => $request->father,
                'fatherBirthPlace' => $request->fatherBirthPlace,
                'fatherOccupation' => $request->fatherOccupation,
                'passport' => $request->passport,
                'passportNo' => $request->passportNo,
                'passportImage' => $passportImage,
                'passportBookImage' => $passportBookImage,
                'policeReportDocument' => $policeReportDocument,
                'birthCertificate' => $birthCertificate,
                'payment' => $request->payment,
                'diabetes' => $request->diabetes,
                'highBloodPressure' => $request->highBloodPressure,
                'asthma' => $request->asthma,
                'apoplexy' => $request->apoplexy,
                'heartDisease' => $request->heartDisease,
                'otherIllness' => $request->otherIllness,
                'otherIllnessDescription' => $request->otherIllnessDescription,
                'heartOtherOperation' => $request->heartOtherOperation,
                'artificialHandLeg' => $request->artificialHandLeg,
                'mentalIllness' => $request->mentalIllness,
                'medicalDocument' => $medicalDocument,
                'forces' => $request->forces,
                'forcesRemoval' => $request->forcesRemoval,
                'courtOrder' => $request->courtOrder,
            ]);

            return redirect()->back()->with('success','Update Successfull');
        }
        if($category_id == 2){
            $follower = Follower::where('id',$crew_id)->update(
                [
                    'name'=>$request->name,
                    'nameWithInitials' => $request->nameWithInitials,
                    'nic' => $request->nic,
                    'email' => $request->email,
                ]
            );

            $contactInfo = ContactInfo::where('followerId',$crew_id)->update([
                'addressLine1' => ucwords(strtolower($request->addressLine1)),
                'addressLine2' => ucwords(strtolower($request->addressLine2)),
                'addressLine3' => ucwords(strtolower($request->addressLine3)),
                'districtId' => $request->district,
                'monasteryId' => $request->monastery,
                'mobile1' => $request->mobile1,
                'mobile2' => $request->mobile2,
            ]);

            $personalInfo = PersonalInfo::where('followerId',$crew_id)->update([
                'raceId' => $request->race,
                'religionId' => $request->religion,
                'civilStatusId' => $request->civilStatus,
                'genderId' => $request->gender,
                'birthDay' => $request->birthDay,
            ]);

            $dambadiwa_crew_existing = DambadiwaCrew::where('crewId',$crew_id)->where('categoryId',$category_id)
            ->where('active', 1)
            ->first();

            if ($request->hasFile('passportImage')) {
                $uploadPath = public_path('attachments/passport/');

                $existingPassportImage = $dambadiwa_crew_existing->passportImage;
                if ($existingPassportImage && file_exists($uploadPath . $existingPassportImage)) {
                    unlink($uploadPath . $existingPassportImage);
                }

                $passportImage = 'Passport-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('passportImage')->getClientOriginalExtension();
                $passportImageMove = $request->file('passportImage')->move(public_path('attachments/passport/'), $passportImage);
            }
            else{
                $passportImage = $dambadiwa_crew_existing->passportImage;
            }

            if ($request->hasFile('passportBookImage')) {
                $uploadPath = public_path('attachments/passport/');

                $existingpassportBookImage = $dambadiwa_crew_existing->passportBookImage;
                if ($existingpassportBookImage && file_exists($uploadPath . $existingpassportBookImage)) {
                    unlink($uploadPath . $existingpassportBookImage);
                }
                $passportBookImage = 'Passport-Book-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('passportBookImage')->getClientOriginalExtension();
                $passportBookImageMove = $request->file('passportBookImage')->move(public_path('attachments/passport/'), $passportBookImage);
            }else{
                $passportBookImage = $dambadiwa_crew_existing->passportBookImage;
            }

            if ($request->hasFile('visaDocument')) {
                $uploadPath = public_path('attachments/visa/');

                $existingvisaDocument = $dambadiwa_crew_existing->visaDocument;
                if ($existingvisaDocument && file_exists($uploadPath . $existingvisaDocument)) {
                    unlink($uploadPath . $existingvisaDocument);
                }
                $visaDocument = 'Visa-Document-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('visaDocument')->getClientOriginalExtension();
                $visaDocumentMove = $request->file('visaDocument')->move(public_path('attachments/visa/'), $visaDocument);
            }else{
                $visaDocument = $dambadiwa_crew_existing->visaDocument;
            }

            if ($request->hasFile('policeReportDocument')) {
                $uploadPath = public_path('attachments/policereport/');

                $existingpoliceReportDocument = $dambadiwa_crew_existing->policeReportDocument;
                if ($existingpoliceReportDocument && file_exists($uploadPath . $existingpoliceReportDocument)) {
                    unlink($uploadPath . $existingpoliceReportDocument);
                }
                $policeReportDocument = 'Police-Report-Document-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('policeReportDocument')->getClientOriginalExtension();
                $policeReportDocumentMove = $request->file('policeReportDocument')->move(public_path('attachments/policereport/'), $policeReportDocument);
            }else{
                $policeReportDocument = $dambadiwa_crew_existing->policeReportDocument;
            }

            if ($request->hasFile('birthCertificate')) {
                $uploadPath = public_path('attachments/birthCertificate/');

                $existingbirthCertificate = $dambadiwa_crew_existing->birthCertificate;
                if ($existingbirthCertificate && file_exists($uploadPath . $existingbirthCertificate)) {
                    unlink($uploadPath . $existingbirthCertificate);
                }
                $birthCertificate = 'Birth-Certificate-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('birthCertificate')->getClientOriginalExtension();
                $birthCertificateMove = $request->file('birthCertificate')->move(public_path('attachments/birthCertificate/'), $birthCertificate);
            }else{
                $birthCertificate = $dambadiwa_crew_existing->birthCertificate;
            }

            if ($request->hasFile('medicalDocument')) {
                $uploadPath = public_path('attachments/medicalDocument/');

                $existingmedicalDocument = $dambadiwa_crew_existing->medicalDocument;
                if ($existingmedicalDocument && file_exists($uploadPath . $existingmedicalDocument)) {
                    unlink($uploadPath . $existingmedicalDocument);
                }
                $medicalDocument = 'Medical-Document-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('medicalDocument')->getClientOriginalExtension();
                $medicalDocumentMove = $request->file('medicalDocument')->move(public_path('attachments/medicalDocument/'), $medicalDocument);
            }else{
                $medicalDocument = $dambadiwa_crew_existing->medicalDocument;
            }

            $dambadiwa_crew = DambadiwaCrew::where('crewId',$crew_id)->where('categoryId',$category_id)->where('active', 1)->update([
                'guardian' => $request->guardian,
                'guardianPhone' => $request->guardianPhone,
                'guardianEmail' => $request->guardianEmail,
                'birthPlace' => $request->birthPlace,
                'occupation' => $request->occupation,
                'previousAbroad' => $request->previousAbroad,
                'spouse' => $request->spouse,
                'spousebirthPlace' => $request->spousebirthPlace,
                'spouseOccupation' => $request->spouseOccupation,
                'mother' => $request->mother,
                'motherBirthPlace' => $request->motherBirthPlace,
                'motherOccupation' => $request->motherOccupation,
                'father' => $request->father,
                'fatherBirthPlace' => $request->fatherBirthPlace,
                'fatherOccupation' => $request->fatherOccupation,
                'passport' => $request->passport,
                'passportNo' => $request->passportNo,
                'passportImage' => $passportImage,
                'passportBookImage' => $passportBookImage,
                'policeReportDocument' => $policeReportDocument,
                'birthCertificate' => $birthCertificate,
                'payment' => $request->payment,
                'diabetes' => $request->diabetes,
                'highBloodPressure' => $request->highBloodPressure,
                'asthma' => $request->asthma,
                'apoplexy' => $request->apoplexy,
                'heartDisease' => $request->heartDisease,
                'otherIllness' => $request->otherIllness,
                'otherIllnessDescription' => $request->otherIllnessDescription,
                'heartOtherOperation' => $request->heartOtherOperation,
                'artificialHandLeg' => $request->artificialHandLeg,
                'mentalIllness' => $request->mentalIllness,
                'medicalDocument' => $medicalDocument,
                'forces' => $request->forces,
                'forcesRemoval' => $request->forcesRemoval,
                'courtOrder' => $request->courtOrder,
            ]);

            return redirect()->back()->with('success','Update Successfull');
        }
    }

    public function project_payment(Request $request)
    {
        $projectId = $request->query('project_id');
        $crew_id = $request->query('crew_id');
        $categoryId = $request->query('category_id');
        $nic = $request->query('nic');

        $project = DB::table('dambadiwa_projects')->where('active','=',1)->where('id','=',$projectId)->first();
        $project_payments = DB::table('dambadiwa_crew_payments')
        ->where('active','=',1)
        ->where('project_id','=',$projectId)
        ->where('crewId','=',$crew_id)
        ->where('categoryId','=',$categoryId)
        ->get();

        $paymentMethod = collect([
            (object) [
                'id' => 1,
                'name' => 'Bank',
            ],
            (object) [
                'id' => 2,
                'name' => 'Cash',
            ],
        ]);

        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Project' => route('dambadiwa.project', ['id' => $projectId]),
            'Crew List' => route('dambadiwa.crewlist', ['id' => $projectId,'crew_type' => $categoryId]),
            'Project Payment' => '',
        ];

        return view('dambadiwa.project-payment',compact('option','projectId','crew_id','categoryId','project','project_payments','paymentMethod','nic'));
    }

    public function project_payment_create(Request $request)
    {
        $projectId = $request->query('projectId');
        $crewId = $request->query('crewId');
        $categoryId = $request->query('categoryId');
        $nic = $request->query('nic');

        $current_date = date('Y-m-d');
        $userId = Auth::user()->id;

        if($request->payment_method == 1){
            $validated = $request->validate([
                'payment_method' => 'required|numeric|min:1',
                'amount' => 'required|numeric|min:1',
                'reciptImage' => 'required',
                'reciptNo' => 'required',
                'addedDate' => 'required|date',
            ]);
        }else{
            $validated = $request->validate([
                'payment_method' => 'required|numeric|min:1',
                'amount' => 'required|numeric|min:1',
                'addedDate' => 'required|date',
            ]);
        }

        if ($request->hasFile('reciptImage')) {
            $reciptImage = 'Payment-Slip-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('reciptImage')->getClientOriginalExtension();
            $reciptImageMove = $request->file('reciptImage')->move(public_path('attachments/payments/'), $reciptImage);
            $slip_no = $request->reciptNo;
        }
        else{
            $reciptImage = '';
            $slip_no = '';
        }

        $project_payment = DambadiwaCrewPayment::create([
            'project_id' => $projectId,
            'crewId' => $crewId,
            'categoryId' => $categoryId,
            'nic' => $nic,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'reciptImage' => $reciptImage,
            'reciptNo' => $slip_no,
            'addedDate' => $request->addedDate,
            'confirmedId' => $userId,
            'confirmedDate' => $current_date,
        ]);

        return redirect()->back()->with('success','payment Successfull');
    }

    public function payment(Request $request)
    {
        $projects = DB::table('dambadiwa_projects')->where('active','=',1)->get();
        $paymentMethod = collect([
            (object) [
                'id' => 1,
                'name' => 'Bank',
            ],
        ]);

        $option = [
            'Home' => url('/'),
            'Payment' => '',
        ];

        return view('payment',compact('option','projects','paymentMethod'));
    }

    public function payment_create(Request $request)
    {
        $current_date = date('Y-m-d');
        $nic = $request->nic;

        if($request->payment_method == 1){
            $validated = $request->validate([
                'project' => 'required|numeric|min:1',
                'payment_method' => 'required|numeric|min:1',
                'amount' => 'required|numeric|min:1',
                'reciptImage' => 'required',
                'reciptNo' => 'required',
                'addedDate' => 'required|date',
            ]);
        }else{
            $validated = $request->validate([
                'project' => 'required|numeric|min:1',
                'payment_method' => 'required|numeric|min:1',
                'amount' => 'required|numeric|min:1',
                'addedDate' => 'required|date',
            ]);
        }

        $follower_check = DB::table('followers')->where('nic',$nic)->where('active','1')->first();

        if(!empty($follower_check)){
            if ($request->hasFile('reciptImage')) {
                $reciptImage = 'Payment-Slip-'.now()->format('Ymd-His').rand(0000,9999).'.'.$request->file('reciptImage')->getClientOriginalExtension();
                $reciptImageMove = $request->file('reciptImage')->move(public_path('attachments/payments/'), $reciptImage);
                $slip_no = $request->reciptNo;
            }
            else{
                $reciptImage = '';
                $slip_no = '';
            }
    
            $project_payment = DambadiwaCrewPayment::create([
                'project_id' => $request->project,
                'crewId' => $follower_check->id,
                'categoryId' => 2,
                'nic' => $nic,
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'reciptImage' => $reciptImage,
                'reciptNo' => $slip_no,
                'addedDate' => $request->addedDate,
                'confirmedId' => 0,
            ]);
    
            return redirect()->route('payment_success', compact('project_payment'));
        }else{
            return redirect()->back()->with('error','User Not Found!');
        }
        
    }

    public function payment_confirm(Request $request){
        $payment_id = $request->query('payment_id');
        $current_date = date('Y-m-d');
        $userId = Auth::user()->id;

        $dambadiwa_crew = DambadiwaCrewPayment::where('id',$payment_id)->where('active', 1)->update([
            'confirmedId' => $userId,
            'confirmedDate' => $current_date,
            'confirm_decline' => 1,
        ]);

        return redirect()->back()->with('success','Payment Confirm Successfull');
    }

    public function payment_decline(Request $request){
        $payment_id = $request->query('payment_id');
        $current_date = date('Y-m-d');
        $userId = Auth::user()->id;

        $dambadiwa_crew = DambadiwaCrewPayment::where('id',$payment_id)->where('active', 1)->update([
            'confirmedId' => $userId,
            'confirmedDate' => $current_date,
            'confirm_decline' => 2,
        ]);

        return redirect()->back()->with('success','Payment Decline Successfull');
    }

    public function payment_success(Request $request){
        $project_payment_id = $request->query('project_payment');

        $project_payments = DB::table('dambadiwa_crew_payments')
        ->join('followers','dambadiwa_crew_payments.crewId','followers.id')
        ->where('dambadiwa_crew_payments.active','=',1)
        ->where('followers.active','=',1)
        ->where('dambadiwa_crew_payments.id','=',$project_payment_id)
        ->first();

        return view('payment_success', compact('project_payments'));
    }

    public function reports(Request $request){
        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Project Reports' => '',
        ];

        return view('dambadiwa.project_reports', compact('option'));
    }

    public function project_payment_report(Request $request){
        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Project Reports' => route('dambadiwa.reports'),
            'Project Payment Reports' => '',
        ];

        return view('dambadiwa.project_payment_report', compact('option'));
    }

    public function project_user_payment_report(Request $request){
        $option = [
            'Dambadiwa' => route('dambadiwa.dashboard'),
            'Project Reports' => route('dambadiwa.reports'),
            'Project User Payment Reports' => '',
        ];

        return view('dambadiwa.project_user_payment_report', compact('option'));
    }

    /**
     * Display the specified resource.
     */
    public function show(DambadiwaProject $dambadiwaProject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DambadiwaProject $dambadiwaProject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDambadiwaProjectRequest $request, DambadiwaProject $dambadiwaProject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DambadiwaProject $dambadiwaProject)
    {
        //
    }
}
