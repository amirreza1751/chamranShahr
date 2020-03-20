@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Book Language
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bookLanguage, ['route' => ['bookLanguages.update', $bookLanguage->id], 'method' => 'patch']) !!}

                        @include('book_languages.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection