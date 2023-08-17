@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Projects</h1>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">Create Project</a>
    </div>
    <table class="table" id="projectsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td><a href="{{ route('projects.edit', $project) }}"><i class="fa-regular fa-pen-to-square"></i></a></td>
                    <td>
                        <form method="POST" action="{{ route('projects.destroy', $project) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#projectsTable').DataTable();
    });
</script>
@endsection
@endsection
