@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @if (empty(Auth::user()->avatar_path))
            <a href="{{ route('profile') }}">
                <div class="callout-rtl callout-info">
                    <h4>تکمیل پروفایل</h4>

                    <p>لطفا تصویر شخصی انتخاب کنید و در صورت لزوم نام و نام خانوادگی خود را اصلاح نمایید.</p>
                </div>
            </a>
        @endif
        @foreach($departments as $department)
            @if (empty($department->path) || empty($department->description))
                <a href="{{ route('departments.profile', ['id' => $department->id]) }}">
                    <div class="callout-rtl callout-warning">
                        <h4>تکمیل دپارتمان {{ $department->title }}</h4>

                        <p>لطفا تصویر و توضیحات مناسب برای دپارتمان انتخاب کنید و در صورت لزوم نام آن را اصلاح فرمایید.</p>
                    </div>
                </a>
            @endif
        @endforeach
        @if ($externalServicesCount == 0)
            <a href="{{ route('externalServices.index') }}">
                <div class="callout-rtl callout-success">
                    <h4>ایجاد سرویس خارجی</h4>

                    <p>برای فعالسازی امکان بارگذاری خودکار اطلاعیه‌ها و خبرهای دپارتمان‌های خود متناسب با هرکدام سرویس خارجی ایجاد کنید.</p>
                </div>
            </a>
        @endif
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ sizeof($departments) }}</h3>

                        <p>دپارتمان‌ها</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-building" style="font-size: 8.5rem; z-index: -1"></i>
                    </div>
                    <a href="{{ route('departments.index') }}" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> بیشتر
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $externalServicesCount }}</h3>
{{--                        <sup style="font-size: 20px">%</sup>--}}

                        <p>سرویس‌های خارجی</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-rss" style="font-size: 8.5rem"></i>
                    </div>
                    <a href="{{ route('externalServices.index') }}" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> بیشتر
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $newsCount }}</h3>

                        <p>اخبار</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-newspaper-o" style="font-size: 8.5rem"></i>
                    </div>
                    <a href="{{ route('news.index') }}" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> بیشتر
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $noticesCount }}</h3>

                        <p>اطلاعیه‌ها</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sticky-note" style="font-size: 8.5rem"></i>
                    </div>
                    <a href="{{ route('notices.index') }}" class="small-box-footer">
                        <i class="fa fa-arrow-circle-right"></i> بیشتر
                    </a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div>
</div>
@endsection
