@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-right">سرویس‌های خارجی</h1>
        @if(Auth::user()->hasRole('developer|admin|content_manager|department_manager|manager'))
            <h1 class="pull-left">
               <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('externalServices.create') !!}">ایجاد سرویس</a>
            </h1>
        @endif
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        @if(Auth::user()->hasRole('developer|admin|content_manager|department_manager'))
            <div class="box box-primary">
                <div class="box-body">
                        @include('external_services.table')
                </div>
            </div>
            <div class="text-center">

            </div>
        @elseif(Auth::user()->hasRole('manager'))
            @if (sizeof($externalServices) == 0)
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">هیچ دپارتمانی برای نمایش وجود ندارد</h3>
                    </div>
                </div>
            @else
                @foreach($externalServices as $index => $externalService)
                    <div class="box box-secondary collapsed-box box-solid" style="padding-top: 0; margin-top: 1rem">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="padding-top: 1rem">{{ $externalService->title }}</h3>

                            {!! Form::open(['route' => ['externalServices.destroy', $externalService->id], 'method' => 'delete', 'class' => 'pull-left']) !!}
                            <div class="">
                                <a href="{{ route('externalServices.show', $externalService->id) }}" class="btn btn-success btn-sm">نمایش</a>
                                <a href="{{ route('externalServices.edit', $externalService->id) }}" class="btn btn-warning btn-sm">ویرایش</a>
{{--                                <button href="{{ route('externalServices.destroy', $externalService->id) }}" class="btn btn-danger">حذف</button>--}}
                                {!! Form::button('حذف', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('آیا از حذف این سرویس مطمئن هستید؟')"]) !!}

                            </div>
                            {!! Form::close() !!}
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

