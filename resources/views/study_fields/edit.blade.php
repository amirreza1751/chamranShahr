@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Study Field
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($studyField, ['route' => ['studyFields.update', $studyField->id], 'method' => 'patch']) !!}

                        @include('study_fields.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection