@extends('layouts.app')

@section('content')
        <section class="content-header">
            <h1 class="iran-bold">
                صفحه‌ی شخصی
            </h1>
        </section>
        <div class="content font-size-lg">
            @include('adminlte-templates::common.errors')
            @include('flash::message')
            <div class="box box-primary">

                <div class="box-body">
                    {!! Form::model($user, ['route' => ['users.updateProfile', $user->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}

                    <div class="col-sm-6">

                        <!-- First Name Field -->
                        <div class="label-row">
                            <div class="label-box col-md-4">
                                {!! Form::label('first_name', 'نام:', ['class' => 'label-box-title']) !!}
                            </div>
                            <div class="label-box col-md-8">
                                {!! Form::text('first_name', null, ['class' => 'input']) !!}
                            </div>
                        </div>

                        <!-- Last Name Field -->
                        <div class="label-row">
                            <div class="label-box col-md-4">
                                {!! Form::label('last_name', 'نام خانوادگی:', ['class' => 'label-box-title']) !!}
                            </div>
                            <div class="label-box col-md-8">
                                {!! Form::text('last_name', null, ['class' => 'input']) !!}
                            </div>
                        </div>

                        <!-- Birthday Field -->
                        <div class="label-row">
                            <div class="label-box col-md-4">
                                {!! Form::label('birthday', 'تاریخ تولد:', ['class' => 'label-box-title']) !!}
                            </div>
                            <div class="label-box col-md-8">
                                {!! Form::date('birthday', null, ['class' => 'input text-ltr']) !!}
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="label-row">
                            <div class="label-box col-md-4">
                                {!! Form::label('password', 'رمز عبور:', ['class' => 'label-box-title']) !!}
                            </div>
                            <div class="label-box col-sm-8">
                                <input type="password" class="input" dir="ltr" name="password">
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="label-row">
                            <div class="label-box col-md-4">
                                {!! Form::label('confirm_password', 'تکرار رمز عبور:', ['class' => 'label-box-title']) !!}
                            </div>
                            <div class="label-box col-sm-8">
                                <input type="password" class="input" dir="ltr" name="confirm_password">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- Username Field -->
                        <div class="label-row">
                            <div class="label-box col-md-4">
                                {!! Form::label('username', 'نام کاربری:', ['class' => 'label-box-title']) !!}
                            </div>
                            <div class="label-box col-md-8">
                                {!! Form::text('username', null, ['class' => 'input text-ltr']) !!}
                            </div>
                        </div>

                        <!-- Avatar Path Field -->
                        <div class="label-row">
                            <div class="label-box col-md-4">
                                {!! Form::label('avatar_path', 'تصویر شخصی:', ['class' => 'label-box-title']) !!}
                            </div>
                            <div class="label-box col-md-8">
                                <input type="file" name="avatar_path" class="custom-file-input" id="customFile">
                                <label style="margin: 10px" class="custom-file-label" for="customFile"></label>
                            </div>
                        </div>
                        <script>
                            // Add the following code if you want the name of the file appear on select
                            $(".custom-file-input").on("change", function() {
                                var fileName = $(this).val().split("\\").pop();
                                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                            });
                        </script>

                        <!-- Phone Number Field -->
                        <div class="label-row">
                            <div class="label-box col-md-4">
                                {!! Form::label('phone_number', 'شماره تلفن همراه:', ['class' => 'label-box-title']) !!}
                            </div>
                            <div class="label-box col-md-8 buttoner" disabled>
                                {!! Form::text('phone_number', null, ['class' => 'input text-ltr col-md-8', 'placeholder' => 'like: 0936 123 4567', 'disabled']) !!}
                                <a disabled class="btn btn-danger col-md-4">تغییر</a>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="label-row">
                            <div class="label-box col-md-4">
                                {!! Form::label('email', 'پست الکترونیک:', ['class' => 'label-box-title']) !!}
                            </div>
                            <div class="label-box col-md-8 buttoner" disabled>
                                {!! Form::text('email', null, ['class' => 'input text-ltr col-md-8', 'placeholder' => 'support@campus.scu.ac.ir', 'disabled']) !!}
                                <a disabled class="btn btn-danger col-md-4">تغییر</a>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Field -->
                    <div class="form-group col-sm-6" style="float: left">
                        {!! Form::submit('ذخیره', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('users.showProfile') !!}" class="btn btn-default">انصراف</a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
@endsection
