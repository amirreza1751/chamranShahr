@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-right">دپارتمان‌ها</h1>
        @if(Auth::user()->hasRole('developer|admin|department_manager'))
            <h1 class="pull-left">
               <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('departments.create') !!}">Add New</a>
            </h1>
        @endif
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
                                <a href="{{ route('departments.showProfile', $department->id) }}" class="btn btn-default">نمایش</a>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            غیر فعال
                        </div>
                        <!-- /.box-body -->
                    </div>
                @endforeach
            @endif
        @endif
    </div>
@endsection

