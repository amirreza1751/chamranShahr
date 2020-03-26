@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Manage Level
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($manageLevel, ['route' => ['manageLevels.update', $manageLevel->id], 'method' => 'patch']) !!}

                        @include('manage_levels.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection