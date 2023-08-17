@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Project</h1>
    <form method="POST" action="{{ route('projects.update', $project) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Project Name:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $project->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Project</button>
    </form>
</div>
@endsection
