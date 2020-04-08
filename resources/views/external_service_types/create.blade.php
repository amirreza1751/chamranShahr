@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            External Service Type
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'externalServiceTypes.store']) !!}

                        @include('external_service_types.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
