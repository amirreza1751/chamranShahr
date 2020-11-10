@extends('layouts.app')

@section('content')
    @include('adminlte-templates::common.errors')
    @include('flash::message')
    <section class="content-header">
        <h1>
            صفحه‌ی شخصی
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li class="active">صفحه‌ی شخصی</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-4">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle image-square-15"
                             src="{{ Auth::user()->avatar() }}"
                             alt="User profile picture">

                        <h3 class="profile-username text-center">{{ Auth::user()->full_name }}</h3>

                        <p class="text-muted text-center">مدیر</p>

                        <ul class="list-group list-group-unbordered">
                            @foreach(Auth::user()->managements() as $management)
                                <li class="list-group-item">
                                    <b>مدیریت</b> <a class="pull-left">{{ $management->managed->title }}</a>
                                </li>
                            @endforeach
                            <li class="list-group-item">
                                <b>آخرین ورود</b> <a
                                    class="pull-left">{{ Morilog\Jalali\Jalalian::fromDateTime(Auth::user()->last_login)->format('%A, %d %B') }}
                                    ساعت {{ Morilog\Jalali\Jalalian::fromDateTime(Auth::user()->last_login)->format('h:m A') }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>پست الکترونیک</b> <a class="pull-left">{{ Auth::user()->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>نام کاربری</b> <a class="pull-left">{{ Auth::user()->username }}</a>
                            </li>
                        </ul>

                        <a disabled="disabled" class="btn btn-primary btn-block"><b>مشاهده‌ی صفحه‌ی عمومی</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">دپارتمان‌ها</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if (sizeof($departments) == 0)
                            <span class="box-title">هیچ دپارتمانی برای نمایش وجود ندارد</span>
                        @else
                            @foreach($departments as $index => $department)
                                <a href="{{ route('departments.profile', $department->id) }}" class="btn btn-primary btn-block"><b>{{ $department->title }}</b></a>
                            @endforeach
                        @endif
{{--                        <p class="text-muted">--}}
{{--                            غیر فعال--}}
{{--                        </p>--}}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-8">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#notifications" data-toggle="tab" aria-expanded="false">نوتیفیکیشن‌ها</a>
                        </li>
                        {{--                        <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Timeline</a></li>--}}
                        <li class=""><a href="#settings" data-toggle="tab" aria-expanded="true">تنظیمات حساب</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="notifications">
                            @foreach($notificationSamples as $notificationSample)
                                <div class="attachment-block clearfix">
                                    <img class="attachment-img attachment-img-custom"
                                         src="{{ $notificationSample->notifier->thumbnail }}"
                                         alt="Attachment Image">

                                    <div class="attachment-pushed">
                                        <h4 class="attachment-heading"><a>{{ $notificationSample->title }}</a></h4>

                                        <div class="attachment-text">
                                            {{ $notificationSample->brief_description }}
                                            <a href="{!! route(app($notificationSample->notifier_type)->getTable() . '.show', [$notificationSample->notifier_id]) !!}">more</a>
                                        </div>
                                        <!-- /.attachment-text -->
                                    </div>
                                    <!-- /.attachment-pushed -->
                                </div>
                            @endforeach
                        </div>

                        <div class="tab-pane" id="settings">

                            <div class="row" style="margin-bottom: 1rem">
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <a class="btn btn-block btn-default btn-xs pull-right" data-toggle="modal" data-target="#input-help">راهنمای ورودی‌ها</a>
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
                                                        <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">نام و نام‌خانوادگی:</span><span class="text">نام و نام‌خانوادگی شما است که در سامانه و برای سایر کاربران نمایش داده خواهد شد</span></p>
                                                        <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">پست الکترونیک:</span><span class="text">پست الکترونیک مربوط به حساب شماست که برای سرویس‌های مختلفی از جمله سرویس های احراز هویت و بازیابی حساب استفاده خواهد شد</span></p>
                                                        <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">نام کاربری:</span><span class="text">نام کاربری منحصر به فرد حساب شما در سامانه است. حروف مجاز برای نام کاربری عبارتند از: <span class="text-danger fontsize-black">حرف a تا حرف z، حرف A تا حرف Z و حرف .</span> که استفاده از . در ابتدا و انتهای نام کاربری و تکرار بیش از یک مرتبه آن بلافاصله پشت سر هم مجاز نیست</span></p>
                                                        <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">رمز عبور:</span><span class="text">رمز عبور شما جهت ورود به سامانه است. این رمز باید شروط حداقلی سامانه را جهت تامین امنیت حساب شما رعایت نماید که متشکل هستند از: دارا بودن حداقل یک حرف کوچک، یک حرف بزرگ، یک عدد و یک کرکتر خاص شامل : <span class="text-danger fontsize-black">! @ # $ % ^ & * ( ) : < > / { }</span></span></p>
                                                        <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">تصویر:</span><span class="text">تصویر شخصی کاربر است که حداکثر اندازه‌ی قابل قبول آن 1MB و فرمت‌های مجاز jpg و png می‌باشند</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </div>
                            </div>

                            {!! Form::model(Auth::user(), ['route' => ['profile.update'], 'method' => 'patch', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

                            <div class="form-group">
                                <label for="first_name" class="col-sm-2 control-label">نام</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="first_name"
                                           placeholder="{{ Auth::user()->first_name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="col-sm-2 control-label">نام خانوادگی</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="last_name"
                                           placeholder="{{ Auth::user()->last_name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label ">پست الکترونیک</label>

                                <div class="col-sm-10">
                                    <input disabled type="email" class="form-control text-ltr" id="email"
                                           placeholder="{{ Auth::user()->email }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">نام کاربری</label>

                                <div class="col-sm-10">
                                    <input name="username" type="text" class="form-control text-ltr" id="username"
                                           placeholder="{{ Auth::user()->username }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">رمز عبور</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" placeholder="رمز عبور">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="col-sm-2 control-label">تکرار رمز عبور</label>

                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="confirm_password"
                                           placeholder="تکرار رمز عبور">
                                </div>
                            </div>
                            <!-- Avatar Path Field -->
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    {!! Form::label('avatar_path', 'تصویر شخصی:') !!}
                                </div>
                                <div class="col-md-10">
                                    <input type="file" name="avatar_path" class="form-control custom-file-input"
                                           id="customFile">
                                    <label style="margin: 10px" class="form-control custom-file-label text-center"
                                           for="customFile"></label>
                                </div>
                            </div>
                            <script>
                                $('#customFile').on('change',function(){
                                    //get the file name
                                    var fileName = $(this).val();
                                    //replace the "Choose a file" label
                                    $(this).next('.custom-file-label').html(fileName);
                                })
                            </script>
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>--}}

                            {{--                                    <div class="col-sm-10">--}}
                            {{--                                        <textarea class="form-control" id="inputExperience"--}}
                            {{--                                                  placeholder="Experience"></textarea>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <div class="col-sm-offset-2 col-sm-10">--}}
                            {{--                                        <div class="checkbox">--}}
                            {{--                                            <label>--}}
                            {{--                                                <input type="checkbox"> I agree to the <a href="#">terms and--}}
                            {{--                                                    conditions</a>--}}
                            {{--                                            </label>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">ذخیره</button>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
@endsection
