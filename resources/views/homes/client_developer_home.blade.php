@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-file-text"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">داکیومنتیشن سوگر</span>
                        <span class="info-box-number"><a href="/api/documentation?token={{ credentials('SWAGGER_DOCS_TOKEN') }}" target="_blank">ورود <small><i class="fa fa-chevron-left"></i></small></a></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-gitlab"></i></span>

                    <div class="info-box-content"   >
                        <span class="info-box-text">ریپوزیتوری گیت</span>
                        <span class="info-box-text"><small class="title-secondary">سورس فرانت‌اند</small></span>
                        <span class="info-box-number"><a href="https://gitlab.com/leviathann/chamran-shahr" target="_blank">ورود <small><i class="fa fa-chevron-left"></i></small></a></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-git"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">ریپوزیتوری گیت</span>
                        <span class="info-box-text"><small class="title-secondary">سورس بک‌اند</small></span>
                        <span class="info-box-number"><a href="https://git.parscoders.com/theAmD/chamranshahr" target="_blank">ورود <small><i class="fa fa-chevron-left"></i></small></a></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-code"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">تیم چمران‌شهر</span>
                        <span class="info-box-text"><small class="title-secondary">در پست‌من</small></span>
                        <span class="info-box-number"><a href="https://chamranshahr.postman.co/" target="_blank">ورود <small><i class="fa fa-chevron-left"></i></small></a></span>
                        <span class=""><a href="https://app.getpostman.com/join-team?invite_code=07d6c358fc94a90e6e3bb1b661228452" target="_blank">درخواست عضویت</a></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>

    </div>
</div>
@endsection
