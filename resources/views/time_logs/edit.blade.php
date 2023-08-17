@extends('layouts.app')

@section('content')

<div class="container">
    <div class="custom__container">
    <div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <form method="POST" action="{{ route('time-logs.update', $timeLog->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <span>Project</span>
                    <select name="project_id" class="form-control">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ $timeLog->project_id == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    
                    <span>Start Date</span>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" name="start_time" value="{{ $timeLog->start_time }}"  autocomplete="off"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    @error('start_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <span>End Date</span>
                    <div class='input-group date' id='datetimepicker2'>
                        <input type='text' class="form-control" name="end_time" value="{{ $timeLog->end_time }}"  autocomplete="off"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    @error('end_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-success mt-3 custom-success">Update</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss', // Format should match your 'start_time' field format
        // Other options...
    });

    $('#datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss', // Format should match your 'end_time' field format
        // Other options...
    });

</script>

@endsection
