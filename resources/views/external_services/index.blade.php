@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-right">سرویس‌های خارجی</h1>
        @if(Auth::user()->hasRole('developer|admin|content_manager|department_manager|manager'))
            <h1 class="pull-right">
               <a class="btn btn-primary btn-xs pull-right" style="margin-right: 10px" href="{!! route('externalServices.create') !!}">ایجاد سرویس</a>
            </h1>
            <h1 class="pull-right">
                <a class="btn btn-default btn-xs pull-right" style="margin-right: 10px"  data-toggle="modal" data-target="#input-help">راهنما</a>
            </h1>
            <div class="modal fade" id="input-help" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="pull-left close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title text-primary">راهنما</h4>
                        </div>
                        <div class="modal-body" style="border-bottom: 10px solid #286090">
                            <div class="help-modal-section">
                                <p><span class="fa fa-star bullet"></span><span class="text-primary fontsize-bolder title fontsize-large">بسیار مهم:</span><span class="text fontsize-large">پس از ایجاد سرویس خارجی با استفاده از دکمه‌ی <span class="label label-primary">بروزرسانی</span> در منوی اصلی مدیریت سرویس‌های خارجی محتوای مربوطه در سامانه برای شما بارگزاری و بروزرسانی خواهد شد؛ این فرایند پس از ایجاد سرویس توسط شما به صورت خودکار در زمان بندی معینی توسط سامانه انجام می‌شود و نیازی به انجام دستی آن پس از اولین به روز رسانی نخواهد بود</span></p>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        @endif
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li class="active">مدیریت سرویس‌های خارجی</li>
        </ol>
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
                        <h3 class="box-title">هیچ سرویسی برای نمایش وجود ندارد</h3>
                    </div>
                </div>
            @else
                @foreach($externalServices as $index => $externalService)
                    <div class="box box-secondary collapsed-box box-solid" style="padding-top: 0; margin-top: 1rem">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="padding-top: 1rem">{{ $externalService->title }}</h3>

                            {!! Form::open(['route' => ['externalServices.destroy', $externalService->id], 'method' => 'delete', 'class' => 'pull-left']) !!}
                            <div class="">
                                <a href="{{ route('externalServices.fetch', $externalService->id) }}" class="btn btn-primary btn-sm">به روز رسانی</a>
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

