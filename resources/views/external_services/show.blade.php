@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            سرویس خارجی
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('externalServices.index') }}"><i class="fa fa-rss-square"></i>مدیریت سرویس‌های خارجی</a></li>
            <li class="active">مشاهده سرویس خارجی</li>
        </ol>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-right: 20px">
                    @include('external_services.show_fields')
                    <a href="{!! route('externalServices.index') !!}" class="btn btn-default">بازگشت</a>
                </div>
            </div>
        </div>
    </div>
@endsection
