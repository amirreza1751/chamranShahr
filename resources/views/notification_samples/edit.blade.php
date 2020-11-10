@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-right">ویرایش نوتیفیکیشن</h1>
        <h1 class="pull-right">
            <a class="btn btn-default btn-xs pull-right" style="margin-right: 10px"  data-toggle="modal" data-target="#input-help">راهنمای ورودی‌ها</a>
        </h1>
        <div class="modal fade" id="input-help" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="pull-left close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title text-primary">راهنمای ورودی‌ها</h4>
                    </div>
                    <div class="modal-body" style="border-bottom: 10px solid #286090">
                        <div class="help-modal-section">
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">عنوان:</span><span class="text">عنوان نوتیفیکیشن است که در سامانه برای کاربران نمایش داده می‌شود</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">نوع:</span><span class="text">دسته بندی نوتفیکیشن‌ها است که در حال حاضر شامل <span class="text-success fontsize-bolder">آموزشی، پژوهشی، دانشجویی-رفاهی و فرهنگی</span> می‌باشد</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">توضیحات:</span><span class="text">متن نوتیفیکیشن است که در سامانه برای کاربران نمایش داده می‌شود</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">تاریخ انقضا:</span><span class="text">تاریخی است که نوتیفیکیشن تا آن زمان اعتبار دارد؛ نوتیفیکیشن تا ساعت 24 روز انتخابی معتبر خواهد بود و پس از آن منقضی شده برای کاربران نمایش داده نخواهد شد اما همچنان از طریق پنل در دسترس است</span></p>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('notificationSamples.index') }}"><i class="fa fa-bell"></i>مدیریت نوتیفیکیشن‌ها</a></li>
            <li class="active">ویرایش نوتیفیکیشن</li>
        </ol>
   </section>
   <div class="content">

       <div class="clearfix"></div>
       @include('adminlte-templates::common.errors')
       <div class="clearfix"></div>

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
