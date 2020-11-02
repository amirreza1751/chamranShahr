@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-right">نوتیفیکیشن‌ها</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary btn-xs pull-right" style="margin-right: 10px" href="{{ route('notifications.showNotify') }}">ایجاد نوتیفیکیشن</a>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li class="active">مدیریت نوتیفیکیشن‌ها</li>
        </ol>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('notification_samples.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

