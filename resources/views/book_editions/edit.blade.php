@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Book Edition
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bookEdition, ['route' => ['bookEditions.update', $bookEdition->id], 'method' => 'patch']) !!}

                        @include('book_editions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection