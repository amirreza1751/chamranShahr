@extends('layouts.app')

@section('content')
{{--    <section class="content-header">--}}
{{--        <h1>--}}
{{--            {{ $notification->title }}--}}
{{--        </h1>--}}
{{--    </section>--}}
    <div class="content">
        @include('notifications.profile')
{{--        <div class="box box-primary">--}}
{{--            <div class="box-body">--}}
{{--                <div class="row" style="padding-right: 20px">--}}
{{--                    @include('notifications.show_fields')--}}
{{--                    <a href="{!! URL::previous() !!}" class="btn btn-default">بازگشت</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
