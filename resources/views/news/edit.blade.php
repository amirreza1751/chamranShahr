@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            خبر
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($news, ['route' => ['news.update', $news->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}

                        @include('news.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
