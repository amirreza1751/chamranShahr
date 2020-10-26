@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Notification Sample
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'notificationSamples.store']) !!}

                        @include('notification_samples.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
