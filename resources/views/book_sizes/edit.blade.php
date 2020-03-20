@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Book Size
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bookSize, ['route' => ['bookSizes.update', $bookSize->id], 'method' => 'patch']) !!}

                        @include('book_sizes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection