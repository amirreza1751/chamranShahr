@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            سرویس خارجی
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('externalServices.index') }}"><i class="fa fa-rss-square"></i>مدیریت سرویس‌های خارجی</a></li>
            <li class="active">ویرایش سرویس خارجی</li>
        </ol>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($external_service, ['route' => ['externalServices.update', $external_service->id], 'method' => 'patch']) !!}

                        @include('external_services.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
