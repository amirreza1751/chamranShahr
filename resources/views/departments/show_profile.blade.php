@extends('layouts.app')
<head>

    <style>
        .labelbutton{
            float: left;
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

        .graylabel {
            color: lightgray;
            margin-left: 5rem;
        }

        .royallabel {
            color: royalblue;
            margin-left: 5rem;
        }

        .labelbox {
            padding: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            margin: 0.5rem;
        }

        .titlebox {
            min-width: 15rem;
            max-width: 15rem;
        }

        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            width: 90%;
            word-wrap: break-word;
            background-color: #EDEFF2;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.75rem;
            margin: 25px;

            margin: 0 auto; /* Added */
            float: none; /* Added */
            margin-top: 3rem; /* Added */
            margin-bottom: 3rem; /* Added */
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
                صفحه‌ی مدیریت
            </h1>
        </section>
        <div class="content">
            @include('adminlte-templates::common.errors')
            @include('flash::message')
            <div class="box box-primary">

                <div class="box-body">
                    <div class="col-sm-12">
                        <div class="card">
                            <img class="card-img-top" src="{{ $department->path }}" alt="Card image"
                                 style="width:100%">
                            <div class="card-body">
                                <h4 class="card-title">{{ $department->title }}</h4>
                                <p class="card-text">نوع مدیریت: @if(!is_null($department->manage_level)) {{ $department->manage_level->management_title }} @endif</p>
                                <p class="card-text">مدیر: @if(!is_null($department->manager())) {{ $department->manager()->full_name }} @endif</p>
                                <a href="{{ route('users.editProfile') }}" class="btn btn-primary">ویرایش</a>
                            </div>
                        </div>

                        <!-- Description Field -->
                        <div class="labelbox">
                            {!! Form::label('description', 'توضیحات:', ['class' => 'graylabel titlebox']) !!}
                            <span> @if(isset($department->description)) {{$department->description}} @endif </span>
                        </div>
                    </div>

{{--                    <div class="col-sm-8" style="padding: 5rem; font-size: 1.5rem;">--}}

{{--                        <!-- Username Field -->--}}
{{--                        <div class="labelbox">--}}
{{--                            {!! Form::label('username', 'نام کاربری:', ['class' => 'graylabel titlebox']) !!}--}}
{{--                            <span> @if(isset($user->username)) {{$user->username}} @endif </span>--}}
{{--                        </div>--}}

{{--                    </div>--}}



                    {{--                    {!! Form::close() !!}--}}
                </div>
            </div>
        </div>
    </div>

@endsection
