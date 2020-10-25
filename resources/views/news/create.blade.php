@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            خبر
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('news.index') }}"><i class="fa fa-newspaper-o"></i>مدیریت اخبار</a></li>
            <li class="active">ایجاد خبر</li>
        </ol>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'news.store', 'enctype' => 'multipart/form-data']) !!}

                        @include('news.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
