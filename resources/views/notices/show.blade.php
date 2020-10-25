@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            اطلاعیه
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('notices.index') }}"><i class="fa fa-sticky-note"></i>مدیریت اطلاعیه‌ها</a></li>
            <li class="active">مشاهده اطلاعیه</li>
        </ol>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-right: 20px">
                    @include('notices.show_fields')
                    <a href="{!! route('notices.index') !!}" class="btn btn-default">بازگشت</a>
                </div>
            </div>
        </div>
    </div>
@endsection
