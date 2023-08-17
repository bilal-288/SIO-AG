@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('time-logs.create') }}" class="btn btn-primary mb-3">Create Time Log</a>

    <h1>Time Logs</h1>
    <table id="timeLogsTable">
        <thead>
            <tr>
                <th>Project</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timeLogs as $timeLog)
            <tr>
                <td>{{ $timeLog->project->name }}</td>
                <td>{{ $timeLog->start_time }}</td>
                <td>{{ $timeLog->end_time }}</td>
                <td>
                    <a href="{{ route('time-logs.edit', $timeLog) }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </td>
                <td>
                    <form id="delete-form-{{ $timeLog->id }}" method="POST" action="{{ route('time-logs.destroy', $timeLog) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="delete-button-{{ $timeLog->id }}"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#timeLogsTable').DataTable();
    });

    document.addEventListener('DOMContentLoaded', function () {
        @foreach($timeLogs as $timeLog)
        const deleteForm{{ $timeLog->id }} = document.getElementById('delete-form-{{ $timeLog->id }}');
        const deleteButton{{ $timeLog->id }} = document.getElementById('delete-button-{{ $timeLog->id }}');

        deleteButton{{ $timeLog->id }}.addEventListener('click', function (event) {
            event.preventDefault();
            if (confirm('Do you really want to delete this time log?')) {
                deleteForm{{ $timeLog->id }}.submit();
            }
        });
        @endforeach
    });
</script>
@endsection
