@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Study Area
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($studyArea, ['route' => ['studyAreas.update', $studyArea->id], 'method' => 'patch']) !!}

                        @include('study_areas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection