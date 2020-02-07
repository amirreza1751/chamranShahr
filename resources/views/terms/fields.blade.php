<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Unique Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unique_code', 'Unique Code:') !!}
    {!! Form::text('unique_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Term Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('term_code', 'Term Code:') !!}
    {!! Form::text('term_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Begin Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('jalalian_begin_date', 'Begin Date:') !!}
    {!! Form::date('jalalian_begin_date', null, ['class' => 'form-control','id'=>'jalalian_end_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#begin_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('jalalian_end_date', 'End Date:') !!}
    {!! Form::date('jalalian_end_date', null, ['class' => 'form-control','id'=>'jalalian_end_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#end_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('terms.index') !!}" class="btn btn-default">Cancel</a>
</div>
