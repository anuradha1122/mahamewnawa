<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFollowerRequest;
use App\Http\Requests\UpdateFollowerRequest;
use App\Models\Follower;
use Illuminate\Http\Request;
use App\Models\Race;
use App\Models\Religion;
use App\Models\CivilStatus;
use App\Models\Gender;
use App\Models\Monastery;
use App\Models\ContactInfo;
use App\Models\PersonalInfo;
use App\Models\District;
use Illuminate\Support\Facades\DB;

class FollowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $option = ['Followers' => ''];
        
        $card_pack_1 = collect([
            (object) [
                'id' => 1,
                'name' => 'Male',
                'user_count' => 25,
            ],
            (object) [
                'id' => 2,
                'name' => 'Female',
                'user_count' => 5,
            ],
            (object) [
                'id' => 3,
                'name' => 'Western Province',
                'user_count' => 10,
            ],
            (object) [
                'id' => 4,
                'name' => 'Central Province',
                'user_count' => 8,
            ],
            (object) [
                'id' => 5,
                'name' => 'Estern Province',
                'user_count' => 12,
            ],
            (object) [
                'id' => 3,
                'name' => 'Northern Province',
                'user_count' => 10,
            ],
            (object) [
                'id' => 4,
                'name' => 'North Central Province',
                'user_count' => 8,
            ],
            (object) [
                'id' => 5,
                'name' => 'North Western Province',
                'user_count' => 12,
            ],
            (object) [
                'id' => 3,
                'name' => 'Southern Province',
                'user_count' => 10,
            ],
            (object) [
                'id' => 4,
                'name' => 'Sabaragamuwa Province',
                'user_count' => 8,
            ],
            (object) [
                'id' => 5,
                'name' => 'Uva Province',
                'user_count' => 12,
            ],
        ]);
        //dd($card_pack_1);
        return view('follower/dashboard',compact('option','card_pack_1','chartData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $races = Race::where('active', 1)->get();
        $religions = Religion::where('active', 1)->get();
        $civilStatuses = CivilStatus::where('active', 1)->get();
        $genders = Gender::where('active', 1)->get();
        $monasteries = Monastery::where('active', 1)->get();
        $districts = District::where('active', 1)->get();

        $option = [
            'Followers' => route('follower.dashboard'),
            'Follower Registration' => '',
        ];
        return view('follower/register',compact('option','races','religions','civilStatuses','genders','monasteries','districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFollowerRequest $request)
    {
        $races = Race::where('active', 1)->get();
        $religions = Religion::where('active', 1)->get();
        $civilStatuses = CivilStatus::where('active', 1)->get();
        $monasteries = Monastery::where('active', 1)->get();
        $districts = District::where('active', 1)->get();
    
        $option = [
            'Followers' => route('follower.dashboard'),
            'Follower Registration' => '',
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
    

        $follower = Follower::create([
            'name' => ucwords(strtolower($request->name)),
            'nameWithInitials' => $nameWithInitials,
            'nic' => strtoupper($request->nic),
            'email' => strtolower($request->email),
        ]);

        $contactInfo = ContactInfo::create([
            'followerId' => $follower->id,
            'addressLine1' => ucwords(strtolower($request->addressLine1)),
            'addressLine2' => ucwords(strtolower($request->addressLine2)),
            'addressLine3' => ucwords(strtolower($request->addressLine3)),
            'districtId' => $request->district,
            'monasteryId' => $request->monastery,
            'mobile1' => $request->mobile1,
            'mobile2' => $request->mobile2,
        ]);
        $contactInfo->save();

        $personalInfo = PersonalInfo::create([
            'followerId' => $follower->id,
            'raceId' => $request->race,
            'religionId' => $request->religion,
            'civilStatusId' => $request->civilStatus,
            'genderId' => $request->gender,
            'birthDay' => $request->birthDay,
        ]);
        $personalInfo->save();


        session()->flash('success', 'User has been successfully registered!');
        
        return view('follower/register',compact('option','races','religions','civilStatuses','monasteries','districts'));
    }

    public function profile(Request $request)
    {
        $option = [
            'Followers' => route('follower.dashboard'),
            'Follower Search' => route('follower.search'),
            'Follower Profile' => '',
        ];
        if($request->has('id')){
            $follower = Follower::leftjoin('personal_infos', 'followers.id', '=', 'personal_infos.followerId')
            ->leftjoin('contact_infos', 'followers.id', '=', 'contact_infos.followerId')
            ->leftjoin('races', 'personal_infos.raceId', '=', 'races.id')
            ->leftjoin('religions', 'personal_infos.religionId', '=', 'religions.id')
            ->leftjoin('civil_statuses', 'personal_infos.civilStatusId', '=', 'civil_statuses.id')
            ->where('followers.id', $request->id)
            ->select(
                'followers.id AS followerId','followers.name AS followerName','followers.nic','followers.email','followers.nameWithInitials',
                'personal_infos.birthDay',
                DB::raw("CASE 
                    WHEN personal_infos.genderId = 1 THEN 'Male' 
                    WHEN personal_infos.genderId = 2 THEN 'Female' 
                    ELSE 'Unknown' 
                END AS gender"),
                'races.name AS race',
                'religions.name AS religion',
                'civil_statuses.name AS civilStatus',
                'contact_infos.addressLine1',
                'contact_infos.addressLine2',
                'contact_infos.addressLine3',
                'contact_infos.mobile1',
                'contact_infos.mobile2',
            )
            ->first();

            return view('follower/profile',compact('follower','option'));
            
        }else{
            return redirect()->route('follower.search');
        }
    }

    public function search()
    {
        $option = [
            'Followers' => route('follower.dashboard'),
            'Follower Search' => '',
        ];
        return view('follower/search',compact('option'));
    }

    public function reports()
    {
        $option = [
            'Followers' => route('follower.dashboard'),
            'Follower Reports' => ''
        ];
        return view('follower/reports',compact('option'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Follower $follower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follower $follower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFollowerRequest $request, Follower $follower)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Follower $follower)
    {
        //
    }
}
