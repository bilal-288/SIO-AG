@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Create Project</h1>
    <form method="POST" action="{{ route('projects.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Project Name:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create Project</button>
    </form>
</div>

@endsection
