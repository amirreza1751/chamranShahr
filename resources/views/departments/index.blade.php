@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>دپارتمان‌ها</h1>
        @if(Auth::user()->hasRole('developer|admin|content_manager|department_manager'))
            <h1 class="pull-right">
               <a class="btn btn-xs btn-primary pull-right" style="margin-right: 1rem" href="{!! route('departments.create') !!}">ایجاد دپارتمان</a>
            </h1>
        @endif
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li class="active">مدیریت دپارتمان‌ها</li>
        </ol>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        @if(Auth::user()->hasRole('developer|admin|department_manager'))

            <div class="box box-primary">
                <div class="box-body">
                        @include('departments.table')
                </div>
            </div>
            <div class="text-center">

            </div>
        @elseif(Auth::user()->hasRole('manager'))
            @if (sizeof($departments) == 0)
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">هیچ دپارتمانی برای نمایش وجود ندارد</h3>
                    </div>
                </div>
            @else
                @foreach($departments as $index => $department)
                    <div class="box box-primary collapsed-box box-solid" style="padding-top: 0; margin-top: 1rem">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="padding-top: 1rem">{{ $department->title }}</h3>

                            <div class="pull-left">
                                <a href="{{ route('departments.profile', $department->id) }}" class="btn btn-default">نمایش</a>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
{{--                        <div class="box-body">--}}
{{--                            غیر فعال--}}
{{--                        </div>--}}
                        <!-- /.box-body -->
                    </div>
                @endforeach
            @endif
        @endif
    </div>
@endsection

