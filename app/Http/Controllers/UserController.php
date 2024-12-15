<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
        $chartData = [
            ['Book Catagory', 'Amount'],
            ["Novels", 44],
            ["Short Story", 31],
            ["Documantary", 12],
            ["Children's Boos", 10],
            ['Other', 3]
        ];
        $option = ['Dashboard' => 'user.dashboard'];
        
        $card_pack_1 = collect([
            (object) [
                'id' => 1,
                'name' => 'Swamin Wahase',
                'user_count' => 25,
            ],
            (object) [
                'id' => 2,
                'name' => 'Gihi',
                'user_count' => 5,
            ],
            (object) [
                'id' => 3,
                'name' => 'SLEAS',
                'user_count' => 10,
            ],
            (object) [
                'id' => 4,
                'name' => 'SLAS',
                'user_count' => 8,
            ],
            (object) [
                'id' => 5,
                'name' => 'Development Officer',
                'user_count' => 12,
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
}
