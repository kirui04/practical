<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 640px;
            }
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('home') }}">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('form') }}">Add Project</a>
        </li>
    </ul>
</nav>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Manage Project</h2>
            <p>Manage project</p>
        </div>
        <div class="card-body">
            <ul>
                @foreach($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            @if(session()->has('ok'))
                <div class="alert alert-success">Added successfully!</div>
            @endif

            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>Project Reference</label>
                    <input class="form-control" name="reference" value="{{ old('reference', @$project->reference) }}"
                           required placeholder="Project reference">
                </div>

                <div class="form-group">
                    <label>Project Title</label>
                    <input class="form-control" name="title" value="{{ old('title', @$project->title) }}" placeholder="Project title" required>
                </div>

                <div class="form-group">
                    <label>Project Amount</label>
                    <input class="form-control" name="amount" value="{{ old('amount', @$project->amount) }}" required placeholder="Amount">
                </div>

                <div class="form-group">
                    <label>Officer</label>
                    <select class="form-control" name="officer_id">
                        @foreach(\App\Officer::all() as $officer)
                            <option value="{{ $officer->id }}"
                                    @if(old('officer_id', @$project->id)==@$project->officer_id) selected @endif>{{ $officer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Readiness</label>
                    <select class="form-control" name="readiness_id">
                        @foreach(\App\Readiness::all() as $r)
                            <option value="{{ $r->id }}"
                                    @if(old('officer_id', @$project->id)==@$project->officer_id) selected @endif>{{ $r->readiness }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Readiness Type</label>
                    <select class="form-control" name="readiness_type_id">
                        @foreach(\App\ReadinessType::all() as $r)
                            <option value="{{ $r->id }}">{{ $r->type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Countries</label>
                    <select multiple class="form-control" style="min-height: 200px" name="country_ids[]">
                        @foreach(\App\Country::all() as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-muted">Press & hold <code>CTRL</code> and click to select many</p>
                </div>

                <div class="form-group">
                    <label>Start Date</label>
                    <input class="form-control" name="start_date" value="{{ old('start_date', @$project->start_date) }}"
                           required>
                </div>

                <div class="form-group">
                    <label>End Date</label>
                    <input class="form-control" name="end_date"
                           value="{{ old('end_date', @$project->end_date) }}"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
