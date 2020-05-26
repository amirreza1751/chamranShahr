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

                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="{{ $user->avatar_path }}" alt="Card image">
                            <div class="card-body">
                                <h4 class="card-title vazir-font-fd">{{ $user->first_name . ' ' . $user->last_name }}</h4>
                                <p class="card-text">نوع کاربری: </p>
                                <p class="card-text">جنسیت: @if(isset($user->gender->title)) {{ $user->gender->title }} @endif</p>
                                <a href="{{ route('users.editProfile') }}" class="btn btn-primary">ویرایش</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">

                        <!-- Username Field -->
                        <div class="label-box">
                            {!! Form::label('username', 'نام کاربری:', ['class' => 'label-box-title']) !!}
                            <span> @if(isset($user->username)) {{$user->username}} @endif </span>
                        </div>

                        <!-- National Id Field -->
                        <div class="label-box">
                            {!! Form::label('national_id', 'شماره ملی:', ['class' => 'label-box-title']) !!}
                            <span> @if(isset($user->national_id)) {{$user->national_id}} @endif </span>
                        </div>

                        <!-- Scu Id Field -->
                        <div class="label-box">
                            {!! Form::label('scu_id', 'شماره دانشگاهی:', ['class' => 'label-box-title']) !!}
                            <span> @if(isset($user->scu_id)) {{$user->scu_id}} @endif </span>
                        </div>

                        <!-- Phone Number Field -->
                        <div class="label-box">
                            {!! Form::label('phone_number', 'شماره تلفن همراه:', ['class' => 'label-box-title']) !!}
                            <span>
                                @if(isset($user->phone_number)) {{$user->phone_number}} @endif
                                @if(isset($user->phone_number))
                                    <span style="float: left;" class="label label-success">تایید شده</span>
                                @else
                                    <span style="float: left;" class="label label-default">تایید نشده</span>
                                @endif
                            </span>
                        </div>

                        <!-- Email Field -->
                        <div class="label-box">
                            {!! Form::label('email', 'پست الکترونیک:', ['class' => 'label-box-title']) !!}
                            <span>
                                    @if(isset($user->email)) {{$user->email}} @endif
                                @if(isset($user->email_verified_at))
                                    <span style="float: left;" class="label label-success">تایید شده</span></h1>
                                @else
                                    <span style="float: left;" class="label label-default">تایید نشده</span></h1>
                                @endif
                                </span>
                        </div>

                        <!-- Birthday Field -->
                        <div class="label-box">
                            {!! Form::label('birthday', 'تاریخ تولد:', ['class' => 'label-box-title']) !!}
                            <span> @if(isset($user->birthday)) {{$user->birthday}} @endif </span>
                        </div>

                    </div>

                    {{--                    {!! Form::close() !!}--}}
                </div>
            </div>
        </div>

        @if(sizeof($user->under_managment()) > 0)
            <section class="content-header">
                <h1 class="iran-bold">
                    مدیریت‌ها
                </h1>
            </section>
            <div class="content">
                <div class="box box-primary">

                    <div class="box-body">
                        @foreach($user->under_managment() as $management)
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- Title Field -->
                                    <div class="label-box">
                                        {!! Form::label('title', 'عنوان:', ['class' => 'royallabel label-box-title']) !!}
                                        <span> @if(isset($management->managed->title)) {{$management->managed->title}} @endif </span>
                                        <a style="float: left" href="{!! route(app($management->managed_type)->getTable() . '.showProfile', [$management->managed->id]) !!}" class='btn btn-primary btn-xs'>مشاهده</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
@endsection
