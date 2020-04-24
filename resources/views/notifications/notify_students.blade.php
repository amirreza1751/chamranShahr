@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Notify Students
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                {!! Form::open(['route' => 'notifications.notifyStudents']) !!}

                    @if(isset($notification)) {{--reditect view--}}
                        <input id="notification_id" type="hidden" value="{{$notification->id}}">
                    @endif

                    @if(isset($notifier['type'])) {{--reditect view--}}
                        <input id="type" type="hidden" value="{{$notifier['type']}}">
                    @endif

                    @if(isset($notifier['id'])) {{--reditect view--}}
                        <input id="id" type="hidden" value="{{$notifier['id']}}">
                    @endif

                <!-- Notifier Type Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('notifier_type', 'Notifier Type:') !!}
                        <select class="form-control m-bot15" name="notifier_type" id="notifier_type">
                            <option disabled selected value> -- select an option -- </option>
                            @if(isset($notifier)) // edit view
                                @foreach($notifiers as $key => $value)
                                    @if($value == $notifier['type'])
                                        <option value="{{ $value }}" selected>{{ $key }}</option>
                                    @else
                                        <option value="{{ $value }}">{{ $key }}</option>
                                    @endif
                                @endforeach
                            @else                   // create view
                                @foreach($notifiers as $key => $value)
                                    <option value="{{ $value }}">{{ $key }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous">
                    </script>
                    <script>
                        jQuery(document).ready(function(){
                            $('select[name="notifier_type"]').on('change', function(){
                                jQuery('#notifier_id').empty();
                                $('#notifier_id').append('<option disabled selected value> -- select an option -- </option>');
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                jQuery.ajax({
                                    url: "{{ url('/notifications/ajaxNotifier') }}",
                                    method: 'get',
                                    data: {
                                        model_name: jQuery('#notifier_type').val(),
                                        notifier_type: jQuery('#type').val(),
                                        notifier_id: jQuery('#id').val(),
                                    },
                                    success: function(data){
                                        console.log(data);
                                        $.each(data, function(id, notifier){
                                            if(notifier['selected']){
                                                $('#notifier_id').append('<option selected value="'+ notifier['id'] +'">' + notifier['title'] + '</option>');
                                            } else {
                                                $('#notifier_id').append('<option value="'+ notifier['id'] +'">' + notifier['title'] + '</option>');
                                            }
                                        });
                                    },
                                    failure: function (data) {
                                        console.log('failure');
                                    }
                                });
                            });
                        });
                    </script>

                    <!-- Notifier Id Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('notifier_id', 'Notifier:') !!}
                        <select class="form-control m-bot15" name="notifier_id" id="notifier_id">
                            <option disabled selected value> -- select an option -- </option>
                            @if(isset($notifier)) // edit view
                                <option value="{{ $notifier['id'] }}" selected>{{ $notifier['title'] }}</option>
                            @endif
                        </select>
                    </div>

                    <!-- Faculty Unique Code Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('faculty_unique_code', 'Faculty:') !!}
                        <select class="form-control m-bot15" name="faculty_unique_code" id="faculty_unique_code">
                            <option selected value> -- all -- </option>
                            @foreach($faculties as $key => $value)
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <script>
                        jQuery(document).ready(function(){
                            $('select[name="faculty_unique_code"]').on('change', function(){
                                jQuery('#study_field_unique_code').empty();
                                $('#study_field_unique_code').append('<option selected value> -- all -- </option>');
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                jQuery.ajax({
                                    url: "{{ url('/notifications/ajaxStudyField') }}",
                                    method: 'get',
                                    data: {
                                        faculty_unique_code: jQuery('#faculty_unique_code').val(),
                                    },
                                    success: function(data){
                                        $.each(data, function(key, value){
                                            $('#study_field_unique_code').append('<option value="'+ key +'">' + value + '</option>');
                                        });
                                    },
                                    failure: function (data) {
                                        console.log('failure');
                                    }
                                });
                            });
                        });
                    </script>

                    <!-- Study Field Unique Code Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('study_field_unique_code', 'Study Field:') !!}
                        <select class="form-control" name="study_field_unique_code" id="study_field_unique_code">
                            <option selected value> -- all -- </option>
                        </select>
                    </div>

                    <script>
                        jQuery(document).ready(function(){
                            $('select[name="study_field_unique_code"]').on('change', function(){
                                jQuery('#study_area_unique_code').empty();
                                $('#study_area_unique_code').append('<option selected value> -- all -- </option>');
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                jQuery.ajax({
                                    url: "{{ url('/notifications/ajaxStudyArea') }}",
                                    method: 'get',
                                    data: {
                                        study_field_unique_code: jQuery('#study_field_unique_code').val(),
                                    },
                                    success: function(data){
                                        $.each(data, function(key, value){
                                            $('#study_area_unique_code').append('<option value="'+ key +'">' + value + '</option>');
                                        });
                                    },
                                    failure: function (data) {
                                        console.log('failure');
                                    }
                                });
                            });
                        });
                    </script>

                    <!-- Study Area Unique Code Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('study_area_unique_code', 'Study Area:') !!}
                        <select class="form-control" name="study_area_unique_code" id="study_area_unique_code">
                            <option selected value> -- all -- </option>
                        </select>
                    </div>

                    <!-- Entrance Term Unique Code Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('entrance_term_unique_code', 'Entrance Term:') !!}
                        <select class="form-control" name="entrance_term_unique_code" id="entrance_term_unique_code">
                            <option selected value> -- all -- </option>
                            @foreach($entrance_terms as $key => $value)
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Status Unique Code Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('study_status_unique_code', 'Study Status:') !!}
                        <select class="form-control m-bot15" name="study_status_unique_code" id="study_status_unique_code">
                            <option selected value> -- all -- </option>
                            @foreach($study_statuses as $key => $value)
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Deadline Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('deadline', 'Deadline:') !!}
                        {!! Form::date('deadline', null, ['class' => 'form-control','id'=>'deadline']) !!}
                    </div>

                <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('notifications.index') !!}" class="btn btn-default">Cancel</a>
                    </div>

                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
