<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\Race;
use App\Models\Religion;
use App\Models\CivilStatus;
use App\Models\Gender;
use App\Models\Monastery;
use App\Models\UserCategory;
use App\Models\UserContactInfo;
use App\Models\UserPersonalInfo;
use App\Models\Position;
use App\Models\User;
use App\Models\UserAppointment;
use App\Models\AppointmentPosition;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
    {
        $totalCounts = DB::table('user_personal_infos')
        ->join('users', 'users.id', '=', 'user_personal_infos.userId')
        ->join('user_appointments', 'users.id', '=', 'user_appointments.userId')
        ->join('monasteries', 'user_appointments.monasteryId', '=', 'monasteries.id')
        ->select(
            DB::raw('SUM(CASE WHEN user_personal_infos.genderId = 1 THEN 1 ELSE 0 END) AS male'),
            DB::raw('SUM(CASE WHEN user_personal_infos.genderId = 2 THEN 1 ELSE 0 END) AS female'),
            DB::raw('SUM(CASE WHEN user_personal_infos.categoryId = 1 THEN 1 ELSE 0 END) AS pawidi'),
            DB::raw('SUM(CASE WHEN user_personal_infos.categoryId = 2 THEN 1 ELSE 0 END) AS gihi')
        )
        ->where('user_appointments.current', 1)
        ->whereNull('user_appointments.releasedDate') // Check for NULL releasedDate
        ->first();

        $monasteryCounts = DB::table('user_personal_infos')
        ->join('users', 'users.id', '=', 'user_personal_infos.userId')
        ->join('user_appointments', 'users.id', '=', 'user_appointments.userId')
        ->join('monasteries', 'user_appointments.monasteryId', '=', 'monasteries.id')
        ->select(
            'monasteries.name AS monasteryName',
            DB::raw('COUNT(*) AS totalCount')
        )
        ->where('user_appointments.current', 1)
        ->whereNull('user_appointments.releasedDate')
        ->groupBy('monasteries.name')
        ->get();

        // Prepare chart data
        $chartData = [
            ['Monastery Name', 'Total Count']
        ];

        // Transform query results into the chart data format
        foreach ($monasteryCounts as $count) {
            $chartData[] = [$count->monasteryName, (int) $count->totalCount];
        }

        // $chartData = [
        //     ['Book Catagory', 'Amount'],
        //     ["Novels", 44],
        //     ["Short Story", 31],
        //     ["Documantary", 12],
        //     ["Children's Boos", 10],
        //     ['Other', 3]
        // ];
        $option = ['Dashboard' => 'user.dashboard'];
        
        $card_pack_1 = collect([
            (object) [
                'id' => 1,
                'name' => 'Swamin Wahase',
                'user_count' => $totalCounts->pawidi,
            ],
            (object) [
                'id' => 2,
                'name' => 'Gihi',
                'user_count' => $totalCounts->gihi,
            ],
            (object) [
                'id' => 3,
                'name' => 'Male',
                'user_count' => $totalCounts->male,
            ],
            (object) [
                'id' => 4,
                'name' => 'Female',
                'user_count' => $totalCounts->female,
            ],

        ]);
        //dd($card_pack_1);
        return view('user/dashboard',compact('option','card_pack_1','chartData'));
    }

    public function create()
    {
        $races = Race::where('active', 1)->get();
        $religions = Religion::where('active', 1)->get();
        $civilStatuses = CivilStatus::where('active', 1)->get();
        $genders = Gender::where('active', 1)->get();
        $monasteries = Monastery::where('active', 1)->get();
        $userCategories = userCategory::where('active', 1)->get();
        $positions = Position::where('active', 1)->get();

        $option = [
            'Dashboard' => 'user.dashboard',
            'User Registration' => 'user.register'
        ];
        return view('user/register',compact('option','races','religions','civilStatuses','genders','monasteries','userCategories','positions'));
    }

    public function store(StoreUserRequest $request)
    {
        $races = Race::where('active', 1)->get();
        $religions = Religion::where('active', 1)->get();
        $civilStatuses = CivilStatus::where('active', 1)->get();
        $genders = Gender::where('active', 1)->get();
        $monasteries = Monastery::where('active', 1)->get();
        $userCategories = userCategory::where('active', 1)->get();
        $positions = Position::where('active', 1)->get();

        $option = [
            'Dashboard' => 'user.dashboard',
            'User Registration' => 'user.register'
        ];
        //dd($request);
        //$validatedData = $request->validated();
        $name = $request->name;
        // Convert the full name to an array of words
        $nameParts = explode(' ', $name);
        // Convert all parts to title case
        $nameParts = array_map('ucfirst', $nameParts);
        // Get the last name (the last element in the array)
        $lastName = array_pop($nameParts);
        // Generate initials for the rest of the names
        $initials = array_map(function($part) {
            return strtoupper($part[0]) . '.';
        }, $nameParts);
        // Combine initials and last name
        $nameWithInitials = implode('', $initials) . ' ' . $lastName;
    

        $user = User::create([
            'name' => ucwords(strtolower($request->name)),
            'nameWithInitials' => $nameWithInitials,
            'nic' => strtoupper($request->nic),
            'email' => strtolower($request->email),
            'password' => Hash::make(substr($request->nic, 0, 6)),
        ]);

        $userContactInfo = UserContactInfo::create([
            'userId' => $user->id,
            'addressLine1' => ucwords(strtolower($request->addressLine1)),
            'addressLine2' => ucwords(strtolower($request->addressLine2)),
            'addressLine3' => ucwords(strtolower($request->addressLine3)),
            'mobile1' => $request->mobile1,
            'mobile2' => $request->mobile2,
        ]);
        $userContactInfo->save();

        $userPersonalInfo = UserPersonalInfo::create([
            'userId' => $user->id,
            'raceId' => $request->race,
            'religionId' => $request->religion,
            'civilStatusId' => $request->civilStatus,
            'genderId' => $request->gender,
            'categoryId' => $request->category,
            'birthDay' => $request->birthDay,
        ]);
        $userPersonalInfo->save();

        $userAppointment = UserAppointment::create([
            'userId' => $user->id,
            'monasteryId' => $request->monastery,
            'appointedDate' => $request->startDate,
        ]);
        $userAppointment->save();

        $appointmentPosition = appointmentPosition::create([
            'appointmentId' => $userAppointment->id,
            'positionId' => $request->position,
            'positionedDate' => $request->startDate,
        ]);
        $appointmentPosition->save();

        session()->flash('success', 'User has been successfully registered!');
        
        return view('user/register',compact('option','races','religions','civilStatuses','genders','monasteries','userCategories','positions'));
    }

    public function search()
    {
        $option = [
            'User Dashboard' => 'user.dashboard',
            'User Search' => 'user.search'
        ];
        return view('user/search',compact('option'));
    }

    public function profile(Request $request)
    {
        $option = [
            'User Dashboard' => 'user.dashboard',
            'User Search' => 'user.search',
            'User Profile' => 'user.profile'
        ];
        if($request->has('id')){
            $user = User::leftjoin('user_personal_infos', 'users.id', '=', 'user_personal_infos.userId')
            ->leftjoin('user_contact_infos', 'users.id', '=', 'user_contact_infos.userId')
            ->leftjoin('races', 'user_personal_infos.raceId', '=', 'races.id')
            ->leftjoin('religions', 'user_personal_infos.religionId', '=', 'religions.id')
            ->leftjoin('civil_statuses', 'user_personal_infos.civilStatusId', '=', 'civil_statuses.id')
            ->where('users.id', $request->id)
            ->select(
                'users.id AS userId','users.name AS userName','users.nic','users.email','users.nameWithInitials',
                'user_personal_infos.birthDay',
                DB::raw("CASE 
                    WHEN user_personal_infos.genderId = 1 THEN 'Male' 
                    WHEN user_personal_infos.genderId = 2 THEN 'Female' 
                    ELSE 'Unknown' 
                END AS gender"),
                'races.name AS race',
                'religions.name AS religion',
                'civil_statuses.name AS civilStatus',
                'user_contact_infos.addressLine1',
                'user_contact_infos.addressLine2',
                'user_contact_infos.addressLine3',
                'user_contact_infos.mobile1',
                'user_contact_infos.mobile2',
            )
            ->first();

            $appointments = UserAppointment::join('users', 'users.id', '=', 'user_appointments.userId')
            ->join('monasteries', 'user_appointments.monasteryId', '=', 'monasteries.id')
            ->where('user_appointments.userId', $request->id)
            ->select(
                'user_appointments.id AS id',
                'user_appointments.appointedDate',
                'user_appointments.releasedDate',
                'user_appointments.current AS currentAppointment',
                'monasteries.name AS monastery'
            )
            ->get();


            $appointment = [];
            $appointments_key = [];
            foreach ($appointments as $key => $value) {
                $appointments_key[] = $value->id;
                $appointment[$value->appointmentId] =$value->monastery."(".$value->appointedDate." - ".$value->releasedDate.")";
            }
            //dd($appointments_key);
            $positions = appointmentPosition::join('user_appointments', 'user_appointments.id', '=', 'appointment_positions.appointmentId')
            ->join('positions', 'appointment_positions.positionId', '=', 'positions.id')
            ->join('monasteries', 'user_appointments.monasteryId', '=', 'monasteries.id')
            ->whereIn('user_appointments.id', $appointments_key)
            ->select(
                'appointment_positions.id AS appointmentPositionId',
                'appointment_positions.positionedDate',
                'appointment_positions.releasedDate',
                'user_appointments.current AS currentAppointment',
                'positions.name AS positionName',
                'monasteries.name AS monasteryName',
                'appointment_positions.current AS currentPostion',
            )
            ->get();

            $position = [];
            foreach ($positions as $key => $value) {
                $position[$value->appointmentPositionId] = $value->positionName."(".$value->positionedDate." - ".$value->releasedDate.") [".$value->monasteryName.")]";
            }

            //dd($position);
            //$teacher = null;
            return view('user/profile',compact('user','appointment','position','option'));
            
        }else{
            return redirect()->route('user.search');
        }
    }

    public function reports()
    {
        $option = [
            'User Dashboard' => 'user.dashboard',
            'User Reports' => 'user.reports'
        ];
        return view('user/reports',compact('option'));
    }
}
