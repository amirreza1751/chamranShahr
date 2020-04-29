@extends('layouts.app')
<head>

    <style>
        .input{
            border: none;
            width: 100%;
        }
        .input:hover{
            border: 0.05rem lightblue solid;
        }
        input[type="text"]:disabled {
            /*border: none;*/
        }

        .graylabel{
            color: lightgray;
            margin-left: 5rem;
        }

        .darkgraylabel{
            color: gray;
            margin-left: 5rem;
        }

        .labelbox{
            padding: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            margin: 0.5rem;
        }
        /*.labelbox:disabled {*/
        /*    background: grey;*/
        /*    padding: unset;*/
        /*    margin: unset;*/
        /*}*/

        .labelbutton{
            padding: 1rem;
            margin: 0.5rem;
            width: 100%;
            vertical-align: center;
        }

        .titlebox{
            min-width: 15rem;
            max-width: 15rem;
        }

        @font-face {
            font-family: IRAN;
            src: url('/fonts/IRAN.ttf');
        }
        @font-face {
            font-family: IRANBlack;
            src: url('/fonts/IRAN_Black.ttf');
        }
        @font-face {
            font-family: IRANBold;
            src: url('/fonts/IRAN_Bold.ttf');
        }
        @font-face {
            font-family: IRANMarker;
            src: url('/fonts/IRANMarker.ttf');
        }
        .iran-marker {
            font-family: IRANMarker;
        }

        .iran-black {
            font-family: IRANBlack;
        }
        .iran-bold {
            font-family: IRANBold;
        }
        .iran {
            font-family: IRAN;
        }

        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            width: 300px;
            word-wrap: break-word;
            background-color: #EDEFF2;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.75rem;
            margin: 25px;
        }

        .card > hr {
            margin-right: 0;
            margin-left: 0;
        }

        .card > .list-group:first-child .list-group-item:first-child {
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        .card > .list-group:last-child .list-group-item:last-child {
            border-bottom-right-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }

        .card-title {
            margin-bottom: 0.75rem;
            font-family: IRANMarker;
        }

        .card-subtitle {
            margin-top: -0.375rem;
            margin-bottom: 0;
        }

        .card-text:last-child {
            margin-bottom: 0;
            font-family: IRAN;
        }

        .card-link:hover {
            text-decoration: none;
        }

        .card-link + .card-link {
            margin-left: 1.25rem;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
        }

        .card-header + .list-group .list-group-item:first-child {
            border-top: 0;
        }

        .card-footer {
            padding: 0.75rem 1.25rem;
            background-color: rgba(0, 0, 0, 0.03);
            border-top: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-footer:last-child {
            border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
        }

        .card-header-tabs {
            margin-right: -0.625rem;
            margin-bottom: -0.75rem;
            margin-left: -0.625rem;
            border-bottom: 0;
        }

        .card-header-pills {
            margin-right: -0.625rem;
            margin-left: -0.625rem;
        }

        .card-img-overlay {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 1.25rem;
        }

        .card-img {
            width: 100%;
            border-radius: calc(0.25rem - 1px);
        }

        .card-img-top {
            width: 100%;
            /*border-top-left-radius: calc(0.25rem - 1px);*/
            border-top-left-radius: 0.75rem;
            /*border-top-right-radius: calc(0.25rem - 1px);*/
            border-top-right-radius: 0.75rem;
        }

        .card-img-bottom {
            width: 100%;
            border-bottom-right-radius: calc(0.25rem - 1px);
            border-bottom-left-radius: calc(0.25rem - 1px);
        }

        .card-deck {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .card-deck .card {
            margin-bottom: 15px;
        }

        @media (min-width: 576px) {
            .card-deck {
                -ms-flex-flow: row wrap;
                flex-flow: row wrap;
                margin-right: -15px;
                margin-left: -15px;
            }
            .card-deck .card {
                display: -ms-flexbox;
                display: flex;
                -ms-flex: 1 0 0%;
                flex: 1 0 0%;
                -ms-flex-direction: column;
                flex-direction: column;
                margin-right: 15px;
                margin-bottom: 0;
                margin-left: 15px;
            }
        }

        .card-group {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .card-group > .card {
            margin-bottom: 15px;
        }

        @media (min-width: 576px) {
            .card-group {
                -ms-flex-flow: row wrap;
                flex-flow: row wrap;
            }
            .card-group > .card {
                -ms-flex: 1 0 0%;
                flex: 1 0 0%;
                margin-bottom: 0;
            }
            .card-group > .card + .card {
                margin-left: 0;
                border-left: 0;
            }
            .card-group > .card:not(:last-child) {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }
            .card-group > .card:not(:last-child) .card-img-top,
            .card-group > .card:not(:last-child) .card-header {
                border-top-right-radius: 0;
            }
            .card-group > .card:not(:last-child) .card-img-bottom,
            .card-group > .card:not(:last-child) .card-footer {
                border-bottom-right-radius: 0;
            }
            .card-group > .card:not(:first-child) {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
            .card-group > .card:not(:first-child) .card-img-top,
            .card-group > .card:not(:first-child) .card-header {
                border-top-left-radius: 0;
            }
            .card-group > .card:not(:first-child) .card-img-bottom,
            .card-group > .card:not(:first-child) .card-footer {
                border-bottom-left-radius: 0;
            }
        }

        .card-columns .card {
            margin-bottom: 0.75rem;
        }

        @media (min-width: 576px) {
            .card-columns {
                -webkit-column-count: 3;
                -moz-column-count: 3;
                column-count: 3;
                -webkit-column-gap: 1.25rem;
                -moz-column-gap: 1.25rem;
                column-gap: 1.25rem;
                orphans: 1;
                widows: 1;
            }
            .card-columns .card {
                display: inline-block;
                width: 100%;
            }
        }

        .accordion > .card {
            overflow: hidden;
        }

        .accordion > .card:not(:first-of-type) .card-header:first-child {
            border-radius: 0;
        }

        .accordion > .card:not(:first-of-type):not(:last-of-type) {
            border-bottom: 0;
            border-radius: 0;
        }

        .accordion > .card:first-of-type {
            border-bottom: 0;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .accordion > .card:last-of-type {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .accordion > .card .card-header {
            margin-bottom: -1px;
        }
    </style>

</head>

@section('content')
    <div class="iran" dir="rtl" style="padding: 50px;">
        <section class="content-header">
            <h1 class="iran-bold">
                صفحه‌ی شخصی
            </h1>
        </section>
        <div class="content">
            @include('adminlte-templates::common.errors')
            @include('flash::message')
            <div class="box box-primary">

                <div class="box-body">
                    {!! Form::model($user, ['route' => ['users.updateProfile', $user->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}

                    <div class="col-sm-12" style="padding: 5rem; font-size: 1.5rem;">

                        <!-- First Name Field -->
                        <div class="row">
                            <div class="labelbox col-sm-8">
                                {!! Form::text('first_name', null, ['class' => 'input']) !!}
                            </div>
                            <div class="labelbox col-sm-3">
                                {!! Form::label('first_name', 'نام:', ['class' => 'darkgraylabel titlebox']) !!}
                            </div>
                        </div>

                        <!-- Last Name Field -->
                        <div class="row">
                            <div class="labelbox col-sm-8">
                                {!! Form::text('last_name', null, ['class' => 'input']) !!}
                            </div>
                            <div class="labelbox col-sm-3">
                                {!! Form::label('last_name', 'نام خانوادگی:', ['class' => 'darkgraylabel titlebox']) !!}
                            </div>
                        </div>

                        <!-- Birthday Field -->
                        <div class="row">
                            <div class="labelbox col-sm-8">
                                {!! Form::date('birthday', null, ['class' => 'input']) !!}
                            </div>
                            <div class="labelbox col-sm-3">
                                {!! Form::label('birthday', 'تاریخ تولد:', ['class' => 'darkgraylabel titlebox']) !!}
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="row">
                            <div class="labelbox col-sm-8">
                                <input type="password" class="input" dir="ltr" name="password">
                            </div>
                            <div class="labelbox col-sm-3">
                                {!! Form::label('password', 'رمز عبور:', ['class' => 'darkgraylabel titlebox']) !!}
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="row">
                            <div class="labelbox col-sm-8">
                                <input type="password" class="input" dir="ltr" name="confirm_password">
                            </div>
                            <div class="labelbox col-sm-3">
                                {!! Form::label('confirm_password', 'تکرار رمز عبور:', ['class' => 'darkgraylabel titlebox']) !!}
                            </div>
                        </div>

                        <!-- Username Field -->
                        <div class="row">
                            <div class="labelbox col-sm-8">
                                {!! Form::text('username', null, ['class' => 'input']) !!}
                            </div>
                            <div class="labelbox col-sm-3">
                                {!! Form::label('username', 'نام کاربری:', ['class' => 'darkgraylabel titlebox']) !!}
                            </div>
                        </div>

                        <!-- Avatar Path Field -->
                        <div class="row">
                            <div class="labelbox col-sm-8">
                                {!! Form::file('avatar_path', null, ['class' => 'input']) !!}
                            </div>
                            <div class="labelbox col-sm-3">
                                {!! Form::label('avatar_path', 'تصویر شخصی:', ['class' => 'darkgraylabel titlebox']) !!}
                            </div>
                        </div>

                        <!-- Phone Number Field -->
                        <div class="row">
                            <div class="col-sm-2" disabled>
                                {{--                                    <a disabled href="{!! route('users.index') !!}" class="btn btn-danger labelbutton">تغییر</a>--}}
                                <a disabled href="" class="btn btn-danger labelbutton">تغییر</a>
                            </div>
                            <div class="labelbox col-sm-6" disabled>
                                {{--                                    {!! Form::text('phone_number', null, ['class' => 'input', 'dir' => 'ltr', 'disabled']) !!}--}}
                                {!! Form::text('phone_number', null, ['class' => 'form-control input', 'dir' => 'ltr', 'placeholder' => 'like: 0936 123 4567', 'disabled']) !!}
                            </div>
                            <div class="labelbox col-sm-3">
                                {!! Form::label('phone_number', 'شماره تلفن همراه:', ['class' => 'darkgraylabel titlebox']) !!}
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="row">
                            <div class="col-sm-2">
                                {{--                                    <a disabled href="{!! route('users.index') !!}" class="btn btn-danger labelbutton">تغییر</a>--}}
                                <a disabled href="" class="btn btn-danger labelbutton">تغییر</a>
                            </div>
                            <div class="labelbox col-sm-6" disabled>
                                {!! Form::text('email', null, ['class' => 'form-control input', 'dir' => 'ltr', 'placeholder' => 'support@campus.scu.ac.ir', 'disabled']) !!}
                            </div>
                            <div class="labelbox col-sm-3">
                                {!! Form::label('email', 'پست الکترونیک:', ['class' => 'darkgraylabel titlebox']) !!}
                            </div>

                            <!-- Submit Field -->
                            <div class="form-group col-sm-6" style="float: left">
                                {!! Form::submit('ذخیره', ['class' => 'btn btn-primary']) !!}
                                <a href="{!! route('users.showProfile') !!}" class="btn btn-default">انصراف</a>
                            </div>
                        </div>


                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
