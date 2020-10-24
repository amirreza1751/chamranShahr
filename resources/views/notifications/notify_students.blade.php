@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            ایجاد نوتیفیکیشن
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

                    @if(isset($notifier)) {{--reditect view--}}
                        <input id="type" type="hidden" value="{{get_class($notifier)}}">
                    @endif

                    @if(isset($notifier->id)) {{--reditect view--}}
                        <input id="id" type="hidden" value="{{$notifier->id}}">
                    @endif

                <!-- Notifier Type Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('notifier_type', 'دسته‌ی منبع:') !!}
                        <select class="form-control m-bot15" name="notifier_type" id="notifier_type">
                            <option disabled selected value> -- انتخاب کنید -- </option>
                            @if(isset($notifier)) // edit view
                                @foreach($notifiers as $key => $value)
                                    @if($value == get_class($notifier))
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
                                $('#notifier_id').append('<option disabled selected value> -- انتخاب کنید -- </option>');
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
                                                console.log('selected');
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
                        {!! Form::label('notifier_id', 'منبع:') !!}
                        <select class="form-control m-bot15" name="notifier_id" id="notifier_id">
                            <option disabled selected value> -- انتخاب کنید -- </option>
                            @if(isset($notifier)) // edit view
                                <option value="{{ $notifier->id }}" selected>{{ $notifier->title }}</option>
                            @endif
                        </select>
                    </div>

                    <!-- Title Field -->
                    <div class="form-group col-sm-8">
                            {!! Form::label('title', 'عنوان:') !!}
                            {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                    <div class="form-group col-sm-4">
                            {!! Form::label('use_notifier_title', 'در صورت فعال بودن این گزینه، از عنوان منبع برای نوتیفیکیشن استفاده می‌شود', ['style' => 'color: lightgray; font-size: 1rem' ]) !!}
                            <div class="form-control checkbox" style="margin: 0;">
                                <label><input name="use_notifier_title" id="use_notifier_title" type="checkbox" value="false"><span style="padding-right: 20px;">استفاده از عنوان منبع</span></label>
                            </div>
                    </div>
                    <script>
                        jQuery(document).ready(function(){
                            $('#use_notifier_title').on('click', function(){
                                if($('#use_notifier_title').is(":checked")){
                                    $('#title').prop('disabled', true);
                                    $('#use_notifier_title').val(false);
                                } else {
                                    $('#title').prop('disabled', false);
                                    $('#use_notifier_title').val(true);
                                }
                            });
                        });
                    </script>

                    <!-- Brief Description Field -->
                    <div class="form-group col-sm-8">
                            {!! Form::label('brief_description', 'Brief Description:') !!}
                            {!! Form::text('brief_description', null, ['class' => 'form-control', 'id' => 'brief_description']) !!}
                    </div>
                    <div class="form-group col-sm-4">
                            {!! Form::label('use_notifier_description', 'در صورت فعال بودن این گزینه، از بخشی از توضیحات منبع برای نوتیفیکیشن استفاده می‌شود', ['style' => 'color: lightgray; font-size: 0.85rem' ]) !!}
                            <div class="form-control checkbox" style="margin: 0;">
                                <label><input name="use_notifier_description" id="use_notifier_description" type="checkbox" value="false"><span style="padding-right: 20px;">استفاده از توضیحات منبع</span></label>
                            </div>
                    </div>
                    <script>
                        jQuery(document).ready(function(){
                            $('#use_notifier_description').on('click', function(){
                                if($('#use_notifier_description').is(":checked")){
                                    $('#brief_description').prop('disabled', true);
                                    $('#use_notifier_description').val(false);
                                } else {
                                    $('#brief_description').prop('disabled', false);
                                    $('#use_notifier_description').val(true);
                                }
                            });
                        });
                    </script>

                    <!-- Faculty Unique Code Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('faculty_unique_code', 'دانشکده:') !!}
                        <select class="form-control m-bot15" name="faculty_unique_code" id="faculty_unique_code">
                            <option selected value> -- همه -- </option>
                            @foreach($faculties as $key => $value)
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <script>
                        jQuery(document).ready(function(){
                            $('select[name="faculty_unique_code"]').on('change', function(){
                                jQuery('#study_field_unique_code').empty();
                                $('#study_field_unique_code').append('<option selected value> -- همه -- </option>');
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
                        {!! Form::label('study_field_unique_code', 'رشته:') !!}
                        <select class="form-control" name="study_field_unique_code" id="study_field_unique_code">
                            <option selected value> -- همه -- </option>
                        </select>
                    </div>

                    <!-- Study Level Unique Code Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('study_level_unique_code', 'مقطع:') !!}
                        <select class="form-control" name="study_level_unique_code" id="study_level_unique_code">
                            <option selected value> -- همه -- </option>
                            @foreach($study_levels as $key => $value)
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <script>
                        jQuery(document).ready(function(){
                            $('select[name="study_field_unique_code"]').on('change', function(){
                                jQuery('#study_area_unique_code').empty();
                                $('#study_area_unique_code').append('<option selected value> -- همه -- </option>');
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
                                        // study_level_unique_code: jQuery('#study_level_unique_code').val(),
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
                        {!! Form::label('study_area_unique_code', 'گرایش:') !!}
                        <select class="form-control" name="study_area_unique_code" id="study_area_unique_code">
                            <option selected value> -- همه -- </option>
                        </select>
                    </div>

                    <!-- Entrance Term Unique Code Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('entrance_term_unique_code', 'ورودی:') !!}
                        <select class="form-control" name="entrance_term_unique_code" id="entrance_term_unique_code">
                            <option selected value> -- همه -- </option>
                            @foreach($entrance_terms as $key => $value)
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Status Unique Code Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('study_status_unique_code', 'وضعیت تحصیلی:') !!}
                        <select class="form-control m-bot15" name="study_status_unique_code" id="study_status_unique_code">
                            <option selected value> -- همه -- </option>
                            @foreach($study_statuses as $key => $value)
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Deadline Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('deadline', 'تاریخ انقضا:') !!}
                        {!! Form::date('deadline', null, ['class' => 'form-control','id'=>'deadline']) !!}
                    </div>

                <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::submit('ایجاد', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('notifications.index') !!}" class="btn btn-default">لغو</a>
                    </div>

                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
