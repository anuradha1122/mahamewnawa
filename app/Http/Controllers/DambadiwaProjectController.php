<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDambadiwaProjectRequest;
use App\Http\Requests\UpdateDambadiwaProjectRequest;
use Illuminate\Http\Request;
use App\Models\DambadiwaProject;
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
            'Dashboard' => 'dashboard',
            'Dambadiwa Dashboard' => 'dambadiwa.dashboard',
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
            'Dashboard' => 'dambadiwa.dashboard',
            'Dambadiwa Crew' => 'dambadiwa.crew'
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
            'Dashboard' => 'dambadiwa.dashboard',
            'Dambadiwa Project Registration' => 'dambadiwa.register'
        ];
        return view('dambadiwa/register',compact('option'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDambadiwaProjectRequest $request)
    {
        $option = [
            'Dashboard' => 'dambadiwa.dashboard',
            'Dambadiwa Project Registration' => 'dambadiwa.register'
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

    public function project($id)
    {
        $project = DambadiwaProject::where('slug', $id)->first();
        $projectId = $project->id;
        //dd($projectId);
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
        $option = ['Dashboard' => 'dambadiwa.dashboard'];

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

        return view('dambadiwa/project',compact('option','project','card_pack_1','chartData'));
    }

    public function crewcreate($id)
    {

        $projectId = $id;

        $option = [
            'Dashboard' => 'dambadiwa.dashboard',
            'Dambadiwa Project Profile' => function () use ($id) {
                return route('dambadiwa.project', ['id' => $id]);
            },
        ];

        return view('dambadiwa/crewregister',compact('option', 'projectId'));
    }

    public function crewlist($id)
    {
        $projectSlug = $id;
        $option = [
            'Dashboard' => 'dambadiwa.dashboard',
            'Dambadiwa Project Profile' => function () use ($id) {
                return route('dambadiwa.project', ['id' => $id]);
            },
        ];
        return view('dambadiwa/crewlist',compact('option', 'projectSlug'));
    }


    public function crewprofile($projectSlug, $id, $categoryId)
    {
        dd($projectSlug, $id, $categoryId);
        $option = [
            'Dashboard' => 'dambadiwa.dashboard',
            'Dambadiwa Project Profile' => function () use ($id) {
                return route('dambadiwa.project', ['id' => $id]);
            },
        ];
        return view('dambadiwa/crewlist',compact('option', 'projectSlug'));
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
