@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-right">کاربران</h1>
        <h1 class="pull-left">
            <a class="btn btn-primary pull-left" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('users.create') !!}">کاربر جدید</a>
        </h1>

    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('users.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

