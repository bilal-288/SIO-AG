@extends('layouts.app')

@section('content')
<div class="container">
    <div class="custom__container">
        <div class="row">
            <div class='col-sm-6'>
                <div class="form-group">
                    <form method="POST" action="{{ route('time-logs.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="project_id">Project:</label>
                            <select name="project_id" class="form-control">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                            @error('project_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <span>Start Date</span>
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' class="form-control" name="start_time" autocomplete="off" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        @error('start_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <span>End Date</span>
                        <div class='input-group date' id='datetimepicker2'>
                            <input type='text' class="form-control" name="end_time" autocomplete="off" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        @error('end_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-primary mt-3 custom">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: false // Prevent automatic selection of current date/time
    });

    $('#datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: false // Prevent automatic selection of current date/time
    });

    // Date validation
    $('#datetimepicker1').on('dp.change', function(e) {
        $('#datetimepicker2').data('DateTimePicker').minDate(e.date);
    });

    $('#datetimepicker2').on('dp.change', function(e) {
        $('#datetimepicker1').data('DateTimePicker').maxDate(e.date);
    });
</script>

@endsection
