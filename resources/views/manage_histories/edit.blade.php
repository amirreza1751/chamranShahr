@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Manage History
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($manage_history, ['route' => ['manageHistories.update', $manage_history->id], 'method' => 'patch']) !!}

                        @include('manage_histories.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
