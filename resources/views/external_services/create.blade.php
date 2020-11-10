@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-right">ایجاد سرویس خارجی</h1>
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
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">عنوان:</span><span class="text">عنوان سرویس است که تنها استفاده از حروف و اعداد فارسی، حروف و اعداد انگلیسی، علائم نگارشی برخی علائم دیگر مانند - _ : ; ' " , ؛ + مجاز است</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">پیوند:</span><span class="text">لینک منبع سرویس خارجی است که محتوای سرویس از طریق آن بارگزاری و به روز رسانی خواهند شد؛ این لینک برای اخبار و اطلاعیه‌های مربوط به دپارتمان‌های دانشگاه معمولا در زیر بخش مربوطه‌ی آن‌ها در سایت دانشگاه با عنوان RSS قرار دارد</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">نوع:</span><span class="text">نوع سرویس خارجی است که در حال حاضر تنها rss فعال و قابل انتخاب ‌می‌باشد</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">نوع محتوا:</span><span class="text">نوع محتوای قابل بارگزاری از لینک سرویس خارجی است که می‌تواند <span class="fontsize-bolder text-success">اطلاعیه یا خبر</span> باشد</span></p>
                            <p><span class="fa fa-caret-left bullet"></span><span class="text-primary fontsize-bolder title">مالکیت:</span><span class="text">مشخص کننده نوع موجودیتی است که این سرویس متعلق به آن است. برای مثال اخبار اصلی دانشگاه متعلق به <span class="text-success fontsize-bolder">«دپارتمان دانشگاه شهید چمران اهواز»</span> می‌باشند</span></p>
                            <p><span class="fa fa-star bullet"></span><span class="text-primary fontsize-bolder title fontsize-large">بسیار مهم:</span><span class="text fontsize-large">پس از ایجاد سرویس خارجی با استفاده از دکمه‌ی <span class="label label-primary">بروزرسانی</span> در منوی اصلی مدیریت سرویس‌های خارجی محتوای مربوطه در سامانه برای شما بارگزاری و بروزرسانی خواهد شد؛ این فرایند پس از ایجاد سرویس توسط شما به صورت خودکار در زمان بندی معینی توسط سامانه انجام می‌شود و نیازی به انجام دستی آن پس از اولین به روز رسانی نخواهد بود</span></p>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>داشبورد</a></li>
            <li><a href="{{ route('externalServices.index') }}"><i class="fa fa-rss-square"></i>مدیریت سرویس‌های خارجی</a></li>
            <li class="active">ایجاد سرویس خارجی</li>
        </ol>
    </section>
    <div class="content">

        <div class="clearfix"></div>
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>

        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'externalServices.store']) !!}

                        @include('external_services.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
