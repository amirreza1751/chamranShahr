@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Study Status
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($studyStatus, ['route' => ['studyStatuses.update', $studyStatus->id], 'method' => 'patch']) !!}

                        @include('study_statuses.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection