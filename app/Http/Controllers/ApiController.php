<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function projects()
    {
        return response()->json(Project::paginate(10));
    }

    public function projectCountry($country)
    {
        $country = DB::table('countries')->where('name', $country)->first();

        $projects = Project::get()->filter(function ($project) use ($country) {
            $names =  $project->countries->pluck('name')->toArray();
            return in_array($country->name, $names);

        })->map(function ($project) {
            return $project;
        });
        return response()->json($projects);
    }

    public function projectStatus($status)
    {
        $projects = Project::where('status', $status)->paginate(10);
        return response()->json($projects);
    }
}
