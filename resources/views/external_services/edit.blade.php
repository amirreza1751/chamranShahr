@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            سرویس خارجی
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($external_service, ['route' => ['externalServices.update', $external_service->id], 'method' => 'patch']) !!}

                        @include('external_services.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
