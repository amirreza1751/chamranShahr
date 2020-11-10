@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1 class="pull-right">خبر</h1>
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
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">عنوان:</span><span class="text">عنوان خبر است که تنها استفاده از حروف و اعداد فارسی، حروف و اعداد انگلیسی، علائم نگارشی برخی علائم دیگر مانند - _ : ; ' " , ؛ + مجاز است</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">سازنده:</span><span class="text">کاربر ایجاد کننده‌ی این خبر است</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">پیوند:</span><span class="text">لینک خارجی خبر است برای اخباری که منبع خارجی دارند</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">توضیحات:</span><span class="text">متن خبر است که تنها استفاده از حروف و اعداد فارسی، حروف و اعداد انگلیسی، علائم نگارشی برخی علائم دیگر مانند - _ : ; ' " , ؛ + مجاز است</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">تصویر:</span><span class="text">تصویر مرتبط با خبر است که حداکثر اندازه‌ی قابل قبول آن 2MB و فرمت‌های مجاز jpg و png می‌باشند</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">مالکیت:</span><span class="text">مشخص کننده نوع موجودیتی است که این خبر متعلق به آن است. برای مثال اخبار اصلی دانشگاه متعلق به <span class="text-success fontsize-bolder">«دپارتمان دانشگاه شهید چمران اهواز»</span> می‌باشند</span></p>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('news.index') }}"><i class="fa fa-newspaper-o"></i>مدیریت اخبار</a></li>
            <li class="active">ایجاد خبر</li>
        </ol>
    </section>
    <div class="content">

        <div class="clearfix"></div>
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>

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
