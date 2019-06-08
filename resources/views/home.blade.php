<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <style>
        .container, .container-fluid {
            font-size: 13px !important;
            margin-top: 50px;
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

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <a href="{{ url('form') }}" class="btn btn-primary float-right">Add Project</a>
            <h2>Projects</h2>

            Rows <select onchange="rowsChanged(this.value)">
                @foreach([5, 10, 20, 50, 100] as $i)
                    <option @if(request('rows', 10)==$i) selected @endif>{{ $i }}</option>
                @endforeach
            </select>
            <table class="table table-bordered mt-3">
                <thead>
                <tr>
                    <th>Reference</th>
                    <th>Officer</th>
                    <th>Readiness</th>
                    <th>Title</th>
                    <th>Countries</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>First Disb</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>{{ $project->reference }}</td>
                        <td>{{ $project->officer->name }}</td>
                        <td>{{ @$project->readiness->readiness }}</td>
                        <td>{{ $project->title }}</td>
                        <td>
                            @foreach($project->countries as $country)
                                {{ $country->name }},
                            @endforeach
                        </td>
                        <td>{{ $project->start_date }}</td>
                        <td>{{ $project->end_date }}</td>
                        <td>{{ @$project->disbursements()->first()->amount }}</td>
                        <td>{{ $project->status }}</td>
                        <td>{{ @$project->amount }}</td>
                        <td style="min-width: 200px">
                            <a href="{{ url("form/$project->id") }}" class="btn btn-outline-primary btn-sm">View</a>
                            <a href="{{ url("form/$project->id") }}" class="btn btn-outline-primary btn-sm">Edit</a>
                            <a href="{{ url("form/$project->id?delete=true") }}" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th colspan="11">
                            <a href="{{ url('data') }}" class="btn btn-primary">Click to add sample data!</a>
                        </th>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{ $projects->links() }}
        </div>
    </div>
</div>
<script>
    let domain = "{{url('/')}}";

    function rowsChanged(count) {
        window.location.href = domain + '/home?rows=' + count;
    }
</script>
</body>
</html>
