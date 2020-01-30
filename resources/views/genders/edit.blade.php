@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Gender
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($gender, ['route' => ['genders.update', $gender->id], 'method' => 'patch']) !!}

                        @include('genders.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection