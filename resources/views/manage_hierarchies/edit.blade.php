@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Manage Hierarchy
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($manageHierarchy, ['route' => ['manageHierarchies.update', $manageHierarchy->id], 'method' => 'patch']) !!}

                        @include('manage_hierarchies.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection