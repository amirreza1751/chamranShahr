@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            خبر
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-right: 20px">
                    @include('news.show_fields')
                    <a href="{!! route('news.index') !!}" class="btn btn-default">بازگشت</a>
                </div>
            </div>
        </div>
    </div>
@endsection
