@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Ad Type
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($adType, ['route' => ['adTypes.update', $adType->id], 'method' => 'patch']) !!}

                        @include('ad_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection