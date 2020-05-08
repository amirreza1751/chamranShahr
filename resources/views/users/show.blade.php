@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            کاربر
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-right: 20px">
                    <div class="mar2rem">
                        @include('users.show_fields')
                        <a href="{!! route('users.index') !!}" class="btn btn-default">بازگشت</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
