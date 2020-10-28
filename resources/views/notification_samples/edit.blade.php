@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            نوتیفیکیشن
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('notificationSamples.index') }}"><i class="fa fa-bell"></i>مدیریت نوتیفیکیشن‌ها</a></li>
            <li class="active">ویرایش نوتیفیکیشن</li>
        </ol>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($notificationSample, ['route' => ['notificationSamples.update', $notificationSample->id], 'method' => 'patch']) !!}

                        @include('notification_samples.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
