@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            نوتیفیکیشن
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('notificationSamples.index') }}"><i class="fa fa-bell"></i>مدیریت نوتیفیکیشن‌ها</a></li>
            <li class="active">مشاهده نوتیفیکیشن</li>
        </ol>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-right: 20px">
                    @include('notification_samples.show_fields')
                    <a href="{{ route('notificationSamples.index') }}" class="btn btn-default">بازگشت</a>
                </div>
            </div>
        </div>
        <div class="box box-primary collapsed-box box-solid" style="padding-top: 0">
            <div class="box-header with-border">
                <h3 class="box-title">دریافت کنندگان</h3>

                <div class="box-tools pull-left" dir="ltr">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @foreach($notifications as $notification)
                    {!! Form::open(['route' => ['notifications.destroy', $notification->id], 'method' => 'delete']) !!}
                    <span class="btn btn-default btn-xs pull-right" style="margin: 0.5rem; cursor: auto">{{ $notification->notifiable->full_name }} {!! Form::button('<i class="fa fa-times"></i>', ['type' => 'submit', 'class' => 'btn btn-box-tool no-padding', 'onclick' => "return confirm('از حذف نوتیفیکیشن برای این کاربر مطمئن هستید؟')"]) !!}</span>
                    {!! Form::close() !!}

                @endforeach
            </div>
            <!-- /.box-body -->
        </div>
    </div>
@endsection
