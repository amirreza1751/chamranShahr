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

                        <p class="text-muted text-center">توسعه دهنده‌ی سرور</p>

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
                        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">تنظیمات حساب</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">

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
                                    <input name="email" type="email" class="form-control text-ltr" id="email"
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
                                    <label style="margin: 10px" class="form-control custom-file-label"
                                           for="customFile"></label>
                                </div>
                            </div>
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
