@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            خبر
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('news.index') }}"><i class="fa fa-newspaper-o"></i>مدیریت اخبار</a></li>
            <li class="active">مشاهده خبر</li>
        </ol>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-right: 20px">
                    @include('news.show_fields')
                    <a href="{!! route('news.index') !!}" class="btn btn-default">بازگشت</a>
                </div>
            </div>
        </div>
    </div>
@endsection
