@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-right">نوتیفیکیشن‌ها</h1>
        <h1 class="pull-left">
            {{--            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('notifications.create') !!}">Add New</a>--}}
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('notifications.showNotify', [ null , null ]) !!}">ایجاد نوتیفیکیشن</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('notifications.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

