@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-right">ایجاد نوتیفیکیشن</h1>
        <h1 class="pull-right">
            <a class="btn btn-default btn-xs pull-right" style="margin-right: 10px"  data-toggle="modal" data-target="#input-help">راهنمای ورودی‌ها</a>
        </h1>
        <div class="modal fade" id="input-help" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="pull-left close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title text-primary">راهنمای ورودی‌ها</h4>
                    </div>
                    <div class="modal-body" style="border-bottom: 10px solid #286090">
                        <div class="help-modal-section">
                            <p><span class="fa fa-star bullet"></span><span class="text-primary fontsize-bolder title fontsize-large">بسیار مهم:</span><span class="text fontsize-large">پیش از ایجاد خبر یا اطلاعیه های مناسب و یا ایجاد سرویس خارجی جهت بارگزاری و به روزرسانی اخبار و اطلاعیه‌های دپارتمان خود نمیتوانید نوتیفیکیشن تولید کنید زیرا هر نوتیفیکیشن می‌بایست یک منبع مشخص که متعلق به دپارتمان های تحت مدیریت شماست، داشته باشد؛ بنابراین اگر پیش از این اخبار یا اطلاعیه های مورد نظر را به وجود نیاورده‌اید، لازم است ابتدا این مرحله را طی کنید</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">نوع منبع:</span><span class="text">نوع منبعی است که نوتیفیکیشن از آن ساخته می‌شود؛ برای مثال نوع منبع برای نوتیفیکیشنی که از خبر <span class="fontsize-bolder text-success">تاریخ بازگشایی دانشگاه شهید چمران اهواز اعلام شد</span> «خبر» و همچنین نوع منبع برای اطلاعیه‌ی <span class="fontsize-bolder text-success">نحوه‌ی نام نویسی نوورودان دوره‌ی کارشناسی</span> «اطلاعیه» می‌باشد</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">منبع:</span><span class="text">یک از گزینه‌های موجود از نوع انتخاب شده در مرحله‌ی قبل است</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">عنوان:</span><span class="text">عنوان نوتیفیکیشن است که می‌توان از عنوان منبع آن با انتخاب گزینه‌ی مربوطه استفاده و یا عنوان متفاوتی وارد کرد</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">توضیحات:</span><span class="text">متن نوتیفیکیشن است که می‌توان از بخش ابتدایی متن منبع آن با انتخاب گزینه‌ی مربوطه استفاده و یا عنوان متفاوتی وارد کرد</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">تاریخ انقضا:</span><span class="text">تاریخی است که نوتیفیکیشن تا آن زمان اعتبار دارد؛ نوتیفیکیشن تا ساعت 24 روز انتخابی معتبر خواهد بود و پس از آن منقضی شده برای کاربران نمایش داده نخواهد شد اما همچنان از طریق پنل در دسترس است</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">نوع:</span><span class="text">دسته بندی نوتفیکیشن‌ها است که در حال حاضر شامل <span class="text-success fontsize-bolder">آموزشی، پژوهشی، دانشجویی-رفاهی و فرهنگی</span> می‌باشد</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">نوع کاربری دریافت‌کنندگان:</span><span class="text">نوع کاربرانی است که این نوتیفیکیشن را دریافت خواهند کرد؛ در حال حاضر می‌توان برای تمامی کاربران و یا دانشجویان با انتخاب ورودی های مناسب ارسال کرد</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">دانشکده، رشته، مقطع، گرایش، ورودی و وضعیت تحصیلی:</span><span class="text">پارامترهایی هستند که بر اساس آن‌ها محدوده‌ی دانشجویان دریافت کننده‌ی نوتیفیکیشن مشخص می‌شود؛ <span class="text-success fontsize-bolder">این گزینه‌ها با انتخاب نوع کاربری دانشجویان فعال خواهند شد</span></span></p>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('notificationSamples.index') }}"><i class="fa fa-bell"></i>مدیریت نوتیفیکیشن‌ها</a>
            </li>
            <li class="active">ایجاد نوتیفیکیشن</li>
        </ol>
    </section>
    <div class="content">

        <div class="clearfix"></div>
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>

        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'notifications.notify']) !!}

                    @if(isset($notification)) {{--reditect view--}}
                    <input id="notification_id" type="hidden" value="{{$notification->id}}">
                    @endif

                    @if(isset($notifier)) {{--reditect view--}}
                    <input id="type" type="hidden" value="{{get_class($notifier)}}">
                    @elseif(old('notifier_type'))
                        <input id="type" type="hidden" value="{{old('notifier_type')}}">
                    @endif

                    @if(isset($notifier->id)) {{--reditect view--}}
                    <input id="id" type="hidden" value="{{$notifier->id}}">
                    @elseif(old('notifier_id'))
                        <input id="type" type="hidden" value="{{old('notifier_id')}}">
                    @endif

                <!-- Notifier Type Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('notifier_type', 'نوع منبع:') !!} <span class="text-danger text-small">الزامی</span>
                        <select class="form-control m-bot15" name="notifier_type" id="notifier_type">
                            <option disabled selected value> -- انتخاب کنید --</option>
                            @if(isset($notifier)) // edit view
                                @foreach($notifier_types as $key => $value)
                                    @if($key == get_class($notifier))
                                        <option value="{{ $key }}" selected>{{ $value }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                @endforeach
                            @else                   // create view
                                @foreach($notifier_types as $key => $value)
                                    @if($key == old('notifier_type'))
                                        <option value="{{ $key }}" selected>{{ $value }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <script>
                        jQuery(document).ready(function () {
                            $('select[name="notifier_type"]').on('change', function () {
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
                                    success: function (data) {
                                        console.log(data);
                                        $.each(data, function (id, notifier) {
                                            if (notifier['selected']) {
                                                console.log('selected');
                                                $('#notifier_id').append('<option selected value="' + notifier['id'] + '">' + notifier['title'] + '</option>');
                                            } else {
                                                $('#notifier_id').append('<option value="' + notifier['id'] + '">' + notifier['title'] + '</option>');
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
                        {!! Form::label('notifier_id', 'منبع:') !!} <span class="text-danger text-small">الزامی</span>
                        <select class="form-control m-bot15" name="notifier_id" id="notifier_id">
                            <option disabled selected value> -- انتخاب کنید --</option>
                            @if(isset($notifier)) // edit view
                            <option value="{{ $notifier->id }}" selected>{{ $notifier->title }}</option>
                            @endif
                        </select>
                    </div>

                    <!-- Title Field -->
                    <div class="form-group col-sm-8">
                        {!! Form::label('title', 'عنوان:') !!} <span class="text-danger text-small">الزامی</span>
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                    <div class="form-group col-sm-4">
                        {!! Form::label('use_notifier_title', 'در صورت فعال بودن این گزینه، از عنوان منبع برای نوتیفیکیشن استفاده می‌شود', ['style' => 'color: lightgray; font-size: 1rem' ]) !!}
                        <div class="form-control checkbox" style="margin: 0;">
                            <label><input name="use_notifier_title" id="use_notifier_title" type="checkbox"
                                          value="false"><span style="padding-right: 20px;">استفاده از عنوان منبع</span></label>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function () {
                            var old_use_notifier_title = "{{old('use_notifier_title')}}";
                            if (old_use_notifier_title !== '') {
                                $('#title').prop('disabled', true);
                                $('#use_notifier_title').val(false);
                                $('#use_notifier_title').prop('checked', true);
                            }
                            $('#use_notifier_title').on('click', function () {
                                if ($('#use_notifier_title').is(":checked")) {
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
                        {!! Form::label('brief_description', 'توضیحات:') !!} <span class="text-danger text-small">الزامی</span>
                        {!! Form::textarea('brief_description', null, ['class' => 'form-control', 'id' => 'brief_description', 'maxlength' => 145, 'rows' => 3]) !!}
                    </div>
                    <div class="form-group col-sm-4">
                        {!! Form::label('use_notifier_description', 'در صورت فعال بودن این گزینه، از بخشی از توضیحات منبع برای نوتیفیکیشن استفاده می‌شود', ['style' => 'color: lightgray; font-size: 0.85rem' ]) !!}
                        <div class="form-control checkbox" style="margin: 0;">
                            <label><input name="use_notifier_description" id="use_notifier_description" type="checkbox"
                                          value="false"><span
                                    style="padding-right: 20px;">استفاده از توضیحات منبع</span></label>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function () {
                            var old_use_notifier_description = "{{old('use_notifier_description')}}";
                            if (old_use_notifier_description !== '') {
                                $('#brief_description').prop('disabled', true);
                                $('#use_notifier_description').val(false);
                                $('#use_notifier_description').prop('checked', true);
                            }
                            $('#use_notifier_description').on('click', function () {
                                if ($('#use_notifier_description').is(":checked")) {
                                    $('#brief_description').prop('disabled', true);
                                    $('#use_notifier_description').val(false);
                                } else {
                                    $('#brief_description').prop('disabled', false);
                                    $('#use_notifier_description').val(true);
                                }
                            });
                        });
                    </script>

                    <!-- Deadline Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('deadline', 'تاریخ انقضا:') !!} <span class="text-danger text-small">الزامی</span>
{{--                        {!! Form::date('deadline', null, ['class' => 'form-control','id'=>'deadline']) !!}--}}
                        <input autocomplete="off" class="form-control" dir="ltr" type="text" value="{{old('deadline_pd')}}" id="deadline_pd" name="deadline_pd"/>
                        <input type="hidden" id="deadline" name="deadline" value="{{old('deadline')}}"/>
                    </div>



                    <!-- Notification Type Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('type', 'نوع نوتیفیکیشن:') !!} <span class="text-danger text-small">الزامی</span>
                        <select class="form-control" name="type" id="type">
                            <option disabled selected value> -- انتخاب کنید --</option>
                            @foreach($notification_types as $key => $value)
                                @if($key == old('type'))
                                    <option selected value="{{ $key }}">{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- User Type Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('user_types', 'نوع کاربری دریافت‌کنندگان:') !!} <span class="text-danger text-small">الزامی</span>
                        <select class="form-control" name="user_type" id="user_type">
                            @foreach($user_types as $key => $value)
                                @if($key == old('user_type'))
                                    <option selected value="{{ $key }}">{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <script>
                        jQuery(document).ready(function () {
                            if ($('#user_type').val() === "{{ App\General\Constants::STUDENTS }}") {
                                $('#student-section').show();
                            }
                            $('#user_type').on('change', function () {
                                if ($('#user_type').val() === "{{ App\General\Constants::STUDENTS }}") {
                                    $('#student-section').show();
                                } else {
                                    $('#student-section').hide();
                                }
                            });
                        });
                    </script>

                    <div id="student-section" style="display: none">
                        <!-- Faculty Unique Code Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('faculty_unique_code', 'دانشکده:') !!}
                            <select class="form-control m-bot15" name="faculty_unique_code" id="faculty_unique_code">
                                <option selected value> -- همه --</option>
                                @foreach($faculties as $key => $value)
                                    @if($value == old('faculty_unique_code'))
                                        <option selected value="{{ $value }}">{{ $key }}</option>
                                    @else
                                        <option value="{{ $value }}">{{ $key }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <script>
                            jQuery(document).ready(function () {
                                $('select[name="faculty_unique_code"]').on('change', function () {
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
                                        success: function (data) {
                                            $.each(data, function (key, value) {
                                                $('#study_field_unique_code').append('<option value="' + key + '">' + value + '</option>');
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
                                <option selected value> -- همه --</option>
                            </select>
                        </div>

                        <!-- Study Level Unique Code Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('study_level_unique_code', 'مقطع:') !!}
                            <select class="form-control" name="study_level_unique_code" id="study_level_unique_code">
                                <option selected value> -- همه --</option>
                                @foreach($study_levels as $key => $value)
                                    @if($value == old('study_level_unique_code'))
                                        <option selected value="{{ $value }}">{{ $key }}</option>
                                    @else
                                        <option value="{{ $value }}">{{ $key }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <script>
                            jQuery(document).ready(function () {
                                $('select[name="study_field_unique_code"]').on('change', function () {
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
                                        success: function (data) {
                                            $.each(data, function (key, value) {
                                                $('#study_area_unique_code').append('<option value="' + key + '">' + value + '</option>');
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
                                <option selected value> -- همه --</option>
                            </select>
                        </div>

                        <!-- Entrance Term Unique Code Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('entrance_term_unique_code', 'ورودی:') !!}
                            <select class="form-control" name="entrance_term_unique_code"
                                    id="entrance_term_unique_code">
                                <option selected value> -- همه --</option>
                                @foreach($entrance_terms as $key => $value)
                                    @if($value == old('entrance_term_unique_code'))
                                        <option selected value="{{ $value }}">{{ $key }}</option>
                                    @else
                                        <option value="{{ $value }}">{{ $key }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Status Unique Code Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('study_status_unique_code', 'وضعیت تحصیلی:') !!}
                            <select class="form-control m-bot15" name="study_status_unique_code"
                                    id="study_status_unique_code">
                                <option selected value> -- همه --</option>
                                @foreach($study_statuses as $key => $value)
                                    @if($value == old('study_status_unique_code'))
                                        <option selected value="{{ $value }}">{{ $key }}</option>
                                    @else
                                        <option value="{{ $value }}">{{ $key }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit Field -->
                <div class="form-group col-sm-12">
                    {!! Form::submit('ایجاد', ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
                    <a href="{!! route('notificationSamples.index') !!}" class="btn btn-default">لغو</a>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script>
        function convert(str){
            var persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g], englishNumbers  = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
            if(typeof str === 'string')
            {
                for(var i=0; i<10; i++)
                {
                    str = str.replace(persianNumbers[i], i).replace(englishNumbers[i], i);
                }
            }
            return str;
        }

        jQuery(document).ready(function () {

            $('#submit').on('click', function() {
                var deadline_pd = $('#deadline_pd');
                $('#deadline').val(convert(deadline_pd.val()));
            });



            $('#deadline_pd').persianDatepicker({
                observer: true,
                format: 'YYYY/MM/DD',
                initialValue: false,
            });


            var old_notifier_type = "{{str_replace("\\", "\\\\", old('notifier_type'))}}";
            var old_notifier_id = '{{old('notifier_id')}}';
            if (old_notifier_type !== '' && old_notifier_id !== '') {
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
                        notifier_type: old_notifier_type,
                        notifier_id: old_notifier_id,
                    },
                    success: function (data) {
                        console.log(data);
                        $.each(data, function (id, notifier) {
                            if (notifier['selected']) {
                                console.log('selected');
                                $('#notifier_id').append('<option selected value="' + notifier['id'] + '">' + notifier['title'] + '</option>');
                            } else {
                                $('#notifier_id').append('<option value="' + notifier['id'] + '">' + notifier['title'] + '</option>');
                            }
                        });
                    },
                    failure: function (data) {
                        console.log('failure');
                    }
                });
            }

            var old_faculty_unique_code = '{{old("faculty_unique_code")}}';
            var old_study_field_unique_code = '{{old("study_field_unique_code")}}';
            if (old_faculty_unique_code !== '') {
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
                        faculty_unique_code: old_faculty_unique_code,
                    },
                    success: function (data) {
                        $.each(data, function (key, value) {
                            if (old_study_field_unique_code !== '' && key === old_study_field_unique_code)
                                $('#study_field_unique_code').append('<option selected value="' + key + '">' + value + '</option>');
                            else
                                $('#study_field_unique_code').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                    failure: function (data) {
                        console.log('failure');
                    }
                });
            }

            var old_study_area_unique_code = '{{old("study_area_unique_code")}}';
            if (old_study_field_unique_code !== '') {
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
                        study_field_unique_code: old_study_field_unique_code,
                    },
                    success: function (data) {
                        $.each(data, function (key, value) {
                            if (old_study_area_unique_code !== '' && old_study_area_unique_code === key)
                                $('#study_area_unique_code').append('<option selected value="' + key + '">' + value + '</option>');
                            else
                                $('#study_area_unique_code').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                    failure: function (data) {
                        console.log('failure');
                    }
                });
            }
        });
    </script>
@endsection
