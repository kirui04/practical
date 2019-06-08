<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home()
    {
        # List projects
        $pager = request('rows', 10);
        $projects = Project::paginate($pager);
        return view('home', ['projects' => $projects]);
    }

    public function form(Request $request)
    {
        # Add or edit project
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'reference' => 'required'
            ]);
            $project = Project::findOrNew($request->id);
            $project->fill($request->all());
            $project->save();

            # Save countries (many to many relationship)
            $project->countries()->sync($request->country_ids);

            return back()->withOk('Saved');
        }

        $project = Project::find(request()->id);
        if ($request->has('delete')) {
            $project->delete();
            return back();
        }
        return view('form', ['project' => $project]);
    }

    public function data()
    {
        # Migrate sample data from excel file
        $path = base_path("file.csv");
        $raw = array_map('str_getcsv', file($path));

        $keys = collect(array_slice($raw, 0, 1)[0])->map(function ($key) {
            return trim(strtolower($key));
        });

        $data = collect(array_slice($raw, 1))->map(function ($values) use ($keys) {
            return @(object)array_combine($keys->toArray(), $values);
        });

        foreach ($data as $row) {
            // Countries
            if (!DB::table('countries')->where('name', @$row->country)->exists() && @$row->country) {
                DB::table('countries')->insert(['name' => @$row->country]);
            }
            // Officers
            if (!DB::table('officers')->where('name', @$row->officer)->exists() && @$row->officer) {
                DB::table('officers')->insert(['name' => @$row->officer]);
            }
            // Readiness
            if (!DB::table('readiness')->where('readiness', @$row->readiness)->exists() && @$row->readiness) {
                DB::table('readiness')->insert(['readiness' => @$row->readiness]);
            }
            // Readiness types
            if (!DB::table('readiness_types')->where('type', @$row->readiness_type)->exists() && @$row->readiness_type) {
                DB::table('readiness_types')->insert(['type' => @$row->readiness_type]);
            }
            // Readiness types
            if (!DB::table('projects')->where('reference', @$row->reference)->exists() && @$row->reference) {
                $id = DB::table('projects')->insertGetId([
                    'reference' => @$row->reference,
                    'title' => @$row->title,
                    'amount' => @$row->amount,
                    'start_date' => @$row->start_date,
                    'end_date' => @$row->end_date,
                    'status' => @$row->status,
                    'officer_id' => optional(DB::table('officers')->where('name', @$row->officer)->first())->id ?? 1,
                    'readiness_id' => optional(DB::table('readiness')->where('readiness', @$row->officer)->first())->id ?? 1,
                    'readiness_type_id' => optional(DB::table('readiness_types')->where('type', @$row->readiness_type)->first())->id ?? 1,
                ]);
                // Disbursements
                DB::table('disbursements')->insert([
                    'project_id' => $id,
                    'amount' => @$row->first_amount
                ]);
            }
        }
      return redirect('home');
    }
}
